<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\post;
use App\Lang;
use App\View;
use DB;
use Carbon\Carbon;

class dashbordController extends Controller
{

    // this function is to choose a language in index
    public function choiceLang($language){
        $choiceLang= app()->setLocale($language);
        return view('index',compact('choiceLang', 'language')); 
    }
    
     // this function is to redirect to take the question from db and show it in the dashbord
    public function dashbord($language){
        $langs = DB::table('langs')->get();
        session(['language' => "$language"]);
        $choiseLang= app()->setLocale($language);
        return view('dashbord.dashbord',compact('langs','language'));   
    }

   // this function is to choose a language in dashbord
   public function choiceLangDashbord($language){
    $choiseLang= app()->setLocale($language);
    return view('dashbord.dashbord',compact('choiseLang', 'language')); 
    }
    
    // this function is to redirect to page addQuetion 
    public function  add(){
        $choiseLang= app()->setLocale(session('language'));
        return view('dashbord.addQuestion',compact('choiseLang'));
    }

    // this function is to add a question in db 
    public function addQuestion(Request $request){  
        $this->validate($request,
        [
            'français'=>'required',
            'anglais'=>'required',
            'arab'=>'required'
        ],
        // the message will returne if the input empty
        [
            'français.required' =>'Vous devez remplir le champ Français',
            'anglais.required' =>'You must fill in the Anglais field',
            'arab.required' =>'يجب عليك ملئ حقل العربية',   
        ]
        );
         // the word Lang is the name of the model
        $add=new Lang;
        $add->fr=$request->français;
        $add->en=$request->anglais;
        $add->ar=$request->arab;
        $add->save();
        $choiseLang= app()->setLocale(session('language'));
        return redirect()->back()->with('message', 'A question has been added')->with('choiseLang');
    }

    // the var id must be like the var in the page delete (dashbord/{{$user->id}}/delete)
    // this function is to delete a quetion from db 
    public function delete(Lang $id){
        $id->delete();
        return back(); 
    }

    // this function is to redirect to page to update question 
    public function edit(Lang $id){
        $choiseLang= app()->setLocale(session('language'));
        return view('/dashbord.edite',compact('id','choiseLang')); 
    }

    // this function is to update the question from db
    public function update(Request $request, Lang $id){ 
        $this->validate($request,
        [  
            'français'=>'required',
            'anglais' =>'required',
            'arab'    =>'required'
        ]);  
        $id->update([
            'fr' => $request->français,
            'en' => $request->anglais,
            'ar' => $request->arab,
        ]);
        return redirect()->back()->with('message', 'Your question has been updated');
    }

  // this function is to select the question from dashbord
    public function select(Request $request, Lang $id){
      $request->session()->put('selectQuestion',$request->input('selectQuestion') ); 
        return redirect('/dashbord');  
    }    

    public function analysis(Request $request){
        $allResult = session('allResult') ? session('allResult') : $request->input('allResult');
        $startDate =  $request->input('startDate') ? $request->input('startDate') : session('startDate');
        $endDate = $request->input('endDate') ? $request->input('endDate') : session('endDate');
       
        if (!isset($allResult) && isset($startDate) && isset($endDate)) {
            $Satisfied=0;
            $LittleSatisfied=0;
            $Unsatisfied=0;
            
            $totalSatisfied=0;
            $totalLittleSatisfied=0;
            $totalUnsatisfied=0;

            $Satisfieds=0;
            $LittleSatisfieds=0;
            $Unsatisfieds=0;
            
            $numbreViews= DB::table('views')->whereBetween('created_at', ["$startDate", "$endDate"])->paginate(30);
            $numbres= DB::table('views')->whereBetween('created_at', ["$startDate", "$endDate"])->get();
            $views= DB::table('views')->paginate(30);
            session(['allResult', null]);
            session(['startDate' => $startDate]);
            session(['endDate' => $endDate]);
        } else {
            $Satisfied=0;
            $LittleSatisfied=0;
            $Unsatisfied=0;
            
            $totalSatisfied=0;
            $totalLittleSatisfied=0;
            $totalUnsatisfied=0;

            $Satisfieds=0;
            $LittleSatisfieds=0;
            $Unsatisfieds=0;

            $numbreViews= DB::table('views')->paginate(30);
            $numbres= DB::table('views')->get();
            $views= DB::table('views')->paginate(30); 
            session(['allResult', true]);
            session(['startDate' => null]);
            session(['endDate' => null]);
            $startDate = null;
            $endDate = null;
          }

         // this function to take the result from db 
        foreach($numbreViews as $numbreView){
            $Satisfied+=($numbreView->Satisfied);
        }

        foreach($numbreViews as $numbreView){
            $LittleSatisfied+=($numbreView->LittleSatisfied);
        }

        foreach($numbreViews as $numbreView){
            $Unsatisfied+=($numbreView->Unsatisfied);
        }


        foreach($numbres as $numbre){
            $totalSatisfied+=($numbre->Satisfied);
        }

        foreach($numbres as $numbre){
            $totalLittleSatisfied+=($numbre->LittleSatisfied);
        }

        foreach($numbres as $numbre){
            $totalUnsatisfied+=($numbre->Unsatisfied);
        }


        foreach($views as $view){
            $Satisfieds+=($view->Satisfied);
            if($totalSatisfied===0){
                $Satisfieds=0;
            }
        }
        
        foreach($views as $view){
            $LittleSatisfieds+=($view->LittleSatisfied);
            if($totalLittleSatisfied===0){
                $LittleSatisfieds=0;
            }
        }

        foreach($views as $view){
            $Unsatisfieds+=($view->Unsatisfied);
            if($totalUnsatisfied===0){
                $Unsatisfieds=0;
            }
        }
        
        //  we use the function numbre format just to set 2 numbre after interval
        $total=$totalSatisfied + $totalLittleSatisfied + $totalUnsatisfied;
        $ValueSatisfied= $total > 0 ? number_format(($totalSatisfied*100) / $total, 2, '.', '') : 0;
        $ValueLittleSatisfied= $total > 0 ? number_format(($totalLittleSatisfied*100) / $total, 2, '.', '') : 0;
        $ValueUnsatisfied= $total > 0 ? number_format(($totalUnsatisfied*100) / $total, 2, '.', '') : 0;
        $choiseLang= app()->setLocale(session('language'));
        return view('dashbord.analysis',compact('choiseLang','numbreViews','startDate','endDate','views','ValueSatisfied', 'ValueLittleSatisfied','ValueUnsatisfied','Satisfied','LittleSatisfied','Unsatisfied','totalSatisfied','totalLittleSatisfied','totalUnsatisfied','Satisfieds','LittleSatisfieds','Unsatisfieds'));  
    }

    public function insertSatisfied(){
        DB::table('views')->insert(
            ['Satisfied' => 1]
        );
        $alert='good';
          return redirect('/index');
    } 

    public function insertALittleSatisfied(){
        DB::table('views')->insert(
            ['LittleSatisfied' => 1]
        );
        return redirect('/index');  
    }
    public function insertUnsatisfied(){
        DB::table('views')->insert(
            ['Unsatisfied' => 1]
        );
        return redirect('/index');  
    }

}
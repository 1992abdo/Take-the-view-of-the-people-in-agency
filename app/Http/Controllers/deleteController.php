<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class deleteController extends Controller
{
    public function destroy($id){
        $blog = Blog::findOrFail($id);

        $blog->delete();

        return redirect('/nieuws');
    }
}
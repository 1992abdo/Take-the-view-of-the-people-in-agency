function arc_wrapper() {
	
	function buildArc(angleInPercent, arcID) {
		var radius = 160;
		var center = { x: 200, y: 200 };
		function percentToDegree(angleInPercent) {
			if (angleInPercent < 0.1) angleInDegrees = 0.36;
			else if (angleInPercent > 99.9) angleInDegrees = 359.64;
			else angleInDegrees = 360 * angleInPercent / 100;
			return angleInDegrees;
		}
		function polarToCartesian(centerX, centerY, radius, angleInDegrees) {
			var angleInRadians = (angleInDegrees - 90) * Math.PI / 180.0;
			return {
				x: centerX + (radius * Math.cos(angleInRadians)),
				y: centerY + (radius * Math.sin(angleInRadians))
			};
		}
		if (arcID == 4) {
			if (angleInPercent < 5) {
				var angleInDegrees = percentToDegree(angleInPercent);
				var start = { x: center.x, y: center.y - radius };
				var end = polarToCartesian(center.x,center.x,radius,angleInDegrees);
				var forceCurve = 0;
				if (angleInDegrees > 180) forceCurve = 1;
				return "M "+end.x+" "+end.y+" A"+radius+" "+radius+" "+0+" "+forceCurve+" "+0+" "+start.x+" "+start.y;
			}
			return "";
		} else {
			if (arcID == 2) angleInPercent = Math.min(50,angleInPercent);
			else if (arcID == 3) angleInPercent = Math.min(25,angleInPercent);
			var angleInDegrees = percentToDegree(angleInPercent);
			var start = { x: center.x, y: center.y - radius };
			var end = polarToCartesian(center.x,center.x,radius,angleInDegrees);
			var forceCurve = 0;
			if (angleInDegrees > 180) forceCurve = 1;
			return "M "+end.x+" "+end.y+" A"+radius+" "+radius+" "+0+" "+forceCurve+" "+0+" "+start.x+" "+start.y;
		}
	}

	function calcCoverArcOpacity(angleInPercent) {
		if (angleInPercent >= 0 && angleInPercent < 5) {
			return 1 - (angleInPercent / 5);
		}
		return 0;
	}

	function animateArc(arc,angleInPercent,animation_steps,animation_duration) {
		// Note: more steps make the animation smoother, but also much more complicated
		if ( animation_steps == "" || animation_steps == 0 ) animation_steps = 200;
		if ( animation_duration == "" ) animation_duration = 1000;
		var animation_stepduration = animation_duration / animation_steps;
		var animation_stepsize = angleInPercent / animation_steps;
		function animateArcStep(arc,step_angleInPercent) {
			arc.querySelector(".arc-svg path:nth-of-type(1)").setAttribute("d", buildArc(step_angleInPercent,1));
			arc.querySelector(".arc-svg path:nth-of-type(2)").setAttribute("d", buildArc(step_angleInPercent,2));
			arc.querySelector(".arc-svg path:nth-of-type(3)").setAttribute("d", buildArc(step_angleInPercent,3));
			arc.querySelector(".arc-svg path:nth-of-type(4)").setAttribute("d", buildArc(step_angleInPercent,4));
			arc.querySelector(".arc-svg path:nth-of-type(4)").setAttribute("stroke-opacity", calcCoverArcOpacity(step_angleInPercent));
			if ( (step_angleInPercent + animation_stepsize) < angleInPercent ) {
				setTimeout(function(){ animateArcStep(arc,step_angleInPercent + animation_stepsize) }, animation_stepduration);
			} else {
				setTimeout(function(){ animateArcStep(arc,angleInPercent) }, animation_stepduration);
			}
		}
		animateArcStep(arc,0);
	}

	function arc_main(arc) {
		// Get the colors:
		var colors_str = arc.getAttribute("data-arc-color");
		if (arc.getAttribute("data-arc-color") == null) colors_str = "#0062FF #1AD7FD #DDDDDD #0088FF"; // gradient-start-color gradient-end-color base-circle-color text-color
		var colors = colors_str.split(" ");
		if (colors.length == 1) {
			colors[1] = colors[0];
			colors[2] = "#DDDDDD";
			colors[3] = (colors[0] == "#0062FF") ? "#0088FF" : colors[0];
			colors[4] = colors[2];
		} else if (colors.length == 2) {
			colors[2] = "#DDDDDD";
			colors[3] = (colors[0] == "#0062FF") ? "#0088FF" : colors[0];
			colors[4] = colors[2];
		} else if (colors.length == 3) {
			colors[3] = (colors[0] == "#0062FF") ? "#0088FF" : colors[0];
			colors[4] = colors[2];
		} else if (colors.length == 4) {
			colors[4] = colors[2];
		}
		if (colors[0] == "init") colors[0] = "#0062FF";
		if (colors[1] == "init") colors[1] = "#1AD7FD";
		if (colors[2] == "init") colors[2] = "#DDDDDD";
		if (colors[3] == "init") colors[3] = (colors[0] == "#0062FF") ? "#0088FF" : colors[0];
		if (colors[4] == "init") colors[4] = colors[2];
		
		function getHalfColor(color1,color2) {
			// takes hex colors with or without a leading # as input
			if (color1.substr(0,1) == "#") color1 = color1.substring(1);
			if (color2.substr(0,1) == "#") color2 = color2.substring(1);
			var hex = function(x) {
				x = x.toString(16);
				return (x.length == 1) ? '0' + x : x;
			};
			var r = Math.ceil(parseInt(color1.substring(0,2), 16) * 0.5 + parseInt(color2.substring(0,2), 16) * 0.5);
			var g = Math.ceil(parseInt(color1.substring(2,4), 16) * 0.5 + parseInt(color2.substring(2,4), 16) * 0.5);
			var b = Math.ceil(parseInt(color1.substring(4,6), 16) * 0.5 + parseInt(color2.substring(4,6), 16) * 0.5);
			return hex(r) + hex(g) + hex(b);
		}
		
		var half_color = getHalfColor(colors[0],colors[1]);
		var quarter_color = getHalfColor(colors[0],half_color);
		// Add some style:
		arc.style.position = "relative";
		arc.style.display = "inline-block";
		if (arc.getAttribute("data-arc-d") == null) arc.setAttribute("data-arc-d", "315px"); // Standard width
		arc.style.width = arc.getAttribute("data-arc-d");
		arc.style.height = arc.getAttribute("data-arc-d");
		arc.style.color = colors[3];
		if (arc.getAttribute("data-arc-fontsize") !== null) {
			arc.style.fontSize = arc.getAttribute("data-arc-fontsize");
		} else {
			// Make the font-size responsive to the arc-size:
			arc.style.fontSize = parseInt(arc.style.width) / 4.5 + "px";
		}

		// Get the stroke-width:
		var arc_width = 25;
		var circle_width = 10;
		if (arc.getAttribute("data-arc-arcwidth") !== null) arc_width = arc.getAttribute("data-arc-arcwidth");
		if (arc.getAttribute("data-arc-circlewidth") !== null) circle_width = arc.getAttribute("data-arc-circlewidth");
		// If data-arc-stepped is set, use a different circle:
		if (arc.getAttribute("data-arc-stepped") !== null) {
			arc_width = Math.max(arc_width, 30);
			circle_width = 0;
			var circle_string = 
				'<g class="arc_stepped_circle" fill="' + colors[2] + '" stroke="none">' +
					'<path d="M209,45.3c11,0.6,21.6,2.4,31.8,5.2c-0.5-1.8-0.5-3.7,0-5.4c0.5-1.6,1.5-3.1,2.8-4.2 c-11.1-3.1-22.8-5-34.7-5.6L209,45.3L209,45.3z"/>' +
					'<path d="M298.2,80.2c8.3,6.8,16,14.6,22.7,23c0.6-1.8,1.7-3.4,3.3-4.5c1.4-1,3-1.6,4.6-1.7 c-7.3-9.2-15.6-17.5-24.7-24.9L298.2,80.2z"/>' +
					'<path d="M258.1,45.6c0.4,1.6,0.4,3.4-0.1,5c-0.6,1.8-1.7,3.3-3.2,4.4c10.2,3.9,19.8,8.7,28.8,14.5l5.9-8.1 C279.7,55.1,269.2,49.8,258.1,45.6z"/>' +
					'<path d="M110.5,61.5l5.9,8.1c9-5.8,18.7-10.7,28.8-14.5c-1.5-1.1-2.6-2.6-3.2-4.4c-0.5-1.6-0.6-3.4-0.2-5 C130.8,49.8,120.3,55.1,110.5,61.5z"/>' +
					'<path d="M344.4,143.6l9.5-3.1c-4.3-11-9.7-21.5-16.1-31.2c-0.6,1.5-1.7,2.9-3,3.9c-1.5,1.1-3.4,1.7-5.2,1.7 C335.4,123.9,340.4,133.5,344.4,143.6z"/>' +
					'<path d="M360,209c-1.9,0-3.7-0.6-5.2-1.7c-0.5,11-2.2,21.6-4.9,31.9l9.5,3.1c3-11.2,4.8-22.8,5.3-34.8 C363.4,208.5,361.7,209,360,209z"/>' +
					'<path d="M141.8,354.4c-0.4-1.6-0.4-3.4,0.2-5c0.6-1.8,1.7-3.3,3.2-4.4c-10.2-3.9-19.8-8.7-28.8-14.5l-5.9,8.1 C120.3,344.9,130.8,350.2,141.8,354.4z"/>' +
					'<path d="M344.4,256.4c-4,10.1-9,19.7-14.9,28.7c1.9,0,3.7,0.6,5.2,1.7c1.4,1,2.4,2.4,3,3.9 c6.4-9.7,11.9-20.2,16.1-31.2L344.4,256.4z"/>' +
					'<path d="M354.8,192.6c1.5-1.1,3.3-1.6,5.2-1.6c1.7,0,3.4,0.5,4.8,1.4c-0.5-12-2.4-23.6-5.3-34.7l-9.5,3.1 C352.6,171,354.3,181.7,354.8,192.6z"/>' +
					'<path d="M159.1,45c0.6,1.8,0.6,3.7,0,5.4c10.2-2.8,20.9-4.6,31.8-5.2v-10c-12,0.6-23.6,2.6-34.7,5.6 C157.6,42,158.6,43.4,159.1,45z"/>' +
					'<path d="M55.6,143.6c4-10.1,9-19.7,14.9-28.7c-1.9,0-3.7-0.6-5.2-1.7c-1.4-1-2.4-2.4-3-3.9 c-6.4,9.7-11.8,20.2-16.1,31.2L55.6,143.6z"/>' +
					'<path d="M40,191c1.9,0,3.7,0.6,5.2,1.7c0.5-11,2.2-21.6,4.9-31.9l-9.5-3.1c-3,11.2-4.8,22.8-5.3,34.7 C36.6,191.5,38.3,191,40,191z"/>' +
					'<path d="M45.2,207.3c-1.5,1.1-3.3,1.7-5.2,1.7c-1.7,0-3.4-0.5-4.8-1.4c0.5,12,2.4,23.6,5.3,34.8l9.5-3.1 C47.4,229,45.7,218.3,45.2,207.3z"/>' +
					'<path d="M324.2,301.3c-1.5-1.1-2.7-2.7-3.3-4.5c-6.8,8.4-14.4,16.1-22.7,23l5.9,8.1c9.1-7.4,17.4-15.8,24.7-24.9 C327.1,302.9,325.5,302.3,324.2,301.3z"/>' +
					'<path d="M191,354.7c-11-0.6-21.6-2.4-31.9-5.2c0.5,1.8,0.5,3.7,0,5.4c-0.5,1.6-1.5,3.1-2.8,4.2 c11.2,3.1,22.8,5,34.7,5.6V354.7z"/>' +
					'<path d="M101.8,319.8c-8.3-6.9-16-14.6-22.7-23c-0.6,1.8-1.7,3.4-3.2,4.5c-1.4,1-3,1.6-4.6,1.7 c7.3,9.2,15.6,17.5,24.7,24.9L101.8,319.8z"/>' +
					'<path d="M55.6,256.4l-9.5,3.1c4.3,11,9.7,21.5,16.1,31.2c0.6-1.5,1.7-2.9,3-3.9c1.5-1.1,3.4-1.7,5.2-1.7 C64.6,276.1,59.6,266.5,55.6,256.4z"/>' +
					'<path d="M240.9,355c-0.6-1.8-0.6-3.7,0-5.4c-10.2,2.8-20.9,4.6-31.9,5.2v10c12-0.6,23.6-2.6,34.7-5.6 C242.4,358,241.4,356.6,240.9,355z"/>' +
					'<path d="M289.5,338.5l-5.9-8.1c-9,5.8-18.7,10.7-28.8,14.5c1.5,1.1,2.6,2.7,3.2,4.4c0.5,1.6,0.6,3.4,0.2,5 C269.2,350.2,279.7,344.9,289.5,338.5z"/>' +
					'<path d="M75.8,98.7c1.5,1.1,2.7,2.7,3.2,4.5c6.8-8.4,14.4-16.1,22.7-23l-5.9-8.1C86.7,79.5,78.4,87.9,71.1,97 C72.9,97.1,74.5,97.7,75.8,98.7z"/>' +
				'</g>' +
				'<g class="arc_stepped_ten-stops" fill="' + colors[4] + '" stroke="none">' +
					'<path d="M200,55c-2.8,0-5-2.2-5-5V30c0-2.8,2.2-5,5-5c2.8,0,5,2.2,5,5v20C205,52.8,202.8,55,200,55z"/>' +
					'<path d="M200,375c-2.8,0-5-2.2-5-5v-20c0-2.8,2.2-5,5-5c2.8,0,5,2.2,5,5v20C205,372.8,202.8,375,200,375z"/>' +
					'<path d="M111.8,83.6c-1.5,0-3.1-0.7-4-2.1L96.1,65.4c-1.6-2.2-1.1-5.4,1.1-7c2.2-1.6,5.4-1.1,7,1.1l11.7,16.1 c1.6,2.2,1.1,5.4-1.1,7C113.9,83.3,112.8,83.6,111.8,83.6z"/>' +
					'<path d="M299.9,342.5c-1.6,0-3.1-0.7-4.1-2.1l-11.7-16.2c-1.6-2.2-1.1-5.4,1.1-7c2.2-1.6,5.4-1.1,7,1.1l11.7,16.2 c1.6,2.2,1.1,5.4-1.1,7C301.9,342.2,300.9,342.5,299.9,342.5z"/>' +
					'<path d="M57.3,158.6c-0.5,0-1-0.1-1.5-0.2l-19-6.1c-2.6-0.8-4.1-3.7-3.2-6.3c0.8-2.6,3.7-4.1,6.3-3.2l19,6.1 c2.6,0.8,4.1,3.7,3.2,6.3C61.4,157.2,59.4,158.6,57.3,158.6z"/>' +
					'<path d="M361.7,257.5c-0.5,0-1-0.1-1.6-0.2l-19-6.2c-2.6-0.9-4.1-3.7-3.2-6.3c0.9-2.6,3.7-4.1,6.3-3.2l19,6.2 c2.6,0.9,4.1,3.7,3.2,6.3C365.8,256.2,363.8,257.5,361.7,257.5z"/>' +
					'<path d="M288.2,83.6c-1,0-2-0.3-2.9-1c-2.2-1.6-2.7-4.8-1.1-7l11.7-16.1c1.6-2.2,4.8-2.7,7-1.1 c2.2,1.6,2.7,4.8,1.1,7l-11.7,16.1C291.3,82.9,289.7,83.6,288.2,83.6z"/>' +
					'<path d="M100.1,342.5c-1,0-2-0.3-2.9-0.9c-2.2-1.6-2.7-4.7-1.1-7l11.7-16.2c1.6-2.2,4.7-2.7,7-1.1 c2.2,1.6,2.7,4.7,1.1,7l-11.7,16.2C103.2,341.8,101.6,342.5,100.1,342.5z"/>' +
					'<path d="M342.7,158.6c-2.1,0-4.1-1.4-4.8-3.5c-0.8-2.6,0.6-5.4,3.2-6.3l19-6.1c2.6-0.8,5.4,0.6,6.3,3.2 c0.8,2.6-0.6,5.4-3.2,6.3l-19,6.1C343.7,158.5,343.2,158.6,342.7,158.6z"/>' +
					'<path d="M38.3,257.5c-2.1,0-4.1-1.4-4.8-3.5c-0.8-2.6,0.6-5.4,3.2-6.3l19-6.1c2.6-0.8,5.4,0.6,6.3,3.2 c0.8,2.6-0.6,5.4-3.2,6.3l-19,6.1C39.3,257.4,38.8,257.5,38.3,257.5z"/>' +
				'</g>' +
				'<g class="arc_stepped_five-stops" fill="' + colors[4] + '" stroke="none">' +
					'<path d="M249.4,357.2c-1.3,0-2.6-0.5-3.5-1.5c-0.9-0.9-1.5-2.2-1.5-3.5c0-1.3,0.5-2.6,1.5-3.5 c0.9-0.9,2.2-1.5,3.5-1.5c1.3,0,2.6,0.5,3.5,1.5c0.9,0.9,1.5,2.2,1.5,3.5c0,1.3-0.5,2.6-1.5,3.5C252,356.7,250.7,357.2,249.4,357.2 z"/>' +
					'<path d="M150.6,52.8c-1.3,0-2.6-0.5-3.5-1.5c-0.9-0.9-1.5-2.2-1.5-3.5s0.5-2.6,1.5-3.5c0.9-0.9,2.2-1.5,3.5-1.5 c1.3,0,2.6,0.5,3.5,1.5c0.9,0.9,1.5,2.2,1.5,3.5s-0.5,2.6-1.5,3.5C153.2,52.3,151.9,52.8,150.6,52.8z"/>' +
					'<path d="M70.6,111c-1.3,0-2.6-0.5-3.5-1.5c-0.9-0.9-1.5-2.2-1.5-3.5c0-1.3,0.5-2.6,1.5-3.5c0.9-0.9,2.2-1.5,3.5-1.5 c1.3,0,2.6,0.5,3.5,1.5c0.9,0.9,1.5,2.2,1.5,3.5c0,1.3-0.5,2.6-1.5,3.5C73.2,110.5,71.9,111,70.6,111z"/>' +
					'<path d="M329.4,299c-1.3,0-2.6-0.5-3.5-1.5c-0.9-0.9-1.5-2.2-1.5-3.5c0-1.3,0.5-2.6,1.5-3.5 c0.9-0.9,2.2-1.5,3.5-1.5c1.3,0,2.6,0.5,3.5,1.5c0.9,0.9,1.5,2.2,1.5,3.5c0,1.3-0.5,2.6-1.5,3.5C332,298.5,330.7,299,329.4,299z"/>' +
					'<path d="M40,205c-1.3,0-2.6-0.5-3.5-1.5c-0.9-0.9-1.5-2.2-1.5-3.5c0-1.3,0.5-2.6,1.5-3.5c0.9-0.9,2.2-1.5,3.5-1.5 c1.3,0,2.6,0.5,3.5,1.5c0.9,0.9,1.5,2.2,1.5,3.5c0,1.3-0.5,2.6-1.5,3.5C42.6,204.5,41.3,205,40,205z"/>' +
					'<path d="M360,205c-1.3,0-2.6-0.5-3.5-1.5c-0.9-0.9-1.5-2.2-1.5-3.5c0-1.3,0.5-2.6,1.5-3.5c0.9-0.9,2.2-1.5,3.5-1.5 c1.3,0,2.6,0.5,3.5,1.5c0.9,0.9,1.5,2.2,1.5,3.5c0,1.3-0.5,2.6-1.5,3.5C362.6,204.5,361.3,205,360,205z"/>' +
					'<path d="M70.6,299c-1.3,0-2.6-0.5-3.5-1.5c-0.9-0.9-1.5-2.2-1.5-3.5c0-1.3,0.5-2.6,1.5-3.5c0.9-0.9,2.2-1.5,3.5-1.5 c1.3,0,2.6,0.5,3.5,1.5c0.9,0.9,1.5,2.2,1.5,3.5c0,1.3-0.5,2.6-1.5,3.5C73.2,298.5,71.9,299,70.6,299z"/>' +
					'<path d="M329.4,110.9c-1.3,0-2.6-0.5-3.5-1.5c-0.9-0.9-1.5-2.2-1.5-3.5c0-1.3,0.5-2.6,1.5-3.5 c0.9-0.9,2.2-1.5,3.5-1.5c1.3,0,2.6,0.5,3.5,1.5c0.9,0.9,1.5,2.2,1.5,3.5c0,1.3-0.5,2.6-1.5,3.5C332,110.4,330.7,110.9,329.4,110.9 z"/>' +
					'<path d="M150.6,357.2c-1.3,0-2.6-0.5-3.5-1.5c-0.9-0.9-1.5-2.2-1.5-3.5c0-1.3,0.5-2.6,1.5-3.5 c0.9-0.9,2.2-1.5,3.5-1.5c1.3,0,2.6,0.5,3.5,1.5c0.9,0.9,1.5,2.2,1.5,3.5c0,1.3-0.5,2.6-1.5,3.5 C153.2,356.7,151.9,357.2,150.6,357.2z"/>' +
					'<path d="M249.4,52.8c-1.3,0-2.6-0.5-3.5-1.5c-0.9-0.9-1.5-2.2-1.5-3.5s0.5-2.6,1.5-3.5c0.9-0.9,2.2-1.5,3.5-1.5 c1.3,0,2.6,0.5,3.5,1.5c0.9,0.9,1.5,2.2,1.5,3.5s-0.5,2.6-1.5,3.5C252,52.3,250.7,52.8,249.4,52.8z"/>' +
				'</g>';
		} else {
			var circle_string = '<circle stroke-width="' + circle_width + '" fill="none" stroke="' + colors[2] + '" cx="200" cy="200" r="160"/>';
		}
		// Create the svg arc:
		var randomID1 = Math.random().toString(36).substr(2, 20);
		var randomID2 = Math.random().toString(36).substr(2, 20);
		var randomID3 = Math.random().toString(36).substr(2, 20);
		arc.innerHTML =
			'<svg class="arc-svg" width="100%" height="100%" viewBox="0 0 400 400" version="1.1" xmlns="http://www.w3.org/2000/svg">' +
				'<defs>' +
					'<linearGradient id="grad_' + randomID1 + '" x1="0%" y1="0%" x2="100%" y2="0%">' +
						'<stop offset="0%" style="stop-color:' + colors[0] + ';stop-opacity:1" />' +
						'<stop offset="100%" style="stop-color:#' + quarter_color + ';stop-opacity:1" />' +
					'</linearGradient>' +
					'<linearGradient id="grad_' + randomID2 + '" x1="100%" y1="0%" x2="0%" y2="0%">' +
						'<stop offset="0%" style="stop-color:#' + quarter_color + ';stop-opacity:1" />' +
						'<stop offset="100%" style="stop-color:#' + half_color + ';stop-opacity:1" />' +
					'</linearGradient>' +
					'<linearGradient id="grad_' + randomID3 + '" x1="0%" y1="100%" x2="0%" y2="0%">' +
						'<stop offset="0%" style="stop-color:#' + half_color + ';stop-opacity:1" />' +
						'<stop offset="100%" style="stop-color:' + colors[1] + ';stop-opacity:1" />' +
					'</linearGradient>' +
				'</defs>' +
				circle_string +
				'<path stroke-width="' + arc_width + '" fill="none" stroke="url(#grad_' + randomID3 + ')" stroke-linecap="round"/>' +
				'<path stroke-width="' + arc_width + '" fill="none" stroke="url(#grad_' + randomID2 + ')" stroke-linecap="round"/>' +
				'<path stroke-width="' + arc_width + '" fill="none" stroke="url(#grad_' + randomID1 + ')" stroke-linecap="round"/>' +
				'<path stroke-width="' + arc_width + '" fill="none" stroke="' + colors[0] + '" stroke-linecap="round"/>' +
			'</svg>';
	// Get the angle of the arc:
	var angleInPercent = arc.getAttribute("data-arc");
	// Animate the arc if data-arc-anim is set:
	if (arc.getAttribute("data-arc-anim") !== null) {
		var animation_parameters = arc.getAttribute("data-arc-anim").split(" ");
		var animation_steps = (animation_parameters.length > 0 && parseInt(animation_parameters[0]) > 0) ? parseInt(animation_parameters[0]) : '';
		var animation_duration = (animation_parameters.length > 1 && parseInt(animation_parameters[1]) > 0) ? parseInt(animation_parameters[1]) : '';
		animateArc(arc,angleInPercent,animation_steps,animation_duration);
	} else {
		arc.querySelector(".arc-svg > path:nth-of-type(1)").setAttribute("d", buildArc(angleInPercent,1));
		arc.querySelector(".arc-svg > path:nth-of-type(2)").setAttribute("d", buildArc(angleInPercent,2));
		arc.querySelector(".arc-svg > path:nth-of-type(3)").setAttribute("d", buildArc(angleInPercent,3));
		arc.querySelector(".arc-svg > path:nth-of-type(4)").setAttribute("d", buildArc(angleInPercent,4));
		arc.querySelector(".arc-svg > path:nth-of-type(4)").setAttribute("stroke-opacity", calcCoverArcOpacity(angleInPercent));
	}
}

	// Create the style for the ::before-element:
	var arc_style = document.createElement('div');
	arc_style.innerHTML = 
		'<style>' +
			'svg-arc[data-arc-desc]::before {' +
				'content: attr(data-arc-desc);' +
				'position: absolute;' +
				'display: block;' +
				'width: 70%;' +
				'text-align: center;' +
				'font-size: 50%;' +
				'opacity: 0.6;' +
				'left: 50%;' +
				'bottom: 53%;' +
				'transform: translateX(-50%);' +
			'}' +
			'svg-arc[data-arc-desc][data-arc-descwidth="90"]::before { width: 90%; }' +
			'svg-arc[data-arc-desc][data-arc-descwidth="80"]::before { width: 80%; }' +
			'svg-arc[data-arc-desc][data-arc-descwidth="70"]::before { width: 70%; }' +
			'svg-arc[data-arc-desc][data-arc-descwidth="60"]::before { width: 60%; }' +
			'svg-arc[data-arc-desc][data-arc-descwidth="50"]::before { width: 50%; }' +
			'svg-arc[data-arc-desc][data-arc-descwidth="40"]::before { width: 40%; }' +
			'svg-arc[data-arc-desc][data-arc-descwidth="30"]::before { width: 30%; }' +
			'svg-arc[data-arc-desc][data-arc-descwidth="20"]::before { width: 20%; }' +
			'svg-arc[data-arc-desc][data-arc-descwidth="10"]::before { width: 10%; }' +
			'svg-arc[data-arc-desc][data-arc-nopercent]::before {' +
				'bottom: 50%;' +
				'transform: translate(-50%,50%);' +
			'}' +
			'svg-arc::after {' +
				'content: attr(data-arc) "%";' +
				'position: absolute;' +
				'display: block;' +
				'width: 100%;' +
				'text-align: center;' +
				'top: 50%;' +
				'transform: translateY(-50%);' +
			'}' +
			'svg-arc[data-arc-desc]::after {' +
				'transform: translateY(-20%);' +
			'}' +
			'svg-arc[data-arc-nopercent]::after {' +
				'content: unset;' +
				'display: none;' +
			'}' +
		'</style>';
	// document.body.insertBefore(arc_style, document.body.firstChild);
	document.getElementsByTagName('head')[0].appendChild(arc_style);

	try {
		var svgArcProto = Object.create(HTMLElement.prototype);
		svgArcProto.createdCallback = function() {
			arc_main(this);
		}
		document.registerElement("svg-arc", {prototype: svgArcProto});
	} catch (err) {
		console.log("Oh no! It looks like your browser doesn't supports custom elements :( (but don't worry, the arcs diagrams also work the old fashioned way)");
		// Well, guess we also have to do this the old-fashioned way...
		document.querySelectorAll("svg-arc").forEach(function(arc){
			arc_main(arc);
		});
	}
}

arc_wrapper();
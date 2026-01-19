function selectrealtime(val){
	var div = document.getElementById("free_courses");
	div.style.display = val == 0 ? "block" : "none";	
}

function guruChangeBcolor(id, color){
	if(id == "pick_notdonecolor"){
		document.getElementById('timetest').style.color = "#"+color;
	}
	else if(id == "pick_txtcolor"){
		document.getElementById('timeleft').style.color = "#"+color;
	}
	else if(id == "pick_xdonecolor"){
		document.getElementById('totalbg').style.backgroundColor = "#"+color;
		document.getElementById('divtotal').style.backgroundColor = "#"+color;
	}
	else if(id == "pick_donecolor"){
		document.getElementById('divtotal').style.borderColor = "#"+color;
		document.getElementById('timeleft').style.backgroundColor = "#"+color;
		document.getElementById('timeleft').style.borderColor = "#"+color;
	}
}

function guruchangeFont(value){
	document.getElementById('divtotal').style.fontFamily = "'"+value+"'";
}
function guruchangeSizeW(value){
	document.getElementById('divtotal').style.width = value+'px';
}
function guruchangeSizeH(value){
	document.getElementById('divtotal').style.height = value+'px';
}
function guruchangeSizeFN(value){
	document.getElementById('timetest').style.fontSize = value+'px';
}
function guruchangeSizeFW(value){
	document.getElementById('timeleft').style.fontSize = value+'px';
	document.getElementById('minsec').style.fontSize = value+'px';
	
}
function guruShowLessons(value){
	if(value == 1){
		document.getElementById('lessons_release_td').style.display = "table-row";
		document.getElementById('lessons_show_td').style.display = "table-row";
	}
	else{
		document.getElementById('lessons_release_td').style.display = "none";
		document.getElementById('lessons_show_td').style.display = "none";
	}
}
function guruPopupChangeOption(){
	alert("This change will be propagated over the way the lessons of this course will be released!");	
}

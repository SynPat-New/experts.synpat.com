<?php 
$parent = $this->parentData;
$expertArea = array();
?>
<style>
.table tbody tr td label a{ color: hsl(3, 95%, 38%) !important; padding-top: 0 !important; }
.table tbody tr td p{text-align:left !important;}
.table thead tr th p{font-weight: bold; text-align:left !important;}
.table tbody tr td label{font-size: 13px; margin:0px; line-height:normal}
.table tbody tr td{
	background:none !important; 
	border-bottom: 1px solid hsl(210, 3%, 77%);
	line-height:14px !important;
	padding: 8px 0px;
}
.table tbody tr td:last-child,
.table thead tr th:last-child {
	padding-left: 8px;
}
.table tbody tr td:first-child,
.table thead tr th:first-child {
	padding-left: 0px;
}
.table .table {
	margin-bottom: -9px;
	margin-top: -8px;
}

.table thead tr th{
	background: #ffffff;
  	border-bottom: 1px solid #DDDDDD;
	padding: 8px 0px;
}
.table thead tr th p {
  	color: #cd2122 !important;
  	font-family: 'Open Sans', Helvetica, Arial, serif;;
  	font-size: 13px;
}
.check-align {
	width: 30px !important;
}
.check-align input {
	margin-right: 5px !important;
}
.check-align + td {
	/*width: 100px !important;*/
}

td.dot{font-weight:bold; font-size:14px; color:#000; padding-left:2px !important; padding-right:2px !important; padding-top:6px !important;}
table.customTable tbody tr td{border:0px solid #fff !important;}
table.customTable tbody tr td{padding-top:0px !important; padding-bottom:0px}
.table tbody tr td.arrow{background:#3A414D url(../img/arrowTop.png) no-repeat 4px 7px !important; width:2%}
.table tbody tr td.arrow2{background:#ffffff url(../img/aow.jpg) no-repeat 4px 7px !important; width:2%}
table.table.table > tbody > tr.hover1:hover > td{ border-top:1px solid #DDDDDD !important; border-bottom:1px solid #DDDDDD !important;}

table tbody tr td.check-align{
	padding-left:10px !important;
	text-align:right !important;
}
.classitemFocus{ 
	background-color:#EFEFEF !important;
	color:#0E2034 !important;
}
span.dot{
	display:inlin-block;
	font-size:150%;
	line-height:50%;
	padding-top:0.15em;
	margin-right:3px;
}

input[type='checkbox'] {
	-webkit-font-smoothing: antialiased;
	text-rendering: optimizeSpeed;
	width: 15px;
	height: 15px;
	margin: 0;
	margin-right: 1px;
	display: block;
	float: left;
	position: relative;
	cursor: pointer;
}

input[type='checkbox']:after {
	content: "";
	vertical-align: middle;
	text-align: center;
	line-height: 15px;
	position: absolute;
	cursor: pointer;
	height: 15px;
	width: 15px;
	left: 0;
	top: 0;
	font-size: 10px;
	background: #f0f0f0;
	color: #2d2d2d;
	border:1px solid #e0e0e0;
}

/*input[type='checkbox']:hover:after, input[type='checkbox']:checked:hover:after {
	background: #5F95FC;
	content: '\2714';
	color: #fff;
}*/
input[type='checkbox']:after {
    box-shadow: none !important;
}
input[type='checkbox']:checked:after {
	background: #f0f0f0;
	content: '\2714';
	color: #111111;
	border:1px solid #e0e0e0;
}
input[type='checkbox'].light-gray:checked:after {
	background: #f0f0f0;
	content: '\2714';
	color: #999999;
	border:1px solid #e0e0e0;
}
input[type='checkbox'].light-red:checked:after {
	background: #f0f0f0;
	content: '\2714';
	color: #ff0000;
	border:1px solid #e0e0e0;
}
a:focus, a:hover{outline:0;text-decoration:none;}
.sm-width{max-width:20px !important;text-align:center;}
.disable-select, body {
    -webkit-touch-callout: none; /* iOS Safari */
    -webkit-user-select: none;   /* Chrome/Safari/Opera */
    -khtml-user-select: none;    /* Konqueror */
    -moz-user-select: none;      /* Firefox */
    -ms-user-select: none;       /* Internet Explorer/Edge */
    user-select: none;           
}
.blue50{background:#E3F2FD;color:rgba(0,0,0,.87);}
.blue100{background:#BBDEFB;color:rgba(0,0,0,.87);}
.blue200{background:#90CAF9;color:rgba(0,0,0,.87);}
.blue300{background:#64B5F6;color:rgba(0,0,0,.87);}
.blue400{background:#42A5F5;color:rgba(0,0,0,.87);}
.blue500{background:#2196F3;color:rgba(0,0,0,.87);}
.blue600{background:#1E88E5;color:rgba(255,255,255,.87);}
.blue700{background:#1976D2;color:rgba(255,255,255,.87);}
.blue800{background:#1565C0;color:rgba(255,255,255,.87);}
.blue900{background:#0D47A1;color:rgba(255,255,255,.87);}
.searchbox_1{
background-color: #fffbf8;
padding:13px;
width:335px;
margin: 100px auto;
-webkit-box-sizing:border-box;
-moz-box-sizing:border-box;
box-sizing:border-box;
border-radius:6px;
-webkit-box-shadow:
0 2px 4px 0 rgba(72, 72, 72, 0.83),
0 10px 15px 0 rgba(126, 126, 126, 0.12),
0 -2px 6px 1px rgba(199, 199, 199, 0.55) inset,
0 2px 4px 2px rgba(255, 255, 255, 0.83) inset;
-moz-box-shadow:
0 2px 4px 0 rgba(72, 72, 72, 0.83),
0 10px 15px 0 rgba(126, 126, 126, 0.12),
0 -2px 6px 1px rgba(199, 199, 199, 0.55) inset,
0 2px 4px 2px rgba(255, 255, 255, 0.83) inset;
box-shadow:
0 2px 4px 0 rgba(72, 72, 72, 0.83),
0 10px 15px 0 rgba(126, 126, 126, 0.12),
0 -2px 6px 1px rgba(199, 199, 199, 0.55) inset,
0 2px 4px 2px rgba(255, 255, 255, 0.83) inset;
}
.search_1{
width:250px;
height:30px;
padding-left:15px;
border-radius:6px;
border:none;
color:#0F0D0D;;
font-weight:500;
background-color:#E2EFF7;;
-webkit-box-shadow:
0 -2px 2px 0 rgba(199, 199, 199, 0.55),
0 1px 1px 0 #fff,
0 2px 2px 1px #fafafa,
0 2px 4px 0 #b2b2b2 inset,
0 -1px 1px 0 #f2f2f2 inset,
0 15px 15px 0 rgba(41, 41, 41, 0.09) inset;
-moz-box-shadow:
0 -2px 2px 0 rgba(199, 199, 199, 0.55),
0 1px 1px 0 #fff,
0 2px 2px 1px #fafafa,
0 2px 4px 0 #b2b2b2 inset,
0 -1px 1px 0 #f2f2f2 inset,
0 15px 15px 0 rgba(41, 41, 41, 0.09) inset;
box-shadow:
0 -2px 2px 0 rgba(199, 199, 199, 0.55),
0 1px 1px 0 #fff,
0 2px 2px 1px #fafafa,
0 2px 4px 0 #b2b2b2 inset,
0 -1px 1px 0 #f2f2f2 inset,
0 15px 15px 0 rgba(41, 41, 41, 0.09) inset;
}
.submit_1{
width:35px;
height:30px;
background-color:transparent;
border:none;
cursor:pointer;
float:right;
}
.search_1:focus{
outline:0;
}
.highlight p{color:#C20000;}
</style>

<div class="row-fluid">
	<div class="span12" style="background:#fff;">
		<a href="<?php echo JUri::base();?>component/survey/?task=customer.ipccodes" class="btn btn-medium btn-flat pull-left">Reset</a>
		<button type="button" class="submit_1" value="search" onclick="searchIPC()"><i class="icon icon-search"></i></button>
		<input type="text" name="search_ipc" id="search_ipc" placeholder="Search..." class="pull-right search_1">
		
	</div>
</div>
<div class="row-fluid">
			<div class="span12" style="background:#fff;" id="results">
					<table class="table table-striped" id="patent">						
							<thead>
								<tr style="background:#BDC2C7;">
									<th></th>
									<th class="sm-width"></th>
									<th width="94%"></th>
								</tr>
							</thead>
							<tbody>
							<?php 
								if(count($parent)>0){
									for($p=0;$p<count($parent);$p++){
										$checked='';
										$class="";
										
							?>
								<tr class="blue50">
									<td class="check-align"><input type="checkbox" <?php echo $checked;?> name="parent_checked[]" value="<?php echo $parent[$p]->id;?>" onclick="checkBoxClick(jQuery(this),0);" class="t0 <?php echo $class;?>"></td>
									<td>	
										<label class="sm-width">									
											<a href="javascript:void(0);" onclick="getChildData(jQuery(this),0)" rel="<?php echo $parent[$p]->id;?>" style="padding-top:3px; display:inline-block;">+</a>
										 </label>
									</td>
									<td class=>
										<p class="noMargin" style="margin-top:4px !important;"><?php echo $parent[$p]->classification_description;?></p>
									</td>
								</tr>
								
							<?php
									}
								}	
							?>
						</tbody>
					</table>
				</div>
			</div>
			<script>
				_siteURL = '<?php echo JUri::base();?>';
				_expertArea = [];
				_expertAreaUnSelected = [];
				_parentsList = [];
				if(_parentsList==null){
					_parentsList = [];
				} else {
					jQuery.each(_parentsList,function(i,s){
						if(jQuery.inArray(s,_expertArea)>=0){
							_parentsList.splice(i,1);
						}
					});
				}
				function checkBoxClickSelection(o){
					_type=0;
					_tabSelected = [];
					
					if(!o.is(':checked')){
						_type=1;
					}
					_findChildrens = [];
					if(_type==1){
						_pr = o.parent().parent();
						_attrName = o.attr('name');
						switch(_attrName){
							case 'child_4[]':
								if(o.attr('parent')>0){
									if(jQuery('input[value="'+o.attr('parent')+'"]:checked').length>0){
										_type = 2;
									}
								}								
							break;
							case 'child_3[]':
							case 'child_2[]':
							case 'child_1[]':
								if(o.attr('child-rel')>0){
									if(jQuery('input[value="'+o.attr('parent')+'"]:checked').length>0){
										_type = 2;
									}
								}
							break;
						}
					}
					_areaID = o.val();
					
				}
var _cap = 0;
				function getChildData(object,level){
					if(object.text()=='+'){
						object.text('-')
					} else {
						object.text('+');
					}
					_getParentID = object.attr('rel');					
					object.addClass('active');
					_parentObject = object.parent().parent().parent().index();
					_PARENTOBJECT = object.parent().parent().parent().parent();
					if(_cap==0){
						jQuery("#patent>tbody>tr").each(function(index){
							if(index>0){
								jQuery(this).removeClass('classitemFocus');
							}		 					
						});	
						jQuery('#childTable>tbody>tr').each(function(index){
							jQuery(this).removeClass('classitemFocus');
						});	
						jQuery('#child1Table>tbody>tr').each(function(index){
							jQuery(this).removeClass('classitemFocus');
						});	
						jQuery('#child2Table>tbody>tr').each(function(index){
							jQuery(this).removeClass('classitemFocus');
						});		
					} else {
						_crA = _searchResults[_n];
						_ID = "#resultTable"+_crA.id;
						jQuery(_ID+" >tbody>tr").each(function(index){
							if(index>0){
								jQuery(this).removeClass('classitemFocus');
							}		 					
						});	
						jQuery(_ID).find('#childTable>tbody>tr').each(function(index){
							jQuery(this).removeClass('classitemFocus');
						});	
						jQuery(_ID).find('#child1Table>tbody>tr').each(function(index){
							jQuery(this).removeClass('classitemFocus');
						});	
						jQuery(_ID).find('#child2Table>tbody>tr').each(function(index){
							jQuery(this).removeClass('classitemFocus');
						});	
					}
									
					object.parent().parent().parent().addClass('classitemFocus');
					if(parseInt(_getParentID)>0){
						jQuery.ajax({
							url:_siteURL+'index.php',
							type:'POST',
							data:{option:'com_survey',task:'customer.childData',pat:_getParentID,l:level,format:''},
							cache:false,
							success:function(data){
								_parsingData = jQuery.parseJSON(data);
								if(_parsingData.length>0){
									switch(parseInt(level)){
										case 0:
											_IDDD = '#patent>tbody>tr';
											if(_cap==1){
												_crA = _searchResults[_n];
												_IDDD = "#resultTable"+_crA.id+'>tbody>tr';
											}
											if(jQuery(_IDDD).eq(_parentObject).next().attr('class')=='relatedData'){
												if(jQuery(_IDDD).eq(_parentObject).next().css('display')=='none'){
													jQuery(_IDDD).eq(_parentObject).next().css('display','table-row');
												} else {
													jQuery(_IDDD).eq(_parentObject).next().css('display','none');
												}
											} else {		
												appendTr = jQuery('<tr/>').addClass('relatedData').css('display','table-row').attr('parent-rel',_getParentID);
												appendTd = jQuery('<td/>').attr('colspan','3');
												appendTable = jQuery('<table/>').addClass('table table-striped').attr('id','childTable');
												_checkObj = object.parent().parent().parent().find('input[name="parent_checked[]"]');
												_checkCheckBox = _checkObj.is(':checked');
												_checkString = "";												
												if(_checkCheckBox==true){
													_checkString = 'CHECKED="CHECKED"';
												}
												_flag=0;												
												for(i=0;i<_parsingData.length;i++){
													_classSelected = "";
													if(_checkString==""){
														if(_expertArea.length>0){
															_checkString = '';
															if(jQuery.inArray(parseInt(_parsingData[i].id),_expertArea)>=0 && jQuery.inArray(parseInt(_parsingData[i].id),_expertAreaUnSelected)<0){				
																_flag=1;
																_checkString = 'CHECKED="CHECKED"';
																_classSelected="selected";
															}else {
																_checkString = '';
															}
														}
													}
													if(_flag==0){
														if(_parentsList.length>0){
															if(jQuery.inArray(parseInt(_parsingData[i].id),_parentsList)>=0 && jQuery.inArray(parseInt(_parsingData[i].id),_expertAreaUnSelected)<0){
																_flag=1;
																_checkString = 'CHECKED="CHECKED"';
																_classSelected = "light-gray";
															}
														}
														if(_flag==0 && _parentsList.length>0){
															_checkString = "";
														}
													} else {
														if(_parentsList.length>0){
															if(jQuery.inArray(parseInt(_parsingData[i].id),_parentsList)>=0 && jQuery.inArray(parseInt(_parsingData[i].id),_expertAreaUnSelected)<0){
																_flag=1;
																_classSelected = "light-gray";
															}
														}
													}
													_shortSelection = _checkString;
													if(_flag==0 && _checkString!="" && _expertAreaUnSelected.length>0){
														if(jQuery.inArray(parseInt(_parsingData[i].id),_expertAreaUnSelected)>=0){
															_flag=0;
															_shortSelection = "";
															_classSelected = "";
															if(_checkObj.length>0){
																_checkObj.addClass("light-gray");
															}
														}
													}
													if(_checkObj.length>0&&_checkObj.hasClass('selected')){
														if(_shortSelection==""){
															console.log('DSA');
															if(jQuery.inArray(parseInt(_parsingData[i].id),_expertAreaUnSelected)<0){
																_flag=0;
																_shortSelection = "CHECKED='CHECKED'";
																_classSelected = "light-red";
															}
														} else {
															_classSelected = "light-red";
														}
													} 
													
													
													appendChildTr = jQuery('<tr/>').addClass('child blue100').attr('child-rel',_getParentID);
													jQuery(appendChildTr).append('<td class="check-align"><input '+_shortSelection+' type="checkbox"  name="child_1[]" onclick="checkBoxClick(jQuery(this),1)" value="'+_parsingData[i].id+'" class="t1 '+_classSelected+'"/></td><td><label class="sm-width"><a style="padding-top:3px; display:inline-block;" rel="'+_parsingData[i].id+'" href="javascript:void(0);" onclick="getChildData(jQuery(this),1)">+</a></label></td><td width="94%"><p style="margin-top:4px !important;" class="noMargin">'+_parsingData[i].classification_description+'</p></td>');
													jQuery(appendTable).append(appendChildTr);
													if(_flag==1){
														_checkString = '';
													}
												}
												jQuery(appendTd).append(appendTable);
												jQuery(appendTr).append(appendTd);
												jQuery(_IDDD).eq(_parentObject).after(appendTr);
											}											
										break;
										case 1:		
											//alert(_PARENTOBJECT.html());
											if(object.parent().parent().parent().next().attr('class')=='relatedData'){
												
												if(object.parent().parent().parent().next().css('display')=='none'){
													
													object.parent().parent().parent().next().css('display','table-row');
												} else {
													
													object.parent().parent().parent().next().css('display','none');
												}
											} else {
											
											appendTr = jQuery('<tr/>').addClass('relatedData').css('display','table-row').attr('parent-rel',_getParentID);
											appendTd = jQuery('<td/>').attr('colspan','3');
											appendTable = jQuery('<table/>').addClass('table table-striped').attr('id','child1Table');		 
											_checkObj = object.parent().parent().parent().find('input[name="child_1[]"]');
											_checkCheckBox = _checkObj.is(':checked');
											_checkString = "";												
											if(_checkCheckBox==true){
												_checkString = 'CHECKED="CHECKED"';
											} 
											_flag=0;
											for(i=0;i<_parsingData.length;i++){
												_classSelected = "";
												if(_checkString==""){
													if(_expertArea.length>0){
														_checkString = '';							
														if(jQuery.inArray(parseInt(_parsingData[i].id),_expertArea)>=0 && jQuery.inArray(parseInt(_parsingData[i].id),_expertAreaUnSelected)<0){		
															_flag=1;
															_checkString = 'CHECKED="CHECKED"';
														}else {
															_checkString = '';
														}
													}
												}
												if(_flag==0){
													if(_parentsList.length>0){
														
														if(jQuery.inArray(parseInt(_parsingData[i].id),_parentsList)>=0 && jQuery.inArray(parseInt(_parsingData[i].id),_expertAreaUnSelected)<0){
															_flag=1;
															_checkString = 'CHECKED="CHECKED"';
															_classSelected = "light-gray";
														}
													}
													/*if(_flag==0 && _parentsList.length>0){
														_checkString = "";
													}*/
												} else {
													if(_parentsList.length>0){
														if(jQuery.inArray(parseInt(_parsingData[i].id),_parentsList)>=0 && jQuery.inArray(parseInt(_parsingData[i].id),_expertAreaUnSelected)<0){
															_flag=1;
															_classSelected = "light-gray";
														}
													}
												}
												_shortSelection = _checkString;
												if(_flag==0 && _checkString!="" && _expertAreaUnSelected.length>0){
													if(jQuery.inArray(parseInt(_parsingData[i].id),_expertAreaUnSelected)>=0){
														_flag=0;
														_shortSelection = "";
														_classSelected = "";
														if(_checkObj.length>0){
															_checkObj.addClass("light-gray");
														}
													}
												}
												if(_checkObj.length>0&&_checkObj.hasClass('selected')){
													if(_shortSelection==""){
														console.log('DSA');
														if(jQuery.inArray(parseInt(_parsingData[i].id),_expertAreaUnSelected)<0){
															_flag=0;
															_shortSelection = "CHECKED='CHECKED'";
															_classSelected = "light-red";
														}
													} else {
														_classSelected = "light-red";
													}
												}else if(_checkObj.length>0 &&_shortSelection!="" && _checkObj.hasClass('light-red')){
													_classSelected = "light-red";
												}
												appendChildTr = jQuery('<tr/>').attr('child-rel',_getParentID).addClass('blue200');
												jQuery(appendChildTr).append('<td class="check-align"><input '+_shortSelection+' type="checkbox" name="child_2[]" onclick="checkBoxClick(jQuery(this),2)" value="'+_parsingData[i].id+'" class="t2 '+_classSelected+'"/></td><td><label class="sm-width"><a style="padding-top:3px; display:inline-block;" rel="'+_parsingData[i].id+'" href="javascript:void(0);" onclick="getChildData(jQuery(this),2)">+</a></label></td><td width="94%"><p style="margin-top:4px !important;" class="noMargin">'+_parsingData[i].classification_description+'</p></td>');
												jQuery(appendTable).append(appendChildTr);
												if(_flag==1){
													_checkString = '';
												}
											}
											if(_checkString!="" && _parentsList.length>0 && _checkObj.length>0){
												_checkObj.addClass("light-gray");
											}
											jQuery(appendTd).append(appendTable);
											jQuery(appendTr).append(appendTd);
											object.parent().parent().parent().after(appendTr);
											}
										break;
										case 2:		
											if(object.parent().parent().parent().next().attr('class')=='relatedData1'){
												if(object.parent().parent().parent().next().css('display')=='none'){
													object.parent().parent().parent().next().css('display','table-row');
												} else {
													object.parent().parent().parent().next().css('display','none');
												}
											} else {
											appendTr = jQuery('<tr/>').addClass('relatedData1').css('display','table-row').attr('parent-rel',_getParentID);
											appendTd = jQuery('<td/>').attr('colspan','3');
											appendTable = jQuery('<table/>').addClass('table table-striped').attr('id','child2Table');	
											_checkObj = object.parent().parent().parent().find('input[name="child_2[]"]');
											_checkCheckBox = _checkObj.is(':checked');
											_checkString = "";												
											if(_checkCheckBox==true){
												_checkString = 'CHECKED="CHECKED"';
											}
											_flag=0;
											for(i=0;i<_parsingData.length;i++){
												_classSelected = '';
												if(_checkString==""){
													if(_expertArea.length>0){
														_checkString = '';
														if(jQuery.inArray(parseInt(_parsingData[i].id),_expertArea)>=0 && jQuery.inArray(parseInt(_parsingData[i].id),_expertAreaUnSelected)<0){			
															_flag=1;
															_checkString = 'CHECKED="CHECKED"';
														}else {
															_checkString = '';
														}
													}
												}
												if(_flag==0){
													if(_parentsList.length>0){
														if(jQuery.inArray(parseInt(_parsingData[i].id),_parentsList)>=0 && jQuery.inArray(parseInt(_parsingData[i].id),_expertAreaUnSelected)<0){
															_flag=1;
															_checkString = 'CHECKED="CHECKED"';
															_classSelected = "light-gray";
														}
													}
													/*if(_flag==0 && _parentsList.length>0){
														_checkString = "";
													}*/
												} else {
													if(_parentsList.length>0){
														if(jQuery.inArray(parseInt(_parsingData[i].id),_parentsList)>=0 && jQuery.inArray(parseInt(_parsingData[i].id),_expertAreaUnSelected)<0){
															_flag=1;
															_classSelected = "light-gray";
														}
													}
												}
												_shortSelection = _checkString;
												if(_flag==0 && _checkString!="" && _expertAreaUnSelected.length>0){
													if(jQuery.inArray(parseInt(_parsingData[i].id),_expertAreaUnSelected)>=0){
														_flag=0;
														_shortSelection = "";
														_classSelected = "";
														if(_checkObj.length>0){
															_checkObj.addClass("light-gray");
														}
													}
												}
												if(_checkObj.length>0&&_checkObj.hasClass('selected')){
													if(_shortSelection==""){
														console.log('DSA');
														if(jQuery.inArray(parseInt(_parsingData[i].id),_expertAreaUnSelected)<0){
															_flag=0;
															_shortSelection = "CHECKED='CHECKED'";
															_classSelected = "light-red";
														}
													} else {
														_classSelected = "light-red";
													}
												}else if(_checkObj.length>0 &&_shortSelection!="" && _checkObj.hasClass('light-red')){
													_classSelected = "light-red";
												}
												appendChildTr = jQuery('<tr/>').addClass('blue300').attr('child-rel',_getParentID);
												jQuery(appendChildTr).append('<td class="check-align"><input '+_shortSelection+' type="checkbox" name="child_3[]" onclick="checkBoxClick(jQuery(this),3)" value="'+_parsingData[i].id+'" class="t3 '+_classSelected+'"/></td><td><label class="sm-width"><a style="padding-top:3px; display:inline-block;"  rel="'+_parsingData[i].id+'" href="javascript:void(0);" onclick="getChildData(jQuery(this),3)">+</a></label></td><td width="94%"><p style="margin-top:4px !important;" class="noMargin">'+_parsingData[i].classification_description+'</p></td>');
												jQuery(appendTable).append(appendChildTr);
												if(_flag==1){
													_checkString = '';
												}
											}
											if(_checkString!="" && _parentsList.length>0 && _checkObj.length>0){
												_checkObj.addClass("light-gray");
											}
											jQuery(appendTd).append(appendTable);
											jQuery(appendTr).append(appendTd);
											object.parent().parent().parent().after(appendTr);
											}
										break;
										case 3:											
											if(object.parent().parent().parent().next().attr('class')=='relatedData2'){
												if(object.parent().parent().parent().next().css('display')=='none'){
													object.parent().parent().parent().next().css('display','table-row');
												} else {
													object.parent().parent().parent().next().css('display','none');
												}
											} else {
											appendTr = jQuery('<tr/>').addClass('relatedData2').css('display','table-row').attr('parent-rel',_getParentID);							
											appendTd = jQuery('<td/>').attr('colspan','3');
											appendTable = jQuery('<table/>').addClass('table table-striped').attr('id','child3Table');	

											_checkObj = 	object.parent().parent().parent().find('input[name="child_3[]"]');
											_checkCheckBox = _checkObj.is(':checked');
											_checkString = "";												
											if(_checkCheckBox==true){
												_checkString = 'CHECKED="CHECKED"';
											}
											if(_checkObj.hasClass('light-gray') && _parentsList.length>0){
												_checkString = "";
											}
											_flag=0;
											_sl=0;
											for(i=0;i<_parsingData.length;i++){
												_classSelected = '';
												_clInc = 400;
												switch(parseInt(_parsingData[i].level)){
													case 1:
														_clInc = 400;
													break;
													case 2:
														_clInc = 500;
													break;
													case 3:
														_clInc = 600;
													break;
													case 4:
														_clInc = 700;
													break;
													case 5:
														_clInc = 800;
													break;
													case 6:
														_clInc = 900;
													break;
													case 7:
														_clInc = 400;
													break;
												}
												appendChildTr = jQuery('<tr/>').addClass('blue'+_clInc).attr('child-rel',_getParentID);
												_stringDot = '';
												if(parseInt(_parsingData[i].level)>0){
													for(st=0;st<parseInt(_parsingData[i].level);st++){
														_stringDot+="<span class='dot'>&#8226;</span>";
													}
												}
												if(_checkString==""){
													if(_expertArea.length>0){
														_checkString = '';
														if(jQuery.inArray(parseInt(_parsingData[i].id),_expertArea)>=0 && jQuery.inArray(parseInt(_parsingData[i].id),_expertAreaUnSelected)<0){
															_flag=1;
															_sl = 1;
															_checkString = 'CHECKED="CHECKED"';
															_classSelected = "selected";
														}else {
															_checkString = '';
														}
													}
												}else {
													if(jQuery.inArray(parseInt(_parsingData[i].id),_expertArea)>=0 && jQuery.inArray(parseInt(_parsingData[i].id),_expertAreaUnSelected)<0){
														_sl = 1;
														_flag=1;
														_classSelected = "selected";
														console.log('SELECTED:'+parseInt(_parsingData[i].id));
													}
												}
												if(_flag==0){
													if(_parentsList.length>0){
														if(jQuery.inArray(parseInt(_parsingData[i].id),_parentsList)>=0 && jQuery.inArray(parseInt(_parsingData[i].id),_expertAreaUnSelected)<0){
															_flag=1;
															_checkString = 'CHECKED="CHECKED"';
															_classSelected = "light-gray";
														}
													}
													/*if(_flag==0 && _parentsList.length>0){
														_checkString = "";
													}*/
												} else {
													if(_parentsList.length>0){
														if(jQuery.inArray(parseInt(_parsingData[i].id),_parentsList)>=0 && jQuery.inArray(parseInt(_parsingData[i].id),_expertAreaUnSelected)<0){
															_flag=1;
															if(_sl==0){_classSelected = "light-gray";}
														}
													}
												}
												_shortSelection = _checkString;
												if(_flag==0 && _checkString!="" && _expertAreaUnSelected.length>0){
													if(jQuery.inArray(parseInt(_parsingData[i].id),_expertAreaUnSelected)>=0){
														_flag=0;
														_shortSelection = "";
														_classSelected = "";
														if(_checkObj.length>0){
															_checkObj.addClass("light-gray");
														}
													}
												}
												if(_checkString==""){
													if(parseInt(_parsingData[i].parent)>0){
														if(jQuery('input[value="'+_parsingData[i].parent+'"]:checked').length>0){							
															if(jQuery.inArray(parseInt(_parsingData[i].id),_parentsList)>=0 && jQuery.inArray(parseInt(_parsingData[i].id),_expertAreaUnSelected)<0){
																console.log('TAM0');
																jQuery('input[value="'+_parsingData[i].parent+'"]:checked').removeClass('light-red').addClass('light-gray');
																_flag=1;
																_classSelected = "light-red";
																_shortSelection = 'CHECKED="CHECKED"';
															}
														}
													}
												}
												if(_checkObj.length>0&&_checkObj.hasClass('selected')){
													if(_shortSelection==""){
														console.log('DSA');
														if(jQuery.inArray(parseInt(_parsingData[i].id),_expertAreaUnSelected)<0){
															_flag=0;
															_shortSelection = "CHECKED='CHECKED'";
															_classSelected = "light-red";
														}
													} else {
														_classSelected = "light-red";
													}
												}else if(_checkObj.length>0 &&_shortSelection!="" && _checkObj.hasClass('light-red')){
													_classSelected = "light-red";
												}
												
												jQuery(appendChildTr).append('<td class="check-align"><input '+_shortSelection+' type="checkbox" name="child_4[]" onclick="checkBoxClickWithParent(jQuery(this),'+_parsingData[i].id+')" big_parent="'+_parsingData[i].big_parent+'" parent="'+_parsingData[i].parent+'" value="'+_parsingData[i].id+'" class="t4 '+_classSelected+'"/></td><td><label class="sm-width"><a style="padding-top:3px; display:inline-block;"  href="javascript:void(0);" ></a></label></td><td width="94%"><p style="margin-top:4px !important;" class="noMargin">'+_stringDot+' '+_parsingData[i].classification_description+'</p></td>');
												jQuery(appendTable).append(appendChildTr);
												if(_flag==1){
													_checkString = '';
												}
											}											
											jQuery(appendTd).append(appendTable);
											jQuery(appendTr).append(appendTd);
											object.parent().parent().parent().after(appendTr);
											if(jQuery('input[name="child_4[]"]:checked').length>0 && _parentsList.length>0){
											_tableRC = jQuery("#child3Table");
											jQuery('input[name="child_4[]"]:checked').each(function(){
				if(jQuery(this).hasClass('selected'))	{							
	if(jQuery(this).attr('big_parent')=="0" && jQuery(this).attr('parent')=="0"){			
			_valM = jQuery(this).val();
			_rowSel = _tableRC.find('input[parent="'+_valM+'"]');
			console.log('ad:'+_rowSel.length+'@@:'+_valM);
			_rowSel.each(function(){
			if(jQuery.inArray(parseInt(jQuery(this).val()),_expertAreaUnSelected)<0){
					_cl = "light-red";
					console.log('TRO:'+parseInt(jQuery(this).val()));
					if(jQuery.inArray(parseInt(jQuery(this).val()),_expertArea)>=0){
						_cl = "";
					}
					jQuery(this).prop('checked',true).addClass(_cl);
					_innerP = jQuery(this).val();
					_rowSels = _tableRC.find('input[parent="'+_innerP+'"]');
					_rowSels.each(function(){
						if(jQuery.inArray(parseInt(jQuery(this).val()),_expertAreaUnSelected)<0){
							if(jQuery.inArray(parseInt(jQuery(this).val()),_expertArea)>=0){
								_cl = "";
							}
							jQuery(this).prop('checked',true).addClass(_cl);
						}
					});
				}
			});
			_rowSel = _tableRC.find('input[big_parent="'+_valM+'"]');
			console.log('a12d:'+_rowSel.length);
			_rowSel.each(function(){
			if(jQuery.inArray(parseInt(jQuery(this).val()),_expertAreaUnSelected)<0){
					_cl = "light-red";
					if(jQuery.inArray(parseInt(jQuery(this).val()),_expertArea)>=0){
						_cl = "";
					}
					jQuery(this).prop('checked',true).addClass(_cl);
				}
			})
		} else if(jQuery(this).attr('parent')>0){
			_valM = jQuery(this).val();
			_pr = jQuery(this).attr('parent');
			if(jQuery('input[value="'+_pr+'"]:checked').length==0){
				if(jQuery.inArray(_pr,_expertAreaUnSelected)<0){
					jQuery('input[value="'+_pr+'"]').prop('checked',true).addClass('light-gray');
				}
			}
			console.log('PEG'+_valM);
			_rowSel = _tableRC.find('input[parent="'+_valM+'"]');
			console.log('RED'+_rowSel.length);
			_rowSel.each(function(){
			if(jQuery.inArray(parseInt(jQuery(this).val()),_expertAreaUnSelected)<0){
					_cl = "light-red";
					if(jQuery.inArray(parseInt(jQuery(this).val()),_expertArea)>=0){
						_cl = "";
					}
					jQuery(this).prop('checked',true).addClass(_cl);
					_innerP = jQuery(this).val();
					_rowSels = _tableRC.find('input[parent="'+_innerP+'"]');
					_rowSels.each(function(){
						if(jQuery.inArray(parseInt(jQuery(this).val()),_expertAreaUnSelected)<0){
							_cl = "light-red";
							if(jQuery.inArray(parseInt(jQuery(this).val()),_expertArea)>=0){
								_cl = "";
							}
							jQuery(this).prop('checked',true).addClass(_cl);
						}
					});
				}
			})
		}
		}										});
											}
											}
										break;
									}
									//
								}
							}
						});
					}
				}
				
				function checkBoxClick(object,level){
					_prop = false;
					_addClass = false;
					_childClass = "";
					if(object.is(':checked')){
						_prop = true;
						object.addClass('selected');
						_childClass = "light-red";
						_addClass = true;
					}else {object.removeClass('selected');}checkBoxClickSelection(object);
					switch(level){
						case 0:
							object.parent().parent().parent().find(".relatedData").each(function(){
								if(parseInt(jQuery(this).attr('parent-rel'))==object.val()){
									jQuery(this).find("td>#childTable>tbody>tr").each(function(){	
										jQuery(this).find('input[name="child_1[]"],input[name="child_2[]"],input[name="child_3[]"],input[name="child_4[]"]').prop('checked',_prop);
										if(_prop===true){
											jQuery(this).find('input[name="child_1[]"],input[name="child_2[]"],input[name="child_3[]"],input[name="child_4[]"]').addClass(_childClass);
										} else {
											jQuery(this).find('input[name="child_1[]"],input[name="child_2[]"],input[name="child_3[]"],input[name="child_4[]"]').removeClass(_childClass);
										}
									});
								}
							});						
						break;
						case 1:
							object.parent().parent().parent().find(".relatedData").each(function(){
								if(parseInt(jQuery(this).attr('parent-rel'))==object.val()){
									jQuery(this).find("td>#child1Table>tbody>tr").each(function(){
										jQuery(this).find('input[name="child_2[]"],input[name="child_3[]"],input[name="child_4[]"]').prop('checked',_prop);
										if(_prop===true){
											jQuery(this).find('input[name="child_2[]"],input[name="child_3[]"],input[name="child_4[]"]').addClass(_childClass);
										} else {
											jQuery(this).find('input[name="child_2[]"],input[name="child_3[]"],input[name="child_4[]"]').removeClass(_childClass);
										}
									});
								}
							});
							var trRelated = object.parent().parent().parent().parent().parent().parent();
							if(trRelated.hasClass('relatedData')){
								_pRel = trRelated.attr('parent-rel');
								var chkPr = trRelated.parent().find('input[value="'+_pRel+'"]');
								if(chkPr.length>0){
									_tapLength = trRelated.find('tr.child').find('input[name="child_1[]"]').length;
									_tSeletedTotal = 0;
									trRelated.find('tr.child').find('input[name="child_1[]"]').each(function(){
										if(jQuery(this).is(':checked')){
											_tSeletedTotal++;
										}
									});
									if(_tSeletedTotal>0 && _tSeletedTotal!=_tapLength){
										chkPr.removeClass('light-red').addClass('light-gray').prop('checked',true);
									} else if(_tSeletedTotal==_tapLength) {
										chkPr.prop('checked',true).removeClass('light-red').removeClass('light-gray');
									} else {
										chkPr.prop('checked',false).removeClass('light-red').removeClass('light-gray');
									}
								}
							}
						break;
						case 2:
						 var objP = object.parent().parent().parent();
							objP.find(".relatedData1").each(function(){
								if(parseInt(jQuery(this).attr('parent-rel'))==object.val()){
									jQuery(this).find("td>#child2Table>tbody>tr").each(function(){
										jQuery(this).find('input[name="child_3[]"],input[name="child_4[]"]').prop('checked',_prop);
										if(_prop===true){
											jQuery(this).find('input[name="child_3[]"],input[name="child_4[]"]').addClass(_childClass);
										} else {
											jQuery(this).find('input[name="child_3[]"],input[name="child_4[]"]').removeClass(_childClass);
										}
									});
								}
							});
							var pP = objP.parent().parent().parent();
							if(pP.hasClass('relatedData')){
								var pRel = pP.attr('parent-rel');
								var tLength = objP.find('tr[child-rel="'+pRel+'"]').length;
								if(tLength>0){
									_tSeletedTotal = 0;
									objP.find('tr[child-rel="'+pRel+'"]').each(function(){
										if(jQuery(this).find('input[name="child_2[]"]:checked').length>0){
											_tSeletedTotal++;
										}
									});
									var chkPr = pP.parent().find('input[value="'+pRel+'"]');
									if(chkPr.length>0){
										if(_tSeletedTotal>0 && tLength!=_tSeletedTotal){
											chkPr.removeClass('light-red').addClass('light-gray').prop('checked',true);
										} else if(_tSeletedTotal==tLength) {
											chkPr.prop('checked',true).removeClass('light-red').removeClass('light-gray');
										} else {
											chkPr.prop('checked',false).removeClass('light-red').removeClass('light-gray');
										}
									}
								}
								var trRelated = pP.parent().parent().parent().parent();
								if(trRelated.hasClass('relatedData')){
									_pRel = trRelated.attr('parent-rel');
									var chkPr = trRelated.parent().find('input[value="'+_pRel+'"]');
									if(chkPr.length>0){
										_tapLength = trRelated.find('tr.child').find('input[name="child_1[]"]').length;
										_tSeletedTotal = 0;
										trRelated.find('tr.child').find('input[name="child_1[]"]').each(function(){
											if(jQuery(this).is(':checked')){
												_tSeletedTotal++;
											}
										});
										if(_tSeletedTotal>0 && _tSeletedTotal!=_tapLength){
											chkPr.removeClass('light-red').addClass('light-gray').prop('checked',true);
										} else if(_tSeletedTotal==_tapLength) {
											chkPr.prop('checked',true).removeClass('light-red').removeClass('light-gray');
										} else {
											chkPr.prop('checked',false).removeClass('light-red').removeClass('light-gray');
										}
									}
								}
							}
						break;
						case 3:
						var objP = object.parent().parent().parent();
							objP.find(".relatedData2").each(function(){
								if(parseInt(jQuery(this).attr('parent-rel'))==object.val()){
									jQuery(this).find("td>#child3Table>tbody>tr").each(function(){
										jQuery(this).find('input[name="child_4[]"]').prop('checked',_prop);
										if(_prop===true){
											jQuery(this).find('input[name="child_4[]"]').addClass(_childClass);
										} else {
											jQuery(this).find('input[name="child_4[]"]').removeClass(_childClass);
										}
									});
								}
							});
							var pPP = objP.parent().parent().parent();
							if(pPP.hasClass('relatedData1')){
								var pRel = pPP.attr('parent-rel');
								var tLength = objP.find('tr[child-rel="'+pRel+'"]').length;
								if(tLength>0){
									_tSeletedTotal = 0;
									objP.find('tr[child-rel="'+pRel+'"]').each(function(){
										if(jQuery(this).find('input[name="child_3[]"]:checked').length>0){
											_tSeletedTotal++;
										}
									});
									var chkPr = pPP.parent().find('input[value="'+pRel+'"]');
									if(chkPr.length>0){
										if(_tSeletedTotal>0 && tLength!=_tSeletedTotal){
											chkPr.addClass('light-gray').removeClass('light-red').prop('checked',true);
										} else if(_tSeletedTotal==tLength) {
											chkPr.prop('checked',true).removeClass('light-red').removeClass('light-gray');
										} else {
											chkPr.prop('checked',false).removeClass('light-red').removeClass('light-gray');
										}
									}
								}
								var pP = pPP.parent().parent().parent().parent();
								if(pP.hasClass('relatedData')){
									var pRel = pP.attr('parent-rel');
									var tLength = pP.find('tr[child-rel="'+pRel+'"]').length;
									if(tLength>0){
										_tSeletedTotal = 0;
										pP.find('tr[child-rel="'+pRel+'"]').each(function(){
											if(jQuery(this).find('input[name="child_2[]"]:checked').length>0){
												_tSeletedTotal++;
											}
										});
										var chkPr = pP.parent().find('input[value="'+pRel+'"]');
										if(chkPr.length>0){
											if(_tSeletedTotal>0 && tLength!=_tSeletedTotal){
												chkPr.addClass('light-gray').removeClass('light-red').prop('checked',true);
											} else if(_tSeletedTotal==tLength) {
												chkPr.prop('checked',true).removeClass('light-red').removeClass('light-gray');
											} else {
												chkPr.prop('checked',false).removeClass('light-red').removeClass('light-gray');
											}
										}
									}
									var trRelated = pP.parent().parent().parent().parent();
									if(trRelated.hasClass('relatedData')){
										_pRel = trRelated.attr('parent-rel');
										var chkPr = trRelated.parent().find('input[value="'+_pRel+'"]');
										if(chkPr.length>0){
											_tapLength = trRelated.find('tr.child').find('input[name="child_1[]"]').length;
											_tSeletedTotal = 0;
											trRelated.find('tr.child').find('input[name="child_1[]"]').each(function(){
												if(jQuery(this).is(':checked')){
													_tSeletedTotal++;
												}
											});
											if(_tSeletedTotal>0 && _tSeletedTotal!=_tapLength){
												chkPr.addClass('light-gray').removeClass('light-red').prop('checked',true);
											} else if(_tSeletedTotal==_tapLength) {
												chkPr.prop('checked',true).removeClass('light-red').removeClass('light-gray');
											} else {
												chkPr.prop('checked',false).removeClass('light-red').removeClass('light-gray');
											}
										}
									}
								}
							}
						break;
					}					
				}
				
				function checkBoxClickWithParent(object,parentVal){
					_prop = false;
					if(object.is(':checked')){
						_prop = true;
						object.addClass('selected');
					} else {
						object.removeClass('selected');
					}
					checkBoxClickSelection(object);
					if(object.attr('big_parent')==0 && object.attr('parent')==0){
						_valMain = object.val();
						if(_prop===true){
							jQuery(".relatedData2>td>#child3Table>tbody>tr").find('input[big_parent="'+_valMain+'"]').prop('checked',true).addClass('light-red');
							jQuery(".relatedData2>td>#child3Table>tbody>tr").find('input[parent="'+_valMain+'"]').prop('checked',true).addClass('light-red');
						} else {
							jQuery(".relatedData2>td>#child3Table>tbody>tr").find('input[big_parent="'+_valMain+'"]').prop('checked',false).removeClass('light-red');
							jQuery(".relatedData2>td>#child3Table>tbody>tr").find('input[parent="'+_valMain+'"]').prop('checked',false).removeClass('light-red');
						}
					} else {
						bpr = object.attr('big_parent');
						_valMain = object.val();
						if(_prop===true){
							/*My Big Parent*/
							//jQuery(".relatedData2>td>#child3Table>tbody>tr").find('input[value="'+bpr+'"]').prop('checked',true).removeClass('light-red').addClass('light-gray');
							
							/*My Parent*/
							//jQuery(".relatedData2>td>#child3Table>tbody>tr").find('input[value="'+pr+'"]').prop('checked',true).removeClass('light-red').addClass('light-gray');
							/*If I am big Parent*/
							//.jQuery(".relatedData2>td>#child3Table>tbody>tr").find('input[big_parent="'+_valMain+'"]').prop('checked',true).removeClass('light-red').addClass('light-gray');
							
							/*I am parent of other means select children*/
							jQuery(".relatedData2>td>#child3Table>tbody>tr").find('input[parent="'+_valMain+'"]').prop('checked',true).removeClass('light-gray').addClass('light-red');
							jQuery(".relatedData2>td>#child3Table>tbody>tr").find('input[parent="'+_valMain+'"]:checked').each(function(){
								_valC = jQuery(this).val();
								jQuery(".relatedData2>td>#child3Table>tbody>tr").find('input[parent="'+_valC+'"]').prop('checked',true).addClass('light-red');
							});
							pr = object.attr('parent');
							/*My Parent*/
							jQuery(".relatedData2>td>#child3Table>tbody>tr").find('input[value="'+pr+'"]').prop('checked',true).removeClass('light-red').addClass('light-gray');
							jQuery(".relatedData2>td>#child3Table>tbody>tr").find('input[value="'+pr+'"]:checked').each(function(){
								if(jQuery(this).attr('parent')>0){
									jQuery(".relatedData2>td>#child3Table>tbody>tr").find('input[value="'+jQuery(this).attr('parent')+'"]').prop('checked',true).removeClass('light-red').addClass('light-gray');
								}
							});
							/*Grand Parent*/
							jQuery(".relatedData2>td>#child3Table>tbody>tr").find('input[value="'+bpr+'"]').prop('checked',true).removeClass('light-red').addClass('light-gray');
						} else {
							jQuery(".relatedData2>td>#child3Table>tbody>tr").find('input[parent="'+_valMain+'"]:checked').each(function(){
								_valC = jQuery(this).val();
								jQuery(".relatedData2>td>#child3Table>tbody>tr").find('input[parent="'+_valC+'"]').prop('checked',false).removeClass('light-red');
							});
							jQuery(".relatedData2>td>#child3Table>tbody>tr").find('input[parent="'+_valMain+'"]').prop('checked',false).removeClass('light-red');
							pr = object.attr('parent');
							if(jQuery(".relatedData2>td>#child3Table>tbody>tr").find('input[parent="'+pr+'"]:checked').length==0){
								jQuery(".relatedData2>td>#child3Table>tbody>tr").find('input[value="'+pr+'"]').prop('checked',false).removeClass('light-gray').removeClass('light-red');
								_ppr = jQuery(".relatedData2>td>#child3Table>tbody>tr").find('input[value="'+pr+'"]').attr('parent');
								if(jQuery(".relatedData2>td>#child3Table>tbody>tr").find('input[parent="'+_ppr+'"]:checked').length==0){
									jQuery(".relatedData2>td>#child3Table>tbody>tr").find('input[value="'+_ppr+'"]').prop('checked',false).removeClass('light-gray').removeClass('light-red');
								} else {
									jQuery(".relatedData2>td>#child3Table>tbody>tr").find('input[value="'+_ppr+'"]').prop('checked',true).removeClass('light-red').addClass('light-gray');
								}
							} else {
								jQuery(".relatedData2>td>#child3Table>tbody>tr").find('input[value="'+pr+'"]').prop('checked',true).removeClass('light-red').addClass('light-gray');
								/*.addClass('light-gray')*/
							}
							if(jQuery(".relatedData2>td>#child3Table>tbody>tr").find('input[parent="'+bpr+'"]:checked').length==0){
								jQuery(".relatedData2>td>#child3Table>tbody>tr").find('input[value="'+bpr+'"]').prop('checked',false).removeClass('light-gray').removeClass('light-red');
							} else {
								jQuery(".relatedData2>td>#child3Table>tbody>tr").find('input[value="'+bpr+'"]').prop('checked',true).removeClass('light-red').addClass('light-gray');
								/*.addClass('light-gray')*/
							}
						}
					}
					
					/*if(object.attr('big_parent')>0 && object.attr('parent')>0){
						_getParent = object.attr('parent');
						_getBigParent = object.attr('big_parent');
						var pr = jQuery(".relatedData2>td>#child3Table>tbody>tr").find('input[value="'+_getParent+'"]');
						var bpr = jQuery(".relatedData2>td>#child3Table>tbody>tr").find('input[value="'+_getBigParent+'"]');
						if(_prop===true){
							bpr.addClass('light-gray');
							pr.addClass('light-gray');
						} else {
							bpr.removeClass('light-gray');
							pr.removeClass('light-gray');
						}
						pr.prop('checked',_prop);
						bpr.prop('checked',_prop);
					}*/
					var objP = object.parent().parent().parent();
					var pPPP = objP.parent().parent().parent();
					if(pPPP.hasClass('relatedData2')){
						var pRel = pPPP.attr('parent-rel');
						var tLength = objP.find('tr[child-rel="'+pRel+'"]').length;
						if(tLength>0){
							_tSeletedTotal = 0;
							objP.find('tr[child-rel="'+pRel+'"]').each(function(){
								if(jQuery(this).find('input[name="child_4[]"]:checked').length>0){
									_tSeletedTotal++;
								}
							});							
							var chkPr = pPPP.parent().find('input[value="'+pRel+'"]');
							if(chkPr.length>0){
								if(_tSeletedTotal>0 && tLength!=_tSeletedTotal){
									chkPr.addClass('light-gray').prop('checked',true);
								} else if(_tSeletedTotal==tLength) {
									chkPr.prop('checked',true).removeClass('light-gray');
								} else {
									chkPr.prop('checked',false).removeClass('light-gray');
								}
							}
						}
						var pPP = pPPP.parent().parent().parent().parent();
						if(pPP.hasClass('relatedData1')){
							var pRel = pPP.attr('parent-rel');
							var tLength = pPP.find('tr[child-rel="'+pRel+'"]').length;
							if(tLength>0){
								_tSeletedTotal = 0;
								pPP.find('tr[child-rel="'+pRel+'"]').each(function(){
									if(jQuery(this).find('input[name="child_3[]"]:checked').length>0){
										_tSeletedTotal++;
									}
								});
								var chkPr = pPP.parent().find('input[value="'+pRel+'"]');
								if(chkPr.length>0){
									if(_tSeletedTotal>0 && tLength!=_tSeletedTotal){
										chkPr.addClass('light-gray').prop('checked',true);
									} else if(_tSeletedTotal==tLength) {
										chkPr.prop('checked',true).removeClass('light-gray');
									} else {
										chkPr.prop('checked',false).removeClass('light-gray');
									}
								}
							}
							var pP = pPP.parent().parent().parent().parent();
							if(pP.hasClass('relatedData')){
								var pRel = pP.attr('parent-rel');
								var tLength = pP.find('tr[child-rel="'+pRel+'"]').length;
								if(tLength>0){
									_tSeletedTotal = 0;
									pP.find('tr[child-rel="'+pRel+'"]').each(function(){
										if(jQuery(this).find('input[name="child_2[]"]:checked').length>0){
											_tSeletedTotal++;
										}
									});
									var chkPr = pP.parent().find('input[value="'+pRel+'"]');
									if(chkPr.length>0){
										if(_tSeletedTotal>0 && tLength!=_tSeletedTotal){
											chkPr.addClass('light-gray').prop('checked',true);
										} else if(_tSeletedTotal==tLength) {
											chkPr.prop('checked',true).removeClass('light-gray');
										} else {
											chkPr.prop('checked',false).removeClass('light-gray');
										}
									}
								}
								var trRelated = pP.parent().parent().parent().parent();
								if(trRelated.hasClass('relatedData')){
									_pRel = trRelated.attr('parent-rel');
									var chkPr = trRelated.parent().find('input[value="'+_pRel+'"]');
									if(chkPr.length>0){
										_tapLength = trRelated.find('tr.child').find('input[name="child_1[]"]').length;
										_tSeletedTotal = 0;
										trRelated.find('tr.child').find('input[name="child_1[]"]').each(function(){
											if(jQuery(this).is(':checked')){
												_tSeletedTotal++;
											}
										});
										if(_tSeletedTotal>0 && _tSeletedTotal!=_tapLength){
											chkPr.addClass('light-gray').prop('checked',true);
										} else if(_tSeletedTotal==_tapLength) {
											chkPr.prop('checked',true).removeClass('light-gray');
										} else {
											chkPr.prop('checked',false).removeClass('light-gray');
										}
									}
								}
							}
						}
					}
				}
				allExpertData = [];
				__dd = "";
var _searchResults = [] ;
var _n=0;
function searchIPC(){
	if(jQuery("#search_ipc").val().length>1){
		jQuery.ajax({
			url:_siteURL+'index.php',
			type:'POST',
			data:{option:'com_survey',task:'customer.search_ipc',s:jQuery("#search_ipc").val(),format:''},
			cache:false,
			success:function(data){
				try{
					if(data!=""){
						_d = JSON.parse(data);
						if(_d.length>0){
							jQuery("#patent").hide();
							jQuery("#search_result").remove();
							_sDiv = jQuery("<div/>").attr('id','search_result');
							jQuery("#results").append(_sDiv);
							_searchResults = _d;
							_n = 0;
							startEmbedingResult();
						}
					}
				}catch(e){
					console.log(e);
				}
			}
		})
	}
}			
jQuery(document).ready(function() {
	jQuery('title').html('EXPERT EXPERTISE');
	jQuery('body').addClass('disable-select').attr('unselectable', 'on').css('user-select', 'none').on('selectstart dragstart', false).on('copy',function(e) {
		e.preventDefault();
		return false;
	});
	jQuery(document).on('keypress',function(e){
		if(e.which==13){
			searchIPC();
		}
	});
});
document.addEventListener('contextmenu', event => event.preventDefault());
var _clickTap = -1;
function startEmbedingResult(){
	/*console.log("Search:"+_searchResults.length);*/
	if(_n<_searchResults.length){
		/*console.log("Counter:"+_n);*/
		_cr = _searchResults[_n];
		/*console.log(_cr);*/
		if(_cr.parent>0){
			/*console.log('Parent Length:'+_cr.parent_list.length);*/
			if(_cr.parent_list.length>0){
				_clickTap = _cr.parent_list.length-1;
				_grandParent = _cr.parent_list[_clickTap];
				_table = jQuery("<table/>").addClass('table table-striped').attr('id',"resultTable"+_cr.id);
				_table.append('<thead><tr style="background:#BDC2C7;"><th></th><th class="sm-width"></th><th width="94%"></th></tr></thead><tbody><tr class="blue50"><td class="check-align"><input type="checkbox" name="parent_checked[]" value="'+_grandParent.id+'" onclick="checkBoxClick(jQuery(this),0);" class="t0 "></td><td><label class="sm-width"><a href="javascript:void(0);" onclick="getChildData(jQuery(this),0)" rel="'+_grandParent.id+'" style="padding-top:3px; display:inline-block;">+</a></label></td><td class=""><p class="noMargin" style="margin-top:4px !important;">'+_grandParent.classification_description+'</p></td></tr></tbody>');
				jQuery("#search_result").append(_table);
				_cap = 1;
				/*console.log("Parent List");
				console.log(_cr.parent_list);*/
				startClicking();
				/*_n = _n+1;
				startEmbedingResult();*/
			}
		} else {
			/*Parent Came*/
			_table = jQuery("<table/>").addClass('table table-striped').attr('id',"resultTable"+_cr.id);
			_table.append('<thead><tr style="background:#BDC2C7;"><th></th><th class="sm-width"></th><th width="94%"></th></tr></thead><tbody><tr class="blue50"><td class="check-align"><input type="checkbox" name="parent_checked[]" value="'+_cr.id+'" onclick="checkBoxClick(jQuery(this),0);" class="t0 "></td><td><label class="sm-width"><a href="javascript:void(0);" onclick="getChildData(jQuery(this),0)" rel="'+_cr.id+'" style="padding-top:3px; display:inline-block;">+</a></label></td><td class="highlight"><p class="noMargin" style="margin-top:4px !important;">'+_cr.classification_description+'</p></td></tr></tbody>');
			jQuery("#search_result").append(_table);
			_n = _n+1;
			startEmbedingResult();
		}
	}
}
function startClicking(){
	_crA = _searchResults[_n];
	_grandParentJ = _crA.parent_list[_clickTap];
	/*console.log('Clicking..');
	console.log('Finding for..');
	console.log(_grandParentJ);*/
	if(jQuery("#resultTable"+_crA.id).find("input[value='"+_grandParentJ.id+"']").length>0){
		_class = jQuery("#resultTable"+_crA.id).find("input[value='"+_grandParentJ.id+"']").attr('class');
		/*console.log("CLASS:"+_class);*/
		if(jQuery("#resultTable"+_crA.id).find("input[value='"+_grandParentJ.id+"']").hasClass("t4")){
			/*console.log('T4TRIGGERED..');*/
			_clickTap = _clickTap-1;
			if(_clickTap>=0){
				/*console.log('T4TIMEOUT..');*/
				setTimeout(function(){startClicking()},500);
			} else {
				/*console.log('T4NEXT..');
				console.log("T4New Table");*/
				jQuery("#resultTable"+_crA.id).find("input[value='"+_crA.id+"']").parent().parent().find('td').eq(2).addClass('highlight');	
				_clickTap = -1;
				_n = _n+1;
				startEmbedingResult();
			}
		} else {
			if(jQuery("#resultTable"+_crA.id).find("a[rel='"+_grandParentJ.id+"']").length>0){
				/*console.log('FOUND..');*/
				if(_crA.id!=_grandParentJ.id){
					jQuery("#resultTable"+_crA.id).find("a[rel='"+_grandParentJ.id+"']").trigger('click');
					/*console.log('TRIGGERED..');*/
					_clickTap = _clickTap-1;
					if(_clickTap>=0){
						/*console.log('TIMEOUT..');*/
						setTimeout(function(){startClicking()},500);
					} else {
						/*console.log('NEXT..');
						console.log("New Table")*/
						jQuery("#resultTable"+_crA.id).find("input[value='"+_crA.id+"']").parent().parent().find('td').eq(2).addClass('highlight');		
						_clickTap = -1;
						_n = _n+1;
						startEmbedingResult();
					}
				} else {
					/*console.log('NEXT1..');
					console.log("New Table1");*/
					jQuery("#resultTable"+_crA.id).find("input[value='"+_crA.id+"']").parent().parent().find('td').eq(2).addClass('highlight');					
					_clickTap = -1;
					_n = _n+1;
					startEmbedingResult();
				}
				
			} else {
				/*console.log('TIMEOUT1..');*/
				setTimeout(function(){startClicking()},500);
			}
		}
	} else {
		/*console.log('TIMEOUT1..');*/
				setTimeout(function(){startClicking()},500);
	}
	
}
</script>
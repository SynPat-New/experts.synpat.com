<?php
// No direct access to this file 
defined('_JEXEC') or die('Restricted access');
$parent = ($this->parentData);
$child = ($this->childData);
$expert = $this->expert;
$expertArea = $this->expertExpertiseArea;

$expertAreaArray = array();
if(count($expertArea)>0){
	for($i=0;$i<count($expertArea);$i++){
		$expertAreaArray[] = $expertArea[$i]->area_id;
	}
}

?> 
<style>
.table tbody tr td label a{font-weight: bold; color: hsl(3, 95%, 38%) !important; font-size:12px; font-family:arial}
.table tbody tr td p{font-weight: bold; text-align:left !important;  color: #0E2034; font-size:12px; font-family:arial}
.table thead tr th p{font-weight: bold; text-align:left !important; color: #0E2034; font-size:12px; font-family:arial}
.table tbody tr td{padding:0px; line-height:14px !important;}
.table tbody tr td label{margin:0px; line-height:normal}
.table tbody tr td{border-bottom: 1px solid hsl(210, 3%, 77%); background:none !important; padding-top:4px; padding-bottom:4px;}

.table thead tr th{border-bottom: 1px solid hsl(210, 3%, 77%); background:none !important; padding-top:4px; padding-bottom:4px; padding-left:0px}

td.dot{font-weight:bold; font-size:14px; color:#000; padding-left:2px !important; padding-right:2px !important; padding-top:6px !important;}
table.customTable tbody tr td{border:0px solid #fff !important}
table.customTable tbody tr td{padding-top:0px !important; padding-bottom:0px}
.table tbody tr td.arrow{background:#3A414D url(../img/arrowTop.png) no-repeat 4px 7px !important; width:2%}
.table tbody tr td.arrow2{background:#E9E7D9 url(../img/aow.jpg) no-repeat 4px 7px !important; width:2%}
table.table.table > tbody > tr.hover1:hover > td{ border-top:1px solid #000000 !important; border-bottom:1px solid #000 !important;}

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
</style>
<form action="index.php" method="post">
<div class="row-fluid">
				<div class="span12" style="background:#fff;">
					<table class="table table-striped" id="patent">						
							<thead>
								<tr style="background:#BDC2C7; border-top:1px solid hsl(210, 4%, 62%);">
									<th width="5%"></th>
									<th width="7%"  style="text-align:center;"><p class="noMargin">Symbol</p></th>
									<th width="88%"><p class="noMargin">Classification and description</p></th>
								</tr>
							</thead>
							<tbody>
							<?php 
								if(count($parent)>0){
							?>
								<tr class="classitemFocus">
									<td class="check-align"><input type="checkbox" name="parent_checked" style="margin-right:5px !important;" value="<?php echo $parent->id;?>" onclick="checkBoxClick(jQuery(this),0);"></td>
									<td style="width:7%">	
										<label>									
											<a href="javascript:void(0);" onclick="getChildData(jQuery(this),0)" rel="<?php echo $parent->id;?>" style="padding-top:3px; display:inline-block;"><?php echo $parent->name;?></a>
										 </label>
									</td>
									<td style="width:88%">
										<p class="noMargin" style="margin-top:4px !important;"><?php echo $parent->classification_description;?></p>
									</td>
								</tr>
								<tr>
									<td height="20px;" colspan="3">
									
									</td>
								</tr>
							<?php
									if(count($child)>0){
										for($i=0;$i<count($child);$i++){
											$row = $child[$i];
											$checked = "";
											if(in_array($row->id,$expertAreaArray)){
												$checked = "CHECKED='CHECKED'";
											}
							?>
											<tr class='child'>
												<td class="check-align">
												<input type="checkbox" onclick="checkBoxClick(jQuery(this),1);" <?php echo $checked;?> name="child_1[]" class="" style="margin-right:5px !important;" value="<?php echo $row->id; ?>"></td>
												<td style="width:7%">
													<label>
														<a href="javascript:void(0);"   onclick="getChildData(jQuery(this),1)" rel="<?php echo $row->id;?>" style="padding-top:3px; display:inline-block;"><?php echo $row->name;?></a>
													</label>
												</td>
												<td style="width:88%">
													<p class="noMargin" style="margin-top:4px !important;"><?php echo $row->classification_description;?></p>
												</td>
											</tr>
							<?php
										}
									}
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
			<script>
				_siteURL = '<?php echo JUri::base();?>';
				_expertArea = [
				<?php
					for($i=0;$i<count($expertArea);$i++){
						echo (int)$expertArea[$i]->area_id;
						if($i<count($expertArea)-1){
							echo ",";
						}
					}
					?>
				];
				function getChildData(object,level){					
					_getParentID = object.attr('rel');					
						object.addClass('active');
						_parentObject = object.parent().parent().parent().index();
						jQuery("#patent>tbody>tr").each(function(index){
							if(index>0){
								jQuery(this).removeClass('classitemFocus');
							}		 					
						});						
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
												jQuery('#patent>tbody>tr').each(function(index){
													if(index>1){
														jQuery(this).remove();
													}
												});					
												_checkCheckBox = object.parent().parent().parent().find('input[name="parent_checked"]').is(':checked');
												_checkString = "";												
												if(_checkCheckBox==true){
													_checkString = 'CHECKED="CHECKED"';
												}
																								
												for(i=0;i<_parsingData.length;i++){
													if(_expertArea.length>0 && _checkString==''){
														_checkString = '';
														if(jQuery.inArray(_parsingData[i].id,_expertArea)){
															_checkString = 'CHECKED="CHECKED"';
														} else {
															_checkString = 'CHECKED="CHECKED"';
														}
													}
													appendChildTr = jQuery('<tr/>').addClass('child');
													jQuery(appendChildTr).append('<td class="check-align"><input '+_checkString+' type="checkbox" name="child_1[]" onclick="checkBoxClick(jQuery(this),1)" value="'+_parsingData[i].id+'" style="margin-right:5px !important;"/></td><td width="7%"><label><a style="padding-top:3px; display:inline-block;" rel="'+_parsingData[i].id+'" href="javascript:void(0);" onclick="getChildData(jQuery(this),1)">'+_parsingData[i].name+'</a></label></td><td width="88%;"><p style="margin-top:4px !important;" class="noMargin">'+_parsingData[i].classification_description+'</p></td>');
													jQuery('#patent>tbody').append(appendChildTr);
												}													
											break;
											case 1:														
												jQuery("#relatedData").remove();		
												appendTr = jQuery('<tr/>').attr('id','relatedData');
												appendTd = jQuery('<td/>').attr('colspan','3');
												appendTable = jQuery('<table/>').addClass('table table-striped').attr('id','child1Table');								
												_checkCheckBox = object.parent().parent().parent().parent().find('input[name="child_1[]"]').is(':checked');
												_checkString = "";												
												if(_checkCheckBox==true){
													_checkString = 'CHECKED="CHECKED"';
												}
												_flag=0;
												for(i=0;i<_parsingData.length;i++){
													if(_checkString==""){
														if(_expertArea.length>0){
															_checkString = '';							
															if(jQuery.inArray(parseInt(_parsingData[i].id),_expertArea)>=0){									
																
																_flag=1;
																_checkString = 'CHECKED="CHECKED"';
															}else {
																_checkString = '';
															}
														}
													}
													appendChildTr = jQuery('<tr/>');
													jQuery(appendChildTr).append('<td class="check-align"><input '+_checkString+' type="checkbox" name="child_2[]" onclick="checkBoxClick(jQuery(this),2)" value="'+_parsingData[i].id+'" style="margin-right:5px !important;"/></td><td width="7%"><label><a style="padding-top:3px; display:inline-block;" rel="'+_parsingData[i].id+'" href="javascript:void(0);" onclick="getChildData(jQuery(this),2)">'+_parsingData[i].name+'</a></label></td><td width="88%;"><p style="margin-top:4px !important;" class="noMargin">'+_parsingData[i].classification_description+'</p></td>');
													jQuery(appendTable).append(appendChildTr);
													if(_flag==1){
														_checkString = '';
													}
												}
												jQuery(appendTd).append(appendTable);
												jQuery(appendTr).append(appendTd);
												jQuery('#patent>tbody>tr').eq(_parentObject).after(appendTr);
											break;
											case 2:
												jQuery("#relatedData1").remove();		
												appendTr = jQuery('<tr/>').attr('id','relatedData1');
												appendTd = jQuery('<td/>').attr('colspan','3');
												appendTable = jQuery('<table/>').addClass('table table-striped').attr('id','child2Table');		
												_checkCheckBox = object.parent().parent().parent().parent().find('input[name="child_2[]"]').is(':checked');
												_checkString = "";												
												if(_checkCheckBox==true){
													_checkString = 'CHECKED="CHECKED"';
												}
												_flag=0;
												for(i=0;i<_parsingData.length;i++){
													if(_checkString==""){
														if(_expertArea.length>0){
															_checkString = '';														
															if(jQuery.inArray(parseInt(_parsingData[i].id),_expertArea)>=0){														
																_flag=1;
																_checkString = 'CHECKED="CHECKED"';
															}else {
																_checkString = '';
															}
														}
													}
													appendChildTr = jQuery('<tr/>').css({background:'#E9E7D9'});
													jQuery(appendChildTr).append('<td class="check-align"><input '+_checkString+' type="checkbox" name="child_3[]" onclick="checkBoxClick(jQuery(this),3)" value="'+_parsingData[i].id+'" style="margin-right:5px !important;"/></td><td width="7%"><label><a style="padding-top:3px; display:inline-block;"  rel="'+_parsingData[i].id+'" href="javascript:void(0);" onclick="getChildData(jQuery(this),3)">'+_parsingData[i].name+'</a></label></td><td width="88%;"><p style="margin-top:4px !important;" class="noMargin">'+_parsingData[i].classification_description+'</p></td>');
													jQuery(appendTable).append(appendChildTr);
													if(_flag==1){
														_checkString = '';
													}
												}
												jQuery(appendTd).append(appendTable);
												jQuery(appendTr).append(appendTd);
												jQuery('#child1Table>tbody>tr').eq(_parentObject).after(appendTr);
											break;
											case 3:
												jQuery("#relatedData2").remove();		
												appendTr = jQuery('<tr/>').attr('id','relatedData2');
												appendTd = jQuery('<td/>').attr('colspan','3');
												appendTable = jQuery('<table/>').addClass('table table-striped').attr('id','child3Table');		
												_checkCheckBox = object.parent().parent().parent().find('input[name="child_3[]"]').is(':checked');
												_checkString = "";												
												if(_checkCheckBox==true){
													_checkString = 'CHECKED="CHECKED"';
												}
												_flag=0;
												for(i=0;i<_parsingData.length;i++){
													appendChildTr = jQuery('<tr/>').css({background:'#000000'});
													_stringDot = '';
													if(parseInt(_parsingData[i].level)>0){
														for(st=0;st<parseInt(_parsingData[i].level);st++){
															_stringDot+="<span class='dot'>&#8226;</span>";
														}
													}
													if(_checkString==""){
														if(_expertArea.length>0){
															_checkString = '';
															if(jQuery.inArray(parseInt(_parsingData[i].id),_expertArea)>=0){												
																_flag=1;
																_checkString = 'CHECKED="CHECKED"';
															}else {
																_checkString = '';
															}
														}
													}
													jQuery(appendChildTr).append('<td class="check-align"><input '+_checkString+' type="checkbox" name="child_4[]" onclick="checkBoxClickWithParent(jQuery(this),'+_parsingData[i].id+')" big_parent="'+_parsingData[i].big_parent+'" parent="'+_parsingData[i].parent+'" value="'+_parsingData[i].id+'" style="margin-right:5px !important;"/></td><td width="12%"><label><a style="padding-top:3px; display:inline-block;"  href="javascript:void(0);" >'+_parsingData[i].name+'</a></label></td><td width="83%;"><p style="margin-top:4px !important;" class="noMargin">'+_stringDot+' '+_parsingData[i].classification_description+'</p></td>');
													jQuery(appendTable).append(appendChildTr);
													if(_flag==1){
														_checkString = '';
													}
												}
												jQuery(appendTd).append(appendTable);
												jQuery(appendTr).append(appendTd);
												jQuery('#child2Table>tbody>tr').eq(_parentObject).after(appendTr);
											break;
										}
										
									}
								}
							});
						}
					
				}
				
				function checkBoxClick(object,level){
					switch(level){
						case 0:
							if(object.is(':checked')){
								jQuery("#patent>tbody>tr.child").each(function(){
									jQuery(this).find('input[name="child_1[]"]').attr('checked','checked');
									jQuery(this).find('input[name="child_2[]"]').attr('checked','checked');
									jQuery(this).find('input[name="child_3[]"]').attr('checked','checked');
									jQuery(this).find('input[name="child_4[]"]').attr('checked','checked');
								}); 
							} else {
								jQuery("#patent>tbody>tr.child").each(function(){
									jQuery(this).find('input[name="child_1[]"]').removeAttr('checked');
									jQuery(this).find('input[name="child_2[]"]').removeAttr('checked','checked');
									jQuery(this).find('input[name="child_3[]"]').removeAttr('checked','checked');
									jQuery(this).find('input[name="child_4[]"]').removeAttr('checked','checked');
								});
							}							
						break;
						case 1:
							if(object.is(':checked')){								
								jQuery("#relatedData>td>#child1Table>tbody>tr").each(function(){
									jQuery(this).find('input[name="child_2[]"]').attr('checked','checked');
									jQuery(this).find('input[name="child_3[]"]').attr('checked','checked');
									jQuery(this).find('input[name="child_4[]"]').attr('checked','checked');
								});
							} else {
								jQuery("#relatedData>td>#child1Table>tbody>tr").each(function(){
									jQuery(this).find('input[name="child_2[]"]').removeAttr('checked');
									jQuery(this).find('input[name="child_3[]"]').removeAttr('checked','checked');
									jQuery(this).find('input[name="child_4[]"]').removeAttr('checked','checked');
								});
							}
						break;
						case 2:
							if(object.is(':checked')){								
								jQuery("#relatedData1>td>#child2Table>tbody>tr").each(function(){
									jQuery(this).find('input[name="child_3[]"]').attr('checked','checked');
									jQuery(this).find('input[name="child_4[]"]').attr('checked','checked');
								});
							} else {
								jQuery("#relatedData1>td>#child2Table>tbody>tr").each(function(){
									jQuery(this).find('input[name="child_3[]"]').removeAttr('checked');
									jQuery(this).find('input[name="child_4[]"]').removeAttr('checked','checked');
								});
							}
						break;
						case 3:
							if(object.is(':checked')){								
								jQuery("#relatedData2>td>#child3Table>tbody>tr").each(function(){
									jQuery(this).find('input[name="child_4[]"]').attr('checked','checked');
								});
							} else {
								jQuery("#relatedData2>td>#child3Table>tbody>tr").each(function(){
									jQuery(this).find('input[name="child_4[]"]').removeAttr('checked');
								});
							}
						break;
					}					
				}
				
				function checkBoxClickWithParent(object,parentVal){
					if(object.is(':checked')){
						jQuery("#relatedData2>td>#child3Table>tbody>tr").each(function(){
								_getParent = jQuery(this).find('input[name="child_4[]"]').attr('parent');
								_getBigParent = jQuery(this).find('input[name="child_4[]"]').attr('big_parent');
								if(_getParent ==parentVal || _getBigParent==parentVal){
									jQuery(this).find('input[name="child_4[]"]').attr('checked','checked');
								}
							});
					} else {
						jQuery("#relatedData2>td>#child3Table>tbody>tr").each(function(){
								_getParent = jQuery(this).find('input[name="child_4[]"]').attr('parent');
								_getBigParent = jQuery(this).find('input[name="child_4[]"]').attr('big_parent');
								if(_getParent ==parentVal || _getBigParent==parentVal){
									jQuery(this).find('input[name="child_4[]"]').removeAttr('checked');
								}
							});
					}					
				}
			</script>
<div class='displayB'>
<button type="submit" class="large button lg-l-r pull-left" style='border:0 !important'>Save Changes <span>&raquo;</span></button>
</div>
					<input type="hidden" name="option" value="com_survey"/>
					<input type="hidden" name="e" value="<?php echo $expert->id;?>"/>
					<input type="hidden" name="task" value="customer.updateAreaExpertise"/>
				</form>

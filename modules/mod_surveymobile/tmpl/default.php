<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_whosonline
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

$db = JFactory::getDBO();
$sql = "SELECT * FROM #__paypal_setting";
$db->setQuery($sql);
$getPaypalData = $db->loadObject();
$paypalEmail = $getPaypalData->email_id;
$paypalURL = "";
if($getPaypalData->mode==1){
	$paypalURL = "https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&notify_version=2.9";		
} else {
	$paypalURL = "https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_xclick&notify_version=2.9";
}
?>
	<div class="hidden-desktop">   
	<div id="order_scripts1" >
    <script src="<?php echo JUri::base();?>templates/kallyas/lib/jquery.handsontable.js"></script>
    <script src="<?php echo JUri::base();?>templates/kallyas/lib/bootstrap-typeahead.js"></script>
    <script src="<?php echo JUri::base();?>templates/kallyas/lib/jquery.autoresize.js"></script>
    <script src="<?php echo JUri::base();?>templates/kallyas/lib/jquery.expage.js"></script>
    <script src="<?php echo JUri::base();?>templates/kallyas/extensions/jquery-ui-1.8.23.draggable.min.js"></script>
    <script src="<?php echo JUri::base();?>templates/kallyas/extensions/jquery.handsontable.controller.js"></script> 
    <script src="<?php echo JUri::base();?>templates/kallyas/lib/jQuery-contextMenu/jquery.contextMenu.js"></script>
    <script src="<?php echo JUri::base();?>templates/kallyas/lib/jQuery-contextMenu/jquery.ui.position.js"></script>
    <script src="<?php echo JUri::base();?>templates/kallyas/extensions/jquery.handsontable.removeRow.js"></script>
    <link rel="stylesheet" media="screen" href="<?php echo JUri::base();?>templates/kallyas/lib/jQuery-contextMenu/jquery.contextMenu.css">
    <link rel="stylesheet" media="screen" href="<?php echo JUri::base();?>templates/kallyas/lib/jquery.handsontable.css">
    <link rel="stylesheet" media="screen" href="<?php echo JUri::base();?>templates/kallyas/extensions/jquery.handsontable.removeRow.css">
    <link rel="stylesheet" media="screen" href="<?php echo JUri::base();?>templates/kallyas/extensions/jquery.handsontable.controller.css">
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.8.2/themes/smoothness/jquery-ui.css" />
	 <script src="http://code.jquery.com/ui/1.8.2/jquery-ui.js"></script>	
	<script>
		jQuery(document).ready(function(){
		if(navigator.userAgent.match(/(iPhone|iPod|iPad|Android|BlackBerry|Windows Phone)/)) {			
			jQuery("#order_scripts1").append("<link rel='stylesheet' href='<?php echo JUri::base();?>templates/kallyas/css/mobile.css' type='text/css' media='screen' />");
		}		
	});
	jQuery(window).resize(function(){
		if(navigator.userAgent.match(/(iPhone|iPod|iPad|Android|BlackBerry|Windows Phone)/)) {			
			jQuery("#order_scripts1").append("<link rel='stylesheet' href='<?php echo JUri::base();?>templates/kallyas/css/mobile.css' type='text/css' media='screen' />");
		}
	});
	</script>
			</div>	
				<div class="form-horizontal-1">
								<div class="control-group">
									<div class="controls">
										<input type="text" maxlength="7" id="project_name_multiple1" class="input-block-level" placeholder="Enter a name for Project" name="project_name_multiple1" >
									</div>
								</div>
							</div>
							
							<div class="form-horizontal-1">
								<div class="control-group">
									<label class="control-label">
										
									</label>
									<div class="controls">
										<input type="text" id="project_deadline_multiple1" class="input-block-level" placeholder="Enter a dealine for Delivery" name="project_deadline_multiple1" >
									</div>
								</div>
							</div>
					
							<div class="form-horizontal-1">
								<div class="control-group">
									<div class="controls">
									<div id="grid_excel" class="dataTable"></div>
									</div>
								</div>
							</div> 
							<div class="form-horizontal-1">
								<div class="control-group">
									<label class="control-label">
										 
									</label>
									<div class="controls">
										<textarea id="comment1" style='overflow:auto;resize:none' class="input-block-level" placeholder="Please provide comments and specific instruction for the experts" name="comment1" ></textarea>
									</div>
								</div>
							</div>
							<div class="form-horizontal">
								<div class="control-group" style="margin:0 !important;">
									<label class="control-label" style="text-align: left;">Price per Claim: $500 </label>
									
								</div>
							</div>
							<div class="form-horizontal">
								<div class="control-group" style="margin:0 !important;">
									<label class="control-label" style="text-align: left;">Number of Claims: <span id="no_of_assets1">0</span></label>
									
								</div>
							</div><div class="form-horizontal">
								<div class="control-group" style="margin:0 !important;">
									<label class="control-label" style="text-align: left;">Total Price: <span id="total_price1">&#36;0</span></label>
									
								</div>
							</div>
							
							<div class="form-horizontal">
								<div class="control-group">
									<label class="control-label" style="float:left; text-align: left; width:125px;" for="check_exclusive_multiple">Exclusively for you:</label>
									<div class="controls" style="width:auto; float:left; margin-left:0;">
										
										<!-- -->
										<div class="visible-phone" style="padding:4px 0;"><input style="margin:0;" type="checkbox" value="1" id="check_exclusive_multiple1" name="check_exclusive_multiple1"> </div>
									</div>
								 
										 
								</div>
							</div>
							<div class="form-horizontal-1">
								<div class="control-group">
									<div class="controls controls-row">
									  <div style="width:auto; float:left; width:35%; text-align:center; background-color: #FFFFFF;">
									  <div id="order_captcha" style='width:90px;height:30px;float:left;'>
										<img src="<?php echo JUri::base()?>index.php?option=com_survey&format=&task=customer.getCaptcha2&rand=<?php echo rand();?>"/>
										</div>
											<a href="javascript://" class="pull-left" style='margin-top:6px;'  onclick="refreshCaptcha();">
											<img src="<?php echo JUri::base();?>templates/kallyas/images/reload-16.png"/>
											</a>
										</div>
										
									  <div style="float:left; width:29%; margin-right:6px; margin-left:6px;"> <input type="text" placeholder="Captcha" name="captach_code" id="captach_code" class="input-block-level  noMargin" /></div>
									  <div class="controls pull-right" style="text-align:center; width:32%;">
										<a href="javascript://"  id="multiple_pay1" class=" multiple_pay large button lg-l-r">Order <span>&raquo;</span></a>
									</div>
									</div>
								</div>
							</div>
<script>
	

__DataExcel = '';
__SiteURL ='<?php echo JUri::base()?>';
__PPURLForA ='<?php echo $paypalURL;?>&business=<?php echo $paypalEmail;?>';
							
					function refreshCaptcha(){
						jQuery("#order_captcha").empty().html('<img src="'+__SiteURL+'index.php?option=com_survey&format=&task=customer.getCaptcha"/>');		
					}
					
					jQuery(document).ready(function(){	
						jQuery( "#project_deadline_multiple1" ).datepicker({ dateFormat: 'yy-mm-dd' });
						/*alert(screen.width);
						alert(window.innerWidth);*/
						var $container = jQuery("#grid_excel");
						jQuery("#comment1").focus(function(){
							_getDT = jQuery("#grid_excel").data('handsontable').getData();
							if(_getDT.length>0){
								countCLAIM = 0;
								for(m=0;m<_getDT.length-1;m++){
									if(_getDT[m][0].length>0){
										countCLAIM = countCLAIM + 1;
									}
								}
								if(countCLAIM>0){
									jQuery("#no_of_assets1").html(countCLAIM);
									jQuery("#total_price1").html("$"+ (countCLAIM*500));
								}
							}
						});
						$container.handsontable({
							rows: 1,
							cols: 4,							
							rowHeaders: true,
							colHeaders: ['Patent', 'Claim', 'Targets','Avoided'],
							minSpareCols: 0,
							minSpareRows: 1,
							contextMenu: false,
							Controller: {
								button:[''],
								ui:'hide'
							}/*,
							onChange: function (change, source) {
								alert(source);
								alert(change);
							}*/
						});
						/*
						if(jQuery.browser.msie || jQuery.browser.webkit){
							jQuery(document).keydown(function(e){
								if(e.keyCode==13){
									__GETID = jQuery("input:text:focus").attr("id");
									if(__GETID=="patent_number_find" || __GETID=="project_nane_find" || __GETID=="expert_nane_find"){
										fundSurvey();
									}
								}
							});
						} else {
							jQuery(document).keypress(function(e){
								if(e.keyCode==13){
									__GETID = jQuery("input:text:focus").attr("id");
									if(__GETID=="patent_number_find" || __GETID=="project_nane_find" || __GETID=="expert_nane_find"){
										fundSurvey();
									}
								}
							});
						}
						jQuery("#patent_number_find1").focus(function(){
							jQuery("#project_nane_find").val('');
						});
						jQuery("#project_nane_find").focus(function(){
							jQuery("#patent_number_find").val('');
						});*/
						var handsontable = $container.data('handsontable');
						jQuery("#project_name_multiple1").focus(function(){
								jQuery("#project_name1").val('');
								jQuery("#patent_number1").val('');
								jQuery("#claim_number1").val('');
								jQuery("#check_exclusive1").val('');
								if(jQuery("#check_exclusive1").is(':checked')){
									jQuery("#check_exclusive1").removeAttr('checked');
								}
						});
						jQuery("#multiple_pay1").click(function(){			
							
							if(jQuery("#project_name_multiple1").val()==""){
								alert('Please enter project name.');
								return false;
							} else {
								if(jQuery("#project_name_multiple1").val().length>7){
									alert('Project length should not be more than 7 character.');
									return false;
								}
							}
							if(jQuery("#project_deadline_multiple1").val()==""){
								alert('Please enter deadline date.');
								return false;
							}
							if(jQuery("#comment1").val()==""){
								alert('Please enter comment for this claim.');
								return false;
							}
							__E = 0;
							if(jQuery("#check_exclusive_multiple1").is(':checked')){
								__E = jQuery("#check_exclusive_multiple1").val();
							}
							__THIS = jQuery(this);
							__THIS.attr('disabled',true);
							__DataExcel = handsontable.getData();
							if(__DataExcel.length>0){
								
								_FLAG = 0;
								for(e=0;e<__DataExcel.length;e++){
									if(__DataExcel[e][0].length>0){
										_FLAG = 1;
										if(__DataExcel[e][0].length<7 && __DataExcel[e][0].length>9 ){
											
											alert('Please enter Patent Number either start US letter and character length should be 9 OR Character length should be 7 without US');
											__THIS.removeAttr('disabled');
											return false;
										} else {
											if(__DataExcel[e][0].length==9){
												_STR = __DataExcel[e][0];
												_STRING = _STR.substring(0,2);
												if(_STRING.toUpperCase()!='US'){
													alert('Please enter Patent Number either start US letter and character length should be 9 OR Character length should be 7 without US');
													__THIS.removeAttr('disabled');
													return false;
												}
											} else if(__DataExcel[e][0].length==7){
												
												_STR = __DataExcel[e][0];
												_STRING = _STR.substring(0,2);
												if(_STRING.toUpperCase()=='US'){													
													alert('Please enter Patent Number either start US letter and character length should be 9 OR Character length should be 7 without US');
													__THIS.removeAttr('disabled');
													return false;
												}
											} else {
												
												alert('Please enter Patent Number either start US letter and character length should be 9 OR Character length should be 7 without US');
												__THIS.removeAttr('disabled');
												return false;
											}
										}
									}
									if(__DataExcel[e][1].length>0){
										if(__DataExcel[e][1].length>2){
											alert('Claim number should be 2 characters.');
											__THIS.removeAttr('disabled');
											return false;
										}
									}
								}
								if(_FLAG ==0){
									alert('Please enter Patent number and Claim number.');
									__THIS.removeAttr('disabled');
									return false;
								}
							} else {
								alert('Please enter Patent number and Claim number.');
								__THIS.removeAttr('disabled');
								return false;
							}							
							jQuery.ajax({
								url:__SiteURL+'index.php?option=com_survey&task=customer.projectSurveyQuestionMultiple',
								type: 'POST',
								dataType: 'json',
								data:{p:jQuery("#project_name_multiple1").val(),e:__E,captach_code:jQuery('#captach_code').val(),other:handsontable.getData(),d:jQuery("#project_deadline_multiple1").val(),c:jQuery("#comment1").val(),format:''},
								success: function (res) {
									__THIS.removeAttr('disabled'); 
								  __DATA = res;
								  if(__DATA.id>0){ 
									__ram = __DATA.id;
									__amTT =  __DATA.amt;
									_amt = 0.5;
									_number_of_patent = __DATA.number_of_patent;
									jQuery("#no_of_assets1").html(__DATA.number_of_patent);
									jQuery("#total_price1").html(__amTT);									
									__PPURLForA = __PPURLForA+"&lc=US&item_name=Order Of ClaimCharts&desc=dummy&quantity="+_number_of_patent+"&amount="+__amTT+"&currency_code=USD&item_number="+__ram+"&notify_url=<?php echo urlencode(JUri::base().'index.php?option=com_survey&task=customer.orderNotify&raw=');?>"+__ram+"&return=<?php echo urlencode(JUri::base().'index.php?option=com_survey&task=customer.orderSuccess&raw=');?>"+__ram+"&cancel=<?php echo urlencode(JUri::base().'index.php?option=com_survey&task=customer.orderCancel&raw=');?>"+__ram;
									window.location.href=__PPURLForA;
								  } else {
									alert(__DATA.error);
								  }
								}
							});	
						});
					});
		
								</script> 
</div>

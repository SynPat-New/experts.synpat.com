<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_whosonline
 * @copyright	Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
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
if ($getPaypalData->mode == 1) {
    $paypalURL = "https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&notify_version=2.9";
} else { 
    $paypalURL = "https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_xclick&notify_version=2.9";
}
?>
<style>
/*.table th, .table td{border-top:1px solid #DDDDDD;}*/
#header{background:rgba(0,0,0,0.5);}
nav#main_menu > ul.sf-menu > li > a{color:#fff;}
.topnav > li > a, .topnav li .menu li a{color:#fff;}
div.span1.btnDeleteSpan{margin-left:2.014102564102564% !important;}
#patentImplementedAll .elementClaim:nth-child(odd){
	background-color:#f9f9f9;border-top:1px solid #efefef !important
}
</style>
<div class="visible-desktop visible-phone visible-tablet"> 
    <div id="order_scripts">
		<!--
        <script src="<?php echo JUri::base(); ?>templates/kallyas/lib/jquery.handsontable.js"></script>
        <script src="<?php echo JUri::base(); ?>templates/kallyas/lib/bootstrap-typeahead.js"></script>
        <script src="<?php echo JUri::base(); ?>templates/kallyas/lib/jquery.autoresize.js"></script>
        <script src="<?php echo JUri::base(); ?>templates/kallyas/lib/jquery.expage.js"></script>
        <script src="<?php echo JUri::base(); ?>templates/kallyas/extensions/jquery.handsontable.controller.js"></script> 
        <script src="<?php echo JUri::base(); ?>templates/kallyas/lib/jQuery-contextMenu/jquery.contextMenu.js"></script>
        <script src="<?php echo JUri::base(); ?>templates/kallyas/lib/jQuery-contextMenu/jquery.ui.position.js"></script>
        <script src="<?php echo JUri::base(); ?>templates/kallyas/extensions/jquery.handsontable.removeRow.js"></script>
        <link rel="stylesheet" media="screen" href="<?php echo JUri::base(); ?>templates/kallyas/lib/jQuery-contextMenu/jquery.contextMenu.css">
        <link rel="stylesheet" media="screen" href="<?php echo JUri::base(); ?>templates/kallyas/lib/jquery.handsontable.css">
        <link rel="stylesheet" media="screen" href="<?php echo JUri::base(); ?>templates/kallyas/extensions/jquery.handsontable.removeRow.css">
        <link rel="stylesheet" media="screen" href="<?php echo JUri::base(); ?>templates/kallyas/extensions/jquery.handsontable.controller.css">-->
		<script src="<?php echo JUri::base(); ?>templates/kallyas/extensions/jquery-ui-1.8.23.draggable.min.js"></script>
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.8.2/themes/smoothness/jquery-ui.css" />
        <script src="http://code.jquery.com/ui/1.8.2/jquery-ui.js"></script>
    </div>
    <form action='index.php' method="POST" onsubmit="return updateShoppingCartTable(2);">
	<div class="row-fluid" >
		<div class="span2" style='padding:0 0 0 10px;'>			
			<div class="span12">
				<div class="controls">
					<input type="text"  id="project_name_multiple" class="input-block-level" placeholder="Set a Project Name" name="project_name_multiple" >
				</div>	
			</div>
			<div class="span12 noMargin">			
				<div class="controls">
					<input type="text" id="project_deadline_multiple" class="input-block-level" placeholder="Dealine for Delivery" name="project_deadline_multiple" >
					
				</div>			
			</div>			
		</div>
		<div class="span2" style='padding:0 0 0 10px;'>	
			<div class="span12">
				<div class="controls">
					<input type="text"  id="maximum_price_claim" class="input-block-level" placeholder="Maximum Price/Claim" name="maximum_price_claim" >
				</div>	
			</div>
			<div class="span12 noMargin">			
				<div class="controls">
					<input type="text" id="specific_expert" class="input-block-level" placeholder="Specific Expert (Optional)" name="specific_expert" >	
				</div>			
			</div>	
		</div>
		<div class="span8" style='padding:0 0 0 10px;'>			
			<div class="controls">
				<textarea id="comment" style='resize:none;min-height:71px' class='span12' placeholder="Please provide comments and specific instruction to the experts" name="comment" ></textarea>
			</div>			
		</div>		
	</div>		
	<div class="row-fluid tM" id="patentImplementedAll">
		<div class='elementClaim row' style='margin-left: 0px; padding:10px;'>			
			<div class='span2'>
				<div class="span12 noMarginLeft">
					<select name="type_of_report[]" class='span12' onchange="changeElement(jQuery(this))">
						<option value="0">Type of Report</option>
						<option value="1">PriorArt Report</option>
						<option value="2">ClaimChart Report</option>
					</select>	
				</div>
				<div class="span12 noMarginLeft">
					<select name="type_of_document[]" class='span12' onchange="changeElement(jQuery(this))">
						<option value="0">Type of Document</option>
						<option value="1">Patent</option>
						<option value="2">Published Application</option>
						<option value="3">Unpublished Application</option>
					</select>	
				</div>		
				<div class="span12 noMarginLeft">
					<select name="type_of_exclusivity[]" class='span12' onchange="checkExclusive()">
						<option value="0">Exclusivity</option>
						<option value="1">Exclusively made for you</option>
						<option value="2">Available for others</option>
					</select>
				</div>				
			</div>
			<div class='span2 nextElement'></div>
			<div class='span6 nextElement1'></div>
			<div class='span2 nextButton'><div class='span12 btnDeleteSpan' style='display:none'><a class='btn btn-flat pull-right' href='javascript://' onclick='deleteSkelton(jQuery(this));'>Remove</a></div><div class='span12 btnAddSpan noMargin'><a class='btn btn-flat pull-right' href='javascript://' onclick='implementedSkelton(jQuery(this));'>Add a Claim</a></div></div>
				
			<!--
			<div class="span12 dP">
				<div class="span2">
					<input class="input-block-level" maxlength="10" name="patent[]" type="text" placeholder="Enter Patent Number">
				</div>
				<div class="span2">
					<input class="input-block-level" maxlength="3" name="claim[]" type="text" placeholder="Enter a Claim Number">
				</div>
				<div class="span7" style='padding-top:5px;'>
					<label style='display:inline-block'>Select whether their report should to be made &nbsp; </label><label class="radio inline" style='padding-top: 0px; margin-top: -3px;'> 
						<input type="radio" id="check_exclusive_multiple" class='tpExclusive' onclick="checkExclusive();" name="check_exclusive_multiple0" value="1"> Exclusive for you
					</label><label style='display:inline-block'>, or &nbsp;</label>
					<label class="radio inline" style='padding-top: 0px; margin-top: -3px;'>
						<input type="radio" id="check_exclusive_multiple" class='tpExclusive' onclick="checkExclusive();" name="check_exclusive_multiple0" value="2"> Available for others too.
					</label>
				</div>
				<div class='span1 btnDeleteSpan ' style='display:none'><a class="btn btn-flat" href="javascript://" onclick="deleteSkelton(jQuery(this));">Remove</a></div>
			</div>
			<div class="span12 noMargin">
				<div class="span2">					
					<label class="radio inline noMargin">
						<input type="radio" class='tpReport' id="type_report" onclick="checkTypeReport(jQuery(this))" name="type_report0" value="1"> PriorArt Report 
					</label>
				</div> 
				<div class="span2">					
					<label class="radio inline noMargin">
						<input type="radio"  class='tpReport' id="type_report" onclick="checkTypeReport(jQuery(this))" name="type_report0" value="2"> ClaimChart Report
					</label>
				</div>
				<div class="span3">
					<input class="input-block-level" name="target[]" type="text"  placeholder='products/companies to target (optional)'>
				</div>
				<div class="span3">
					<input class="input-block-level" name="avoided[]" type="text" placeholder="products/companies to ignore (optional)">
				</div>
				<div class='span2 btnAddSpan'><a class='btn btn-flat pull-right' href='javascript://' onclick="implementedSkelton(jQuery(this));">Add a Claim</a></div>	
			</div>-->
		</div>
	</div>
	<div class="row-fluid">
		<div class="span5 tMxxx">
			<table class="table" style='border:1px solid #DDDDDD;'>
				<tr>
					<th class="aCenter">ClaimCharts</th>
					<th class="aCenter">Price per claim</th>
					<th class="aCenter">Number of claims ordered</th>
				</tr>
				<tr>
					<td class="aCenter">Non-Exclusive</td>
					<td class="aCenter">$400</td>
					<td class='ccNon aCenter'>-</td>
				</tr>
				<tr>
					<td class="aCenter">Exclusive</td>
					<td class="aCenter">$700</td>
					<td class='ccExc aCenter'>-</td>
				</tr>
				<tr>
					<th class="aCenter">PriorArt</th>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td class="aCenter">Non-Exclusive</td>
					<td class="aCenter">$700</td>
					<td class='panon aCenter'>-</td>
				</tr>
				<tr>
					<td class="aCenter">Exclusive</td>
					<td class="aCenter">$900</td>
					<td class='paExc aCenter'>-</td>
				</tr>
				<tr style='border:1px solid #DDDDDD;'>
					<td class="aCenter">Total</td>
					<td class="reportTotal aCenter">-</td>
					<td class='grandTotal aCenter' style='font-weight:bold;'>-</td>
				</tr>
			</table>
		</div>
	</div>
	<!--
	<div class="row-fluid">		
		<div class="span7 tMxxx">
			<table class="table" style='border:1px solid #DDDDDD;'>
				<thead>
					<tr>
						<th></th>
						<th colspan="2" class="aCenter">ClaimCharts</th>
						<th colspan="2" class="aCenter">PriorArt</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td></td>
						<td style="text-align:center">Non-Exclusive</td>
						<td style="text-align:center">Exclusive</td>
						<td style="text-align:center">Non-Exclusive</td>
						<td style="text-align:center">Exclusive</td>
						<td></td>
					</tr>
					<tr>
						<td>Price per claim</td>
						<td style="text-align:center">$400</td>
						<td style="text-align:center">$700</td>
						<td style="text-align:center">$700</td>
						<td style="text-align:center">$900</td>
						<td></td>
					</tr>
					<tr>
						<td>Number of claims ordered</td>
						<td class='ccNon' style="text-align:center">-</td>
						<td class='ccExc' style="text-align:center">-</td>
						<td class='panon' style="text-align:center">-</td>
						<td class='paExc' style="text-align:center">-</td>
						<td>Total:</td>
					</tr>
					<tr style='border:1px solid #DDDDDD;'>
						<td>SubTotal</td>
						<td class='ccNonSub' style="text-align:center">-</td>
						<td class='ccSub' style="text-align:center">-</td>
						<td class='paNonSub' style="text-align:center">-</td>
						<td class='paSub' style="text-align:center">-</td>
						<td class='grandTotal' style='border-left:1px solid #DDDDDD;font-weight:bold;text-align:center' >-</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>-->
	<div class="row-fluid" style='margin-bottom:0px'>
		<div class="span12">
			<div class="form-horizontal-1 visible-desktop visible-phone visible-tablet">
				<div class="control-group">
					<div class="controls controls-row">
						<div class="controls pull-left" style="text-align:center;">
							<!--<a href="javascript://" id="multiple_pay" class="multiple_pay btn btn-flat" >Place your Order</a>-->
							<input type="submit" class="btn btn-flat" name="submit" value="Place your Order" />
						</div>
					</div>
				</div>
			</div> 
		</div> 
    </div> 
		<input type="hidden" name="option" value="com_survey"/>
		<input type="hidden" name="task" value="customer.projectSurveyQuestionMultiple"/>
	</form>
    <script>		
        __DataExcel1 = '';
        __SiteURL = '<?php echo JUri::base() ?>';
        __PPURLForA = '<?php echo $paypalURL; ?>&business=<?php echo $paypalEmail; ?>'; 
        
		
		
		function changeElement(object){
			/*PriorArt || ClaimChart*//*Patent || Published || Unpublished*//*Exclusive for you || Available for others*/	
			__index = object.parent().parent().parent().index();	
			if(__index>0){
				object.parent().parent().parent().find('div.nextButton').html("<div class='span12 btnDeleteSpan'><a class='btn btn-flat pull-right' href='javascript://' onclick='deleteSkelton(jQuery(this));'>Remove</a></div><div class='span12 btnAddSpan noMargin'><a class='btn btn-flat pull-right' href='javascript://' onclick='implementedSkelton(jQuery(this));'>Add a Claim</a></div>");	
			}
			switch(parseInt(object.parent().parent().find('select[name="type_of_report[]"]').val())){
				case 1:	
					switch(parseInt(object.parent().parent().find('select[name="type_of_document[]"]').val())){
						case 1:
							/*Patent*/
							object.parent().parent().parent().find('div.nextElement').removeClass('span8').addClass('span2').html('<div class="span12"><div class="controls"><input class="input-block-level patent" maxlength="10" name="patent'+__index+'" type="text" placeholder="Enter Patent Number"></div></div>');object.parent().parent().parent().find('div.nextElement1').css('display','block').addClass('span6').html('<div class="span4"><input class="input-block-level claim" maxlength="3" name="claim'+__index+'" type="text" placeholder="Enter a Claim Number"></div>')
						break;
						case 2:
							/*Published*/
							object.parent().parent().parent().find('div.nextElement').removeClass('span8').addClass('span2').html('<div class="span12"><input class="input-block-level application" maxlength="20" name="application'+__index+'" type="text" placeholder="Enter Application Number"></div>');object.parent().parent().parent().find('div.nextElement1').css('display','block').addClass('span6').html('<div class="span4"><input class="input-block-level claim" maxlength="3" name="claim'+__index+'" type="text" placeholder="Enter a Claim Number"></div>');
							
						break;
						case 3:
							/*Unpublished*/
							object.parent().parent().parent().find('div.nextElement').removeClass('span2').addClass('span8').html('<div class="span12"><textarea style="height:100px;" name="claim_language'+__index+'" class="claim_language span12" placeholder="Enter the claim language"></textarea></div>');object.parent().parent().parent().find('div.nextElement1').css('display','none');
							
						break;
						default:
							/*Remove Everything*/
							object.parent().parent().parent().find('div.nextElement').html('');
							object.parent().parent().parent().find('div.nextElement1').html('');
							//object.parent().parent().find('div.nextButton').html('');
						break;
					}
				break;
				case 2:
					switch(parseInt(object.parent().parent().find('select[name="type_of_document[]"]').val())){
						case 1:
							/*Patent*/
							object.parent().parent().parent().find('div.nextElement').html('<div class="span3"><input class="input-block-level patent" maxlength="10" name="patent'+__index+'" type="text" placeholder="Enter Patent Number"></div><div class="span3"><input class="input-block-level claim" maxlength="3" name="claim'+__index+'" type="text" placeholder="Enter a Claim Number"></div><div class="span12 noMargin"><input class="input-block-level target" name="target'+__index+'" type="text" placeholder="List the target products and/or companies to research (Optional)"></div><div class="span12 noMargin"><input class="input-block-level avoided" name="avoided'+__index+'" type="text" placeholder="List the target products and /or companies you wish the expert not to research (Optional)"></div>');object.parent().parent().parent().find('div.nextElement1').css('display','none');					
						break;
						case 2:
						case 3:
						default:
							/*Remove Everything*/
							object.parent().parent().parent().find('div.nextElement').html('');
							object.parent().parent().parent().find('div.nextElement1').html('');
							//object.parent().parent().find('div.nextButton').html('');
						break;
					}
				break;
				default:
					/*Remove Everything*/
					object.parent().parent().parent().find('div.nextElement').html('');
					object.parent().parent().parent().find('div.nextElement1').html('');
					//object.parent().parent().find('div.nextButton').html('');					
				break;
			}
			updateShoppingCartTable(1);
		}
		
		
        function checkExclusive(){
			updateShoppingCartTable(1);
		}
       
		function updateShoppingCartTable(type){
			_errorReport = 0;
			_indexObject = 0;
			_errorMessage="";
			if(type==2){
				jQuery('.elementClaim').each(function(index){
					_indexObject = index;
					if(jQuery(this).find('select[name="type_of_report[]"]').val()=='0'){
						_errorReport = 1;
						_errorMessage ="Please select type of report.";
						return false;
					}
					if(jQuery(this).find('select[name="type_of_document[]"]').val()=='0'){
						_errorReport = 1;
						_errorMessage ="Please select type of document.";
						return false;
					}
					if(jQuery(this).find('select[name="type_of_exclusivity[]"]').val()=='0'){
						_errorReport = 1;
						_errorMessage ="Please select exclusivity.";
						return false;
					}
					switch(parseInt(jQuery(this).find('select[name="type_of_report[]"]').val())){
						case 1:
							/*PriorArt*/
							switch(parseInt(jQuery(this).find('select[name="type_of_document[]"]').val())){
								case 1:
									/*Patent*/
									if(jQuery(this).find('input.patent').val()==""){
										_errorReport = 1;
										_errorMessage ="Please enter patent number.";
										return false;
									}
									if(jQuery(this).find('input.claim').val()==""){
										_errorReport = 1;
										_errorMessage ="Please enter claim number.";
										return false;
									}
								break;
								case 2:
									/*Published*/
									if(jQuery(this).find('input.application').val()==""){
										_errorReport = 1;
										_errorMessage ="Please enter application number.";
										return false;
									}
									if(jQuery(this).find('input.claim').val()==""){
										_errorReport = 1;
										_errorMessage ="Please enter claim number.";
										return false;
									}
								break;
								case 3:
									/*Unpublished*/
									if(jQuery(this).find('textarea.claim_language').val()==""){
										_errorReport = 1;
										_errorMessage ="Please enter claim language.";
										return false;
									}
								break;								
							}
						break;
						case 2:
							/*ClaimChart*/
							switch(parseInt(jQuery(this).find('select[name="type_of_document[]"]').val())){
								case 1:
									/*Patent*/
									if(jQuery(this).find('input.patent').val()==""){
										_errorReport = 1;
										_errorMessage ="Please enter patent number.";
										return false;
									}
									if(jQuery(this).find('input.claim').val()==""){
										_errorReport = 1;
										_errorMessage ="Please enter claim number.";
										return false;
									}
								break;
								case 2:
								case 3:
								default:
									_errorReport = 1;
									_errorMessage ="Please select other document type in ClaimChart report.";
									return false;
								break;
							}
						break;
					}
				});
			}
			
			if(_errorReport == 0){
				jQuery('.elementClaim').removeClass('alert-error');
				_claimChartExclusive = 0;
				_claimChartNonExclusive = 0;
				_priorArtNonExclusive = 0;
				_priorArtExclusive = 0;
				jQuery('.elementClaim').each(function(index){
					switch(parseInt(jQuery(this).find('select[name="type_of_report[]"]').val())){
						case 1:
							/*PriorArt*/
							switch(parseInt(jQuery(this).find('select[name="type_of_exclusivity[]"]').val())){
								case 1:
									/*Exclusive*/
									_priorArtExclusive = _priorArtExclusive + 1;
								break;
								case 2:
									/*Non Exclusive*/
									_priorArtNonExclusive = _priorArtNonExclusive +1;
								break;
							}
						break;
						case 2:
							/*ClaimChart*/
							switch(parseInt(jQuery(this).find('select[name="type_of_exclusivity[]"]').val())){
								case 1:
									/*Exclusive*/
									if(parseInt(jQuery(this).find('select[name="type_of_document[]"]').val())==1){
										_claimChartExclusive = _claimChartExclusive + 1;
									}
								break;
								case 2:
									/*Non Exclusive*/
									if(parseInt(jQuery(this).find('select[name="type_of_document[]"]').val())==1){
										_claimChartNonExclusive = _claimChartNonExclusive + 1;
									}
								break;
							}
						break;
					}
				});
				
				jQuery('.ccNon').html((_claimChartNonExclusive>0)?_claimChartNonExclusive:'-');
				jQuery('.ccExc').html((_claimChartExclusive>0)?_claimChartExclusive:'-');
				jQuery('.panon').html((_priorArtNonExclusive>0)?_priorArtNonExclusive:'-');
				jQuery('.paExc').html((_priorArtExclusive>0)?_priorArtExclusive:'-');
				_total = 0;
				if(_claimChartNonExclusive>0){
					_ss = _claimChartNonExclusive * 400;
					_total = _total + _ss;
					jQuery('.ccNonSub').html('$'+_ss);
				} else {
					jQuery('.ccNonSub').html('-');
				}
				if(_claimChartExclusive>0){
					_ss = _claimChartExclusive * 700;
					_total = _total + _ss;
					jQuery('.ccSub').html('$'+_ss);
				} else {
					jQuery('.ccSub').html('-');
				}
				if(_priorArtNonExclusive>0){
					_ss = _priorArtNonExclusive * 700;
					_total = _total + _ss;
					jQuery('.paNonSub').html('$'+_ss);
				} else {
					jQuery('.paNonSub').html('-');
				}
				if(_priorArtExclusive>0){
					_ss = _priorArtExclusive * 900;
					_total = _total + _ss;
					jQuery('.paSub').html('$'+_ss);
				} else {
					jQuery('.paSub').html('-');
				}
				/*Grand Total*/
				if(_total>0){
					jQuery('.grandTotal').html('$'+_total);
				} else {
					jQuery('.grandTotal').html('-');
				}
				return true;
			} else {
				alert(_errorMessage);
				jQuery("#patentImplementedAll>div.elementClaim").eq(_indexObject).addClass('alert-error');	
				return false;			
			}			
		}
			function implementedSkelton(object){
				if(updateShoppingCartTable(1)){
					jQuery('.btnAddSpan').css('display','none');
					jQuery('.btnDeleteSpan').css('display','block');
					_length = jQuery("#patentImplementedAll>div.elementClaim").length;
					jQuery("#patentImplementedAll").append('<div class="elementClaim row" style="margin-left: 0px;"><div class="span2"><select name="type_of_report[]" style="width:150px" onchange="changeElement(jQuery(this))"><option value="0">Type of Report</option><option value="1">PriorArt Report</option><option value="2">ClaimChart Report</option>		</select><select name="type_of_document[]" style="width:150px" onchange="changeElement(jQuery(this))"><option value="0">Type of Document</option><option value="1">Patent</option><option value="2">Published Application</option><option value="3">Unpublished Application</option></select><select name="type_of_exclusivity[]" style="width:150px" onchange="checkExclusive()"><option value="0">Exclusivity</option><option value="1">Exclusively made for you</option><option value="2">Available for others</option></select></div><div class="span8 nextElement"></div><div class="span2 nextButton"><div class="span12 btnDeleteSpan"><a class="btn btn-flat pull-right" href="javascript://" onclick="deleteSkelton(jQuery(this));">Remove</a></div><div class="span12 btnAddSpan noMargin"><a class="btn btn-flat pull-right" href="javascript://" onclick="implementedSkelton(jQuery(this));">Add a Claim</a></div></div></div>');
					var destination = object.offset().top;
					jQuery("html:not(:animated),body:not(:animated)").animate({ scrollTop: destination+121}, 1100);
				}				
			} 

            function refreshCaptcha() {
                jQuery("#order_captcha").empty().html('<img src="' + __SiteURL + 'index.php?option=com_survey&format=&task=customer.getCaptcha"/>');
            }
			
			function deleteSkelton(object){
				if(jQuery('.btnDeleteSpan').length>1){
					object.parent().parent().parent().remove();
					var destination = object.offset().top;
					jQuery("#patentImplementedAll>div.elementClaim").eq(jQuery("#patentImplementedAll>div.elementClaim").length-1).find('.btnAddSpan').css('display','block');
					jQuery("#patentImplementedAll>div.elementClaim").eq(jQuery("#patentImplementedAll>div.elementClaim").length-1).find('.btnDeleteSpan').css('display','block');
					updateShoppingCartTable(1);
					jQuery('.elementClaim').each(function(index){
						if(jQuery(this).find('input.patent').length>0){
							jQuery(this).find('input.patent').attr('name','patent'+index);
						}
						if(jQuery(this).find('input.claim').length>0){
							jQuery(this).find('input.claim').attr('name','claim'+index);
						}
						if(jQuery(this).find('input.application').length>0){
							jQuery(this).find('input.application').attr('name','application'+index);
						}
						if(jQuery(this).find('textarea.claim_language').length>0){
							jQuery(this).find('textarea.claim_language').attr('name','claim_language'+index);
						}
						if(jQuery(this).find('input.target').length>0){
							jQuery(this).find('input.target').attr('name','target'+index);
						}
						if(jQuery(this).find('input.avoided').length>0){
							jQuery(this).find('input.avoided').attr('name','avoided'+index);
						}
					});
					if(jQuery('.btnDeleteSpan').length==1){
						jQuery('.btnDeleteSpan').css('display','none');
					}
				} else {
					alert('You cannot remove it.');
				}
			}
			jQuery(document).ready(function() {
                jQuery("#project_deadline_multiple").datepicker({dateFormat: 'yy-mm-dd'});
			});
    </script>
</div>

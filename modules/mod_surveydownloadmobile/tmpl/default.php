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
				<div class="control-group">
					<!-- <label class="control-label" for="patent_number_find"></label> -->
					<div class="controls">
						<input type="text" maxlength="9" placeholder="Enter the Patent Number" name="patent_number_find1" id="patent_number_find1"  class="input-block-level" >
					</div>
				</div>				
				<div class="control-group">
					<!-- <label class="control-label" for="project_nane_find"></label> -->
					<div class="controls">
						<input type="text" maxlength="7" placeholder="Enter the Project Name"  name="project_nane_find1" id="project_nane_find1" class="input-block-level" >
					</div>
				</div>
				<div class="control-group">
					<!-- <label class="control-label" for="project_nane_find"></label> -->
					<div class="controls">
						<input type="text" maxlength="7" placeholder="Enter the Expert Name"  name="expert_nane_find1" id="expert_nane_find1" class="input-block-level" >
					</div>
				</div>				
				<div class="control-group">
					<!-- <label class="control-label">&nbsp;</label> -->
					<div class="controls">						
						<div class="hidden-desktop">
							<a href="#searchData1"  id="find_survey" onclick="fundSurvey1();"  class=" anchorLink large button lg-l-r" >Find <span>&raquo;</span></a>
						</div>
					</div>
				</div>
<!--CONTANTAREA STARTS-->
		<section class="dPx" id="searchData1" style="display:none;">
			<!-- -->
			<style>
			.loader , .loader1 , .loader2 , .loader_2 , .loader_1 , .loader_3{
				display:none;
				margin:0 auto;
				width:50px;
				height:50px;
			}
			.nav-tabs.nav-stacked > li a.active{
				background:none !important;
				color:red !important;
			}
			#questionlist thead tr th , #expertList tbody tr td{
				border-top:0px !important;
			}
			#surveylist > li > a:hover, #surveylist > li > a:focus ,#projectList > li > a:hover, #projectList > li > a:focus {
				background: none !important;
			}
			</style>
			<div class="container contCustom"> 
				<div class="row-fluid">
					<div class="span12 white">
						<!-- START PHONE-->
						
						<div class="row-fluid hidden-desktop">
							<div class="container_12" style="width:100%; margin:0;">
								<div class="grid_12 showError1"></div>
								<div class="grid_2">									
									<div id="project1">
										<div class="loader_2">
											<img src="<?php echo JUri::base();?>components/com_survey/images/loader.gif"/>
										</div>
									</div>									
								</div>
								<div class="grid_3">									
									<div id="survey1">
										<div class="loader_1">
											<img src="<?php echo JUri::base();?>components/com_survey/images/loader.gif"/>
										</div>
									</div>									
								</div>
								<div class="grid_7">
									<div class="row-fluid">
										<div class="row-fluid">
											<div id="question1" class="span12" style="overflow-x:scroll;">
												<div class="loader_3">
													<img src="<?php echo JUri::base();?>components/com_survey/images/loader.gif"/>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- FOR PHONE -->
					
					</div>
				</div>
			</div><!-- -->
		</section><!--CONTANTAREA STARTS-->
		
		<script>

								
								function fundSurvey1(){
									jQuery('.showError1').empty();
									if(jQuery("#patent_number_find1").val()=="" && jQuery("#project_nane_find1").val()=="" && jQuery("#expert_nane_find1").val()==""){
										alert('Please enter Patent number or Project name or Expert Name.');
										return false;
									}
									jQuery("#searchData1").css('display','block');
									jQuery("#find_survey1").attr('disabled',true);
									jQuery("#project1").find('legend').remove();
									jQuery("#projectList").remove();
									jQuery("#questionlist").parent().remove();
									jQuery("#questionlist").remove();
									jQuery("#expertList").parent().remove();
									jQuery("#expertList").remove();
									jQuery('.loader_2').css('display','block');
									jQuery("#project1").append('<legend class="noMargin" style="font-size:14px; font-weight:bold; color:#005580; border:none; white-space:nowrap;">Project</legend>');
									jQuery.ajax({
									url:__SiteURL+'index.php?option=com_survey&task=customer.search',
									type:'POST',
									data:{p:jQuery("#project_nane_find1").val(),s:jQuery("#patent_number_find1").val(),e:jQuery("#expert_nane_find1").val(),format:''},
									dataType: 'json',
									cache:false,
									success:function(data){
										jQuery("#find_survey1").removeAttr('disabled');
										_ul = jQuery("<ul/>").attr('id','projectList').addClass('nav nav-tabs nav-stacked');
										if(data.data!=null && data.data.length>0){	
											if(data.data.length==1){
												_row =data.data[0];
												jQuery(_ul).append("<li><a href='javascript://' class='active' onclick='su1(jQuery(this),"+_row.id+")'>"+_row.name+"</a></li>");
												jQuery("#rssFeed").attr('href',__SiteURL+'index.php?option=com_survey&view=customer&p_d='+_row.id+'&format=feed&type=rss');
												su1(jQuery("#projectList li a").eq(0),_row.id);
												
											} else {										
												for(i=0;i<data.data.length;i++){
													_row =data.data[i];
													jQuery(_ul).append("<li><a href='javascript://' onclick='su1(jQuery(this),"+_row.id+")'>"+_row.name+"</a></li>");
												}
											}											
										} else {
											jQuery('.showError1').append("<p class='alert alert-danger'>We have a project that with a name close to this one, but not exactly. Please correct your query.</p>");
										}
										jQuery("#project1").append(_ul);
										jQuery('.loader_2').css('display','none');
									}
									});
								}
																
								
								function su1(object,d){
									jQuery("#rssFeed").attr('href',__SiteURL+'index.php?option=com_survey&view=customer&p_d='+d+'&format=feed&type=rss');
									jQuery("#projectList li a").removeClass('active');
									object.addClass('active');
									jQuery("#questionlist").parent().remove();
									jQuery("#questionlist").remove();
									jQuery("#expertList").parent().remove();
									jQuery("#expertList").remove();
								if(d!=""){
									jQuery("#surveylist").remove();
									jQuery("#survey1").find('legend').remove();
									
									jQuery(".loader_1").before('<legend class="noMargin" style="font-size:14px; margin-left:5px; margin-bottom:8px; font-weight:bold; color:#005580; border:none; white-space:nowrap;">Claim</legend>');
									jQuery('.loader_1').css('display','block');
									
									jQuery.ajax({
									url:__SiteURL+'index.php?option=com_survey&task=customer.surveyListAnother',
									data:{ps:d,format:''},
									cache:false,
									success:function(html){
										__data = jQuery.parseJSON(html);
										jQuery("#surveylist").remove();
										_HTML = jQuery('<ul/>').attr('id','surveylist').addClass('nav nav-tabs nav-stacked');
										if(__data.length>0){
											for(i=0;i<__data.length;i++){
												_LI = jQuery('<li/>').data('surveyID',__data[i].id).click(function(){
																										
																										qu1(jQuery(this),jQuery(this).data('surveyID'));
																									}).append('<a href="javascript://">'+__data[i].combine_name+'</a>');
												jQuery(_HTML).append(_LI);
											}
										} else {
											jQuery(_HTML).append("<li>No record found</li>");	
										}
										
										jQuery("#survey1").append(_HTML);
										jQuery('.loader_1').css('display','none');
									}	
									});
								}
							}
				function qu1(object,su){
			/*__PPURL ="https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_xclick&notify_version=2.9&business=";*/
			__PPURL ="<?php echo $paypalURL;?>&business=";
			__SU = parseInt(su);
			jQuery("#surveylist li a").removeClass('active');
			object.find('a').addClass('active');
			jQuery("#questionlist").parent().remove();
				jQuery("#questionlist").remove();
				jQuery("#expertList").parent().remove();
				jQuery("#expertList").remove();		
			if(__SU!=0 && __SU!='NAN' &&  __SU!='NAN'){						
				jQuery('.loader_3').css('display','block');
				jQuery.ajax({
				url:__SiteURL+'index.php?option=com_survey&task=customer.quList',	
				data:{ps:__SU,format:''},
				cache:false,
				success:function(html){
					__data = jQuery.parseJSON(html);
					jQuery("#questionlist").remove();
					jQuery("#expertList").remove();
					//__GRID2Div = jQuery('<div/>').addClass('span8').css({marginLeft:'10px'});
					__GRID5Div = jQuery('<div/>').addClass('grid_6 alpha omega');
					__LegendGrid2 = jQuery('<legend/>').addClass('noMargin').append('Elements').css({height:'53px',fontSize:'14px',fontWeight:'bold',color:'#005580',whiteSpace:'wrap'});
					
					jQuery(__GRID5Div).append(__LegendGrid2);
					
					_HTML = jQuery('<table/>').attr('id','questionlist').addClass('table');
					__ETable = jQuery("<table/>").attr('id','expertList').addClass('table result-table').css('background','none').css('margin-top','4px');
					__GRID10Div = jQuery('<div/>').addClass('span4').css({overflowX:'scroll',margin:'0'});
					__GRID7Div = jQuery('<div/>').addClass('grid_6').css({overflowX:'scroll',margin:'0'});
					if(__data['question'].length>0){
						for(i=0;i<__data['question'].length;i++){
							_QueThread = jQuery("<thead/>");							
							if(i==(__data['question'].length-1)){
								_MAINTR = jQuery("<tr/>").css('border-bottom','1px solid #ccc').data('quData',__data['question'][i]);
							} else {
								_MAINTR = jQuery("<tr/>").data('quData',__data['question'][i]);
							}							
							_TH = jQuery("<th/>").append(__data['question'][i]['data'].description);
							jQuery(_MAINTR).append(_TH);
							jQuery(_QueThread).append(_MAINTR);
							jQuery(_HTML).append(_QueThread);
							if(i==0){
								
								_Thead = jQuery("<thead/>");
								_TR = jQuery("<tr/>");								
								for(s=0;s<__data['expert'].length;s++){
									if(__data['expert'][s].linkedin_profile_url==""){
										jQuery(_TR).append("<th valign='top' class='"+__data['expert'][s].id+"' style='text-align:center;height:33px;'>"+__data['expert'][s].name+"</th>");
									} else {
										jQuery(_TR).append("<th valign='top' class='"+__data['expert'][s].id+"' style='text-align:center;height:33px;'><a target='_BLANK' href='"+__SiteURL+"index.php?option=com_survey&task=customer.expertProfile&display="+__data['expert'][s].id+"'>"+__data['expert'][s].name+"</a></th>");
									}
									
									jQuery.ajax({
										url:__SiteURL+'index.php?option=com_survey&task=customer.showExpertRating',	
										data:{expert_id:__data['expert'][s].id,format:''},
										type:'POST',
										cache:false,
										success:function(html){
											_ratingData = jQuery.parseJSON(html);
											if(_ratingData.data.length){
												expertID = 0;
												totalProject = 0;
												totalRate = 0;
												for(r=0;r<_ratingData.data.length;r++){
													
													if(r==0){
														expertID = _ratingData.data[r].id;
													}
													totalProject = totalProject+_ratingData.data[r].countSurvey;
													   totalRate = totalRate+_ratingData.data[r].rating;
												}
												
												if(totalProject>0 && totalRate>0){
													$calcRating = totalRate/totalProject;
													if($calcRating==1){
														$class="s_star_1_0";
													} else if(($calcRating>1 && $calcRating<1.5) || ($calcRating>1.5 && $calcRating<2)){
														$class="s_star_1_5";
													} else if($calcRating==2){
														$class="s_star_2_0";
													} else if(($calcRating>2 && $calcRating<2.5) || ($calcRating>2.5 && $calcRating<3)){
														$class="s_star_2_5";
													} else if($calcRating==3){
														$class="s_star_3_0";
													} else if(($calcRating>3 && $calcRating<3.5) || ($calcRating>3.5 && $calcRating<4)){
														$class="s_star_3_5";
													} else if($calcRating==4){
														$class="s_star_4_0";
													} else if(($calcRating>4 && $calcRating<4.5) || ($calcRating>4.5 && $calcRating<5)){
														$class="s_star_4_5";
													} else if($calcRating==5){
														$class="s_star_5_0";
													}
													if(jQuery("."+expertID).find('.swSprite').length==0){
														jQuery("."+expertID).append('<br/><span title="'+$calcRating+' out of 5 stars" class="swSprite '+$class+'"></span>');
													}
												} else {
													_class="s_star_0_0";
													if(jQuery("."+expertID).find('.swSprite').length==0){
														jQuery("."+expertID).append('<br/><span title="0 out of 5 stars" class="swSprite '+_class+'"></span>');
													}
												}
											} else {
												_class="s_star_0_0";
												if(jQuery("."+_ratingData.id).find('.swSprite').length==0){
													jQuery("."+_ratingData.id).append('<br/><span title="0 out of 5 stars" class="swSprite '+_class+'"></span>');
												}
											}
										}
									});
								}
								jQuery(_Thead).append(_TR);
								jQuery(__ETable).append(_Thead);
							}
							__TR = jQuery("<tr/>");
							for(s=0;s<__data['expert'].length;s++){
								if(__data['question'][i]['answer'].length>0){
									__parseFlag = 0;
									__DipTo = 0;
									for(an=0;an<__data['question'][i]['answer'].length;an++){
										if(__DipTo==0){
											if(__data['expert'][s].id==__data['question'][i]['answer'][an].expert_id){
												__DipTo = 1;
												if(__data['question'][i]['answer'][an].status==1){
													_TD = jQuery("<td/>").addClass('aCenter').append('<i class="icon-ok aCenter"> </i>');
												} else {
													_TD = jQuery("<td/>").addClass('aCenter');
												}
												__parseFlag = 1;
											}
										}
										jQuery(__TR).append(_TD);
									}
									if(__parseFlag==0){
										_TD = jQuery("<td/>").append("");
										jQuery(__TR).append(_TD);
									}
								} else{
									_TD = jQuery("<td/>").append("");
									jQuery(__TR).append(_TD);
								}
							}
							jQuery(__ETable).append(__TR);
						}						
							__TR = jQuery("<tr/>");
							if(__data['survey'].length>0){
								for(s=0;s<__data['expert'].length;s++){
									__DIP2=0;
									for(am=0;am<__data['survey'].length;am++){
										if(__DIP2==0){
											if((__data['expert'][s].id==__data['survey'][am].expert_id) && (__data['expert'][s].target==__data['survey'][am].target)){
												__DIP2 = 1;
												__SUR = __data['survey'][am].survey_id;
												__EXP = __data['survey'][am].expert_id;
												_TD = jQuery("<td/>").css('background','none').addClass('aCenter').data('expertAmount',__data['survey'][am].amount).append('<span class="label dM">'+__data['survey'][am].target+'</span><br/><span class="label dM">$'+__data['survey'][am].amount+'</span><br/>');									
												__A = jQuery("<a/>").addClass('btn btn-danger').attr('data-target',__data['survey'][am].target).data('expertEmail',__data['expert'][s].paypal_id).click(function(){
																																							_TTHISS = jQuery(this);
																																							_TTHISS.attr('disabled',true);
																																							__cEM = jQuery(this).data('expertEmail');
																																							__target = jQuery(this).attr('data-target');
																																							__amTT = jQuery(this).parent().data('expertAmount');
																																							jQuery.ajax({
																																							url:__SiteURL+'index.php?option=com_survey&task=customer.transaction',
																																							data:{amt:__amTT,su:__SUR,ex:__EXP,target:__target,format:''},
																																							cache:false,
																																							success:function(data){
																																								if(data>0){
																																									__ram = data;
																																									__PPURL = __PPURL+__cEM+"&lc=US&item_name=Survey Purchase&amount="+__amTT+"&currency_code=USD&item_number="+__ram+"&notify_url=<?php echo urlencode(JUri::base().'index.php?option=com_survey&task=customer.notify&raw=');?>"+__ram+"&return=<?php echo urlencode(JUri::base().'index.php?option=com_survey&task=customer.success&raw=');?>"+__ram+"&cancel=<?php echo urlencode(JUri::base().'index.php?option=com_survey&task=customer.cancel&raw=');?>"+__ram;
																																									_TTHISS.removeAttr('disabled');
																																									window.location.href=__PPURL;
																																								}
																																							}
																																							});
																																						}).append('Buy');
												jQuery(_TD).append(__A);
												jQuery(__TR).append(_TD);
											}
										}
									}
								}
								jQuery(__ETable).append(__TR);								
							}
					} else {
						jQuery(_HTML).append('<tr><td>No record found!</td></tr>');						
					}
					/*
					jQuery(__GRID2Div).append(_HTML);
					
					jQuery(__GRID10Div).append(__ETable);
					*/
					jQuery(__GRID5Div).append(_HTML);
					
					jQuery(__GRID7Div).append(__ETable);
					jQuery("#question1").append(__GRID5Div).append(__GRID7Div);
					
					/*Change height for the Questions*/
						jQuery('#questionlist>thead').each(function(index){
								_height = jQuery(this).height();		
								jQuery("#expertList>tbody>tr").eq(index).css('height',_height+'px');		
						});
						/*End Change height for the Questions*/
					jQuery('.loader_3').css('display','none');
				}
				});
			}
		}
						
							</script>
							</div>
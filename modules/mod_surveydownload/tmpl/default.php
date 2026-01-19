<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_surveyorder
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

jimport('joomla.application.component.model');
JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_content/models');
$articleModel = JModelLegacy::getInstance( 'Article', 'ContentModel' );

?>

<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '864115217006674',
      xfbml      : true,
      version    : 'v2.4'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>

	<script type="text/javascript">
	</script>
<script type="text/javascript" src="<?php echo JUri::base();?>templates/kallyas/js/jquery.clipboard.js"></script>

<style>
#questionlist th{
font-size:13px !important;
font-weight:normal !important;
}
.table th, .table td{border-top:1px solid #DDDDDD;}
#header{background:rgba(0,0,0,0.5);}
nav#main_menu > ul.sf-menu > li > a{color:#fff;}
.topnav > li > a, .topnav li .menu li a{color:#fff;}
.smallm_title{border-bottom:1px solid #e5e5e5;}

/** Embeding code */
[name=iframeLink]+a,
[name=iLink]+a {
	display: inline-block;
	vertical-align: top;
}

</style>

<div class="visible-desktop visible-phone visible-tablet">
			<div class="row-fluid" style='margin-bottom:0px'>
				<div class="span12">
					<p>Search reports to acquire, for example use order name: <b>sun1</b> to retrieve a project details:</p>
				</div>
			</div>
			<div class="row-fluid" style='margin-bottom:0px'>
				<div class="span4">						
					<div class="controls">						
						<input type="text" maxlength="9" placeholder="Enter the Patent/Application Number" name="patent_number_find" id="patent_number_find"  class="input-block-level" >						
					</div>
					
				</div>				
				<div class="span4">						
					<div class="controls">
						<input type="text" maxlength="7" placeholder="Enter the Order Name"  name="project_nane_find" id="project_nane_find" class="input-block-level" >						
					</div>
					
				</div>
				<div class="span4">						
					<div class="controls">
						<input type="text"  placeholder="Enter the PExpert Name"  name="expert_nane_find" id="expert_nane_find" class="input-block-level" >						
					</div>
				</div>				
				<div class="span12 noMargin">	
					<!-- <label class="control-label">&nbsp;</label> -->
					<div class="controls">
						<div class="visible-desktop visible-phone visible-tablet"><input type='hidden' name='project_id' id='project_id' value='0'/>
							<a href="javascript://" id="find_survey" onclick="findSurvey();"   class="btn btn-flat" >Find</a>
						</div>	
						<span class="help-block tM" style='display:none;'>Once you find a report of interest, and agree to the expert's asking price, click Buy and you''ll be led to the expert's shopping cart at PayPal. You''ll be able to pay with a regular credit card. Upon payment you''ll be able to download the report in a PDF format.</span>						
					</div>
				</div>
			</div>
<!--CONTANTAREA STARTS-->
		<section class="dPx" id="searchData" style="display:none;">
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
			.table th{
				padding-top:5px !important;
			}
			ul.social-icons li{
				background:none;padding-left:0px;
			}
			#embedTable1 th, #embedTable1 td{padding:8px 8px 8px 44px;}
			#embedTable1 th:first-child, #embedTable1 td:first-child{padding:8px 8px 8px 0px;}
			.iframe-container{border:1px solid #ccc;}
			</style>
			<div class="container contCustom">
				<div class="row-fluid">
					<div class="span12 white">
						<!-- START DESKTOP -->
							<div class="row-fluid visible-desktop visible-phone visible-tablet custom-1">
								<div class="span12 showError" style='display:none'></div>
								<div class="span2 noMarginLeft">
									<div class="span5 noMargin">  
										<div id="project">
											<div class="loader2" style="display: none;">
												<img src="http://claimcharts.info/components/com_survey/images/loader.gif">
											</div>
										</div>
									</div>
									<div class="span7" style="margin-left:0px;"> 
										<div id="survey">
											<div class="loader" style="display: none;">
												<img src="http://claimcharts.info/components/com_survey/images/loader.gif">
											</div>
										</div>
									</div>
								</div>
								<div class="span10" style="">
									<div class="row-fluid" id="question">
										<div class="loader1">
											<img src="<?php echo JUri::base();?>components/com_survey/images/loader.gif"/>
										</div>
									</div>
								</div>								
								<div class="span12 noMargin" id="embedCode" style='display:none'>
									
									<div class="moduletable span12 " id="mod258" data-id="258" style='margin-bottom:0px;'>
										<div class="bghelper">
											<div class="modulecontent">
												<div class="custom ">
													<div class="span12">
														<?php 
															$result = $articleModel->getItem(90);
															$text = "<p></p>";
															$title = "";
															if(count($result)>0 && !empty($result->introtext)){
																$text = $result->introtext;
																/*$text  = str_replace("#CODES#","",$text);*/
																$title = $result->title;
															}
														?>
														<h3 class="m_title" style="margin-top:25px"><?php echo $title;?></h3>
														<?php echo $text;?>
													</div>
												</div>
											</div><!-- end modulecontent-->
										</div><!-- end bghelper -->										
									</div>
									
									<div class="moduletable span12 noMargin" id="mod133" data-id="133">
										<div class="bghelper">										
											
											<div class="modulecontent">
												<div class="custom ">
													<ul class="list-style1 cols-1 clearfix ">
														<li id="embedTable" style='background:none;padding-left:0px;'></li>
														<!--<li>If you would like to embed this "shopping cart" in your html page, please click here to receive the embedding code: <a href="#myModal" role="button" data-toggle="modal"><img src="<?php echo JUri::base();?>templates/kallyas/images/html-source.png"/></a>
														</li>-->
														<li id="shareTable" style='background:none;padding-left:0px;'>
														<div class="moduletable span12 " id="mod258" data-id="258" style='margin-bottom:30px;'>
										<div class="bghelper">
											<div class="modulecontent">
												<div class="custom ">
													<div class="span12">
														<?php 
															$result = $articleModel->getItem(91);
															$text = "<p></p>";
															$title = "";
															if(count($result)>0 && !empty($result->introtext)){
																$text = $result->introtext;
																/*$text  = str_replace("#CODES#","",$text);*/
																$title = $result->title;
															}
														?>
														<h3 class="m_title" style="margin-top:25px"><?php echo $title;?></h3>
														<?php echo $text;?>
													</div>
												</div>
											</div><!-- end modulecontent-->
										</div><!-- end bghelper -->										
									</div>
									<div class="visible-desktop visible-phone visible-tablet hidden" id="sharingContent">
									<?php 
										$result = $articleModel->getItem(89);
										$text = "";
										$title = "";
										if(count($result)>0 && !empty($result->introtext)){
											$text = $result->introtext;
											/*$text  = str_replace("#CODES#","",$text);*/
											$title = $result->title;
										}
									?>
									<style>
										div.sharing .social-icons li a{
											background-color:#cd2122;
										}
										
									</style>
									<div class="row-fluid" style='margin-bottom:0px'>
										<div class="span12">
											<div class="span12">
												<input type="text" class="span12" name="sharing_title" id="sharing_title" readonly="readonly"  value=""/>
											</div>
											<div class="span12 noMargin">
											<textarea name="sharing_data" maxlength='155' id="sharing_data" class="span12" style="height:50px;resize:none" class="mce_editable"></textarea>
											</div>
										</div>
										<div class="span12 sharing noMarginLeft">
											<ul class="social-icons fixclear normal" style='margin-bottom:40px;'>
											<li class="social-mail"><a href="javascript://" onclick="shareData('mail')" target="_blank" title="Email to friend">Email</a></li>
											<li class="social-linkedin"><a href="javascript://" onclick="shareData('linkedin')" title="Share on LinkedIn">LinkedIn</a></li>
											<li class="social-facebook"><a href="javascript://" onclick="shareData('facebook')"  title="Share on Facebook">Facebook</a></li>
											<li class="social-twitter"><a href="javascript://" onclick="shareData('twitter')"  title="Share on Twitter">Twitter</a></li>
											</ul>
										</div>
									</div>
								</div>
								<script> 
									__title = '<?php echo $title?>';
									__orgText = '<?php echo $text?>';
									__orgText = jQuery(__orgText).text();
									function shareData(type){
										$title = jQuery("#sharing_title").val();
										$summary = jQuery("#sharing_data").val();	
										$source = '<?php echo JUri::base()?>?'+jQuery("#project_nane_find").val();
										switch(type){
											case 'linkedin':		
												$title = encodeURIComponent($title);
												$summary = encodeURIComponent($summary);	
												$source = encodeURIComponent($source);
												$url = 'https://www.linkedin.com/shareArticle?mini=true&url='+$source+'&title='+$title+'&summary='+$summary+'&source='+$source;
												console.log($url);
												window.open($url,"Share on Linked In","width=500,height=400");
											break;
											case 'facebook':
												console.log($source);
												FB.ui({
												  method: 'feed',
												  link: $source,
												  caption: $title,
												  description: $summary,
												}, function(response){});
											break;
											case 'twitter':
												$title = encodeURIComponent($title);
												$summary = encodeURIComponent($summary);	
												$source = encodeURIComponent($source);
												$url = 'http://twitter.com/share?text='+$summary+'&url='+$source+'&via=claimcharts&related='+$source;
												window.open($url,"Share on Twitter","width=500,height=400");
											break;
											case 'mail':
												window.open("mailto:?subject="+$title+"&body="+$summary,"Share with friends","width=500,height=400");
											break;
										}	
									}
									/*jQuery(window).load(function(){
										
									});*/
								</script>
														
														</li>
														<li id="shareCode" style='background:none;padding-left:0px;'></li>
														
													</ul>
												</div>
											</div><!-- end modulecontent-->
										</div><!-- end bghelper -->
									</div>									
									<!--<a href="<?php echo JUri::base();?>index.php?option=com_survey&view=customer&format=feed&type=rss" target="_BLANK" id="rssFeed">
										<img src="<?php echo JUri::base();?>templates/survey/images/rss.png"/>
									</a>-->
								</div>
							</div>
						<!-- END DESKTOP -->
					</div>
				</div>
			</div><!-- -->
		</section><!--CONTANTAREA STARTS-->
		
		<script>
			function changeWidthIframe(tap){
				/*iframe-container*/
				switch(parseInt(tap)){
					case 1:
						jQuery('.iframe-container').eq(1).find('iframe').css('height',(jQuery('.iframe-container').eq(1).find('iframe').contents().find('body').height()+55)+'px');
					break;
					case 2:
						jQuery('.iframe-container').eq(0).find('iframe').css('height',(jQuery('.iframe-container').eq(0).find('iframe').contents().find('body').height()+55)+'px');
					break;
					default:
						jQuery('.iframe-container').find('iframe').css('height',(jQuery('.iframe-container').find('iframe').contents().find('body').height()+55)+'px');
					break;
				}			
			}
			__SiteURL = '<?php echo JUri::base();?>';
			if (jQuery.browser.msie || jQuery.browser.webkit) {
                    jQuery(document).keydown(function(e) {
                        if (e.keyCode == 13) {
                            __GETID = jQuery("input:text:focus").attr("id");
                            if (__GETID == "patent_number_find" || __GETID == "project_nane_find" || __GETID == "expert_nane_find") {
                                findSurvey();
                            }
                        }
                    });
                } else {
                    jQuery(document).keypress(function(e) {
                        if (e.keyCode == 13) {
                            __GETID = jQuery("input:text:focus").attr("id");
                            if (__GETID == "patent_number_find" || __GETID == "project_nane_find" || __GETID == "expert_nane_find") {
                                findSurvey();
                            }
                        }
                    });
                }
			jQuery(document).ready(function(){
				jQuery('.chcsdc').click(function(){
					__this = jQuery(this);
					jQuery('.chcsdc').each(function(){
						jQuery(this).removeAttr('checked');
					});
					__this.attr('checked','checked');
				});
				<?php 
					$param = JRequest::getVar('awse','');
					if(!empty($param)){
						$explodeParam = explode('@',base64_decode($param));
						if(isset($explodeParam[0]) && !empty($explodeParam[0])){
				?>
							jQuery("#project_nane_find").val('<?php echo $explodeParam[0];?>');
							findSurvey();
				<?php	
							/*
							if(isset($explodeParam[1]) && !empty($explodeParam[1])){
				?>
								su(jQuery("#projectList li a").eq(0),<?php echo $explodeParam[1]?>);
				<?php
							}
							*/
						}
					}
				?>
			});
			_codes="";
			function sendAlert(){		
				if(jQuery("#user_email_address").val()==""){
					alert('Please enter email address.');
					jQuery("#user_email_address").focus();
				} else {
					__c = 0;/*
					if(jQuery("input[name'type']:checked").val()=='claim'){
						_findActiveObject = jQuery("#surveylist>li>a.active");
						if(_findActiveObject!=undefined){
							__c = _findActiveObject.parent().data('surveyID');
						}
					}
					__c = 1;
					if(jQuery("input[name'type']:checked").val()=='claim' && (__c==0 || __c==undefined)){
						alert('Please select claim');
					} else */if(jQuery("#project_id").val()=='0'){
						alert('Please select project');
					} else {
						jQuery.ajax({
							url:__SiteURL+'index.php?option=com_survey&task=customer.sendAlert',
							type:'POST',
							data:{p:jQuery("#project_id").val(),c:__c,t:'both',e:jQuery("#user_email_address").val(),format:''},
							dataType: 'json',
							cache:false,
							success:function(data){
								if(data>0){
									alert('Email alerts update for this project.');
									jQuery("#user_email_address").val('');
								} else {
									alert('Please try after sometime.');
								}
							}
							
						});
					}
				}
				
			}
		function findSurvey(){
			jQuery('.showError').css('display','none').empty();
			jQuery("#embedCode").css('display','none');
			if(jQuery("#patent_number_find").val()=="" && jQuery("#project_nane_find").val()=="" && jQuery("#expert_nane_find").val()==""){
				alert('Please enter Patent number or Project name or Expert Name.');
				return false;
			}
			jQuery("#searchData").css('display','block');
			jQuery("#find_survey").attr('disabled',true);
			jQuery('.loader2').css('display','block');
			jQuery("#project").find('legend').remove();					
			jQuery("#projectList").remove();		
			jQuery("#surveylist").remove();		
			jQuery("#survey").find('legend').remove();
			jQuery("#expertList").parent().remove();
			jQuery("#expertList").remove();			
			jQuery("#questionlist").parent().remove();
			jQuery("#questionlist").remove();
			jQuery('.help-block').css('display','none');
			jQuery.ajax({
			url:__SiteURL+'index.php?option=com_survey&task=customer.search',
			type:'POST',
			data:{p:jQuery("#project_nane_find").val(),s:jQuery("#patent_number_find").val(),e:jQuery("#expert_nane_find").val(),format:''},
			dataType: 'json',
			cache:false,
			success:function(data){
				jQuery("#find_survey").removeAttr('disabled');				
				_ul = jQuery("<ul/>").attr('id','projectList').addClass('nav nav-tabs nav-stacked');
				if(data.data!=null && data.data.length>0){	
					/*jQuery("#project").append('<legend class="noMargin smallm_title" style="font-size: 14px; margin-bottom: 8px; font-weight: bold; white-space: nowrap; width: 100%; display: block; padding-bottom: 13px; border-bottom: 1px solid #e5e5e5;">Order</legend>');*/
					
					if(data.data.length==1){
						_row =data.data[0];
						
						/*jQuery(_ul).append("<li><a data-name='"+_row.name+"' data-id='"+_row.id+"' href='javascript://' class='active' onclick='su(jQuery(this),"+_row.id+")'>"+_row.name+"</a></li>");*/
						jQuery("#project_id").val(_row.id);	
					
						_codes = _row.code+', ' ;
						su(jQuery("#projectList li a").eq(0),_row.id,_row.name);
						
					} else {
						for(i=0;i<data.data.length;i++){
							_row =data.data[i];
							jQuery(_ul).append("<li ><a href='javascript://' data-name='"+_row.name+"' data-id='"+_row.id+"' onclick='su(jQuery(this),"+_row.id+",'\'"+_row.name+"\'')'>"+_row.name+"</a></li>");
							
						}		
					}														
				} else {
					jQuery('.showError').css('display','').append("<p class='alert alert-danger'>The search ended with no results. Please correct your query.</p>");
					jQuery("#project").find('legend').remove();
				}
				jQuery("#project").append(_ul);
				jQuery('.loader2').css('display','none');
			}
			});
		}
								
								
								
		function su(object,d,n){
			/*jQuery("#projectList li a").removeClass('active');*/
			jQuery("#rssFeed").attr('href',__SiteURL+'index.php?option=com_survey&view=customer&p_d='+d+'&format=feed&type=rss');
			/*object.addClass('active');
			jQuery("#questionlist").parent().remove();
			jQuery("#questionlist").remove();
			jQuery("#expertList").parent().remove();
			jQuery("#expertList").remove();*/
			jQuery('.showError').css('display','none')
		if(d!=""){
			jQuery("#surveylist").remove();
			jQuery("#survey").find('legend').remove();									
			/*jQuery(".loader").before('<legend class="noMargin smallm_title" style="font-size: 14px; margin-left: 5px; margin-bottom: 8px; font-weight: bold; white-space: nowrap; width: 100%; display: block; border-bottom: 1px solid #e5e5e5; padding-bottom: 13px;">Claim</legend>');
			jQuery('.loader').css('display','block');	*/								
			jQuery.ajax({
			url:__SiteURL+'index.php?option=com_survey&task=customer.surveyListAnother',
			data:{ps:d,format:''},
			cache:false,
			success:function(html){
				__data = jQuery.parseJSON(html);
				jQuery("#surveylist").remove();
				_HTML = jQuery('<ul/>').attr('id','surveylist').addClass('nav nav-tabs nav-stacked');
				if(__data.length>0){
					jQuery("#survey").parent().css('min-height','0px').parent().css('min-height','0px');
					jQuery("#question").parent().css('min-height','0px');
					_tableEmbed = jQuery("<table/>").addClass('table');
					/*_tHeading = jQuery("<thead/>");
					_trHead = jQuery("<tr/>");
					_trTh = jQuery("<th/>");
					jQuery(_trHead).append(_trTh);
					_trTh1 = jQuery("<th/>");
					jQuery(_trHead).append(_trTh1);					
					_trTh2 = jQuery("<th/>");
					jQuery(_trHead).append(_trTh2);
					jQuery(_tHeading).append(_trHead);
					jQuery(_tableEmbed).append(_tHeading);*/
					_tBody = jQuery("<tbody/>");
					
					_claimCharts = "";
					_priorArt = "";					
					
					for(i=0;i<__data.length;i++){
						/*_LI = jQuery('<li/>').data('surveyID',__data[i].id).data('name',__data[i].name).data('type',__data[i].report_type).click(function(){
																				qu(jQuery(this),jQuery(this).data('surveyID'));
																			}).append('<a style="padding-left:0px;padding-right:0px;" href="javascript://">'+__data[i].combine_name+'</a>');
						<?php 
							$param = JRequest::getVar('awse','');
							if(!empty($param)){
								$explodeParam = explode('@',base64_decode($param));
								if(isset($explodeParam[1]) && !empty($explodeParam[1])){
						?>
									if(__data[i].combine_name=='<?php echo $explodeParam[1]?>'){
										qu(jQuery("#surveylist>li").eq(i),__data[i].id);
									}
						<?php
								}
							}
						?>
						jQuery(_HTML).append(_LI);*/
						
						/*_codes += __data[i].code + ", ";*/
						/*_fFD = 0;
						if(jQuery("#project_nane_find").val()!="" && __data[i].exclude==1){
							_fFD = 1;
						}*/
						_iframeCode = '<iframe src="'+__SiteURL+'index.php/component/survey/?tmpl=component&task=customer.generateClientRequest&client_id='+n+'&name='+__data[i].name+'" width="100%" height="628" frameborder="0" scrolling="yes"></iframe>';
						_iLink = __SiteURL+'index.php/component/survey/?tmpl=component&task=customer.generateClientRequest&client_id='+n+'&name='+__data[i].name;
						if(__data[i].report_type=="2"){
							_claimCharts +="<tr><td>"+__data[i].combine_name+"</td><td><textarea  name='iframeLink' style='width:330px;height:65px;'>"+_iframeCode+"</textarea> <a href='javascript://'  class='embed btn btn-flat'>Copy to clipboard</a></td> <td> <textarea type='text' name='iLink' style='width:330px;height:65px;'>"+_iLink+"</textarea> <a href='javascript://'  class='link btn btn-flat'>Copy to clipboard</a></td></tr>";		
						} else {
							_priorArt +="<tr><td>"+__data[i].combine_name+"</td><td><textarea style='width:330px;height:65px;' name='iframeLink'> "+_iframeCode+"</textarea> <a href='javascript://'  class='embed btn btn-flat'>Copy to clipboard</a></td><td> <textarea  name='iLink' style='width:330px;height:65px;'>"+_iLink+"</textarea> <a href='javascript://'  class='link btn btn-flat'>Copy to clipboard</a></td></tr>";	
						}						
					}
					if(_codes!=""){
						_codes = _codes.substring(0,_codes.length-2);
						jQuery("#sharingContent").removeClass("hidden").addClass("show");
						newText = __orgText;
						newText = newText.replace("#CODES#",'<?php echo JUri::base()?>?'+n);
						jQuery("#sharing_data").val(newText);						
						jQuery("#sharing_title").val(__title);
						jQuery(" .mceToolbarRow2,.mceToolbarRow3").find("td").empty();
						jQuery(".mceToolbarRow4, .mceToolbarRow1").find("td").empty();
						jQuery("#editor-xtd-buttons").empty();						
						jQuery(".toggle-editor").empty();
					} else{
						jQuery("#sharingContent").removeClass("show").addClass("hidden");
					}
					if(_claimCharts!=""){
						_iframeCode = '<iframe src="'+__SiteURL+'index.php/component/survey/?tmpl=component&task=customer.generateClientRequest&client_id='+n+'&pr=2" width="100%" height="628" frameborder="0" scrolling="yes"></iframe>';
						jQuery(_tBody).append("<tr><td colspan='3' style='border-top:0px;padding-left:0px;padding-right:0px'><div class='iframe-container' >"+_iframeCode+"</div></td></tr>");
					}
					if(_priorArt!=""){						
						_iframeCode = '<iframe src="'+__SiteURL+'index.php/component/survey/?tmpl=component&task=customer.generateClientRequest&client_id='+n+'&pr=1" width="100%" height="628" frameborder="0" scrolling="yes"></iframe>';					
						jQuery(_tBody).append("<tr><td colspan='3' style='border-top:0px;padding-left:0px;padding-right:0px;'><div class='iframe-container' >"+_iframeCode+"</div></td></tr>");
					}
					_tBody1 = jQuery("<tbody/>");
					/*jQuery(_tBody1).append("<tr><td colspan='3' style='padding-top:35px;border:0px;padding-left:0px;' id='embed_code'><h3 class='span12 m_title' style='margin-left:0px'>Embedding Codes and Links</h3></td></tr>");*/
					jQuery(_tBody1).append("<tr><td colspan='3' style='padding-top:0;border:0px;padding-left:0px;padding-bottom:0px;' id='embed_code'></td></tr>");
					_trHead = jQuery("<tr/>");
					_trTh = jQuery("<th/>");
					jQuery(_trTh).append("Product");
					jQuery(_trHead).append(_trTh);
					_trTh1 = jQuery("<th/>");
					jQuery(_trTh1).append("Embedding Codes");	
					jQuery(_trHead).append(_trTh1);					
					_trTh2 = jQuery("<th/>");
					jQuery(_trTh2).append("Links");
					jQuery(_trHead).append(_trTh2);
					jQuery(_tBody1).append(_trHead);
					_tR = jQuery("<tr/>");
					_tD = jQuery("<td/>");
					/*Entire Order*/
					jQuery(_tD).append("Entire Order");
					jQuery(_tR).append(_tD);
					_tD1 = jQuery("<td/>");
					_iframeCode = '<iframe src="'+__SiteURL+'index.php/component/survey/?&tmpl=component&task=customer.generateClientRequest&client_id='+n+'" width="100%" height="628" frameborder="0" scrolling="yes"></iframe>';
					_iLink = __SiteURL+'index.php/component/survey/?&tmpl=component&task=customer.generateClientRequest&client_id='+n;
					jQuery(_tD1).append("<textarea name='iframeLink' style='width:330px;height:65px;'>"+_iframeCode+"</textarea> <a href='javascript://' class='embed btn btn-flat'>Copy to clipboard</a>");
					jQuery(_tR).append(_tD1);
					_tD2 = jQuery("<td/>");
					jQuery(_tD2).append("<textarea type='text' name='iLink' style='width:330px;height:65px;'>"+_iLink+"</textarea> <a href='javascript://'  class='link btn btn-flat'>Copy to clipboard</a>");
					jQuery(_tR).append(_tD1);
					jQuery(_tR).append(_tD2);
					jQuery(_tBody1).append(_tR);
					/*End Entire Order*/
					/*ClaimCharts Embedding Code*/
					if(_claimCharts!=""){
						_tR = jQuery("<tr/>");
						_tD = jQuery("<td/>").append("ClaimCharts");
						jQuery(_tR).append(_tD);
						_iframeCode = '<iframe src="'+__SiteURL+'index.php/component/survey/?tmpl=component&task=customer.generateClientRequest&client_id='+n+'&pr=2" width="100%" height="628" frameborder="0" scrolling="yes"></iframe>';					
						_iLink = __SiteURL+'index.php/component/survey/?tmpl=component&task=customer.generateClientRequest&client_id='+n+'&pr=2';
						_tD1 = jQuery("<td/>").append("<textarea style='width:330px;height:65px;'  name='iframeLink'>"+_iframeCode+"</textarea> <a href='javascript://'  class='embed btn btn-flat'>Copy to clipboard</a>");
						jQuery(_tR).append(_tD1);
						_tD2 = jQuery("<td/>").append("<textarea name='iLink' style='width:330px;height:65px;'>"+_iLink+"</textarea> <a href='javascript://'  class='link btn btn-flat'>Copy to clipboard</a>");
						jQuery(_tR).append(_tD2);
						jQuery(_tBody1).append(_tR);
						jQuery(_tBody1).append(_claimCharts);
					}
					/*End ClaimCharts Embedding Code*/
					/*Prior Arts Embedding Code*/
					if(_priorArt!=""){		
						_tR = jQuery("<tr/>");
						_tD = jQuery("<td/>").append("PriorArts");
						jQuery(_tR).append(_tD);
						_iframeCode = '<iframe src="'+__SiteURL+'index.php/component/survey/?tmpl=component&task=customer.generateClientRequest&client_id='+n+'&pr=1" width="100%" height="628" frameborder="0" scrolling="no"></iframe>';
						_iLink = __SiteURL+'index.php/component/survey/?tmpl=component&task=customer.generateClientRequest&client_id='+n+'&pr=1';
						_tD1 = jQuery("<td/>").append("<textarea  name='iframeLink' style='width:330px;height:65px;'>"+_iframeCode+"</textarea> <a href='javascript://'  class='embed link btn btn-flat'>Copy to clipboard</a>");
						jQuery(_tR).append(_tD1);
						_tD2 = jQuery("<td/>").append("<textarea name='iLink' style='width:330px;height:65px;'>"+_iLink+"</textarea> <a href='javascript://'  class='link btn btn-flat'>Copy to clipboard</a>");
						jQuery(_tR).append(_tD2);
						jQuery(_tBody1).append(_tR);						
						jQuery(_tBody1).append(_priorArt);
					}
					/*End Prior Art Embedding Code*/					
					jQuery(_tableEmbed).append(_tBody);
					
					_tableShareEmbed = jQuery("<table/>").attr("id",'embedTable1').addClass("table");
					jQuery(_tableShareEmbed).append(_tBody1);
					_expertCreateReport = jQuery('<div/>').addClass('span12').addClass('noMargin').append("<a  class='btn btn-flat pull-right' href='javascript:void(0);'onclick='expertStartWorking(\""+n+"\");' style=''>Tech expert, click to start working on this project</a>");
					jQuery("#embedTable").html("<h3 class='span12 m_title noMargin'>"+n+"</h3>").find('h3').css('margin-bottom','0px').after(_tableEmbed);jQuery("#embedTable").append(_expertCreateReport);
					jQuery("#embedTable").find('h3').before("<div class='span12 '>If you would like to receive an email alert each time an expert report is created under this project, please enter your email &nbsp; <input type='text' name='user_email_address' id='user_email_address' style='width:315px;'/>  <a  class='btn btn-flat' href='javascript:void(0);'onclick='sendAlert();' style='margin-top:-10px;'>Send Alert</a></div>");
					jQuery("#shareCode").empty().append(_tableShareEmbed);
					<?php 
						$result = $articleModel->getItem(92);
						$text = "<p></p>";
						$title = "";
						if(count($result)>0 && !empty($result->introtext)){
							$text = $result->introtext;
							$title = $result->title;
						}
					?>
					__EmbedCodeTitle = '<?php echo $title;?>';
					__EmbedCodeText = '<?php echo $text;?>';
														
														
					jQuery("#embedTable1").find('td#embed_code').append('<div class="moduletable span12 " id="mod258" data-id="258" style="margin-bottom:30px;">'+
										'<div class="bghelper">'+
											'<div class="modulecontent">'+
												'<div class="custom ">'+
													'<div class="span12">'+
														'<h3 class="m_title" style="margin-top:25px">'+__EmbedCodeTitle+'</h3>'+
														__EmbedCodeText+
													'</div>'+
												'</div>'+
											'</div>'+
										'</div>'+									
									'</div>');
					jQuery("#embedCode").css('display','block');
					jQuery("#rssFeed").attr('href',__SiteURL+'index.php?option=com_survey&view=customer&p_d='+jQuery("#projectList li a.active").attr('data-id')+'&format=feed&type=rss');
					jQuery(document).ready(function(){
						jQuery('a.embed').clipboard({
							path:'<?php echo JUri::base();?>templates/kallyas/js/jquery.clipboard.swf',
							copy:function(){
								var this_sel = jQuery(this);
								return this_sel.parent().find('textarea[name="iframeLink"]').val();
							},
							afterCopy:function(){
								alert("Copied");
							}
						});
						jQuery('a.link').clipboard({
							path:'<?php echo JUri::base();?>templates/kallyas/js/ZeroClipboard.swf',
							copy:function(){
								var this_sel = jQuery(this);
								return this_sel.parent().find('textarea[name="iLink"]').val();
							},
							afterCopy:function(){
								alert("Copied");  
							} 
						});
					});
				} else {
					jQuery(_HTML).append("<li>No record found</li>");	
				}				
				jQuery("#survey").append(_HTML);
				jQuery('.loader').css('display','none');
			}	
			});
		}
	}
								
								
							
	function qu(object,su){
		/*__PPURL ="https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_xclick&notify_version=2.9&business=";*/
		__PPURL ="<?php echo $paypalURL;?>&business=";
		__SU = parseInt(su);
		jQuery("#surveylist li a").removeClass('active');
		jQuery('.showError').css('display','none')
		object.find('a').addClass('active');
		if(__SU!=0 && __SU!='NAN' &&  __SU!='NAN'){
		
			jQuery("#questionlist").parent().remove();
			jQuery("#questionlist").remove();
			jQuery("#expertList").parent().remove();
			jQuery("#expertList").remove();		
			jQuery('.loader1').css('display','block');
			jQuery.ajax({
			url:__SiteURL+'index.php?option=com_survey&task=customer.quList',	
			data:{ps:__SU,format:''},
			cache:false,
			success:function(html){
				__data = jQuery.parseJSON(html);
				jQuery("#questionlist").remove();
				jQuery("#expertList").remove();
				__GRID2Div = jQuery('<div/>').addClass('span5 noMarginLeft');
				__GRID5Div = jQuery('<div/>').addClass('grid_6 alpha omega');
				__LegendGrid2 = jQuery('<legend/>').addClass('noMargin smallm_title').append('Elements').css({height:'53px',fontWeight:'bold',whiteSpace:'wrap',paddingLeft:'8px',borderBottom:'1px solid #e5e5e5'});				
				jQuery(__GRID2Div).append(__LegendGrid2);				
				_HTML = jQuery('<table/>').attr('id','questionlist').addClass('table');
				__ETable = jQuery("<table/>").attr('id','expertList').addClass('table result-table').css('background','none').css('margin-top','0px');
				__GRID10Div = jQuery('<div/>').addClass('span7').css({overflowX:'scroll',margin:'0'});
				__GRID7Div = jQuery('<div/>').addClass('grid_6').css({overflowX:'scroll',margin:'0'});
				if(__data['question'].length>0){
					/*Embed code Table*/					
					jQuery('.help-block').css('display','block');
					for(i=0;i<__data['question'].length;i++){
						_QueThread = jQuery("<thead/>");							
						if(i==(__data['question'].length-1)){
							_MAINTR = jQuery("<tr/>").data('quData',__data['question'][i]);
						} else {
							_MAINTR = jQuery("<tr/>").data('quData',__data['question'][i]);
						}							
						_TH = jQuery("<th/>").append(__data['question'][i]['data'].description);
						jQuery(_MAINTR).append(_TH);
						jQuery(_QueThread).append(_MAINTR);
						jQuery(_HTML).append(_QueThread);
						if(i==0){ 
							
							_Thead = jQuery("<thead/>");
							/*_TR = jQuery("<tr/>").css({borderBottom:'1px solid #E5E5E5'});	*/							
							_TR = jQuery("<tr/>");								
							for(s=0;s<__data['expert'].length;s++){
								if(__data['expert'][s].linkedin_profile_url==""){
									jQuery(_TR).append("<th valign='top' class=' smallm_title "+__data['expert'][s].id+"' style='text-align:center;height:33px;'><a target='_BLANK' href='"+__SiteURL+"index.php?option=com_survey&task=customer.expertProfile&display="+__data['expert'][s].id+"'>"+__data['expert'][s].name+"</a></th>");
								} else {
									jQuery(_TR).append("<th valign='top' class='smallm_title "+__data['expert'][s].id+"' style='text-align:center;height:33px;'><a target='_BLANK' href='"+__SiteURL+"index.php?option=com_survey&task=customer.expertProfile&display="+__data['expert'][s].id+"'>"+__data['expert'][s].name+"</a></th>");
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
													__class="s_star_1_0";
												} else if(($calcRating>1 && $calcRating<1.5) || ($calcRating>1.5 && $calcRating<2)){
													__class="s_star_1_5";
												} else if($calcRating==2){
													__class="s_star_2_0";
												} else if(($calcRating>2 && $calcRating<2.5) || ($calcRating>2.5 && $calcRating<3)){
													__class="s_star_2_5";
												} else if($calcRating==3){
													__class="s_star_3_0";
												} else if(($calcRating>3 && $calcRating<3.5) || ($calcRating>3.5 && $calcRating<4)){
													__class="s_star_3_5";
												} else if($calcRating==4){
													__class="s_star_4_0";
												} else if(($calcRating>4 && $calcRating<4.5) || ($calcRating>4.5 && $calcRating<5)){
													__class="s_star_4_5";
												} else if($calcRating==5){
													__class="s_star_5_0";
												}
												if(jQuery("."+expertID).find('.swSprite').length==0){
													jQuery("."+expertID).append('<br/><label title="'+$calcRating+' out of 5 stars" class="swSprite '+__class+'"></label>');
												}
											} else {
												_class="s_star_0_0";
												if(jQuery("."+expertID).find('.swSprite').length==0){
													jQuery("."+expertID).append('<br/><label title="0 out of 5 stars" class="swSprite '+_class+'"></label>');
												}
											}
										} else {
											_class="s_star_0_0";
											if(jQuery("."+_ratingData.id).find('.swSprite').length==0){
												jQuery("."+_ratingData.id).append('<br/><label title="0 out of 5 stars" class="swSprite '+_class+'"></label>');
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
										 if (__data['expert'][s].id == __data['question'][i]['answer'][an].expert_id && (__data['expert'][s].target == __data['question'][i]['answer'][an].target) && (__data['expert'][s].target_product == __data['question'][i]['answer'][an].target_product)) {
											__DipTo = 1;
											if(__data['question'][i]['answer'][an].status==1){
												_TD = jQuery("<td/>").addClass('aCenter').append('<i class="icon-ok aCenter"> </i>');
											} else {
												_TD = jQuery("<td/>").addClass('aCenter');
											}
											__parseFlag = 1;
											jQuery(__TR).append(_TD);
										}
									}									
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
										 if ((__data['expert'][s].id == __data['survey'][am].expert_id) && (__data['expert'][s].target == __data['survey'][am].target) && (__data['expert'][s].target_product == __data['survey'][am].target_product)) {
											__DIP2 = 1;
											__SUR = __data['survey'][am].survey_id;
											__EXP = __data['expert'][s].id;
											_TD = jQuery("<td/>").css('background','none').addClass('aCenter').data('expertAmount',__data['survey'][am].amount).append('<span class="dM"><b>'+__data['survey'][am].target+'</b></span><br/><span class="dM"><b>'+__data['survey'][am].target_product+'</b></span><br/><span class="dM"><b>$'+__data['survey'][am].amount+'</b></span><br/>');									
											__A = jQuery("<a/>").addClass('btn btn-flat').attr('data-expertID',__data['expert'][s].id).attr('data-target',__data['survey'][am].target).attr('data-target_product', __data['survey'][am].target_product).data('expertEmail',__data['expert'][s].paypal_id).click(function(){
																																						_TTHISS = jQuery(this);
																																						_TTHISS.attr('disabled',true);
																																						__cEM = jQuery(this).data('expertEmail');
																																						__target = jQuery(this).attr('data-target');
																																						 __target_product = jQuery(this).attr('data-target_product');
																																						__expertID = jQuery(this).attr('data-expertID');  
																																						__amTT = jQuery(this).parent().data('expertAmount');
																																						//alert(__expertID);
																																						jQuery.ajax({
																																						url:__SiteURL+'index.php?option=com_survey&task=customer.transaction',
																																						data:{amt:__amTT,su:__SUR,ex:__expertID,target:__target,target_product:__target_product,format:''},
																																						cache:false,
																																						success:function(data){
																																							if(data>0){
																																								__ram = data;
																																								__PPURL = __PPURL+__cEM+"&lc=US&item_name=Purchase Report&amount="+__amTT+"&currency_code=USD&item_number="+__ram+"&notify_url=<?php echo urlencode(JUri::base().'index.php?option=com_survey&task=customer.notify&raw=');?>"+__ram+"&return=<?php echo urlencode(JUri::base().'index.php?option=com_survey&task=customer.success&raw=');?>"+__ram+"&cancel=<?php echo urlencode(JUri::base().'index.php?option=com_survey&task=customer.cancel&raw=');?>"+__ram;
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
					jQuery(_HTML).append('<thead><tr><th>No record found!</th></tr></thead>');		
					__ETable ='';
					__GRID10Div = jQuery('<div/>');
				}
				
				jQuery(__GRID2Div).append(_HTML);
				
				jQuery(__GRID10Div).append(__ETable);
				_WIDTH = jQuery("#question").width();
				jQuery("#question").append(__GRID2Div).append(__GRID10Div);
				jQuery("#question").parent().css('width',_WIDTH+'px');
				_questionWidth = _WIDTH * 40.17094017094017/100;
				_ansWidth = _WIDTH * 57.26495726495726/100;
				jQuery("#question").find('.span5').css({width:_questionWidth+'px',float:'left'});
				jQuery("#question").find('.span7').css({width:_ansWidth+'px',float:'left'});
				/*Change height for the Questions*/
					jQuery('#questionlist>thead').each(function(index){
							_height = jQuery(this).height();		
							jQuery("#expertList>tbody>tr").eq(index).css('height',_height+'px');		
					});
					/*End Change height for the Questions*/
				jQuery('.loader1').css('display','none');
			}
			});
		}
	}
	function expertStartWorking(project){
		window.location=__SiteURL+'profile?start='+project;
	}
		jQuery(document).ready(function(){
			
			u = window.location.href;
			q = u.split("?");
			if(q.length==2 && q[1]!=undefined && q[1]!=""){
				jQuery.ajax({
					url:__SiteURL+'index.php?option=com_survey&task=customer.sucess_payment',
					type:'POST',
					data:{p:q[1],format:''},
					dataType: 'json',
					cache:false,
					success:function(data){
						if(data.data.length>0){
							_codes="";
							for(i=0;i<data.data.length;i++){
								_codes +=data.data[i].code + ", ";
							}
							if(_codes!=""){
								_codes = _codes.substring(0,_codes.length-2);
								jQuery("#sharingContent").removeClass("hidden").addClass("show");
								newText = __orgText;
								newText = newText.replace("#CODES#",'<?php echo JUri::base()?>?'+q[1]);
								jQuery("#sharing_data").val(newText);
								jQuery("#sharing_title").val(__title);
								
							} else{
								jQuery("#sharingContent").removeClass("show").addClass("hidden");
							}
						}
					}
				});
			}
		});
			
						
							</script>
							</div>
							<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3 id="myModalLabel">HTML Embed code</h3>
  </div>
  <div class="modal-body">
    <textarea style='width:490px; height:60px' onclick="this.select();" ></textarea>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
  </div>
</div>

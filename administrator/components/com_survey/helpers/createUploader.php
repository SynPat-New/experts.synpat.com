<?php
/**
 * @copyright   (C) 2010 iJoomla, Inc. - All rights reserved.
 * @license  GNU General Public License, version 2 (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author  iJoomla.com <webmaster@ijoomla.com>
 * @url   http://www.ijoomla.com/licensing/
 * the PHP code portions are distributed under the GPL license. If not otherwise stated, all images, manuals, cascading style sheets, and included JavaScript  *are NOT GPL, and are released under the IJOOMLA Proprietary Use License v1.0 
 * More info at http://www.ijoomla.com/licensing/
*/
	defined ('_JEXEC') or die ("Go away.");
	$max_upload 	= (int)(ini_get('upload_max_filesize'));
	$max_post 		= (int)(ini_get('post_max_size'));
	$memory_limit 	= (int)(ini_get('memory_limit'));
	$upload_mb 		= min($max_upload, $max_post, $memory_limit);
	if($upload_mb == 0) {$upload_mb = 10;}
	$upload_mb*=1048576; //transform in bytes
	$doc = &JFactory::getDocument();
	$doc->addScript('components/com_guru/js/jquery-1.4.2.min.js');
	
	//start images
	$doc->addScriptDeclaration('
		jQuery.noConflict();
		jQuery(function(){
			function createUploader(){            
				var uploader = new qq.FileUploader({
					element: document.getElementById(\'imageUploader\'),
					action: \'components/com_guru/helpers/fileuploader.php\',
					params:{
						folder:\'media\',
						mediaType:\'image\',
						size: document.getElementById(\'media_fullpx\').value,
						type: document.getElementById(\'media_prop\').value
					},
					onSubmit: function(id,fileName,folder){
						jQuery(\'.qq-upload-list li\').css(\'display\',\'none\');
					},
					onComplete: function(id,fileName,responseJSON){
						//alert(responseJSON.success);
						//alert(\'id: \'+ id + \'; filename:\' + fileName);
						//if(responseJSON.success == true){
							jQuery(\'.qq-upload-success\').append(\'- <span style="color:#387C44;">Upload successful</span>\');
							//if(responseJSON.locate) {
								//jQuery(\'#view_imagelist23\').attr("src", "../"+responseJSON.locate +"/"+ fileName);
								jQuery(\'#view_imagelist23\').attr("src", "../"+responseJSON.locate +"/"+ fileName+"?timestamp=" + new Date().getTime());
								jQuery(\'#image\').val("/"+ fileName);
								jQuery(\'#is_image\').val("1");
							//}
						//}
					},
					allowedExtensions: [\'jpg\', \'jpeg\', \'png\', \'gif\', \'JPG\', \'JPEG\', \'PNG\', \'GIF\'],
					sizeLimit: '.$upload_mb.',
					multiple: false,
					maxConnections: 1
				});           
			}
			createUploader();
		});
	');
	//end images
	
	//start video
	$doc->addScriptDeclaration('
		jQuery.noConflict();
		jQuery(function(){
			function createUploader(){            
				var uploader = new qq.FileUploader({
					element: document.getElementById(\'videoUploader\'),
					action: \'components/com_guru/helpers/fileuploader.php\',
					params:{
						mediaType:\'video\'
					},
					onSubmit: function(id,fileName,folder){
						jQuery(\'.qq-upload-list li\').css(\'display\',\'none\');
					},
					onComplete: function(id,fileName,responseJSON){
						//alert(responseJSON.success);
						//alert(\'id: \'+ id + \'; filename:\' + fileName);
						//if(responseJSON.success == true){
							jQuery(\'.qq-upload-success\').append(\'- <span style="color:#387C44;">Upload successful</span>\');
							//if(responseJSON.locate) {
								jQuery(\'#localfile\').append("<option value=\'"+responseJSON.locate +"/"+ fileName+"\' selected=\'selected\'>"+ fileName+"</option>");
								jQuery(\'#source_local_v2\').val(\'local\');
								jQuery(\'#source_local_v2\').attr("checked", "checked");
								jQuery(\'#source_code_v\').attr("checked", "");
								jQuery(\'#source_url_v\').attr("checked", "");
							//}
						//}
					},
					allowedExtensions: [\'ax\', \'amv\', \'asf\', \'gif\', \'avi\', \'mp4\', \'fla\', \'swf\', \'mov\' , \'mpg\', \'mpeg\', \'rm\'],
					sizeLimit: '.$upload_mb.',
					multiple: false,
					maxConnections: 1
				});           
			}
			createUploader();
		});
	');
	//end video
	
	//start audio
	$doc->addScriptDeclaration('
		jQuery.noConflict();
		jQuery(function(){
			function createUploader(){            
				var uploader = new qq.FileUploader({
					element: document.getElementById(\'audioUploader\'),
					action: \'components/com_guru/helpers/fileuploader.php\',
					params:{
						mediaType:\'audio\'
					},
					onSubmit: function(id,fileName,folder){
						jQuery(\'.qq-upload-list li\').css(\'display\',\'none\');
					},
					onComplete: function(id,fileName,responseJSON){
						//alert(responseJSON.success);
						//alert(\'id: \'+ id + \'; filename:\' + fileName);
						//if(responseJSON.success == true){
							jQuery(\'.qq-upload-success\').append(\'- <span style="color:#387C44;">Upload successful</span>\');
							//if(responseJSON.locate) {
								jQuery(\'#localfile_a\').append("<option value=\'"+ fileName+"\' selected=\'selected\'>"+ fileName+"</option>");
								jQuery(\'#source_local_a2\').val(\'local\');
								jQuery(\'#source_local_a2\').attr("checked", "checked");
							//}
						//}
					},
					allowedExtensions: [\'aac\', \'aob\', \'ada\', \'au\', \'mid\', \'midi\', \'mp3\', \'ogg\', \'wav\'],
					sizeLimit: '.$upload_mb.',
					multiple: false,
					maxConnections: 1
				});           
			}
			createUploader();
		});
	');
	//end audio
	
	//start docs
	$doc->addScriptDeclaration('
		jQuery.noConflict();
		jQuery(function(){
			function createUploader(){            
				var uploader = new qq.FileUploader({
					element: document.getElementById(\'docUploader\'),
					action: \'components/com_guru/helpers/fileuploader.php\',
					params:{
						mediaType:\'doc\'
					},
					onSubmit: function(id,fileName,folder){
						jQuery(\'.qq-upload-list li\').css(\'display\',\'none\');
					},
					onComplete: function(id,fileName,responseJSON){
						//alert(responseJSON.success);
						//alert(\'id: \'+ id + \'; filename:\' + fileName);
						//if(responseJSON.success == true){
							jQuery(\'.qq-upload-success\').append(\'- <span style="color:#387C44;">Upload successful</span>\');
							//if(responseJSON.locate) {
								jQuery(\'#localfile_d\').append("<option value=\'"+ fileName+"\' selected=\'selected\'>"+ fileName+"</option>");
								jQuery(\'#source_local_d2\').val(\'local\');
								jQuery(\'#source_local_d2\').attr("checked", "checked");
							//}
						//}
					},
					allowedExtensions: [\'doc\', \'docx\', \'txt\', \'pdf\', \'csv\', \'htm\', \'html\', \'xhtml\', \'xml\', \'sxw\', \'rtf\', \'odt\', \'css\', \'odp\', \'pps\', \'ppt\', \'sxi\'],
					sizeLimit: '.$upload_mb.',
					multiple: false,
					maxConnections: 1
				});           
			}
			createUploader();
		});
	');
	//end docs
	
	//start file
	$doc->addScriptDeclaration('
		jQuery.noConflict();
		jQuery(function(){
			function createUploader(){            
				var uploader = new qq.FileUploader({
					element: document.getElementById(\'fileUploader\'),
					action: \'components/com_guru/helpers/fileuploader.php\',
					params:{
						mediaType:\'file\'
					},
					onSubmit: function(id,fileName,folder){
						jQuery(\'.qq-upload-list li\').css(\'display\',\'none\');
					},
					onComplete: function(id,fileName,responseJSON){
						//alert(responseJSON.success);
						//alert(\'id: \'+ id + \'; filename:\' + fileName);
						//if(responseJSON.success == true){
							jQuery(\'.qq-upload-success\').append(\'- <span style="color:#387C44;">Upload successful</span>\');
							//if(responseJSON.locate) {
								jQuery(\'#localfile_f\').append("<option value=\'"+ fileName+"\' selected=\'selected\'>"+ fileName+"</option>");
								jQuery(\'#source_local_f2\').val(\'local\');
								jQuery(\'#source_local_f2\').attr("checked", "checked");
							//}
						//}
					},
					allowedExtensions: [\'exe\', \'zip\'],
					sizeLimit: '.$upload_mb.',
					multiple: false,
					maxConnections: 1
				});           
			}
			createUploader();
		});
	');
	//end file
	
	
	
	$doc->addScript('components/com_guru/js/fileuploader.js');
	$doc->addStyleSheet('components/com_guru/css/fileuploader.css');
	
	?>


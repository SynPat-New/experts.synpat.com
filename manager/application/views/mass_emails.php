<?php 
	/*echo "<pre>";
	print_r($claims);
	print_r($experts);*/
?>
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl;?>public/widgets/tooltip/tooltip.css">
<script type="text/javascript" src="<?php echo $Layout->baseUrl;?>public/widgets/tooltip/tooltip.js"></script>
<script type="text/javascript" src="<?php echo $Layout->baseUrl;?>public/widgets/summernote-wysiwyg/summernote-wysiwyg.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl;?>public/widgets/summernote-wysiwyg/summernote-wysiwyg.css"/>
<script type="text/javascript" src="<?php echo $Layout->baseUrl;?>public/widgets/datatable/datatable.js"></script>
<script type="text/javascript" src="<?php echo $Layout->baseUrl;?>public/widgets/datatable/datatable-bootstrap.js"></script>
<script type="text/javascript" src="<?php echo $Layout->baseUrl;?>public/widgets/datatable/datatable-tabletools.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl; ?>public/widgets/slidebars/slidebars.css">
<script type="text/javascript">

	__tt = "";
    $(document).ready(function() {
        $('#datatable-claims').dataTable({
            "scrollY": "500px",
            "paging": false,
			"language": {
				"emptyTable":     "No expert found!"
			}
        });
		__tt = $('#datatable-experts').dataTable({
            "scrollY": "500px",
            "paging": false
        });
		$('#summernote').summernote({
			height: 250, 
			
		});
		$('.dataTables_filter input').attr("placeholder", "Search...");
		
    });
	_stack=0;
	function findExpertWithCode(){
	   var site_url = '<?php echo site_url(); ?>';
		if(jQuery("#expertise_code").val()==""){
			alert('Please enter expertise code.');	
		}	else {
			jQuery("#found_expert").html('Loading...');
			jQuery.ajax({
				url:site_url+'api/findExpertWithCode',
				type:'POST',
				data:{code:jQuery("#expertise_code").val(),mode:2},
				dataType:"json",
				cache:false,
				success: function(data){					
						/*Implement table with list of Expertise Under this code.*/
					__tt.fnDestroy();
					_htmlCode ="";		
					for(i=0;i<data.count.length;i++){
						 _stack = 1;
						_htmlCode +='<tr><td><input type="checkbox" name="selected_expert[]" checked="checked" id="selected_expert['+data.count[i].expert_id+']" value="'+data.count[i].expert_id+'"/></td>';
						_htmlCode +='<td>'+data.count[i].name+'</td>';
						_htmlCode +='<td>'+data.count[i].email+'</td>';
						_htmlCode +='</tr>';
					}
					jQuery("#datatable-experts").find("tbody").empty().append(_htmlCode);
					__tt = $('#datatable-experts').dataTable({
						"scrollY": "500px",
						"bDestroy": true,
						"paging": false
					});
					jQuery("#found_expert").html('');
				}	
			});	
		}
	}
	
	function getAll(){
		jQuery("#found_expert").html('Loading...');
		jQuery.ajax({
			url:'<?php echo site_url(); ?>api/getAllExperts',
			type:'POST',
			dataType:"json",
			cache:false,
			success: function(data){					
					/*Implement table with list of Expertise Under this code.*/
				__tt.fnDestroy();
				_htmlCode ="";	
				_stack = 0;
				for(i=0;i<data.length;i++){					 
					_htmlCode +='<tr><td><input type="checkbox" name="selected_expert[]" checked="checked" id="selected_expert['+data[i].expert_id+']" value="'+data[i].expert_id+'"/></td>';
					_htmlCode +='<td>'+data[i].name+'</td>';
					_htmlCode +='<td>'+data[i].email+'</td>';
					_htmlCode +='</tr>';
				}
				jQuery("#datatable-experts").find("tbody").empty().append(_htmlCode);
				__tt = $('#datatable-experts').dataTable({
					"scrollY": "500px",
					"bDestroy": true,
					"paging": false
				});
				jQuery("#found_expert").html('');
			}	
		});	
	}
	function addTemplate(){
		console.log($("#summernote").code());
		if(jQuery("#subject").val()!=""){
			jQuery.ajax({
				type:"POST",
				url:'<?php echo site_url(); ?>api/addTemplate',
				data:{te:$("#summernote").code(),s:jQuery("#subject").val()},
				dataType:"json",
				cache:false,
				success: function(data){	
					if(data.length>0){
						jQuery("#template_list").find("tbody").empty();
						s=1;
						for(j=0;j<data.length;j++){
							delete window["temp"+j];
							window["temp"+s] = [data[j]];
							jQuery("#template_list").find("tbody").append("<tr><td><a href='javascript://' onclick='getTemplate("+data[j].id+")'>"+data[j].subject+"</a></td></tr>");
							s++;
						}
					}
				}
			});
		}
	}
	function getTemplate(c){
		$("#summernote").code(window["temp"+c][0].templates);
		$("#subject").val(window["temp"+c][0].subject);
	}
	function validateCode(){
		if(jQuery("input[name='selected_expert[]']:checked").length>0){
			return true;
		} else {
			alert("Please enter expert code and find expert.");
			return false;
		}
		/*if(_stack==0){
			alert("Please enter expert code and find expert.");
		}*/
	}
	function selectAll(o){
		if(o.is(':checked')){
			jQuery("#datatable-experts").find('input[type="checkbox"]').prop('checked',true);
		} else {
			jQuery("#datatable-experts").find('input[type="checkbox"]').prop('checked',false);
		}
	}
	function openPopupForExpertise(){
		objBar = jQuery("#dv_slidebars");
		objBar.find('iframe').attr('src','<?php echo site_url() ?>api/area_of_expertise');
		if(objBar.hasClass('sb-width-custom')){
			objBar.addClass('show').css('margin-right','0px');
		}
	}
	function closeSlideBar(obj){
		objBar = jQuery("#dv_slidebars");
		objBar.addClass('hide').removeClass('show').css('margin-right','-'+objBar.data('width')+'px');
	}
</script>
<div id="page-title">
    <h2>Mass Emails</h2>
    <p></p>
</div>
<div class="panel">
	<div class="panel-body">	
		<div class="example-box-wrapper">
			<p>
				Instructions:<br/>
				1. From the Claim List - select the claim.<br/>
				2. Select the experts you wish to invite.<br/>
				3. Select the template message you wish to use to invite the experts. You may use #NAME# to automatically refer to the expert name and #LINK# to a link to the project of the selected claim.<br/>
			</p>
		</div>
		<form action="<?php echo site_url() ?>api/sendMassEmail" method="post" name="adminForm" onsubmit="return validateCode();">
		<div class="example-box-wrapper">	
			<div class="row">
				<div class="col-lg-8">
					<div class="row">
						<div class="col-lg-12">
							<input type="text" id="subject" name="subject" placeholder="Subject" class="form-control"/>
						</div>
						<div class="col-lg-12 mrg10T">
							<textarea id="summernote" name="email_message"></textarea>
						</div>
						<div class="col-lg-12 mrg10T">
							<button type="button" onclick="addTemplate()">Create  Template</button>
							<button type="submit">Send Email</button>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<h4>Template List</h4>
					<table id="template_list">
						<tbody>
							<?php
								$templates = json_decode($templates);
								foreach($templates as $template){
							?>
								<script>
									window.temp<?php echo $template->id?> = [<?php echo json_encode($template);?>];
								</script>
								<tr>
									<td><a href='javascript://' onclick="getTemplate(<?php echo $template->id?>)"><?php echo $template->subject;?></a></td>
								</tr>
							<?php
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>		
		<div class="example-box-wrapper">
			<div class="row">				
				<div class="col-lg-5">
					<h4>Experts List</h4>
					<div class="controls mrg20B">
						<label>Expertise Code:</label>
						<input type="text" name="expertise_code" id="expertise_code"/><input type="button" class="mrg5L" name="find_expert" value="Find" onClick="findExpertWithCode();"/> <input type="button" class="mrg5L" name="get_all" value="All" onClick="getAll();"/> <input type="button" class="mrg5L" name="get_all" value="Get Expertise Code" onClick="openPopupForExpertise();"/>
					</div>
					<div id="found_expert"></div>   
					<label>Select all: <input type='checkbox' onclick='selectAll(jQuery(this))'/></label>
					<table class="table table-striped table-bordered dataTable no-footer " id="datatable-experts">
						<thead>
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Email</th>
							</tr>
						</thead>
						<tbody>
							<?php 
								$experts= json_decode($experts);
								if(count($experts)>0){
									for($i=0;$i<count($experts);$i++){
							?>
								<tr>
									<td><input type="checkbox"  name="selected_expert[]" id="selected_expert[<?php echo $experts[$i]->id;?>]" value="<?php echo $experts[$i]->id;?>"/></td>
									<td><?php echo $experts[$i]->name?></td>
									<td><?php echo $experts[$i]->email?></td>
								</tr>
							<?php
									}
								} else {
							?>
							<tr>
								<td colspan="2"><p class="alert alert-info">No list found</p></td>
							</tr>
							<?php
								}
							?>
						</tbody>
					</table>					
				</div>
				<div class="col-lg-7">
					<h4>Claims List</h4>
					<div class='col-lg-12' style='margin-top:43px;'></div>
					<table class="table table-striped table-bordered dataTable no-footer " id="datatable-claims">
						<thead>
							<tr>
								<th>#</th>
								<th>Claim</th>
								<th>Order_name</th>
							</tr>
						</thead>
						<tbody class="table">
							<?php 
								$claims= json_decode($claims);
								if(count($claims)>0){
									for($i=0;$i<count($claims);$i++){
										$surveyID = $this->uri->segment(3);
							?>
								<tr>
									<td valign="top"><input type="radio" <?php if($surveyID==$claims[$i]->id):?> CHECKED='CHECKED'<?php endif;?> name="survey_id" id="survey_id[<?php echo $claims[$i]->id;?>]" value="<?php echo $claims[$i]->id;?>"/></td>
									<td valign="top"><?php echo $claims[$i]->combine_name?></td>
									<td valign="top"><?php echo $claims[$i]->project_name?></td>
								</tr>
							<?php
									}
								} else {
							?>
							<tr>
								<td colspan="2"  valign="top"><p class="alert alert-info">No list found</p></td>
							</tr>
							<?php
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>	
		</form>
	</div>   
</div>

<div class="sb-slidebar bg-white sb-right sb-style-overlay sb-width-custom" data-width='1000px' id="dv_slidebars"  style='width:1000px;'>
	<div class="scrollable-content scrollable-slim-sidebar">
		<div class="pad15A">
			<a href='javascript://' onclick='closeSlideBar(jQuery(this))'>Close</a>
			<iframe src="about:html" style="width:1000px;height:450px;" scrolling="yes" border='0px'></iframe>
		</div>
	</div>
</div>
<?php
$obj = array();
if(!empty($get_data)){
	$obj = json_decode($get_data);
}
$surveyID = $this->uri->segment(3);
$combineName = "";
if(count($obj)>0){
	if(isset($obj[0])){
		$combineName = $obj[0]->survey_detail->combine_name;
	}
}
?>

<a href="<?php echo site_url() ?>api/start_questionare/<?php echo $surveyID ?>" class="btn  btn-info pull-left mrg5B" style='padding-left:0px;'>Start/Edit Questionare</a>
<h2 class='pull-left' style='width:100%;'><?php echo $combineName; ?></h2>
<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
    <thead>
		<tr>
			<th>#</th>
			<th>Elements</th>               
		</tr>
	</thead>
	<tbody>
		<?php
			$i=1;
			foreach($obj as $k=>$v)  {        
		?>
		<tr>
			<td>
				 <?php echo $i; ?> 
			</td>
			<td>
				<?php echo $v->description; ?> 
			</td>
		</tr>
		<?php
			$i = $i+1;
		}
		?>
	</tbody>
</table>
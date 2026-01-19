<?php 
$user_activity = $this->user_activity;
$getActivityData = $user_activity['getActivityData'];
$getActivityCombineData = $user_activity['getActivityCombineData'];
$getActivityTiming = $user_activity['getActivityTiming'];
if(count($getActivityData)>0){
?>

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
  google.charts.load("current", {packages:["timeline"]});
  google.charts.setOnLoadCallback(drawChart);
  function drawChart() {

    var container = document.getElementById('example5.1');
    var chart = new google.visualization.Timeline(container);
    var dataTable = new google.visualization.DataTable();
    dataTable.addColumn({ type: 'string', id: 'Room' });
    dataTable.addColumn({ type: 'string', id: 'Name' });
    dataTable.addColumn({ type: 'date', id: 'Start' });
    dataTable.addColumn({ type: 'date', id: 'End' });
    dataTable.addRows([
		<?php 
			$i=0;
			foreach($getActivityData as $activity){
				$i++;
				$sY = date('Y',strtotime($activity->start_time));
				$sM = date('m',strtotime($activity->start_time)) - 1;
				$sD = date('d',strtotime($activity->start_time));
				$sH = date('H',strtotime($activity->start_time));
				$sI = date('i',strtotime($activity->start_time));
				$sS = date('s',strtotime($activity->start_time));
				
				$eY = date('Y',strtotime($activity->end_time));
				$eM = date('m',strtotime($activity->end_time)) - 1;
				$eD = date('d',strtotime($activity->end_time));
				$eH = date('H',strtotime($activity->end_time));
				$eI = date('i',strtotime($activity->end_time));
				$eS = date('s',strtotime($activity->end_time));
				echo "[ '".addslashes(str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),' ',$activity->description))."','".$i."', new Date(".$sY.",".$sM.",".$sD.",".$sH.",".$sI.",".$sS."),  new Date(".$eY.",".$eM.",".$eD.",".$eH.",".$eI.",".$eS.") ]";
				if($i<count($getActivityData)){
					echo ",";
				}
			}
		?>
	  ]);

    var options = {
      timeline: { showRowLabels: true }
    };

    chart.draw(dataTable, options);
  }

</script>
<!--<div class='container'>-->
<div class="row" style='margin-left:20px;'>
<div class='col-lg-12' style='margin-top:20px;'>
<div id="example5.1" style="height:150px;width:837px;"></div>
</div>
<div class='col-md-6'>
<table class='table table-condensed table-striped table-bordered table-hover'>
	<thead>
		<tr>
			<th>Asset Number</th>
			<th>Time spent (HH:mm)</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			$i=0;
			foreach($getActivityCombineData as $time){
				list($hour,$minute,$second) = explode(':', $time->duration);
				$timeShow =  sprintf('%02d:%02d', $hour, $minute); 
		?>
			<tr>
				<td><?php echo $time->description;?></td>
				<td><?php echo $timeShow;?></td>
			</tr>
		<?php
				$i++;
			}
		?>  
		<tr>
			<td>Total Time Spent</td>
			<td><?php
				list($hour,$minute,$second) = explode(':', $getActivityTiming);
				$timeShow =  sprintf('%02d:%02d', $hour, $minute); 
				echo $timeShow;?></td>
		</tr>
	</tbody>
</table>
</div>
</div><!--</div>-->
	<?php } else {?>
	No activty found!
	<?php }
?>

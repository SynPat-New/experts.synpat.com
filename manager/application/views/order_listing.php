<table class="table">
    <tr>
        <th>#</th>
        <th>Ordered </th>
        <th>Specific Expert</th>
        <th>Paypal </th>
        <th>Deadline</th>
        <th>Project </th>
        <th># Of Claims</th>
        <th>Order Comment </th>
        <th>Questionares Prepared </th>
        <th>In Process </th>
        <th>Submitted </th>
    </tr>
    <?php
    $obj = json_decode($get_data);
	if(count($obj)):
    foreach($obj as $k=>$v)
    {
   ?>
    <tr>
        <td><?php echo $v->id; ?></td>
        <td><?php echo date('M d, Y',strtotime($v->create_date));?></td>
         <td><?php echo $v->specific_expert; ?></td>
         <td><?php echo $v->success; ?> </td>
         <td><?php echo date('M d, Y',strtotime($v->deadline)); ?></td>
         <td>
            <a href="<?php echo $v->id; ?>">
                <?php echo $v->projectName; ?>
            </a>
        </td>
         <td><?php echo $v->survey_id; ?></td>
         <td><?php echo $v->description; ?></td>
         <td><?php echo $v->Questionares_prepared; ?></td>
         <td><?php echo $v->cc_in_process; ?></td>
         <td><?php echo $v->cc_submitted; ?></td>
    </tr>
    <?php
     }
	 endif;
    ?>
</table>
<h2>Projects</h2>
<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
	<thead>
    <tr>
        <th>
            # 
        </th>
        <th>
            <input type="checkbox" name="click" value=""/>
        </th>
        <th>
            Project Name  
        </th>
        <th>
            Description 
        </th>
        <th>
            Project Image  
        </th>
        <th>
            Project Survey List 
        </th>
        <th>
            Project ID  
        </th>
    </tr>
	</thead>
	<tbody>
    <?php
    $obj = json_decode($get_data);
    foreach($obj as $k=>$v)
    {
       // echo '<pre>';
      //  print_r($obj[$k]);
       // die;
   ?>
    <tr>
        <td>
            <?php echo $v->id; ?>
        </td>
        <td>
            <input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($obj); ?>);"/>
        </td>
        <td>
            <?php echo $v->name; ?>
        </td>
         <td>
            <?php echo $v->description; ?>
        </td>
         <td>
             <?php echo $v->project_image; ?><img src=""/>
        </td>
         <td>
            <a href="<?php echo site_url(); ?>api/survey_list/<?php echo $v->id; ?>" style='color:#025A8D;text-decoration:underline'>
                Survey List
            </a>
        </td>
         <td>
            <?php echo $v->id; ?>
        </td>
    </tr>
    <?php
     }
    ?>
	</tbody>
</table>
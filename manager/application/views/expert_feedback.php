<h2>Expert Feedback</h2>
<div style="float: right;">
    <a href="<?php echo site_url().'api/delete_expert/' ?>" onclick=" return confirm('Are You Really want to Delete')">Delete</a> | <a href="<?php  echo site_url() ?>api/expert_list/">Cancel</a>
</div>
<table class="table">
    <tr>
        <th>
            # 
        </th>
        <th>
            Claim  
        </th>
        <th>
            Feedback  
        </th>
        <th>
           Date
        </th>
        <th>
            Rating
        </th>
        <th>
            
        </th>
    </tr>
    <?php
    $obj = json_decode($get_data);
    foreach($obj as $k=>$v)
    {   
   ?>
    <tr>
        <td>
            <?php echo $v->id; ?>
        </td>
         <td>
            <input type="checkbox" name="" value=""/>
        </td>
         <td>
            <?php echo $v->combineName; ?>  
        </td>
         <td>
            <?php echo $v->feedback; ?>
        </td>
         <td>
            <?php echo $v->created_date; ?> 
        </td>
         <td>
            <?php echo $v->rating; ?>
        </td>
    </tr>
     <?php
     }
    ?>
</table>
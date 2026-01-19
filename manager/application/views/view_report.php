<div style="float: right;">
     <a href="<?php  echo site_url() ?>api/report_list">Cancel</a>
</div>
<h2>View Report</h2>

<?php
$obj = json_decode($get_data);

foreach($obj as $key =>$val)
{
    ?>
    <b>Ques:-<?php  echo $val->description ?></b><br />
    Ans:- 
    <?php
    echo $val->answer;
}
?>
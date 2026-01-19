<?php
class Order_model extends CI_Model {
        function order_list(){
           // $sql = "SELECT t.* , p.name as projectName,p.description , p.id as projectID , s.id as surveyID , s.name as surveyName , s.combine_name as combineName , s.deadline, s.specific_expert  FROM #__transactions as t LEFT JOIN #__projects as p ON p.id = t.survey_id  LEFT JOIN #__survey as s ON s.project_id = p.id WHERE t.type=1 GROUP BY projectID ORDER BY id DESC ";
            
            $this->db->query('SELECT t.* , p.name as projectName,p.description , p.id as projectID , s.id as surveyID , s.name as surveyName , s.combine_name as combineName , s.deadline, s.specific_expert  FROM #__transactions as t LEFT JOIN #__projects as p ON p.id = t.survey_id  LEFT JOIN #__survey as s ON s.project_id = p.id WHERE t.type=1 GROUP BY projectID ORDER BY id DESC')->result->get;
        }
    }
?>
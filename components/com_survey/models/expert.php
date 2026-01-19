<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// Include dependancy of the main model form
jimport('joomla.application.component.modellist');
jimport('joomla.application.component.helper');


class SurveyModelExpert extends JModelList
{
    protected $item;

    function getPagination()
    {
        $pagination = parent::getPagination();
        $pagination->total = $this->total;
        if ($pagination->total % $pagination->limit > 0) {
            $nr_pages = intval($pagination->total / $pagination->limit) + 1;
        } else {
            $nr_pages = intval($pagination->total / $pagination->limit);
        }
        $pagination->set('pages.total', $nr_pages);
        $pagination->set('pages.stop', $nr_pages);
        return $pagination;
    }

    function getItems()
    {
        $app = JFactory::getApplication();
        $limistart = $app->getUserStateFromRequest($this->context . '.list.start', 'limitstart');
        $limit = $app->getUserStateFromRequest('global.list.limit', 'limit', $app->getCfg('list_limit'));
        $db =& JFactory::getDBO();
        //$query = $db->getQuery(true);
        $query = $this->getListQuery();
        $db->setQuery($query);
        $db->query();
        $result = $db->loadAssocList();
        $this->total = count($result);
        $db->setQuery($query, $limistart, $limit);
        $db->query();
        $result = $db->loadAssocList();
        return $result;
    }

    function getListQuery()
    {
        $app = JFactory::getApplication();
        $limit = $app->getUserStateFromRequest('global.list.limit', 'limit', $app->getCfg('list_limit'), 'int');
        $limitstart = $app->getUserStateFromRequest('limitstart', 'limitstart', 0, 'int');

        $limit_cond = "";
        if ($limit != 0) {
            $limit_cond = " LIMIT " . $limitstart . "," . $limit . " ";
        }
        $db =& JFactory::getDBO();
        $sql = "SELECT count(*) FROM #__expert as p ORDER BY p.`name` ASC ";
        $db->setQuery($sql);
        $db->query();
        $this->_total = $db->loadResult();
        $sql = "SELECT * FROM #__expert as p ORDER BY p.`name` ASC";
        //$db->setQuery($sql);
        //$db->query();
        //$result = $db->loadAssocList();
        return $sql;
    }


    /**
     * Returns a reference to the a Table object, always creating it.
     *
     * @param    type    The table type to instantiate
     * @param    string    A prefix for the table class name. Optional.
     * @param    array    Configuration array for model. Optional.
     * @return    JTable    A database object
     * @since    1.6
     */
    public function getTable($type = 'Expert', $prefix = 'SurveyTable', $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }


    function save($data)
    {
        $db =& JFactory::getDBO();
        $item =& $this->getTable('Expert');
        if (!$item->bind($data)) {
            echo $item->getError() . ' - 1';
            return false;
        }
        if (!$item->check()) {
            echo $item->getError() . ' - 2';
            return false;
        }
        if (!$item->store()) {
            echo $item->getError() . ' - 3';
            return false;
        }
        return $item->id;
    }

    function checkExpertEmail($email)
    {
        $db =& JFactory::getDBO();
        $sql = "SELECT * FROM #__expert WHERE email='" . $email . "'";
        $db->setQuery($sql);
        return $db->loadObject();
    }

    function checkExpertUsername($username)
    {
        $db =& JFactory::getDBO();
        $sql = "SELECT * FROM #__expert WHERE username='" . $username . "'";
        $db->setQuery($sql);
        return $db->loadObject();
    }
    
    /*
     * Called by Search Export Module (Home Page)
     * Returns a list of Experts that meet the criteria
     */
    function searchExperts($name) {
        $db = JFactory::getDBO();
        $sql = "SELECT * FROM #__expert WHERE name LIKE '%" . $name . "%'";
        $db->setQuery($sql);
        $result = $db->loadObjectList();
        return $result;
    }
    
    /*
     * Called by Search Export Module (Home Page)
     * Returns a list of Experts that meet the criteria
     */
    function searchExpertsWithReports($name) {
        $db = JFactory::getDBO();
        
        // Sample Output
        // ---------------------
        //expert_name	projects
        //John Anthony1	IXI
        //Max Lerner	IXI
        //Vivek Kapoor	P342135, P66425
        /*
        $sql = "SELECT
                e.name expert_name,
                GROUP_CONCAT(DISTINCT p.name ORDER BY p.name SEPARATOR ', ' ) AS 'projects'
                FROM 
                s1b9p_expert e
                LEFT JOIN s1b9p_survey_question_answer qa ON e.id = qa.expert_id
                LEFT JOIN s1b9p_question q ON qa.ques_id = q.id 
                LEFT JOIN s1b9p_survey s ON q.survey_id = s.id
                LEFT JOIN s1b9p_projects p ON p.id = s.project_id
                WHERE
                e.name LIKE '%" . $name . "%'
                GROUP BY
                e.id 
                ORDER BY  
                e.name;";
                */
           $sql = "SELECT
                e.name expert_name,e.id as expert_id,
                GROUP_CONCAT(DISTINCT p.name ORDER BY p.name SEPARATOR ', ' ) AS 'projects'
                FROM 
                #__expert e
                LEFT JOIN #__survey_question_answer qa ON e.id = qa.expert_id
                LEFT JOIN #__question q ON qa.ques_id = q.id 
                LEFT JOIN #__survey s ON q.survey_id = s.id
                LEFT JOIN #__projects p ON p.id = s.project_id
                WHERE
                e.name = '" . $name . "'
                GROUP BY
                e.id 
                ORDER BY  
                e.name;";
        $db->setQuery($sql);
        $result = $db->loadObjectList();
        return $result;
    }
    
//-- GET ALL Expert Reports (Surveys)

//SELECT * FROM s1b9p_expert e
//LEFT JOIN s1b9p_survey_question_answer qa ON e.id = qa.expert_id
//LEFT JOIN s1b9p_question q ON qa.ques_id = q.id 
//LEFT JOIN s1b9p_survey s ON q.survey_id = s.id
//LEFT JOIN s1b9p_projects p ON p.id = s.project_id
//WHERE e.id = '9'
//GROUP BY s.id
}

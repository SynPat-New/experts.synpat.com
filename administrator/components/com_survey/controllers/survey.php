<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controllerform library
jimport('joomla.application.component.controllerform');

/**
 * HelloWorld Controller
 */
class SurveyControllerSurvey extends JControllerForm {

    var $_model = null;

    function __construct() {
        parent::__construct();
        $this->registerTask("list", "SurveyList");
        $this->registerTask("new", "newSurvey");
        $this->registerTask("edit", "editSurvey");
        $this->registerTask("remove", "delete");
        $this->_model = & $this->getModel("survey");
    }

    function SurveyList() {
        JRequest::setVar("view", "survey");
        $view = $this->getView("survey", "html");
        $view->setLayout("listform");
        $view->setModel($this->_model, true);
        $view->listform();
    }

    function newSurvey() {
        JRequest::setVar("view", "survey");
        $view = $this->getView("survey", "html");
        $view->setLayout("editform");
        $view->setModel($this->_model, true);
        $view->editform();
    }

    function editSurvey() {
        JRequest::setVar("view", "survey");
        $view = $this->getView("survey", "html");
        $view->setLayout("editform");
        $view->setModel($this->_model, true);
        $view->editform();
    }

    function save() {
        $app = JFactory::getApplication('administrator');
        $data = JRequest::get('post');
        $survey["description"] = JRequest::getVar("description", "", "post", "string", JREQUEST_ALLOWHTML);
        $survey["image"] = $data["images"];
        $survey["id"] = $data["id"];
        $survey["name"] = $data["name"];
        $survey["project_id"] = $data["project_id"];
        $survey["user_id"] = $data["user_id"];
        unset($data['images']);
        $id = $this->_model->save($survey);
        if ($id > 0) {
            $getAllQuestionIDs = $data['question_ids'];
            if (empty($getAllQuestionIDs)) {
                $model = $this->getModel('Question');
                for ($i = 1; $i <= (int) $data['no_of_questions_new']; $i++) {
                    $question = array();
                    $question['description'] = $data['questions_' . $i];
                    if (!empty($question['description'])) {
                        $question['survey_id'] = $id;
                        $question['id'] = 0;
                        $model->save($question);
                    }
                }
            } else {
                $question_ids = explode(',', $getAllQuestionIDs);
                if (count($question_ids) > 0 && $question_ids[0] != "") {
                    $model = $this->getModel('Question');
                    for ($i = 0; $i < count($question_ids); $i++) {
                        if ($question_ids[$i] != ""):
                            $question = array();
                            $question['description'] = $data['questions_' . $question_ids[$i]];
                            if (!empty($question['description'])) {
                                $question['survey_id'] = $id;
                                $question['id'] = $question_ids[$i];
                                $model->save($question);
                            }
                        endif;
                    }
                }
                if ($data['no_of_questions_new'] > 0) {
                    if ($data['no_of_questions_new'] == 1) {
                        $newQuestionID = $data['no_of_questions'] + 1;
                        $question = array();
                        $question['description'] = $data['questions_new_' . $newQuestionID];
                        if (!empty($question['description'])) {
                            $question['survey_id'] = $id;
                            $question['id'] = 0;
                            $model->save($question);
                        }
                    } else {
                        /* $loop = $data['no_of_questions_new'] - $data['no_of_questions']; */
                        $loop = $data['no_of_questions_new'];
                        if ($loop > 0) {
                            for ($l = 1; $l <= count($loop); $l++) {
                                $newQuestionID = $data['no_of_questions'] + $l;
                                $question = array();
                                $question['description'] = $data['questions_new_' . $newQuestionID];
                                if (!empty($question['description'])) {
                                    $question['survey_id'] = $id;
                                    $question['id'] = 0;
                                    $model->save($question);
                                }
                            }
                        }
                    }
                }
            }
            $msg = JText::_('SURVEY_DETAILS_SAVED');
            $this->setRedirect('index.php?option=com_survey&task=survey.list', $msg);
        } else {
            $msg = JText::_('SURVEY_DETAILS_SAVED_ERROR');
            $this->setRedirect('index.php?option=com_survey&task=survey.list', $msg, "notice");
        }
    }

    function apply() {
        $app = JFactory::getApplication('administrator');
        $db = & JFactory::getDBO();
        $data = JRequest::get('post');
        $data["description"] = JRequest::getVar("description", "", "post", "string", JREQUEST_ALLOWHTML);
        $data["project_image"] = $data['images'];
        unset($data['images']);
        $result = $this->_model->save($data);
        if (isset($result) && $result != false) {
            $msg = JText::_('SURVEY_DETAILS_SAVED');
            $this->setRedirect('index.php?option=com_survey&task=survey.edit&id=' . $result . '&hidemainmenu=1', $msg);
        } else {
            $author_type = JRequest::getVar("author_type", "0");
            $this->setRedirect("index.php?option=com_survey&task=survey.new", JText::_('SURVEY_DETAILS_SAVED_ERROR'));
        }
    }

    function cancel() {
        $app = JFactory::getApplication('administrator');
        $app->redirect('index.php?option=com_survey&task=');
    }

    function cancelSurvey() {
        $app = JFactory::getApplication('administrator');
        $app->redirect('index.php?option=com_survey&task=survey.list');
    }

    function delete() {
        $result = $this->_model->delete();
        $msg = "";
        if ($result === true) {
            $msg = JText::_('SURVEY_DELETED');
        } elseif ($result === false) {
            $msg = JText::_('SURVEY_DELETED_ERROR');
        }
        $link = "index.php?option=com_survey&task=survey.list";
        $this->setRedirect($link, $msg, "notice");
    }

    function answerList() {
        JRequest::setVar("view", "survey");
        $view = $this->getView("survey", "html");
        $view->setLayout("answer");
        $view->setModel($this->_model, true);
        $view->answer();
    }

    function saveanswer() {
        $post = JRequest::get('post');
        $getAnswerList = explode(',', $post['answer']);
        if (count($getAnswerList) > 0 && $getAnswerList[0] != "") {
            for ($i = 0; $i < count($getAnswerList); $i++) {
                if ($getAnswerList[$i] != "") {
                    $model = $this->getModel('Answer');
                    $ans = "";
                    if (isset($post['answer_pub_' . $getAnswerList[$i]])) {
                        $ans = array('publish' => $post['answer_pub_' . $getAnswerList[$i]], 'id' => $getAnswerList[$i]);
                    } else {
                        $ans = array('publish' => 1, 'id' => $getAnswerList[$i]);
                    }
                    $model->save($ans);
                }
            }
        }
        $app = JFactory::getApplication();
        $link = 'index.php?option=com_survey&task=survey.answerList&expert_id=' . $post['expert_id'] . '&survey_id=' . $post['survey_id'];
        $this->setRedirect($link, "Data updated successfully", "notice");
    }

    function sendSuccess() {
        JRequest::setVar("view", "survey");
        $view = $this->getView("survey", "html");
        $view->setLayout("emailsuccess");
        $view->setModel($this->_model, true);
        $view->emailSuccess();
    }

}

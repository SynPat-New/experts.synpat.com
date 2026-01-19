<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controllerform library
jimport('joomla.application.component.controllerform');

/**
 * HelloWorld Controller
 */
class SurveyControllerQuestion extends JControllerForm {

    var $_model = null;

    function __construct() {
        parent::__construct();
        $this->registerTask("", "QuestionList");
        $this->registerTask("list", "QuestionList");
        $this->registerTask("new", "newQuestion");
        $this->registerTask("edit", "editQuestion");
        $this->registerTask("remove", "delete");
        $this->registerTask("sendEmail", "emailLayout");
        $this->_model = & $this->getModel("question");
    }

    function QuestionList() {
        JRequest::setVar("view", "question");
        $view = $this->getView("question", "html");
        $view->setModel($this->_model, true);
        parent::display();
    }

    function newQuestion() {
        JRequest::setVar("view", "question");
        $view = $this->getView("question", "html");
        $view->setLayout("editform");
        $view->setModel($this->_model, true);
        $view->editform();
    }

    function editQuestion() {
        JRequest::setVar("view", "question");
        $view = $this->getView("question", "html");
        $view->setLayout("editform");
        $view->setModel($this->_model, true);
        $view->editform();
    }

    function save() {
        $app = JFactory::getApplication('administrator');
        $data = JRequest::get('post');
        $flag = 0;
        if ((int) $data['oldQuestion'] > 0) {
            $allQuestionIDs = explode(',', $data['oldQuestionID']);
            if (count($allQuestionIDs) > 0 && $allQuestionIDs[0] != "") {
                for ($i = 0; $i < count($allQuestionIDs); $i++) {
                    if ($data['question_' . $allQuestionIDs[$i]] != "") {
                        $oldData = array();
                        $oldData['description'] = $data['question_' . $allQuestionIDs[$i]];
                        $oldData['id'] = $allQuestionIDs[$i];
                        $oldData['survey_id'] = $data['survey_id'];
                        $oldData['created_date'] = date('Y-m-d H:i:s', strtotime('now'));
                        $oldData['question_order'] = $data['question_order_' . $allQuestionIDs[$i]];
                        $this->_model->save($oldData);
                        $flag = 1;
                    }
                }
            }
        }
        if ((int) $data['newQuestions'] > 0) {
            for ($i = 1; $i <= $data['newQuestions']; $i++) {
                if ($data['question_new_' . $i] != "") {
                    $newData = array();
                    $newData['description'] = $data['question_new_' . $i];
                    $newData['id'] = 0;
                    $newData['survey_id'] = $data['survey_id'];
                    $newData['created_date'] = date('Y-m-d H:i:s', strtotime('now'));
                    $newData['question_order'] = $data['question_new_order_' . $i];
                    $this->_model->save($newData);
                    $flag = 1;
                }
            }
        }

        /* $data["description"] = JRequest::getVar("description","","post","string",JREQUEST_ALLOWRAW); */
        if ($flag == 1) {
            /* Delete Old Area Survey and Insert New */
            /* Now its been change , It will save when Questionare send to expert. */
            /*
              $this->_model->deleteInsertAreaSurvey($data['survey_id'],$data['area_expertise']);
             */
            /* End Delete process */
            $msg = JText::_('QUESTION_DETAILS_SAVED');
            $this->setRedirect('index.php?option=com_survey&task=question.list&survey_id=' . $data['survey_id'], $msg);
        } else {
            $msg = JText::_('QUESTION_DETAILS_SAVED_ERROR');
            $this->setRedirect('index.php?option=com_survey&task=question.list&survey_id=' . $data['survey_id'], $msg, "notice");
        }
    }

    function apply() {
        $app = JFactory::getApplication('administrator');
        $db = & JFactory::getDBO();
        $data = JRequest::get('post');
        $data["description"] = JRequest::getVar("description", "", "post", "string", JREQUEST_ALLOWRAW);
        $result = $this->_model->save($data);
        if (isset($result) && $result != false) {
            $msg = JText::_('QUESTION_DETAILS_SAVED');
            $this->setRedirect('index.php?option=com_survey&task=question.edit&id=' . $result . '&hidemainmenu=1', $msg);
        } else {
            $author_type = JRequest::getVar("author_type", "0");
            $this->setRedirect("index.php?option=com_survey&task=question.new", JText::_('QUESTION_DETAILS_SAVED_ERROR'));
        }
    }

    function cancel() {
        $app = JFactory::getApplication('administrator');
        $app->redirect('index.php?option=com_survey&task=');
    }

    function cancelquestion() {
        $app = JFactory::getApplication('administrator');
        /* $app->redirect('index.php?option=com_survey&task=question.list'); */
        $app->redirect('index.php?option=com_survey&task=');
    }

    function delete() {
        $result = $this->_model->delete();
        $msg = "";
        if ($result === true) {
            $msg = JText::_('QUESTION_DELETED');
        } elseif ($result === false) {
            $msg = JText::_('QUESTION_DELETED_ERROR');
        }
        $link = "index.php?option=com_survey&task=question.list";
        $this->setRedirect($link, $msg, "notice");
    }

    function emailLayout() {
        JRequest::setVar("view", "email");
        $view = $this->getView("email", "html");
        $view->setLayout("default");
        $model = & $this->getModel("email");
        $view->setModel($model, true);
        $view->emailLayout();
    }

    function emailSend() {
        $msg = "";
        $post = JRequest::get('post');
        $msg = "";
        $type = "";
		try {
			$getAllExpert = array();
			if(isset($post['selected_expert']) && count($post['selected_expert'])>0){				
                foreach ($post['selected_expert'] as $id => $value) {
                    $expert = $this->_model->getSingleExpert($value);
                    array_push($getAllExpert, $expert);
                }
			} else {
				$getAllExpert = $this->_model->findExpertWithCode($post['expertise_code'],2);
			}
            // EPO Integration - Not Complete - Hidden
            /*if (isset($post['parent_checked'])
                || isset($post['child_1'])
                || isset($post['child_2'])
                || isset($post['child_3'])
                || isset($post['child_4'])) {
                $expertArea = "";
                if (isset($post['parent_checked'])) {
                    $expertArea .= $this->findAllIDSExperArea($post['parent_checked'], 0);
                }

                if (isset($post['child_1'])) {
                    $expertArea .= $this->findAllIDSExperArea($post['child_1'], 1);
                }

                if (isset($post['child_2'])) {
                        $expertArea .= $this->findAllIDSExperArea($post['child_2'], 1);
                }

                if (isset($post['child_3'])) {
                    $expertArea .= $this->findAllIDSExperArea($post['child_3'], 1);
                }

                if (isset($post['child_4'])) {
                    $expertArea .= $this->findAllIDSExperArea($post['child_4'], 1);
                }
                $expertArea = substr($expertArea, 0, -1);*/
            //if (isset($post['patent_categories'])) {
            //    $expertArea = $post['patent_categories'];

                //if ($expertArea != "") {
                    //$getAllExpert = $this->_model->getAllExpertByAreaID($expertArea);

                if (count($getAllExpert) > 0) {
                    for ($i = 0; $i < count($getAllExpert); $i++) {
							if(!empty($getAllExpert[$i]->id)){
                            $getProjectSurveyData = $this->_model->getProjectSurveyData($post['survey_id']);
                            $mailer = & JFactory::getMailer();
                            $config = & JFactory::getConfig();
                            $sender = array(
                                $config->getValue('config.mailfrom'),
                                $config->getValue('config.fromname'));
                            $mailer->setSender($sender);
                            $encodeData = base64_encode($getProjectSurveyData->name . "@" . $getProjectSurveyData->id . "@" . $getAllExpert[$i]->id);
                            $mailer->addRecipient($getAllExpert[$i]->email);
							$body = "<table><tr><td><h1 style='text-align: left; color: #cd2122;'>ClaimCharts.info</h1></td></tr><tr><td>";
                            $body .= "Hi " . $getAllExpert[$i]->name . ",<br/><p>" . $post['email_message'] . "</p><p><a href='" . JUri::root() . "index.php?option=com_survey&task=survey.surveylist&ps=" . $encodeData . "'>" . JUri::root() . "index.php?option=com_survey&task=survey.surveylist&ps=" . $encodeData . "</a></p>";
                            $body .="</td></tr><tr><td>Vivek Kapoor</td></tr><tr><td>Account Manager</td></tr><tr><td>ClaimCharts.info</td></tr><tr><td>One Market - Spear Tower, 35 Floor</td></tr><tr><td>San Francisco, CA 94105</td></tr><tr><td style='height:20px;'></td></tr><tr><td>T +1-415-935-5272</td></tr><tr><td><a href='mailto:vivek@claimcharts.info'>vivek@claimcharts.info</a></td></tr><tr><td><a href='http://www.claimcharts.info' target='_blank'>www.ClaimCharts.info</a></td></tr><tr><td style='height:20px;'></td></tr><tr><td><p>This message is intended only for the individual or entity to which it is addressed. It may contain information that is confidential or privileged. If the reader of this message is not the intended recipient, you are hereby notified that any dissemination, sharing or copying of this e-mail is strictly prohibited. If you receive this e-mail in error, please notify Syndicated Patent Acquisitions Corp. immediately by telephone or email, and delete the material from any computer. Thank you.</p></td></tr></table>";
							$mailer->setSubject('New survey is waiting');
                            $mailer->setBody($body);
                            $mailer->isHTML(true);
                            $mailer->Encoding = 'base64';
                            if ($mailer->Send()) {
                                $msg = "Message Sent.";
                                $type = "Success";
                                $this->_model->insertEmailSend($post['survey_id'], $getAllExpert[$i]->id, 0);
                            } else {
                                $this->_model->insertEmailSend($post['survey_id'], $getAllExpert[$i]->id, 1);
                            }
                            /* Insert Notification */
                            $this->_model->insertNotification($post['survey_id'], $getAllExpert[$i]->id);
                            /* End Notification */
							}
                        }
                        $this->_model->insertMessageSend($post['survey_id']);
                    } else {
                        $msg = "No expert found!";
                        $type = "Notice";
                    }
                //}
//            } else {
//                $msg = "Please select expertise area.";
//                $type = "Error";
//            }

        } catch (Exception $e) {
            $msg = 'Caught exception: ' + $e->getMessage() + "\n";
            $type = "Error";
        }
        
        /*$link = "index.php?option=com_survey&task=question.list&survey_id=" . $post['survey_id'];*/
        $link = "index.php?option=com_survey&task=order.list";
        $this->setRedirect($link, $msg, $type);
    }

    function findAllIDSExperArea($expertiseAreaID, $level) {
        $getList = "";
        if ($level == 0) {
            $getList .= $expertiseAreaID . ",";
            $getListData = $this->_model->getChildExpertise($expertiseAreaID);
            if (count($getListData) > 0) {
                foreach ($getListData as $child) {
                    $getList .= $this->findAllIDSExperArea($child->id, 0);
                }
            }
        } else {
            foreach ($expertiseAreaID as $child) {
                $getList .= $child . ",";
                $getListData = $this->_model->getChildExpertise($child);
                if (count($getListData) > 0) {
                    foreach ($getListData as $child) {
                        $getList .= $this->findAllIDSExperArea($child->id, 0);
                    }
                }
            }
        }
        return $getList;
    }

    function deleteQuestionare() {
        $surveyID = JRequest::getInt('survey_id');
        $getAction = $this->_model->deleteQuestionare($surveyID);
        $app = JFactory::getApplication();
        if ($getAction == 1) {
            $app->redirect('index.php?option=com_survey&task=question.new&survey_id=' . $surveyID, 'Clear questionare', 'success');
        } else {
            $app->redirect('index.php?option=com_survey&task=question.new&survey_id=' . $surveyID, 'Unable to delete questionare', 'success');
        }
    }
	
	function findExpertWithCode(){
		$data = JRequest::get('post');
		$getList = $this->_model->findExpertWithCode($data['code'],$data['mode']);
		if($data['mode']==2){
			echo json_encode($getList);
		} else {
			echo json_encode(array('count'=>$getList));	
		}
		die;
	}
	
    function childData() {
        $parentID = JRequest::getInt('pat');
        $level = JRequest::getInt('l');
        if ($level == 1 || $level == 2 || $level == 0) {
            $getData = $this->_model->getChildExpertise($parentID);
            echo json_encode($getData);
        } else if ($level == 3) {
            $getData = $this->_model->getChildExpertise($parentID);
            $newArray = "";
            if (count($getData) > 0) {
                for ($i = 0; $i < count($getData); $i++) {
                    $newArray[] = array('id' => $getData[$i]->id, 'name' => $getData[$i]->name, 'classification_description' => $getData[$i]->classification_description, 'parent' => 0, 'level' => 1, 'big_parent' => 0);
                    $checkData = $this->_model->getChildExpertise($getData[$i]->id);
                    if (count($checkData) > 0) {
                        for ($s = 0; $s < count($checkData); $s++) {
                            $newArray[] = array('id' => $checkData[$s]->id, 'name' => $checkData[$s]->name, 'classification_description' => $checkData[$s]->classification_description, 'parent' => $getData[$i]->id, 'level' => 2, 'big_parent' => $getData[$i]->id);
                            $checkData1 = $this->_model->getChildExpertise($checkData[$s]->id);
                            if (count($checkData1) > 0) {
                                for ($h = 0; $h < count($checkData1); $h++) {
                                    $newArray[] = array('id' => $checkData1[$h]->id, 'name' => $checkData1[$h]->name, 'classification_description' => $checkData1[$h]->classification_description, 'parent' => $checkData[$s]->id, 'level' => 3, 'big_parent' => $getData[$i]->id);
                                    $checkData2 = $this->_model->getChildExpertise($checkData1[$h]->id);
                                    if (count($checkData2) > 0) {
                                        for ($m = 0; $m < count($checkData2); $m++) {
                                            $newArray[] = array('id' => $checkData1[$m]->id, 'name' => $checkData2[$m]->name, 'classification_description' => $checkData2[$m]->classification_description, 'parent' => $checkData1[$h]->id, 'level' => 4, 'big_parent' => $getData[$i]->id);
                                            $checkData3 = $this->_model->getChildExpertise($checkData2[$m]->id);
                                            if (count($checkData3) > 0) {
                                                for ($n = 0; $n < count($checkData3); $n++) {
                                                    $newArray[] = array('id' => $checkData3[$n]->id, 'name' => $checkData3[$n]->name, 'classification_description' => $checkData3[$n]->classification_description, 'parent' => $checkData2[$m]->id, 'level' => 5, 'big_parent' => $getData[$i]->id);
                                                    $checkData4 = $this->_model->getChildExpertise($checkData3[$n]->id);
                                                    if (count($checkData4) > 0) {
                                                        for ($a = 0; $a < count($checkData4); $a++) {
                                                            $newArray[] = array('id' => $checkData4[$a]->id, 'name' => $checkData4[$a]->name, 'classification_description' => $checkData4[$a]->classification_description, 'parent' => $checkData3[$n]->id, 'level' => 6, 'big_parent' => $getData[$i]->id);
                                                            $checkData5 = $this->_model->getChildExpertise($checkData4[$a]->id);
                                                            if (count($checkData5) > 0) {
                                                                for ($j = 0; $j < count($checkData5); $j++) {
                                                                    $newArray[] = array('id' => $checkData5[$j]->id, 'name' => $checkData4[$j]->name, 'classification_description' => $checkData4[$j]->classification_description, 'parent' => $checkData4[$a]->id, 'level' => 7, 'big_parent' => $getData[$i]->id);
                                                                    $checkData6 = $this->_model->getChildExpertise($checkData5[$j]->id);
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                echo json_encode($newArray);
            }
        }
    }

}

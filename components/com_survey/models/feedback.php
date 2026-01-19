<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla modelitem library
jimport('joomla.application.component.modellist');
jimport('joomla.application.component.helper');


class SurveyModelFeedback extends JModelList
{
	
	function expertSurveyExist($string)
    {
        /*Check Code Exist*/
        $db = JFactory::getDBO();
        $sttring = base64_decode($string);
        $stringExplode = explode('@', $sttring);
		 
        if (count($stringExplode) == 5) {
            $newString = base64_encode($stringExplode[0] . "@" . $stringExplode[1] . "@" . $stringExplode[2]. "@" . $stringExplode[3]);
            
			$sql = "SELECT * FROM `#__digicode` WHERE code_generate='" . $newString . "' AND status=0";
            $db->setQuery($sql);
            $getData = $db->loadObject();
            /*End Code Exist*/
            if (count($getData) > 0) {
                $decodeCode = base64_decode($string);
                $explodeCode = explode('@', $decodeCode);
                if (count($explodeCode) > 0 && $explodeCode[1] != "") {
                    $getExpert = $this->expertData($explodeCode[1]);
					$findFeedback = $this->findFeedBackWithString($string);
                    return array('digiCode' => $getData, 'expert' => $getExpert,'feedback'=>$findFeedback);
                }
            } else {
                /*return $getData;*/
                return array();
            }
        } else {
            return array();
        }
    }
	
	function findFeedBackWithString($string){
		$db = JFactory::getDBO();
        $sql = "SELECT * FROM #__expertrating  WHERE digital_code='" . $string . "'";
        $db->setQuery($sql);
        return $db->loadObject();
	}
	
	function expertData($expertID)
    {
        $db = JFactory::getDBO();
        $sql = "SELECT e.* , p.paypal_id FROM #__expert as e LEFT JOIN #__expert_payment as p ON p.expert_id = e.id WHERE e.id='" . $expertID . "'";
        $db->setQuery($sql);
        return $db->loadObject();
    }
}


<?php
require_once(JPATH_SITE.'/components/com_guru/helpers/check.php');
class sef_guru{
   /**
   * Creates the SEF Advance URL out of the request
   * Input: $string, string, The request URL (index.php?option=com_example&Itemid=$Itemid)
   * Output: $sefstring, string, SEF Advance URL ($var1/$var2/)
   **/
	function create($string){
		$database=&JFactory::getDBO();
		$retval ="";
		$string = str_replace("&amp;", "&",$string);
		$o = explode("&", substr($string, strpos($string,"index.php?")+10));

		foreach($o as $value){
			$i = explode("=", $value);
		 	if($i["1"] != "com_guru"){
				$ns[$i["0"]] = $i["1"];
			}
		}
		
		//start take out component name
		if(isset($ns["option"])){
			unset($ns["option"]);
		}
		//end take out component name
		
		$view = "";
		
		
		if(isset($ns) && count($ns) > 0){
			foreach($ns as $key => $val){
				if($key == "view"){
					$view  = $val;
				}
				if($key == "catid"){
					$sql = "select name, alias from #__guru_category where id=".intval($val);
					$database->setQuery($sql);
					$database->query();
					$result = $database->loadAssocList();			
					$alias = "";
					if(trim($result["0"]["alias"]) == ""){
						$alias = JFilterOutput::stringURLSafe($result["0"]["name"]);
					}
					else{
						$alias = trim($result["0"]["alias"]);
					}
					$retval .= intval($val)."-".$alias."/";
				}
				elseif($key == "task" && $view != "guruPrograms"){
					//do nothing
				}
				elseif($key == "module"){
					$sql = "select title, alias from #__guru_days where id=".intval($val);
					$database->setQuery($sql);
					$database->query();
					$result = $database->loadAssocList();			
					$alias = "";
					if(trim($result["0"]["alias"]) == ""){
						$alias = JFilterOutput::stringURLSafe($result["0"]["title"]);
					}
					else{
						$alias = trim($result["0"]["alias"]);
					}
					$retval .= intval($val)."-".$alias."/";
				}
				elseif($key == "cid" && ($view == "gurutasks" || $view == "guruTasks")){
					$sql = "select name, alias from #__guru_task where id=".intval($val);
					$database->setQuery($sql);
					$database->query();
					$result = $database->loadAssocList();			
					$alias = "";
					if(trim($result["0"]["alias"]) == ""){
						$alias = JFilterOutput::stringURLSafe($result["0"]["name"]);
					}
					else{
						$alias = trim($result["0"]["alias"]);
					}
					$retval .= intval($val)."-".$alias."/";
				}
				elseif($key == "cid" && ($view == "guruPrograms")){
					$sql = "select name, alias from #__guru_program where id=".intval($val);
					$database->setQuery($sql);
					$database->query();
					$result = $database->loadAssocList();			
					$alias = "";
					if(trim($result["0"]["alias"]) == ""){
						$alias = JFilterOutput::stringURLSafe($result["0"]["name"]);
					}
					else{
						$alias = trim($result["0"]["alias"]);
					}
					$retval .= intval($val)."-".$alias."/";
				}
				elseif($key == "layout" && ($view == "guruPrograms")){
				}
				elseif($key == "course_id" && ($view == "guruPrograms")){
					$task = JRequest::getVar("task");
					if($task == "view"){
						$retval .= $val."/";
					}
				}
				else{
					if(strpos($key, "http") === FALSE){
						$retval .= $val."/";
					}
				}
			}
		}
		return $retval;
   }

   /**
   * Reverts to the query string out of the SEF Advance URL
   * Input:
   *    $url_array, array, The SEF Advance URL split in arrays
   *    $pos, int, The position offset for virtual directories (first virtual directory, which is the component name, begins at $pos+1)
   * Output: $QUERY_STRING, string, query string (var1=$var1&var2=$var2)
   *    Note that this will be added to already defined first part (option=com_example&Itemid=$Itemid)
   **/
	function revert($url_array, $pos){
		$database =& JFactory::getDBO();
		//start take the replacement for space from sef_advanced config table
		$query="select * from #__sef_config";
		$database->setQuery($query);
		$database->query();
		$result=$database->loadObject();
		if(is_array($result) && count($result)>0){
			$space		= $result->space;
			$use_alias	= $result->alias;
			$lowercase	= $result->lowercase;
		}
		//end take the replacement for space from sef_advanced config table

		$na = array();

      	for($a = $pos+1; $a < count($url_array); $a++){
        	if(strlen($url_array[$a]) > 0){
            	$na[] = $url_array[$a];
         	}
      	}
		$vars = array();
		
		unset($na["0"]);
		
		if($na["1"] == "guruPcategs"){
			$vars["view"] = $na["1"];
			$vars["task"] = "view";
			$vars["cid"] = $na["2"];
		}
		elseif($na["1"] == "gurupcategs"){
			if(in_array("http", $na)){
				$key = array_search('http', $na);
				unset($na[$key]);
			}
			$vars["view"] = $na["1"];
		}
		elseif($na["1"] == "guruauthor"){
			$vars["view"] = $na["1"];
			if(count($na) == 4){
				if(intval($na["2"]) == "0"){
					$vars["layout"] = $na["2"];
				}
				if(isset($na["3"])){
					$vars["cid"] = $na["3"];
				}
				if(isset($na["4"])){
					$vars['Itemid'] = $na["4"];
				}
			}
			elseif(count($na) == 3){
				$vars["layout"] = $na["2"];
				$vars['Itemid'] = $na["3"];
			}
		}
		elseif($na["1"] == "guruprograms" || $na["1"] == "guruPrograms"){
			$vars['view'] = $na["1"];

			if(count($na) == 3){
				$vars['layout'] = "view";
				$vars['cid'] = intval($na["2"]);
				$vars['course_id'] = intval($na["2"]);
				$vars['Itemid'] = $na["3"];
			}
			elseif(count($na) == 2){
				$vars['view'] = "guruprograms";
				$vars['cid'] = $na["2"];
				$vars['course_id'] = intval($na["2"]);
				$vars['task'] = "enroll";
			}
			elseif(count($na) == 5){
				$vars['view'] = "guruprograms";
				$vars['task'] = $na["2"];
				$vars['cid'] = intval($na["3"]);
				$vars['course_id'] = intval($na["3"]);
			}
			elseif(count($na) == 4){
				$vars['view'] = "guruprograms";
				$vars['task'] = $na["2"];
				$vars['cid'] = intval($na["3"]);
				$vars['course_id'] = intval($na["3"]);
				$vars['Itemid'] = $na["4"];
			}
			else{
				$vars['task'] = $na["2"];
				if($vars['task'] != "buy_action"){
					$vars['layout'] = "view";
				}
				$vars['course_id'] = $na["3"];
				$vars['cid'] = $na["3"];
				if(isset($na["4"])){
					$vars['Itemid'] = $na["4"];
				}
			}
		}
		elseif($na["1"] == "gurutasks"){
			$vars['view'] = $na["1"];
			$vars['catid'] = $na["2"];
			$vars['module'] = $na["3"];
			$vars['cid'] = $na["4"];
			if(isset($na["5"])){
				$vars['tmpl'] = 'component';
			}
			$Itemid = JRequest::setVar("Itemid", "");
		}
		elseif($na["1"] == "guruEditplans"){
			$vars["view"] = $na["1"];
			$vars['course_id'] = $na["2"];
			if(isset($na["3"]) || $na["3"] == "&tmpl=component"){
				$vars['tmpl'] = "component";
			}
		}
		elseif($na["1"] == "guruBuy"){
			if(count($na) == 1){
				$vars["view"] = $na["1"];
				$vars['task'] = "buy";
			}
			elseif(count($na) == 3){
				$vars["view"] = $na["1"];
				$vars["action"] = "checkout";
				$vars["task"] = "checkout";
				$vars["from"] = $na["2"];
			}
			elseif(count($na) == 4){
				$vars["view"] = $na["1"];
				$vars["action2"] = $na["2"];
				$vars["order_id"] = $na["3"];
				$vars["Itemid"] = $na["4"];
			}
			else{
				$vars["view"] = $na["1"];
				$vars["Itemid"] = $na["2"];
			}
		}
		elseif($na['1'] == "guruorders"){
			$vars['view'] = $na["1"];
			$vars['layout'] = $na["2"];
			if(isset($na["4"])){
				$vars['course'] = $na["4"];
			}
		}
		elseif($na['1'] == "guruOrders"){	
			$vars['view'] = $na["1"];
			$vars["orderid"] = $na["2"];
			$vars['task'] = "showrec";
			if(count($na) == 4){
				$vars['task'] = "listQuizStud";
				$vars['tmpl'] = "component";
				$vars['cid'] = $na["2"];
				$vars['pid'] = $na["3"];
			}
			if(count($na) == 6){
				$vars['task'] = "show_quizz_res";
				$vars['tmpl'] = "component";
				$vars['cid'] = $na["2"];
				$vars['pid'] = $na["3"];
				$vars['quiz_id'] = $na[4];
				$vars['id'] = $na[5];
				
			}	
		}
		elseif($na['1'] == "guruProfile"){
			$vars["view"] = $na["1"];
			if(count($na) == 5){
				$task = JRequest::getVar("task", "loginform");
				$vars['task'] = $task;
				$vars['course_id'] = $na["2"];
				$vars['returnpage'] = "guruprograms";
				$vars['graybox'] = "true";
				$vars['tmpl'] = "component";
				$vars['Itemid'] = $na["5"];
			}
			elseif($na["6"] == "index.php"){
				$vars['returnpage'] = JRequest::getVar("returnpage");
				$vars['task'] = JRequest::getVar("task");
				$vars['course_id'] = JRequest::getVar("course_id");
				$vars['graybox'] = JRequest::getVar("graybox");
				$vars['username'] = JRequest::getVar("username");
   				$vars['passwd'] = JRequest::getVar("passwd");
			}
			else{
				$vars['task'] = $na["2"];
				if(isset($na["3"])){
					$vars['returnpage'] = $na["3"];
				}
			}
		}
		elseif($na['1'] == "guruTasks"){
			if(intval($na["4"]) != "0"){
				$vars["view"] = $na["1"];
				$vars['catid'] = $na["2"];
				$vars['module'] = $na["3"];
				$vars['cid'] = $na["4"];
				if(in_array("component", $na)){
					$vars['tmpl'] = 'component';
				}
				$vars['task'] = "view";
			}
			elseif(count($na) == "3"){
				$vars["view"] = $na["1"];
				$vars['module'] = $na["2"];
				$vars['cid'] = $na["3"];
				$vars['task'] = "view";
			}
			else{
				$vars["view"] = $na["1"];
				$vars['catid'] = $na["2"];
				$vars['module'] = $na["3"];
				$vars['action'] = "viewmodule";
				if(in_array("component", $na)){
					$vars['tmpl'] = 'component';
				}
			}
		}
		elseif($na["1"] == "guruLogin"){
			if(count($na) == "4"){
				if($na["4"] == "index.php"){
					$na = array_diff($na, array(array_pop($na)));
					$vars["view"] = $na["1"];
					$vars["task"] = JRequest::getVar("task");
					$vars["course_id"] = $na["3"];
					$vars["cid"] = $na["3"];
					$vars["returnpage"] = $na["2"];
				}
				else{
					$vars["view"] = $na["1"];
					$vars["task"] = JRequest::getVar("task");
					$vars["course_id"] = $na["2"];
					$vars["cid"] = $na["2"];
					$vars["returnpage"] = $na["3"];
					$vars["tmpl"] = "component";
				}
			}
			elseif(count($na) == "3"){
				$task = JRequest::getVar("task");
				if($na["3"] == "index.php" && $task=="log_in_user"){
					$na = array_diff($na, array(array_pop($na)));
					$vars["view"] = $na["1"];
					$vars["returnpage"] = $na["2"];
					$vars['Itemid'] = $na["3"];
				}
				else{
					$vars["view"] = $na["1"];
					$vars["task"] = JRequest::getVar("task");
					$vars["course_id"] = $na["2"];
					$vars["cid"] = $na["2"];
					$vars["returnpage"] = $na["3"];	
				}		
			}
			else{
				$vars["view"] = $na["1"];
				$vars["returnpage"] = $na["2"];
			}
		}
		
		$QUERY_STRING = "";
		
     	foreach($vars as $key=>$value){
        	$QUERY_STRING .= "&";
        	$QUERY_STRING .= $key;
        	$QUERY_STRING .= "=";
        	$QUERY_STRING .= $value;
        	$GLOBALS[$key] = $_GET[$key] = $_REQUEST[$key] = $value;
      	}

		return $QUERY_STRING;
   	}
}
?>
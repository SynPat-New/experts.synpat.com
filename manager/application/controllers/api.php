<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('my_helper');
        $this->layout->auto_render=false;
        $this->layout->layout='default';
        $this->is_login();
    }
    private function is_login(){
        /*if(!$this->session->userdata('logged_in'))
        {
            $site_url = site_url().'user/login';
            redirect($site_url);
        }*/
    }
    public function index()
    {
       $this->layout->title_for_layout = 'Dashboard';
		   $this->layout->layout='default';
		   $this->layout->render('home');
    }
	
	
	function remove_expert(){
		$data = json_encode(array('affected'=>0,'error'=>''));
		if(isset($_POST) && count($_POST)>0){
			$ID = $this->input->post('id');
			if($ID>0){
				$data = $this->call(array(
					"option"=>"com_survey",
					"task"=>"customer.delete_expert",
					"p"=>$ID
				));
			}
		}
		echo $data;
		die;
	}
	
	function transaction_list(){
		$this->layout->title_for_layout = 'Dashboard';
		$this->layout->layout='default';
		$this->layout->render('transaction_list');
	}
	
	function findTransactionList(){
		$transactionList = array();
		$this->config->load('config');
		$paypalMode = $this->config->item('paypal_mode');
		$postTransactionArray = array();
		if($paypalMode=="live"){
			$paypalUrl = "https://api-3t.paypal.com/nvp";
			$postTransactionArray['USER'] = $this->config->item('USER_LIVE');
			$postTransactionArray['PWD'] = $this->config->item('PWD_LIVE');
			$postTransactionArray['SIGNATURE'] = $this->config->item('SIGNATURE_LIVE');
		}
		$postTransactionArray['METHOD'] = 'TransactionSearch';
		$postTransactionArray['VERSION'] = '99';
		$startDate = $this->input->post('start_date');
		$endDate = $this->input->post('end_date');
		$postTransactionArray['STARTDATE'] = gmdate('Y-m-d H:i:s',strtotime($startDate));
		if($endDate!=""){
			$postTransactionArray['ENDDATE'] = gmdate('Y-m-d H:i:s',strtotime($endDate));
		}
		
		$postdata = http_build_query($postTransactionArray); 
		$curl = curl_init();					
		curl_setopt($curl, CURLOPT_URL, $paypalUrl);
		curl_setopt($curl, CURLOPT_VERBOSE, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
		$response = curl_exec($curl);
		curl_close($curl);
		$httpResponseAr = explode('&',$response);
		$httpParsedResponseAr = array();
		foreach ($httpResponseAr as $i => $value){
			$tmpAr = explode("=", $value);
			if(sizeof($tmpAr) > 1){
				$httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
			}
		}
		if(sizeof($httpParsedResponseAr)>0 && array_key_exists('ACK', $httpParsedResponseAr)){
			$transactionList = $httpParsedResponseAr;
		}
		echo json_encode($httpParsedResponseAr);
	}
	
	function delete_claim(){
		$data = 0;
		if(isset($_POST)){
			$ID = $this->input->post('id');
			if($ID>0){
				$data = $this->call(array(
					"option"=>"com_survey",
					"task"=>"customer.delete_claim",
					"p"=>$ID
				));
			}
		}
		echo $data;
		die;
	}
	
	
	function childData(){
		$data = $this->call(array(
								"option"=>"com_survey",
								"task"=>"customer.childData",
								"pat"=>$this->input->post('pat'),
								"l"=>$this->input->post('l'),
								"format"=>$this->input->post('format'),
							  ));
		echo $data;
		die;
	}
	
	public function save_agreement(){
		$data = $this->call(array(
								"option"=>"com_survey",
								"task"=>"api.save_agreement",
								"id"=>$this->input->post('id'),
								"content"=>$this->input->post('content'),
								"format"=>'',
							  ));
		echo $data;
		die;					  
	}
	
	public function term_of_use(){
		$data['agreement'] = $this->call(array(
								"option"=>"com_survey",
								"task"=>"api.agreement",
								"p"=>1
							  ));
		$data['title'] = "Terms Of Use";
		$this->layout->layout='default';
		$this->layout->render('nda',$data);	
	}
	
	public function privacy_policy(){
		$data['agreement'] = $this->call(array(
								"option"=>"com_survey",
								"task"=>"api.agreement",
								"p"=>2
							  ));
		$data['title'] = "Privacy Policy";
		$this->layout->layout='default';
		$this->layout->render('nda',$data);	
	}
	
	public function sme_agreement(){
		$data['agreement'] = $this->call(array(
								"option"=>"com_survey",
								"task"=>"api.agreement",
								"p"=>3
							  ));
		$data['title'] = "SME Agreement";
		$this->layout->layout='default';
		$this->layout->render('nda',$data);	
	}
	
	public function nda(){
		$data['agreement'] = $this->call(array(
								"option"=>"com_survey",
								"task"=>"api.agreement",
								"p"=>4
							  ));
		$data['title'] = "NDA";
		$this->layout->layout='default';
		$this->layout->render('nda',$data);	
	}
	
	
	
	public function area_of_expertise(){
		$data['experts_area'] = $this->call(array(
								"option"=>"com_survey",
								"task"=>"api.expertArea"
							  ));
		$this->layout->layout='ajax';
		$this->layout->render('area_of_expertise',$data);	
	}
	
	public function mass_emails(){
		/*Expert List*/
		$data['experts'] = $this->call(array(
								"option"=>"com_survey",
								"task"=>"api.expertList"
							  ));
		/*End List*/
		/*Claims List*/
		$data['claims'] = $this->call(array(
								"option"=>"com_survey",
								"task"=>"api.surveyList"
							  ));
		/*End Claims List*/
		$data['templates'] = $this->call(array(
								"option"=>"com_survey",
								"task"=>"api.getAllTemplates"
							  ));
		$this->layout->render('mass_emails',$data);	
	}
	
	public function mass_payments(){
		 $data =  array(
                "option"=>"com_survey",
                "task"=>"api.unpaid_expert_report_list"				
                );
     $data['get_data'] = $this->call($data);
     $this->layout->render('unpaid_expert_payment_list',$data);
	}
	
	public function add_discount(){
		if(isset($_POST) && count($_POST)>0){
			$getData = $this->input->post();
			$getData['discount']['option'] = "com_survey";
			$getData['discount']['task'] = "api.add_discount";
			$data =  array(
                "option"=>"com_survey",
                "task"=>"api.add_discount",
				"name"=>$getData['discount']['name']
                );			
			$getID = $this->call($getData['discount']);
			if($getID>0){
				redirect('api/discount_list');
			} else if($getID=='-1'){
				$this->session->set_flashdata('message','<p class="alert alert-warning">Coupon Code is already exist.</p>');
				redirect('api/add_discount');
			} else {
				$this->session->set_flashdata('message','<p class="alert alert-warning">Server bust, Please try after sometime.</p>');
				redirect('api/add_discount');
			}
		}
		$this->layout->render('add_discount');	
	}
	
	public function discount_list(){
       $data =  array(
                "option"=>"com_survey",
                "task"=>"api.discountList"				
                );
        $data['get_data'] = $this->call($data);        
        $this->layout->render('discount_list',$data);
    }
	
    public function order_list(){
       $data =  array(
                "option"=>"com_survey",
                "task"=>"api.orderList"				
                );
        $data['get_data'] = $this->call($data);        
        $this->layout->render('order_list',$data);
    }
    
    public function survey_list($id=null){
       $data =  array(
                "option"=>"com_survey",
                "task"=>"api.surveyList",
                'project_id'=>$id				
                );
        $data['get_data'] = $this->call($data);  
		$data['project_id'] = $id;
        $this->layout->render('survey_list',$data);
    }
	
	public function update_project_claims(){
		if(isset($_POST) && count($_POST)>0){
			$data =  array(
                "option"=>"com_survey",
                "task"=>"api.update_project_claims",
                'project_id'=>$this->input->post('project_id')		
                );
			$this->call($data);
		}
		die;
	}
	
    public function findExpertWithCode($code=null,$mode=null){
        $code = $_REQUEST['code'];
        $mode = $_REQUEST['mode'];
        $data =  array(
                "option"=>"com_survey",
                "task"=>"api.findExpertWithCode",
                'code'=>$_REQUEST['code'],	
                'mode' =>$_REQUEST['mode']		
                );
        $data = $this->call($data);
		print_r($data);
		die;
	}
	
	public function add_new_claims(){
        $project_id = $this->input->post('project_id');
        $claim = $this->input->post('claim');
        $data =  array(
                "option"=>"com_survey",
                "task"=>"api.add_new_claims",
                'project_id'=>$project_id,	
                'claim' =>$claim		
                );
        $data = $this->call($data);
		echo $data;
		die;
	}
	
	public function getAllExperts(){
	   $data = $this->call(array(
								"option"=>"com_survey",
								"task"=>"api.expertList"
							  ));
		print_r($data);
		die;
	}
    public function emailSend($post= null){
        $email_message = $_REQUEST['email_message'];
        $expertise_code = $_REQUEST['expertise_code'];
        $selected_expert = $_REQUEST['selected_expert'];
        $post = 'email_message='.$email_message.'&expertise_code='.$expertise_code.'&selected_expert='.$selected_expert;
        $data =  array(
                "option"=>"com_survey",
                "task"=>"api.emailSend",
               "email_message"=>$email_message,
               "expertise_code"=>$expertise_code,
			   "survey_id"=>$_REQUEST['survey_id'],
               "selected_expert"=>implode(",",$selected_expert)
                );
        $data = $this->call($data);
        $data_arr = json_decode($data);
        $this->session->set_flashdata('email_msg',$data_arr->msg);
        $site_url = site_url().'api/order_list';
        redirect($site_url);
    }
	
	public function sendMassEmail($post= null){
        $email_message = $this->input->post('email_message');
        $expertise_code = $this->input->post('expertise_code');
        $selected_expert = $this->input->post('selected_expert');
		$subject = $this->input->post('subject');
		$dataR = array("msg"=>"Error");
        if(isset($_REQUEST['survey_id'])){
			$data =  array(
                "option"=>"com_survey",
                "task"=>"api.emailMSend",
               "email_message"=>$email_message,
               "expertise_code"=>$expertise_code,
			   "survey_id"=>$this->input->post('survey_id'),
			   "subject"=>$subject,
               "selected_expert"=>implode(",",$selected_expert)
                );
			$dataR = $this->call($data);
		} else{
			$data =  array(
                "option"=>"com_survey",
                "task"=>"api.emailMSend",
               "email_message"=>$email_message,
               "expertise_code"=>$expertise_code,
               "selected_expert"=>implode(",",$selected_expert),
			   "subject"=>$subject,
             );
			$dataR = $this->call($data);
		}  

        $data_arr = json_decode($dataR);
        $this->session->set_flashdata('email_msg',$data_arr->msg);
        $site_url = site_url().'api/mass_emails';
        redirect($site_url);
    }
	
	public function addTemplate(){
		$post = $this->input->post();
		 $data =  array(
			"option"=>"com_survey",
			"task"=>"api.addTemplate",
			"s"=>$post['s'],
			"te"=>$post['te']
		);		
		$get_data = $this->call($data);
		echo $get_data;
		die;
	}
	
	public function save_qus(){	
		$post = $this->input->post();
        $postData = json_encode($post);      
	    $data =  array(
			"option"=>"com_survey",
			"task"=>"api.saveQus",
			"postData"=> $postData
			);		
		$get_data = $this->call($data);
		if($get_data == true) {
            $site_url = site_url().'api/question_list/'.$post['survey_id'];
            redirect($site_url);    
        }  else {
            $site_url = site_url().'api/start_questionare/'.$post['survey_id'];
            redirect($site_url); 
        }
    }
    
    public function cancel_qus(){
        $site_url = site_url().'api/order_list';
        redirect($site_url); 
    }
   
    public function deleteQuestionare($surveyID=null){        
        $data =  array(
                "option"=>"com_survey",
                "task"=>"api.deleteQuestionare",
                'surveyID'=>$surveyID				
                );
        $get_data = $this->call($data);
    }
    public function emailSendCancel(){
        $site_url = site_url().'api/home';
        redirect($site_url);
    }
    public function email($surveyID=null){
       $data =  array(
                "option"=>"com_survey",
                "task"=>"api.emailView",
                'surveyID'=>$surveyID				
                );
        $data['get_data'] = $this->call($data);
        
        $this->layout->render('email_view',$data);
    }
    public function start_questionare($survey_id=null){
        $data =  array(
                "option"=>"com_survey",
                "task"=>"api.start_questionare",
                'survey_id'=>$survey_id	
                );
        $data['get_data'] = $this->call($data);
        $this->layout->render('start_questionare',$data);  
    } 
	
	public function view_activity($report_type=0,$expert_id=null,$surveyID=null,$target=null,$target_product=null){
		$data =  array(
                "option"=>"com_survey",
                "task"=>"api.viewactivity",
                'expertID'=>$expert_id,
                'surveyID'=>$surveyID,
				'target'=>$target,
				'target_product'=>$target_product,
				'report_type'=>$report_type
                );
        $list = $this->call($data);
		if(!empty($list)){
			$getActivityData = json_decode($list);
			if(count($getActivityData)>0){
?>

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
  google.charts.load("current", {packages:["timeline"]});
  google.charts.setOnLoadCallback(drawChart);
  function drawChart() {

    var container = document.getElementById('example5.1');
    var chart = new google.visualization.Timeline(container);
    var dataTable = new google.visualization.DataTable();
    dataTable.addColumn({ type: 'string', id: 'Room' });
    dataTable.addColumn({ type: 'string', id: 'Name' });
    dataTable.addColumn({ type: 'date', id: 'Start' });
    dataTable.addColumn({ type: 'date', id: 'End' });
    dataTable.addRows([
		<?php 
			$i=0;
			foreach($getActivityData as $activity){
				$i++;
				$sY = date('Y',strtotime($activity->start_time));
				$sM = date('m',strtotime($activity->start_time)) - 1;
				$sD = date('d',strtotime($activity->start_time));
				$sH = date('H',strtotime($activity->start_time));
				$sI = date('i',strtotime($activity->start_time));
				$sS = date('s',strtotime($activity->start_time));
				
				$eY = date('Y',strtotime($activity->end_time));
				$eM = date('m',strtotime($activity->end_time)) - 1;
				$eD = date('d',strtotime($activity->end_time));
				$eH = date('H',strtotime($activity->end_time));
				$eI = date('i',strtotime($activity->end_time));
				$eS = date('s',strtotime($activity->end_time));
				echo "[ '".addslashes(str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),' ',$activity->description))."','".$i."', new Date(".$sY.",".$sM.",".$sD.",".$sH.",".$sI.",".$sS."),  new Date(".$eY.",".$eM.",".$eD.",".$eH.",".$eI.",".$eS.") ]";
				if($i<count($getActivityData)){
					echo ",";
				}
			}
		?>
	  ]);

    var options = {
      timeline: { showRowLabels: true }
    };

    chart.draw(dataTable, options);
  }

</script>
<!--<div class='container'>-->
<div class="row" style='margin-left:20px;'>
<div class='col-lg-12' style='margin-top:20px;'>
<div id="example5.1" style="height:150px;width:837px;"></div>
</div>
<div class='col-md-6'>
<table class='table table-condensed table-striped table-bordered table-hover'>
	<thead>
		<tr>
			<th>Element</th>
			<th>Time spent (HH:mm)</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			$i=0;
			foreach($getActivityData as $time){
				list($hour,$minute,$second) = explode(':', $time->duration);
				$timeShow =  sprintf('%02d:%02d', $hour, $minute); 
		?>
			<tr>
				<td><?php echo $time->description;?></td>
				<td><?php echo $timeShow;?></td>
			</tr>
		<?php
				$i++;
			}
		?>  
	</tbody>
</table>
</div>
</div><!--</div>-->
	<?php } else {
	echo "Sorry no acctivity found";
	 }


		} else {
			echo "Sorry no acctivity found";
		}
		die;
	}
    
    public function view_report($expert_id=null,$surveyID=null,$target=null,$target_product=null){
        $data =  array(
                "option"=>"com_survey",
                "task"=>"api.viewreport",
                'expertID'=>$expert_id,
                'surveyID'=>$surveyID,
				'target'=>urldecode($target),
				'target_product'=>urldecode($target_product)
                );
        $html = $this->call($data);
		if(!empty($html)){
			redirect($html);
		} else {
			echo "Sorry no report";
		}
		die;
		/*$data['get_data'] = $this->call($data);
		$files = json_decode($data['get_data'],true);
		
		if($files['file_name']!=""){
			redirect($files);
		} else if($files['html']!=""){
			echo $files['html'];
			die;
		} else {
			$this->layout->render('view_report',$data);
		}*/
    }
    
    public function question_list($id=null){
       $data =  array(
                "option"=>"com_survey",
                "task"=>"api.questionList",
                'survey_id'=>$id			
                );
        $data['get_data'] = $this->call($data);
        $this->layout->render('question_list',$data);
    }
    public function expert_feedback($id=null){
        $data =  array(
                "option"=>"com_survey",
                "task"=>"api.feedback",
                'id'=>$id			
            );
        $data['get_data'] = $this->call($data);
        
        $this->layout->render('expert_feedback',$data);
    }
    public function home(){
       /* if($this->session->userdata('logged_in')){       	   
		   $this->layout->title_for_layout = 'Dashboard';
		   $this->layout->layout='default';
		   $this->layout->render('home');
        }  else  {
			redirect('user/login', 'refresh');
        }   */   
		$this->layout->title_for_layout = 'Dashboard';
	   $this->layout->layout='default';
	   $this->layout->render('home');
	}
	
	function paypal_setting(){
		$dataPost =  array(
                "option"=>"com_survey",
                "task"=>"api.getPaypalData"				
                );
		$data['get_data'] = $this->call($dataPost);
		$this->layout->title_for_layout = 'Paypal Setting';
		$this->layout->layout='default';
		$this->layout->render('paypal',$data);
	}
	
	function paypal(){
		$postData = $this->input->post();
		if(count($postData)>0){
			$dataPost =  array(
                "option"=>"com_survey",
                "task"=>"api.getPaypalUpdate",
				"postData"=>json_encode($postData)
            );
			$data = $this->call($dataPost);
		}
		redirect('api/paypal_setting');
	}
	
    public function view_order_list(){
       $data =  array(
                "option"=>"com_survey",
                "task"=>"api.getSurveyList"				
                );
        $data = $this->call($data);
        
        $data['get_data'] = $this->call($data);        
    }
    
     public function project_list(){
       $data =  array(
                "option"=>"com_survey",
                "task"=>"api.projectList"				
                );
        $data['get_data'] = $this->call($data);
        $this->layout->render('project_list',$data);
    }
    
    
    public function expert_list(){
       $data =  array(
                "option"=>"com_survey",
                "task"=>"api.expertList"				
                );
        $data['get_data'] = $this->call($data);
        $this->layout->render('expert_list',$data);
    }
    public function edit_expert($id){
       $data =  array(
                "option"=>"com_survey",
                "task"=>"api.expertEdit",
                'id'=>$id				
                );
        $data['get_data'] = $this->call($data);
        
        $this->layout->render('edit_expert',$data);
    }
    public function report_list(){
       $data =  array(
                "option"=>"com_survey",
                "task"=>"api.reportList"				
                );
        $data['get_data'] = $this->call($data);
        $this->layout->render('report_list',$data);
    }
	
	public function update_report_price(){
        $data =  array(
                "option"=>"com_survey",
                "task"=>"api.update_report_price",
                'p'=>$this->input->post('p'),
                'v'=>$this->input->post('v'),	
                );
        $msg = $this->call($data);
		echo $msg;
		die;
    }
	
	public function show_report_price(){
        $data =  array(
                "option"=>"com_survey",
                "task"=>"api.show_report_price",
                'p'=>$this->input->post('p'),
                's'=>$this->input->post('s'),	
                );
        $msg = $this->call($data);
		echo $msg;
		die;
    }
	
    public function saveExpertDetail(){
        $data =  array(
                "option"=>"com_survey",
                "task"=>"api.saveExpertDetail",
                'name'=>$_REQUEST['first_name'],	
                'last_name'=>$_REQUEST['last_name'],
                'company_name'=>$_REQUEST['company_name'],
                'address'=>$_REQUEST['address'],
                'city'=>$_REQUEST['city'],
                'state'=>$_REQUEST['state'],
                'zip'=>$_REQUEST['zip'],
                'country'=>$_REQUEST['country'],
                'email'=>$_REQUEST['email'],
                'phone'=>$_REQUEST['phone'],
                'web'=>$_REQUEST['web']			
                );
        $msg = $this->call($data);
        $this->session->set_flashdata('expert_msg',$msg);
        $site_url = site_url().'api/expert_list';
        redirect($site_url);
    }
	
	public function saveUser(){
		$data =  array(
                "option"=>"com_survey",
                "task"=>"api.saveExpertDetail",
                'name'=>$_REQUEST['first_name'],	
                'last_name'=>$_REQUEST['last_name'],
                'company_name'=>$_REQUEST['company_name'],
                'address'=>$_REQUEST['address'],
                'city'=>$_REQUEST['city'],
                'state'=>$_REQUEST['state'],
                'zip'=>$_REQUEST['zip'],
                'country'=>$_REQUEST['country'],
                'email'=>$_REQUEST['email'],
                'phone'=>$_REQUEST['phone'],
                'web'=>$_REQUEST['web'],
				'id'=>$_REQUEST['id']
                );
        $msg = $this->call($data);
        $this->session->set_flashdata('expert_msg',$msg);
        $site_url = site_url().'api/saveUser';
        redirect($site_url);
	}
    
    public function expert_unpublish($cid){
        $data = array(
                'option'=>'com_survey',
                'task'=>"api.expert_unpublish",
                'cid'=>$cid
                );
        $data = $this->call($data);
        $site_url = site_url().'api/expert_list';
        redirect($site_url);
    }
	
	public function delete_experts(){
		$data = 0;
		/*if($this->input->post('t')==1){
			$data = array(
                'option'=>'com_survey',
                'task'=>"api.expert_unpublish",
                'cid'=>$this->input->post('experts')
                );
			$data = $this->call($data);
		} else {
			$data = array(
                'option'=>'com_survey',
                'task'=>"api.expert_publish",
                'cid'=>$this->input->post('experts')
                );
			$data = $this->call($data);
		}*/
		$data = array(
			'option'=>'com_survey',
			'task'=>"api.expert_see_list",
			'cid'=>$this->input->post('experts'),
			't'=>$this->input->post('t'),
			);
		$data = $this->call($data);
        echo $data;die;
    }
	
    
    public function expert_publish($cid=null){ 
        $data = array(
                'option'=>'com_survey',
                'task'=>"api.expert_publish",
                'cid'=>$cid
                );
        $data = $this->call($data);
        $site_url = site_url().'api/expert_list';
        redirect($site_url);
    }
    public function delete_expert(){
        $data = array(
                'option'=>'com_survey',
                'task'=>"api.expert_publish",
                'cid'=>$cid
                );
        $data = $this->call($data);
        $site_url = site_url().'api/deleteFeedback';
        redirect($site_url);
    }
    public function new_expert(){
      $this->layout->render('new_expert');
    }
	
	public function mass_payment_initiate(){
		if(isset($_POST) && count($_POST)>0){
			$userRawData = $this->input->post('user_list');
			$errorCodeList = array(
				'10001'=>'Invalid account number. OR The transaction could not be loaded OR Transaction refused because of an invalid argument.',
				'10002'=>'The user account is locked',
				'10004'=>'The number of input records is greater than maximum allowed. OR The number of input records is less than or equal to zero. OR The note string length exceeds the maximum limit of 4000 characters. OR The amount is missing. OR The currency is missing. OR Currency is not supported. OR The amount is not a valid number.',
				'10007'=>'Permission denied. You do not have permissions to make this API call.',
				'10014'=>'API call was rate limited. The API call has been denied as it has exceeded the permissible call rate limit.',
				'10301'=>'The user is not allowed to send money through Mass Pay',
				'10303'=>'Account is restricted',
				'10304'=>'The user account has unconfirmed email',
				'10305'=>'The user account needs to have its sending limit removed in order to make a mass payment.',
				'10306'=>'The user\'s international account needs to have its sending limit removed in order to make a mass payment',
				'10307'=>'The user account is receive only and therefore cannot send payments out',
				'10308'=>'Masspay server configuration error. There is some configuration error.',
				'10309'=>'Masspay server unavailable.',
				'10310'=>'Unable to create payment.',
				'10311'=>'Unable to submit payments for masspay',
				'10312'=>'The masspay server has reported errors.',
				'10313'=>'The masspay input file includes invalid data.',
				'10314'=>'The input to the masspay server is incorrect.',
				'10317'=>'The masspay input file includes invalid Email',
				'10320'=>'Internal Error',
				'10321'=>'The account does not have sufficient funds to do this masspay',
				'10327'=>'The masspay input file includes invalid UserID'
			);
			if($userRawData !=""){
				try{
					$userList = json_decode($userRawData,true);
					//Sandbox
					$paypalUrl = "https://api-3t.sandbox.paypal.com/nvp";
					$postPaymentArray['USER'] = 'sandbox_api1.claimcharts.info';
					$postPaymentArray['PWD'] = 'QMUV2W9U396B6EH7';
					$postPaymentArray['SIGNATURE'] = 'AFcWxV21C7fd0v3bYYYRCpSSRl31AGb49r5B19Z3LkJqrFDKoq61dqdC';
					/*Live*/
					/*$paypalUrl = "https://api-3t.paypal.com/nvp";
					$postPaymentArray['USER'] = 'sales_api1.claimcharts.info';
					$postPaymentArray['PWD'] = '5GG5A25GY36NHXNB';
					$postPaymentArray['SIGNATURE'] = 'AiPC9BjkCyDFQXbSkoZcgqH3hpacAKlmS8Gd1OGg2-UMzxrIKP0lO9Z8'; 
					*/
					
					$postPaymentArray['METHOD'] = 'MassPay';
					$postPaymentArray['VERSION'] = '204';
					$postPaymentArray['CURRENCYCODE'] = 'USD';
					$postPaymentArray['RECEIVERTYPE'] = 'EmailAddress';
					$postPaymentArray['EMAILSUBJECT'] = 'Payment to researchers';
					for ($i = 0; $i < count($userList); $i++) {
						$postPaymentArray['L_EMAIL'.$i] = $userList[$i]['business_id'];
						$postPaymentArray['L_AMT'.$i] = $userList[$i]['amount'];
						$postPaymentArray['L_NOTE'.$i] = 'Payment for creating report in claimcharts';
					}
					$curl = curl_init();
					curl_setopt($curl, CURLOPT_URL, $paypalUrl);
					curl_setopt($curl, CURLOPT_VERBOSE, 1);
					curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($curl, CURLOPT_POST, true);
					curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($postPaymentArray));
					$response = curl_exec($curl);
					curl_close($curl);
					$httpResponseAr = explode('&',$response);
					$status = array();
					foreach ($httpResponseAr as $i => $value){
						$tmpAr = explode("=", $value);
						if(sizeof($tmpAr) > 1){
							$status[$tmpAr[0]] = $tmpAr[1];
						}
					}
					/*ho "<pre>";
					print_r($status);*/
					$userAfterPaymentArray = array();
					if($status['ACK'] == "Success") {
						for ($i = 0; $i < count($userList); $i++) {
							$userAfterPaymentArray[] = array('expert_id'=>$userList[$i]['expert_id'],'survey_id'=>$userList[$i]['survey_id'],'report_id'=>$userList[$i]['report_id'],'amount'=>$userList[$i]['amount'],'busness_email'=>$userList[$i]['business_id'],'message'=>$status['ACK'],'error_code'=>'','create_date'=>date('Y-m-d H:i:s'),'payment_timestamp'=>urldecode($status['TIMESTAMP']),'correlationid'=>$status['CORRELATIONID'],'build'=>$status['BUILD'],'payment_done'=>1);
						}
					} else if($status['ACK'] == "Failure"){
						for ($i = 0; $i < count($userList); $i++) {
							$message = "";
							if(isset($status['L_ERRORCODE'.$i])){
								/*Payment Error*/
								$message = $status['L_ERRORCODE'.$i];
							}
							$userAfterPaymentArray[] = array('expert_id'=>$userList[$i]['expert_id'],'survey_id'=>$userList[$i]['survey_id'],'report_id'=>$userList[$i]['report_id'],'amount'=>$userList[$i]['amount'],'busness_email'=>$userList[$i]['business_id'],'message'=>$message,'error_code'=>$status['L_ERRORCODE'.$i],'create_date'=>date('Y-m-d H:i:s'),'payment_timestamp'=>urldecode($status['TIMESTAMP']),'correlationid'=>$status['CORRELATIONID'],'build'=>$status['BUILD'],'payment_done'=>0);
						}
					}
					
					/*int_r($userAfterPaymentArray);*/
					if(count($userAfterPaymentArray)>0){
						$data = array(
                'option'=>'com_survey',
                'task'=>"api.expert_mass_payment",
                'user_payment_data'=>json_encode($userAfterPaymentArray)
                );
						/*int_r($data);*/
       			$callData =$this->call($data);
						/*int_r($callData);*/
						if(isset($callData['message'])){
							$message=$callData['message']; 
						}else {
							$message="Server has reported errors."; 
						}
					} else {
						$message="Server has reported errors."; 
					}
				}catch(Exception $e){
					$message="Server has reported errors.";
				}
			} else {
				$message="No data is posted";
			}
		} else {
			$message="No data is posted";
		}
		echo $message;
		die;
	}
	
    public function call($data){
        $curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => '1',
			CURLOPT_URL => 'https://experts.synpat.com/index.php',
			CURLOPT_USERAGENT => 'Collect Data',
			CURLOPT_POST => 1,
			CURLOPT_POSTFIELDS => $data
		));        
        $resp = curl_exec($curl);
		/*echo "<pre>";
		print_r($resp);
		die;*/
		return $resp;
    } 
}
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
    
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
       public function __construct()
        {
            
            parent::__construct();
    
            $this->load->library('layout');

		$this->layout->add_css('public/libs/jqueryui/ui-lightness/jquery-ui-1.10.4.custom.min.css');

		$this->layout->add_css('public/libs/bootstrap/css/bootstrap.min.css');

		$this->layout->add_css('public/libs/font-awesome/css/font-awesome.min.css');

		$this->layout->add_css('public/libs/fontello/css/fontello.css');

		$this->layout->add_css('public/libs/animate-css/animate.min.css');

		$this->layout->add_css('public/libs/nifty-modal/css/component.css');

		$this->layout->add_css('public/libs/magnific-popup/magnific-popup.css');

		$this->layout->add_css('public/libs/ios7-switch/ios7-switch.css');

		$this->layout->add_css('public/libs/pace/pace.css');

		$this->layout->add_css('public/libs/sortable/sortable-theme-bootstrap.css');

		$this->layout->add_css('public/libs/bootstrap-datepicker/css/datepicker.css');

		$this->layout->add_css('public/libs/jquery-icheck/skins/all.css');

		$this->layout->add_css('public/css/style.css');

		$this->layout->add_css('public/css/style-responsive.css');
    		$this->load->model('user_model');
    
    		$this->layout->auto_render=false;	
    		$this->layout->layout='default';
        }
    public function index()
    {
        /*if(!isset($this->session->userdata['type'])){
            $this->session->set_flashdata('error','Please login first!');
            $this->layout->auto_render=false;	
            $this->layout->layout='default';
            redirect('user/login');
    		}
            else
            {
                redirect('api/home');
            }*/
			redirect('api/home');
    }
	public function forgot_password(){
		if(isset($_POST) && count($_POST)>0){
			$postData = $this->input->post('forgot');
			if(isset($postData['email']) && !empty($postData['email'])){
				$updatePassword = $this->simpleloginsecure->edit_password($postData['email'],'','admin123');
				if($updatePassword){
					$this->load->library('email');
					$this->email->from('no-reply@claimcharts.info', 'ClaimCharts.info');
					$this->email->to($postData['email']);					 
					$this->email->subject('Recover Password');
					$this->email->message('Your Password is: admin123');
					if($this->email->send()) {
						$this->session->set_flashdata("email_sent","Email sent successfully.");
					} else {
						 $this->session->set_flashdata("email_sent","Error in sending Email.");
					}
					redirect('user/login');
				} else {
					redirect('user/login');
				}
			} else{
				redirect('user/login');
			}
		} else {
			redirect('user/login');
		}
	}
    public function login()
	{	   
	//   print_r($this->session->userdata); 
    if($this->session->userdata('logged_in'))
    {
        redirect('dashboard/home');
    }
	  if(isset($_POST) && count($_POST)>0){

			/**/

			$postUserData = $this->input->post();
           // $this->simpleloginsecure->create('admin','admin@admin.com','admin123','1234567890','1','true');
            //die;
			$suceessLogin = $this->simpleloginsecure->login($postUserData['user']['email'],$postUserData['user']['password']);
            //echo $this->db->last_query();
           
            
			if($suceessLogin){
                $this->session->userdata('logged_in');
				redirect('api/home');

			} else {
				$this->session->set_flashdata('message','Enter wrong email and password.');

				redirect('user/login');

			}

		} else {

			$this->layout->auto_render=false;		

			$this->layout->layout='login';

			$this->layout->title_for_layout = 'Backyard Synpat Login';		

			$this->layout->render('user/login');

		}
	}
    public function logout(){
        $this->simpleloginsecure->logout();
        	redirect('user/login');
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
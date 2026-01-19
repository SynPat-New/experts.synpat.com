<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->layout->auto_render=false;
		$this->layout->layout='default';
    }
    public function index()
    {
                
       if($this->session->userdata('logged_in'))
       {
         $session_data = $this->session->userdata('logged_in');
         $data['username'] = $session_data['username'];
         $this->layout->render('home');
       }
       else
       {
         //If no session, redirect to login page
         redirect('user/login', 'refresh');
       }
    }
    public function home()
	{
	   //print_r($this->session->userdata); 
       if($this->session->userdata('logged_in'))
       {       	   
	   $this->layout->title_for_layout = 'Dashboard';
       $this->layout->layout='default';
       $this->layout->render('home');
       }
       else
       {
         //If no session, redirect to login page
         redirect('user/login', 'refresh');
       }              
	}
    public function order()
	{	   
	   $this->layout->title_for_layout = 'Dashboard';
       $this->layout->layout='default';
       $this->layout->render('order');
	}
    public function project()
	{
	   $this->layout->title_for_layout = 'Dashboard';
       $this->layout->layout='default';
       $this->layout->render('projects');
	}
    public function expert()
	{
	   $this->layout->title_for_layout = 'Dashboard';
       $this->layout->layout='default';
       $this->layout->render('experts');
	}
    public function report()
	{
	   $this->layout->title_for_layout = 'Dashboard';
       $this->layout->layout='default';
       $this->layout->render('reports');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
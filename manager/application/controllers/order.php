<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->layout->auto_render=false;
		$this->layout->layout='default';
        $this->load->model('order_model');
    }
    function OrderList() {		
            $curl = curl_init();
            curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => '1',
			CURLOPT_URL => 'http://experts.synpat.com/index.php?option=com_survey&task=order.list',
			CURLOPT_USERAGENT => 'Collect Data',
			CURLOPT_POST => 1,
			CURLOPT_POSTFIELDS => array(
				'access_code' => '12345',
				'license_number' => 'DEMO'.date('dm'),
				'license_status'=>'0'
			)
		));
        
         $resp = curl_exec($curl);
         echo 'Curl Response '. $resp;
         die;
	}
}
?>
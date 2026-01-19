<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('getUserNotification'))
{
    function getUserNotification(){
		$CI = &get_instance();
		$user_session_id = $CI->session->userdata('id');
		$query = $CI->db->select('*')->from('notifications')->where('user_id',$user_session_id)->order_by('id','DESC')->get();
		$data=array();
		if($query->num_rows()>0){
			foreach($query->result() as $row){
				$data[] = $row;
			}
		}	
		return $data;
    }

	function get_menu_arr(){
		$CI = &get_instance();
		$user_session_id = $CI->session->userdata('id');
		$query = $CI->db->select('*')->from('user_page_access_level as u')->join('pages','u.page_id=pages.id')->where('u.user_id',$user_session_id)->get();
		//echo $CI->db->last_query();
		$data=array();
		if($query->num_rows()>0){
			foreach($query->result() as $row){
				$data[] = $row;
			}
		}	
		return $data;
    }
	
	function getUserPageAssigned(){
		/*Check Which Page Assign to him*/
		$CI = &get_instance();
		$user_session_id = $CI->session->userdata('id');
		$where = "( p.page_url = 'leads/litigation' OR p.page_url = 'leads/market')";
		$query = $CI->db->select('count(*)')->from('pages as p')->join('user_page_access_level as u', 'u.page_id = p.id')->where('u.user_id',$user_session_id)->where($where)->get();
		return $query->row();
	}
	
	function getUserTaskList(){
		$CI = &get_instance();
		$CI->load->model('opportunity_model');
		$user_session_id = $CI->session->userdata('id');
		$getTaskData = $CI->opportunity_model->waitingApproval($user_session_id);
		return $getTaskData;
	}
}
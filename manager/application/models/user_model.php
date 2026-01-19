<?php
class User_model extends CI_Model {
    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    public function login($username,$password)
    {
        //return $this->db->get_where('login',array('username' =>$data['username'],'password' => md5($data['password'])))->limit;
        $this -> db -> select('id, username, password');
        $this -> db -> from('login');
        $this -> db -> where('username', $username);
        $this -> db -> where('password', MD5($password));
        $this -> db -> limit(1);
        $query = $this -> db -> get();
        echo $this->db->last_query();
        die;
        if($query -> num_rows() == 1)
        {
         return $query->result();
        }
        else
        {
         return false;
        }
        //return $query;
        //echo $query;
    }
}
?>
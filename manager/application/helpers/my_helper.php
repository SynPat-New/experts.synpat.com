<?php
function is_logged_in(){
    $user = $this->session->userdata();
    if(!isset($user))
    {
        return false;
    }
    else
    {
        return true;
    }
}
?>
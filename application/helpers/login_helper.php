<?php 

function is_logged_in() {
    // Get current CodeIgniter instance
    $CI =& get_instance();
    // We need to use $CI->session instead of $this->session
    $user = $CI->session->userdata('user_name');
    // $first_name = $CI->session->userdata('first_name');
    // $middle_name = $CI->session->userdata('middle_name');
    // $last_name = $CI->session->userdata('last_name');
    // $email = $CI->session->userdata('email');
    if (!isset($user)) { return false; } else { return $CI->session->userdata; }
    
}

?>
<?php 
class UserloginModel extends CI_Model
{
    public function __construct() {
        parent::__construct();
    }
    public function login_auth()
    {    
        $user_name = $this->input->post('user_name'); 
        $password = $this->input->post('password'); 
        $this->db->where('user_name', $user_name);
        $this->db->where('deleted_at is NULL');
       
        $query = $this->db->get('users');

        if($query->num_rows() > 0)
        {
            foreach($query->result() as $row)
            {
                if($row->is_active == 1)
                {   
                    $input_password =  md5($password);
                    if($row->password == $input_password)
                    {
                        $this->session->set_userdata('id', $row->id);
                        $this->session->set_userdata('user_name', $row->user_name);
                        $this->session->set_userdata('first_name', $row->first_name);
                        $this->session->set_userdata('middle_name', $row->middle_name);
                        $this->session->set_userdata('last_name', $row->last_name);
                        $this->session->set_userdata('email', $row->email);
                        $this->session->set_userdata('user_type_id', $row->user_type_id);
                    }
                    else
                    {
                        return 'Enter valid user name and password!';
                    }
                }
                else
                {
                    return 'Username is inactive in the system, Contact to administrator!';
                }
            }
        }
        else
        {
         return 'Username does not exist in the system!';
        }
    }
}

?>
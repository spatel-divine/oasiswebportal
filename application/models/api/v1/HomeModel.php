<?php 
class HomeModel extends CI_Model{
    public function __construct() {
        parent::__construct();
   	}
    // function: signUp()
    // It is used to save user data into database
   	public function signUp(){
        $birth_date='';
        if(isset($_POST['birth_date']) && $_POST['birth_date']){
            $birth_date=$this->input->post('birth_date');
            $birth_date=date("Y-m-d",strtotime(str_replace('/','-',$birth_date)));
        }
   		$data = array(
            'user_name' => $this->input->post('user_name'),
            'password' => md5($this->input->post('password')),
            'first_name' => $this->input->post('first_name'),
            'middle_name' => $this->input->post('middle_name'),
            'last_name' => $this->input->post('last_name'),
            'birth_date' => $birth_date,
            'gender' => $this->input->post('gender'),
            'blood_group' => $this->input->post('blood_group'),
            'address' => $this->input->post('address'),
            'zip_code' => $this->input->post('zip_code'),
            'mobile_number' => $this->input->post('mobile_number'),
            'alternate_mobile' => $this->input->post('alternate_mobile'),
            'email' => $this->input->post('email'),
            'edu_qualification' => $this->input->post('edu_qualification'),
            'occupation' => $this->input->post('occupation'),
            'languages_known' => $this->input->post('languages_known'),
            'marital_status' => $this->input->post('marital_status'),
            'is_active' => 1,
            'created_at'=>date('Y-m-d H:i:s'),
        );
        $user=$data;
        $result=$this->db->insert('users', $data);
        if($result==1){
            $data=array();
            $user_id=$this->db->insert_id();
            $data['created_by']=$user_id;
            $this->db->where('id',$user_id);
            $this->db->update('users',$data);
            $user['id']=$user_id;
            $user['created_by']=$user_id;
            // start to send 'Sign Up Mail To Admin'
            $email_template=getEmailTemplateByTitle('Sign Up Mail To Admin');
            if($email_template){
                $from_email='';
                if(isset($email_template->from_email) && $email_template->from_email){
                    $from_email=$email_template->from_email;
                }
                $to_email='webmaster@oasismovement.in';
                $subject='';
                if(isset($email_template->subject) && $email_template->subject){
                    $subject=$email_template->subject;
                }
                $view_user_link=base_url().'Management/add_user/'.$user_id;
                $msg_content='';
                if(isset($email_template->content) && $email_template->content){
                    $msg_content = $email_template->content;
                    $msg_content = str_replace("##view_user_link##", $view_user_link, $msg_content);
                }
                sendMail($from_email,$to_email,$subject,$msg_content);
            }
            // end to send 'Sign Up Mail To Admin'
            return $user;
        }
        return $result;
   	}
    // function: checkUniqueUserName($user_name)
    // It is used to check for unique user name for user
    public function checkUniqueUserName($user_name){
        $query=$this->db->query("SELECT * FROM users WHERE user_name='".$user_name."' AND deleted_at IS NULL");
        if($query->num_rows()>0){
            return false;
        }
        return true;
    }
    // function: checkUniqueEmail($email)
    // It is used to check for unique email id for user
    public function checkUniqueEmail($email){
        $query=$this->db->query("SELECT * FROM users WHERE email='".$email."' AND deleted_at IS NULL");
        if($query->num_rows()>0){
            return false;
        }
        return true;
    } 
    // function: checkLogin()
    // It is used to check for authenticate user
    public function checkLogin(){
        $result=array();
        $user_name=$this->input->post('user_name');
        $password=md5($this->input->post('password'));
        $query=$this->db->query("SELECT u.*, r.role_name, ut.user_type FROM users u LEFT JOIN roles r ON u.role_id=r.id AND r.is_active=1 AND r.deleted_at IS NULL LEFT JOIN user_types ut ON u.user_type_id=ut.id AND ut.is_active=1 AND ut.deleted_at IS NULL WHERE u.user_name='".$user_name."' AND u.password='".$password."' AND u.deleted_at IS NULL");
        if($query->num_rows()>0){
            $row=$query->row();
            if(isset($row->is_active) && $row->is_active==0){
                $result['status']=1; //user is inactive
            }else{
                $result['user']=$row;  
                $result['status']=2; // valid user
            }
        }else{
            $result['status']=0; // invalid user name or password
        }
        return $result;
    }
    // function: checkForValidEmail($email)
    // It is used to check for authenticate user
    public function checkForValidEmail($email){
        $result=array();
        $query=$this->db->query("SELECT * FROM users WHERE email='".$email."' AND deleted_at IS NULL");
        if($query->num_rows()>0){
            $row=$query->row();
            if(isset($row->is_active) && $row->is_active==0){
                $result['status']=1; //user is inactive
            }else{
                $result['user']=$row;  
                $result['status']=2; // valid user
            }
        }else{
            $result['status']=0; // invalid user
        }
        return $result;
    }
    // function: sendForgotPasswordEmail($user)
    // It is used to send reset password link email to user
    public function sendForgotPasswordEmail($user){
        // start to send forgot password email
        $email_template=getEmailTemplateByTitle('Forgot Password');
        if($email_template){
            $user_id=$user->id;
            $reset_password_code=getRandomCode();
            $from_email='';
            if(isset($email_template->from_email) && $email_template->from_email){
                $from_email=$email_template->from_email;
            }
            $to_email=$user->email;
            $subject='';
            if(isset($email_template->subject) && $email_template->subject){
                $subject=$email_template->subject;
            }
            $fullname='';
            if(isset($user->first_name) && $user->first_name){
                $fullname.=$user->first_name;
            }
            if(isset($user->last_name) && $user->last_name){
                if($fullname){
                    $fullname.=' ';
                }
                $fullname.=$user->last_name;
            }
            $reset_password_link=base_url().'reset_password_form_api?id='.base64_encode($user_id).'&code='.base64_encode($reset_password_code);
            $msg_content='';
            if(isset($email_template->content) && $email_template->content){
                $msg_content = $email_template->content;
                $msg_content = str_replace("##fullname##", $fullname, $msg_content);
                $msg_content = str_replace("##reset_password_link##", $reset_password_link, $msg_content);
            }
            $result=sendMail($from_email,$to_email,$subject,$msg_content);
            if($result){
                $data=array(
                    'reset_password_request'=>1,
                    'reset_password_code'=>$reset_password_code,
                    'updated_by'=>$user_id,
                    'updated_at'=>date('Y-m-d H:i:s')
                );
                $this->db->where('id',$user_id);
                $this->db->update('users',$data);
                return 1;
            }else{
                return 2;
            }
        }
        // end to send forgot password email 
    } 
    // function: checkForValidUser($id,$code)
    // It is used to check for authenticate user
    public function checkForValidUser($id,$code){
        $result=array();
        $query=$this->db->query("SELECT * FROM users WHERE id='".$id."' AND reset_password_request='1' AND reset_password_code='".$code."'");
        if($query->num_rows()>0){
            return true;
        }
        return false;
    }
    // function: resetPassword()
    // It is used to reset password
    public function resetPassword(){
        $user_id=base64_decode($this->input->post('user_id'));
        $data=array(
            'password'=>md5($this->input->post('password')),
            'reset_password_request'=>0,
            'reset_password_code'=>'',
            'updated_by'=>$user_id,
            'updated_at'=>date('Y-m-d H:i:s')
        );
        $this->db->where('id',$user_id);
        $result=$this->db->update('users',$data);
        return $result;
    }
    // function: getTotalOmPrograms($year='')
    // It is used to get Total Om Program by user_id
    public function getTotalOmPrograms($year=''){
        $yearcondition='';
        if($year){
            $yearcondition=" AND (YEAR(bm.start_date)='".$year."') ";
        }
        $query=$this->db->query("SELECT count(*) AS totalomprograms FROM  batch_master bm WHERE bm.deleted_at IS NULL ".$yearcondition);
        if($query->num_rows()>0){
            $row=$query->row();
            return $row->totalomprograms;
        }
    }
    // function: geLatestStories()
    // It is used to fetch latest 3 share post
    public function geLatestStories(){
        $query=$this->db->query("SELECT sp.* FROM share_post sp WHERE sp.is_active=1 AND sp.deleted_at IS NULL ORDER BY sp.created_at DESC LIMIT 3");
        if($query->num_rows()>0){
            return $query->result();
        }
    }
    // function: getProfileDetails()
    // It is used to fetch profile details by login id
    public function getProfileDetails(){
        $jwt = new JwtToken();
        $received_Token = $this->input->request_headers('Authorization');
        $user = $jwt->GetTokenData($received_Token);
        if(isset($user['user_id']) && $user['user_id']){
            $query=$this->db->query("SELECT * FROM users WHERE id='".$user['user_id']."'");
            if($query->num_rows()>0){
                return $query->row();
            }
        }
    }
    // function: changeProfile()
    // It is used to update profile data of login
    public function changeProfile(){
        $jwt = new JwtToken();
        $received_Token = $this->input->request_headers('Authorization');
        $user = $jwt->GetTokenData($received_Token);
        if(isset($user['user_id']) && $user['user_id']){
            $user_id=$user['user_id'];
            $birth_date='';
            if(isset($_POST['birth_date']) && $_POST['birth_date']){
                $birth_date=$this->input->post('birth_date');
                $birth_date=date("Y-m-d",strtotime(str_replace('/','-',$birth_date)));
            }
            $data = array(
                'first_name' => $this->input->post('first_name'),
                'middle_name' => $this->input->post('middle_name'),
                'last_name' => $this->input->post('last_name'),
                'birth_date' => $birth_date,
                'gender' => $this->input->post('gender'),
                'blood_group' => $this->input->post('blood_group'),
                'address' => $this->input->post('address'),
                'zip_code' => $this->input->post('zip_code'),
                'mobile_number' => $this->input->post('mobile_number'),
                'alternate_mobile' => $this->input->post('alternate_mobile'),
                'email' => $this->input->post('email'),
                'edu_qualification' => $this->input->post('edu_qualification'),
                'occupation' => $this->input->post('occupation'),
                'languages_known' => $this->input->post('languages_known'),
                'marital_status' => $this->input->post('marital_status'),
                'updated_by'=>$user_id,
                'updated_at'=>date('Y-m-d H:i:s')
            );
            $this->db->where('id',$user_id);
            $result=$this->db->update('users',$data);
            return $result;
        }
    }
    // function: checkUniqueEmailEdit($email)
    // It is used to check for unique email id for user
    public function checkUniqueEmailEdit($email){
        $jwt = new JwtToken();
        $received_Token = $this->input->request_headers('Authorization');
        $user = $jwt->GetTokenData($received_Token);
        $user_id='';
        if(isset($user['user_id']) && $user['user_id']){
            $user_id=$user['user_id'];
        }
        $query=$this->db->query("SELECT * FROM users WHERE email='".$email."' AND deleted_at IS NULL AND id!='".$user_id."'");
        if($query->num_rows()>0){
            return false;
        }
        return true;
    } 
    public function checkOldPassword($old_password){
        $user=$this->getProfileDetails();
        if(isset($user->password) && $user->password && $user->password!=md5($old_password)){
            return false;
        }
        return true;
    }
    // function: changePassword()
    // It is used to update profile data of login
    public function changePassword(){
        $jwt = new JwtToken();
        $received_Token = $this->input->request_headers('Authorization');
        $user = $jwt->GetTokenData($received_Token);
        if(isset($user['user_id']) && $user['user_id']){
            $user_id=$user['user_id'];
            $data = array(
                'password' => md5($this->input->post('password')),
                'updated_by'=>$user_id,
                'updated_at'=>date('Y-m-d H:i:s')
            );
            $this->db->where('id',$user_id);
            $result=$this->db->update('users',$data);
            return $result;
        }
    }
}
<?php 
class UserModel extends CI_Model{
    public function __construct(){
        parent::__construct();
   	}
   	// function: getTotalUser()
    // It is used to fetch total user from database
    public function getTotalUser(){
        $query=$this->db->query("SELECT COUNT(*) as total_rows FROM users u LEFT JOIN states s ON u.state_id=s.id AND s.is_active=1 AND s.deleted_at IS NULL LEFT JOIN districts d ON u.district_id=d.id AND d.is_active=1 AND d.deleted_at IS NULL LEFT JOIN city_town_villages c ON u.city_id=c.id AND c.is_active=1 AND c.deleted_at IS NULL LEFT JOIN roles r ON u.role_id=r.id AND r.is_active=1 AND r.deleted_at IS NULL WHERE u.is_active=1 AND u.deleted_at IS NULL");
        if($query->num_rows()>0){
            $row=$query->row();
            if(isset($row->total_rows) && $row->total_rows){
                return $row->total_rows;
            }
        }
        return 0;
    }
    // function: getUserList()
    // It is used to fetch user list from database
    public function getUserList($limit,$offset){
        $query=$this->db->query("SELECT TO_BASE64(u.id) as user_id, u.user_name, s.state_name, d.district_name, c.village_name, DATE_FORMAT(u.birth_date, '%d-%m-%Y') as birth_date, r.role_name FROM users u LEFT JOIN states s ON u.state_id=s.id AND s.is_active=1 AND s.deleted_at IS NULL LEFT JOIN districts d ON u.district_id=d.id AND d.is_active=1 AND d.deleted_at IS NULL LEFT JOIN city_town_villages c ON u.city_id=c.id AND c.is_active=1 AND c.deleted_at IS NULL LEFT JOIN roles r ON u.role_id=r.id AND r.is_active=1 AND r.deleted_at IS NULL WHERE u.is_active=1 AND u.deleted_at IS NULL LIMIT ".$offset.",".$limit);
        if($query->num_rows()>0){
            return $query->result();
        }
    }
    // function: addUser()
    // It is used to add user data into database
   	public function addUser(){
   		$jwt = new JwtToken();
        $received_Token = $this->input->request_headers('Authorization');
        $user = $jwt->GetTokenData($received_Token);
        $user_id='';
        if(isset($user['user_id']) && $user['user_id']){
            $user_id=$user['user_id'];
        }
        $birth_date='';
        if(isset($_POST['birth_date']) && $_POST['birth_date']){
            $birth_date=$this->input->post('birth_date');
            $birth_date=date("Y-m-d",strtotime(str_replace('/','-',$birth_date)));
        }
   		$data = array(
   			'first_name' => $this->input->post('first_name'),
            'middle_name' => $this->input->post('middle_name'),
            'last_name' => $this->input->post('last_name'),
            'user_name' => $this->input->post('user_name'),
            'password' => md5($this->input->post('password')),
            'role_id' => $this->input->post('role_id'),
            'birth_date' => $birth_date,
            'gender' => $this->input->post('gender'),
            'blood_group' => $this->input->post('blood_group'),
            'user_type_id' => $this->input->post('user_type_id'),
            'mobile_number' => $this->input->post('mobile_number'),
            'alternate_mobile' => $this->input->post('alternate_mobile'),
            'email' => $this->input->post('email'),
            'edu_qualification' => $this->input->post('edu_qualification'),
            'occupation' => $this->input->post('occupation'),
            'languages_known' => $this->input->post('languages_known'),
            'marital_status' => $this->input->post('marital_status'),
            'state_id' => $this->input->post('state_id'),
            'district_id' => $this->input->post('district_id'),
            'city_id' => $this->input->post('city_id'),
            'address' => $this->input->post('address'),
            'zip_code' => $this->input->post('zip_code'),
            'is_active' => 1,
            'created_by' => $user_id,
            'created_at'=> date('Y-m-d H:i:s')
        );
        $result=$this->db->insert('users', $data);
        $email_template=getEmailTemplateByTitle('Add User Mail To User');
        if($result==1 && isset($data['email']) && $data['email'] && $email_template){
        	// start to send 'Add User Mail To User'
            $from_email='';
            if(isset($email_template->from_email) && $email_template->from_email){
                $from_email=$email_template->from_email;
            }
            $to_email=$data['email']; 
            $subject='';
            if(isset($email_template->subject) && $email_template->subject){
                $subject=$email_template->subject;
            }
            $msg_content='';
            if(isset($email_template->content) && $email_template->content){
                $msg_content = $email_template->content;
                $newuser='';
                if(isset($data['first_name']) && $data['first_name']){
                	$newuser.=$data['first_name'];
                }
                if(isset($data['last_name']) && $data['last_name']){
                	if($newuser!=''){
                		$newuser.=' ';
                	}
                	$newuser.=$data['last_name'];
                }
                $msg_content = str_replace("##newuser##", $newuser, $msg_content);
                $username='';
                if(isset($data['user_name']) && $data['user_name']){
                	$username=$data['user_name'];
                }
                $msg_content = str_replace("##username##", $username, $msg_content);
                $password='';
                if(isset($_POST['password']) && $_POST['password']){
                	$password=$this->input->post('password');
                }
                $msg_content = str_replace("##password##", $password, $msg_content);
            }
            sendMail($from_email,$to_email,$subject,$msg_content);
            // end to send 'Add User Mail To User'
        }
        return $result;
   	}
   	// function: getUserById()
    // It is used to fetch user details from database
   	public function getUserById($user_id){
   		$query=$this->db->query("SELECT * FROM users WHERE id=".$user_id);
        if($query->num_rows()>0){
            return $query->row();
        }
   	}
   	// function: checkEditUniqueEmail($email)
    // It is used to check for unique email id for user
    public function checkEditUniqueEmail($email){
        $user_id='';
        if(isset($_POST['user_id']) && $_POST['user_id']){
            $user_id=base64_decode($this->input->post('user_id'));
        }
        $query=$this->db->query("SELECT * FROM users WHERE email='".$email."' AND id!='".$user_id."' AND deleted_at IS NULL");
        if($query->num_rows()>0){
            return false;
        }
        return true;
    }
   	// function: updateUser()
    // It is used to update user data into database
   	public function updateUser(){
   		$jwt = new JwtToken();
        $received_Token = $this->input->request_headers('Authorization');
        $user = $jwt->GetTokenData($received_Token);
        $user_id='';
        if(isset($user['user_id']) && $user['user_id']){
            $user_id=$user['user_id'];
        }
        $id=base64_decode($this->input->post('user_id'));
        $userdetails=$this->getUserById($id);
        $is_password_changed=0;
        $password=$this->input->post('password');
        if(isset($userdetails->password) && isset($_POST['password']) && $userdetails->password!=$_POST['password']){
        	$is_password_changed=1;
        	$password=md5($this->input->post('password'));
        }
        $birth_date='';
        if(isset($_POST['birth_date']) && $_POST['birth_date']){
            $birth_date=$this->input->post('birth_date');
            $birth_date=date("Y-m-d",strtotime(str_replace('/','-',$birth_date)));
        }
   		$data = array(
   			'first_name' => $this->input->post('first_name'),
            'middle_name' => $this->input->post('middle_name'),
            'last_name' => $this->input->post('last_name'),
            'password' => $password,
            'role_id' => $this->input->post('role_id'),
            'birth_date' => $birth_date,
            'gender' => $this->input->post('gender'),
            'blood_group' => $this->input->post('blood_group'),
            'user_type_id' => $this->input->post('user_type_id'),
            'mobile_number' => $this->input->post('mobile_number'),
            'alternate_mobile' => $this->input->post('alternate_mobile'),
            'email' => $this->input->post('email'),
            'edu_qualification' => $this->input->post('edu_qualification'),
            'occupation' => $this->input->post('occupation'),
            'languages_known' => $this->input->post('languages_known'),
            'marital_status' => $this->input->post('marital_status'),
            'state_id' => $this->input->post('state_id'),
            'district_id' => $this->input->post('district_id'),
            'city_id' => $this->input->post('city_id'),
            'address' => $this->input->post('address'),
            'zip_code' => $this->input->post('zip_code'),
            'updated_by' => $user_id,
            'updated_at'=> date('Y-m-d H:i:s')
        );
        $this->db->where('id',$id);
        $result=$this->db->update('users', $data);
        $email_template=getEmailTemplateByTitle('Change Password Mail To User');
        if($user_id!=$id && $result==1 && $is_password_changed==1 && isset($data['email']) && $data['email'] && $email_template){
        	// start to send 'Change Password Mail To User'
            $from_email='';
            if(isset($email_template->from_email) && $email_template->from_email){
                $from_email=$email_template->from_email;
            }
            $to_email=$data['email']; 
            $subject='';
            if(isset($email_template->subject) && $email_template->subject){
                $subject=$email_template->subject;
            }
            $msg_content='';
            if(isset($email_template->content) && $email_template->content){
                $msg_content = $email_template->content;
                $fullname='';
                if(isset($data['first_name']) && $data['first_name']){
                	$fullname.=$data['first_name'];
                }
                if(isset($data['last_name']) && $data['last_name']){
                	if($fullname!=''){
                		$fullname.=' ';
                	}
                	$fullname.=$data['last_name'];
                }
                $msg_content = str_replace("##fullname##", $fullname, $msg_content);
                $newpassword='';
                if(isset($_POST['password']) && $_POST['password']){
                	$newpassword=$this->input->post('password');
                }
                $msg_content = str_replace("##newpassword##", $newpassword, $msg_content);
            }
            sendMail($from_email,$to_email,$subject,$msg_content);
            // end to send 'Change Password Mail To User'
        }
        return $result;
   	}
   	// function: deleteUser()
    // It is used to delete user details from database 
    public function deleteUser($id){
    	$jwt = new JwtToken();
        $received_Token = $this->input->request_headers('Authorization');
        $user = $jwt->GetTokenData($received_Token);
        $user_id='';
        if(isset($user['user_id']) && $user['user_id']){
            $user_id=$user['user_id'];
        }
        $data = array(
            'deleted_by'=> $user_id,
            'deleted_at'=>date('Y-m-d H:i:s')
        );
        $this->db->where('id',$id);
        $result=$this->db->update('users', $data);
        return $result;
    }
    // function: checkUserNameExist()
    // It is used to check for username exist or not in database.
    public function checkUserNameExist($user_name){
        $query=$this->db->query("SELECT * FROM users WHERE user_name='".$user_name."'");
        if($query->num_rows()>0){
            return $query->row();
        }
    }
    // function: checkRoleIdExist()
    // It is used to check for role id exist or not in database.
    public function checkRoleIdExist($role_id){
        $query=$this->db->query("SELECT * FROM roles WHERE id='".$role_id."' AND deleted_at IS NULL");
        if($query->num_rows()>0){
            return $query->row();
        }
    }
    // function: insertBulkUser()
    // It is used to insert bulk users into 'users' table from csv file
    public function insertBulkUser($insert_arr,$password_arr){
        $result=$this->db->insert_batch('users', $insert_arr);
        if($result && isset($insert_arr) && $insert_arr){
        	for($i=0;$i<count($insert_arr);$i++){
        		$email_template=getEmailTemplateByTitle('Add User Mail To User');
        		if(isset($insert_arr[$i]['email']) && $insert_arr[$i]['email'] && $email_template){
	        		// start to send 'Add User Mail To User'
		            $from_email='';
		            if(isset($email_template->from_email) && $email_template->from_email){
		                $from_email=$email_template->from_email;
		            }
		            $to_email=$insert_arr[$i]['email']; 
		            $subject='';
		            if(isset($email_template->subject) && $email_template->subject){
		                $subject=$email_template->subject;
		            }
		            $msg_content='';
		            if(isset($email_template->content) && $email_template->content){
		                $msg_content = $email_template->content;
		                $newuser='';
		                if(isset($insert_arr[$i]['first_name']) && $insert_arr[$i]['first_name']){
		                	$newuser.=$insert_arr[$i]['first_name'];
		                }
		                if(isset($insert_arr[$i]['last_name']) && $insert_arr[$i]['last_name']){
		                	if($newuser!=''){
		                		$newuser.=' ';
		                	}
		                	$newuser.=$insert_arr[$i]['last_name'];
		                }
		                $msg_content = str_replace("##newuser##", $newuser, $msg_content);
		                $username='';
		                if(isset($insert_arr[$i]['user_name']) && $insert_arr[$i]['user_name']){
		                	$username=$insert_arr[$i]['user_name'];
		                }
		                $msg_content = str_replace("##username##", $username, $msg_content);
		                $password='';
		                if(isset($password_arr[$i]['pwd']) && $password_arr[$i]['pwd']){
		                	$password=$password_arr[$i]['pwd'];
		                }
		                $msg_content = str_replace("##password##", $password, $msg_content);
		            }
		            sendMail($from_email,$to_email,$subject,$msg_content);
		            // end to send 'Add User Mail To User'
        		}
        	}
        }
        return $result;
    }
}
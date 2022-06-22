<?php 
class UserModel extends CI_Model
{
    public function __construct() {
        parent::__construct();
        $this->session_data = is_logged_in();
    }
   /**
    * Insert the user in database...
    */
    public function insert_user()
    { 
        try { 
            $data = array(
                'first_name' => $this->input->post('first_name'),
                'middle_name' => $this->input->post('middle_name'),
                'last_name' => $this->input->post('last_name'),
                'user_name' => $this->input->post('user_name'),
                'password' => md5($this->input->post('password')),
                'role_id' => $this->input->post('role_id'), // Need to add dynamic role id
                'birth_date' => date("y-m-d", strtotime($this->input->post('dob')))  ,
                'gender' => $this->input->post('gender'),
                'blood_group' => $this->input->post('blood_group'),
                'user_type_id' => $this->input->post('user_type_id'),
                'mobile_number' => $this->input->post('mobile_number'),
                'alternate_mobile' => $this->input->post('alternate_mobile_no'),
                'occupation' => $this->input->post('occupation'),
                'marital_status' => $this->input->post('marital_status'),
                'email' => $this->input->post('email'),
                'languages_known' => $this->input->post('language_known'),
                'edu_qualification' => $this->input->post('education_qualification'),
                'state_id' => $this->input->post('state'),
                'district_id' => $this->input->post('district'),
                'city_id' => $this->input->post('city_village'),
                'address' => $this->input->post('address'),
                'zip_code' => $this->input->post('pin'),
                'created_by' => $this->session_data['id'],
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_by'=> $this->session_data['id'],
                'updated_at'=>date('Y-m-d H:i:s'),
                'is_active' => 1
            );
            // user data inserting in to the database.
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
        catch (Exception $e) {
            //alert the user then kill the process
              return $e->getMessage();
        }

    }   
    
    /**
     * Update the user type...
     */
    public function update_user(){
        $id = $this->input->post('user_id');
        $is_password_changed=0;
        $update_pw =  $this->input->post('password');
        if($this->input->post('password') != $this->input->post('oldpassword')){
            $is_password_changed=1;
            $update_pw =  md5($this->input->post('password'));
        }
        $data = array(
            'first_name' => $this->input->post('first_name'),
            'middle_name' => $this->input->post('middle_name'),
            'last_name' => $this->input->post('last_name'),
            //'user_name' => $this->input->post('user_name'),
            'password' => $update_pw,
            'role_id' => $this->input->post('role_id'), // Need to add dynamic role id
            'birth_date' => date("y-m-d", strtotime($this->input->post('dob')))  ,
            'gender' => $this->input->post('gender'),
            'blood_group' => $this->input->post('blood_group'),
            'user_type_id' => $this->input->post('user_type_id'),
            'mobile_number' => $this->input->post('mobile_number'),
            'alternate_mobile' => $this->input->post('alternate_mobile_no'),
            'occupation' => $this->input->post('occupation'),
            'marital_status' => $this->input->post('marital_status'),
            'email' => $this->input->post('email'),
            'languages_known' => $this->input->post('language_known'),
            'edu_qualification' => $this->input->post('education_qualification'),
            'state_id' => $this->input->post('state'),
            'district_id' => $this->input->post('district'),
            'city_id' => $this->input->post('city_village'),
            'address' => $this->input->post('address'),
            'zip_code' => $this->input->post('pin'),
            'updated_by'=> $this->session_data['id'],
            'updated_at'=>date('Y-m-d H:i:s'),
            'is_active' => 1
        );

        $this->db->where('id', $id);
        $result=$this->db->update('users', $data);
        $user_id=$this->session->userdata('id');
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
    }

    /**
	 * Get the users from database.
	 */
	public function get_user_list($id = ""){

        $this->db->select('users.*, roles.role_name, districts.district_name, states.state_name, city_town_villages.village_name');    
        $this->db->from('users');
        $this->db->join('states', 'users.state_id = states.id' , 'left');
        $this->db->join('districts', 'users.district_id = districts.id' , 'left');
        $this->db->join('city_town_villages', 'users.city_id = city_town_villages.id', 'left');
        $this->db->join('roles', 'users.role_id = roles.id', 'left');
        $this->db->where('users.is_active', 1);
        $this->db->where('users.deleted_at IS NULL', NULL);

        if($id != "") {
            $this->db->like('users.id', $id);
        }
        $query = $this->db->get();
        return $query->result();
    }

   

     /**
	 * Get the users type from database.
	 */
	public function get_user_type($id = ""){
        if($id != "") {
            $this->db->like('id', $id);
        }
        $query = $this->db->get("user_types");
        return $query->result();
    }

    public function check_user_name($user_name = "", $user_id = ""){
        if($user_id != '') {
            return $this->db
                ->where('user_name', $user_name)
                ->where('id !=', $user_id)
                ->where('deleted_at IS NULL')
                ->count_all_results('users');
        }else{
            return $this->db
            ->where('user_name', $user_name)
            ->where('deleted_at IS NULL')
            ->count_all_results('users');
        }

    }

    public function change_user_password(){

        $data = array(
            'password' =>  md5($this->input->post('password')),
            'updated_by' => $this->session_data['id']
            
        );
        $this->db->where('id', $this->input->post('user_id'));
        $update = $this->db->update('users', $data);

         // set flash data
         if($update){
            return true;
         }

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
    }
    // function: getFacilitatorList()
    // It is used to fetch users list which has user type 'Facilitator' 
    public function getFacilitatorList(){
        $query=$this->db->query("SELECT u.id, CONCAT_WS(' ', u.first_name, u.last_name) AS user_full_name FROM users u INNER JOIN user_types ut ON u.user_type_id=ut.id AND ut.user_type='Facilitator' AND ut.is_active=1 AND ut.deleted_at IS NULL WHERE u.is_active=1 AND u.deleted_at IS NULL");
        if($query->num_rows()>0){
            return $query->result();
        }
    } 
    // function: getCoFacilitatorList()
    // It is used to fetch users list which has user type 'Co-Facilitator' 
    public function getCoFacilitatorList(){
        $query=$this->db->query("SELECT u.id, CONCAT_WS(' ', u.first_name, u.last_name) AS user_full_name FROM users u INNER JOIN user_types ut ON u.user_type_id=ut.id AND ut.user_type='Co-Facilitator' AND ut.is_active=1 AND ut.deleted_at IS NULL WHERE u.is_active=1 AND u.deleted_at IS NULL");
        if($query->num_rows()>0){
            return $query->result();
        }
    }
    // function: getCoordinatorList()
    // It is used to fetch users list which has user type 'Co-Ordinator' 
    public function getCoordinatorList(){
        $query=$this->db->query("SELECT u.id, CONCAT_WS(' ', u.first_name, u.last_name) AS user_full_name FROM users u INNER JOIN user_types ut ON u.user_type_id=ut.id AND ut.user_type='Co-Ordinator' AND ut.is_active=1 AND ut.deleted_at IS NULL WHERE u.is_active=1 AND u.deleted_at IS NULL");
        if($query->num_rows()>0){
            return $query->result();
        }
    }
    // function: getVolunteerList()
    // It is used to fetch users list which has user type 'Volunteer' 
    public function getVolunteerList(){
        $query=$this->db->query("SELECT u.id, CONCAT_WS(' ', u.first_name, u.last_name) AS user_full_name FROM users u INNER JOIN user_types ut ON u.user_type_id=ut.id AND ut.user_type='Volunteer' AND ut.is_active=1 AND ut.deleted_at IS NULL WHERE u.is_active=1 AND u.deleted_at IS NULL");
        if($query->num_rows()>0){
            return $query->result();
        }
    }
    // function: getParticipantList()
    // It is used to fetch users list which has user type 'Volunteer' 
    public function getParticipantList(){
        $query=$this->db->query("SELECT u.id, CONCAT_WS(' ', u.first_name, u.last_name) AS user_full_name FROM users u INNER JOIN user_types ut ON u.user_type_id=ut.id AND ut.user_type='Participant' AND ut.is_active=1 AND ut.deleted_at IS NULL WHERE u.is_active=1 AND u.deleted_at IS NULL");
        if($query->num_rows()>0){
            return $query->result();
        }
    }
    // function: getUserList()
    // It is used to fetch user list from database
    public function getUserList($condition=''){
        $query=$this->db->query("SELECT id, CONCAT_WS(' ', first_name, last_name) AS full_name FROM users WHERE deleted_at IS NULL ".$condition);
        if($query->num_rows()>0){
            return $query->result();
        }
    }
    // function: getUserById()
    // It is used to fetch user by user id from database
    public function getUserById($user_id){
        $query=$this->db->query("SELECT * FROM users WHERE id='".$user_id."'");
        if($query->num_rows()>0){
            return $query->row();
        }
    }
    // function: updateActiveDeactiveUser()
    // It is used to  update Active/Deactive status of user into database
    public function updateActiveDeactiveUser(){
        $data = array(
            'active_deactive_date'=>date('Y-m-d'),
            'active_deactive_reason_type'=>trim($this->input->post('active_deactive_reason_type')),
            'active_deactive_reason'=>trim($this->input->post('active_deactive_reason')),
            'updated_by'=> $this->session_data['id'],
            'updated_at'=>date('Y-m-d H:i:s')
        );
        $is_active=$this->input->post('is_active');
        if($is_active==2){
            $data['deleted_at']=date('Y-m-d H:i:s');
        }else{
            $data['is_active']=$is_active;
        }
        $this->db->where('id',$this->input->post('user'));
        $result=$this->db->update('users', $data);
        return $result;
    }
    // function: checkAddUniqueEmail($email)
    // It is used to check for unique email id for user
    public function checkAddUniqueEmail($email){
        $query=$this->db->query("SELECT * FROM users WHERE email='".$email."' AND deleted_at IS NULL");
        //echo $this->db->last_query();die();
        if($query->num_rows()>0){
            return false;
        }
        return true;
    }
    // function: checkEditUniqueEmail($email)
    // It is used to check for unique email id for user
    public function checkEditUniqueEmail($email){
        $user_id='';
        if(isset($_POST['user_id']) && $_POST['user_id']){
            $user_id=$this->input->post('user_id');
        }
        $query=$this->db->query("SELECT * FROM users WHERE email='".$email."' AND id!='".$user_id."' AND deleted_at IS NULL");
        if($query->num_rows()>0){
            return false;
        }
        return true;
    }
}

?>
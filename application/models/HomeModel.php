<?php 
class HomeModel extends CI_Model{
    public function __construct() {
        parent::__construct();
   	}
   	// function: addAssignRights()
	// It is used to add rights into database
   	public function addAssignRights(){
		$this->load->library('controllerlist');
    	$old_assign_rights_arr=$this->getOldAssignRightsList();
		$insert_arr=array();
		$list=$this->controllerlist->getControllers();
		if($list){
			foreach ($list as $key => $value) {
				if($value){
					for($i=0;$i<count($value);$i++){
						$controller_name=strtolower($key);
						$method_name=strtolower($value[$i]);
						$controller_name_method_name=$controller_name.$method_name;
						$display_controller_name='';
						if(isset($old_assign_rights_arr['display_controller_name'][$controller_name_method_name]) && $old_assign_rights_arr['display_controller_name'][$controller_name_method_name]!='' && $old_assign_rights_arr['display_controller_name'][$controller_name_method_name]!=null){
							$display_controller_name=$old_assign_rights_arr['display_controller_name'][$controller_name_method_name];
						}
						$display_name='';
						if(isset($old_assign_rights_arr['display_name'][$controller_name_method_name]) && $old_assign_rights_arr['display_name'][$controller_name_method_name]!='' && $old_assign_rights_arr['display_name'][$controller_name_method_name]!=null){
							$display_name=$old_assign_rights_arr['display_name'][$controller_name_method_name];
						}
						$is_active=1;
						if(isset($old_assign_rights_arr['is_active'][$controller_name_method_name]) && $old_assign_rights_arr['is_active'][$controller_name_method_name]!='' && $old_assign_rights_arr['is_active'][$controller_name_method_name]!=null){
							$is_active=$old_assign_rights_arr['is_active'][$controller_name_method_name];
						}
						$insert_arr[] = array(
			            	'controller_name'=>strtolower($key),
			            	'display_controller_name'=>$display_controller_name,
			            	'method_name'=>strtolower($value[$i]),
			            	'display_name'=>$display_name,
			            	'is_active'=>$is_active,
			                'created_at'=>date('Y-m-d H:i:s')
			            );
					}
				}
			}
		}
		$result=$this->db->query("TRUNCATE TABLE  assign_rights_list");
		if($result){
			$this->db->insert_batch('assign_rights_list', $insert_arr); 
			echo "Assign Rights added successfully.";
		}else{
			echo "Sorry, something went wrong!";
		}
    }
    // function: getOldAssignRightsList()
	// It is used to fetch assign rights list from database
    public function getOldAssignRightsList(){
    	$old_assign_rights_arr['display_name']=array();
    	$old_assign_rights_arr['is_active']=array();
    	$query=$this->db->query("SELECT * FROM assign_rights_list");
    	if($query->num_rows()>0){
    		$result=$query->result();
    		foreach($result as $r){
    			$controller_name_method_name=$r->controller_name.$r->method_name;
    			$old_assign_rights_arr['display_controller_name'][$controller_name_method_name]=$r->display_controller_name;
    			$old_assign_rights_arr['display_name'][$controller_name_method_name]=$r->display_name;
    			$old_assign_rights_arr['is_active'][$controller_name_method_name]=$r->is_active;
    		}
    	}
    	return $old_assign_rights_arr;
    }
    // function: getAssignRightsList()
	// It is used to fetch assign rights list from database
    public function getAssignRightsList(){
    	$query=$this->db->query("SELECT * FROM assign_rights_list WHERE is_active=1");
    	if($query->num_rows()>0){
    		return $query->result();
    	}
    }
    // function: assignRights()
	// It is used to assign/edit rights to user or role
    public function assignRights(){
    	$assign_rights_type=$this->input->post('assign_rights_type');
    	$assign_rights_ids=implode(',', $_POST['rights']);
		$data = array(
            'assign_rights_ids'=>$assign_rights_ids,
            'is_active'=>1,
            'updated_by'=>$this->session->userdata('id'),
            'updated_at'=>date('Y-m-d H:i:s')
        );
		if($assign_rights_type=='Role'){
			$query=$this->db->query("SELECT * FROM assign_rights_to_role WHERE role_id='".$this->input->post('role_id')."' AND is_active=1 AND deleted_at IS NULL");
			if($query->num_rows()>0){
				$row=$query->row();
				$this->db->where('id',$row->id);
	    		$result=$this->db->update('assign_rights_to_role', $data);
			}else{
				$data['role_id']=$this->input->post('role_id');
				$data['created_by']=$this->session->userdata('id');
		        $data['created_at']=date('Y-m-d H:i:s');
				$result=$this->db->insert('assign_rights_to_role', $data);
			}
		}else{
			$query=$this->db->query("SELECT * FROM assign_rights_to_user WHERE user_id='".$this->input->post('user_id')."' AND is_active=1 AND deleted_at IS NULL");
			if($query->num_rows()>0){
				$row=$query->row();
				$this->db->where('id',$row->id);
	    		$result=$this->db->update('assign_rights_to_user', $data);
			}else{
				$data['user_id']=$this->input->post('user_id');
				$data['created_by']=$this->session->userdata('id');
	        	$data['created_at']=date('Y-m-d H:i:s');
				$result=$this->db->insert('assign_rights_to_user', $data);
			}
		}
        return $result;
    }
    // function: getAssignRightsByUser()
	// It is used to fetch assign rights by user id from database
    public function getAssignRightsByUser($user_id){
    	$rights_arr=array();
    	$query=$this->db->query("SELECT * FROM assign_rights_to_user WHERE user_id='".$user_id."'");
		if($query->num_rows()>0){
			$row=$query->row();
			$rights_arr=explode(',',$row->assign_rights_ids);
		}
		return $rights_arr;
    }
    // function: getAssignRightsByRole()
	// It is used to fetch assign rights by role id from database
    public function getAssignRightsByRole($role_id){
    	$rights_arr=array();
    	$query=$this->db->query("SELECT * FROM assign_rights_to_role WHERE role_id='".$role_id."'");
		if($query->num_rows()>0){
			$row=$query->row();
			$rights_arr=explode(',',$row->assign_rights_ids);
		}
		return $rights_arr;
    }
}
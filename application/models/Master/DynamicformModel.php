<?php 
class DynamicformModel extends CI_Model{
	public function __construct(){
        parent::__construct();
	}
	// *************** Start Dynamic Feedback Form *******************
	// function: getProgramFeedbackList()
	// It is used to fetch program feedback field list which is not deleted from database
	public function getProgramFeedbackList(){
		$query=$this->db->query("SELECT * FROM program_feedback_form WHERE deleted_at IS NULL");
		if($query->num_rows()>0){
			return $query->result();
		}
	}
	// function: getProgramFeedback()
	// It is used to fetch program feedback field which is not deleted and is active from database
	public function getProgramFeedback(){
		$query=$this->db->query("SELECT * FROM program_feedback_form WHERE is_active=1 AND deleted_at IS NULL ORDER BY sequence_no ASC");
		if($query->num_rows()>0){
			return $query->result();
		}
	}
	// function: insertNewFieldsInDynamicForm()
	// It is used to insert new dynamic fields in dynamic form
	public function insertNewFieldsInDynamicForm($tablename){
		$option_arr=array();
		$j=0;
		$sequence_index=getTotalRecordFromTable($tablename)+1;
		for($i=0;$i<count($_POST['sequence_no']);$i++){
			$data=array();
			$sequence_no=$_POST['sequence_no'][$i];
			if($sequence_no=='' && $sequence_no==null){
				$sequence_no=$sequence_index;
				$sequence_index++;
			}
			$data['sequence_no']=$sequence_no;
			if(isset($_POST['field_name'][$i]) && $_POST['field_name'][$i]){
				$data['field_label']=ucwords($_POST['field_name'][$i]);
				$field_name=$_POST['field_name'][$i];
				$field_name=str_replace("/","or",strtolower($field_name));
				$field_name=str_replace(",","",$field_name);
				$field_name=str_replace(";","",$field_name);
				$field_name=str_replace("-","",$field_name);
				$data['field_name']=str_replace(" ","_",$field_name);
			}
			if(isset($_POST['field_type'][$i]) && $_POST['field_type'][$i]){
				$data['field_type']=$_POST['field_type'][$i];
				if($_POST['field_type'][$i]=='number'){
					if(isset($_POST['min_number'][$i][0])){
						$data['min_number']=$_POST['min_number'][$i][0];
					}
					if(isset($_POST['max_number'][$i][0])){
						$data['max_number']=$_POST['max_number'][$i][0];
					}
				}else if($_POST['field_type'][$i]=='file'){
					if(isset($_POST['max_upload'][$i][0]) && $_POST['max_upload'][$i][0]){
						$data['max_upload']=$_POST['max_upload'][$i][0];
					}
					if(isset($_POST['file_extension'][$i]) && $_POST['file_extension'][$i]){
						$ext=implode("','",$_POST['file_extension'][$i]);
						$data['file_extension']="'".$ext."'";
					}
				}else if($_POST['field_type'][$i]=='date'){
					if(isset($_POST['date_validation'][$i][0])){
						$data['date_validation']=$_POST['date_validation'][$i][0];
						$data['is_readonly']=1;
					}
				}
			}
			if(isset($_POST['is_required'][$i]) && $_POST['is_required'][$i]){
				$data['is_required']=$_POST['is_required'][$i];
			}
			if(isset($data['field_label']) && $data['field_label']){
				if($_POST['field_type'][$i]=='date' || $_POST['field_type'][$i]=='file' || $_POST['field_type'][$i]=='dropdown' || $_POST['field_type'][$i]=='checkbox' || $_POST['field_type'][$i]=='radio'){
					$data['placeholder']='Please Select '.$data['field_label'];
				}else{
					$data['placeholder']='Enter '.$data['field_label'];
				}
			}
			if(isset($_POST['comments'][$i]) && $_POST['comments'][$i]){
				$data['comments']=$_POST['comments'][$i];
			}
			$data['is_active']=1;
			$data['created_by']=$this->session->userdata('id');
			$data['created_at']=date('Y-m-d H:i:s');
			$data['updated_by']=$this->session->userdata('id');
			$data['updated_at']=date('Y-m-d H:i:s');
			$result=$this->db->insert($tablename, $data);
	        if($result==1 && isset($_POST['field_type_option'][$i]) && $_POST['field_type_option'][$i] && $_POST['field_type'][$i]=='dropdown' || $_POST['field_type'][$i]=='checkbox' || $_POST['field_type'][$i]=='radio'){
	            $related_table_id=$this->db->insert_id();
	            $option_value_arr=array_filter($_POST['field_type_option'][$i]);
	            for($k=0;$k<count($option_value_arr);$k++){
					$option_arr[$j]['table_name']=$tablename;
					$option_arr[$j]['related_table_id']=$related_table_id;
					$option_arr[$j]['option_value']=$option_value_arr[$k];
					$option_arr[$j]['is_active']=1;
					$option_arr[$j]['created_by']=$this->session->userdata('id');
					$option_arr[$j]['created_at']=date('Y-m-d H:i:s');
					$option_arr[$j]['updated_by']=$this->session->userdata('id');
					$option_arr[$j]['updated_at']=date('Y-m-d H:i:s');
					$j++;
				}
	        }
		}
		if($option_arr){
			$this->db->insert_batch('dynamic_form_option_table',$option_arr);
		}
	}
	// function: deleteDynamicField()
    // It is used to delete dynamic field from database 
    public function deleteDynamicField($tablename,$field_id){
        $data = array(
            'deleted_by'=>$this->session->userdata('id'),
            'deleted_at'=>date('Y-m-d H:i:s'),
        );
        $this->db->where('id',$field_id);
        $result=$this->db->update($tablename, $data);
       	if($result==1){
	        $this->db->where('table_name',$tablename);
	        $this->db->where('related_table_id',$field_id);
	        $this->db->update('dynamic_form_option_table',$data);
       	}
        return $result;
    }
    // function: getDynamicFieldDetailById()
    // It is used to fetch field details by id and tablename from database 
    public function getDynamicFieldDetailById($tablename,$field_id){
        $query=$this->db->query("SELECT * FROM ".$tablename." WHERE id='".$field_id."'");
        if($query->num_rows()>0){
        	return $query->row();
        }
    }
    // function: updateDynamicFormField()
    // It is used to update dynamic form's field from database 
    public function updateDynamicFormField(){
    	$field_id=base64_decode($this->input->post('field_id'));
		$tablename=$this->input->post('tablename');
		$field_label=ucwords($this->input->post('field_name'));
		$field_name=$this->input->post('field_name');
		$field_name=str_replace("/","or",strtolower($field_name));
		$field_name=str_replace(",","",$field_name);
		$field_name=str_replace(";","",$field_name);
		$field_name=str_replace("-","",$field_name);
		$field_name=str_replace(" ","_",$field_name);
		$field_type=$this->input->post('field_type');
		if($field_type=='date' || $field_type=='file' || $field_type=='dropdown' || $field_type=='checkbox' || $field_type=='radio'){
			$placeholder='Please Select '.$field_label;
		}else{
			$placeholder='Enter '.$field_label;
		}
		$is_required=$this->input->post('is_required');
		$is_active=$this->input->post('is_active');
        $data = array(
        	'field_label'=>$field_label,
        	'field_name'=>$field_name,
        	'placeholder'=>$placeholder,
        	'sequence_no'=>$this->input->post('sequence_no'),
        	'is_required'=>$is_required,
        	'is_active'=>$is_active,
        	'comments'=>trim($this->input->post('comments')),
            'updated_by'=>$this->session->userdata('id'),
            'updated_at'=>date('Y-m-d H:i:s'),
        );
        if($field_type=='number'){
			$data['min_number']=$this->input->post('min_number');
			$data['max_number']=$this->input->post('max_number');
		}
		if($field_type=='file'){
			$data['max_upload']=$this->input->post('max_upload');
			if(isset($_POST['file_extension']) && $_POST['file_extension']){
				$ext=implode("','",$this->input->post('file_extension'));
				$data['file_extension']="'".$ext."'";
			}
		}
		if($field_type=='date'){
			$data['date_validation']=$this->input->post('date_validation');
			$data['is_readonly']=1;
		}
        $this->db->where('id',$field_id);
        $result=$this->db->update($tablename, $data);
        $updated_data[0]=$this->input->post('sequence_no');
        $updated_data[1]=$field_label;
       	$updated_data[2]=ucfirst($field_type);
        if($is_required==1){
        	$updated_data[3]='Yes';
        }else{
        	$updated_data[3]='No';
        }
        if($is_active==1){
        	$updated_data[4]='Active';
        }else{
        	$updated_data[4]='Inactive';
        }
        $updated_data[5]=date('d-m-Y',strtotime(date('Y-m-d H:i:s')));
        $updated_data[6]='<a class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#editField" href="javascript:void(0);" onclick="getDynamicFormFieldData(\''.$this->input->post('field_id').'\');"><i class="fa fa-edit"></i> Edit</a>&nbsp;<a class="btn btn-secondary btn-sm" onclick="deleteDynamicField(\''.$this->input->post('field_id').'\');" href="javascript:void(0);"><i class="fa fa-delete"></i> Delete</a>';
        return $updated_data;
    }
    // function: getPersonalLearningList()
	// It is used to fetch personal learning field list which is not deleted from database
	public function getPersonalLearningList(){
		$query=$this->db->query("SELECT * FROM personal_learning_form WHERE deleted_at IS NULL");
		if($query->num_rows()>0){
			return $query->result();
		}
	}
	// function: getPersonalLearning()
	// It is used to fetch personal learning form field from database which is not deleted and is active 
	public function getPersonalLearning(){
		$query=$this->db->query("SELECT * FROM personal_learning_form WHERE is_active=1 AND deleted_at IS NULL ORDER BY sequence_no ASC");
		if($query->num_rows()>0){
			return $query->result();
		}
	}
	// function: getFeedbackParticipantsList()
	// It is used to fetch feedback participants field list which is not deleted from database
	public function getFeedbackParticipantsList(){
		$query=$this->db->query("SELECT * FROM feedback_for_participants_form WHERE deleted_at IS NULL");
		if($query->num_rows()>0){
			return $query->result();
		}
	}
	// function: getFeedbackParticipant()
	// It is used to fetch feedback for participants form field from database which is not deleted and is active 
	public function getFeedbackParticipant(){
		$query=$this->db->query("SELECT * FROM feedback_for_participants_form WHERE is_active=1 AND deleted_at IS NULL ORDER BY sequence_no ASC");
		if($query->num_rows()>0){
			return $query->result();
		}
	}
	// function: getFeedbackByParticipantsList()
	// It is used to fetch program feedback by participants field list which is not deleted from database
	public function getFeedbackByParticipantsList(){
		$query=$this->db->query("SELECT * FROM program_feedback_by_participants_form WHERE deleted_at IS NULL");
		if($query->num_rows()>0){
			return $query->result();
		}
	}
	// function: getFeedbackByParticipant()
	// It is used to fetch program feedback for participants form field from database which is not deleted and is active 
	public function getFeedbackByParticipant(){
		$query=$this->db->query("SELECT * FROM program_feedback_by_participants_form WHERE is_active=1 AND deleted_at IS NULL ORDER BY sequence_no ASC");
		if($query->num_rows()>0){
			return $query->result();
		}
	}
	// function: getStarParticipantsList()
	// It is used to fetch star participants field list which is not deleted from database
	public function getStarParticipantsList(){
		$query=$this->db->query("SELECT * FROM star_participants_form WHERE deleted_at IS NULL");
		if($query->num_rows()>0){
			return $query->result();
		}
	}
	// function: getStarParticipant()
	// It is used to fetch star participants form field from database which is not deleted and is active 
	public function getStarParticipant(){
		$query=$this->db->query("SELECT * FROM star_participants_form WHERE is_active=1 AND deleted_at IS NULL ORDER BY sequence_no ASC");
		if($query->num_rows()>0){
			return $query->result();
		}
	}
	// function: getImactOnCharacterTraitsList()
	// It is used to fetch  impact on character traits field list which is not deleted from database
	public function getImactOnCharacterTraitsList(){
		$query=$this->db->query("SELECT * FROM impact_on_character_traits_form WHERE deleted_at IS NULL");
		if($query->num_rows()>0){
			return $query->result();
		}
	}
	// function: getImactOnCharacterTraits()
	// It is used to fetch  impact on character traits form field from database which is not deleted and is active 
	public function getImactOnCharacterTraits(){
		$query=$this->db->query("SELECT * FROM impact_on_character_traits_form WHERE is_active=1 AND deleted_at IS NULL ORDER BY sequence_no ASC");
		if($query->num_rows()>0){
			return $query->result();
		}
	}
	// function: getParameterOrCharacteristicsList()
	// It is used to fetch Parameter Or Characteristics List from database which is not deleted and is active 
	public function getParameterOrCharacteristicsList(){
		$query=$this->db->query("SELECT * FROM parameter_or_characteristics_list WHERE is_active=1 AND deleted_at IS NULL ORDER BY sequence_no ASC");
		if($query->num_rows()>0){
			return $query->result();
		}
	}
    // *************** End Dynamic Feedback Form *********************
}
?>
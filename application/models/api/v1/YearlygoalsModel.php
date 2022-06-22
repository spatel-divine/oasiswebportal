<?php 
class YearlygoalsModel extends CI_Model{
    public function __construct() {
        parent::__construct();
   	}
   	// function: getYearlyGoalsList()
    // It is used to get yearly goal list from db by center id from login user id
   	public function getYearlyGoalsList(){
   		$jwt = new JwtToken();
        $received_Token = $this->input->request_headers('Authorization');
        $user = $jwt->GetTokenData($received_Token);
        $user_id='';
        if(isset($user['user_id']) && $user['user_id']){
            $user_id=$user['user_id'];
        }
   		//$query=$this->db->query("SELECT TO_BASE64(pm.id) as program_id, pm.program_name, IF(yg.id IS NOT NULL,1,0) as is_checked, REPLACE(JSON_OBJECTAGG(TO_BASE64(pm.id),yg.id),'\"','\'') as keyvalue FROM program_master pm LEFT JOIN yearly_goals yg ON pm.id=yg.program_id AND yg.is_active=1 AND yg.deleted_at IS NULL AND yg.center_id IN (SELECT id FROM user_centers WHERE user_id='".$user_id."' AND is_active=1 AND deleted_at IS NULL) WHERE pm.is_active=1 AND pm.deleted_at IS NULL GROUP BY pm.id");
        $query=$this->db->query("SELECT TO_BASE64(pm.id) as program_id, pm.program_name, IF(yg.id IS NOT NULL,1,0) as is_checked, yg.id as ygid FROM program_master pm LEFT JOIN yearly_goals yg ON pm.id=yg.program_id AND yg.is_active=1 AND yg.deleted_at IS NULL AND yg.center_id IN (SELECT id FROM user_centers WHERE user_id='".$user_id."' AND is_active=1 AND deleted_at IS NULL) WHERE pm.is_active=1 AND pm.deleted_at IS NULL GROUP BY pm.id");
   		if($query->num_rows()>0){
   			return $query->result();
   		}
   	}
   	// function: checkForCenterId()
    // It is used to add yearly goals by center id from login user id
   	public function checkForCenterId(){
   		$jwt = new JwtToken();
        $received_Token = $this->input->request_headers('Authorization');
        $user = $jwt->GetTokenData($received_Token);
        $user_id='';
        if(isset($user['user_id']) && $user['user_id']){
            $user_id=$user['user_id'];
        }
   		$query=$this->db->query("SELECT id FROM user_centers WHERE user_id='".$user_id."' AND is_active=1 AND deleted_at IS NULL");
   		if($query->num_rows()>0){
   			$row=$query->row();
   			return $row->id;
   		}
   	}
   	// function: addYearlyGoals($centerid)
    // It is used to add yearly goals by center id from login user id
   	public function addYearlyGoals($centerid){
   		$jwt = new JwtToken();
        $received_Token = $this->input->request_headers('Authorization');
        $user = $jwt->GetTokenData($received_Token);
        $user_id='';
        if(isset($user['user_id']) && $user['user_id']){
            $user_id=$user['user_id'];
        }
        $yearlygoalsprogramlist=$this->getYearlyGoalsListArr();
        $updatedyearlygoalsids=array();
        if(isset($_POST['program_ids']) && $_POST['program_ids']){
        	for($i=0;$i<count($_POST['program_ids']);$i++){
                if(isset($_POST['program_ids'][$i]) && $_POST['program_ids'][$i]){
                    //$keyvalue=json_decode(str_replace("'",'"',$_POST['program_ids'][$i]), true);
                    $keyvalue=json_decode($_POST['program_ids'][$i], true);
                    $program_id=key($keyvalue);
                    $yearly_goals_id=$keyvalue[$program_id];
                    if(in_array($program_id,$yearlygoalsprogramlist)){
                        $updatedyearlygoalsids[key($yearlygoalsprogramlist)]=$program_id;
                    }
                    if($yearly_goals_id){
                        $data = array(
                            'center_id'=>$centerid,
                            'program_id'=>base64_decode($program_id),
                            'updated_by'=>$user_id,
                            'updated_at'=>date('Y-m-d H:i:s')
                        );
                        $this->db->where('id',$yearly_goals_id);
                        $this->db->update('yearly_goals', $data);
                    }else{
                        $data = array(
                            'center_id'=>$centerid,
                            'program_id'=>base64_decode($program_id),
                            'created_by'=>$user_id,
                            'created_at'=>date('Y-m-d H:i:s'),
                        );
                        $this->db->insert('yearly_goals', $data);
                    } 
                }
		    }
            // start delete unchecked programs
            $removedyglistarr=array_diff($yearlygoalsprogramlist,$updatedyearlygoalsids);
            $removedygids=implode("','",array_keys($removedyglistarr));
            $removedygids="'".$removedygids."'";
            $result=$this->db->query("DELETE FROM yearly_goals WHERE id IN (".$removedygids.")");
            // end delete unchecked programs
		    return 1;
        }
   	}
    // function: getYearlyGoalsListArr()
    // It is used to get yearly goal list from db by center id from login user id
    public function getYearlyGoalsListArr(){
        $jwt = new JwtToken();
        $received_Token = $this->input->request_headers('Authorization');
        $user = $jwt->GetTokenData($received_Token);
        $user_id='';
        if(isset($user['user_id']) && $user['user_id']){
            $user_id=$user['user_id'];
        }
        $yearlygoalsprogramlist=array();
        $query=$this->db->query("SELECT TO_BASE64(pm.id) as program_id, yg.id as ygid  FROM program_master pm INNER JOIN yearly_goals yg ON pm.id=yg.program_id AND yg.is_active=1 AND yg.deleted_at IS NULL AND yg.center_id IN (SELECT id FROM user_centers WHERE user_id='".$user_id."' AND is_active=1 AND deleted_at IS NULL) WHERE pm.is_active=1 AND pm.deleted_at IS NULL GROUP BY pm.id");
        if($query->num_rows()>0){
            $result=$query->result();
            foreach($result as $r){
                $yearlygoalsprogramlist[$r->ygid]=$r->program_id;
            }
        }
        return $yearlygoalsprogramlist;
    }
    // function: getYearlyGoalsFormDataList()
    // It is used to get data for yearly goals program form list from login user id
    public function getYearlyGoalsFormDataList(){
        $jwt = new JwtToken();
        $received_Token = $this->input->request_headers('Authorization');
        $user = $jwt->GetTokenData($received_Token);
        $user_id='';
        if(isset($user['user_id']) && $user['user_id']){
            $user_id=$user['user_id'];
        }
        $yearlygoalsprogramlist=array();
        $query=$this->db->query("SELECT TO_BASE64(yg.id) as yearly_goals_id, yg.no_of_programs, yg.no_of_beneficiaries, yg.no_of_facilitator_trainees, yg.no_of_facilitators, yg.no_of_volunteers, yg.remark FROM yearly_goals yg WHERE yg.is_active=1 AND yg.deleted_at IS NULL AND yg.center_id IN (SELECT id FROM user_centers WHERE user_id='".$user_id."' AND is_active=1 AND deleted_at IS NULL)");
        if($query->num_rows()>0){
            return $query->result();
        }
    }
    // function: saveYearlyGoalsDetails()
    // It is used to add yearly goals by center id from login user id
    public function saveYearlyGoalsDetails(){
        $jwt = new JwtToken();
        $received_Token = $this->input->request_headers('Authorization');
        $user = $jwt->GetTokenData($received_Token);
        $user_id='';
        if(isset($user['user_id']) && $user['user_id']){
            $user_id=$user['user_id'];
        }
        $yearly_goals_id=base64_decode($this->input->post('yearly_goals_id'));
        if($yearly_goals_id){
            $data = array(
                'no_of_programs'=>$this->input->post('no_of_programs'),
                'no_of_beneficiaries'=>$this->input->post('no_of_beneficiaries'),
                'no_of_facilitator_trainees'=>$this->input->post('no_of_facilitator_trainees'),
                'no_of_facilitators'=>$this->input->post('no_of_facilitators'),
                'no_of_volunteers'=>$this->input->post('no_of_volunteers'),
                'remark'=>$this->input->post('remark'),
                'updated_by'=>$user_id,
                'updated_at'=>date('Y-m-d H:i:s')
            );
            $this->db->where('id',$yearly_goals_id);
            $result=$this->db->update('yearly_goals',$data);
            return $result;
        }
    }
}
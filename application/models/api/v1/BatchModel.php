<?php 
class BatchModel extends CI_Model{
    public function __construct() {
        parent::__construct();
   	}
   	// function: getTotalBatch()
    // It is used to get total batches from db
   	public function getTotalBatch(){
   		$query=$this->db->query("SELECT COUNT(*) as total_rows FROM batch_master bm LEFT JOIN program_master pm ON bm.program_id=pm.id AND pm.is_active=1 AND pm.deleted_at IS NULL WHERE bm.deleted=0");
        if($query->num_rows()>0){
            $row=$query->row();
            if(isset($row->total_rows) && $row->total_rows){
                return $row->total_rows;
            }
        }
        return 0;
   	}
    // function: getBatchList()
    // It is used to get batch list from db
    public function getBatchList($limit,$offset){
        $query=$this->db->query("SELECT TO_BASE64(bm.id) as batch_id, pm.program_name, bm.batch_name, bm.location, bm.start_date, bm.end_date FROM batch_master bm LEFT JOIN program_master pm ON bm.program_id=pm.id AND pm.is_active=1 AND pm.deleted_at IS NULL WHERE bm.deleted=0 LIMIT ".$offset.",".$limit);
        if($query->num_rows()>0){
            return $query->result();
        }
    }
   	// function: addBatch()
    // It is used to add batch data.
   	public function addBatch(){
   		$jwt = new JwtToken();
        $received_Token = $this->input->request_headers('Authorization');
        $user = $jwt->GetTokenData($received_Token);
        $user_id='';
        if(isset($user['user_id']) && $user['user_id']){
            $user_id=$user['user_id'];
        }
        $start_date='';
        if(isset($_POST['start_date']) && $_POST['start_date']){
            $start_date=$this->input->post('start_date');
            $start_date=date("Y-m-d",strtotime(str_replace('/','-',$start_date)));
        }
        $end_date='';
        if(isset($_POST['end_date']) && $_POST['end_date']){
            $end_date=$this->input->post('end_date');
            $end_date=date("Y-m-d",strtotime(str_replace('/','-',$end_date)));
        }
   		$data = array(
            'state_id'=>$this->input->post('state_id'),
            'region_id'=>$this->input->post('region_id'),
            'center_id'=>$this->input->post('center_id'),
            'program_id'=>$this->input->post('program_id'),
            'batch_name'=>trim($this->input->post('batch_name')),
            'start_date'=>$start_date,
            'end_date'=>$end_date,
            'location'=>$this->input->post('location'),
            'no_of_participant_registered'=>$this->input->post('no_of_participant_registered'),
            'group_id'=>$this->input->post('group_id'),
            'group_name'=>trim($this->input->post('group_name')),
            'created_by'=>$user_id,
            'created_at'=>date('Y-m-d H:i:s'),
        );
        $result=$this->db->insert('batch_master', $data);
        if($result==1){
            $batch_id=$this->db->insert_id();
            if(isset($_POST['facilitator']) && $_POST['facilitator']){
                $this->insert_batch_data($batch_id,'batch_facilitator',$_POST['facilitator'],$user_id); 
            }
            if(isset($_POST['co_facilitator']) && $_POST['co_facilitator']){
                $this->insert_batch_data($batch_id,'batch_co_facilitator',$_POST['co_facilitator'],$user_id); 
            }
            if(isset($_POST['coordinator']) && $_POST['coordinator']){
                $this->insert_batch_data($batch_id,'batch_coordinator',$_POST['coordinator'],$user_id); 
            }
            if(isset($_POST['volunteer']) && $_POST['volunteer']){
                $this->insert_batch_data($batch_id,'batch_volunteer',$_POST['volunteer'],$user_id);
            }
            if(isset($_POST['participant']) && $_POST['participant']){
                $this->insert_batch_data($batch_id,'batch_participant',$_POST['participant'],$user_id);
            }
        }
        return $result;
   	}
   	// function: insert_batch_data()
    // It is used to add batch data.
    public function insert_batch_data($batch_id,$tablename,$arr,$user_id){
        if(is_array($arr)){
            $insert_arr=array();
            $arr=array_filter($arr);
            for($i=0;$i<count($arr);$i++){
                if(isset($arr[$i]) && $arr[$i]){
                    $insert_arr[] = array(
                        'batch_id'=>$batch_id,
                        'user_id'=>$arr[$i],
                        'created_by'=> $user_id,
                        'created_at'=>date('Y-m-d H:i:s'),
                    );
                }
            }
            if($insert_arr){
                $this->db->insert_batch($tablename, $insert_arr);
            }
        }
    }
    // function: checkValidEndDate($end_date)
    // It is used to end date greater than start date
    public function checkValidEndDate($end_date,$start_date){
       	$start_date=strtotime(str_replace('/','-',$start_date));
       	$end_date=strtotime(str_replace('/','-',$end_date));
		if($end_date<$start_date){
			return false;
		}
		return true;
    }
    // function: getBatchById()
    // It is used to fetch batch details by id from database
    public function getBatchById($id){ 
        $query=$this->db->query("SELECT * FROM batch_master WHERE id=".$id);
        if($query->num_rows()>0){
            return $query->row();
        }
    }
    // function: getBatchFacilitatorByBatchId()
    // It is used to fetch batch Facilitator list by batch id from database
    public function getBatchFacilitatorByBatchId($id){ 
        $batchfacilitator=array();
        $query=$this->db->query("SELECT user_id FROM batch_facilitator WHERE batch_id='".$id."' AND deleted=0");
        if($query->num_rows()>0){
           $result=$query->result();
           foreach ($result as $r){
               $batchfacilitator[]=$r->user_id;
           }
        }
        return $batchfacilitator;
    } 
    // function: getBatchCoFacilitatorByBatchId()
    // It is used to fetch batch Co-Facilitator list by batch id from database
    public function getBatchCoFacilitatorByBatchId($id){ 
        $batchcofacilitator=array();
        $query=$this->db->query("SELECT user_id FROM batch_co_facilitator WHERE batch_id='".$id."' AND deleted=0");
        if($query->num_rows()>0){
           $result=$query->result();
           foreach ($result as $r){
               $batchcofacilitator[]=$r->user_id;
           }
        }
        return $batchcofacilitator;
    }
    // function: getBatchCoordinatorByBatchId()
    // It is used to fetch batch Coordinator list by batch id from database
    public function getBatchCoordinatorByBatchId($id){ 
        $batchcoordinator=array();
        $query=$this->db->query("SELECT user_id FROM batch_coordinator WHERE batch_id='".$id."' AND deleted=0");
        if($query->num_rows()>0){
           $result=$query->result();
           foreach ($result as $r){
               $batchcoordinator[]=$r->user_id;
           }
        }
        return $batchcoordinator;
    } 
    // function: getBatchVolunteerByBatchId()
    // It is used to fetch batch Volunteer list by batch id from database
    public function getBatchVolunteerByBatchId($id){ 
        $batchvolunteer=array();
        $query=$this->db->query("SELECT user_id FROM batch_volunteer WHERE batch_id='".$id."' AND deleted=0");
        if($query->num_rows()>0){
           $result=$query->result();
           foreach ($result as $r){
               $batchvolunteer[]=$r->user_id;
           }
        }
        return $batchvolunteer;
    } 
    // function: getBatchParticipantByBatchId()
    // It is used to fetch batch Participant list by batch id from database
    public function getBatchParticipantByBatchId($id){ 
        $batchparticipant=array();
        $query=$this->db->query("SELECT user_id FROM batch_participant WHERE batch_id='".$id."' AND deleted=0");
        if($query->num_rows()>0){
           $result=$query->result();
           foreach ($result as $r){
               $batchparticipant[]=$r->user_id;
           }
        }
        return $batchparticipant;
    } 
    // function: updateBatch()
    // It is used to update batch
    public function updateBatch(){
    	$jwt = new JwtToken();
        $received_Token = $this->input->request_headers('Authorization');
        $user = $jwt->GetTokenData($received_Token);
        $user_id='';
        if(isset($user['user_id']) && $user['user_id']){
            $user_id=$user['user_id'];
        }
        $start_date='';
        if(isset($_POST['start_date']) && $_POST['start_date']){
            $start_date=$this->input->post('start_date');
            $start_date=date("Y-m-d",strtotime(str_replace('/','-',$start_date)));
        }
        $end_date='';
        if(isset($_POST['end_date']) && $_POST['end_date']){
            $end_date=$this->input->post('end_date');
            $end_date=date("Y-m-d",strtotime(str_replace('/','-',$end_date)));
        }
        $data = array(
            'state_id'=>$this->input->post('state_id'),
            'region_id'=>$this->input->post('region_id'),
            'center_id'=>$this->input->post('center_id'),
            'program_id'=>$this->input->post('program_id'),
            'batch_name'=>trim($this->input->post('batch_name')),
            'start_date'=>$start_date,
            'end_date'=>$end_date,
            'location'=>$this->input->post('location'),
            'no_of_participant_registered'=>$this->input->post('no_of_participant_registered'),
            'group_id'=>$this->input->post('group_id'),
            'group_name'=>trim($this->input->post('group_name')),
            'updated_by'=> $user_id,
            'updated_at'=>date('Y-m-d H:i:s')
        );
        $batch_id=base64_decode($this->input->post('batch_id'));
        $this->db->where('id',$batch_id);
        $result=$this->db->update('batch_master', $data);
        if($result==1){
            if(isset($_POST['facilitator']) && $_POST['facilitator']){
                $this->db->delete('batch_facilitator', array('batch_id' => $batch_id)); 
                $this->insert_batch_data($batch_id,'batch_facilitator',$_POST['facilitator'],$user_id); 
            }
            if(isset($_POST['co_facilitator']) && $_POST['co_facilitator']){
                $this->db->delete('batch_co_facilitator', array('batch_id' => $batch_id)); 
                $this->insert_batch_data($batch_id,'batch_co_facilitator',$_POST['co_facilitator'],$user_id); 
            }
            if(isset($_POST['coordinator']) && $_POST['coordinator']){
                $this->db->delete('batch_coordinator', array('batch_id' => $batch_id)); 
                $this->insert_batch_data($batch_id,'batch_coordinator',$_POST['coordinator'],$user_id); 
            }
            if(isset($_POST['volunteer']) && $_POST['volunteer']){
                $this->db->delete('batch_volunteer', array('batch_id' => $batch_id)); 
                $this->insert_batch_data($batch_id,'batch_volunteer',$_POST['volunteer'],$user_id);
            }
            if(isset($_POST['participant']) && $_POST['participant']){
                $this->db->delete('batch_participant', array('batch_id' => $batch_id)); 
                $this->insert_batch_data($batch_id,'batch_participant',$_POST['participant'],$user_id);
            }
        }
        return $result;
    }
    // function: deleteBatch()
    // It is used to delete batch details from database 
    public function deleteBatch($batch_id){
    	$jwt = new JwtToken();
        $received_Token = $this->input->request_headers('Authorization');
        $user = $jwt->GetTokenData($received_Token);
        $user_id='';
        if(isset($user['user_id']) && $user['user_id']){
            $user_id=$user['user_id'];
        }
        $data = array(
            'deleted_by'=> $user_id,
            'deleted_at'=>date('Y-m-d H:i:s'),
            'deleted'=>1
        );
        $this->db->where('id',$batch_id);
        $result=$this->db->update('batch_master', $data);
        if($result==1){
        	$this->db->where('batch_id',$batch_id);
            $this->db->update('batch_facilitator', $data);
            $this->db->where('batch_id',$batch_id);
            $this->db->update('batch_co_facilitator', $data);
            $this->db->where('batch_id',$batch_id);
            $this->db->update('batch_coordinator', $data);
            $this->db->where('batch_id',$batch_id);
            $this->db->update('batch_volunteer', $data);
            $this->db->where('batch_id',$batch_id);
            $this->db->update('batch_participant', $data);
        }
        return $result;
    }
}
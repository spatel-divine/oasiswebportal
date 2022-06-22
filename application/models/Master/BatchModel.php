<?php 
class BatchModel extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $this->session_data = is_logged_in();
    }
    // function: getBatchList()
    // It is used to fetch batch list from database
    public function getBatchList(){
        $query=$this->db->query("SELECT bm.*, pm.program_name FROM batch_master bm LEFT JOIN program_master pm ON bm.program_id=pm.id AND pm.is_active=1 AND pm.deleted_at IS NULL WHERE bm.deleted=0");
        if($query->num_rows()>0){
            return $query->result();
        }
        return false;
    }
    // function: insertBatch()
    // It is used to add batch
    public function insertBatch(){
        $data = array(
            'state_id'=>$this->input->post('state_id'),
            'region_id'=>$this->input->post('region_id'),
            'center_id'=>$this->input->post('center_id'),
            'program_id'=>$this->input->post('program_id'),
            'batch_name'=>trim($this->input->post('batch_name')),
            'start_date'=>date('Y-m-d',strtotime($this->input->post('start_date'))),
            'end_date'=>date('Y-m-d',strtotime($this->input->post('end_date'))),
            'location'=>$this->input->post('location'),
            'no_of_participant_registered'=>$this->input->post('no_of_participant_registered'),
            'group_id'=>$this->input->post('group_id'),
            'group_name'=>trim($this->input->post('group_name')),
            'created_by'=> $this->session_data['id'],
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_by'=> $this->session_data['id'],
            'updated_at'=>date('Y-m-d H:i:s')
        );
        $result=$this->db->insert('batch_master', $data);
        if($result==1){
            $batch_id=$this->db->insert_id();
            if(isset($_POST['facilitator']) && $_POST['facilitator']){
                $this->insert_batch_data($batch_id,'batch_facilitator',$_POST['facilitator']); 
            }
            if(isset($_POST['co_facilitator']) && $_POST['co_facilitator']){
                $this->insert_batch_data($batch_id,'batch_co_facilitator',$_POST['co_facilitator']); 
            }
            if(isset($_POST['coordinator']) && $_POST['coordinator']){
                $this->insert_batch_data($batch_id,'batch_coordinator',$_POST['coordinator']); 
            }
            if(isset($_POST['volunteer']) && $_POST['volunteer']){
                $this->insert_batch_data($batch_id,'batch_volunteer',$_POST['volunteer']);
            }
            if(isset($_POST['participant']) && $_POST['participant']){
                $this->insert_batch_data($batch_id,'batch_participant',$_POST['participant']);
            }
        }
        return $result;
    }
    // function: updateBatch()
    // It is used to update batch
    public function updateBatch(){
        $data = array(
            'state_id'=>$this->input->post('state_id'),
            'region_id'=>$this->input->post('region_id'),
            'center_id'=>$this->input->post('center_id'),
            'program_id'=>$this->input->post('program_id'),
            'batch_name'=>trim($this->input->post('batch_name')),
            'start_date'=>date('Y-m-d',strtotime($this->input->post('start_date'))),
            'end_date'=>date('Y-m-d',strtotime($this->input->post('end_date'))),
            'location'=>$this->input->post('location'),
            'no_of_participant_registered'=>$this->input->post('no_of_participant_registered'),
            'group_id'=>$this->input->post('group_id'),
            'group_name'=>trim($this->input->post('group_name')),
            'updated_by'=> $this->session_data['id'],
            'updated_at'=>date('Y-m-d H:i:s')
        );
        $batch_id=base64_decode($this->input->post('batch_id'));
        $this->db->where('id',$batch_id);
        $result=$this->db->update('batch_master', $data);
        if($result==1){
            if(isset($_POST['facilitator']) && $_POST['facilitator']){
                $this->db->delete('batch_facilitator', array('batch_id' => $batch_id)); 
                $this->insert_batch_data($batch_id,'batch_facilitator',$_POST['facilitator']); 
            }
            if(isset($_POST['co_facilitator']) && $_POST['co_facilitator']){
                $this->db->delete('batch_co_facilitator', array('batch_id' => $batch_id)); 
                $this->insert_batch_data($batch_id,'batch_co_facilitator',$_POST['co_facilitator']); 
            }
            if(isset($_POST['coordinator']) && $_POST['coordinator']){
                $this->db->delete('batch_coordinator', array('batch_id' => $batch_id)); 
                $this->insert_batch_data($batch_id,'batch_coordinator',$_POST['coordinator']); 
            }
            if(isset($_POST['volunteer']) && $_POST['volunteer']){
                $this->db->delete('batch_volunteer', array('batch_id' => $batch_id)); 
                $this->insert_batch_data($batch_id,'batch_volunteer',$_POST['volunteer']);
            }
            if(isset($_POST['participant']) && $_POST['participant']){
                $this->db->delete('batch_participant', array('batch_id' => $batch_id)); 
                $this->insert_batch_data($batch_id,'batch_participant',$_POST['participant']);
            }
        }
        return $result;
    }
    // function: insert_batch_data()
    // It is used to add batch data.
    public function insert_batch_data($batch_id,$tablename,$arr){
        $insert_arr=array();
        for($i=0;$i<count($arr);$i++){
            $insert_arr[] = array(
                'batch_id'=>$batch_id,
                'user_id'=>$arr[$i],
                'created_by'=> $this->session_data['id'],
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_by'=> $this->session_data['id'],
                'updated_at'=>date('Y-m-d H:i:s')
            );
        }
        $this->db->insert_batch($tablename, $insert_arr); 
    }
    // function: getBatchById()
    // It is used to fetch batch details by id from database
    public function getBatchById($id){ 
        $query=$this->db->query("SELECT * FROM batch_master WHERE id=".$id);
        if($query->num_rows()>0){
            return $query->row();
        }
        return false;
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
    // function: deleteBatch()
    // It is used to delete batch details from database 
    public function deleteBatch($batch_id){
        $data = array(
            'deleted_by'=> $this->session_data['id'],
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
            // $this->db->delete('batch_facilitator', array('batch_id' => $batch_id));
            // $this->db->delete('batch_co_facilitator', array('batch_id' => $batch_id));
            // $this->db->delete('batch_coordinator', array('batch_id' => $batch_id));
            // $this->db->delete('batch_volunteer', array('batch_id' => $batch_id));  
            // $this->db->delete('batch_participant', array('batch_id' => $batch_id));
        }
        return $result;
    }
    // function: getBatchlistByDateRange()
    // It is used to fetch batch list by date range(start_date-end_date) from database
    public function getBatchlistByDateRange(){
        $start_date=date('Y-m-d',strtotime($this->input->post('start_date')));
        $end_date=date('Y-m-d',strtotime($this->input->post('end_date')));
        $query=$this->db->query("SELECT bm.*, pm.program_name FROM batch_master bm LEFT JOIN program_master pm ON bm.program_id=pm.id AND pm.is_active=1 AND pm.deleted_at IS NULL WHERE bm.deleted=0 AND bm.start_date>='".$start_date."' AND bm.end_date<='".$end_date."'");
        if($query->num_rows()>0){
            return $query->result();
        }
        return false;
    }
}
?>
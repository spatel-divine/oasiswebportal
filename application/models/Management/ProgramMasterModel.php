<?php 
class ProgramMasterModel extends CI_Model
{
    public function __construct() {
        parent::__construct();
        $this->session_data = is_logged_in();
    }
   /**
    * Insert the program_master in database...
    */
    public function insert_program_master()
    { 
        $data = array(
            'program_name' => $this->input->post('program_name'),
            'program_related_id' => $this->input->post('program_related_id'),
            'program_type_id' => $this->input->post('program_type_id'),
            'number_of_days' => $this->input->post('number_of_days'),
            'session_name' => $this->input->post('session_name'),
            'created_by' =>  $this->session_data['id'],
            'is_active' =>  1,
        );
        //program_master in to the database.
        return $this->db->insert('program_master', $data);
    }   
    
    /**
     * Update program master..
     */
    public function update_program_master(){
         $id = $this->input->post('program_master_id');
        $data = array(
                    'program_name' => $this->input->post('program_name'),
                    'program_related_id' => $this->input->post('program_related_id'),
                    'program_type_id' => $this->input->post('program_type_id'),
                    'number_of_days' => $this->input->post('number_of_days'),
                    'session_name' => $this->input->post('session_name'),
                    'updated_by' =>  $this->session_data['id']
        );
 
        $this->db->where('id', $id);
        $this->db->update('program_master', $data);
    }

    /**
	 * Get program master from database.
	 */
	public function get_program_master($id = ""){
    
        $this->db->select('program_master.id, program_master.program_name, 
        program_master.program_related_id, program_master.program_type_id, number_of_days, session_name, program_types.program_type_name, program_related.program_related_to_name ');    
        $this->db->from('program_master');
        $this->db->join('program_types', 'program_master.program_type_id = program_types.id','left');
        $this->db->join('program_related', 'program_master.program_related_id = program_related.id','left');

        if($id != "") {
            $this->db->like('program_master.id', $id);
        }
        $this->db->where('program_master.deleted_at IS NULL', NULL);
        $this->db->order_by("program_master.program_name", "asc");
        $query = $this->db->get();
        return $query->result();


    }
    // *************** Start Program Session Module Code*********************
    // function: getProgramSession()
    // It is used to fetch active program session list from database
    public function getProgramSession(){
        $query=$this->db->query("SELECT sm.*, pm.program_name FROM sessionmanagement sm INNER JOIN program_master pm ON sm.program_id=pm.id AND pm.is_active=1 AND pm.deleted_at IS NULL WHERE sm.deleted=0");
        if($query->num_rows()>0){
            return $query->result();
        }
        return false;
    }
    // function: getActiveProgramList()
    // It is used to fetch active program list from database
    public function getActiveProgramList(){
        $query=$this->db->query("SELECT * FROM program_master WHERE is_active=1 AND deleted_at IS NULL");
        if($query->num_rows()>0){
            return $query->result();
        }
        return false;
    }
    // function: getSessionById()
    // It is used to fetch session details by id from database
    public function getSessionById($id){ 
        $query=$this->db->query("SELECT sm.*, pm.program_name FROM sessionmanagement sm INNER JOIN program_master pm ON sm.program_id=pm.id WHERE sm.id=".base64_decode($id));
        if($query->num_rows()>0){
            return $query->row();
        }
        return false;
    } 
    // function: insertProgramSession()
    // It is used to insert session details into database
    public function insertProgramSession(){ 
        $data = array(
            'session_name'=>trim($this->input->post('session_name')),
            'program_id'=>$this->input->post('program_id'),
            'status'=>$this->input->post('status'),
            'created_by'=> $this->session_data['id'],
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_by'=> $this->session_data['id'],
            'updated_at'=>date('Y-m-d H:i:s')
        );
        $result=$this->db->insert('sessionmanagement', $data);
        return $result;
    }  
    // function: updateProgramSession()
    // It is used to update session details into database
    public function updateProgramSession(){ 
        $data = array(
            'session_name'=>trim($this->input->post('session_name')),
            'program_id'=>$this->input->post('program_id'),
            'status'=>$this->input->post('status'),
            'updated_by'=> $this->session_data['id'],
            'updated_at'=>date('Y-m-d H:i:s')
        );
        $this->db->where('id',base64_decode($this->input->post('session_id')));
        $result=$this->db->update('sessionmanagement', $data);
        return $result;
    } 
    // function: deleteProgramSession()
    // It is used to delete session details from database 
    public function deleteProgramSession($session_id){
        $data = array(
            'deleted_by'=> $this->session_data['id'],
            'deleted_at'=>date('Y-m-d H:i:s'),
            'deleted'=>1
        );
        $this->db->where('id',base64_decode($session_id));
        $result=$this->db->update('sessionmanagement', $data);
        return $result;
    }
    public function getSessionByProgram($program_name){
        $query=$this->db->query("SELECT s.* FROM sessionmanagement s INNER JOIN program_master p ON s.program_id=p.id AND p.program_name='".$program_name."' WHERE s.status=1 AND s.deleted_at IS NULL");
        if($query->num_rows()>0){
            return $query->result();
        }
    }
    public function getActiveSessionList(){
        $query=$this->db->query("SELECT s.* FROM sessionmanagement s WHERE s.status=1 AND s.deleted_at IS NULL");
        if($query->num_rows()>0){
            return $query->result();
        }
    }
    // *************** End Program Session Module Code*********************
}
?>
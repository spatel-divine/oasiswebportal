<?php 
class ProgramTypeModel extends CI_Model
{

    public function __construct() {
        parent::__construct();
        $this->session_data = is_logged_in();
    }
   /**
    * Insert the in database...
    */
    public function insert_program_type()
    { 
        $data = array(
            'program_type_name' => $this->input->post('program_type_name'),
            'created_by' =>  $this->session_data['id'],
            'is_active' =>  1,
        );
        //program_types in to the database.
        return $this->db->insert('program_types', $data);
    }   
    
    /**
     * Update..
     */
    public function update_program_type(){
        $id = $this->input->post('program_type_id');
        $data = array(
                    'program_type_name' => $this->input->post('program_type_name'),
                    'updated_by' =>  $this->session_data['id']
                   
        );
        $this->db->where('id', $id);
        $this->db->update('program_types', $data);
    }

    /**
	 * Get program type from database.
	 */
	public function get_program_type($id = ""){
        if($id != "") {
            $this->db->like('id', $id);
        }
        $this->db->order_by("id", "desc");
        $this->db->where('deleted_at IS NULL', NULL);
        $query = $this->db->get("program_types");
        return $query->result();
    }

}
?>
<?php 
class ProgramRelatedModel extends CI_Model
{

    public function __construct() {
        parent::__construct();
        $this->session_data = is_logged_in();
    }
   /**
    * Insert the in database...
    */
    public function insert_program_related()
    { 
        $data = array(
            'program_related_to_name' => $this->input->post('program_related_to_name'),
            'created_by' =>  $this->session_data['id'],
            'is_active' =>  1,
        );
        //program_related in to the database.
        return $this->db->insert('program_related', $data);
    }   
    
    /**
     * Update..
     */
    public function update_program_related(){
        $id = $this->input->post('program_related_id');
        $data = array(
                    'program_related_to_name' => $this->input->post('program_related_to_name'),
                    'updated_by' =>  $this->session_data['id']
                   
        );
        $this->db->where('id', $id);
        $this->db->update('program_related', $data);
    }

    /**
	 * Get program_related data from database.
	 */
	public function get_program_related($id = ""){
        if($id != "") {
            $this->db->like('id', $id);
        }
        $this->db->order_by("id", "desc");
        $this->db->where('deleted_at IS NULL', NULL);
         $query = $this->db->get("program_related");
        return $query->result();
    }

}
?>
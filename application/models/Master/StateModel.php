<?php 
class StateModel extends CI_Model
{
    public function __construct() {
        parent::__construct();
        $this->session_data = is_logged_in();
    }
   /**
    * Insert the state in database...
    */
    public function insert_state()
    { 
        $data = array(
            'state_name' => $this->input->post('state_name'),
            'created_by' =>  $this->session_data['id'],
            'is_active' =>  1,
        );
        // state data inserting in to the database.
        return $this->db->insert('states', $data);
    }   
    
    /**
     * Update the states..
     */
    public function update_state(){
        $id = $this->input->post('state_id');
        $data = array(
                    'state_name' => $this->input->post('state_name'),
                    'updated_by' =>  $this->session_data['id']
        );
        $this->db->where('id', $id);
        $this->db->update('states', $data);
    }

    /**
	 * Get the state data from database.
	 */
	public function get_state($id = ""){
        if(!empty($this->input->get("search"))){
          $this->db->like('state_name', $this->input->get("search"));
        }
        if($id != "") {
            $this->db->like('id', $id);
        }
        $this->db->where('deleted_at IS NULL', NULL);
        $query = $this->db->get("states");
        return $query->result();
    }
    // function: getActiveStateList()
    // It is used to fetch active and not deleted states from database
    public function getActiveStateList(){
        $query=$this->db->query("SELECT * FROM states WHERE is_active=1 AND deleted_at IS NULL");
        if($query->num_rows()>0){
            return $query->result();
        }
    }
}

?>
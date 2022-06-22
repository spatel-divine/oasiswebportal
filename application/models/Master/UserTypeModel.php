<?php 
class UserTypeModel extends CI_Model
{

    public function __construct() {
        parent::__construct();
    }
   /**
    * Insert the user type in database...
    */
    public function insert_user_type()
    { 
        $data = array(
            'user_type' => $this->input->post('user_type'),
            'created_by' => '1'
            
        );
        // user type data inserting in to the database.
        return $this->db->insert('user_types', $data);
    }   
    
    /**
     * Update the user type...
     */
    public function update_user_type(){
        $id = $this->input->post('user_type_id');
        $data = array(
                    'user_type' => $this->input->post('user_type'),
                    'updated_by' => '1'
        );
        $this->db->where('id', $id);
        $this->db->update('user_types', $data);
    }

    /**
	 * Get the user type data from database.
	 */
	public function get_userType($id = ""){
        if(!empty($this->input->get("search"))){
          $this->db->like('user_type', $this->input->get("search"));
        }
        if($id != "") {
            $this->db->like('id', $id);
        }
        $this->db->where('deleted_at IS NULL', NULL);
        $query = $this->db->get("user_types");
        return $query->result();
    }
    public function getUserTypesListByTypeName($USER_TYPE_IDS){
        $query=$this->db->query("SELECT * FROM user_types WHERE id IN(".$USER_TYPE_IDS.") AND is_active=1 AND deleted_at IS NULL");
        if($query->num_rows()>0){
            return $query->result();
        }
    }
}

?>
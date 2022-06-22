<?php 
class RoleModel extends CI_Model
{

    public function __construct() {
        parent::__construct();
        $this->session_data = is_logged_in();
    }
   /**
    * Insert the role in database...
    */
    public function insert_role()
    { 
        $data = array(
            'role_name' => $this->input->post('role_name'),
            'created_by' =>  $this->session_data['id'],
            'is_active' =>  1,
        );
        // role data inserting in to the database.
        return $this->db->insert('roles', $data);
    }   
    
    /**
     * Update the roles..
     */
    public function update_role(){
        $id = $this->input->post('role_id');
        $data = array(
                    'role_name' => $this->input->post('role_name'),
                    'updated_by' =>  $this->session_data['id'],
                    'updated_at' => date("Y-d-m H:i:s"),
        );
        $this->db->where('id', $id);
        $this->db->update('roles', $data);
    }

    /**
	 * Get the role data from database.
	 */
	public function get_role($id = ""){
        if(!empty($this->input->get("search"))){
          $this->db->like('role_name', $this->input->get("search"));
        }
        if($id != "") {
            $this->db->like('id', $id);
        }
        $this->db->where('deleted_at IS NULL', NULL);
        $this->db->where('is_active', 1);
        $query = $this->db->get("roles");
        return $query->result();
    }
    // function: getRoleList()
    // It is used to fetch role list from database
    public function getRoleList(){
        $query=$this->db->query("SELECT * FROM roles WHERE deleted_at IS NULL AND is_active=1");
        if($query->num_rows()>0){
            return $query->result();
        }
    }

}

?>
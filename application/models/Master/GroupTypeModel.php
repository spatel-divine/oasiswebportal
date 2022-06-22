<?php 
class GroupTypeModel extends CI_Model
{

    public function __construct() {
        parent::__construct();
        $this->session_data = is_logged_in();
    }
   /**
    * Insert the group type in database...
    */
    public function insert_group_type()
    { 
        $data = array(
            'group_type_name' => $this->input->post('group_type_name'),
            'created_by' =>  $this->session_data['id'],
            'is_active' =>  1,
        );
        // group type in to the database.
        return $this->db->insert('group_types', $data);
    }   
    
    /**
     * Update the group_type_name..
     */
    public function update_group_type(){
        $id = $this->input->post('group_type_id');
        $data = array(
                    'group_type_name' => $this->input->post('group_type_name'),
                    'updated_by' =>  $this->session_data['id']
                   
        );
        $this->db->where('id', $id);
        $this->db->update('group_types', $data);
    }

    /**
	 * Get the group type data from database.
	 */
	public function get_group_type($id = ""){
        if(!empty($this->input->get("search"))){
          $this->db->like('group_type_name', $this->input->get("search"));
        }
        if($id != "") {
            $this->db->like('id', $id);
        }
        $this->db->where('deleted_at IS NULL', NULL);
        $query = $this->db->get("group_types");
        return $query->result();
    }
    // function: getGroupTypeList()
    // It is used to fetch list of all active group type
    public function getGroupTypeList(){
        $query=$this->db->query("SELECT * FROM group_types WHERE is_active=1 AND deleted_at IS NULL");
        if($query->num_rows()>0){
            return $query->result();
        }
    }

}
?>
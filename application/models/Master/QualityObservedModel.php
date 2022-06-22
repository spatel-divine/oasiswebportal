<?php 
class QualityObservedModel extends CI_Model
{

    public function __construct() {
        parent::__construct();
        $this->session_data = is_logged_in();
    }
   /**
    * Insert in database...
    */
    public function insert_quality_data()
    { 
        $data = array(
            'quality_name' => $this->input->post('quality_name'),
            'created_by' =>  $this->session_data['id'],
            'is_active' =>  1,
        );
        // quality in to the database.
        return $this->db->insert('quality_data', $data);
    }   
    
    /**
     * Update the quality_data..
     */
    public function update_quality_data(){
        $id = $this->input->post('quality_data_id');
        $data = array(
                    'quality_name' => $this->input->post('quality_name'),
                    'updated_by' =>  $this->session_data['id']
                   
        );
        $this->db->where('id', $id);
        $this->db->update('quality_data', $data);
    }

    /**
	 * Get the quality data from db
	 */
	public function get_quality_data($id = ""){
        if(!empty($this->input->get("search"))){
          $this->db->like('quality_name', $this->input->get("search"));
        }
        if($id != "") {
            $this->db->like('id', $id);
        }
        $this->db->where('deleted_at IS NULL', NULL);
        $query = $this->db->get("quality_data");
        return $query->result();
    }

}
?>
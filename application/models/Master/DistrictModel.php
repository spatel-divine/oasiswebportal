<?php 
class DistrictModel extends CI_Model
{
    public function __construct() {
        parent::__construct();
        $this->session_data = is_logged_in();
    }
   /**
    * Insert the district in database...
    */
    public function insert_district()
    { 
        $data = array(
            'state_id' => $this->input->post('state_id'),
            'district_name' => $this->input->post('district_name'),
            'created_by' =>  $this->session_data['id'],
            'is_active' =>  1,
        );
        // state data inserting in to the database.
        return $this->db->insert('districts', $data);
    }   
    
    /**
     * Update the district..
     */
    public function update_district(){
        $id = $this->input->post('district_id');

        $data = array(
                    'district_name' => $this->input->post('district_name'),
                    'state_id' => $this->input->post('state_id'),
                    'updated_by' =>  $this->session_data['id']
        );
        $this->db->where('id', $id);
        $this->db->update('districts', $data);
    }

    /**
	 * Get the get district list from database.
	 */
	public function get_district($id = ""){
        $this->db->select('districts.id, districts.state_id, districts.district_name, states.state_name');    
        $this->db->from('districts');
        $this->db->join('states', 'districts.state_id = states.id');
        if($id != "") {
            $this->db->like('districts.id', $id);
        }
        $this->db->where('districts.deleted_at IS NULL', NULL);
        $query = $this->db->get();
        return $query->result();
    }

    //Get District from state
    public function get_district_from_state($state_id = ""){
          $this->db->select('districts.id, districts.state_id, districts.district_name, states.state_name');    
          $this->db->from('districts');
          $this->db->join('states', 'districts.state_id = states.id');
          if($state_id != "") {
              $this->db->like('districts.state_id', $state_id);
          }
          $this->db->where('districts.deleted_at IS NULL', NULL);
          $query = $this->db->get();
          return $query->result();
      }
    // function: getDistrictByStateId()
    // It is used to fetch district by state id from database
    public function getDistrictByStateId($state_id=''){
        $condition='';
        if($state_id){
            $condition.=" AND state_id='".$state_id."'";
        }
        $query=$this->db->query("SELECT * FROM districts WHERE is_active=1 AND deleted_at IS NULL ".$condition);
        if($query->num_rows()>0){
            return $query->result();
        }
    }
    // function: getDistrictListByStateId()
    // It is used to fetch district list by state id from database
    public function getDistrictListByStateId($state_id=''){
        $condition='';
        if($state_id){
            $condition.=" AND state_id='".$state_id."'";
        }
        $query=$this->db->query("SELECT id, district_name FROM districts WHERE is_active=1 AND deleted_at IS NULL ".$condition);
        if($query->num_rows()>0){
            return $query->result();
        }
    }
}

?>
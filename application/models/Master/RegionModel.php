<?php 
class RegionModel extends CI_Model
{
    public function __construct() {
        parent::__construct();
        $this->session_data = is_logged_in();
   }
   /**
    * Insert the regions in database...
    */
    public function insert_region()
    { 
        $data = array(
            'state_id' => $this->input->post('state_id'),
            'region_name' => $this->input->post('region_name'),
            'created_by' =>  $this->session_data['id'],
            'is_active' =>  1,
        );
        // regions data inserting in to the database.
        return $this->db->insert('regions', $data);
    }   
    
    /**
     * Update the regions..
     */
    public function update_region(){
        $id = $this->input->post('region_id');

        $data = array(
                    'region_name' => $this->input->post('region_name'),
                    'state_id' => $this->input->post('state_id'),
                    'updated_by' =>  $this->session_data['id']
        );
        $this->db->where('id', $id);
        $this->db->update('regions', $data);
    }

    /**
	 * Get the get regions from database.
	 */
	public function get_region($id = ""){

        $this->db->select('regions.id, regions.state_id, regions.region_name, states.state_name');    
        $this->db->from('regions');
        $this->db->join('states', 'regions.state_id = states.id');
        if($id != "") {
            $this->db->like('regions.id', $id);
        }
        $this->db->where('regions.deleted_at IS NULL', NULL);
        $query = $this->db->get();
        return $query->result();
    }
    /**
     * Get the region from selected state..
     */
    public function get_region_from_state($state_id=""){

        $this->db->select('regions.id, regions.state_id, regions.region_name, states.state_name');    
        $this->db->from('regions');
        $this->db->join('states', 'regions.state_id = states.id');
        if($state_id != "") {
            $this->db->like('regions.state_id', $state_id);
        }
        $this->db->where('regions.deleted_at IS NULL', NULL);
        $query = $this->db->get();
        
        return $query->result();
    }
    // function: getRegionByStateId()
    // It is used to fetch region by state id from database
    public function getRegionByStateId($state_id=''){
        $condition='';
        if($state_id){
            $condition.=" AND state_id='".$state_id."'";
        }
        $query=$this->db->query("SELECT * FROM regions WHERE is_active=1 AND deleted_at IS NULL ".$condition);
        if($query->num_rows()>0){
            return $query->result();
        }
    }
    // function: getRegionListByStateId()
    // It is used to fetch region list by state id from database
    public function getRegionListByStateId($state_id=''){
        $condition='';
        if($state_id){
            $condition.=" AND state_id='".$state_id."'";
        }
        $query=$this->db->query("SELECT id, region_name FROM regions WHERE is_active=1 AND deleted_at IS NULL ".$condition);
        if($query->num_rows()>0){
            return $query->result();
        }
    }
}

?>
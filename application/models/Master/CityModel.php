<?php 
class CityModel extends CI_Model
{
    public function __construct() {
        parent::__construct();
        $this->session_data = is_logged_in();
   }
   /**
    * Insert the city in database...
    */
    public function insert_city()
    { 
        $data = array(
            'district_id' => $this->input->post('district_id'),
            'village_name' => $this->input->post('village_name'),
            'created_by' =>  $this->session_data['id'],
            'is_active' =>  1,
        );
        // city data inserting in to the database.
        return $this->db->insert('city_town_villages', $data);
    }   
    
    /**
     * Update the district..
     */
    public function update_city(){
        $id = $this->input->post('village_id');

        $data = array(
                    'village_name' => $this->input->post('village_name'),
                    'district_id' => $this->input->post('district_id'),
                    'updated_by' =>  $this->session_data['id']
        );
        $this->db->where('id', $id);
        $this->db->update('city_town_villages', $data);
    }

    /**
	 * Get the get city village or town from database.
	 */
	public function get_city($id = ""){
       
        $this->db->select('city_town_villages.id, city_town_villages.district_id, city_town_villages.village_name, districts.district_name');    
        $this->db->from('districts');
        $this->db->join('city_town_villages', 'districts.id = city_town_villages.district_id');
        if($id != "") {
            $this->db->like('city_town_villages.id', $id);
        }
        $this->db->where('city_town_villages.deleted_at IS NULL', NULL);
        $query = $this->db->get();
        return $query->result();
    }

    // Get the city list from dist
    public function get_city_from_dist($dist_id = ""){
       
        $this->db->select('city_town_villages.id, city_town_villages.district_id, city_town_villages.village_name, districts.district_name');    
        $this->db->from('districts');
        $this->db->join('city_town_villages', 'districts.id = city_town_villages.district_id');
        if($dist_id != "") {
            $this->db->like('city_town_villages.district_id', $dist_id);
        }
        $this->db->where('city_town_villages.deleted_at IS NULL', NULL);
        $query = $this->db->get();
        return $query->result();
    }
    // function: getCityByStateId()
    // It is used to fetch city by state id from database
    public function getCityByStateId($state_id){
        $query=$this->db->query("SELECT c.* FROM city_town_villages c INNER JOIN districts d ON c.district_id=d.id AND d.is_active=1 AND d.deleted_at IS NULL AND d.state_id='".$state_id."' WHERE c.is_active=1 AND c.deleted_at IS NULL");
        if($query->num_rows()>0){
            return $query->result();
        }
    }
    // function: getCityByDistrictId()
    // It is used to fetch city by district id from database
    public function getCityByDistrictId($district_id=''){
        $condition='';
        if($district_id){
            $condition.=" AND district_id='".$district_id."'";
        }
        $query=$this->db->query("SELECT * FROM city_town_villages WHERE is_active=1 AND deleted_at IS NULL ".$condition);
        if($query->num_rows()>0){
            return $query->result();
        }
    }
    // function: getCityListByDistrictId()
    // It is used to fetch city list by district id from database
    public function getCityListByDistrictId($district_id=''){
        $condition='';
        if($district_id){
            $condition.=" AND district_id='".$district_id."'";
        }
        $query=$this->db->query("SELECT id, village_name FROM city_town_villages WHERE is_active=1 AND deleted_at IS NULL ".$condition);
        if($query->num_rows()>0){
            return $query->result();
        }
    }
}

?>
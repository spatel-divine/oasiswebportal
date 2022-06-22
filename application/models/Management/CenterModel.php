<?php 
class CenterModel extends CI_Model
{
    public function __construct() {
        parent::__construct();
        $this->session_data = is_logged_in();
   }
   /**
    * Insert the center_master in database...
    */
    public function insert_center_master()
    { 
        $data = array(
            'center_name' => $this->input->post('center_name'),
            'address' => $this->input->post('address'),
            'state_id' => $this->input->post('state_id'),
            'region_id' => $this->input->post('region_id'),
            'city_id' => $this->input->post('city_id'),
            'center_contact_no' => $this->input->post('center_contact_no'),
            'created_by' =>  $this->session_data['id'],
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_by'=> $this->session_data['id'],
            'updated_at'=>date('Y-m-d H:i:s'),
            'is_active' =>  1,
        );
        //center_master in to the database.
        return $this->db->insert('center_master', $data);
    }   
    
    /**
     * Update center master..
     */
    public function update_center_master(){
        $id = $this->input->post('center_id');
        $data = array(
                    'center_name' => $this->input->post('center_name'),
                    'address' => $this->input->post('address'),
                    'state_id' => $this->input->post('state_id'),
                    'region_id' => $this->input->post('region_id'),
                    'city_id' => $this->input->post('city_id'),
                    'center_contact_no' => $this->input->post('center_contact_no'),
                    'updated_by' =>  $this->session_data['id'],
                    'updated_at'=>date('Y-m-d H:i:s')
        );
 
        $this->db->where('id', $id);
        $this->db->update('center_master', $data);
    }

    /**
	 * Get center master from database.
	 */
	public function get_center_list($id = ""){
    
        $this->db->select('center_master.id, center_master.center_name, 
        center_master.address, center_master.city_id,center_master.region_id, center_master.state_id, center_master.center_contact_no, states.state_name, regions.region_name, city_town_villages.village_name');
        $this->db->from('center_master');
        $this->db->join('states', 'center_master.state_id = states.id');
        $this->db->join('regions', 'center_master.region_id = regions.id','left');
        $this->db->join('city_town_villages', 'center_master.city_id = city_town_villages.id');

        if($id != "") {
            $this->db->like('center_master.id', $id);
        }

        $this->db->where('center_master.deleted_at IS NULL', NULL);
        $this->db->order_by("center_master.center_name", "asc");

        $query = $this->db->get();
        return $query->result();


    }
    // function: getCenterByRegionId()
    // It is used to fetch center by region id from database
    public function getCenterByRegionId($region_id=''){
        $condition='';
        if($region_id){
            $condition.=" AND region_id='".$region_id."' ";
        }
        $query=$this->db->query("SELECT * FROM center_master WHERE is_active=1 AND deleted_at IS NULL ".$condition);
        if($query->num_rows()>0){
            return $query->result();
        }
    }
    // function: getCenterListByRegionId()
    // It is used to fetch center by region id from database
    public function getCenterListByRegionId($region_id=''){
        $condition='';
        if($region_id){
            $condition.=" AND region_id='".$region_id."' ";
        }
        $query=$this->db->query("SELECT id,center_name FROM center_master WHERE is_active=1 AND deleted_at IS NULL ".$condition);
        if($query->num_rows()>0){
            return $query->result();
        }
    }
    // function: getCenterList()
    // It is used to fetch center list from database
    public function getCenterList(){
        $query=$this->db->query("SELECT * FROM center_master WHERE deleted_at IS NULL");
        if($query->num_rows()>0){
            return $query->result();
        }
    }
    // function: getCenterById()
    // It is used to fetch center by center id from database
    public function getCenterById($center_id){
        $query=$this->db->query("SELECT * FROM center_master WHERE id='".$center_id."'");
        if($query->num_rows()>0){
            return $query->row();
        }
    }
    // function: updateActiveDeactiveCenter()
    // It is used to  update Active/Deactive status of center into database
    public function updateActiveDeactiveCenter(){
         $data = array(
            'active_deactive_date'=>date('Y-m-d'),
            'active_deactive_reason_type'=>trim($this->input->post('active_deactive_reason_type')),
            'active_deactive_reason'=>trim($this->input->post('active_deactive_reason')),
            'is_active'=>$this->input->post('is_active'),
            'updated_by'=> $this->session_data['id'],
            'updated_at'=>date('Y-m-d H:i:s')
        );
        $this->db->where('id',$this->input->post('center'));
        $result=$this->db->update('center_master', $data);
        return $result;
    }
    // function: getUserCenterList()
    // It is used to fetch assigned center list from database
    public function getUserCenterList(){
        $query=$this->db->query("SELECT uc.*, CONCAT_WS(' ',u.first_name, u.last_name) as user_fullname, s.state_name, r.region_name, c.center_name FROM user_centers uc LEFT JOIN users u ON uc.user_id=u.id AND u.deleted_at IS NULL LEFT JOIN states s ON uc.state_id=s.id AND s.deleted_at IS NULL LEFT JOIN regions r ON uc.region_id=r.id AND r.deleted_at IS NULL LEFT JOIN center_master c ON uc.center_id=c.id AND c.deleted_at IS NULL WHERE uc.deleted_at IS NULL");
        if($query->num_rows()>0){
            return $query->result();
        }
    }
    // function: createAssignCenter()
    // It is used to assigned center to selected user
    public function createAssignCenter(){ 
        $data = array(
            'user_id' => $this->input->post('user_id'),
            'state_id' => $this->input->post('state_id'),
            'region_id' => $this->input->post('region_id'),
            'center_id' => $this->input->post('center_id'),
            'created_by' =>  $this->session_data['id'],
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_by'=> $this->session_data['id'],
            'updated_at'=>date('Y-m-d H:i:s'),
            'is_active' => $this->input->post('is_active'),
        );
        $result=$this->db->insert('user_centers', $data);
        return $result;
    } 
    // function: getUserCenterById()
    // It is used to fetch assigned center list from database
    public function getUserCenterById($assigned_center_id){
        $query=$this->db->query("SELECT uc.* FROM user_centers uc WHERE uc.id='".$assigned_center_id."'");
        if($query->num_rows()>0){
            return $query->row();
        }
    } 
    // function: updateAssignCenter()
    // It is used to assigned center to selected user
    public function updateAssignCenter(){ 
        $data = array(
            'user_id' => $this->input->post('user_id'),
            'state_id' => $this->input->post('state_id'),
            'region_id' => $this->input->post('region_id'),
            'center_id' => $this->input->post('center_id'),
            'updated_by'=> $this->session_data['id'],
            'updated_at'=>date('Y-m-d H:i:s'),
            'is_active' => $this->input->post('is_active'),
        );
        $user_center_id=base64_decode($this->input->post('user_center_id'));
        $this->db->where('id',$user_center_id);
        $result=$this->db->update('user_centers',$data);
        return $result;
    } 
    // function: deleteAssignUserCenter()
    // It is used to delete user center from database
    public function deleteAssignUserCenter($user_center_id){
        $data = array(
            'deleted_by'=> $this->session_data['id'],
            'deleted_at'=>date('Y-m-d H:i:s')
        );
        $this->db->where('id',$user_center_id);
        $result=$this->db->update('user_centers', $data);
        return $result;
    }
    // function: getCenterByStateId()
    // It is used to fetch center by state id from database
    public function getCenterByStateId($state_id=''){
        $condition='';
        if($state_id){
            $condition.=" AND state_id='".$state_id."' ";
        }
        $query=$this->db->query("SELECT * FROM center_master WHERE is_active=1 AND deleted_at IS NULL ".$condition);
        if($query->num_rows()>0){
            return $query->result();
        }
    }
}
?>
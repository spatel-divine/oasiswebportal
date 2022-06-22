<?php 
class DownloadCategoryModel extends CI_Model
{

    public function __construct() {
        parent::__construct();
        $this->session_data = is_logged_in();
    }
   /**
    * Insert the in database...
    */
    public function insert_download_category()
    { 
        $data = array(
            'download_category_name' => $this->input->post('download_category_name'),
            'created_by' =>  $this->session_data['id'],
            'is_active' =>  1,
        );
        //download_categories in to the database.
        return $this->db->insert('download_categories', $data);
    }   
    
    /**
     * Update the download_categories..
     */
    public function update_download_category(){
        $id = $this->input->post('download_category_id');
        $data = array(
                    'download_category_name' => $this->input->post('download_category_name'),
                    'updated_by' =>  $this->session_data['id']
                   
        );
        $this->db->where('id', $id);
        $this->db->update('download_categories', $data);
    }

    /**
	 * Get download_categories data from database.
	 */
	public function get_download_category($id = ""){
        if(!empty($this->input->get("search"))){
          $this->db->like('download_category_name', $this->input->get("search"));
        }
        if($id != "") {
            $this->db->like('id', $id);
        }
        $this->db->order_by("id", "desc");
        $this->db->where('deleted_at IS NULL', NULL);
        $query = $this->db->get("download_categories");

        return $query->result();
    }
    // function: getDownloadCategoryList()
    // It is used to fetch download category list
    public function getDownloadCategoryList(){
        $query=$this->db->query("SELECT * FROM download_categories WHERE is_active=1 AND deleted_at IS NULL");
        if($query->num_rows()>0){
            return $query->result();
        }
    }
}
?>
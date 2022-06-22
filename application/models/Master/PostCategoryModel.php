<?php 
class PostCategoryModel extends CI_Model
{

    public function __construct() {
        parent::__construct();
        $this->session_data = is_logged_in();
    }
   /**
    * Insert the in database...
    */
    public function insert_post_category()
    { 
        $data = array(
            'category_name' => $this->input->post('category_name'),
            'created_by' =>  $this->session_data['id'],
            'is_active' =>  1,
        );
        // group type in to the database.
        return $this->db->insert('post_categories', $data);
    }   
    
    /**
     * Update the update_post_category..
     */
    public function update_post_category(){
        $id = $this->input->post('post_category_id');
        $data = array(
                    'category_name' => $this->input->post('category_name'),
                    'updated_by' =>  $this->session_data['id']
                   
        );
        $this->db->where('id', $id);
        $this->db->update('post_categories', $data);
    }

    /**
	 * Get the category name data from database.
	 */
	public function get_post_category($id = ""){
        if(!empty($this->input->get("search"))){
          $this->db->like('category_name', $this->input->get("search"));
        }
        if($id != "") {
            $this->db->like('id', $id);
        }
        $this->db->where('deleted_at IS NULL', NULL);
        $query = $this->db->get("post_categories");
        return $query->result();
    }
    public function getPostCategoryList(){
        $query=$this->db->query("SELECT * FROM post_categories WHERE is_active=1 AND deleted_at IS NULL");
        if($query->num_rows()>0){
            return $query->result();
        }
    }
}
?>
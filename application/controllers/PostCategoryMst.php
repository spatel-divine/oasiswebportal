<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class PostCategoryMst extends CI_Controller {
	public function __construct() {
    	parent::__construct();
    	if(!(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])=='xmlhttprequest')){
    		// Start check Login
            if(!is_logged_in()){
			    redirect('login');
			}
			// End check Login
			// Start check Assign Rights
	    	$controller = strtolower($this->router->fetch_class());
			$method = strtolower($this->router->fetch_method());
			$result=checkAssignRights($controller,$method);
			if(!$result){
			 	redirect('home/error403');
			}
			// End check Assign Rights
        }
		$this->load->model('Master/PostCategoryModel');
    }
	/**
	 * Create create post category 
	 */
	public function createPostCategory(){
		$this->form_validation->set_rules('category_name', 'Category Name', 'required');
        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('errors', validation_errors());
			//Get the current data and load it in list view.
			$data['data'] = $this->PostCategoryModel->get_post_category();
            $this->load->view('post_category_master', $data);
        }else{
			if($this->input->post('post_category_id') !="" ){
				//update..
        		$this->PostCategoryModel->update_post_category();
			}else{
				//Insert..
        		$this->PostCategoryModel->insert_post_category();
			}
			redirect('master/post_category_master');
		}
	}
	public function editPostCategory($post_category_id){
		//Get the current data and load it in list view.
		$data['edit_data'] = $this->PostCategoryModel->get_post_category($post_category_id);
		$data['data'] = $this->PostCategoryModel->get_post_category();
		if(!empty($data)) {
			$this->load->view('post_category_master', $data);
		}
	}
}

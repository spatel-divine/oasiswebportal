<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class DownloadCategoryMst extends CI_Controller {
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
		$this->load->model('Master/DownloadCategoryModel');
    }
	/**
	 * Create create download category 
	 */
	public function createDownloadCategory(){
		$this->form_validation->set_rules('download_category_name', 'Download Category Name', 'required');
        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('errors', validation_errors());
			//Get the current data and load it in list view.
			$data['data'] = $this->DownloadCategoryModel->get_download_category();
            $this->load->view('download_category_master', $data);
        }else{
			if($this->input->post('download_category_id') !="" ){
				//update..
        		$this->DownloadCategoryModel->update_download_category();
			}else{
				//Insert..
        		$this->DownloadCategoryModel->insert_download_category();
			}
			redirect('master/download_category_master');
		}
	}
	public function editDownloadCategory($download_category_id){
		//Get the current data and load it in list view.
		$data['edit_data'] = $this->DownloadCategoryModel->get_download_category($download_category_id);
		$data['data'] = $this->DownloadCategoryModel->get_download_category();
		
		if(!empty($data)) {
			$this->load->view('download_category_master', $data);
		}
	}
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'controllers/JwtToken.php';
class Contactus extends REST_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('api/v1/ContactusModel');
        $this->load->library("pagination");
    }
    public function index_post(){
    } 
    // function: queries_questions_list_get()
    // It is used to get Queries/Questions list
    public function queries_questions_list_get(){
        if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $data=array();
            $jwt = new JwtToken();
            $received_Token = $this->input->request_headers('Authorization');
            $user = $jwt->GetTokenData($received_Token);
            $user_id='';
            if(isset($user['user_id']) && $user['user_id']){
                $user_id=$user['user_id'];
            }
            $data["queriesquestionslist"] = $this->ContactusModel->getQueriesQuestionsListByUserId($user_id);
            $this->response([
                'status' => True,
                'message' => $data,
            ], REST_Controller::HTTP_OK);
        }
    }
    // function: queries_questions_post()
    // It is used to save Queries/Questions
    public function queries_questions_post(){
        if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $data=array();
	        $this->form_validation->set_data($this->post());
	        $this->form_validation->set_rules('queries', 'Queries/Questions','trim|required',array('required'=>'Enter Queries/Questions'));
	        if($this->form_validation->run() == FALSE){
	            $data = $this->form_validation->error_array();
	            $this->response([
	                'status' => False,
	                'message' => $data,
	            ], REST_Controller::HTTP_OK);
	        }else{
	            $result=$this->ContactusModel->saveRequest();
	            if($result==1){
	                $data["success_message"] = "Queries/Questions added successfully";
	                $this->response([
	                    'status' => True,
	                    'message' => $data,
	                ], REST_Controller::HTTP_OK);
	            }else{
	                $data["error_message"] = "Something Went Wrong. Please Try Again.";
	                $this->response([
	                    'status' => False,
	                    'message' => $data,
	                ], REST_Controller::HTTP_OK);
	            }
	        }
        }
    }
    // function: share_stories_list_get()
    // It is used to get Queries/Questions list
    public function share_stories_list_get(){
        if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $data=array();
            $jwt = new JwtToken();
            $received_Token = $this->input->request_headers('Authorization');
            $user = $jwt->GetTokenData($received_Token);
            $user_id='';
            if(isset($user['user_id']) && $user['user_id']){
                $user_id=$user['user_id'];
            }
            $config = array();
            $config["base_url"] = base_url() . "api/v1/contactus/share_stories_list";
            $config["total_rows"] = $this->ContactusModel->getTotalShareStoriesByUserId($user_id);
            $config["per_page"] = LIST_LIMIT;
            $total_no_of_pages=0;
            if($config["total_rows"]>0){
                $total_no_of_pages=ceil($config["total_rows"]/LIST_LIMIT);
            }
            $config["total_no_of_pages"] = $total_no_of_pages;
            $config["uri_segment"] = 5;
            /*$config['full_tag_open'] = "<ul class='pagination pagination-sm pro-page-list'>";
            $config['full_tag_close'] ="</ul>";
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
            $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
            $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
            $config['next_tag_open'] = "<li>";
            $config['next_tagl_close'] = "</li>";
            $config['prev_tag_open'] = "<li>";
            $config['prev_tagl_close'] = "</li>";
            $config['first_tag_open'] = "<li>";
            $config['first_tagl_close'] = "</li>";
            $config['last_tag_open'] = "<li>";
            $config['last_tagl_close'] = "</li>"; */
            $this->pagination->initialize($config);
            $page = ($this->uri->segment(5))? $this->uri->segment(5) : 0;
            $config['sharestorieslist'] = $this->ContactusModel->getShareStoriesListByUserId($user_id,$config["per_page"], $page);
            //$config["links"] = $this->pagination->create_links();
            //print_r($data);
            $this->response([
                'status' => True,
                'message' => $config,
            ], REST_Controller::HTTP_OK);
        }
    }
    // function: post_categories_list_get()
    // It is used to fetch post categories list
    public function post_categories_list_get(){
    	if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
        	$data=array();
        	$data["postcategorieslist"] = $this->ContactusModel->getPostCategoriesList();
            $this->response([
                'status' => True,
                'message' => $data,
            ], REST_Controller::HTTP_OK);
        }
    }
    // function: add_share_stories_post()
    // It is used to add share stories 
    public function add_share_stories_post(){
        if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $data=array();
	        $this->form_validation->set_data($this->post());
	        $this->form_validation->set_rules('posttitle', 'Post Title','trim|required',array('required'=>'Enter Post Title'));
	        $this->form_validation->set_rules('category_id', 'Category','required',array('required'=>'Please Select Category'));
	        if($this->form_validation->run() == FALSE){
	            $data = $this->form_validation->error_array();
	            $this->response([
	                'status' => False,
	                'message' => $data,
	            ], REST_Controller::HTTP_OK);
	        }else{
	            $result=$this->ContactusModel->addSharePost();
	            if($result==1){
	                $data["success_message"] = "Share Story added successfully";
	                $this->response([
	                    'status' => True,
	                    'message' => $data,
	                ], REST_Controller::HTTP_OK);
	            }else if(isset($result['error']) && $result['error']){
					if(isset($result['error']['upload_file']) && $result['error']['upload_file']){
						$data['upload_file_error']=$result['error']['upload_file'];
					}
					$this->response([
	                    'status' => False,
	                    'message' => $data,
	                ], REST_Controller::HTTP_OK);
				}else{
	                $data["error_message"] = "Something Went Wrong. Please Try Again.";
	                $this->response([
	                    'status' => False,
	                    'message' => $data,
	                ], REST_Controller::HTTP_OK);
	            }
	        }
        }
    }
    // function: get_share_stories_get()
    // It is used to get share stories details by id
    public function get_share_stories_get(){
        if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $share_post_id=base64_decode($this->input->get('share_post_id'));
            $data['share_stories_details']='';
            $data['files_arr']=array(); 
            if(isset($share_post_id) && $share_post_id!='' && $share_post_id!=null){
                $data['share_stories_details']=$this->ContactusModel->getShareStoriesById($share_post_id);
                $data['files_arr']=$this->ContactusModel->getSharePostUploadFileList($share_post_id);
            }
            $this->response([
                'status' => True,
                'message' => $data,
            ], REST_Controller::HTTP_OK);
        }
    }
    // function: edit_share_stories_post()
    // It is used to edit share stories
    public function edit_share_stories_post(){
        if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $data=array();
	        $this->form_validation->set_data($this->post());
	        $this->form_validation->set_rules('posttitle', 'Post Title','trim|required',array('required'=>'Enter Post Title'));
	        $this->form_validation->set_rules('category_id', 'Category','required',array('required'=>'Please Select Category'));
	        if($this->form_validation->run() == FALSE){
	            $data = $this->form_validation->error_array();
	            $this->response([
	                'status' => False,
	                'message' => $data,
	            ], REST_Controller::HTTP_OK);
	        }else{
	            $result=$this->ContactusModel->editSharePost();
	            if($result==1){
	                $data["success_message"] = "Share Story updated successfully";
	                $this->response([
	                    'status' => True,
	                    'message' => $data,
	                ], REST_Controller::HTTP_OK);
	            }else if(isset($result['error']) && $result['error']){
					if(isset($result['error']['upload_file']) && $result['error']['upload_file']){
						$data['upload_file_error']=$result['error']['upload_file'];
					}
					$this->response([
	                    'status' => False,
	                    'message' => $data,
	                ], REST_Controller::HTTP_OK);
				}else{
	                $data["error_message"] = "Something Went Wrong. Please Try Again.";
	                $this->response([
	                    'status' => False,
	                    'message' => $data,
	                ], REST_Controller::HTTP_OK);
	            }
	        }
        }
    }
    // function: delete_share_stories_get()
    // It is used to delete share stories
    public function delete_share_stories_get(){
        if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
        	$share_post_id=base64_decode($this->input->get('share_post_id'));
            $result=$this->ContactusModel->deleteSharePost($share_post_id);
            if($result==1){
                $data["success_message"] = "Share Story deleted successfully";
                $this->response([
                    'status' => True,
                    'message' => $data,
                ], REST_Controller::HTTP_OK);
            }else{
                $data["error_message"] = "Something Went Wrong. Please Try Again.";
                $this->response([
                    'status' => False,
                    'message' => $data,
                ], REST_Controller::HTTP_OK);
            }
        }
    }
    // function: download_share_stories_get()
    // It is used to download share stories
    public function download_share_stories_get(){
        if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
        	$result='';
            $id=base64_decode($this->input->get('share_post_id'));
        	if($id){
                $data["files_arr"]=getSharePostUploadFiles($id);
                $this->response([
                    'status' => True,
                    'message' => $data,
                ], REST_Controller::HTTP_OK);
				/* $this->load->library('zip');
				$sharepost=$this->ContactusModel->getSharePostById($id);
				$title='';
				if(isset($sharepost->posttitle) && $sharepost->posttitle!='' && $sharepost->posttitle!=null){
					$title=$sharepost->posttitle.'_';
				}
		        $files_arr=getSharePostUploadFileList($id);
		        if($files_arr){
		            foreach($files_arr as $file){
		                if(isset($file->upload_file) && $file->upload_file!='' && $file->upload_file!=null){
		                    $file_path="upload/upload_file/".$file->upload_file;
		                    if(file_exists($file_path)){
		                        $this->zip->read_file($file_path);
		                    }
		                }
		            }
		            $result=$this->zip->download($title.'share_post.zip');
		        } */
			}else{
                $data["error_message"] = "Something Went Wrong. Please Try Again.";
                $this->response([
                    'status' => False,
                    'message' => $data,
                ], REST_Controller::HTTP_OK);
            }
        }
    }
    // function: contact_us_get()
    // It is used to get contact
    public function contact_us_get(){
        if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $data['head_office']=$this->ContactusModel->getContactUsByType('Head Office');
            $data['valleys_institute']=$this->ContactusModel->getContactUsByType('Valleys Institute');
            $this->response([
                'status' => True,
                'message' => $data,
            ], REST_Controller::HTTP_OK);
        }
    }
}
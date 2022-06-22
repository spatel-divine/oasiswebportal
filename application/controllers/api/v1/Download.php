<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'controllers/JwtToken.php';
class Download extends REST_Controller {
    public function __construct() {
       parent::__construct();
       $this->load->model('api/v1/DownloadModel');
       $this->load->library("pagination");
    }
    // function: download_list_get()
    // It is used to get download list
    public function download_list_get(){
        if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $config = array();
            $config["base_url"] = base_url() . "api/v1/download/download_list";
            $config["total_rows"] = $this->DownloadModel->getTotalDownloadList();
            $config["per_page"] = LIST_LIMIT;
            $total_no_of_pages=0;
            if($config["total_rows"]>0){
                $total_no_of_pages=ceil($config["total_rows"]/LIST_LIMIT);
            }
            $config["total_no_of_pages"] = $total_no_of_pages;
            $config["uri_segment"] = 5;
            $this->pagination->initialize($config);
            $page = ($this->uri->segment(5))? $this->uri->segment(5) : 0;
            $config['downloadlist'] = $this->DownloadModel->getDownloadList($config["per_page"], $page);
            $this->response([
                'status' => True,
                'message' => $config,
            ], REST_Controller::HTTP_OK);
        }
    }
    // function: download_files_get()
    // It is used to get download list
    public function download_files_get(){
        if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $result='';
        	$id=$this->input->get('download_id');
        	if($id){
				$id=base64_decode($id);
                $data["files_arr"]=getDownloadManagementUploadFiles($id);
				/* $this->load->library('zip');
				$downloadmanagement=$this->DownloadModel->getDownloadManagementById($id);
				$title='downloadmanagement';
				if(isset($downloadmanagement->downloadtitle) && $downloadmanagement->downloadtitle!='' && $downloadmanagement->downloadtitle!=null){
					$title=$downloadmanagement->downloadtitle;
				}
		        $files_arr=getDownloadManagementUploadFileList($id);
		        if($files_arr){
		            foreach($files_arr as $file){
		                if(isset($file->upload_file) && $file->upload_file!='' && $file->upload_file!=null){
		                    $file_path="upload/download_management_upload_file/".$file->upload_file;
		                    if(file_exists($file_path)){
		                        $this->zip->read_file($file_path);
		                    }
		                }
		            }
		            $title = strtolower(str_replace(' ', '_',substr($title, 0, 25)));
		            $result=$this->zip->download($title.'.zip');
		        }
                $data["success_message"] = "Download data successfully"; */
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
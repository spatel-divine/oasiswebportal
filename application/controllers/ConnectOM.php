<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class ConnectOM extends CI_Controller {
	public function __construct(){
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
        $this->load->model('ConnectomModel');
    }
    // ********************* Start Contact Us *****************************
    // function: contact_us()
	// It is used to display contact
	public function contact_us(){
		$data=array();
		$this->load->model('Master/StateModel');
		$this->load->model('Master/RegionModel');
		$this->load->model('Management/CenterModel');
		$data['statelist']=$this->StateModel->getActiveStateList();
		$data['regionlist']=$this->RegionModel->getRegionByStateId();
		$data['centerlist']=$this->CenterModel->getCenterByRegionId();
		$data['head_office']=$this->ConnectomModel->getContactUsByType('Head Office');
		$data['valleys_institute']=$this->ConnectomModel->getContactUsByType('Valleys Institute');
		$this->load->view('contact_us',$data);
	}
	// function: ajax_get_center()
	// It is used to get center list by start date and end date
	public function ajax_get_center(){
		$message_arr=array();
		if(!is_logged_in()){
		    $message_arr['notvaliduserurl']=site_url('login');
		}else{
			// Start check Assign Rights
	    	$controller = strtolower($this->router->fetch_class());
			$method = strtolower($this->router->fetch_method());
			$result=checkAssignRights($controller,$method);
			// End check Assign Rights
			if(!$result){
			 	$message_arr['notvaliduserurl']=site_url('home/error403');
			}else{
				if(isset($_POST) && $_POST){
					$centerlist=$this->ConnectomModel->getCenterList();	
					$centerhtml='';
					if($centerlist){
						$centerhtml.='<tr><th class="font-weight-600">Center Name</th><th class="font-weight-600">Contact No</th></tr>';
						foreach($centerlist as $center){
							$centerhtml.='<tr>';
							if(isset($center->center_name) && $center->center_name!='' && $center->center_name!=null){
								$centerhtml.='<td>'.$center->center_name.'</td>';
							}else{
								$centerhtml.='<td>-</td>';
							}
							if(isset($center->center_contact_no) && $center->center_contact_no!='' && $center->center_contact_no!=null){
								$centerhtml.='<td><a href="tel:'.$center->center_contact_no.'">'.$center->center_contact_no.'</a></td>';
							}else{
								$centerhtml.='<td>-</td>';
							}
							$centerhtml.='</tr>';
						}
					}
					$message_arr['centerhtml']=$centerhtml;
				}
			}
		}
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($message_arr));
	}
	// function: ajax_update_contact_us()
	// It is used to update contact us by type
	public function ajax_update_contact_us(){
		$message_arr=array();
		if(!is_logged_in()){
		    $message_arr['notvaliduserurl']=site_url('login');
		}else{
			// Start check Assign Rights
	    	$controller = strtolower($this->router->fetch_class());
			$method = strtolower($this->router->fetch_method());
			$result=checkAssignRights($controller,$method);
			// End check Assign Rights
			if(!$result){
			 	$message_arr['notvaliduserurl']=site_url('home/error403');
			}else{
				if(isset($_POST) && $_POST){
					$this->form_validation->set_rules('address', 'Address', 'required',array('required'=>'Enter Address'));
					$this->form_validation->set_rules('phone', 'Phone', 'required',array('required'=>'Enter Phone Number'));
					$this->form_validation->set_rules('email', 'Email', 'required|valid_email',array('required'=>'Enter Email Address','valid_email'=>'Please Enter Valid Email Address'));
					if($this->form_validation->run() == FALSE){
						$message_arr=$this->form_validation->error_array();
					}else{
						$result=$this->ConnectomModel->updateContactUs();
						if($result==1){
							$message_arr['address']=$this->input->post('address');
							$message_arr['phone']=$this->input->post('phone');
							$message_arr['email']=$this->input->post('email');
							$message_arr['success_message']='<div class="alert alert-success"><font color="white"><b><a href="#" class="close" data-dismiss="alert" aria-label="close" style="color:#fff;">&times;</a>Contact Us Info updated successfully</b></font></div>';
						}else{
							$message_arr['error_message']='<div class="alert alert-danger"><font color="white"><b><a href="#" class="close" data-dismiss="alert" aria-label="close" style="color:#fff;">&times;</a>Contact Us Info has not been updated. Please Try Again!</b></font></div>';
						}
					}
				}
			}
		}
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($message_arr));
	}
	// ********************* End Contact Us *****************************
	// ********************* Start Share Post *****************************
	// function: share_post()
	// It is used to add share post
	public function share_post($share_post_id=''){
		$data=array();
		$this->load->model('Master/PostCategoryModel');
		if(isset($_POST) && $_POST){
			$this->form_validation->set_rules('posttitle', 'Post Title', 'required',array('required'=>'Enter Post Title'));
			$this->form_validation->set_rules('category_id', 'Category', 'required',array('required'=>'Please Select Category'));
			$this->form_validation->set_rules('post_description', 'Post Description', 'required',array('required'=>'Enter Post Description'));
			if($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('errors', validation_errors());
			}else{
				if(isset($_POST['share_post_id']) && $_POST['share_post_id']){
					//Update Share Post
					$result=$this->ConnectomModel->updateSharePost();
					if($result==1){
						$this->session->set_flashdata('success_message','Share Post has been updated successfully.');
						redirect('connectOM/view_shared_post_list');
					}else if(isset($result['error']) && $result['error']){
						if(isset($result['error']['featured_image']) && $result['error']['featured_image']){
							$data['featured_image_error']=$result['error']['featured_image'];
						}else if(isset($result['error']['upload_file']) && $result['error']['upload_file']){
							$data['upload_file_error']=$result['error']['upload_file'];
						}
					}else{
						$this->session->set_flashdata('error_message','Sorry, Share Post could not be updated. Try again.');
					}
				}else{
					//Insert Share Post
					$result=$this->ConnectomModel->insertSharePost();	
					if($result==1){				
						$this->session->set_flashdata('success_message','Share Post has been added successfully.');
						redirect('connectOM/view_shared_post_list');
					}else if(isset($result['error']) && $result['error']){
						if(isset($result['error']['featured_image']) && $result['error']['featured_image']){
							$data['featured_image_error']=$result['error']['featured_image'];
						}else if(isset($result['error']['upload_file']) && $result['error']['upload_file']){
							$data['upload_file_error']=$result['error']['upload_file'];
						}
					}else{
						$this->session->set_flashdata('error_message','Sorry, Share Post could not be added. Please try again.');
					}
				}
			}
		}
		$data['post_category_list']=$this->PostCategoryModel->getPostCategoryList();
		if($share_post_id){
			$share_post_id=base64_decode($share_post_id);
			$data['share_post']=$this->ConnectomModel->getSharePostById($share_post_id);
		}else if(isset($_POST['share_post_id']) && $_POST['share_post_id']!='' && $_POST['share_post_id']!=null){
			$share_post_id=base64_decode($this->input->post('share_post_id'));
			$data['share_post']=$this->ConnectomModel->getSharePostById($share_post_id);
		}
		$this->load->view('share_post',$data);
	}
	public function view_shared_post_list(){
		$data=array();
		$data['share_post_list']=$this->ConnectomModel->getSharePostList();
		$this->load->view('view_shared_post_list',$data);
	}
	public function view_share_post($share_post_id){
		$data=array();
		$share_post_id=base64_decode($share_post_id);
		$data['share_post']=$this->ConnectomModel->getSharePostById($share_post_id);
		$this->load->view('view_share_post',$data);
	}
	// function: ajax_delete_share_post_file_upload()
	// It is used to delete share post file upload using ajax
	public function ajax_delete_share_post_file_upload(){
		$message_arr=array();
		if(!is_logged_in()){
		    $message_arr['notvaliduserurl']=site_url('login');
		}else{
			// Start check Assign Rights
	    	$controller = strtolower($this->router->fetch_class());
			$method = strtolower($this->router->fetch_method());
			$result=checkAssignRights($controller,$method);
			// End check Assign Rights
			if(!$result){
			 	$message_arr['notvaliduserurl']=site_url('home/error403');
			}else{
				if(isset($_POST['id']) && $_POST['id']){
					$id=base64_decode($this->input->post('id'));
					$share_post_id=base64_decode($this->input->post('share_post_id'));
					$result=$this->ConnectomModel->deleteSharePostFileUpload($id);
					if($result==1){
						$file_upload_html='';
						$files_arr=getSharePostUploadFileList($share_post_id);
						if($files_arr){
							$file_upload_html.='<table class="table table-striped table-bordered text-wrap text-center"><thead><tr><th class="wd-15p">SR No</th><th class="wd-15p">Upload File</th><th class="wd-15p">Delete</th></tr></thead><tbody>';
							$i=1;
							foreach ($files_arr as $file){
								$file_upload_html.='<tr><td>'.$i.'</td><td>';
								if(isset($file->upload_file) && $file->upload_file!='' && $file->upload_file!=null){ 
									$filename_arr=explode(".",basename($file->upload_file));
	    							$ext=strtolower(end($filename_arr));
									$imgfile=array('jpg','jpeg','png','bmp');
									$audiofile=array('ogg','mp3');
									$videofile=array('mp4');
									$otherfile=array('doc','docx','pdf','xls','xlsx','ppt','ppsx');
									$filepath=base_url().'upload/upload_file/'.$file->upload_file;
									if(file_exists('upload/upload_file/'.$file->upload_file)){ 
										if(in_array($ext,$imgfile)){ 
											$file_upload_html.='<p class="imgcontainer"><a target="_blank" href="'.$filepath.'"><img class="imgfile" src="'.$filepath.'"/></a></p>';
								  		}else if(in_array($ext,$otherfile)){
								  			$file_upload_html.='<p class="doccontainer"><a target="_blank" href="'.$filepath.'"><span>'.$file->upload_file.'</span></a></p>';
								  		}else if(in_array($ext,$audiofile)){ 
								  			$file_upload_html.='<p class="audiocontainer"><audio controls>';
								  			if($ext=='opp'){
												$file_upload_html.='<source src="'.$filepath.'" type="audio/ogg">';
											}else{
												$file_upload_html.='<source src="'.$filepath.'" type="audio/mpeg">';  		
											}
											$file_upload_html.='Your browser does not support the audio element.</audio></p>';
								  		}else if(in_array($ext,$videofile)){
								  			$file_upload_html.='<p class="videocontainer"><video width="320" height="240" controls><source src="'.$filepath.'" type="video/mp4">Your browser does not support the video tag.</video></p>';
								  		}
									}
								}
								$file_upload_html.='</td><td style="width:20px;"><a class="btn btn-danger btn-sm" href="javascript:void(0);" onclick="deleteSharePostFileUpload(\''.base64_encode($file->id).'\',\''.base64_encode($file->share_post_id).'\');"><i class="fa fa-trash"></i> Delete</a></td></tr>';
								$i++;
							}
							$file_upload_html.='</tbody></table>';
						}
						$message_arr['file_upload_html']=$file_upload_html;
						$message_arr['success_message']='<div class="alert alert-success"><font color="white"><b><a href="#" class="close" data-dismiss="alert" aria-label="close" style="color:#fff;">&times;</a>File has been deleted successfully.</b></font></div>';
					}else{
						$message_arr['error_message']='<div class="alert alert-danger"><font color="white"><b><a href="#" class="close" data-dismiss="alert" aria-label="close" style="color:#fff;">&times;</a>Sorry, file has not been deleted. Please try again.</b></font></div>';
					}
				}
			}
		}
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($message_arr));
   	}
   	// function: delete_share_post()
	// It is used to delete share post
	public function delete_share_post($id){
		if($id){
			$id=base64_decode($id);
			$result=$this->ConnectomModel->deleteSharePost($id);
			if($result==1){
				$this->session->set_flashdata('success_message','Share Post has been deleted successfully.');
			}else{
				$this->session->set_flashdata('error_message','Sorry, Share Post could not be deleted. Try again.');
			}
		}else{
			$this->session->set_flashdata('error_message','Sorry, Share Post could not be deleted. Try again.');
		}
		redirect('connectOM/view_shared_post_list');
	}
	// function: download_share_post()
	// It is used to download share post
	public function download_share_post($id){
		if($id){
			$id=base64_decode($id);
			$this->load->library('zip');
			$sharepost=$this->ConnectomModel->getSharePostById($id);
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
	            $this->zip->download($title.'share_post.zip');
	        }
		}
	}
	// ********************* End Share Post *****************************
	/*public function download_management()
	{
		$this->load->view('download_management');
	}*/
	// ********************* Start Ask Us *******************************
	// function: ask_us()
	// It is used to display request list
	public function ask_us(){
		$data=array();
		if(isset($_POST) && $_POST){
			//Update Share Post
			$result=$this->ConnectomModel->giveResponse();
			if($result==1){
				$this->session->set_flashdata('success_message','Response has been added successfully.');
			}else{
				$this->session->set_flashdata('error_message','Sorry, Response could not be added. Please try again.');
			}
		}
		$data['requestlist']=$this->ConnectomModel->getRequestList();
		$this->load->view('ask_us',$data);
	}
	// function: ajax_fetch_request_by_id()
	// It is used to fetch request form html by field id using ajax
	public function ajax_fetch_request_by_id(){
		$message_arr=array();
		if(!is_logged_in()){
		    $message_arr['notvaliduserurl']=site_url('login');
		}else{
			// Start check Assign Rights
	    	$controller = strtolower($this->router->fetch_class());
			$method = strtolower($this->router->fetch_method());
			$result=checkAssignRights($controller,$method);
			// End check Assign Rights
			if(!$result){
			 	$message_arr['notvaliduserurl']=site_url('home/error403');
			}else{
				if(isset($_POST['id']) && $_POST['id']){
					$request_html='';
					$request_id=$this->input->post('id');
					$id=base64_decode($this->input->post('id'));
					$request_details=$this->ConnectomModel->getRequestDetails($id);
					if($request_details){
						$fullname='';
						if(isset($request_details->fullname) && $request_details->fullname!='' && $request_details->fullname!=null){
							$fullname=$request_details->fullname;
						}
						$request_date='';
						if(isset($request_details->request_date) && $request_details->request_date!='' && $request_details->request_date!=null){
							$request_date=date('d-m-Y',strtotime($request_details->request_date));
						}
						$queries='';
						if(isset($request_details->queries) && $request_details->queries!='' && $request_details->queries!=null){
							$queries=$request_details->queries;
						}
						$opinion='';
						if(isset($request_details->opinion) && $request_details->opinion!='' && $request_details->opinion!=null){
							$opinion=$request_details->opinion;
						}
						$suggestions='';
						if(isset($request_details->suggestions) && $request_details->suggestions!='' && $request_details->suggestions!=null){
							$suggestions=$request_details->suggestions;
						}
						$time_contribution_for='';
						if(isset($request_details->time_contribution_for) && $request_details->suggestions!='' && $request_details->time_contribution_for!=null){
							$time_contribution_for=$request_details->time_contribution_for;
						}
						$available_date1='';
						if(isset($request_details->available_date1) && $request_details->available_date1!='' && $request_details->available_date1!=null){
							$available_date1=date('d-m-Y',strtotime($request_details->available_date1));
						}
						$available_date2='';
						if(isset($request_details->available_date2) && $request_details->available_date2!='' && $request_details->available_date2!=null){
							$available_date2=date('d-m-Y',strtotime($request_details->available_date2));
						}
						$available_date3='';
						if(isset($request_details->available_date3) && $request_details->available_date3!='' && $request_details->available_date3!=null){
							$available_date3=date('d-m-Y',strtotime($request_details->available_date3));
						}
						$request_html.='<div class="form-group"><div class="row"><div class="col-lg-6 col-md-12"><label>Name</label><input type="text" class="form-control" value="'.$fullname.'" readonly></div><div class="col-lg-6 col-md-12"><label>Request Date</label><input type="text" class="form-control" value="'.$request_date.'" readonly></div></div></div><div class="form-group"><div class="row"><div class="col-lg-4 col-md-12"><label>Queries</label><textarea class="form-control" readonly>'.$queries.'</textarea></div><div class="col-lg-4 col-md-12"><label>Opinion</label><textarea class="form-control" readonly>'.$opinion.'</textarea></div><div class="col-lg-4 col-md-12"><label>Suggestions</label><textarea class="form-control" readonly>'.$suggestions.'</textarea></div></div></div><div class="form-group"><div class="row"><div class="col-lg-6 col-md-12"><label>Give Response <font color="red">*</font></label><textarea class="form-control" id="response" name="response" placeholder="Enter Your Response" required data-msg-required="Enter Response"></textarea><label id="response-error" class="error validationerror" for="response"></label></div><div class="col-lg-6 col-md-12"><label>Time Contribution For</label><textarea class="form-control" id="time_contribution_for" name="time_contribution_for" readonly>'.$time_contribution_for.'</textarea></div></div></div><div class="form-group"><div class="row"><div class="col-lg-4 col-md-12"><label>Available Date1</label><input type="text" class="form-control" value="'.$available_date1.'" readonly></div><div class="col-lg-4 col-md-12"><label>Available Date2</label><input type="text" class="form-control" value="'.$available_date2.'" readonly></div><div class="col-lg-4 col-md-12"><label>Available Date3</label><input type="text" class="form-control" value="'.$available_date3.'" readonly></div></div></div><hr/><input type="hidden" id="request_id" name="request_id" value="'.$request_id.'"/><div class="form-group"  style="float:right;"><div class="row"><input type="submit" name="submit" value="Submit" class="btn btn-app btn-primary mr-2 mt-1 mb-1" ></div></div>';
					}
					$message_arr['request_html']=$request_html;
				}
			}
		}
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($message_arr));
	}
	// function: ajax_view_request_by_id()
	// It is used to fetch request form html by field id using ajax
	public function ajax_view_request_by_id(){
		$message_arr=array();
		if(!is_logged_in()){
		    $message_arr['notvaliduserurl']=site_url('login');
		}else{
			// Start check Assign Rights
	    	$controller = strtolower($this->router->fetch_class());
			$method = strtolower($this->router->fetch_method());
			$result=checkAssignRights($controller,$method);
			// End check Assign Rights
			if(!$result){
			 	$message_arr['notvaliduserurl']=site_url('home/error403');
			}else{
				if(isset($_POST['id']) && $_POST['id']){
					$view_request_html='';
					$request_id=$this->input->post('id');
					$id=base64_decode($this->input->post('id'));
					$request_details=$this->ConnectomModel->getRequestDetails($id);
					if($request_details){
						$fullname='';
						if(isset($request_details->fullname) && $request_details->fullname!='' && $request_details->fullname!=null){
							$fullname=$request_details->fullname;
						}
						$request_date='';
						if(isset($request_details->request_date) && $request_details->request_date!='' && $request_details->request_date!=null){
							$request_date=date('d-m-Y',strtotime($request_details->request_date));
						}
						$response_date='';
						if(isset($request_details->response_date) && $request_details->response_date!='' && $request_details->response_date!=null){
							$response_date=date('d-m-Y',strtotime($request_details->response_date));
						}
						$queries='';
						if(isset($request_details->queries) && $request_details->queries!='' && $request_details->queries!=null){
							$queries=$request_details->queries;
						}
						$opinion='';
						if(isset($request_details->opinion) && $request_details->opinion!='' && $request_details->opinion!=null){
							$opinion=$request_details->opinion;
						}
						$suggestions='';
						if(isset($request_details->suggestions) && $request_details->suggestions!='' && $request_details->suggestions!=null){
							$suggestions=$request_details->suggestions;
						}
						$response='';
						if(isset($request_details->response) && $request_details->response!='' && $request_details->response!=null){
							$response=$request_details->response;
						}
						$time_contribution_for='';
						if(isset($request_details->time_contribution_for) && $request_details->suggestions!='' && $request_details->time_contribution_for!=null){
							$time_contribution_for=$request_details->time_contribution_for;
						}
						$available_date1='';
						if(isset($request_details->available_date1) && $request_details->available_date1!='' && $request_details->available_date1!=null){
							$available_date1=date('d-m-Y',strtotime($request_details->available_date1));
						}
						$available_date2='';
						if(isset($request_details->available_date2) && $request_details->available_date2!='' && $request_details->available_date2!=null){
							$available_date2=date('d-m-Y',strtotime($request_details->available_date2));
						}
						$available_date3='';
						if(isset($request_details->available_date3) && $request_details->available_date3!='' && $request_details->available_date3!=null){
							$available_date3=date('d-m-Y',strtotime($request_details->available_date3));
						}
						$view_request_html.='<div class="form-group"><div class="row"><div class="col-lg-4 col-md-12"><label>Name</label><input type="text" class="form-control" value="'.$fullname.'" readonly></div><div class="col-lg-4 col-md-12"><label>Request Date</label><input type="text" class="form-control" value="'.$request_date.'" readonly></div><div class="col-lg-4 col-md-12"><label>Response Date</label><input type="text" class="form-control" value="'.$response_date.'" readonly></div></div></div><div class="form-group"><div class="row"><div class="col-lg-4 col-md-12"><label>Queries</label><textarea class="form-control" readonly>'.$queries.'</textarea></div><div class="col-lg-4 col-md-12"><label>Opinion</label><textarea class="form-control" readonly>'.$opinion.'</textarea></div><div class="col-lg-4 col-md-12"><label>Suggestions</label><textarea class="form-control" readonly>'.$suggestions.'</textarea></div></div></div><div class="form-group"><div class="row"><div class="col-lg-6 col-md-12"><label>Give Response</label><textarea class="form-control" id="response" name="response" placeholder="Enter Your Response" readonly>'.$response.'</textarea></div><div class="col-lg-6 col-md-12"><label>Time Contribution For</label><textarea class="form-control" id="time_contribution_for" name="time_contribution_for" readonly>'.$time_contribution_for.'</textarea></div></div></div><div class="form-group"><div class="row"><div class="col-lg-4 col-md-12"><label>Available Date1</label><input type="text" class="form-control" value="'.$available_date1.'" readonly></div><div class="col-lg-4 col-md-12"><label>Available Date2</label><input type="text" class="form-control" value="'.$available_date2.'" readonly></div><div class="col-lg-4 col-md-12"><label>Available Date3</label><input type="text" class="form-control" value="'.$available_date3.'" readonly></div></div></div>';
					}
					$message_arr['view_request_html']=$view_request_html;
				}
			}
		}
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($message_arr));
	}
	// ********************* End Ask Us *****************************
	// ********************* Start Download Management **************
	// function: add_download_data($download_management_id)
	// It is used to add/update download data
	public function add_download_data($download_management_id=''){
		$data=array();
		$this->load->model('Master/DownloadCategoryModel');
		if(isset($_POST) && $_POST){
			$this->form_validation->set_rules('downloadtitle', 'Download Title', 'required',array('required'=>'Enter Download Title'));
			$this->form_validation->set_rules('category_id', 'Category', 'required',array('required'=>'Please Select Category'));
			if($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('errors', validation_errors());
			}else{
				if(isset($_POST['download_management_id']) && $_POST['download_management_id']){
					//Update Download Management
					$result=$this->ConnectomModel->updateDownloadManagement();
					if($result==1){
						$this->session->set_flashdata('success_message','Download Management has been updated successfully.');
						redirect('connectOM/view_downloads_data_list');
					}else if(isset($result['error']) && $result['error']){
						if(isset($result['error']['upload_file']) && $result['error']['upload_file']){
							$data['upload_file_error']=$result['error']['upload_file'];
						}
					}else{
						$this->session->set_flashdata('error_message','Sorry, Download Management could not be updated. Please try again.');
					}
				}else{
					//Insert Download Management
					$result=$this->ConnectomModel->insertDownloadManagement();
					if($result==1){				
						$this->session->set_flashdata('success_message','Download Management has been added successfully.');
						redirect('connectOM/view_downloads_data_list');
					}else if(isset($result['error']) && $result['error']){
						if(isset($result['error']['upload_file']) && $result['error']['upload_file']){
							$data['upload_file_error']=$result['error']['upload_file'];
						}
					}else{
						$this->session->set_flashdata('error_message','Sorry, Download Management could not be added. Please try again.');
					}
				}
			}
		}
		$data['download_category_list']=$this->DownloadCategoryModel->getDownloadCategoryList();
		if($download_management_id){
			$download_management_id=base64_decode($download_management_id);
			$data['download_management']=$this->ConnectomModel->getDownloadManagementById($download_management_id);
		}else if(isset($_POST['download_management_id']) && $_POST['download_management_id']!='' && $_POST['download_management_id']!=null){
			$download_management_id=base64_decode($this->input->post('download_management_id'));
			$data['download_management']=$this->ConnectomModel->getDownloadManagementById($download_management_id);
		}
		$this->load->view('add_download_data',$data);
	}
	// function: view_downloads_data_list()
	// It is used to add/update download data
	public function view_downloads_data_list(){
		$data=array();
		$data['download_management_list']=$this->ConnectomModel->getDownloadManagementList();
		$this->load->view('view_downloads_data_list',$data);
	}
	// function: view_download_management($download_management_id)
	// It is used to view download management data
	public function view_download_management($download_management_id){
		$data=array();
		$download_management_id=base64_decode($download_management_id);
		$data['download_management']=$this->ConnectomModel->getDownloadManagementById($download_management_id);
		$this->load->view('view_download_management',$data);
	}
	// function: delete_download_management($id)
	// It is used to delete download management
	public function delete_download_management($id){
		if($id){
			$id=base64_decode($id);
			$result=$this->ConnectomModel->deleteDownloadManagement($id);
			if($result==1){
				$this->session->set_flashdata('success_message','Download Load has been deleted successfully.');
			}else{
				$this->session->set_flashdata('error_message','Sorry, Download Load could not be deleted. Try again.');
			}
		}else{
			$this->session->set_flashdata('error_message','Sorry, Download Load could not be deleted. Try again.');
		}
		redirect('connectOM/view_downloads_data_list');
	}
	// function: download_download_management()
	// It is used to download 'download management'
	public function download_download_management($id){
		if($id){
			$id=base64_decode($id);
			$this->load->library('zip');
			$downloadmanagement=$this->ConnectomModel->getDownloadManagementById($id);
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
	            $this->zip->download($title.'.zip');
	        }
		}
	}
	// function: ajax_delete_download_management_file_upload()
	// It is used to delete download management file upload using ajax
	public function ajax_delete_download_management_file_upload(){
		$message_arr=array();
		if(!is_logged_in()){
		    $message_arr['notvaliduserurl']=site_url('login');
		}else{
			// Start check Assign Rights
	    	$controller = strtolower($this->router->fetch_class());
			$method = strtolower($this->router->fetch_method());
			$result=checkAssignRights($controller,$method);
			// End check Assign Rights
			if(!$result){
			 	$message_arr['notvaliduserurl']=site_url('home/error403');
			}else{
				if(isset($_POST['id']) && $_POST['id']){
					$id=base64_decode($this->input->post('id'));
					$download_management_id=base64_decode($this->input->post('download_management_id'));
					$result=$this->ConnectomModel->deleteDownloadManagementFileUpload($id);
					if($result==1){
						$file_upload_html='';
						$files_arr=getDownloadManagementUploadFileList($download_management_id);
						if($files_arr){
							$file_upload_html.='<table class="table table-striped table-bordered text-wrap text-center"><thead><tr><th class="wd-15p">SR No</th><th class="wd-15p">Upload File</th><th class="wd-15p">Delete</th></tr></thead><tbody>';
							$i=1;
							foreach ($files_arr as $file){
								$file_upload_html.='<tr><td>'.$i.'</td><td>';
								if(isset($file->upload_file) && $file->upload_file!='' && $file->upload_file!=null){ 
									$filename_arr=explode(".",basename($file->upload_file));
	    							$ext=strtolower(end($filename_arr));
									$imgfile=array('jpg','jpeg','png','bmp');
									$audiofile=array('ogg','mp3');
									$videofile=array('mp4');
									$otherfile=array('doc','docx','pdf','xls','xlsx','ppt','ppsx');
									$filepath=base_url().'upload/download_management_upload_file/'.$file->upload_file;
									if(file_exists('upload/download_management_upload_file/'.$file->upload_file)){ 
										if(in_array($ext,$imgfile)){ 
											$file_upload_html.='<p class="imgcontainer"><a target="_blank" href="'.$filepath.'"><img class="imgfile" src="'.$filepath.'"/></a></p>';
								  		}else if(in_array($ext,$otherfile)){
								  			$file_upload_html.='<p class="doccontainer"><a target="_blank" href="'.$filepath.'"><span>'.$file->upload_file.'</span></a></p>';
								  		}else if(in_array($ext,$audiofile)){ 
								  			$file_upload_html.='<p class="audiocontainer"><audio controls>';
								  			if($ext=='opp'){
												$file_upload_html.='<source src="'.$filepath.'" type="audio/ogg">';
											}else{
												$file_upload_html.='<source src="'.$filepath.'" type="audio/mpeg">';  		
											}
											$file_upload_html.='Your browser does not support the audio element.</audio></p>';
								  		}else if(in_array($ext,$videofile)){
								  			$file_upload_html.='<p class="videocontainer"><video width="320" height="240" controls><source src="'.$filepath.'" type="video/mp4">Your browser does not support the video tag.</video></p>';
								  		}
									}
								}
								$file_upload_html.='</td><td style="width:20px;"><a class="btn btn-danger btn-sm" href="javascript:void(0);" onclick="deleteDownloadManagementFileUpload(\''.base64_encode($file->id).'\',\''.base64_encode($file->download_management_id).'\');"><i class="fa fa-trash"></i> Delete</a></td></tr>';
								$i++;
							}
							$file_upload_html.='</tbody></table>';
						}
						$message_arr['file_upload_html']=$file_upload_html;
						$message_arr['success_message']='<div class="alert alert-success"><font color="white"><b><a href="#" class="close" data-dismiss="alert" aria-label="close" style="color:#fff;">&times;</a>File has been deleted successfully.</b></font></div>';
					}else{
						$message_arr['error_message']='<div class="alert alert-danger"><font color="white"><b><a href="#" class="close" data-dismiss="alert" aria-label="close" style="color:#fff;">&times;</a>Sorry, file has not been deleted. Please try again.</b></font></div>';
					}
				}
			}
		}
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($message_arr));
   	}
	// ********************* End Download Management *************************
}
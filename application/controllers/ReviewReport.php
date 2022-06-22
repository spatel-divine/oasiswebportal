<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class ReviewReport extends CI_Controller {
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
        $this->load->model('ReviewreportModel');
    }
    // function: review_summary_report()
	// It is used to display review summary report
	public function review_summary_report(){
		$data=array();
		$data['reviewlist']=$this->ReviewreportModel->getReviewList();
		$this->load->view('review_summary_report',$data);
	}
	// function: get_review_report_list()
	// It is used to display review summary list
	public function get_review_report_list(){
		$data=array();
		$data['tablename']='';
		if(isset($_GET['tablename']) && $_GET['tablename']){
			$data['tablename']=$this->input->get('tablename');
		}
		$this->load->model('Management/ProgramMasterModel');
		$data['programlist']=$this->ProgramMasterModel->getActiveProgramList();
		$data['sessionlist']=$this->ProgramMasterModel->getActiveSessionList();
		$this->load->view('review_report_list',$data);
	}
	// function: ajax_get_review_summary_report()
	// It is used to get review summary report list by ajax
	public function ajax_get_review_summary_report(){
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
				$reviewsummaryreportlisthtml='';
				if(isset($_POST) && $_POST){
					$reviewsummaryreport_list=$this->ReviewreportModel->getReviewSummaryReportByFilter();
					if($reviewsummaryreport_list){
						$tablename=$this->input->post('tablename');
						foreach($reviewsummaryreport_list as $reviewsummaryreport){
							$reviewsummaryreportlisthtml.='<tr><td>'.$reviewsummaryreport->program_name.'</td><td>'.$reviewsummaryreport->batch_name.'</td><td>'.$reviewsummaryreport->session_name.'</td><td>'.date('d-m-Y',strtotime($reviewsummaryreport->created_at)).'</td><td><a target="_blank" title="View" class="btn btn-primary btn-sm tooltipcls" href="'.site_url('ReviewReport/review_summary_details/').$tablename.'/'.$reviewsummaryreport->id.'"><i class="fa fa-eye"></i></a></td></tr>';
						}
					}
				}
				$message_arr['reviewsummaryreportlisthtml']=$reviewsummaryreportlisthtml;
			}
		}
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($message_arr));
	}
	// function: review_summary_details()
	// It is used to fetch review summary details
	public function review_summary_details($tablename,$id){
		$data=array();
		$data['tablename']=$tablename;
		$reviews=$this->ReviewreportModel->getReviewDetails($tablename,$id);
		$data['reviewdetails']=json_decode($reviews->reviews);
		//print_r($data['reviewdetails']);die();
		$data['reviews']=$reviews;
		$data['reviews_files']=$this->ReviewreportModel->getReviewFilesDetails($tablename,$id);
		$this->load->view('review_summary_details',$data);
	}
}
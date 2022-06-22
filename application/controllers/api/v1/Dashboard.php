<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'controllers/JwtToken.php';
class Dashboard extends REST_Controller {
    public function __construct() {
       parent::__construct();
       $this->load->model('api/v1/DashboardModel');
    }
    // function: omoverview_get()
    // It is used to get overview details of om project
    public function omoverview_get(){
        if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $data=array();
            $data["totalomprogramsdetails"] = $this->DashboardModel->getTotalOmProgramsDetails();
            $data["totalomprograms"] = $this->DashboardModel->getTotalOmPrograms();
            $data["totalombeneficiariesdetails"] = $this->DashboardModel->getTotalOmBeneficiariesDetails();
            $data["totalombeneficiaries"] = $this->DashboardModel->getTotalOmBeneficiaries();
            $data["programthisyeardetails"] = $this->DashboardModel->getProgramThisYearDetails();
            $data["programthisyear"] = $this->DashboardModel->getProgramThisYear();
            $data["totalombeneficiariesthisyeardetails"] = $this->DashboardModel->getTotalOmBeneficiariesThisYearDetails();
            $data["totalombeneficiariesthisyear"] = $this->DashboardModel->getTotalOmBeneficiariesThisYear();
            $data["totalbeneficiarieschildrenyouthdetails"] = $this->DashboardModel->getTotalBeneficiariesChildrenYouthDetails();
            $data["totalbeneficiarieschildrenyouth"] = $this->DashboardModel->getTotalBeneficiariesChildrenYouth();
            $data["totalbeneficiariesadultsdetails"] = $this->DashboardModel->getTotalBeneficiariesAdultsDetails();
            $data["totalbeneficiariesadults"] = $this->DashboardModel->getTotalBeneficiariesAdults();
            $this->response([
                'status' => True,
                'message' => $data,
            ], REST_Controller::HTTP_OK);
        }
    }
    // function: ongoing_upcoming_programs_get()
    // It is used to get ongoing upcoming programs details 
    public function ongoing_upcoming_programs_get(){
        if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $data=array();
            $data["ongoingprogramsdetail"] = $this->DashboardModel->getOnGoingProgramDetails();
            $data["upcomingprogramsdetail"] = $this->DashboardModel->getUpComingProgramDetails();
            $this->response([
                'status' => True,
                'message' => $data,
            ], REST_Controller::HTTP_OK);
        }
    }
    // function: my_journey_with_om_get()
    // It is used to get journey with om by login user id
    public function my_journey_with_om_get(){
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
            $data["journeywithom"] = $this->DashboardModel->getJourneyWithOm($user_id);
            $this->response([
                'status' => True,
                'message' => $data,
            ], REST_Controller::HTTP_OK);
        }
    }
}
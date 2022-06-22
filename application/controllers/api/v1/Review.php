<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'controllers/JwtToken.php';
class Review extends REST_Controller {
    public function __construct(){
       parent::__construct();
       $this->load->model('api/v1/ReviewModel');
    }
    // function: program_feedback_form_data_get()
    // It is used to fetch program feedback form data
    public function program_feedback_form_data_get(){
    	if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $data=array();
            $data["batch_list"] = $this->ReviewModel->getBatchList();
            $data["user_types"] = $this->ReviewModel->getUserTypesListByTypeName(USER_TYPE_IDS_FOR_F_CF_V);
            $data["program_feedback"] = $this->ReviewModel->getProgramFeedback();
            $this->response([
                'status' => True,
                'message' => $data,
            ], REST_Controller::HTTP_OK);
        }
    }
    // function: program_name_by_batch_id_get()
    // It is used to fetch program name by batch id
    public function program_name_by_batch_id_get(){
        if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $data=array();
            $batch_id=$this->input->get("batch_id");
            $data["program_name"] = $this->ReviewModel->getProgramNameByBatchId($batch_id);
            $this->response([
                'status' => True,
                'message' => $data,
            ], REST_Controller::HTTP_OK);
        }
    }
    // function: sessionlist_by_program_name_get()
    // It is used to fetch session list by program name
    public function sessionlist_by_program_name_get(){
        if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $data=array();
            $program_name=$this->input->get("program_name");
            $data["sessionlist"] = $this->ReviewModel->sessionListByProgramName($program_name);
            $this->response([
                'status' => True,
                'message' => $data,
            ], REST_Controller::HTTP_OK);
        }
    }
    // function: dynamic_field_options_by_related_table_name_get()
    // It is used to get options from related table name
    public function dynamic_field_options_by_related_table_name_get(){
        if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $data=array();
            $related_table_name=$this->input->get("related_table_name");
            $data["optionslist"] = $this->ReviewModel->getDynamicFieldOptionByRelatedTable($related_table_name);
            $this->response([
                'status' => True,
                'message' => $data,
            ], REST_Controller::HTTP_OK);
        }
    }
    // function: dynamic_field_optionlist_get()
    // It is used to get options list
    public function dynamic_field_optionlist_get(){
        if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $data=array();
            $tablename=$this->input->get("tablename");
            $related_table_id=$this->input->get("field_id");
            $fieldtype=$this->input->get("fieldtype");
            $field_name='';
            if(isset($_GET['field_name']) && $_GET['field_name']){
                $field_name=$this->input->get("field_name");
            }
            $data["optionslist"] = $this->ReviewModel->getDynamicFieldOption($tablename, $related_table_id, $fieldtype, $field_name);
            $this->response([
                'status' => True,
                'message' => $data,
            ], REST_Controller::HTTP_OK);
        }
    }
    // function: program_feedback_review_post()
    // It is used to add program feedback review
    public function program_feedback_review_post(){
        if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $data=array();
            $this->form_validation->set_rules('batch_name', 'Batch', 'required', array('required' => 'Please Select Batch'));
            $this->form_validation->set_rules('user_type', 'Type Of User', 'required', array('required' => 'Please Select Type Of User'));
            $program_feedback = $this->ReviewModel->getRequiredFieldList('program_feedback_form');
            if($program_feedback){
                foreach($program_feedback as $r){
                    if($r->field_type=='dropdown' || $r->field_type=='date' || $r->field_type=='radio' || $r->field_type=='checkbox'){
                        $required_valid_msg='Please Select '.$r->field_label; 
                    }else{
                        $required_valid_msg=$r->field_label.' is required'; 
                    }
                    if($r->field_type!='file'){
                        if($r->special_feature=='multiple select2'){
                            $this->form_validation->set_rules($r->field_name.'[]', $r->field_label, 'required', array('required' => $required_valid_msg));
                        }else{
                            $this->form_validation->set_rules($r->field_name, $r->field_label, 'required', array('required' => $required_valid_msg));
                        }
                    }
                }
            }
            if($this->form_validation->run() == FALSE){
                $data = $this->form_validation->error_array();
                $this->response([
                    'status' => False,
                    'message' => $data,
                ], REST_Controller::HTTP_OK);
            }else{
                $result=$this->ReviewModel->addProgramFeedbackReview();
                if(isset($result['success']) && $result['success']==1){
                    $data["success_message"] = "Program Feedback Review added successfully.";
                    $this->response([
                        'status' => True,
                        'message' => $data,
                    ], REST_Controller::HTTP_OK);
                }else if(isset($result['error']) && $result['error']){
                    $data["error_message"] = $result['error'];
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
    // function: personal_reflection_form_data_get()
    // It is used to fetch program feedback form data
    public function personal_reflection_form_data_get(){
        if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $data=array();
            $data["batch_list"] = $this->ReviewModel->getBatchList();
            $data["user_types"] = $this->ReviewModel->getUserTypesListByTypeName(USER_TYPE_IDS_FOR_F_CF);
            $data["personal_learning"] = $this->ReviewModel->getPersonalLearning();
            $this->response([
                'status' => True,
                'message' => $data,
            ], REST_Controller::HTTP_OK);
        }
    }
    // function: personal_reflection_review_post()
    // It is used to add personal reflection review
    public function personal_reflection_review_post(){
        if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $data=array();
            $this->form_validation->set_rules('batch_name', 'Batch', 'required', array('required' => 'Please Select Batch'));
            $this->form_validation->set_rules('user_type', 'Type Of User', 'required', array('required' => 'Please Select Type Of User'));
            $personal_learning = $this->ReviewModel->getRequiredFieldList('personal_learning_form');
            if($personal_learning){
                foreach($personal_learning as $r){
                    if($r->field_type=='dropdown' || $r->field_type=='date' || $r->field_type=='radio' || $r->field_type=='checkbox'){
                        $required_valid_msg='Please Select '.$r->field_label; 
                    }else{
                        $required_valid_msg=$r->field_label.' is required'; 
                    }
                    if($r->field_type!='file'){
                        if($r->special_feature=='multiple select2'){
                            $this->form_validation->set_rules($r->field_name.'[]', $r->field_label, 'required', array('required' => $required_valid_msg));
                        }else{
                            $this->form_validation->set_rules($r->field_name, $r->field_label, 'required', array('required' => $required_valid_msg));
                        }
                    }
                }
            }
            if($this->form_validation->run() == FALSE){
                $data = $this->form_validation->error_array();
                $this->response([
                    'status' => False,
                    'message' => $data,
                ], REST_Controller::HTTP_OK);
            }else{
                $result=$this->ReviewModel->addPersonalReflectionReview();
                if(isset($result['success']) && $result['success']==1){
                    $data["success_message"] = "Personal Reflection Review added successfully.";
                    $this->response([
                        'status' => True,
                        'message' => $data,
                    ], REST_Controller::HTTP_OK);
                }else if(isset($result['error']) && $result['error']){
                    $data["error_message"] = $result['error'];
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
    // function: feedback_for_participants_form_data_get()
    // It is used to fetch program feedback form data
    public function feedback_for_participants_form_data_get(){
        if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $data=array();
            $data["batch_list"] = $this->ReviewModel->getBatchList();
            $data["user_types"] = $this->ReviewModel->getUserTypesListByTypeName(USER_TYPE_IDS_FOR_F_CF);
            $data["feedback_participant"] = $this->ReviewModel->getFeedbackParticipant();
            $this->response([
                'status' => True,
                'message' => $data,
            ], REST_Controller::HTTP_OK);
        }
    }
    // function: total_registered_participants_by_batch_id_get()
    // It is used to fetch total registered participants by batch id
    public function total_registered_participants_by_batch_id_get(){
        if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $data=array();
            $batch_id=$this->input->get("batch_id");
            $data["total_registered_participants"] = $this->ReviewModel->getParticipantsByBatchId($batch_id);
            $this->response([
                'status' => True,
                'message' => $data,
            ], REST_Controller::HTTP_OK);
        }
    }
    // function: feedback_for_participants_review_post()
    // It is used to add feedback for participants review
    public function feedback_for_participants_review_post(){
        if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $data=array();
            $this->form_validation->set_rules('batch_name', 'Batch', 'required', array('required' => 'Please Select Batch'));
            $this->form_validation->set_rules('user_type', 'Type Of User', 'required', array('required' => 'Please Select Type Of User'));
            $feedback_participant = $this->ReviewModel->getRequiredFieldList('feedback_for_participants_form');
            if($feedback_participant){
                foreach($feedback_participant as $r){
                    if($r->field_type=='dropdown' || $r->field_type=='date' || $r->field_type=='radio' || $r->field_type=='checkbox'){
                        $required_valid_msg='Please Select '.$r->field_label; 
                    }else{
                        $required_valid_msg=$r->field_label.' is required'; 
                    }
                    if($r->field_type!='file'){
                        if($r->special_feature=='multiple select2'){
                            $this->form_validation->set_rules($r->field_name.'[]', $r->field_label, 'required', array('required' => $required_valid_msg));
                        }else{
                            $this->form_validation->set_rules($r->field_name, $r->field_label, 'required', array('required' => $required_valid_msg));
                        }
                    }
                }
            }
            if($this->form_validation->run() == FALSE){
                $data = $this->form_validation->error_array();
                $this->response([
                    'status' => False,
                    'message' => $data,
                ], REST_Controller::HTTP_OK);
            }else{
                $result=$this->ReviewModel->addFeedbackForParticipantsReview();
                if(isset($result['success']) && $result['success']==1){
                    $data["success_message"] = "Feedback for Participants Review added successfully.";
                    $this->response([
                        'status' => True,
                        'message' => $data,
                    ], REST_Controller::HTTP_OK);
                }else if(isset($result['error']) && $result['error']){
                    $data["error_message"] = $result['error'];
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
    // function: program_feedback_by_participants_form_data_get()
    // It is used to fetch program feedback by participants form data
    public function program_feedback_by_participants_form_data_get(){
        if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $data=array();
            $data["batch_list"] = $this->ReviewModel->getBatchList();
            $data['feedback_by_participant'] = $this->ReviewModel->getFeedbackByParticipant();
            $this->response([
                'status' => True,
                'message' => $data,
            ], REST_Controller::HTTP_OK);
        }
    }
    // function: program_feedback_by_participants_review_post()
    // It is used to add program feedback by participants review
    public function program_feedback_by_participants_review_post(){
        if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $data=array();
            $this->form_validation->set_rules('batch_name', 'Batch', 'required', array('required' => 'Please Select Batch'));
            $feedback_by_participant = $this->ReviewModel->getRequiredFieldList('program_feedback_by_participants_form');
            if($feedback_by_participant){
                foreach($feedback_by_participant as $r){
                    if($r->field_type=='dropdown' || $r->field_type=='date' || $r->field_type=='radio' || $r->field_type=='checkbox'){
                        $required_valid_msg='Please Select '.$r->field_label; 
                    }else{
                        $required_valid_msg=$r->field_label.' is required'; 
                    }
                    if($r->field_type!='file'){
                        if($r->special_feature=='multiple select2'){
                            $this->form_validation->set_rules($r->field_name.'[]', $r->field_label, 'required', array('required' => $required_valid_msg));
                        }else{
                            $this->form_validation->set_rules($r->field_name, $r->field_label, 'required', array('required' => $required_valid_msg));
                        }
                    }
                }
            }
            if($this->form_validation->run() == FALSE){
                $data = $this->form_validation->error_array();
                $this->response([
                    'status' => False,
                    'message' => $data,
                ], REST_Controller::HTTP_OK);
            }else{
                $result=$this->ReviewModel->addProgramFeedbackByParticipantsReview();
                if(isset($result['success']) && $result['success']==1){
                    $data["success_message"] = "Program Feedback by Participants Review added successfully.";
                    $this->response([
                        'status' => True,
                        'message' => $data,
                    ], REST_Controller::HTTP_OK);
                }else if(isset($result['error']) && $result['error']){
                    $data["error_message"] = $result['error'];
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
    // function: star_participants_form_data_get()
    // It is used to fetch star participants form data
    public function star_participants_form_data_get(){
        if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $data=array();
            $data["batch_list"] = $this->ReviewModel->getBatchList();
            $data['star_participant'] = $this->ReviewModel->getStarParticipant();
            $this->response([
                'status' => True,
                'message' => $data,
            ], REST_Controller::HTTP_OK);
        }
    }
    // function: star_participants_review_post()
    // It is used to star participants review
    public function star_participants_review_post(){
        if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $data=array();
            $this->form_validation->set_rules('batch_name', 'Batch', 'required', array('required' => 'Please Select Batch'));
            $star_participants = $this->ReviewModel->getRequiredFieldList('star_participants_form');
            if($star_participants){
                foreach($star_participants as $r){
                    if($r->field_type=='dropdown' || $r->field_type=='date' || $r->field_type=='radio' || $r->field_type=='checkbox'){
                        $required_valid_msg='Please Select '.$r->field_label; 
                    }else{
                        $required_valid_msg=$r->field_label.' is required'; 
                    }
                    if($r->field_type!='file'){
                        if($r->special_feature=='multiple select2'){
                            $this->form_validation->set_rules($r->field_name.'[]', $r->field_label, 'required', array('required' => $required_valid_msg));
                        }else{
                            $this->form_validation->set_rules($r->field_name, $r->field_label, 'required', array('required' => $required_valid_msg));
                        }
                    }
                }
            }
            if($this->form_validation->run() == FALSE){
                $data = $this->form_validation->error_array();
                $this->response([
                    'status' => False,
                    'message' => $data,
                ], REST_Controller::HTTP_OK);
            }else{
                $result=$this->ReviewModel->addStarParticipantsReview();
                if(isset($result['success']) && $result['success']==1){
                    $data["success_message"] = "Star Participants Review added successfully.";
                    $this->response([
                        'status' => True,
                        'message' => $data,
                    ], REST_Controller::HTTP_OK);
                }else if(isset($result['error']) && $result['error']){
                    $data["error_message"] = $result['error'];
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
    // function: impact_assessment_form_data_get()
    // It is used to fetch impact assessment form data
    public function impact_assessment_form_data_get(){
        if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $data=array();
            $data["batch_list"] = $this->ReviewModel->getBatchList();
            $data['impact_assessment'] = $this->ReviewModel->getImactOnCharacterTraits();
            $data['parameter_or_characteristics_list'] = $this->ReviewModel->getParameterOrCharacteristicsList();
            $this->response([
                'status' => True,
                'message' => $data,
            ], REST_Controller::HTTP_OK);
        }
    }
    // function: impact_assessment_review_post()
    // It is used to impact assessment review
    public function impact_assessment_review_post(){
        if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $data=array();
            $this->form_validation->set_rules('batch_name', 'Batch', 'required', array('required' => 'Please Select Batch'));
            $impact_assessment = $this->ReviewModel->getRequiredFieldList('impact_on_character_traits_form');
            if($impact_assessment){
                foreach($impact_assessment as $r){
                    if($r->field_type=='dropdown' || $r->field_type=='date' || $r->field_type=='radio' || $r->field_type=='checkbox'){
                        $required_valid_msg='Please Select '.$r->field_label; 
                    }else{
                        $required_valid_msg=$r->field_label.' is required'; 
                    }
                    if($r->field_type!='file'){
                        if($r->special_feature=='multiple select2'){
                            $this->form_validation->set_rules($r->field_name.'[]', $r->field_label, 'required', array('required' => $required_valid_msg));
                        }else{
                            $this->form_validation->set_rules($r->field_name, $r->field_label, 'required', array('required' => $required_valid_msg));
                        }
                    }
                }
            }
            if($this->form_validation->run() == FALSE){
                $data = $this->form_validation->error_array();
                $this->response([
                    'status' => False,
                    'message' => $data,
                ], REST_Controller::HTTP_OK);
            }else{
                $result=$this->ReviewModel->addImpactAssessmentReview();
                if(isset($result['success']) && $result['success']==1){
                    $data["success_message"] = "Impact Assessment Review added successfully.";
                    $this->response([
                        'status' => True,
                        'message' => $data,
                    ], REST_Controller::HTTP_OK);
                }else if(isset($result['error']) && $result['error']){
                    $data["error_message"] = $result['error'];
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
}
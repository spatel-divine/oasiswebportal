<?php 
class ReviewreportModel extends CI_Model{
    public function __construct() {
        parent::__construct();
   	}
    // function: getReviewList()
    // It is used to review list from database
    public function getReviewList(){
        $query=$this->db->query("(SELECT 'Program Feedback Review' as 'name_of_review', 'program_feedback_review' as 'tablename', count(*) as no_of_reviews FROM program_feedback_review WHERE is_active=1 AND deleted_at IS NULL) 
            UNION (SELECT 'Personal Learning Review' as 'name_of_review', 'personal_learning_review' as 'tablename', count(*) as no_of_reviews FROM personal_learning_review WHERE is_active=1 AND deleted_at IS NULL)
            UNION (SELECT 'Feedback For Participants Review' as 'name_of_review', 'feedback_for_participants_review' as 'tablename', count(*) as no_of_reviews FROM feedback_for_participants_review WHERE is_active=1 AND deleted_at IS NULL)
            UNION (SELECT 'Program Feedback By Participants Review' as 'name_of_review', 'program_feedback_by_participants_review' as 'tablename', count(*) as no_of_reviews FROM program_feedback_by_participants_review WHERE is_active=1 AND deleted_at IS NULL)
            UNION (SELECT 'Star Participant Review' as 'name_of_review', 'star_participant_review' as 'tablename', count(*) as no_of_reviews FROM star_participant_review WHERE is_active=1 AND deleted_at IS NULL)
            UNION (SELECT 'Impact On Character Traits Review' as 'name_of_review', 'impact_on_character_traits_review' as 'tablename', count(*) as no_of_reviews FROM impact_on_character_traits_review WHERE is_active=1 AND deleted_at IS NULL)");
        if($query->num_rows()>0){
            return $query->result();
        }
    }

    // function: getReviewSummaryReportByFilter()
    // It is used to fetch review summary report list by filter(program, session, start date or end date) from database
    public function getReviewSummaryReportByFilter(){
        $tablename=$this->input->post('tablename');
        $program_name=$this->input->post('program_name');
        $session_id=$this->input->post('session_id');
        $start_date='';
        if(isset($_POST['start_date']) && $_POST['start_date']){
            $start_date=date('Y-m-d',strtotime($this->input->post('start_date')));
        }
        $end_date='';
        if(isset($_POST['end_date']) && $_POST['end_date']){
            $end_date=date('Y-m-d',strtotime($this->input->post('end_date')));
        }
        $condition='';
        if($session_id){
            $condition.=" AND JSON_UNQUOTE(JSON_EXTRACT(t.reviews,'$.session'))='".$session_id."' ";
        }else if($program_name){
            $condition.=" AND JSON_UNQUOTE(JSON_EXTRACT(t.reviews,'$.program_name'))='".$program_name."' ";
        }
        if($start_date && $end_date){
            $condition.=" AND (date_format(date(t.created_at),'%Y-%m-%d')>='".$start_date."' AND date_format(date(t.created_at),'%Y-%m-%d')<='".$end_date."') ";
        }else if($start_date){
            $condition.=" AND date_format(date(t.created_at),'%Y-%m-%d')='".$start_date."' ";
        }else if($end_date){
            $condition.=" AND date_format(date(t.created_at),'%Y-%m-%d')='".$end_date."' ";
        }
        $query=$this->db->query("SELECT TO_BASE64(t.id) as id, JSON_UNQUOTE(JSON_EXTRACT(t.reviews,'$.program_name')) as program_name, b.batch_name, s.session_name, t.created_at FROM ".$tablename." t LEFT JOIN batch_master b ON JSON_UNQUOTE(JSON_EXTRACT(t.reviews,'$.batch_name'))=b.id LEFT JOIN sessionmanagement s ON JSON_UNQUOTE(JSON_EXTRACT(t.reviews,'$.session'))=s.id WHERE t.is_active=1 AND t.deleted_at IS NULL ".$condition);
        if($query->num_rows()>0){
            return $query->result();
        }
        return false;
    }

    // function: review_summary_details($tablename,$id)
    // It is used to fetch review summary details by tablename and id
    public function getReviewDetails($tablename,$id){
        $id=base64_decode($id);
        //$query=$this->db->query("SELECT t.id, t.reviews, b.batch_name, s.session_name, ut.user_type, t.created_at FROM ".$tablename." t LEFT JOIN batch_master b ON JSON_UNQUOTE(JSON_EXTRACT(t.reviews,'$.batch_name'))=b.id LEFT JOIN sessionmanagement s ON JSON_UNQUOTE(JSON_EXTRACT(t.reviews,'$.session'))=s.id LEFT JOIN user_types ut ON JSON_UNQUOTE(JSON_EXTRACT(t.reviews,'$.user_type'))=ut.id WHERE t.id=".$id);
        $query=$this->db->query("SELECT t.id, t.reviews, t.created_at FROM ".$tablename." t  WHERE t.id=".$id);
        if($query->num_rows()>0){
            return $query->row();
        }
    } 

    // function: getReviewFilesDetails($tablename,$id)
    // It is used to fetch review files details by tablename and id
    public function getReviewFilesDetails($tablename,$id){
        $id=base64_decode($id);
        $tablename=$tablename.'_upload_file';
        $query=$this->db->query("SELECT * FROM ".$tablename." t  WHERE t.review_id=".$id);
        if($query->num_rows()>0){
            return $query->result();
        }
    }
}
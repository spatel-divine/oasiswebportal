<?php 
class DashboardModel extends CI_Model{
    public function __construct() {
        parent::__construct();
   	}
	// function: getProgramOverviewByFilter()
    // It is used to fetch program overview list by filter(state,region,center,year) from database
    public function getProgramOverviewByFilter(){
    	$center_id=$this->input->post('center_id');
    	$state_id=$this->input->post('state_id');
        $region_id=$this->input->post('region_id');
        $year=$this->input->post('year');
        $condition='';
        $condition1='';
        if($center_id){
            $condition.=" AND center_id='".$center_id."' ";
            $condition1.=" AND b.center_id='".$center_id."' ";
        }else if($region_id){
            $condition.=" AND region_id='".$region_id."' ";
            $condition1.=" AND b.region_id='".$region_id."' ";
        }else if($state_id){
            $condition.=" AND state_id='".$state_id."' ";
            $condition1.=" AND b.state_id='".$state_id."' ";
        }
        if($year){
        	$yearc=" AND (YEAR(start_date)='".$year."' ) ";
            $yearc1=" AND (YEAR(b.start_date)='".$year."' ) ";
        }else{
        	$yearc=" AND (YEAR(start_date)='".date('Y')."' ) ";
            $yearc1=" AND (YEAR(b.start_date)='".date('Y')."' ) ";
        }
        $tilldatecondition=" AND start_date<='".date('Y-m-d')."' ";
        $tilldatecondition1=" AND b.start_date<='".date('Y-m-d')."' ";
        $children_youth_ids=str_replace(',',"','",GROUP_CHILDREN_YOUTH_IDS);
        $adult_ids=str_replace(',',"','",GROUP_ADULT_IDS);
        $query=$this->db->query("SELECT pm.id, pm.program_name, bm.total_batch, bpm.total_participant, bmy.total_batch_by_year, bpmy.total_participant_by_year, bpmcy.total_participant_by_children_youth, bpma.total_participant_by_adult FROM program_master pm LEFT JOIN (SELECT id, program_id, count(*) as total_batch FROM batch_master WHERE deleted_at IS NULL ".$condition.$tilldatecondition." GROUP BY  program_id) bm ON pm.id=bm.program_id LEFT JOIN (SELECT program_id, count(*) as total_participant FROM (SELECT DISTINCT(bp.user_id), b.program_id FROM batch_participant bp INNER JOIN batch_master b ON bp.batch_id=b.id AND b.deleted_at IS NULL ".$condition1.$tilldatecondition1." WHERE bp.deleted_at IS NULL) a GROUP BY program_id) bpm ON pm.id=bpm.program_id LEFT JOIN (SELECT id, program_id, count(*) as total_batch_by_year FROM batch_master WHERE deleted_at IS NULL ".$condition.$yearc." GROUP BY  program_id) bmy ON pm.id=bmy.program_id LEFT JOIN (SELECT program_id, count(*) as total_participant_by_year FROM (SELECT DISTINCT(bp.user_id), b.program_id FROM batch_participant bp INNER JOIN batch_master b ON bp.batch_id=b.id AND b.deleted_at IS NULL ".$condition1.$yearc1." WHERE bp.deleted_at IS NULL) a GROUP BY program_id) bpmy ON pm.id=bpmy.program_id LEFT JOIN (SELECT program_id, count(*) as total_participant_by_children_youth FROM (SELECT DISTINCT(bp.user_id), b.program_id FROM batch_participant bp INNER JOIN batch_master b ON bp.batch_id=b.id AND b.deleted_at IS NULL AND b.group_id IN('".$children_youth_ids."') ".$condition1.$yearc1." WHERE bp.deleted_at IS NULL) a GROUP BY program_id) bpmcy ON pm.id=bpmcy.program_id  LEFT JOIN (SELECT program_id, count(*) as total_participant_by_adult FROM (SELECT DISTINCT(bp.user_id), b.program_id FROM batch_participant bp INNER JOIN batch_master b ON bp.batch_id=b.id AND b.deleted_at IS NULL AND b.group_id IN('".$adult_ids."') ".$condition1.$yearc1." WHERE bp.deleted_at IS NULL) a GROUP BY program_id) bpma ON pm.id=bpma.program_id WHERE pm.is_active=1 AND pm.deleted_at IS NULL GROUP BY pm.id");
        // echo $this->db->last_query();die();
        if($query->num_rows()>0){
            return $query->result();
        }
    }
    // function: getMonitoringProjectProgramByFilter()
    // It is used to fetch Monitoring Project Program list by filter(state,region,center) from database
    public function getMonitoringProjectProgramByFilter(){
        $center_id=$this->input->post('center_id');
        $state_id=$this->input->post('state_id');
        $region_id=$this->input->post('region_id');
        $condition='';
        if($center_id){
            $condition.=" AND yg.center_id='".$center_id."' ";
        }else if($region_id){
            $condition.=" AND yg.center_id IN(SELECT  id FROM center_master WHERE region_id='".$region_id."' AND is_active=1 AND deleted_at IS NULL) ";
        }else if($state_id){
            $condition.=" AND yg.center_id IN(SELECT  id FROM center_master WHERE state_id='".$state_id."' AND is_active=1 AND deleted_at IS NULL) ";
        }
        $condition1='';
        if($center_id){
            $condition1.=" AND center_id='".$center_id."' ";
        }else if($region_id){
            $condition1.=" AND region_id='".$region_id."' ";
        }else if($state_id){
            $condition1.=" AND state_id='".$state_id."' ";
        }
        $year=date('Y');
        $yg_year=" AND (YEAR(yg.created_at)='".$year."' OR YEAR(yg.updated_at)='".$year."') ";
        $bm_yearc=" AND (YEAR(start_date)='".$year."' ) ";
        $query=$this->db->query("SELECT pm.id, pm.program_name, yg.no_of_programs, bm.total_completed_program, (yg.no_of_programs-IFNULL(bm.total_completed_program,0)) as pending_program, CONCAT(ROUND(((100*IFNULL(bm.total_completed_program,0))/yg.no_of_programs),2), '%') as achievement FROM program_master pm LEFT JOIN yearly_goals yg ON pm.id=yg.program_id AND yg.is_active=1 AND yg.deleted_at IS NULL ".$condition. $yg_year." LEFT JOIN (SELECT id, program_id, count(*) as total_completed_program FROM batch_master WHERE start_date IS NOT NULL AND end_date IS NOT NULL AND deleted_at IS NULL ".$condition1.$bm_yearc." GROUP BY program_id) bm ON pm.id=bm.program_id WHERE pm.is_active=1 AND pm.deleted_at IS NULL GROUP BY pm.id");
        //echo $this->db->last_query();die();
        if($query->num_rows()>0){
            return $query->result();
        }
    }
    // function: getMonitoringLeadersTeamByFilter()
    // It is used to fetch Monitoring Leaders Team list by filter(state,region,center) from database
    public function getMonitoringLeadersTeamByFilter(){
        $center_id=$this->input->post('center_id');
        $state_id=$this->input->post('state_id');
        $region_id=$this->input->post('region_id');
        $condition="";
        $main_roles_ids=str_replace(',',"','",MAIN_ROLES_IDS);
        $user_condition=" WHERE bb.user_id IN (SELECT u.id FROM users u INNER JOIN roles r ON u.role_id=r.id AND r.is_active=1 AND r.deleted_at IS NULL AND r.id IN('".$main_roles_ids."') WHERE u.is_active=1 AND u.deleted_at IS NULL GROUP BY u.id)";
        if($center_id){
            $condition.=" AND b.center_id='".$center_id."' ";
            $user_condition="";
        }else if($region_id){
            $condition.=" AND b.region_id='".$region_id."' ";
        }else if($state_id){
            $condition.=" AND b.state_id='".$state_id."' ";
        }
        //$query=$this->db->query("SELECT u.id, CONCAT_WS(' ',u.first_name,u.last_name) as fullname, r.role_name, u.created_at as active_since, count(bfm.user_id) as bf_total, count(bcm.user_id) as bc_total, count(bcfm.user_id) as bcf_total, count(bpm.user_id) as bp_total, count(bvm.user_id) as bv_total FROM users u INNER JOIN roles r ON u.role_id=r.id AND r.is_active=1 AND r.deleted_at IS NULL AND r.id IN('".$main_roles_ids."') LEFT JOIN (SELECT bf.user_id FROM batch_facilitator bf INNER JOIN batch_master b ON bf.batch_id=b.id AND b.deleted_at IS NULL WHERE bf.deleted_at IS NULL) bfm ON u.id=bfm.user_id LEFT JOIN (SELECT bc.user_id FROM batch_coordinator bc INNER JOIN batch_master b ON bc.batch_id=b.id AND b.deleted_at IS NULL WHERE bc.deleted_at IS NULL) bcm ON u.id=bcm.user_id LEFT JOIN (SELECT bcf.user_id FROM batch_co_facilitator bcf INNER JOIN batch_master b ON bcf.batch_id=b.id AND b.deleted_at IS NULL WHERE bcf.deleted_at IS NULL) bcfm ON u.id=bcfm.user_id LEFT JOIN (SELECT bp.user_id FROM batch_participant bp INNER JOIN batch_master b ON bp.batch_id=b.id AND b.deleted_at IS NULL WHERE bp.deleted_at IS NULL) bpm ON u.id=bpm.user_id LEFT JOIN (SELECT bv.user_id FROM batch_volunteer bv INNER JOIN batch_master b ON bv.batch_id=b.id AND b.deleted_at IS NULL WHERE bv.deleted_at IS NULL) bvm ON u.id=bvm.user_id WHERE u.is_active=1 AND u.deleted_at IS NULL ".$condition." GROUP BY u.id");
        /* $subquery="SELECT u.id FROM users u INNER JOIN roles r ON u.role_id=r.id AND r.is_active=1 AND r.deleted_at IS NULL AND r.id IN('".$main_roles_ids."') WHERE u.is_active=1 AND u.deleted_at IS NULL ".$condition." GROUP BY u.id";
        $query=$this->db->query("SELECT user_id, SUM(total) AS total_program_attended, CONCAT_WS(' ',u.first_name,u.last_name) as fullname, u.created_at as active_since, r.role_name FROM (SELECT bp.user_id as 'user_id',count(bp.user_id) as total, 'participant' as title FROM batch_participant bp INNER JOIN batch_master bpm ON bp.batch_id=bpm.id AND bpm.deleted_at IS NULL AND bpm.end_date<='".date('Y-m-d')."' WHERE bp.user_id IN (".$subquery.") GROUP BY bp.user_id 
        UNION SELECT bc.user_id as 'user_id',count(bc.user_id) as total, 'coordinator' as title FROM batch_coordinator bc INNER JOIN batch_master bcm ON bc.batch_id=bcm.id AND bcm.deleted_at IS NULL  AND bcm.end_date<='".date('Y-m-d')."' WHERE bc.user_id IN (".$subquery.") GROUP BY bc.user_id
        UNION SELECT bcf.user_id as 'user_id',count(bcf.user_id) as total, 'co_facilitator' as title FROM batch_co_facilitator bcf INNER JOIN batch_master bcfm ON bcf.batch_id=bcfm.id AND bcfm.deleted_at IS NULL AND bcfm.end_date<='".date('Y-m-d')."' WHERE bcf.user_id IN (".$subquery.") GROUP BY bcf.user_id
        UNION SELECT bv.user_id as 'user_id',count(bv.user_id) as total, 'volunteer' as title FROM batch_volunteer bv INNER JOIN batch_master bvm ON bv.batch_id=bvm.id AND bvm.deleted_at IS NULL AND bvm.end_date<='".date('Y-m-d')."' WHERE bv.user_id IN (".$subquery.") GROUP BY bv.user_id
         UNION SELECT bf.user_id as 'user_id',count(bf.user_id) as total, 'facilitator' as title FROM batch_facilitator bf INNER JOIN batch_master bfm ON bf.batch_id=bfm.id AND bfm.deleted_at IS NULL AND bfm.end_date<='".date('Y-m-d')."' WHERE bf.user_id IN (".$subquery.") GROUP BY bf.user_id) a INNER JOIN users u ON a.user_id=u.id AND u.deleted_at IS NULL LEFT JOIN roles r ON u.role_id=r.id AND r.is_active=1 AND r.deleted_at IS NULL GROUP BY a.user_id"); */
        $query=$this->db->query("SELECT user_id, SUM(total) AS total_program_attended, CONCAT_WS(' ',u.first_name,u.last_name) as fullname, u.created_at as active_since, r.role_name FROM 
            (SELECT bb.user_id as 'user_id',count(bb.user_id) as total, 'participant' as title FROM batch_participant bb INNER JOIN batch_master b ON bb.batch_id=b.id AND b.deleted_at IS NULL ".$condition." AND b.end_date<='".date('Y-m-d')."' ".$user_condition." GROUP BY bb.user_id 
            UNION SELECT bb.user_id as 'user_id',count(bb.user_id) as total, 'coordinator' as title FROM batch_coordinator bb INNER JOIN batch_master b ON bb.batch_id=b.id AND b.deleted_at IS NULL ".$condition." AND b.end_date<='".date('Y-m-d')."' ".$user_condition." GROUP BY bb.user_id
            UNION SELECT bb.user_id as 'user_id',count(bb.user_id) as total, 'co_facilitator' as title FROM batch_co_facilitator bb INNER JOIN batch_master b ON bb.batch_id=b.id AND b.deleted_at IS NULL ".$condition." AND b.end_date<='".date('Y-m-d')."' ".$user_condition." GROUP BY bb.user_id
            UNION SELECT bb.user_id as 'user_id',count(bb.user_id) as total, 'volunteer' as title FROM batch_volunteer bb INNER JOIN batch_master b ON bb.batch_id=b.id AND b.deleted_at IS NULL ".$condition." AND b.end_date<='".date('Y-m-d')."' ".$user_condition." GROUP BY bb.user_id
             UNION SELECT bb.user_id as 'user_id',count(bb.user_id) as total, 'facilitator' as title FROM batch_facilitator bb INNER JOIN batch_master b ON bb.batch_id=b.id AND b.deleted_at IS NULL ".$condition." AND b.end_date<='".date('Y-m-d')."' ".$user_condition." GROUP BY bb.user_id) a INNER JOIN users u ON a.user_id=u.id AND u.deleted_at IS NULL LEFT JOIN roles r ON u.role_id=r.id AND r.is_active=1 AND r.deleted_at IS NULL GROUP BY a.user_id");
        //echo $this->db->last_query();die();
        if($query->num_rows()>0){
            return $query->result();
        }
    }
    // function: getBatchListByUserId($user_id)
    // It is used to get batch list by user id from database
    public function getBatchListByUserId($user_id){
        $center_id=$this->input->post('center_id');
        $state_id=$this->input->post('state_id');
        $region_id=$this->input->post('region_id');
        $condition="";
        if($center_id){
            $condition.=" AND bm.center_id='".$center_id."' ";
        }else if($region_id){
            $condition.=" AND bm.region_id='".$region_id."' ";
        }else if($state_id){
            $condition.=" AND bm.state_id='".$state_id."' ";
        }
        $query=$this->db->query("(SELECT b.batch_id,bm.batch_name, pm.program_name, bm.location, bm.start_date, bm.end_date FROM batch_participant b INNER JOIN batch_master bm ON bm.id=b.batch_id AND bm.deleted_at IS NULL ".$condition." AND bm.end_date<='".date('Y-m-d')."' LEFT JOIN program_master pm ON bm.program_id=pm.id AND pm.deleted_at IS NULL AND pm.is_active=1 WHERE b.user_id='".$user_id."' AND b.deleted_at IS NULL)
            UNION ALL(SELECT b.batch_id,bm.batch_name, pm.program_name, bm.location, bm.start_date, bm.end_date FROM batch_coordinator b INNER JOIN batch_master bm ON bm.id=b.batch_id AND bm.deleted_at IS NULL ".$condition." AND bm.end_date<='".date('Y-m-d')."' LEFT JOIN program_master pm ON bm.program_id=pm.id AND pm.deleted_at IS NULL AND pm.is_active=1 WHERE b.user_id='".$user_id."' AND b.deleted_at IS NULL)
            UNION ALL(SELECT b.batch_id,bm.batch_name, pm.program_name, bm.location, bm.start_date, bm.end_date FROM batch_facilitator b INNER JOIN batch_master bm ON bm.id=b.batch_id AND bm.deleted_at IS NULL ".$condition." AND bm.end_date<='".date('Y-m-d')."' LEFT JOIN program_master pm ON bm.program_id=pm.id AND pm.deleted_at IS NULL AND pm.is_active=1 WHERE b.user_id='".$user_id."' AND b.deleted_at IS NULL)
            UNION ALL(SELECT b.batch_id,bm.batch_name, pm.program_name, bm.location, bm.start_date, bm.end_date FROM batch_co_facilitator b INNER JOIN batch_master bm ON bm.id=b.batch_id AND bm.deleted_at IS NULL ".$condition." AND bm.end_date<='".date('Y-m-d')."' LEFT JOIN program_master pm ON bm.program_id=pm.id AND pm.deleted_at IS NULL AND pm.is_active=1 WHERE b.user_id='".$user_id."' AND b.deleted_at IS NULL)
            UNION ALL(SELECT b.batch_id,bm.batch_name, pm.program_name, bm.location, bm.start_date, bm.end_date FROM batch_volunteer b INNER JOIN batch_master bm ON bm.id=b.batch_id AND bm.deleted_at IS NULL ".$condition." AND bm.end_date<='".date('Y-m-d')."' LEFT JOIN program_master pm ON bm.program_id=pm.id AND pm.deleted_at IS NULL AND pm.is_active=1 WHERE b.user_id='".$user_id."' AND b.deleted_at IS NULL)");
        //echo $this->db->last_query();die();
        if($query->num_rows()>0){
            return $query->result();
        }
    }
    // function: getMonitoringFacilitatorsByFilter()
    // It is used to fetch Monitoring Facilitators list by filter(state,region,center) from database
    public function getMonitoringFacilitatorsByFilter(){
        $center_id=$this->input->post('center_id');
        $state_id=$this->input->post('state_id');
        $region_id=$this->input->post('region_id');
        $condition='';
        $condition1='';
        if($center_id){
            $condition.=" AND center_id='".$center_id."' ";
            $condition1.=" AND b.center_id='".$center_id."' ";
        }else if($region_id){
            $condition.=" AND region_id='".$region_id."' ";
            $condition1.=" AND b.region_id='".$region_id."' ";
        }else if($state_id){
            $condition.=" AND state_id='".$state_id."' ";
            $condition1.=" AND b.state_id='".$state_id."' ";
        }
        $yearc=" AND YEAR(start_date)='".date('Y')."' AND YEAR(end_date)='".date('Y')."' ";
        $yearc1=" AND YEAR(b.start_date)='".date('Y')."' AND YEAR(b.end_date)='".date('Y')."' ";
        $ygyearc=" AND (YEAR(yg.created_at)='".date('Y')."' OR YEAR(yg.updated_at)='".date('Y')."') ";
        $ygcondition='';
        if($center_id){
            $ygcondition.=" AND yg.center_id='".$center_id."' ";
        }else if($region_id){
            $ygcondition.=" AND yg.center_id IN(SELECT id FROM center_master WHERE region_id='".$region_id."' AND is_active=1 AND deleted_at IS NULL) ";
        }else if($state_id){
            $ygcondition.=" AND yg.center_id IN(SELECT id FROM center_master WHERE state_id='".$state_id."' AND is_active=1 AND deleted_at IS NULL) ";
        }
        $query=$this->db->query("SELECT pm.id, pm.program_name, bm.training_given, bfm.total_active_facilitator, bfm.active_facilitator_list, yg.no_of_facilitators, r.learners, CONCAT(ROUND(((100*IFNULL(bfm.total_active_facilitator,0))/yg.no_of_facilitators),2), '%') as achievement FROM program_master pm LEFT JOIN (SELECT id, program_id, COUNT(*) AS training_given FROM batch_master WHERE deleted_at IS NULL ".$condition.$yearc." GROUP BY program_id) bm ON pm.id=bm.program_id LEFT JOIN (SELECT program_id, count(*) as total_active_facilitator, group_concat(DISTINCT(user_id) separator \"','\") as active_facilitator_list FROM (SELECT DISTINCT(bf.user_id), b.program_id FROM batch_facilitator bf INNER JOIN batch_master b ON bf.batch_id=b.id AND b.deleted_at IS NULL ".$condition1.$yearc1." WHERE bf.deleted_at IS NULL) a GROUP BY program_id) bfm ON pm.id=bfm.program_id LEFT JOIN yearly_goals yg ON pm.id=yg.program_id ".$ygyearc.$ygcondition." LEFT JOIN (SELECT JSON_UNQUOTE(JSON_EXTRACT(reviews,'$.batch_name')) AS batch_id, COUNT(*) AS learners FROM feedback_for_participants_review WHERE YEAR(created_at)='".date('Y')."' AND JSON_UNQUOTE(JSON_EXTRACT(reviews,'$.user_type'))=".USER_TYPE_IDS_FOR_F." AND is_active=1 AND deleted_at IS NULL GROUP BY JSON_UNQUOTE(JSON_EXTRACT(reviews,'$.batch_name'))) r ON bm.id=r.batch_id WHERE pm.is_active=1 AND pm.deleted_at IS NULL GROUP BY pm.id");
        if($query->num_rows()>0){
            return $query->result();
        }
    }
    // function: getTotalInactiveFacilitators($active_facilitator_list)
    // It is used to fetch user by user id from database
    public function getTotalInactiveFacilitators($active_facilitator_list){
        $query=$this->db->query("SELECT * FROM users WHERE id NOT IN('".$active_facilitator_list."') AND is_active=1 AND deleted_at IS NULL");
        if($query->num_rows()>0){
            return $query->num_rows();
        }
    }
    // function: getActiveUserByIds($user_ids)
    // It is used to fetch active user by user ids from database
    public function getActiveUserByIds($user_ids){
        $query=$this->db->query("SELECT CONCAT_WS(' ',u.first_name,u.last_name) as fullname, u.gender, TIMESTAMPDIFF(YEAR, u.birth_date, CURDATE()) AS age, s.state_name, r.region_name, cm.center_name, YEAR(u.created_at) as active_since FROM users u LEFT JOIN states s ON u.state_id=s.id AND s.is_active=1 AND s.deleted_at IS NULL LEFT JOIN user_centers uc ON u.id=uc.user_id AND uc.is_active AND uc.deleted_at IS NULL LEFT JOIN regions r ON uc.region_id=r.id AND r.is_active=1 AND r.deleted_at IS NULL LEFT JOIN center_master cm ON uc.region_id=cm.id AND cm.is_active=1 AND cm.deleted_at IS NULL WHERE u.id IN('".str_replace(",","','",$user_ids)."') AND u.is_active=1 AND u.deleted_at IS NULL");
        if($query->num_rows()>0){
            return $query->result();
        }
    }
    // function: getInactiveUserByIds($user_ids)
    // It is used to fetch inactive user by user ids from database
    public function getInactiveUserByIds($user_ids){
        $query=$this->db->query("SELECT CONCAT_WS(' ',u.first_name,u.last_name) as fullname, u.gender, TIMESTAMPDIFF(YEAR, u.birth_date, CURDATE()) AS age, s.state_name, r.region_name, cm.center_name, YEAR(u.created_at) as active_since FROM users u LEFT JOIN states s ON u.state_id=s.id AND s.is_active=1 AND s.deleted_at IS NULL LEFT JOIN user_centers uc ON u.id=uc.user_id AND uc.is_active AND uc.deleted_at IS NULL LEFT JOIN regions r ON uc.region_id=r.id AND r.is_active=1 AND r.deleted_at IS NULL LEFT JOIN center_master cm ON uc.region_id=cm.id AND cm.is_active=1 AND cm.deleted_at IS NULL WHERE u.id NOT IN('".str_replace(",","','",$user_ids)."') AND u.is_active=1 AND u.deleted_at IS NULL");
        if($query->num_rows()>0){
            return $query->result();
        }
    }
}
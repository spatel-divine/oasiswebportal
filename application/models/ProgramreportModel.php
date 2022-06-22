<?php 
class ProgramreportModel extends CI_Model{
    public function __construct() {
        parent::__construct();
   	}
   	// function: getProgramSummaryReportByFilter()
    // It is used to fetch program summary report list by filter(state,region,center,start date or end date) from database
    public function getProgramSummaryReportByFilter(){
    	$center_id=$this->input->post('center_id');
    	$state_id=$this->input->post('state_id');
        $region_id=$this->input->post('region_id');
        $start_date='';
        if(isset($_POST['start_date']) && $_POST['start_date']){
        	$start_date=date('Y-m-d',strtotime($this->input->post('start_date')));
        }
        $end_date='';
        if(isset($_POST['end_date']) && $_POST['end_date']){
        	$end_date=date('Y-m-d',strtotime($this->input->post('end_date')));
        }
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
        if($start_date && $end_date){
        	$condition.=" AND ( start_date>='".$start_date."' AND end_date<='".$end_date."') ";
        	$condition1.=" AND ( b.start_date>='".$start_date."' AND b.end_date<='".$end_date."') ";
        }else if($start_date){
        	$condition.=" AND start_date='".$start_date."' ";
        	$condition1.=" AND b.start_date='".$start_date."' ";
        }else if($end_date){
        	$condition.=" AND end_date='".$end_date."' ";
        	$condition1.=" AND b.end_date='".$end_date."' ";
        }
        /* $starparticipants_condition='';
        if($state_id){
            $starparticipants_condition.=" AND JSON_EXTRACT(reviews,'$.state')='".$state_id."' ";
        }
        $query=$this->db->query("SELECT pm.id, pm.program_name, bm.total_batch, bpm.total_participant, bfm.total_facilitator, bcfm.total_cofacilitator, bcm.total_coordinator, bvm.total_volunteer, spm.total_star_participant FROM program_master pm LEFT JOIN (SELECT id, program_id, count(*) as total_batch FROM batch_master WHERE deleted_at IS NULL ".$condition." GROUP BY  program_id) bm ON pm.id=bm.program_id LEFT JOIN (SELECT program_id, count(*) as total_participant FROM (SELECT DISTINCT(bp.user_id), b.program_id FROM batch_participant bp INNER JOIN batch_master b ON bp.batch_id=b.id AND b.deleted_at IS NULL ".$condition1." WHERE bp.deleted_at IS NULL) a GROUP BY program_id) bpm ON pm.id=bpm.program_id LEFT JOIN (SELECT program_id, count(*) as total_facilitator FROM (SELECT DISTINCT(bf.user_id), b.program_id FROM batch_facilitator bf INNER JOIN batch_master b ON bf.batch_id=b.id AND b.deleted_at IS NULL ".$condition1." WHERE bf.deleted_at IS NULL) a GROUP BY program_id) bfm ON pm.id=bfm.program_id LEFT JOIN (SELECT program_id, count(*) as total_cofacilitator FROM (SELECT DISTINCT(bcf.user_id), b.program_id FROM batch_co_facilitator bcf INNER JOIN batch_master b ON bcf.batch_id=b.id AND b.deleted_at IS NULL ".$condition1." WHERE bcf.deleted_at IS NULL) a GROUP BY program_id) bcfm ON pm.id=bcfm.program_id LEFT JOIN (SELECT program_id, count(*) as total_coordinator FROM (SELECT DISTINCT(bc.user_id), b.program_id FROM batch_coordinator bc INNER JOIN batch_master b ON bc.batch_id=b.id AND b.deleted_at IS NULL ".$condition1." WHERE bc.deleted_at IS NULL) a GROUP BY program_id) bcm ON pm.id=bcm.program_id LEFT JOIN (SELECT program_id, count(*) as total_volunteer FROM (SELECT DISTINCT(bv.user_id), b.program_id FROM batch_volunteer bv INNER JOIN batch_master b ON bv.batch_id=b.id AND b.deleted_at IS NULL ".$condition1." WHERE bv.deleted_at IS NULL) a GROUP BY program_id) bvm ON pm.id=bvm.program_id LEFT JOIN (SELECT JSON_UNQUOTE(JSON_EXTRACT(reviews,'$.program_name')) AS program_id, count(*) as total_star_participant FROM star_participant_review WHERE is_active=1 ".$starparticipants_condition." GROUP BY program_id) spm ON pm.id=spm.program_id WHERE pm.is_active=1 AND pm.deleted_at IS NULL GROUP BY pm.id"); */
        $query=$this->db->query("SELECT pm.id, pm.program_name, bm.total_batch, bpm.total_participant, bfm.total_facilitator, bcfm.total_cofacilitator, bcm.total_coordinator, bvm.total_volunteer, spm.total_star_participant FROM program_master pm LEFT JOIN (SELECT id, program_id, count(*) as total_batch FROM batch_master WHERE deleted_at IS NULL ".$condition." GROUP BY  program_id) bm ON pm.id=bm.program_id LEFT JOIN (SELECT program_id, count(*) as total_participant FROM (SELECT DISTINCT(bp.user_id), b.program_id FROM batch_participant bp INNER JOIN batch_master b ON bp.batch_id=b.id AND b.deleted_at IS NULL ".$condition1." WHERE bp.deleted_at IS NULL) a GROUP BY program_id) bpm ON pm.id=bpm.program_id LEFT JOIN (SELECT program_id, count(*) as total_facilitator FROM (SELECT DISTINCT(bf.user_id), b.program_id FROM batch_facilitator bf INNER JOIN batch_master b ON bf.batch_id=b.id AND b.deleted_at IS NULL ".$condition1." WHERE bf.deleted_at IS NULL) a GROUP BY program_id) bfm ON pm.id=bfm.program_id LEFT JOIN (SELECT program_id, count(*) as total_cofacilitator FROM (SELECT DISTINCT(bcf.user_id), b.program_id FROM batch_co_facilitator bcf INNER JOIN batch_master b ON bcf.batch_id=b.id AND b.deleted_at IS NULL ".$condition1." WHERE bcf.deleted_at IS NULL) a GROUP BY program_id) bcfm ON pm.id=bcfm.program_id LEFT JOIN (SELECT program_id, count(*) as total_coordinator FROM (SELECT DISTINCT(bc.user_id), b.program_id FROM batch_coordinator bc INNER JOIN batch_master b ON bc.batch_id=b.id AND b.deleted_at IS NULL ".$condition1." WHERE bc.deleted_at IS NULL) a GROUP BY program_id) bcm ON pm.id=bcm.program_id LEFT JOIN (SELECT program_id, count(*) as total_volunteer FROM (SELECT DISTINCT(bv.user_id), b.program_id FROM batch_volunteer bv INNER JOIN batch_master b ON bv.batch_id=b.id AND b.deleted_at IS NULL ".$condition1." WHERE bv.deleted_at IS NULL) a GROUP BY program_id) bvm ON pm.id=bvm.program_id LEFT JOIN (SELECT b.program_id AS program_id, count(*) as total_star_participant FROM star_participant_review sp INNER JOIN batch_master b ON JSON_UNQUOTE(JSON_EXTRACT(sp.reviews,'$.batch_name'))=b.id AND b.deleted_at IS NULL ".$condition1." WHERE sp.is_active=1 GROUP BY program_id) spm ON pm.id=spm.program_id WHERE pm.is_active=1 AND pm.deleted_at IS NULL GROUP BY pm.id");
        //echo $this->db->last_query();die();
        if($query->num_rows()>0){
            return $query->result();
        }
        return false;
    }
    // function: getStartParticipantsByProgramId($program_id)
    // It is used to fetch star participants detail by program id from database
    public function getStartParticipantsByProgramId($program_id){
        $center_id=$this->input->post('center_id');
        $state_id=$this->input->post('state_id');
        $region_id=$this->input->post('region_id');
        $start_date='';
        if(isset($_POST['start_date']) && $_POST['start_date']){
            $start_date=date('Y-m-d',strtotime($this->input->post('start_date')));
        }
        $end_date='';
        if(isset($_POST['end_date']) && $_POST['end_date']){
            $end_date=date('Y-m-d',strtotime($this->input->post('end_date')));
        }
        $condition="";
        if($center_id){
            $condition.=" AND b.center_id='".$center_id."' ";
            $user_condition="";
        }else if($region_id){
            $condition.=" AND b.region_id='".$region_id."' ";
        }else if($state_id){
            $condition.=" AND b.state_id='".$state_id."' ";
        }
        if($start_date && $end_date){
            $condition.=" AND ( b.start_date>='".$start_date."' AND b.end_date<='".$end_date."') ";
        }else if($start_date){
            $condition.=" AND b.start_date='".$start_date."' ";
        }else if($end_date){
            $condition.=" AND b.end_date='".$end_date."' ";
        }
    	$query=$this->db->query("SELECT JSON_UNQUOTE(JSON_EXTRACT(reviews,'$.first_name')) AS first_name, JSON_UNQUOTE(JSON_EXTRACT(reviews,'$.last_name')) AS last_name, JSON_UNQUOTE(JSON_EXTRACT(reviews,'$.date_of_birth')) AS date_of_birth, s.state_name, d.district_name, c.village_name, JSON_UNQUOTE(JSON_EXTRACT(reviews,'$.qualities_observed')) AS qualities_observed FROM star_participant_review sp LEFT JOIN states s ON JSON_UNQUOTE(JSON_EXTRACT(sp.reviews,'$.state'))=s.id LEFT JOIN districts d ON JSON_UNQUOTE(JSON_EXTRACT(sp.reviews,'$.district'))=d.id LEFT JOIN city_town_villages c ON JSON_UNQUOTE(JSON_EXTRACT(sp.reviews,'$.villageorcity'))=c.id INNER JOIN batch_master b ON JSON_UNQUOTE(JSON_EXTRACT(sp.reviews,'$.batch_name'))=b.id AND b.deleted_at IS NULL ".$condition." WHERE JSON_EXTRACT(reviews,'$.program_name') IN(SELECT program_name FROM program_master WHERE id='".$program_id."')");
        // echo $this->db->last_query();die();
    	if($query->num_rows()>0){
    		return $query->result();
    	}
    }
    // function: getQualitiesObservedByIds($qualities_observed_ids)
	// It is used to get qualities observed name list by qualities observed ids
	function getQualitiesObservedByIds($qualities_observed_ids){
	    //$qualities_observed_ids=str_replace(',',"','",$qualities_observed_ids);
        $qualities_observed_ids=str_replace('[','',$qualities_observed_ids);
        $qualities_observed_ids=str_replace(']','',$qualities_observed_ids);
        //print_r($qualities_observed_ids);
	    $query=$this->db->query("SELECT * FROM quality_data WHERE id IN (".$qualities_observed_ids.")");
        //echo $this->db->last_query();
	    $qualities_observed_name_list='';
	    if($query->num_rows()>0){
	        $result=$query->result();
	        foreach($result as $r){
	            if(isset($r->quality_name) && $r->quality_name){
	                if($qualities_observed_name_list){
	                    $qualities_observed_name_list.=', '; 
	                }
	                $qualities_observed_name_list.=$r->quality_name; 
	            }
	        }
	    }
	    return $qualities_observed_name_list;
	}
	// function: getBatchSummaryReportByProgramId($program_id)
	// It is used to get batch summary report list by program_id from database
	public function getBatchSummaryReportByProgramId($program_id){
		$query=$this->db->query("SELECT b.* FROM batch_master b WHERE b.deleted_at IS NULL AND b.program_id='".$program_id."'");
		if($query->num_rows()>0){
			return $query->result();
		}
	}
    // function: getUserSummaryReportByProgramId()
    // It is used to get user summary report list by program_id from database
    public function getUserSummaryReportByProgramId(){
        $tablename=$this->input->get('tablename');
        $program_id=base64_decode($this->input->get('id'));
        $center_id=$this->input->get('center_id');
        $state_id=$this->input->get('state_id');
        $region_id=$this->input->get('region_id');
        $start_date='';
        if(isset($_GET['start_date']) && $_GET['start_date']){
            $start_date=date('Y-m-d',strtotime($this->input->get('start_date')));
        }
        $end_date='';
        if(isset($_GET['end_date']) && $_GET['end_date']){
            $end_date=date('Y-m-d',strtotime($this->input->get('end_date')));
        }
        $condition="";
        if($center_id){
            $condition.=" AND b.center_id='".$center_id."' ";
            $user_condition="";
        }else if($region_id){
            $condition.=" AND b.region_id='".$region_id."' ";
        }else if($state_id){
            $condition.=" AND b.state_id='".$state_id."' ";
        }
        if($start_date && $end_date){
            $condition.=" AND ( b.start_date>='".$start_date."' AND b.end_date<='".$end_date."') ";
        }else if($start_date){
            $condition.=" AND b.start_date='".$start_date."' ";
        }else if($end_date){
            $condition.=" AND b.end_date='".$end_date."' ";
        }
        $usersummaryreport=array();
        $query=$this->db->query("SELECT tm.user_id, CONCAT_WS(' ',u.first_name,u.last_name) as fullname FROM program_master pm LEFT JOIN (SELECT DISTINCT(t.user_id) as user_id, b.program_id FROM ".$tablename." t INNER JOIN batch_master b ON t.batch_id=b.id AND b.deleted_at IS NULL ".$condition." WHERE t.deleted_at IS NULL) tm ON pm.id=tm.program_id LEFT JOIN users u ON tm.user_id=u.id WHERE pm.id='".$program_id."'");
        // echo $this->db->last_query();die();
        if($query->num_rows()>0){
            $i=0;
            $result=$query->result();
            foreach($result as $r){
                $query=$this->db->query("(SELECT 'participant' as 'title', b.user_id,count(*) as total_batch,count(DISTINCT(bm.program_id)) as total_program FROM batch_participant b LEFT JOIN batch_master bm ON bm.id=b.batch_id AND bm.deleted_at IS NULL WHERE b.user_id='".$r->user_id."' AND b.deleted_at IS NULL group by b.user_id) 
                    UNION (SELECT 'co_facilitator' as 'title', b.user_id,count(*) as total_batch,count(DISTINCT(bm.program_id)) as total_program FROM batch_co_facilitator b LEFT JOIN batch_master bm ON bm.id=b.batch_id AND bm.deleted_at IS NULL WHERE b.user_id='".$r->user_id."' AND b.deleted_at IS NULL group by b.user_id)
                    UNION (SELECT 'coordinator' as 'title', b.user_id,count(*) as total_batch,count(DISTINCT(bm.program_id)) as total_program FROM batch_coordinator b LEFT JOIN batch_master bm ON bm.id=b.batch_id AND bm.deleted_at IS NULL WHERE b.user_id='".$r->user_id."' AND b.deleted_at IS NULL group by b.user_id)
                    UNION (SELECT 'facilitator' as 'title', b.user_id,count(*) as total_batch,count(DISTINCT(bm.program_id)) as total_program FROM batch_facilitator b LEFT JOIN batch_master bm ON bm.id=b.batch_id AND bm.deleted_at IS NULL WHERE b.user_id='".$r->user_id."' AND b.deleted_at IS NULL group by b.user_id)
                    UNION (SELECT 'volunteer' as 'title', b.user_id,count(*) as total_batch,count(DISTINCT(bm.program_id)) as total_program FROM batch_volunteer b LEFT JOIN batch_master bm ON bm.id=b.batch_id AND bm.deleted_at IS NULL WHERE b.user_id='".$r->user_id."' AND b.deleted_at IS NULL group by b.user_id)");
                if($query->num_rows()>0){
                    $result1=$query->result();
                    $total_batch=0;
                    $total_program=0;
                    $participant='';
                    $co_facilitator='';
                    $coordinator='';
                    $facilitator='';
                    $volunteer='';
                    foreach($result1 as $r1){
                        $total_batch+=$r1->total_batch;
                        $total_program+=$r1->total_program;
                        if(isset($r1->title) && $r1->title=='participant'){
                            $participant=$r1->total_batch;
                        }else if(isset($r1->title) && $r1->title=='co_facilitator'){
                            $co_facilitator=$r1->total_batch;
                        }else if(isset($r1->title) && $r1->title=='coordinator'){
                            $coordinator=$r1->total_batch;
                        }else if(isset($r1->title) && $r1->title=='facilitator'){
                            $facilitator=$r1->total_batch;
                        }else if(isset($r1->title) && $r1->title=='volunteer'){
                            $volunteer=$r1->total_batch;
                        }
                    }
                    $usersummaryreport[$i]['user_id']=$r->user_id;
                    $usersummaryreport[$i]['fullname']=$r->fullname;
                    $usersummaryreport[$i]['total_batch']=$total_batch;
                    $usersummaryreport[$i]['total_program']=$total_program;
                    $usersummaryreport[$i]['participant']=$participant;
                    $usersummaryreport[$i]['co_facilitator']=$co_facilitator;
                    $usersummaryreport[$i]['coordinator']=$coordinator;
                    $usersummaryreport[$i]['facilitator']=$facilitator;
                    $usersummaryreport[$i]['volunteer']=$volunteer;
                    $i++;
                }
            }
        }
        //print_r($usersummaryreport);die();
        return $usersummaryreport;
    }
    // function: getBatchListByUserId($user_id)
    // It is used to get batch list by user id from database
    public function getBatchListByUserId($user_id){
        $query=$this->db->query("(SELECT b.batch_id,bm.batch_name, pm.program_name, bm.location, bm.start_date, bm.end_date FROM batch_participant b INNER JOIN batch_master bm ON bm.id=b.batch_id AND bm.deleted_at IS NULL LEFT JOIN program_master pm ON bm.program_id=pm.id AND pm.deleted_at IS NULL AND pm.is_active=1 WHERE b.user_id='".$user_id."' AND b.deleted_at IS NULL)
            UNION ALL(SELECT b.batch_id,bm.batch_name, pm.program_name, bm.location, bm.start_date, bm.end_date FROM batch_coordinator b INNER JOIN batch_master bm ON bm.id=b.batch_id AND bm.deleted_at IS NULL LEFT JOIN program_master pm ON bm.program_id=pm.id AND pm.deleted_at IS NULL AND pm.is_active=1 WHERE b.user_id='".$user_id."' AND b.deleted_at IS NULL)
            UNION ALL(SELECT b.batch_id,bm.batch_name, pm.program_name, bm.location, bm.start_date, bm.end_date FROM batch_facilitator b INNER JOIN batch_master bm ON bm.id=b.batch_id AND bm.deleted_at IS NULL LEFT JOIN program_master pm ON bm.program_id=pm.id AND pm.deleted_at IS NULL AND pm.is_active=1 WHERE b.user_id='".$user_id."' AND b.deleted_at IS NULL)
            UNION ALL(SELECT b.batch_id,bm.batch_name, pm.program_name, bm.location, bm.start_date, bm.end_date FROM batch_co_facilitator b INNER JOIN batch_master bm ON bm.id=b.batch_id AND bm.deleted_at IS NULL LEFT JOIN program_master pm ON bm.program_id=pm.id AND pm.deleted_at IS NULL AND pm.is_active=1 WHERE b.user_id='".$user_id."' AND b.deleted_at IS NULL)
            UNION ALL(SELECT b.batch_id,bm.batch_name, pm.program_name, bm.location, bm.start_date, bm.end_date FROM batch_volunteer b INNER JOIN batch_master bm ON bm.id=b.batch_id AND bm.deleted_at IS NULL LEFT JOIN program_master pm ON bm.program_id=pm.id AND pm.deleted_at IS NULL AND pm.is_active=1 WHERE b.user_id='".$user_id."' AND b.deleted_at IS NULL)");
        if($query->num_rows()>0){
            return $query->result();
        }
    }
    public function getUserTypeBatchListByUserId($tablename,$user_id){
        $query=$this->db->query("SELECT b.batch_id,bm.batch_name, pm.program_name, bm.location, bm.start_date, bm.end_date FROM ".$tablename." b LEFT JOIN batch_master bm ON bm.id=b.batch_id AND bm.deleted_at IS NULL LEFT JOIN program_master pm ON bm.program_id=pm.id AND pm.deleted_at IS NULL AND pm.is_active=1 WHERE b.user_id='".$user_id."' AND b.deleted_at IS NULL");
        if($query->num_rows()>0){
            return $query->result();
        }
    }
}
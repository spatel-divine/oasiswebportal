<?php 
class DashboardModel extends CI_Model{
    public function __construct() {
        parent::__construct();
   	}
   	// function: getTotalOmProgramsDetails()
    // It is used to get Program Details
   	public function getTotalOmProgramsDetails(){
   		$query=$this->db->query("SELECT pm.program_name, bm.total_program FROM program_master pm LEFT JOIN (SELECT id, program_id, count(*) as total_program FROM batch_master WHERE deleted_at IS NULL AND start_date<='".date('Y-m-d')."' GROUP BY  program_id) bm ON pm.id=bm.program_id WHERE pm.is_active=1 AND pm.deleted_at IS NULL GROUP BY pm.id");
        // echo $this->db->last_query();die();
        if($query->num_rows()>0){
            return $query->result();
        }
   	}
   	// function: getTotalOmPrograms()
    // It is used to get total Program
   	public function getTotalOmPrograms(){
   		$query=$this->db->query("SELECT count(*) AS totalomprograms FROM  batch_master bm WHERE bm.deleted_at IS NULL AND bm.start_date<='".date('Y-m-d')."'");
        // echo $this->db->last_query();die();
        if($query->num_rows()>0){
            $row=$query->row();
            return $row->totalomprograms;
        }
        return 0;
   	}
   	// function: getTotalOmBeneficiariesDetails()
    // It is used to get om beneficiaries details
   	public function getTotalOmBeneficiariesDetails(){
   		$query=$this->db->query("SELECT pm.program_name, bpm.total_participant FROM program_master pm LEFT JOIN (SELECT program_id, count(*) as total_participant FROM (SELECT DISTINCT(bp.user_id), b.program_id FROM batch_participant bp INNER JOIN batch_master b ON bp.batch_id=b.id AND b.deleted_at IS NULL AND b.start_date<='".date('Y-m-d')."' WHERE bp.deleted_at IS NULL) a GROUP BY program_id) bpm ON pm.id=bpm.program_id WHERE pm.is_active=1 AND pm.deleted_at IS NULL GROUP BY pm.id");
        // echo $this->db->last_query();die();
        if($query->num_rows()>0){
            return $query->result();
        }
   	}
   	// function: getTotalOmBeneficiaries()
    // It is used to get total beneficiaries
   	public function getTotalOmBeneficiaries(){
   		$query=$this->db->query("SELECT SUM(bpm.total_participant) as totalombeneficiaries FROM program_master pm LEFT JOIN (SELECT program_id, count(*) as total_participant FROM (SELECT DISTINCT(bp.user_id), b.program_id FROM batch_participant bp INNER JOIN batch_master b ON bp.batch_id=b.id AND b.deleted_at IS NULL AND b.start_date<='".date('Y-m-d')."' WHERE bp.deleted_at IS NULL) a GROUP BY program_id) bpm ON pm.id=bpm.program_id WHERE pm.is_active=1 AND pm.deleted_at IS NULL");
        if($query->num_rows()>0){
            $row=$query->row();
            return $row->totalombeneficiaries;
        }
        return 0;
   	}
   	// function: getProgramThisYearDetails()
    // It is used to get Program Details By This Year
   	public function getProgramThisYearDetails(){
   		$query=$this->db->query("SELECT pm.program_name, bmy.total_program_this_year FROM program_master pm LEFT JOIN (SELECT id, program_id, count(*) as total_program_this_year FROM batch_master WHERE deleted_at IS NULL AND (YEAR(start_date)='".date('Y')."') GROUP BY program_id) bmy ON pm.id=bmy.program_id WHERE pm.is_active=1 AND pm.deleted_at IS NULL GROUP BY pm.id");
        //echo $this->db->last_query();die();
        if($query->num_rows()>0){
            return $query->result();
        }
   	}
   	// function: getProgramThisYear()
    // It is used to get Program this year
   	public function getProgramThisYear(){
   		$query=$this->db->query("SELECT SUM(bmy.total_program_this_year) AS programthisyear FROM program_master pm LEFT JOIN (SELECT id, program_id, count(*) as total_program_this_year FROM batch_master WHERE deleted_at IS NULL AND (YEAR(start_date)='".date('Y')."') GROUP BY program_id) bmy ON pm.id=bmy.program_id WHERE pm.is_active=1 AND pm.deleted_at IS NULL");
   		//echo $this->db->last_query();die();
        if($query->num_rows()>0){
            $row=$query->row();
            return $row->programthisyear;
        }
        return 0;
   	}
   	// function: getTotalOmBeneficiariesThisYearDetails()
    // It is used to get om beneficiaries this year details 
   	public function getTotalOmBeneficiariesThisYearDetails(){
   		$query=$this->db->query("SELECT pm.program_name, bpmy.total_beneficiaries_this_year FROM program_master pm LEFT JOIN (SELECT program_id, count(*) as total_beneficiaries_this_year FROM (SELECT DISTINCT(bp.user_id), b.program_id FROM batch_participant bp INNER JOIN batch_master b ON bp.batch_id=b.id AND b.deleted_at IS NULL AND (YEAR(b.start_date)='".date('Y')."' )  WHERE bp.deleted_at IS NULL) a GROUP BY program_id) bpmy ON pm.id=bpmy.program_id  WHERE pm.is_active=1 AND pm.deleted_at IS NULL GROUP BY pm.id");
        //echo $this->db->last_query();die();
        if($query->num_rows()>0){
            return $query->result();
        }
   	}
   	// function: getTotalOmBeneficiariesThisYear()
    // It is used to get Program this year
   	public function getTotalOmBeneficiariesThisYear(){
   		$query=$this->db->query("SELECT SUM(bpmy.total_beneficiaries_this_year) as totalombeneficiariesthisyear FROM program_master pm LEFT JOIN (SELECT program_id, count(*) as total_beneficiaries_this_year FROM (SELECT DISTINCT(bp.user_id), b.program_id FROM batch_participant bp INNER JOIN batch_master b ON bp.batch_id=b.id AND b.deleted_at IS NULL AND (YEAR(b.start_date)='".date('Y')."' )  WHERE bp.deleted_at IS NULL) a GROUP BY program_id) bpmy ON pm.id=bpmy.program_id  WHERE pm.is_active=1 AND pm.deleted_at IS NULL");
   		// echo $this->db->last_query();die();
        if($query->num_rows()>0){
            $row=$query->row();
            return $row->totalombeneficiariesthisyear;
        }
        return 0;
   	}
   	// function: getTotalBeneficiariesChildrenYouthDetails()
    // It is used to get om beneficiaries Children and Youths this year details 
   	public function getTotalBeneficiariesChildrenYouthDetails(){
   		$children_youth_ids=str_replace(',',"','",GROUP_CHILDREN_YOUTH_IDS);
   		$query=$this->db->query("SELECT pm.program_name, bpmcy.total_participant_by_children_youth FROM program_master pm LEFT JOIN (SELECT program_id, count(*) as total_participant_by_children_youth FROM (SELECT DISTINCT(bp.user_id), b.program_id FROM batch_participant bp INNER JOIN batch_master b ON bp.batch_id=b.id AND b.deleted_at IS NULL AND b.group_id IN('".$children_youth_ids."') AND (YEAR(b.start_date)='".date('Y')."' ) WHERE bp.deleted_at IS NULL) a GROUP BY program_id) bpmcy ON pm.id=bpmcy.program_id WHERE pm.is_active=1 AND pm.deleted_at IS NULL GROUP BY pm.id");
        // echo $this->db->last_query();die();
        if($query->num_rows()>0){
            return $query->result();
        }
   	}
   	// function: getTotalBeneficiariesChildrenYouth()
    // It is used to get total beneficiaries children and youth this year
   	public function getTotalBeneficiariesChildrenYouth(){
   		$children_youth_ids=str_replace(',',"','",GROUP_CHILDREN_YOUTH_IDS);
   		$query=$this->db->query("SELECT SUM(bpmcy.total_participant_by_children_youth) as totalbeneficiarieschildrenyouth FROM program_master pm LEFT JOIN (SELECT program_id, count(*) as total_participant_by_children_youth FROM (SELECT DISTINCT(bp.user_id), b.program_id FROM batch_participant bp INNER JOIN batch_master b ON bp.batch_id=b.id AND b.deleted_at IS NULL AND b.group_id IN('".$children_youth_ids."') AND (YEAR(b.start_date)='".date('Y')."' ) WHERE bp.deleted_at IS NULL) a GROUP BY program_id) bpmcy ON pm.id=bpmcy.program_id WHERE pm.is_active=1 AND pm.deleted_at IS NULL");
   		// echo $this->db->last_query();die();
        if($query->num_rows()>0){
            $row=$query->row();
            return $row->totalbeneficiarieschildrenyouth;
        }
        return 0;
   	}
   	// function: getTotalBeneficiariesAdultsDetails()
    // It is used to get om beneficiaries Adults this year details 
   	public function getTotalBeneficiariesAdultsDetails(){
   		$adult_ids=str_replace(',',"','",GROUP_ADULT_IDS);
   		$query=$this->db->query("SELECT pm.program_name, bpma.total_participant_by_adult FROM program_master pm LEFT JOIN (SELECT program_id, count(*) as total_participant_by_adult FROM (SELECT DISTINCT(bp.user_id), b.program_id FROM batch_participant bp INNER JOIN batch_master b ON bp.batch_id=b.id AND b.deleted_at IS NULL AND b.group_id IN('".$adult_ids."') AND (YEAR(b.start_date)='".date('Y')."' ) WHERE bp.deleted_at IS NULL) a GROUP BY program_id) bpma ON pm.id=bpma.program_id WHERE pm.is_active=1 AND pm.deleted_at IS NULL GROUP BY pm.id");
        // echo $this->db->last_query();die();
        if($query->num_rows()>0){
            return $query->result();
        }
   	}
   	// function: getTotalBeneficiariesAdults()
    // It is used to get total beneficiaries adults this year
   	public function getTotalBeneficiariesAdults(){
   		$adult_ids=str_replace(',',"','",GROUP_ADULT_IDS);
   		$query=$this->db->query("SELECT SUM(bpma.total_participant_by_adult) as totalbeneficiariesadults FROM program_master pm LEFT JOIN (SELECT program_id, count(*) as total_participant_by_adult FROM (SELECT DISTINCT(bp.user_id), b.program_id FROM batch_participant bp INNER JOIN batch_master b ON bp.batch_id=b.id AND b.deleted_at IS NULL AND b.group_id IN('".$adult_ids."') AND (YEAR(b.start_date)='".date('Y')."' ) WHERE bp.deleted_at IS NULL) a GROUP BY program_id) bpma ON pm.id=bpma.program_id WHERE pm.is_active=1 AND pm.deleted_at IS NULL");
   		//echo $this->db->last_query();die();
        if($query->num_rows()>0){
            $row=$query->row();
            return $row->totalbeneficiariesadults;
        }
        return 0;
   	}
    // function: getOnGoingProgramDetails()
    // It is used to get on going programs details from database
    public function getOnGoingProgramDetails(){
      $query=$this->db->query("SELECT pm.program_name, bm.batch_name, CONCAT_WS(' ',EXTRACT(DAY FROM bm.start_date),DATE_FORMAT(bm.start_date, '%b')) as daymonth  FROM batch_master bm INNER JOIN program_master pm ON bm.program_id=pm.id AND pm.is_active=1 AND pm.deleted_at IS NULL WHERE bm.deleted_at IS NULL AND bm.start_date<='".date('Y-m-d')."' AND bm.end_date>'".date('Y-m-d')."'");
      //echo $this->db->last_query();die();
      if($query->num_rows()>0){
        return $query->result();
      }
    } 
    // function: getUpComingProgramDetails()
    // It is used to get up coming programs details from database
    public function getUpComingProgramDetails(){
      $query=$this->db->query("SELECT pm.program_name, bm.batch_name, DATE_FORMAT(bm.start_date, '%d/%m/%Y') as start_date,DATEDIFF(bm.start_date,NOW()) AS days FROM batch_master bm INNER JOIN program_master pm ON bm.program_id=pm.id AND pm.is_active=1 AND pm.deleted_at IS NULL WHERE bm.deleted_at IS NULL AND bm.start_date>'".date('Y-m-d')."'");
      //echo $this->db->last_query();die();
      if($query->num_rows()>0){
        return $query->result();
      }
    }
    // function: getJourneyWithOm($user_id)
    // It is used to get login user journey with OM
    public function getJourneyWithOm($user_id){
      $query=$this->db->query("(SELECT bm.batch_name, pm.program_name, bm.location, bm.start_date, bm.end_date FROM batch_participant b INNER JOIN batch_master bm ON bm.id=b.batch_id AND bm.deleted_at IS NULL LEFT JOIN program_master pm ON bm.program_id=pm.id AND pm.deleted_at IS NULL AND pm.is_active=1 WHERE b.user_id='".$user_id."' AND b.deleted_at IS NULL)
            UNION ALL(SELECT bm.batch_name, pm.program_name, bm.location, bm.start_date, bm.end_date FROM batch_coordinator b INNER JOIN batch_master bm ON bm.id=b.batch_id AND bm.deleted_at IS NULL LEFT JOIN program_master pm ON bm.program_id=pm.id AND pm.deleted_at IS NULL AND pm.is_active=1 WHERE b.user_id='".$user_id."' AND b.deleted_at IS NULL)
            UNION ALL(SELECT bm.batch_name, pm.program_name, bm.location, bm.start_date, bm.end_date FROM batch_facilitator b INNER JOIN batch_master bm ON bm.id=b.batch_id AND bm.deleted_at IS NULL LEFT JOIN program_master pm ON bm.program_id=pm.id AND pm.deleted_at IS NULL AND pm.is_active=1 WHERE b.user_id='".$user_id."' AND b.deleted_at IS NULL)
            UNION ALL(SELECT bm.batch_name, pm.program_name, bm.location, bm.start_date, bm.end_date FROM batch_co_facilitator b INNER JOIN batch_master bm ON bm.id=b.batch_id AND bm.deleted_at IS NULL LEFT JOIN program_master pm ON bm.program_id=pm.id AND pm.deleted_at IS NULL AND pm.is_active=1 WHERE b.user_id='".$user_id."' AND b.deleted_at IS NULL)
            UNION ALL(SELECT bm.batch_name, pm.program_name, bm.location, bm.start_date, bm.end_date FROM batch_volunteer b INNER JOIN batch_master bm ON bm.id=b.batch_id AND bm.deleted_at IS NULL LEFT JOIN program_master pm ON bm.program_id=pm.id AND pm.deleted_at IS NULL AND pm.is_active=1 WHERE b.user_id='".$user_id."' AND b.deleted_at IS NULL)");
      // echo $this->db->last_query();die();
      if($query->num_rows()>0){
        return $query->result();
      }
    }
}
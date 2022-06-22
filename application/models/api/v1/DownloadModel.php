<?php 
class DownloadModel extends CI_Model{
    public function __construct(){
        parent::__construct();
   	}
   	// function: getTotalDownloadList()
    // It is used to fetch total download list from database
    public function getTotalDownloadList(){
        $query=$this->db->query("SELECT COUNT(*) AS total_rows FROM download_management dm LEFT JOIN download_categories dc ON dm.category_id=dc.id AND dc.is_active=1 AND dc.deleted_at IS NULL WHERE dm.is_active=1 AND dm.deleted_at IS NULL");
        if($query->num_rows()>0){
            $row=$query->row();
            if(isset($row->total_rows) && $row->total_rows){
                return $row->total_rows;
            }
        }
        return 0;
    }
    // function: getDownloadList()
    // It is used to fetch download list from database
    public function getDownloadList($limit,$offset){
        $query=$this->db->query("SELECT TO_BASE64(dm.id) as download_id, dm.downloadtitle, dc.download_category_name FROM download_management dm LEFT JOIN download_categories dc ON dm.category_id=dc.id AND dc.is_active=1 AND dc.deleted_at IS NULL WHERE dm.is_active=1 AND dm.deleted_at IS NULL LIMIT ".$offset.",".$limit);
        if($query->num_rows()>0){
            return $query->result();
        }
    }
    // function: getDownloadManagementById($download_management_id)
    // It is used to fetch download management detail by id
    public function getDownloadManagementById($download_management_id){
        $query=$this->db->query("SELECT * FROM download_management WHERE id='".$download_management_id."'");
        if($query->num_rows()>0){
            return $query->row();
        }
    }
}
<?php 
class ConnectomModel extends CI_Model{
    public function __construct() {
        parent::__construct();
   	}
    // function: getContactUsByType()
    // It is used to get Contact Us By Type from db
    public function getContactUsByType($type){
        $query=$this->db->query("SELECT * FROM contact_us WHERE type='".$type."'");
        if($query->num_rows()>0){
            return $query->row();
        }
    }
   	// function: getCenterList()
    // It is used to get Center List By State id or Region Id
    public function getCenterList(){
        $state_id=$this->input->post('state_id');
        $region_id=$this->input->post('region_id');
        $condition='';
        if($region_id){
            $condition.=" AND region_id='".$region_id."' ";
        }else if($state_id){
            $condition.=" AND state_id='".$state_id."' ";
        }
        $query=$this->db->query("SELECT * FROM center_master WHERE is_active=1 AND deleted_at IS NULL ".$condition);
        if($query->num_rows()>0){
            return $query->result();
        }
    }
    // function: updateContactUs()
    // It is used to update Contact Us Detail
    public function updateContactUs(){
        $id=base64_decode($this->input->post('id'));
        $data = array(
            'address'=>$this->input->post('address'),
            'phone'=>$this->input->post('phone'),
            'email'=>$this->input->post('email'),
            'updated_by'=>$this->session->userdata('id'),
            'updated_at'=>date('Y-m-d H:i:s'),
        );
        $this->db->where('id',$id);
        $result=$this->db->update('contact_us', $data);
        return $result;
    }
    // function: insertSharePost()
    // It is used to add share post
    public function insertSharePost(){
        $result=array();
        $featured_image_name='';
        $upload_file_names=array();
        //start upload featured images
        if(isset($_FILES['featured_image']) && $_FILES['featured_image']){
            $file_path="upload/featured_images/";
            $valid_ext=array('jpg','jpeg','png','bmp');
            $uploadOk=upload_file($_FILES['featured_image'],$file_path,$valid_ext);
            if(isset($uploadOk['error']) && $uploadOk['error']){
                $result['error']['featured_image']=$uploadOk['error'];
                return $result;
            }
            $featured_image_name=$uploadOk['filename'];
        }
        //end upload featured images
        //start upload upload_file
        if(isset($_FILES['upload_file']) && $_FILES['upload_file']){
            $file_path="upload/upload_file/";
            $valid_ext=array('jpg','jpeg','png','bmp','mp4','ogg','mp3','ppt','ppsx','doc','docx','pdf','xls','xlsx');
            $uploadOk=upload_file($_FILES['upload_file'],$file_path,$valid_ext);
            if(isset($uploadOk['error']) && $uploadOk['error']){
                //unlink uploaded file
                $file_path="upload/featured_images/".$featured_image_name;
                if($featured_image_name!='' && file_exists($file_path)){
                    unlink($file_path);
                }
                if(isset($uploadOk['upload_file_names']) && $uploadOk['upload_file_names']){
                    for($i=0;$i<count($uploadOk['upload_file_names']);$i++){
                        $file_path="upload/upload_file/".$uploadOk['upload_file_names'][$i];
                        if($uploadOk['upload_file_names'][$i]!='' && file_exists($file_path)){
                            unlink($file_path);
                        }
                    }
                }
                $result['error']['upload_file']=$uploadOk['error'];
                return $result;
            }
            $upload_file_names=$uploadOk['upload_file_names'];
        }
        //end upload upload_file
        $result='';
        $data = array(
            'posttitle'=>$this->input->post('posttitle'),
            'category_id'=>$this->input->post('category_id'),
            'post_description'=>$this->input->post('post_description'),
            'featured_image'=>$featured_image_name,
            'is_active'=>1,
            'created_by'=> $this->session->userdata('id'),
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_by'=> $this->session->userdata('id'),
            'updated_at'=>date('Y-m-d H:i:s')
        );
        $result=$this->db->insert('share_post', $data);
        if($result==1){
            $share_post_id=$this->db->insert_id();
            if($upload_file_names){
                $insert_arr=array();
                for($i=0;$i<count($upload_file_names);$i++){
                    $insert_arr[] = array(
                        'share_post_id'=>$share_post_id,
                        'upload_file'=>$upload_file_names[$i]
                    );
                }
                $this->db->insert_batch('share_post_upload_file', $insert_arr); 
            }
        }else{
            //unlink uploaded file
            $file_path="upload/featured_images/".$featured_image_name;
            if($featured_image_name!='' && file_exists($file_path)){
                unlink($file_path);
            }
            if(isset($upload_file_names) && $upload_file_names){
                for($i=0;$i<count($upload_file_names);$i++){
                    $file_path="upload/upload_file/".$upload_file_names[$i];
                    if($upload_file_names[$i]!='' && file_exists($file_path)){
                        unlink($file_path);
                    }
                }
            }
        }
        return $result;
    }
    // function: updateSharePost()
    // It is used to update share post
    public function updateSharePost(){
        $result=array();
        $featured_image_name='';
        $upload_file_names=array();
        //start upload featured images
        if(isset($_FILES['featured_image']['name']) && $_FILES['featured_image']['name']){
            $file_path="upload/featured_images/";
            $valid_ext=array('jpg','jpeg','png','bmp');
            $uploadOk=upload_file($_FILES['featured_image'],$file_path,$valid_ext);
            if(isset($uploadOk['error']) && $uploadOk['error']){
                $result['error']['featured_image']=$uploadOk['error'];
                return $result;
            }
            $featured_image_name=$uploadOk['filename'];
        }
        //end upload featured images
        //start upload upload_file
        if(isset($_FILES['upload_file']['name'][0]) && $_FILES['upload_file']['name'][0]){
            $file_path="upload/upload_file/";
            $valid_ext=array('jpg','jpeg','png','bmp','mp4','ogg','mp3','ppt','ppsx','doc','docx','pdf','xls','xlsx');
            $uploadOk=upload_file($_FILES['upload_file'],$file_path,$valid_ext);
            if(isset($uploadOk['error']) && $uploadOk['error']){
                //unlink uploaded file
                $file_path="upload/featured_images/".$featured_image_name;
                if($featured_image_name!='' && file_exists($file_path)){
                    unlink($file_path);
                }
                if(isset($uploadOk['upload_file_names']) && $uploadOk['upload_file_names']){
                    for($i=0;$i<count($uploadOk['upload_file_names']);$i++){
                        $file_path="upload/upload_file/".$uploadOk['upload_file_names'][$i];
                        if($uploadOk['upload_file_names'][$i]!='' && file_exists($file_path)){
                            unlink($file_path);
                        }
                    }
                }
                $result['error']['upload_file']=$uploadOk['error'];
                return $result;
            }
            $upload_file_names=$uploadOk['upload_file_names'];
        }
        //end upload upload_file
        $result='';
        $data = array(
            'posttitle'=>$this->input->post('posttitle'),
            'category_id'=>$this->input->post('category_id'),
            'post_description'=>$this->input->post('post_description'),
            'updated_by'=> $this->session->userdata('id'),
            'updated_at'=>date('Y-m-d H:i:s')
        );
        $old_featured_image_name=$this->input->post('old_featured_image_name');
        if($featured_image_name && $old_featured_image_name){
            //unlink old image
            $file_path="upload/featured_images/".$old_featured_image_name;
            if(file_exists($file_path)){
                unlink($file_path);
            }
            $data['featured_image']=$featured_image_name;
        }
        $share_post_id=base64_decode($this->input->post('share_post_id'));
        $this->db->where('id',$share_post_id);
        $result=$this->db->update('share_post',$data);
        if($result==1){
            if($upload_file_names){
                $insert_arr=array();
                for($i=0;$i<count($upload_file_names);$i++){
                    $insert_arr[] = array(
                        'share_post_id'=>$share_post_id,
                        'upload_file'=>$upload_file_names[$i]
                    );
                }
                $this->db->insert_batch('share_post_upload_file', $insert_arr); 
            }
        }else{
            //unlink uploaded file
            $file_path="upload/featured_images/".$featured_image_name;
            if($featured_image_name!='' && file_exists($file_path)){
                unlink($file_path);
            }
            if(isset($upload_file_names) && $upload_file_names){
                for($i=0;$i<count($upload_file_names);$i++){
                    $file_path="upload/upload_file/".$upload_file_names[$i];
                    if($upload_file_names[$i]!='' && file_exists($file_path)){
                        unlink($file_path);
                    }
                }
            }
        }
        return $result;
    }
    // function: deleteSharePostFileUpload($id)
    // It is used to delete share post file upload
    public function deleteSharePostFileUpload($id){
        $row=$this->getFileUploadDetails($id);
        //unlink file from upload/upload_file folder
        if(isset($row->upload_file) && $row->upload_file!='' && $row->upload_file!=null){
            $file_path="upload/upload_file/".$row->upload_file;
            if(file_exists($file_path)){
                unlink($file_path);
            }
        }
        $result=$this->db->delete('share_post_upload_file', array('id' => $id));
        return $result; 
    }
    // function: getSharePostList()
    // It is used to fetch share post list
    public function getSharePostList(){
        $query=$this->db->query("SELECT * FROM share_post WHERE is_active=1 AND deleted_at IS NULL");
        if($query->num_rows()>0){
            return $query->result();
        }
    }
    // function: getSharePostById($share_post_id)
    // It is used to fetch share post detail by id
    public function getSharePostById($share_post_id){
        $query=$this->db->query("SELECT * FROM share_post WHERE id='".$share_post_id."'");
        if($query->num_rows()>0){
            return $query->row();
        }
    }
    // function: getFileUploadDetails($id)
    // It is used to fetch file upload detail by id
    public function getFileUploadDetails($id){
        $query=$this->db->query("SELECT * FROM share_post_upload_file WHERE id='".$id."'");
        if($query->num_rows()>0){
            return $query->row();
        }
    }
    // function: deleteSharePost($id)
    // It is used to delete share post by id
    public function deleteSharePost($id){
        $data = array(
            'deleted_by'=> $this->session->userdata('id'),
            'deleted_at'=>date('Y-m-d H:i:s')
        );
        $this->db->where('id',$id);
        $result=$this->db->update('share_post',$data);
        if($result==1){
            $this->db->where('share_post_id',$id);
            $result=$this->db->update('share_post_upload_file',$data);
        }
        return $result;
    }
    // function: getRequestList()
    // It is used to fetch request list from database
    public function getRequestList(){
        $query=$this->db->query("SELECT r.*, CONCAT_WS(' ',u.first_name,u.last_name) as fullname FROM requests r LEFT JOIN users u ON r.user_id=u.id AND u.is_active=1 AND u.deleted_at IS NULL WHERE r.is_active=1 AND r.deleted_at IS NULL");
        if($query->num_rows()>0){
            return $query->result();
        }
    }
    // function: getRequestDetails($id)
    // It is used to fetch request details by id from database
    public function getRequestDetails($id){
        $query=$this->db->query("SELECT r.*,CONCAT_WS(' ',u.first_name,u.last_name) as fullname FROM requests r LEFT JOIN users u ON r.user_id=u.id AND u.is_active=1 AND u.deleted_at IS NULL  WHERE r.id='".$id."' AND r.is_active=1 AND r.deleted_at IS NULL");
        //echo $this->db->last_query();die();
        if($query->num_rows()>0){
            return $query->row();
        }
    }
    // function: giveResponse()
    // It is used to give response to specific request
    public function giveResponse(){
        $id=base64_decode($this->input->post('request_id'));
        $data = array(
            'response'=> $this->input->post('response'),
            'response_date'=>date('Y-m-d H:i:s'),
            'updated_by'=> $this->session->userdata('id'),
            'updated_at'=>date('Y-m-d H:i:s')
        );
        $this->db->where('id',$id);
        $result=$this->db->update('requests',$data);
        return $result;
    } 
    // function: getDownloadManagementById($download_management_id)
    // It is used to fetch download management detail by id
    public function getDownloadManagementById($download_management_id){
        $query=$this->db->query("SELECT * FROM download_management WHERE id='".$download_management_id."'");
        if($query->num_rows()>0){
            return $query->row();
        }
    }
    // function: insertDownloadManagement()
    // It is used to add download management
    public function insertDownloadManagement(){
        $result=array();
        $upload_file_names=array();
        //start upload upload_file
        if(isset($_FILES['upload_file']) && $_FILES['upload_file']){
            $file_path="upload/download_management_upload_file/";
            $valid_ext=array('jpg','jpeg','png','bmp','mp4','ogg','mp3','ppt','ppsx','doc','docx','pdf','xls','xlsx');
            $uploadOk=upload_file($_FILES['upload_file'],$file_path,$valid_ext);
            if(isset($uploadOk['error']) && $uploadOk['error']){
                if(isset($uploadOk['upload_file_names']) && $uploadOk['upload_file_names']){
                    for($i=0;$i<count($uploadOk['upload_file_names']);$i++){
                        $file_path="upload/download_management_upload_file/".$uploadOk['upload_file_names'][$i];
                        if($uploadOk['upload_file_names'][$i]!='' && file_exists($file_path)){
                            unlink($file_path);
                        }
                    }
                }
                $result['error']['upload_file']=$uploadOk['error'];
                return $result;
            }
            $upload_file_names=$uploadOk['upload_file_names'];
        }
        //end upload upload_file
        $result='';
        $data = array(
            'downloadtitle'=>$this->input->post('downloadtitle'),
            'category_id'=>$this->input->post('category_id'),
            'is_active'=>1,
            'created_by'=> $this->session->userdata('id'),
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_by'=> $this->session->userdata('id'),
            'updated_at'=>date('Y-m-d H:i:s')
        );
        $result=$this->db->insert('download_management', $data);
        if($result==1){
            $download_management_id=$this->db->insert_id();
            if($upload_file_names){
                $insert_arr=array();
                for($i=0;$i<count($upload_file_names);$i++){
                    $insert_arr[] = array(
                        'download_management_id'=>$download_management_id,
                        'upload_file'=>$upload_file_names[$i]
                    );
                }
                $this->db->insert_batch('download_management_upload_file', $insert_arr); 
            }
        }else{
            //unlink uploaded file
            if(isset($upload_file_names) && $upload_file_names){
                for($i=0;$i<count($upload_file_names);$i++){
                    $file_path="upload/download_management_upload_file/".$upload_file_names[$i];
                    if($upload_file_names[$i]!='' && file_exists($file_path)){
                        unlink($file_path);
                    }
                }
            }
        }
        return $result;
    }
    // function: getDownloadManagementList()
    // It is used to fetch download management list
    public function getDownloadManagementList(){
        $query=$this->db->query("SELECT * FROM download_management WHERE is_active=1 AND deleted_at IS NULL");
        if($query->num_rows()>0){
            return $query->result();
        }
    }
    // function: deleteDownloadManagement($id)
    // It is used to delete download management by id
    public function deleteDownloadManagement($id){
        $data = array(
            'deleted_by'=> $this->session->userdata('id'),
            'deleted_at'=>date('Y-m-d H:i:s')
        );
        $this->db->where('id',$id);
        $result=$this->db->update('download_management',$data);
        if($result==1){
            $this->db->where('download_management_id',$id);
            $result=$this->db->update('download_management_upload_file',$data);
        }
        return $result;
    }
    // function: getDownloadManagementFileUploadDetails($id)
    // It is used to fetch file upload detail by id
    public function getDownloadManagementFileUploadDetails($id){
        $query=$this->db->query("SELECT * FROM download_management_upload_file WHERE id='".$id."'");
        if($query->num_rows()>0){
            return $query->row();
        }
    }
    // function: deleteDownloadManagementFileUpload($id)
    // It is used to delete download management file upload
    public function deleteDownloadManagementFileUpload($id){
        $row=$this->getDownloadManagementFileUploadDetails($id);
        //unlink file from upload/download_management_upload_file folder
        if(isset($row->upload_file) && $row->upload_file!='' && $row->upload_file!=null){
            $file_path="upload/download_management_upload_file/".$row->upload_file;
            if(file_exists($file_path)){
                unlink($file_path);
            }
        }
        $result=$this->db->delete('download_management_upload_file', array('id' => $id));
        return $result; 
    }
    // function: updateDownloadManagement()
    // It is used to update download management
    public function updateDownloadManagement(){
        $result=array();
        $upload_file_names=array();
        //start upload upload_file
        if(isset($_FILES['upload_file']['name'][0]) && $_FILES['upload_file']['name'][0]){
            $file_path="upload/download_management_upload_file/";
            $valid_ext=array('jpg','jpeg','png','bmp','mp4','ogg','mp3','ppt','ppsx','doc','docx','pdf','xls','xlsx');
            $uploadOk=upload_file($_FILES['upload_file'],$file_path,$valid_ext);
            if(isset($uploadOk['error']) && $uploadOk['error']){
                if(isset($uploadOk['upload_file_names']) && $uploadOk['upload_file_names']){
                    for($i=0;$i<count($uploadOk['upload_file_names']);$i++){
                        $file_path="upload/download_management_upload_file/".$uploadOk['upload_file_names'][$i];
                        if($uploadOk['upload_file_names'][$i]!='' && file_exists($file_path)){
                            unlink($file_path);
                        }
                    }
                }
                $result['error']['upload_file']=$uploadOk['error'];
                return $result;
            }
            $upload_file_names=$uploadOk['upload_file_names'];
        }
        //end upload upload_file
        $result='';
        $data = array(
            'downloadtitle'=>$this->input->post('downloadtitle'),
            'category_id'=>$this->input->post('category_id'),
            'updated_by'=> $this->session->userdata('id'),
            'updated_at'=>date('Y-m-d H:i:s')
        );
        $download_management_id=base64_decode($this->input->post('download_management_id'));
        $this->db->where('id',$download_management_id);
        $result=$this->db->update('download_management',$data);
        if($result==1){
            if($upload_file_names){
                $insert_arr=array();
                for($i=0;$i<count($upload_file_names);$i++){
                    $insert_arr[] = array(
                        'download_management_id'=>$download_management_id,
                        'upload_file'=>$upload_file_names[$i]
                    );
                }
                $this->db->insert_batch('download_management_upload_file', $insert_arr); 
            }
        }else{
            //unlink uploaded file
            if(isset($upload_file_names) && $upload_file_names){
                for($i=0;$i<count($upload_file_names);$i++){
                    $file_path="upload/download_management_upload_file/".$upload_file_names[$i];
                    if($upload_file_names[$i]!='' && file_exists($file_path)){
                        unlink($file_path);
                    }
                }
            }
        }
        return $result;
    }
}
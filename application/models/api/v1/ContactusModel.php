<?php 
class ContactusModel extends CI_Model{
    public function __construct() {
        parent::__construct();
   	}
   	// function: getQueriesQuestionsListByUserId()
    // It is used to get Queries/Questions List from database by user id
   	public function getQueriesQuestionsListByUserId($user_id){
   		$query=$this->db->query("SELECT queries, opinion, suggestions, response, time_contribution_for, available_date1, available_date2, available_date3 FROM requests WHERE user_id='".$user_id."' AND is_active=1 AND deleted_at IS NULL");
   		if($query->num_rows()>0){
   			return $query->result();
   		}
   	}
   	// function: saveRequest()
    // It is used to save Queries/Questions in 'request' table
   	public function saveRequest(){
        $jwt = new JwtToken();
        $received_Token = $this->input->request_headers('Authorization');
        $user = $jwt->GetTokenData($received_Token);
        $user_id='';
        if(isset($user['user_id']) && $user['user_id']){
            $user_id=$user['user_id'];
        }
        $available_date1=NULL;
        if(isset($_POST['available_date1']) && $_POST['available_date1']){
        	$available_date1=$this->input->post('available_date1');
            $available_date1=date("Y-m-d",strtotime(str_replace('/','-',$available_date1)));
        }
        $available_date2=NULL;
        if(isset($_POST['available_date2']) && $_POST['available_date2']){
        	$available_date2=$this->input->post('available_date2');
            $available_date2=date("Y-m-d",strtotime(str_replace('/','-',$available_date2)));
        }
        $available_date3=NULL;
        if(isset($_POST['available_date3']) && $_POST['available_date3']){
        	$available_date3=$this->input->post('available_date3');
            $available_date3=date("Y-m-d",strtotime(str_replace('/','-',$available_date3)));
        }
        $data = array(
            'user_id'=> $user_id,
            'queries'=> $this->input->post('queries'),
            'suggestions'=> $this->input->post('suggestions'),
            'opinion'=> $this->input->post('opinion'),
            'time_contribution_for'=> $this->input->post('time_contribution_for'),
            'available_date1'=>$available_date1,
            'available_date2'=>$available_date2,
            'available_date3'=>$available_date3,
            'request_date'=>date('Y-m-d H:i:s'),
            'created_by'=>$user_id,
            'created_at'=>date('Y-m-d H:i:s')
        );
        $result= $this->db->insert('requests', $data);
        return $result;
   	}
   	// function: getTotalShareStoriesByUserId($user_id)
    // It is used to get total share stories of specified user
   	public function getTotalShareStoriesByUserId($user_id){
   		$query=$this->db->query("SELECT COUNT(*) as total_pages FROM share_post sp LEFT JOIN post_categories pc ON sp.category_id=pc.id AND pc.is_active=1 AND pc.deleted_at IS NULL WHERE sp.created_by='".$user_id."' AND sp.is_active=1 AND sp.deleted_at IS NULL");
   		if($query->num_rows()>0){
   			$row=$query->row();
            if(isset($row->total_pages) && $row->total_pages){
                return $row->total_pages;
            }
   		}
        return 0;
   	}

    // function: getShareStoriesListByUserId($user_id)
    // It is used to get share stories list of specified user
    public function getShareStoriesListByUserId($user_id,$limit,$offset){
        $query=$this->db->query("SELECT TO_BASE64(sp.id) as share_post_id, sp.posttitle, pc.category_name FROM share_post sp LEFT JOIN post_categories pc ON sp.category_id=pc.id AND pc.is_active=1 AND pc.deleted_at IS NULL WHERE sp.created_by='".$user_id."' AND sp.is_active=1 AND sp.deleted_at IS NULL LIMIT ".$offset.",".$limit);
        if($query->num_rows()>0){
            return $query->result();
        }
    }
   	public function getPostCategoriesList(){
   		$query=$this->db->query("SELECT id, category_name FROM post_categories WHERE is_active=1 AND deleted_at IS NULL");
   		//echo $this->db->last_query();
   		if($query->num_rows()>0){
   			return $query->result();
   		}
   	}
   	// function: addSharePost()
    // It is used to add share post in 'share_post' table
   	public function addSharePost(){
   		$result=array();
   		$upload_file_names=array();
   		//start upload upload_file
        if(isset($_FILES['upload_file']) && $_FILES['upload_file']){
            $file_path="upload/upload_file/";
            $valid_ext=array('jpg','jpeg','png','bmp','mp4','ogg','mp3','ppt','ppsx','doc','docx','pdf','xls','xlsx');
            $uploadOk=upload_file($_FILES['upload_file'],$file_path,$valid_ext);
            if(isset($uploadOk['error']) && $uploadOk['error']){
                //unlink uploaded file
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
        $jwt = new JwtToken();
        $received_Token = $this->input->request_headers('Authorization');
        $user = $jwt->GetTokenData($received_Token);
        $user_id='';
        if(isset($user['user_id']) && $user['user_id']){
            $user_id=$user['user_id'];
        }
        $data = array(
            'posttitle'=> $this->input->post('posttitle'),
            'category_id'=> $this->input->post('category_id'),
            'is_active'=>1,
            'created_by'=>$user_id,
            'created_at'=>date('Y-m-d H:i:s')
        );
        $result= $this->db->insert('share_post', $data);
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
    // function: getShareStoriesById()
    // It is used to get share stories by id 'share_post' table
    public function getShareStoriesById($share_post_id){
        $query=$this->db->query("SELECT TO_BASE64(id) as share_post_id, posttitle, category_id FROM share_post WHERE id='".$share_post_id."'");
        if($query->num_rows()>0){
            return $query->row();
        }
    }
    // function: getSharePostUploadFileList($share_post_id)
    // It is used to get list of all upload files of share post by share post id
    public function getSharePostUploadFileList($share_post_id){
        $query=$this->db->query("SELECT TO_BASE64(id) as upload_file_id, upload_file  FROM share_post_upload_file WHERE share_post_id='".$share_post_id."' AND deleted_at IS NULL");
        if($query->num_rows()>0){
            return $query->result();
        }
    }
   	// function: editSharePost()
    // It is used to edit share post in 'share_post' table
   	public function editSharePost(){
        $result=array();
        $upload_file_names=array();
        //start upload upload_file
        if(isset($_FILES['upload_file']['name'][0]) && $_FILES['upload_file']['name'][0]){
            $file_path="upload/upload_file/";
            $valid_ext=array('jpg','jpeg','png','bmp','mp4','ogg','mp3','ppt','ppsx','doc','docx','pdf','xls','xlsx');
            $uploadOk=upload_file($_FILES['upload_file'],$file_path,$valid_ext);
            if(isset($uploadOk['error']) && $uploadOk['error']){
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
   		$jwt = new JwtToken();
        $received_Token = $this->input->request_headers('Authorization');
        $user = $jwt->GetTokenData($received_Token);
        $user_id='';
        if(isset($user['user_id']) && $user['user_id']){
            $user_id=$user['user_id'];
        }
   		$data = array(
            'posttitle'=>$this->input->post('posttitle'),
            'category_id'=>$this->input->post('category_id'),
            'updated_by'=> $user_id,
            'updated_at'=>date('Y-m-d H:i:s')
        );
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
    // function: deleteSharePost($id)
    // It is used to delete share post by id
    public function deleteSharePost($id){
        if($id){
            $jwt = new JwtToken();
            $received_Token = $this->input->request_headers('Authorization');
            $user = $jwt->GetTokenData($received_Token);
            $user_id='';
            if(isset($user['user_id']) && $user['user_id']){
                $user_id=$user['user_id'];
            }
            $data = array(
                'deleted_by'=> $user_id,
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
    }
    // function: getSharePostById($share_post_id)
    // It is used to fetch share post detail by id
    public function getSharePostById($share_post_id){
        $query=$this->db->query("SELECT * FROM share_post WHERE id='".$share_post_id."'");
        if($query->num_rows()>0){
            return $query->row();
        }
    }
    // function: getContactUsByType()
    // It is used to get Contact Us By Type from db
    public function getContactUsByType($type){
        $query=$this->db->query("SELECT phone, email, address FROM contact_us WHERE type='".$type."'");
        if($query->num_rows()>0){
            return $query->row();
        }
    }
}
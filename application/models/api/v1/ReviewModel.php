<?php 
class ReviewModel extends CI_Model{
    public function __construct() {
        parent::__construct();
   	}
    // function: getBatchList()
    // It is used to fetch batch list from database
    public function getBatchList(){
        $query=$this->db->query("SELECT bm.id as batch_id, bm.batch_name FROM batch_master bm WHERE bm.deleted_at IS NULL");
        if($query->num_rows()>0){
            return $query->result();
        }
    }
    // function: getUserTypesListByTypeName($USER_TYPE_IDS)
    // It is used to fetch user type list from database
    public function getUserTypesListByTypeName($USER_TYPE_IDS){
        $query=$this->db->query("SELECT id as user_type_id, user_type FROM user_types WHERE id IN(".$USER_TYPE_IDS.") AND is_active=1 AND deleted_at IS NULL");
        if($query->num_rows()>0){
            return $query->result();
        }
    }
    // function: getProgramFeedback()
    // It is used to fetch program feedback field which is not deleted and is active from database
    public function getProgramFeedback(){
        $query=$this->db->query("SELECT id as field_id, field_label, field_name, field_type, special_feature, related_table_name, is_required, file_extension, max_upload, min_number, max_number, date_validation, placeholder, comments, is_readonly FROM program_feedback_form WHERE is_active=1 AND deleted_at IS NULL ORDER BY sequence_no ASC");
        if($query->num_rows()>0){
            return $query->result();
        }
    }
    // function: getProgramNameByBatchId($batch_id)
    // It is used to fetch program name by batch id
    public function getProgramNameByBatchId($batch_id){
        $query=$this->db->query("SELECT pm.program_name FROM batch_master bm INNER JOIN program_master pm ON bm.program_id=pm.id AND pm.is_active=1 AND pm.deleted_at IS NULL WHERE bm.id='".$batch_id."'");
        if($query->num_rows()>0){
            $row=$query->row();
            return $row->program_name;
        }
    }
    // function: sessionListByProgramName($program_name)
    // It is used to fetch session list by program name
    public function sessionListByProgramName($program_name){
        $query=$this->db->query("SELECT s.id, s.session_name FROM sessionmanagement s INNER JOIN program_master p ON s.program_id=p.id AND p.program_name='".$program_name."' WHERE s.status=1 AND s.deleted_at IS NULL");
        if($query->num_rows()>0){
            return $query->result();
        }
    }
    // function: getDynamicFieldOptionByRelatedTable()
    // It is used to fetch option list from related_table table for dynamic form
    public function getDynamicFieldOptionByRelatedTable($tablename){
        // $option_html='<option value="">--Select--</option>';
        $option_list=array();
        $query=$this->db->query("SELECT * FROM ".$tablename." WHERE is_active=1 AND deleted_at IS NULL");
        if($query->num_rows()>0){
            $result=$query->result();
            $idfield='id';
            $namefield='name';
            if($tablename=='quality_data'){
                $namefield='quality_name';
            }else if($tablename=='program_master'){
                $namefield='program_name';
            }else if($tablename=='roles'){
                $namefield='role_name';
            }else if($tablename=='states'){
                $namefield='state_name';
            }else if($tablename=='districts'){
                $namefield='district_name';
            }else if($tablename=='city_town_villages'){
                $namefield='village_name';
            }
            foreach($result as $r){
                // $option_list.='<option value="'.$r->$idfield.'">'.$r->$namefield.'</option>';
                $option_list[]=array('id'=>$r->$idfield,'name'=>$r->$namefield);
            }
        };
        return $option_list;
    }
    // function: getDynamicFieldOption($tablename, $related_table_id, $fieldtype, $field_name='')
    // It is used to fetch option list from dynamic_form_option table for specific table in dynamic form
    function getDynamicFieldOption($tablename, $related_table_id, $fieldtype, $field_name=''){
        $option_list=array();
        /* 
        if($fieldtype=='dropdown'){
            $option_html='<option value="">--Select--</option>';
        }else{
            $option_html='';
        } */
        $query=$this->db->query("SELECT * FROM dynamic_form_option_table WHERE table_name='".$tablename."' AND related_table_id='".$related_table_id."' AND is_active=1 AND deleted_at IS NULL");
        if($query->num_rows()>0){
            $result=$query->result();
            /* 
            $i=1;
            if($fieldtype=='checkbox'){
                foreach($result as $r){
                    $option_html.='<input type="checkbox" id="'.$field_name.$i.'" name="'.$field_name.'" value="'.$r->option_value.'">&nbsp;<label for="'.$field_name.$i.'">'.$r->option_value.'</label>&nbsp;';
                    $i++;
                }
            }else if($fieldtype=='radio'){
                foreach($result as $r){
                    $option_html.='<input type="radio" id="'.$field_name.$i.'" name="'.$field_name.'" value="'.$r->option_value.'">&nbsp;<label for="'.$field_name.$i.'">'.$r->option_value.'</label>&nbsp;';
                    $i++;
                }
            }else{
               foreach($result as $r){
                    $option_html.='<option value="'.$r->option_value.'">'.$r->option_value.'</option>';
                } 
            } */
            foreach($result as $r){
                $option_list[]=array('id'=>$r->option_value,'name'=>$r->option_value);
                // $option_html.='<option value="'.$r->option_value.'">'.$r->option_value.'</option>';
            } 
        }
        // return $option_html;
        return $option_list;
    }
    // function: getRequiredFieldList($tablename)
    // It is used to fetch  required field list which is not deleted and is active from database
    public function getRequiredFieldList($tablename){
        $query=$this->db->query("SELECT field_label, field_name, field_type, special_feature FROM ".$tablename." WHERE is_required=1 AND is_active=1 AND deleted_at IS NULL ORDER BY sequence_no ASC");
        if($query->num_rows()>0){
            return $query->result();
        }
    }
    // function: getProgramFeedback()
    // It is used to add Program Feedback Review
    public function addProgramFeedbackReview(){
        $result=array();
        $upload_file_names=array();
        //start upload_file
        if(isset($_FILES) && $_FILES){
            foreach($_FILES as $field_name => $value){
                $totalfiles=0;
                if(isset($_FILES[$field_name]['name'])){
                    $totalfiles=count($_FILES[$field_name]['name']);
                }
                $max_upload=$this->checkMaxUpload($field_name,'program_feedback_form',$totalfiles);
                if(!$max_upload){
                    $file_path="upload/program_feedback_review/";
                    $valid_ext=$this->getValidExtensionByFieldName($field_name,'program_feedback_form');
                    $uploadOk=upload_file($_FILES[$field_name],$file_path,$valid_ext);
                    if(isset($uploadOk['error']) && $uploadOk['error']){
                        $result['error'][$field_name]=$uploadOk['error'];
                        //unlink uploaded file
                        if(isset($upload_file_names) && $upload_file_names){
                            foreach($upload_file_names as $field_name => $value){
                                for($i=0;$i<count($upload_file_names[$field_name]);$i++){
                                    $file_path="upload/program_feedback_review/".$upload_file_names[$field_name][$i];
                                    if($upload_file_names[$field_name][$i]!='' && file_exists($file_path)){
                                        unlink($file_path);
                                    }
                                }
                            }
                        }
                        return $result;
                    }
                    $upload_file_names[$field_name]=$uploadOk['upload_file_names'];
                }else{
                    $result['error'][$field_name]='Sorry, can not upload more than '.$max_upload.' files';
                    return $result;
                }
            }
        }
        //end upload upload_file
        //print_r($upload_file_names);die();
        $jwt = new JwtToken();
        $received_Token = $this->input->request_headers('Authorization');
        $user = $jwt->GetTokenData($received_Token);
        $user_id='';
        if(isset($user['user_id']) && $user['user_id']){
            $user_id=$user['user_id'];
        }
        $reviews = json_encode($_POST);
        $data = array(
            'reviews'=>$reviews,
            'is_active'=>1,
            'created_by'=>$user_id,
            'created_at'=>date('Y-m-d H:i:s'),
        );
        $result['success']=$this->db->insert('program_feedback_review', $data);
        if($result['success']==1){
            $review_id=$this->db->insert_id();
            if($upload_file_names){
                foreach($upload_file_names as $field_name => $value){
                    $insert_arr=array();
                    for($i=0;$i<count($upload_file_names[$field_name]);$i++){
                        $insert_arr[] = array(
                            'review_id'=>$review_id,
                            'upload_file'=>$upload_file_names[$field_name][$i],
                            'field_name'=>$field_name
                        );
                    }
                    $this->db->insert_batch('program_feedback_review_upload_file', $insert_arr);
                }
            }
        }else{
            //unlink uploaded file
            if(isset($upload_file_names) && $upload_file_names){
                foreach($upload_file_names as $field_name => $value){
                    for($i=0;$i<count($upload_file_names[$field_name]);$i++){
                        $file_path="upload/program_feedback_review/".$upload_file_names[$field_name][$i];
                        if($upload_file_names[$field_name][$i]!='' && file_exists($file_path)){
                            unlink($file_path);
                        }
                    }
                }
            }
        }
        return $result;
    }
    // function: getValidExtensionByFieldName($field_name,$tablename)
    // It is used to get valid extention array By Field Name and table name
    public function getValidExtensionByFieldName($field_name,$tablename){
        $valid_ext=array();
        $query=$this->db->query("SELECT file_extension FROM ".$tablename." WHERE field_name='".$field_name."'");
        if($query->num_rows()>0){
            $row=$query->row();
            $file_extension=$row->file_extension;
            $query=$this->db->query("SELECT extension_name FROM extensions WHERE is_active=1 AND id IN(".$file_extension.")");
            if($query->num_rows()>0){
                $result=$query->result();
                foreach($result as $r){
                    $valid_ext[]=$r->extension_name;
                }
            }
        }
        return $valid_ext;
    }
    // function: checkMaxUpload($field_name,$tablename,$totalfiles)
    // It is used to check max upload validation By Field Name, table name and total files
    public function checkMaxUpload($field_name,$tablename,$totalfiles){
        $query=$this->db->query("SELECT max_upload FROM ".$tablename." WHERE field_name='".$field_name."'");
        if($query->num_rows()>0){
            $row=$query->row();
            $max_upload=$row->max_upload;
            if($max_upload>0 && $max_upload<$totalfiles){
                print_r($totalfiles);
                return $max_upload;
            }
        }
        return false;
    }
    // function: getPersonalLearning()
    // It is used to fetch personal learning form field from database which is not deleted and is active 
    public function getPersonalLearning(){
        $query=$this->db->query("SELECT id as field_id, field_label, field_name, field_type, special_feature, related_table_name, is_required, file_extension, max_upload, min_number, max_number, date_validation, placeholder, comments, is_readonly FROM personal_learning_form WHERE is_active=1 AND deleted_at IS NULL ORDER BY sequence_no ASC");
        if($query->num_rows()>0){
            return $query->result();
        }
    }
    // function: addPersonalReflectionReview()
    // It is used to add Personal Reflection Review
    public function addPersonalReflectionReview(){
        $result=array();
        $upload_file_names=array();
        //start upload_file
        if(isset($_FILES) && $_FILES){
            foreach($_FILES as $field_name => $value){
                $totalfiles=0;
                if(isset($_FILES[$field_name]['name'])){
                    $totalfiles=count($_FILES[$field_name]['name']);
                }
                $max_upload=$this->checkMaxUpload($field_name,'personal_learning_form',$totalfiles);
                if(!$max_upload){
                    $file_path="upload/personal_reflection_review/";
                    $valid_ext=$this->getValidExtensionByFieldName($field_name,'personal_learning_form');
                    $uploadOk=upload_file($_FILES[$field_name],$file_path,$valid_ext);
                    if(isset($uploadOk['error']) && $uploadOk['error']){
                        $result['error'][$field_name]=$uploadOk['error'];
                        //unlink uploaded file
                        if(isset($upload_file_names) && $upload_file_names){
                            foreach($upload_file_names as $field_name => $value){
                                for($i=0;$i<count($upload_file_names[$field_name]);$i++){
                                    $file_path="upload/personal_reflection_review/".$upload_file_names[$field_name][$i];
                                    if($upload_file_names[$field_name][$i]!='' && file_exists($file_path)){
                                        unlink($file_path);
                                    }
                                }
                            }
                        }
                        return $result;
                    }
                    $upload_file_names[$field_name]=$uploadOk['upload_file_names'];
                }else{
                    $result['error'][$field_name]='Sorry, can not upload more than '.$max_upload.' files';
                    return $result;
                }
            }
        }
        //end upload upload_file
        //print_r($upload_file_names);die();
        $jwt = new JwtToken();
        $received_Token = $this->input->request_headers('Authorization');
        $user = $jwt->GetTokenData($received_Token);
        $user_id='';
        if(isset($user['user_id']) && $user['user_id']){
            $user_id=$user['user_id'];
        }
        $reviews = json_encode($_POST);
        $data = array(
            'reviews'=>$reviews,
            'is_active'=>1,
            'created_by'=>$user_id,
            'created_at'=>date('Y-m-d H:i:s'),
        );
        $result['success']=$this->db->insert('personal_learning_review', $data);
        if($result['success']==1){
            $review_id=$this->db->insert_id();
            if($upload_file_names){
                foreach($upload_file_names as $field_name => $value){
                    $insert_arr=array();
                    for($i=0;$i<count($upload_file_names[$field_name]);$i++){
                        $insert_arr[] = array(
                            'review_id'=>$review_id,
                            'upload_file'=>$upload_file_names[$field_name][$i],
                            'field_name'=>$field_name
                        );
                    }
                    $this->db->insert_batch('personal_learning_review_upload_file', $insert_arr);
                }
            }
        }else{
            //unlink uploaded file
            if(isset($upload_file_names) && $upload_file_names){
                foreach($upload_file_names as $field_name => $value){
                    for($i=0;$i<count($upload_file_names[$field_name]);$i++){
                        $file_path="upload/personal_reflection_review/".$upload_file_names[$field_name][$i];
                        if($upload_file_names[$field_name][$i]!='' && file_exists($file_path)){
                            unlink($file_path);
                        }
                    }
                }
            }
        }
        return $result;
    }
    // function: getFeedbackParticipant()
    // It is used to fetch feedback for participants form field from database which is not deleted and is active 
    public function getFeedbackParticipant(){
        $query=$this->db->query("SELECT id as field_id, field_label, field_name, field_type, special_feature, related_table_name, is_required, file_extension, max_upload, min_number, max_number, date_validation, placeholder, comments, is_readonly FROM feedback_for_participants_form WHERE is_active=1 AND deleted_at IS NULL ORDER BY sequence_no ASC");
        if($query->num_rows()>0){
            return $query->result();
        }
    }
    // function: getParticipantsByBatchId($batch_id)
    // It is used to fetch total registered participants by batch id
    public function getParticipantsByBatchId($batch_id){
        $query=$this->db->query("SELECT bm.no_of_participant_registered FROM batch_master bm  WHERE bm.id='".$batch_id."'");
        if($query->num_rows()>0){
            $row=$query->row();
            return $row->no_of_participant_registered;
        }
        return 0;
    }
    // function: addFeedbackForParticipantsReview()
    // It is used to add Feedback For Participants Review
    public function addFeedbackForParticipantsReview(){
        $result=array();
        $upload_file_names=array();
        //start upload_file
        if(isset($_FILES) && $_FILES){
            foreach($_FILES as $field_name => $value){
                $totalfiles=0;
                if(isset($_FILES[$field_name]['name'])){
                    $totalfiles=count($_FILES[$field_name]['name']);
                }
                $max_upload=$this->checkMaxUpload($field_name,'feedback_for_participants_form',$totalfiles);
                if(!$max_upload){
                    $file_path="upload/feedback_for_participants_review/";
                    $valid_ext=$this->getValidExtensionByFieldName($field_name,'feedback_for_participants_form');
                    $uploadOk=upload_file($_FILES[$field_name],$file_path,$valid_ext);
                    if(isset($uploadOk['error']) && $uploadOk['error']){
                        $result['error'][$field_name]=$uploadOk['error'];
                        //unlink uploaded file
                        if(isset($upload_file_names) && $upload_file_names){
                            foreach($upload_file_names as $field_name => $value){
                                for($i=0;$i<count($upload_file_names[$field_name]);$i++){
                                    $file_path="upload/feedback_for_participants_review/".$upload_file_names[$field_name][$i];
                                    if($upload_file_names[$field_name][$i]!='' && file_exists($file_path)){
                                        unlink($file_path);
                                    }
                                }
                            }
                        }
                        return $result;
                    }
                    $upload_file_names[$field_name]=$uploadOk['upload_file_names'];
                }else{
                    $result['error'][$field_name]='Sorry, can not upload more than '.$max_upload.' files';
                    return $result;
                }
            }
        }
        //end upload upload_file
        //print_r($upload_file_names);die();
        $jwt = new JwtToken();
        $received_Token = $this->input->request_headers('Authorization');
        $user = $jwt->GetTokenData($received_Token);
        $user_id='';
        if(isset($user['user_id']) && $user['user_id']){
            $user_id=$user['user_id'];
        }
        $reviews = json_encode($_POST);
        $data = array(
            'reviews'=>$reviews,
            'is_active'=>1,
            'created_by'=>$user_id,
            'created_at'=>date('Y-m-d H:i:s'),
        );
        $result['success']=$this->db->insert('feedback_for_participants_review', $data);
        if($result['success']==1){
            $review_id=$this->db->insert_id();
            if($upload_file_names){
                foreach($upload_file_names as $field_name => $value){
                    $insert_arr=array();
                    for($i=0;$i<count($upload_file_names[$field_name]);$i++){
                        $insert_arr[] = array(
                            'review_id'=>$review_id,
                            'upload_file'=>$upload_file_names[$field_name][$i],
                            'field_name'=>$field_name
                        );
                    }
                    $this->db->insert_batch('feedback_for_participants_review_upload_file', $insert_arr);
                }
            }
        }else{
            //unlink uploaded file
            if(isset($upload_file_names) && $upload_file_names){
                foreach($upload_file_names as $field_name => $value){
                    for($i=0;$i<count($upload_file_names[$field_name]);$i++){
                        $file_path="upload/feedback_for_participants_review/".$upload_file_names[$field_name][$i];
                        if($upload_file_names[$field_name][$i]!='' && file_exists($file_path)){
                            unlink($file_path);
                        }
                    }
                }
            }
        }
        return $result;
    }
    // function: getFeedbackByParticipant()
    // It is used to fetch program feedback for participants form field from database which is not deleted and is active 
    public function getFeedbackByParticipant(){
        $query=$this->db->query("SELECT id as field_id, field_label, field_name, field_type, special_feature, related_table_name, is_required, file_extension, max_upload, min_number, max_number, date_validation, placeholder, comments, is_readonly FROM program_feedback_by_participants_form WHERE is_active=1 AND deleted_at IS NULL ORDER BY sequence_no ASC");
        if($query->num_rows()>0){
            return $query->result();
        }
    }
    // function: addProgramFeedbackByParticipantsReview()
    // It is used to add Program Feedback By Participants Review
    public function addProgramFeedbackByParticipantsReview(){
        $result=array();
        $upload_file_names=array();
        //start upload_file
        if(isset($_FILES) && $_FILES){
            foreach($_FILES as $field_name => $value){
                $totalfiles=0;
                if(isset($_FILES[$field_name]['name'])){
                    $totalfiles=count($_FILES[$field_name]['name']);
                }
                $max_upload=$this->checkMaxUpload($field_name,'program_feedback_by_participants_form',$totalfiles);
                if(!$max_upload){
                    $file_path="upload/program_feedback_by_participants_review/";
                    $valid_ext=$this->getValidExtensionByFieldName($field_name,'program_feedback_by_participants_form');
                    $uploadOk=upload_file($_FILES[$field_name],$file_path,$valid_ext);
                    if(isset($uploadOk['error']) && $uploadOk['error']){
                        $result['error'][$field_name]=$uploadOk['error'];
                        //unlink uploaded file
                        if(isset($upload_file_names) && $upload_file_names){
                            foreach($upload_file_names as $field_name => $value){
                                for($i=0;$i<count($upload_file_names[$field_name]);$i++){
                                    $file_path="upload/program_feedback_by_participants_review/".$upload_file_names[$field_name][$i];
                                    if($upload_file_names[$field_name][$i]!='' && file_exists($file_path)){
                                        unlink($file_path);
                                    }
                                }
                            }
                        }
                        return $result;
                    }
                    $upload_file_names[$field_name]=$uploadOk['upload_file_names'];
                }else{
                    $result['error'][$field_name]='Sorry, can not upload more than '.$max_upload.' files';
                    return $result;
                }
            }
        }
        //end upload upload_file
        //print_r($upload_file_names);die();
        $jwt = new JwtToken();
        $received_Token = $this->input->request_headers('Authorization');
        $user = $jwt->GetTokenData($received_Token);
        $user_id='';
        if(isset($user['user_id']) && $user['user_id']){
            $user_id=$user['user_id'];
        }
        $reviews = json_encode($_POST);
        $data = array(
            'reviews'=>$reviews,
            'is_active'=>1,
            'created_by'=>$user_id,
            'created_at'=>date('Y-m-d H:i:s'),
        );
        $result['success']=$this->db->insert('program_feedback_by_participants_review', $data);
        if($result['success']==1){
            $review_id=$this->db->insert_id();
            if($upload_file_names){
                foreach($upload_file_names as $field_name => $value){
                    $insert_arr=array();
                    for($i=0;$i<count($upload_file_names[$field_name]);$i++){
                        $insert_arr[] = array(
                            'review_id'=>$review_id,
                            'upload_file'=>$upload_file_names[$field_name][$i],
                            'field_name'=>$field_name
                        );
                    }
                    $this->db->insert_batch('program_feedback_by_participants_review_upload_file', $insert_arr);
                }
            }
        }else{
            //unlink uploaded file
            if(isset($upload_file_names) && $upload_file_names){
                foreach($upload_file_names as $field_name => $value){
                    for($i=0;$i<count($upload_file_names[$field_name]);$i++){
                        $file_path="upload/program_feedback_by_participants_review/".$upload_file_names[$field_name][$i];
                        if($upload_file_names[$field_name][$i]!='' && file_exists($file_path)){
                            unlink($file_path);
                        }
                    }
                }
            }
        }
        return $result;
    }
    // function: getStarParticipant()
    // It is used to fetch star participants form field from database which is not deleted and is active 
    public function getStarParticipant(){
        $query=$this->db->query("SELECT id as field_id, field_label, field_name, field_type, special_feature, related_table_name, is_required, file_extension, max_upload, min_number, max_number, date_validation, placeholder, comments, is_readonly FROM star_participants_form WHERE is_active=1 AND deleted_at IS NULL ORDER BY sequence_no ASC");
        if($query->num_rows()>0){
            return $query->result();
        }
    }
    // function: addStarParticipantsReview()
    // It is used to add star Participants Review
    public function addStarParticipantsReview(){
        $result=array();
        $upload_file_names=array();
        //start upload_file
        if(isset($_FILES) && $_FILES){
            foreach($_FILES as $field_name => $value){
                $totalfiles=0;
                if(isset($_FILES[$field_name]['name'])){
                    $totalfiles=count($_FILES[$field_name]['name']);
                }
                $max_upload=$this->checkMaxUpload($field_name,'star_participants_form',$totalfiles);
                if(!$max_upload){
                    $file_path="upload/star_participant_review/";
                    $valid_ext=$this->getValidExtensionByFieldName($field_name,'star_participants_form');
                    $uploadOk=upload_file($_FILES[$field_name],$file_path,$valid_ext);
                    if(isset($uploadOk['error']) && $uploadOk['error']){
                        $result['error'][$field_name]=$uploadOk['error'];
                        //unlink uploaded file
                        if(isset($upload_file_names) && $upload_file_names){
                            foreach($upload_file_names as $field_name => $value){
                                for($i=0;$i<count($upload_file_names[$field_name]);$i++){
                                    $file_path="upload/star_participant_review/".$upload_file_names[$field_name][$i];
                                    if($upload_file_names[$field_name][$i]!='' && file_exists($file_path)){
                                        unlink($file_path);
                                    }
                                }
                            }
                        }
                        return $result;
                    }
                    $upload_file_names[$field_name]=$uploadOk['upload_file_names'];
                }else{
                    $result['error'][$field_name]='Sorry, can not upload more than '.$max_upload.' files';
                    return $result;
                }
            }
        }
        //end upload upload_file
        //print_r($upload_file_names);die();
        $jwt = new JwtToken();
        $received_Token = $this->input->request_headers('Authorization');
        $user = $jwt->GetTokenData($received_Token);
        $user_id='';
        if(isset($user['user_id']) && $user['user_id']){
            $user_id=$user['user_id'];
        }
        $reviews = json_encode($_POST);
        $data = array(
            'reviews'=>$reviews,
            'is_active'=>1,
            'created_by'=>$user_id,
            'created_at'=>date('Y-m-d H:i:s'),
        );
        $result['success']=$this->db->insert('star_participant_review', $data);
        if($result['success']==1){
            $review_id=$this->db->insert_id();
            if($upload_file_names){
                foreach($upload_file_names as $field_name => $value){
                    $insert_arr=array();
                    for($i=0;$i<count($upload_file_names[$field_name]);$i++){
                        $insert_arr[] = array(
                            'review_id'=>$review_id,
                            'upload_file'=>$upload_file_names[$field_name][$i],
                            'field_name'=>$field_name
                        );
                    }
                    $this->db->insert_batch('star_participant_review_upload_file', $insert_arr);
                }
            }
        }else{
            //unlink uploaded file
            if(isset($upload_file_names) && $upload_file_names){
                foreach($upload_file_names as $field_name => $value){
                    for($i=0;$i<count($upload_file_names[$field_name]);$i++){
                        $file_path="upload/star_participant_review/".$upload_file_names[$field_name][$i];
                        if($upload_file_names[$field_name][$i]!='' && file_exists($file_path)){
                            unlink($file_path);
                        }
                    }
                }
            }
        }
        return $result;
    }
    // function: getImactOnCharacterTraits()
    // It is used to fetch  impact on character traits form field from database which is not deleted and is active 
    public function getImactOnCharacterTraits(){
        $query=$this->db->query("SELECT id as field_id, field_label, field_name, field_type, special_feature, related_table_name, is_required, file_extension, max_upload, min_number, max_number, date_validation, placeholder, comments, is_readonly FROM impact_on_character_traits_form WHERE is_active=1 AND deleted_at IS NULL ORDER BY sequence_no ASC");
        if($query->num_rows()>0){
            return $query->result();
        }
    }
    // function: getParameterOrCharacteristicsList()
    // It is used to fetch Parameter Or Characteristics List from database which is not deleted and is active 
    public function getParameterOrCharacteristicsList(){
        $query=$this->db->query("SELECT TO_BASE64(id) as parameter_or_characteristics_id, sequence_no, type, name, characteristics, description FROM parameter_or_characteristics_list WHERE is_active=1 AND deleted_at IS NULL ORDER BY sequence_no ASC");
        if($query->num_rows()>0){
            return $query->result();
        }
    }
    // function: addImpactAssessmentReview()
    // It is used to add Impact Assessment Review
    public function addImpactAssessmentReview(){
        $result=array();
        $upload_file_names=array();
        //start upload_file
        if(isset($_FILES) && $_FILES){
            foreach($_FILES as $field_name => $value){
                $totalfiles=0;
                if(isset($_FILES[$field_name]['name'])){
                    $totalfiles=count($_FILES[$field_name]['name']);
                }
                $max_upload=$this->checkMaxUpload($field_name,'impact_on_character_traits_form',$totalfiles);
                if(!$max_upload){
                    $file_path="upload/impact_on_character_traits_review/";
                    $valid_ext=$this->getValidExtensionByFieldName($field_name,'impact_on_character_traits_form');
                    $uploadOk=upload_file($_FILES[$field_name],$file_path,$valid_ext);
                    if(isset($uploadOk['error']) && $uploadOk['error']){
                        $result['error'][$field_name]=$uploadOk['error'];
                        //unlink uploaded file
                        if(isset($upload_file_names) && $upload_file_names){
                            foreach($upload_file_names as $field_name => $value){
                                for($i=0;$i<count($upload_file_names[$field_name]);$i++){
                                    $file_path="upload/impact_on_character_traits_review/".$upload_file_names[$field_name][$i];
                                    if($upload_file_names[$field_name][$i]!='' && file_exists($file_path)){
                                        unlink($file_path);
                                    }
                                }
                            }
                        }
                        return $result;
                    }
                    $upload_file_names[$field_name]=$uploadOk['upload_file_names'];
                }else{
                    $result['error'][$field_name]='Sorry, can not upload more than '.$max_upload.' files';
                    return $result;
                }
            }
        }
        //end upload upload_file
        //print_r($upload_file_names);die();
        $jwt = new JwtToken();
        $received_Token = $this->input->request_headers('Authorization');
        $user = $jwt->GetTokenData($received_Token);
        $user_id='';
        if(isset($user['user_id']) && $user['user_id']){
            $user_id=$user['user_id'];
        }
        $parameter_or_characteristics_id_arr=array();
        if(isset($_POST['parameter_or_characteristics_id']) && $_POST['parameter_or_characteristics_id']){
            $parameter_or_characteristics_id_arr=$_POST['parameter_or_characteristics_id'];
            unset($_POST['parameter_or_characteristics_id']);
        }
        $before_oasis_program_arr=array();
        if(isset($_POST['before_oasis_program']) && $_POST['before_oasis_program']){
            $before_oasis_program_arr=$_POST['before_oasis_program'];
            unset($_POST['before_oasis_program']);
        }
        $status_at_present_arr=array();
        if(isset($_POST['status_at_present']) && $_POST['status_at_present']){
            $status_at_present_arr=$_POST['status_at_present'];
            unset($_POST['status_at_present']);
        }
        unset($_POST[0]);
        $reviews = json_encode($_POST);
        $data = array(
            'reviews'=>$reviews,
            'is_active'=>1,
            'created_by'=>$user_id,
            'created_at'=>date('Y-m-d H:i:s'),
        );
        $result['success']=$this->db->insert('impact_on_character_traits_review', $data);
        if($result['success']==1){
            $review_id=$this->db->insert_id();
            if($upload_file_names){
                foreach($upload_file_names as $field_name => $value){
                    $insert_arr=array();
                    for($i=0;$i<count($upload_file_names[$field_name]);$i++){
                        $insert_arr[] = array(
                            'review_id'=>$review_id,
                            'upload_file'=>$upload_file_names[$field_name][$i],
                            'field_name'=>$field_name
                        );
                    }
                    $this->db->insert_batch('impact_on_character_traits_review_upload_file', $insert_arr);
                }
            }
            // Start parameter_or_characteristics_review
            if($parameter_or_characteristics_id_arr && $before_oasis_program_arr && $status_at_present_arr){
                $insert_arr=array();
                for($i=0;$i<count($parameter_or_characteristics_id_arr);$i++){
                    $insert_arr[] = array(
                        'review_id'=>$review_id,
                        'parameter_or_characteristics_id'=>base64_decode($parameter_or_characteristics_id_arr[$i]),
                        'before_oasis_program'=>$before_oasis_program_arr[$i],
                        'status_at_present'=>$status_at_present_arr[$i]
                    );
                }
                $this->db->insert_batch('parameter_or_characteristics_review', $insert_arr);
            }
            // End parameter_or_characteristics_review
        }else{
            //unlink uploaded file
            if(isset($upload_file_names) && $upload_file_names){
                foreach($upload_file_names as $field_name => $value){
                    for($i=0;$i<count($upload_file_names[$field_name]);$i++){
                        $file_path="upload/impact_on_character_traits_review/".$upload_file_names[$field_name][$i];
                        if($upload_file_names[$field_name][$i]!='' && file_exists($file_path)){
                            unlink($file_path);
                        }
                    }
                }
            }
        }
        return $result;
    }
}
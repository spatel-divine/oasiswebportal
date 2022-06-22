<?php 
// function: getFileExtensionOptions()
// It is used to fetch file extensions from extensions table for dynamic form
function getFileExtensionOptions($selectedext=''){
    // Get current CodeIgniter instance
    $CI =& get_instance();
    $file_ext_options_html="<option value=''>--Select--</option>";
    $query=$CI->db->query("SELECT * FROM extensions WHERE is_active=1");
    if($query->num_rows()>0){
    	$result=$query->result();
        $extarr=explode(',',$selectedext);
    	foreach ($result as $r){
            $selected='';
            if(in_array($r->id,$extarr)){
                $selected='selected';
            }
    		$file_ext_options_html.="<option value='".$r->id."' ".$selected.">".$r->extension_name."</option>";
    	}
    }
    return  $file_ext_options_html;
}
// function: getTotalRecordFromTable()
// It is used to fetch total record from specific table for indexing in dynamic form
function getTotalRecordFromTable($tablename){
    // Get current CodeIgniter instance
    $CI =& get_instance();
    $query=$CI->db->query("SELECT * FROM ".$tablename);
    if($query->num_rows()>0){
        return $query->num_rows();
    }
    return 0;
}
// function: getDynamicFieldOption()
// It is used to fetch option list from dynamic_form_option table for specific table in dynamic form
function getDynamicFieldOption($tablename, $related_table_id, $fieldtype, $field_name=''){
    // Get current CodeIgniter instance
    $CI =& get_instance();
    if($fieldtype=='dropdown'){
        $option_html='<option value="">--Select--</option>';
    }else{
        $option_html='';
    }
    $query=$CI->db->query("SELECT * FROM dynamic_form_option_table WHERE table_name='".$tablename."' AND related_table_id='".$related_table_id."' AND is_active=1 AND deleted_at IS NULL");
    if($query->num_rows()>0){
        $result=$query->result();
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
        }
    }
    return $option_html;
}
// function: getDynamicFieldOptionByRelatedTable()
// It is used to fetch option list from related_table table for dynamic form
function getDynamicFieldOptionByRelatedTable($tablename){
    // Get current CodeIgniter instance
    $CI =& get_instance();
    $option_html='<option value="">--Select--</option>';
    $query=$CI->db->query("SELECT * FROM ".$tablename." WHERE is_active=1 AND deleted_at IS NULL");
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
            $option_html.='<option value="'.$r->$idfield.'">'.$r->$namefield.'</option>';
        }
    };
    return $option_html;
}
// function: getAssignRightsControllerList()
// It is used to fetch controller by group for rowcol on assign rights page
function getAssignRightsControllerList(){
    $CI =& get_instance();
    $controllerarr=array();
    $query=$CI->db->query("SELECT controller_name,count(*) as COUNT FROM assign_rights_list WHERE is_active=1 Group By controller_name");
    if($query->num_rows()>0){
        $result=$query->result();
        foreach ($result as $r) {
           $controllerarr[$r->controller_name]=$r->COUNT;
        }
    };
    return $controllerarr;
}
// function: getAssignRightsHtml()
// It is used to fetch AssignRightsHtml
function getAssignRightsHtml($assign_rights_list,$rights_arr){
    $assign_rights_html='';
    if($assign_rights_list){
        $menu='';
        $controllerarr=getAssignRightsControllerList();
        foreach ($assign_rights_list as $assign_right){
            $assign_rights_html.='<tr>';
            if($menu!=$assign_right->controller_name){ 
                $menu=$assign_right->controller_name;
                $rowspan='';
                if(isset($controllerarr[$menu]) && $controllerarr[$menu]){
                    $rowspan='rowspan="'.$controllerarr[$menu].'"';
                }
                $assign_rights_html.='<td '.$rowspan.' class="module_name_style">';
                if($assign_right->display_controller_name){
                    $assign_rights_html.=$assign_right->display_controller_name; 
                }else{
                    $assign_rights_html.=ucfirst($menu); 
                }
                $assign_rights_html.='</td>';
            }
            $assign_rights_html.='<td class="text-sm font-weight-400">';
            if($assign_right->display_name){
                $assign_rights_html.=$assign_right->display_name; 
            }else{
                $assign_rights_html.=ucwords(str_replace('_', ' ',$assign_right->method_name));
            }
            $checked='';
            if(isset($rights_arr) && $rights_arr && in_array($assign_right->id,$rights_arr)){ 
                $checked='checked'; 
            }
            $assign_rights_html.='</td><td><input class="assignrights" type="checkbox" name="rights[]" value="'.$assign_right->id.'" '.$checked.' onchange="updateAllcheck(this);" required data-msg-required="Note: Please select atleast one rights from below table."></td></tr>';
        }
    }else{
        $assign_rights_html.='<tr><td colspan="3">Sorry, No Section Available.</td></tr>';
    }
    return $assign_rights_html;
}
// function: checkAssignRights()
// It is used to check  Assign Rights
function checkAssignRights($controller,$method){
    $CI =& get_instance();
    $query=$CI->db->query("SELECT id FROM assign_rights_list WHERE controller_name='".$controller."' AND method_name='".$method."' AND is_active=1");
    // echo $CI->db->last_query();
    if($query->num_rows()>0){
        $userid=$CI->session->userdata('id');
        $row=$query->row();
        $role_id=$row->id;
        $result=checkAssignRightsForUser($userid,$role_id);
        if(!$result){
            $result=checkAssignRightsForRole($userid,$role_id);
        }
        return $result;
    }
    return true;
}
// function: checkAssignRightsForUser()
// It is used to check  Assign Rights for User
function checkAssignRightsForUser($userid,$role_id){
    $CI =& get_instance();
    $query=$CI->db->query("SELECT * FROM assign_rights_to_user WHERE user_id='".$userid."' AND FIND_IN_SET('".$role_id."', assign_rights_ids)");
    //echo $CI->db->last_query();
    if($query->num_rows()>0){
        return true;
    }
    return false;
}
// function: checkAssignRightsForRole()
// It is used to check  Assign Rights for role
function checkAssignRightsForRole($userid,$role_id){
    $CI =& get_instance();
    $query=$CI->db->query("SELECT * FROM assign_rights_to_role ar INNER JOIN users u ON ar.role_id=u.role_id WHERE u.id='".$userid."' AND FIND_IN_SET('".$role_id."', ar.assign_rights_ids)");
    // echo $CI->db->last_query();
    if($query->num_rows()>0){
        return true;
    }
    return false;
}
// function: upload_file()
// It is used to upload file into specify folder
function upload_file($attachment,$file_path,$valid_ext,$valid_size=''){
    $result=array();
    if(isset($attachment['name']) && is_array($attachment['name'])){
        for($i=0;$i<count($attachment['name']);$i++){
            if(!empty($attachment['name'][$i])){
                $filename_arr=explode(".",basename($attachment['name'][$i]));
                $ext=strtolower(end($filename_arr));
                if(!$valid_ext || in_array($ext,$valid_ext)){
                    //if($attachment < 500000) {
                        // $filename=time().'_'.unique().basename($attachment["name"][$i]);
                        $filename=time().'_'.uniqid().'.'.$ext;
                        $target_file = $file_path.$filename;
                        if(move_uploaded_file($attachment["tmp_name"][$i], $target_file)) {
                            $result['upload_file_names'][]=$filename;
                        }else{
                            $result['error']="Sorry, there was an error uploading file.";
                        }
                    //}else{
                       //$result['error']="Sorry, your file is too large.";
                    //}
                }else{
                    $str=implode(',',$valid_ext);
                    $result['error']='Sorry, only '.$str.' files are allowed.';
                }
            }else{
                $result['error']='Sorry, File not found. Please try again.';
            }
        }
    }else{
        if(!empty($attachment['name'])){
            $filename_arr=explode(".",basename($attachment['name']));
            $ext=strtolower(end($filename_arr));
            if(in_array($ext,$valid_ext)){
                //if($attachment < 500000) {
                    //$filename=time().'_'.basename($attachment["name"]);
                    $filename=time().'_'.uniqid().'.'.$ext;
                    $target_file = $file_path.$filename;
                    if(move_uploaded_file($attachment["tmp_name"], $target_file)) {
                        $result['filename']=$filename;
                    }else{
                        $result['error']="Sorry, there was an error uploading file.";
                    }
                //}else{
                   //$result['error']="Sorry, your file is too large.";
                //}
            }else{
                $str=implode(',',$valid_ext);
                $result['error']='Sorry, only '.$str.' files are allowed.';
            }
        }else{
            $result['error']='Sorry, File not found. Please try again.';
        }
    }
    return $result;
}
// function: getCategoryById()
// It is used to get category name by category id
function getCategoryById($category_id){
    $CI =& get_instance();
    $query=$CI->db->query("SELECT category_name FROM post_categories WHERE id='".$category_id."'");
    if($query->num_rows()>0){
        $row=$query->row();
        return $row->category_name;
    }
}
// function: getSharePostUploadFiles($share_post_id)
// It is used to get list of all upload files of share post by share post id
function getSharePostUploadFiles($share_post_id){
    $CI =& get_instance();
    $query=$CI->db->query("SELECT id, share_post_id, upload_file FROM share_post_upload_file WHERE share_post_id='".$share_post_id."' AND deleted_at IS NULL");
    if($query->num_rows()>0){
        return $query->result();
    }
}
// function: getSharePostUploadFileList($share_post_id)
// It is used to get list of all upload files of share post by share post id
function getSharePostUploadFileList($share_post_id){
    $CI =& get_instance();
    $query=$CI->db->query("SELECT * FROM share_post_upload_file WHERE share_post_id='".$share_post_id."' AND deleted_at IS NULL");
    if($query->num_rows()>0){
        return $query->result();
    }
}
// function: getDownloadCategoryById($category_id)
// It is used to get category name by category id
function getDownloadCategoryById($category_id){
    $CI =& get_instance();
    $query=$CI->db->query("SELECT download_category_name FROM download_categories WHERE id='".$category_id."'");
    if($query->num_rows()>0){
        $row=$query->row();
        return $row->download_category_name;
    }
}
// function: getDownloadManagementUploadFiles($download_management_id)
// It is used to get list of all upload files of download management by download management id
function getDownloadManagementUploadFiles($download_management_id){
    $CI =& get_instance();
    $query=$CI->db->query("SELECT id, download_management_id, upload_file FROM download_management_upload_file WHERE download_management_id='".$download_management_id."' AND deleted_at IS NULL");
    if($query->num_rows()>0){
        return $query->result();
    }
}
// function: getDownloadManagementUploadFileList($download_management_id)
// It is used to get list of all upload files of download management by download management id
function getDownloadManagementUploadFileList($download_management_id){
    $CI =& get_instance();
    $query=$CI->db->query("SELECT * FROM download_management_upload_file WHERE download_management_id='".$download_management_id."' AND deleted_at IS NULL");
    if($query->num_rows()>0){
        return $query->result();
    }
}
// function: getRandomCode()
// It is used to get random code
function getRandomCode(){
    $n=10;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }
    return $randomString;
}
// function: getEmailTemplateByTitle($title)
// It is used to get email template by title
function getEmailTemplateByTitle($title){
    $CI =& get_instance();
    $query=$CI->db->query("SELECT * FROM email_template WHERE title='".$title."' AND is_active=1");
    if($query->num_rows()>0){
        return $query->row();
    }
}
// function: check_token()
// It is used to check authorise token for login user
function check_token(){
    $CI =& get_instance();
    $auth_token = $CI->input->get_request_header("Authorization");
    $session_token = $CI->session->userdata('token');
    if($auth_token !== $session_token || !isset($auth_token)){
        //empty sesion...
        if(isset($_SESSION) && $_SESSION){
            $CI->session->sess_destroy();
        }
        return false;
        // echo json_encode(api_response("Invalid Token!", REST_Controller::HTTP_UNAUTHORIZED, false, "Invalid Token!"), true);
        // //empty sesion...
        // $CI->session->sess_destroy();
        // exit;
    }
    return true;
}
// function: sendMail($from_email,$to_email,$subject,$msg_content)
// It is used to send mail using parameter
function sendMail($from_email,$to_email,$subject,$msg_content){
    $CI =& get_instance();
    $config = Array(
       'protocol' => 'smtp',
       'smtp_host' => 'ssl://smtp.googlemail.com',
       'smtp_port' => 465,
       'smtp_user' => 'rekha.divineinfosys@gmail.com', 
       'smtp_pass' => 'rekha!@#123',
       'mailtype' => 'html',
       'charset' => 'iso-8859-1',
       'wordwrap' => TRUE
    );
    $CI->email->initialize($config);
    $CI->email->set_newline("\r\n");
    $CI->email->from($from_email); 
    $CI->email->to($to_email);
    $CI->email->subject($subject);
    $CI->email->message($msg_content);
    $mail=$CI->email->send();
    return $mail;
    /* if($CI->email->send()){
        echo 'Email sent.';
    }else{
        show_error($CI->email->print_debugger());
    } */
}
// function: getActiveStateList()
// It is used to fetch active and not deleted states from database
function getActiveStateList(){
    $CI =& get_instance();
    $query=$CI->db->query("SELECT id, state_name FROM states WHERE is_active=1 AND deleted_at IS NULL");
    if($query->num_rows()>0){
        return $query->result();
    }
}
// function: getActiveProgramList()
// It is used to fetch active program list from database
function getActiveProgramList(){
    $CI =& get_instance();
    $query=$CI->db->query("SELECT id, program_name FROM program_master WHERE is_active=1 AND deleted_at IS NULL");
    if($query->num_rows()>0){
        return $query->result();
    }
}
// function: getGroupTypeList()
// It is used to fetch list of all active group type
function getGroupTypeList(){
    $CI =& get_instance();
    $query=$CI->db->query("SELECT id, group_type_name FROM group_types WHERE is_active=1 AND deleted_at IS NULL");
    if($query->num_rows()>0){
        return $query->result();
    }
}
// function: getRoleList()
// It is used to fetch role list from database
function getRoleList(){
    $CI =& get_instance();
    $query=$CI->db->query("SELECT id, role_name FROM roles WHERE deleted_at IS NULL AND is_active=1");
    if($query->num_rows()>0){
        return $query->result();
    }
}
// function: getUserTypeList()
// It is used to fetch user type list from database
function getUserTypeList(){
    $CI =& get_instance();
    $query=$CI->db->query("SELECT id, user_type FROM user_types WHERE deleted_at IS NULL AND is_active=1");
    if($query->num_rows()>0){
        return $query->result();
    }
}
// function: getDDLOptionByRelatedFieldName($fieldname,$value)
// It is used to fetch DDL option list from related field name
function getDDLOptionByRelatedFieldName($fieldname,$value){
    // Get current CodeIgniter instance
    $CI =& get_instance();
    $option_list='';
    $tablename='';
    $condition='';
    if($fieldname=='batch_name'){
        $tablename='batch_master';
        $condition=" id='".$value."'";
    }else if($fieldname=='user_type'){
        $tablename='user_types';
        $condition=" id='".$value."'";
    }else if($fieldname=='session'){
        $tablename='sessionmanagement';
        $condition=" id='".$value."'";
    }else if($fieldname=='state'){
        $tablename='states';
        $condition=" id='".$value."'";
    }else if($fieldname=='district'){
        $tablename='districts';
        $condition=" id='".$value."'";
    }else if($fieldname=='villageorcity'){
        $tablename='city_town_villages';
        $condition=" id='".$value."'";
    }else if($fieldname=='villageorcity'){
        $tablename='city_town_villages';
        $condition=" id='".$value."'";
    }else if($fieldname=='which_first_program_did_you_attend_at_oasis'){
        $tablename='program_master';
        $condition=" id='".$value."'";
    }else if($fieldname=='qualities_observed'){
        $tablename='quality_data';
        $ids=implode("','",$value);
        $condition=" id IN('".$ids."')";
    }else if($fieldname=='next_level_program'){
        $tablename='program_master';
        $ids=implode("','",$value);
        $condition=" id IN('".$ids."')";
    }else if($fieldname=='next_level_role'){
        $tablename='roles';
        $ids=implode("','",$value);
        $condition=" id IN('".$ids."')";
    }
    if($tablename){
        $query=$CI->db->query("SELECT * FROM ".$tablename." WHERE ".$condition);
        if($query->num_rows()>0){
            if(is_array($value)){
                $result=$query->result();
                $colname='';
                if($fieldname=='qualities_observed'){
                    $colname='quality_name';
                }else if($fieldname=='next_level_program'){
                    $colname='program_name';
                }else if($fieldname=='next_level_role'){
                    $colname='role_name';
                }
                if($colname){
                   foreach($result as $r){
                        if($option_list){
                            $option_list.=', ';
                        }
                        $option_list.=$r->$colname;
                    } 
                }
            }else{
                $row=$query->row();
                if($fieldname=='batch_name'){
                    $option_list=$row->batch_name;
                }else if($fieldname=='user_type'){
                    $option_list=$row->user_type;
                }else if($fieldname=='session'){
                    $option_list=$row->session_name;
                }else if($fieldname=='state'){
                    $option_list=$row->state_name;
                }else if($fieldname=='district'){
                    $option_list=$row->district_name;
                }else if($fieldname=='villageorcity'){
                    $option_list=$row->village_name;
                }else if($fieldname=='which_first_program_did_you_attend_at_oasis'){
                    $option_list=$row->program_name;
                }
            }
        }
        if($option_list==''){
            $option_list='N/A';
        }
        return $option_list;
    }
}
?>
<?php
require APPPATH . '/libraries/CreatorJwt.php';

class JwtToken extends CI_Controller
{
    public function __construct()
    {        
        //parent::__construct();
        $this->objOfJwt = new CreatorJwt();
        header('Content-Type: application/json');
    }

    /*************Ganerate token this function use**************/
    public function JwtTokenGenerate($user_id, $first_name, $last_name, $email)
    {
        $tokenData['user_id'] = $user_id;
       // $tokenData['role'] = $role;
		$tokenData['first_name'] = $first_name;
        $tokenData['last_name'] = $last_name;
        $tokenData['email'] = $email;
        $tokenData['timeStamp'] = Date('Y-m-d h:i:s');
        $jwtToken = $this->objOfJwt->GenerateToken($tokenData);
        //echo json_encode(array('Token'=>$jwtToken));
		return $jwtToken;
    }
     
   /*************Use for token then fetch the data**************/
    public function GetTokenData($received_Token){
        try{
            $jwtData = $this->objOfJwt->DecodeToken($received_Token['Authorization']);
            return $jwtData;
            //echo json_encode($jwtData);
        }
        catch (Exception $e){
            http_response_code('401');
            echo json_encode(array( "status" => false, "message" => $e->getMessage()));exit;
        }
    }
}
        
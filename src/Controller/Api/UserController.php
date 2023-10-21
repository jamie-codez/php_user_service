<?php
class UserController extends BaseController{
    /**
     * Get all users with pagination
     */
    public function getUsers(){
        $strErrorDescription = "";
        $strErrorHeader="";
        $responseData=array();
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $queryParams = $this->getQueryParams();
        if (strtoupper($requestMethod)=="GET"){
            try {
                $userModel = new UserModel();
                $initLimit = 10;
                if (isset($queryParams["limit"]) && $queryParams["limit"]){
                    $initLimit = $queryParams["limit"];
                }
                $arrUsers = $userModel->getUsers($initLimit);
                $responseData = json_encode($arrUsers);
            }catch (Exception $exception){
                $strErrorDescription = $exception->getMessage()." Something went wrong";
                $strErrorHeader = "HTTP/1.1 500 Internal Server Error";
            }
        }else{
            $strErrorDescription = "Method nor supported";
            $strErrorHeader = "HTTP/1.1 422 Unprocessable Entity";
        }
        // Send output
        if (!$strErrorDescription){
            $this->sendOutput(
                $responseData,
                array("Content-Type: application/json","HTTP/1.1 200 OK")
            );
        }else{
            $this->sendOutput(
                json_encode(array("error"=>$strErrorDescription)),
                array("Content-Type: application/json",$strErrorHeader)
            );
        }
    }
}
<?php
//echo phpinfo();
class BaseController{
    /**
     * @param $name
     * @param $arguments
     * @return void
     * The call magic method call when called absent method
     */
    public function __call($name,$arguments){
        $this->sendOutput("",array("HTTP/1.1 404 Not Found"));
    }

    /**
     * @return array
     * Get URI elements
     */
    protected function getUriSegments(){
        $uri = parse_url($_SERVER["REQUEST_URI"],PHP_URL_PATH);
        return explode("/",$uri);
    }

    /**
     * @return array
     * Gets query params
     */
    protected function getQueryParams(){
        $query = array();
        return parse_url($_SERVER["QUERY_STRING"],$query);
    }

    /**
     * Sends API output
     * @param mixed $data
     * @param array $httpHeaders
     */
    protected function sendOutput($data, $httpHeaders=array()){
        header_remove("Set-Cookie");
        if (is_array($httpHeaders) && count($httpHeaders)){
            foreach ($httpHeaders as $httpHeader){
                header($httpHeader);
            }
        }
        echo $data;
        exit();
    }

}

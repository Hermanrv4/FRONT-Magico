<?php


namespace App\Http\Common\Responses;


class ApiResponse{
    public $status;
    public $message;
    public $response;
    public $msg_default_error="";
    public $msg_default_success="";

    public function __construct($status=0,$message="",$response=array()) {
        $this->status = $status;
        $this->message = $message;
        $this->response = $response;

        $this->msg_response='app/response.message.';
        $this->msg_default_error=$this->msg_response.config('app.value.result.message.value.default_error');
        $this->msg_default_success=$this->msg_response.config('app.value.result.message.value.default_success');
    }
    public static function ParseResponse($response){
        
        $response = json_decode($response, true);
        return (new ApiResponse(
            $response[config('app.value.result.status.key')]
            ,$response[config('app.value.result.message.key')]
            ,$response[config('app.value.result.response.key')]));
    }
    public function SendResponse($is_ok,$message,$response){
        $response = array(
            config('app.value.result.status.key') => ($is_ok?config('app.value.result.status.value.success'):config('app.value.result.status.value.error')),
            config('app.value.result.message.key') => ($message==null?trans($is_ok?$this->msg_default_success:$this->msg_default_error):$message),
            config('app.value.result.response.key') => ($response==null?config('app.value.result.response.value.default'):$response),
        );
        return response()->json($response, 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],JSON_UNESCAPED_UNICODE);
    }
    public static function SendSuccessResponse($message=null,$response=null){
        return (new ApiResponse())->SendResponse(true,$message,$response);
    }
    public static function SendErrorResponse($message=null,$response=null,$locale=null){
        return (new ApiResponse())->SendResponse(false,$message,$response);
    }
}

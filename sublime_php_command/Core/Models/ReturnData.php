<?php 
	namespace Chigi\Sublime\Models;

	use Chigi\Sublime\Settings\Environment;
	
	class ReturnData {
		public function __construct(){
		}
		protected $code;
		public function getCode(){
			return $this->code;
		}
		public function setCode($code){
			$this->code=$code;
			return $this;
		}
		protected $status_message;
		public function getStatusMsg(){
			return $this->status_message;
		}
		public function setStatusMsg($msg){
			$this->status_message=$msg;
			return $this;
		}
		protected $msg;
		public function getMsg(){
			return $this->msg;
		}
		public function setMsg($msg){
			$this->msg=$msg;
			return $this;
		}
		protected $data;
		public function getData(){
			return $this->data;
		}
		public function setData($data){
			$this->data=$data;
			return $this;
		}
		public function getJSON() {
			$return_arr = array(
				'code'=>$this->code,
				'status_message'=>$this->status_message,
				'msg'=>$this->msg,
				'data'=>$this->data
			);
			return json_encode($return_arr);
    		}
	}
?>
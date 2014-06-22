<?php

namespace Chigi\Sublime\Models;

/**
 * 返回值数据抽象对象
 */
class ReturnData {

    public function __construct() {
        
    }

    /**
     * 结果代码
     * @var int
     */
    protected $code;

    /**
     * 获得结果码
     * @return int
     */
    public function getCode() {
        return $this->code;
    }

    public function setCode($code) {
        $this->code = $code;
        return $this;
    }

    /**
     * 状态栏显示字符串
     * @var string
     */
    protected $status_message;

    /**
     * 获得状态栏显示用字符串
     * @return string
     */
    public function getStatusMsg() {
        return $this->status_message;
    }

    public function setStatusMsg($msg) {
        $this->status_message = $msg;
        return $this;
    }

    /**
     * 开发者信息
     * @var string
     */
    protected $msg;

    /**
     * 获得开发者信息
     * @return string
     */
    public function getMsg() {
        return $this->msg;
    }

    public function setMsg($msg) {
        $this->msg = $msg;
        return $this;
    }

    /**
     * 原始数据
     * @var mixed
     */
    protected $data;

    /**
     * 获取原始数据
     * @return mixed
     */
    public function getData() {
        return $this->data;
    }

    public function setData($data) {
        $this->data = $data;
        return $this;
    }

    /**
     * 获取JSON格式字符串
     * @return string
     */
    public function getJSON() {
        $return_arr = array(
            'code' => $this->code,
            'status_message' => $this->status_message,
            'msg' => $this->msg,
            'data' => $this->data
        );
        return json_encode($return_arr);
    }
    
    /**
     * 判断当前返回数据是否2XX
     * @return boolean
     */
    public function isValid() {
        return ($this->code < 300 && $this->code >= 200);
    }

}

?>
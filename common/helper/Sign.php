<?php
namespace common\helper;

class Sign
{
    protected $type;

    public function __construct($type = 'md5')
    {
        $this->type = $type;
    }

    //根据用户提交的加密方式自动选择对应的方法，后续改成每种加密方式单独一个类
    public function encrypt($lData, $oqUser)
    {
        $typeName = 'encrypt' . ucfirst($this->type);
        return $this->$typeName($lData, $oqUser);
    }

    public function verify($sign, $lData, $oqUser)
    {
        $typeName = 'verify' . ucfirst($this->type);
        return $this->$typeName($sign, $lData, $oqUser);
    }

    protected function encryptMd5($lData, $oqUser)
    {
        ksort($lData);
        $signString = '';
        foreach($lData as $k => $v){
            if($v !== ''){
            $signString .= $k . '=' . $v . '&';
            }
        }
        return strtolower(md5($signString . 'key='. $oqUser->pay_md5_key));
    }

    protected function verifyMd5($sign, $lData, $oqUser)
    {
        return $this->encryptMd5($lData, $oqUser) === $sign;
    }
}
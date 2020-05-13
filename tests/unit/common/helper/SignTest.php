<?php
namespace common\helper;

use common\helper\Sign;
use common\models\User;

class SignTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected $user_id = 1;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testMd5()
    {
        $lData = ['money'=>100, 'order_id'=>1234567890];
        $oqUser = User::findOne($this->user_id);
        $ohSign = new Sign('md5');
        $result = $ohSign->verify($ohSign->encrypt($lData, $oqUser), $lData, $oqUser);
        $this->assertTrue($result, 'md5验签不通过');
    }
}
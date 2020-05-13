<?php
namespace common\helper;
use common\helper\ErrorCode;

class ErrorCodeTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testExplain()
    {
        $this->assertEquals(ErrorCode::explain(ErrorCode::SYSTEM_ERR), '系统错误！！！', '错误码解析错误');
        $this->assertEquals(ErrorCode::explain(ErrorCode::NOT_FOUND_ERR), '找不到对应的接口','错误码解析错误2');
        $this->assertEquals(ErrorCode::explain(ErrorCode::PAYMENT_FORM_ERR), '请求格式错误','错误码解析错误3');
        $this->assertNotEquals(ErrorCode::explain(ErrorCode::CHANNEL_FILE_ERR), '','错误码解析错误4');
        $this->assertEquals(ErrorCode::explain(99999), '','错误码解析错误5');
    }
}
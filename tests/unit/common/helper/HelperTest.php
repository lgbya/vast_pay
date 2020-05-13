<?php
namespace common\helper;

use common\helper\Helper;

class HelperTest extends \Codeception\Test\Unit
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

    public function testShowJsonSuccess()
    {
        $lJson = Helper::showJsonSuccess();
//        codecept_debug($lJson);
        $this->assertEquals($lJson['error'], 0, '成功非零');
        $this->assertEquals($lJson['message'], 'success', '成功非success');
        $this->assertEquals($lJson['data'], [], '成功非空');

        $lJson = Helper::showJsonSuccess(['extra'=>'ok']);
        $this->assertEquals($lJson['error'], 0, '成功非零');
        $this->assertEquals($lJson['data']['extra'], 'ok', 'data扩展消息错误');

    }

    public function testShowJsonError()
    {
        $errCode = ErrorCode::CHANNEL_ACCOUNT_NOT_FOUNT;
        $lJson = Helper::showJsonError($errCode);
//        codecept_debug($lJson);
        $this->assertEquals($lJson['error'], $errCode, '错误码无效');
        $this->assertEquals($lJson['message'], ErrorCode::explain($errCode), '错误提示无效');
        $this->assertEquals($lJson['data'], [], '失败非空');

        $lJson = Helper::showJsonError($errCode, '',['extra'=>'fail']);
        $this->assertEquals($lJson['error'], $errCode, '错误码无效2');
        $this->assertEquals($lJson['message'], ErrorCode::explain($errCode), '错误提示无效2');
        $this->assertEquals($lJson['data']['extra'], 'fail', 'data扩展消息错误2');

        $lJson = Helper::showJsonError(2333);
//        codecept_debug($lJson);
        $this->assertEquals($lJson['message'], '', '错误提示无效3');
    }

    public function testCuttingDateRange()
    {
        $dateStr = '2000-12-16到2001-12-16';
        $lTime = Helper::cuttingDateRange($dateStr);
        $this->assertEquals(count($lTime), 2, '无法产生两个时间戳');
        $this->assertEquals(date('Y-m-d',$lTime[0]), '2000-12-16', '第一时间戳生成错误！！！');
        $this->assertEquals(date('Y-m-d',$lTime[1]), '2001-12-16', '第二时间戳生成错误！！！');

        $dateStr = '2000-12-16=2001-12-16';
        $lTime = Helper::cuttingDateRange($dateStr, '=');
        $this->assertEquals(count($lTime), 2, '无法产生两个时间戳2');
        $this->assertEquals(date('Y-m-d',$lTime[0]), '2000-12-16', '第一时间戳生成错误2！！！');
        $this->assertEquals(date('Y-m-d',$lTime[1]), '2001-12-16', '第二时间戳生成错误2！！！');

        $dateStr = '2000-12-16-2001-12-16';
        $lTime = Helper::cuttingDateRange($dateStr, '-');
        $this->assertNotEquals(count($lTime), 2, '不是唯一标识符也切割两个时间戳');
    }

    public function testFormatMoney()
    {
        $this->assertEquals(Helper::formatMoney(1),   '￥0.010', '金额不符合');
        $this->assertEquals(Helper::formatMoney(1000),   '￥10.000', '金额不符合2');
        $this->assertEquals(Helper::formatMoney(0),   '￥0.000', '金额不符合3');
        $this->assertEquals(Helper::formatMoney(-1000),   '￥-10.000', '金额不符合4');
        $this->assertEquals(Helper::formatMoney(-0),   '￥0.000', '金额不符合5');
        $this->assertEquals(Helper::formatMoney(-0.01),   '￥-0.000', '金额不符合6');
        $this->assertEquals(Helper::formatMoney(-0.01, 4),   '￥-0.0001', '金额不符合8');
    }

    public function testCountWeight()
    {
        $lsData = [['id'=>1, 'weight'=>50],['id'=>2, 'weight'=>50]];
        $lData = Helper::countWeight($lsData);
        $this->assertIsNumeric($lData['id'], '权重无法筛选1');

        $lsData = [['id'=>1, 'weight'=>100],['id'=>2, 'weight'=>0]];
        $lData = Helper::countWeight($lsData);
        $this->assertEquals($lData['id'], 1,'权重无法筛选2');

        $lsData = [['id'=>1, 'weight'=>-2],['id'=>2, 'weight'=>1]];
        $lData = Helper::countWeight($lsData);
        $this->assertEquals($lData['id'], 2,'权重无法筛选3');

        $lsData = [['id'=>1, 'weight'=>-2],['id'=>2, 'weight'=>-1]];
        $lData = Helper::countWeight($lsData);
        $this->assertEquals($lData, [],'权重无法筛选4');
    }

    public function testCreateForm()
    {
        $url = 'http://www.bbb.com';
        $lData = ['money'=>'100', 'order_id'=>'123456',];
        $formStr = "<form action=\"{$url}\" method=\"post\"><input type=\"hidden\" name=\"money\" value=\"{$lData['money']}\"><input type=\"hidden\" name=\"order_id\" value=\"{$lData['order_id']}\"></form>";
        $formStr2 = Helper::createForm($url, $lData);
        $this->assertEquals($formStr,   $formStr2, 'form表单生成失败');
    }

    public function testJoinToUppercase()
    {
        $this->assertEquals(Helper::joinToUppercase('AbcDef'),   'abc-def', '生成连接格式错误');
        $this->assertEquals(Helper::joinToUppercase('Lgbya'),   'lgbya', '生成连接格式错误2');
        $this->assertEquals(Helper::joinToUppercase('ABCD'),   'a-b-c-d', '生成连接格式错误3');
        $this->assertEquals(Helper::joinToUppercase('ABCD', '到'),   'a到b到c到d', '生成连接格式错误3');
        $this->assertEquals(Helper::joinToUppercase(''),   '', '生成连接格式错误4');
    }

    public function testRestoreUppercase()
    {
        $this->assertEquals(Helper::restoreUppercase('abc-def'),   'AbcDef', '还原格式错误');
        $this->assertEquals(Helper::restoreUppercase('lgbya'),   'Lgbya', '还原格式错误2');
        $this->assertEquals(Helper::restoreUppercase('a-b-c-d'),   'ABCD', '还原格式错误3');
        $this->assertEquals(Helper::restoreUppercase('a到b到c到d','到'),   'ABCD', '还原格式错误4');
        $this->assertEquals(Helper::restoreUppercase(''),   '', '还原格式错误5');
    }
}
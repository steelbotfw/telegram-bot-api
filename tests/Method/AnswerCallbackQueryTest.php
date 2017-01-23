<?php

namespace Steelbot\Tests\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\Method\AnswerCallbackQuery;

class AnswerCallbackQueryTest extends \PHPUnit_Framework_TestCase
{
    public function testGetParams()
    {
        $method = new AnswerCallbackQuery(123);

        $params = $method->getParams();

        $this->assertArrayHasKey('callback_query_id', $params);
        $this->assertEquals(123, $params['callback_query_id']);
        $this->assertArrayNotHasKey('show_alert', $params);
        $this->assertArrayNotHasKey('cache_time', $params);

        $method->setShowAlert(true);
        $method->setCacheTime(42);
        $params = $method->getParams();

        $this->assertArrayHasKey('show_alert', $params);
        $this->assertEquals(1, $params['show_alert']);
        $this->assertEquals(42, $params['cache_time']);
    }

    public function testBuildResult()
    {
        $method = new AnswerCallbackQuery(123);

        $result = $method->buildResult(true);

        $this->assertTrue($result);
    }

    public function testJsonSerialize()
    {
        $method = new AnswerCallbackQuery(123);
        $method->setText('Callback text');
        $method->setUrl('http://url');

        $json = [
            'text' => 'Callback text',
            'url' => 'http://url'
        ];
        $json = json_encode($json, JSON_UNESCAPED_UNICODE);

        $this->assertJsonStringEqualsJsonString($json, json_encode($method, JSON_UNESCAPED_UNICODE));
    }

    public function testGetHttpMethod()
    {
        $method = new AnswerCallbackQuery(123);

        $this->assertEquals(AnswerCallbackQuery::HTTP_POST, $method->getHttpMethod());
    }

    public function testGetMethodName()
    {
        $method = new AnswerCallbackQuery(123);

        $this->assertEquals('answerCallbackQuery', $method->getMethodName());
    }

    public function testGetSetCallbackQueryId()
    {
        $method = new AnswerCallbackQuery(123);

        $this->assertEquals(123, $method->getCallbackQueryId());

        $method->setCallbackQueryId(111);

        $this->assertEquals(111, $method->getCallbackQueryId());
    }


    public function testGetSetText()
    {
        $method = new AnswerCallbackQuery(123);

        $this->assertNull($method->getText());

        $method->setText('Callback text');

        $this->assertEquals('Callback text', $method->getText());
    }

    public function testGetSetShowAlert()
    {
        $method = new AnswerCallbackQuery(123);

        $this->assertNull($method->getShowAlert());

        $method->setShowAlert(true);

        $this->assertTrue($method->getShowAlert());
    }

    public function testGetSetUrl()
    {
        $method = new AnswerCallbackQuery(123);

        $this->assertNull($method->getUrl());

        $method->setUrl('http://url');

        $this->assertEquals('http://url', $method->getUrl());
    }

    public function testGetSetCacheTime()
    {
        $method = new AnswerCallbackQuery(123);

        $this->assertNull($method->getCacheTime());

        $method->setCacheTime(42);

        $this->assertEquals(42, $method->getCacheTime());
    }
}

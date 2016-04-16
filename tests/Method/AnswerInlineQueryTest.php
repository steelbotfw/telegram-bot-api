<?php

namespace Steelbot\Tests\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\InlineQueryResult\InlineQueryResultArticle;
use Steelbot\TelegramBotApi\Method\AnswerInlineQuery;

class AnswerInlineQueryTest extends \PHPUnit_Framework_TestCase
{
    public function testGetParams()
    {
        $method = new AnswerInlineQuery(123, []);
        $method->setCacheTime(20)
               ->setIsPersonal(true)
               ->setNextOffset('abc');

        $params = $method->getParams();

        $this->assertArrayHasKey('cache_time', $params);
        $this->assertEquals(20, $params['cache_time']);
        $this->assertArrayHasKey('is_personal', $params);
        $this->assertEquals('1', $params['is_personal']);
        $this->assertArrayHasKey('next_offset', $params);
        $this->assertEquals('abc', $params['next_offset']);
    }

    public function testBuildResult()
    {
        $method = new AnswerInlineQuery(123, []);

        $result = $method->buildResult(true);

        $this->assertTrue($result);
    }

    public function testJsonSerialize()
    {
        $result1 = new InlineQueryResultArticle('steelbot123', 'Test article', 'Text');

        $method = new AnswerInlineQuery(123, [$result1]);

        $json = [
            'results' => [
                [
                    'type' => 'article',
                    'id' => 'steelbot123',
                    'title' => 'Test article',
                    'message_text' => 'Text'
                ]
            ]
        ];
        $json = json_encode($json, JSON_UNESCAPED_UNICODE);

        $this->assertEquals($json, json_encode($method, JSON_UNESCAPED_UNICODE));
    }

    public function testGetHttpMethod()
    {
        $method = new AnswerInlineQuery(123, []);

        $this->assertEquals(AnswerInlineQuery::HTTP_POST, $method->getHttpMethod());
    }

    public function testGetMethodName()
    {
        $method = new AnswerInlineQuery(123, []);

        $this->assertEquals('answerInlineQuery', $method->getMethodName());
    }

    public function testGetSetInlineQueryId()
    {
        $method = new AnswerInlineQuery(123, []);

        $this->assertEquals(123, $method->getInlineQueryId());

        $method->setInlineQueryId(111);

        $this->assertEquals(111, $method->getInlineQueryId());
    }

    public function testGetSetNextOffset()
    {
        $method = new AnswerInlineQuery(123, []);

        $this->assertNull($method->getNextOffset());

        $method->setNextOffset('aabbcc');

        $this->assertEquals('aabbcc', $method->getNextOffset());
    }

    public function testGetSetResults()
    {
        $result1 = new InlineQueryResultArticle('steelbot123', 'Test article', 'Text');

        $method = new AnswerInlineQuery(123, []);

        $this->assertEmpty($method->getResults());

        $method->setResults([$result1]);

        $this->assertCount(1, $method->getResults());
        $this->assertContains($result1, $method->getResults());
    }

    public function testGetSetSwitchPmText()
    {
        $method = new AnswerInlineQuery(123, []);

        $this->assertNull($method->getSwitchPmText());

        $method->setSwitchPmText('pm text');

        $this->assertEquals('pm text', $method->getSwitchPmText());
    }

    public function testGetSetSwitchPmParameter()
    {
        $method = new AnswerInlineQuery(123, []);

        $this->assertNull($method->getSwitchPmParameter());

        $method->setSwitchPmParameter('pm parameter');

        $this->assertEquals('pm parameter', $method->getSwitchPmParameter());
    }
}

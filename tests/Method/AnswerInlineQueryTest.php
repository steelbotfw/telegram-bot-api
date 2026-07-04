<?php

namespace Steelbot\Tests\TelegramBotApi\Method;

use PHPUnit\Framework\TestCase;
use Steelbot\TelegramBotApi\InlineQueryResult\InlineQueryResultArticle;
use Steelbot\TelegramBotApi\InputMessageContent\InputTextMessageContent;
use Steelbot\TelegramBotApi\Method\AnswerInlineQuery;
use Steelbot\TelegramBotApi\Method\HttpMethod;

class AnswerInlineQueryTest extends TestCase
{
    public function testGetParams()
    {
        $method = new AnswerInlineQuery(123, []);
        $method->setCacheTime(20)
               ->setIsPersonal(true)
               ->setNextOffset('abc');

        $params = $method->getParams();

        $this->assertSame([], $params);
    }

    public function testBuildResult()
    {
        $method = new AnswerInlineQuery(123, []);

        $result = $method->buildResult(true);

        $this->assertTrue($result);
    }

    public function testJsonSerialize()
    {
        $inputMessageContent = new InputTextMessageContent('Text');
        $result1 = new InlineQueryResultArticle('steelbot123', 'Test article', $inputMessageContent);

        $method = new AnswerInlineQuery(123, [$result1]);
        $method->setSwitchPmText('switchPmText')
            ->setSwitchPmParameter('switchPmParameter')
            ->setCacheTime(20)
            ->setIsPersonal(true)
            ->setNextOffset('abc');

        $json = [
            'inline_query_id' => 123,
            'results' => [
                [
                    'type' => 'article',
                    'id' => 'steelbot123',
                    'title' => 'Test article',
                    'input_message_content' => [
                        'message_text' => 'Text'
                    ]
                ]
            ],
            'cache_time' => 20,
            'is_personal' => true,
            'next_offset' => 'abc',
            'switch_pm_parameter' => 'switchPmParameter',
            'switch_pm_text' => 'switchPmText'
        ];
        $json = json_encode($json, JSON_UNESCAPED_UNICODE);

        $this->assertJsonStringEqualsJsonString($json, json_encode($method, JSON_UNESCAPED_UNICODE));
    }

    public function testGetHttpMethod()
    {
        $method = new AnswerInlineQuery(123, []);

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
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
        $inputMessageContent = new InputTextMessageContent('Text');
        $result1 = new InlineQueryResultArticle('steelbot123', 'Test article', $inputMessageContent);

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

        $this->assertInstanceOf(AnswerInlineQuery::class, $method->setSwitchPmText('pm text'));

        $this->assertEquals('pm text', $method->getSwitchPmText());
    }

    public function testGetSetSwitchPmParameter()
    {
        $method = new AnswerInlineQuery(123, []);

        $this->assertNull($method->getSwitchPmParameter());

        $this->assertInstanceOf(AnswerInlineQuery::class,
            $method->setSwitchPmParameter('pm parameter')
        );

        $this->assertEquals('pm parameter', $method->getSwitchPmParameter());
    }
}

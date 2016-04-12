<?php

namespace Steelbot\Tests\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\Method\AbstractMethod;
use Steelbot\TelegramBotApi\Method\GetFile;
use Steelbot\TelegramBotApi\Type\File;

class GetFileTest extends \PHPUnit_Framework_TestCase
{
    public function testGetMethodName()
    {
        $method = new GetFile(1);

        $this->assertEquals('getFile', $method->getMethodName());
    }

    public function testGetHttpMethod()
    {
        $method = new GetFile(1);

        $this->assertEquals(AbstractMethod::HTTP_GET, $method->getHttpMethod());
    }

    public function testGetParams()
    {
        $method = new GetFile(1);

        $params = [
            'file_id' => 1
        ];
        $this->assertEquals($params, $method->getParams());
    }

    /**
     * @dataProvider buildResultDataProvider
     */
    public function testBuildResult($result)
    {
        $method = new GetFile(1);

        $file = $method->buildResult($result);

        $this->assertInstanceOf(File::class, $file);
        $this->assertEquals($file->fileId, 1);
    }

    public function buildResultDataProvider(): array
    {
        $file = [
            'file_id' => 1,
            'file_size' => '123',
            'file_path' => 'file_path.jpg',
        ];

        return [
            [$file]
        ];
    }
}

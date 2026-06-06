<?php

namespace Steelbot\Tests\TelegramBotApi;

use Amp\ByteStream\InMemoryStream;
use Amp\CancellationToken;
use Amp\Http\Client\DelegateHttpClient;
use Amp\Http\Client\HttpClient;
use Amp\Http\Client\Request;
use Amp\Http\Client\Response;
use Amp\Promise;
use Amp\Success;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Steelbot\TelegramBotApi\Api;
use Steelbot\TelegramBotApi\Exception\TelegramBotApiException;
use Steelbot\TelegramBotApi\Method\AbstractMethod;
use Steelbot\TelegramBotApi\Type\Update;
use Steelbot\Tests\TelegramBotApi\Stub\AbstractMethodWithBodyStub;
use function Amp\ByteStream\buffer;
use function Amp\Promise\wait;

class ApiTest extends TestCase
{
    private const TELEGRAM_TOKEN = '12345:telegram-token';

    /** @var DelegateHttpClient&MockObject */
    private $httpClientDelegate;

    private HttpClient $httpClient;

    protected function setUp(): void
    {
        $this->httpClientDelegate = $this->createMock(DelegateHttpClient::class);
        $this->httpClient = new HttpClient($this->httpClientDelegate);
    }

    public function testExecuteOk(): void
    {
        $method = $this->createMock(AbstractMethod::class);
        $method->expects(self::once())->method('getMethodName')->willReturn('someMethod');
        $method->expects(self::once())->method('getHttpMethod')->willReturn(AbstractMethod::HTTP_GET);
        $method->expects(self::once())->method('getParams')->willReturn([
            'param1' => 'value1',
            'param2' => 'value2',
        ]);
        $method->expects(self::once())->method('buildResult')->with('result')->willReturn('result');

        $this->setUpHttpClient(
            ['ok' => true, 'result' => 'result'],
            static function (Request $request): void {
                self::assertSame('GET', $request->getMethod());
                self::assertSame(
                    'https://api.telegram.org/bot12345:telegram-token/someMethod'
                    . '?param1=value1&param2=value2',
                    (string) $request->getUri()
                );
            }
        );

        $result = wait((new Api(self::TELEGRAM_TOKEN, $this->httpClient))->execute($method));

        self::assertSame('result', $result);
    }

    public function testExecuteThrowsTelegramApiException(): void
    {
        $method = $this->createMock(AbstractMethod::class);
        $method->expects(self::once())->method('getMethodName')->willReturn('someMethod');
        $method->expects(self::once())->method('getHttpMethod')->willReturn(AbstractMethod::HTTP_GET);
        $method->expects(self::once())->method('getParams')->willReturn([]);
        $method->expects(self::never())->method('buildResult');

        $this->setUpHttpClient([
            'ok' => false,
            'description' => 'Error description',
            'error_code' => 42,
            'parameters' => ['retry_after' => 10],
        ]);

        try {
            wait((new Api(self::TELEGRAM_TOKEN, $this->httpClient))->execute($method));
            self::fail('Expected TelegramBotApiException was not thrown');
        } catch (TelegramBotApiException $exception) {
            self::assertSame('Error description', $exception->getMessage());
            self::assertSame(42, $exception->getCode());
            self::assertNotNull($exception->getParameters());
            self::assertSame(10, $exception->getParameters()->retryAfter);
        }
    }

    public function testExecuteWithJsonBody(): void
    {
        $requestBody = [
            'jsonParam1' => 'jsonValue1',
            'jsonParam2' => 'jsonValue2',
        ];
        $encodedRequestBody = json_encode($requestBody, JSON_THROW_ON_ERROR);
        $capturedRequest = null;

        $method = $this->createMock(AbstractMethodWithBodyStub::class);
        $method->expects(self::once())->method('getMethodName')->willReturn('someMethod');
        $method->expects(self::once())->method('getHttpMethod')->willReturn(AbstractMethod::HTTP_POST);
        $method->expects(self::once())->method('getParams')->willReturn(['param1' => 'value1']);
        $method->expects(self::once())->method('buildResult')->with('result')->willReturn('result');
        $method->expects(self::once())->method('jsonSerialize')->willReturn($requestBody);

        $this->setUpHttpClient(
            ['ok' => true, 'result' => 'result'],
            static function (Request $request) use (&$capturedRequest, $encodedRequestBody): void {
                $capturedRequest = $request;
                self::assertSame('POST', $request->getMethod());
                self::assertSame(
                    'https://api.telegram.org/bot12345:telegram-token/someMethod?param1=value1',
                    (string) $request->getUri()
                );
                self::assertSame('application/json', $request->getHeader('content-type'));
                self::assertSame((string) strlen($encodedRequestBody), $request->getHeader('content-length'));
            }
        );

        $result = wait((new Api(self::TELEGRAM_TOKEN, $this->httpClient))->execute($method));

        self::assertSame('result', $result);
        self::assertInstanceOf(Request::class, $capturedRequest);
        self::assertSame($encodedRequestBody, wait(buffer($capturedRequest->getBody()->createBodyStream())));
    }

    public function testGetUpdatesReturnsUpdateObjects(): void
    {
        $this->setUpHttpClient(
            [
                'ok' => true,
                'result' => [
                    ['update_id' => 42],
                    ['update_id' => 43],
                ],
            ],
            static function (Request $request): void {
                self::assertSame(
                    'https://api.telegram.org/bot12345:telegram-token/getUpdates'
                    . '?offset=2&limit=5&timeout=30',
                    (string) $request->getUri()
                );
            }
        );

        $updates = wait((new Api(self::TELEGRAM_TOKEN, $this->httpClient))->getUpdates(1));

        self::assertCount(2, $updates);
        self::assertContainsOnlyInstancesOf(Update::class, $updates);
        self::assertSame(42, $updates[0]->updateId);
        self::assertSame(43, $updates[1]->updateId);
    }

    /**
     * @param callable(Request): void|null $requestAssertion
     */
    private function setUpHttpClient(array $responseData, ?callable $requestAssertion = null): void
    {
        $this->httpClientDelegate
            ->expects(self::once())
            ->method('request')
            ->willReturnCallback(
                static function (
                    Request $request,
                    CancellationToken $cancellation
                ) use ($responseData, $requestAssertion): Promise {
                    if ($requestAssertion !== null) {
                        $requestAssertion($request);
                    }

                    return new Success(new Response(
                        '1.1',
                        200,
                        null,
                        ['content-type' => 'application/json'],
                        new InMemoryStream(json_encode($responseData, JSON_THROW_ON_ERROR)),
                        $request
                    ));
                }
            );
    }
}

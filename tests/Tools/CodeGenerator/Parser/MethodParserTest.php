<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Tests\Tools\CodeGenerator\Parser;

use Dom\HTMLDocument;
use PHPUnit\Framework\TestCase;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\BotApiDefinition;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\SectionDefinition;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Parser\MethodParser;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Parser\ParserHelper;

class MethodParserTest extends TestCase
{
    public function testParse_WithParameterTableAndReturnDescription_ReturnsMethodDefinition(): void
    {
        $document = HTMLDocument::createFromString(<<<'HTML'
<!doctype html>
<html>
<body>
<h4><a name="sendmessage"></a>sendMessage</h4>
<p>Use this method to send text messages. Returns the sent <a href="#message">Message</a>.</p>
<table>
<thead>
<tr><th>Parameter</th><th>Type</th><th>Required</th><th>Description</th></tr>
</thead>
<tbody>
<tr><td>chat_id</td><td>Integer</td><td>Yes</td><td>Unique identifier for the target chat</td></tr>
<tr><td>text</td><td>String</td><td>Yes</td><td>Text of the message to be sent</td></tr>
<tr><td>disable_notification</td><td>Boolean</td><td>No</td><td>Sends the message silently</td></tr>
</tbody>
</table>
</body>
</html>
HTML);

        $h4Node = $document->querySelector('h4');
        $paragraphNode = $document->querySelector('p');
        $tableNode = $document->querySelector('table');
        self::assertNotNull($h4Node);
        self::assertNotNull($paragraphNode);
        self::assertNotNull($tableNode);

        $sectionDefinition = new SectionDefinition('Getting updates', new BotApiDefinition());
        $parser = new MethodParser(new ParserHelper());

        $methodDefinition = $parser->parse($h4Node, [$paragraphNode, $tableNode], $sectionDefinition);

        self::assertSame('sendMessage', $methodDefinition->name);
        self::assertSame('#sendmessage', $methodDefinition->id);
        self::assertCount(3, $methodDefinition->getParameters());
        self::assertSame('chat_id', $methodDefinition->getParameters()[0]->name);
        self::assertFalse($methodDefinition->getParameters()[0]->isOptional);
        self::assertSame(['Integer'], $methodDefinition->getParameters()[0]->typeDefinition->getTypes());
        self::assertSame('disable_notification', $methodDefinition->getParameters()[2]->name);
        self::assertTrue($methodDefinition->getParameters()[2]->isOptional);
        self::assertSame(['Boolean'], $methodDefinition->getParameters()[2]->typeDefinition->getTypes());
        self::assertSame(['#message'], $methodDefinition->getReturnTypeDefinition()?->getTypes());
    }
}

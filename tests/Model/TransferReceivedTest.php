<?php declare(strict_types=1);

namespace Matleo\BankStatementParserBundle\tests\Model;

use Matleo\BankStatementParserBundle\Model\TransferReceived;
use PHPUnit\Framework\TestCase;

final class TransferReceivedTest extends TestCase
{
    public function testCreate()
    {
        $test1 = "VIR RECU 9936053227134".
            "\nDE: MLLE SOPHIE VERMOTE" .
            "\nMOTIF: complement";

        preg_match(TransferReceived::PATTERN, $test1, $matches);

        $transferReceived = TransferReceived::create($matches);

        $this->assertInstanceOf(
            TransferReceived::class,
            $transferReceived
        );

        $this->assertEquals(
            '9936053227134',
            $transferReceived->getNumber()
        );

        $this->assertEquals(
            'MLLE SOPHIE VERMOTE',
            $transferReceived->getFrom()
        );

        $this->assertEquals(
            'complement',
            $transferReceived->getReason()
        );
    }
}

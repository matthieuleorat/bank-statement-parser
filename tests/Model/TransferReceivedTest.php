<?php declare(strict_types=1);

namespace Matleo\BankStatementParserBundle\tests\Model;

use Matleo\BankStatementParserBundle\Model\TransferReceived;
use PHPUnit\Framework\TestCase;

final class TransferReceivedTest extends TestCase
{
    public function testCreateModel1()
    {
        $test1 = "VIR RECU 9936053227134".
            "\nDE: MLLE GEGE RALDINE" .
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
            'MLLE GEGE RALDINE',
            $transferReceived->getFrom()
        );

        $this->assertEquals(
            'complement',
            $transferReceived->getReason()
        );
    }
    
    public function testCreateModel2()
    {
        $model2 = "VIREMENT RECU".
                    "\nDE: MLLE GEGE RALDINE".
                    "\nMOTIF: Vie quotidienne".
                    "\nREF: 1000117069699";

        preg_match(TransferReceived::PATTERN, $model2, $matches);
        $transferReceived = TransferReceived::create($matches);

        $this->assertInstanceOf(
            TransferReceived::class,
            $transferReceived
        );

        $this->assertEquals(
            '',
            $transferReceived->getNumber()
        );

        $this->assertEquals(
            'MLLE GEGE RALDINE',
            $transferReceived->getFrom()
        );

        $this->assertEquals(
            'Vie quotidienne',
            $transferReceived->getReason()
        );

        $this->assertEquals(
            '1000117069699',
            $transferReceived->getRef()
        );
    }
}

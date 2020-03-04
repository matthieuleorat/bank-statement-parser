<?php declare(strict_types=1);

namespace Matleo\BankStatementParser\tests\Model;

use Matleo\BankStatementParser\Model\TransferSended;
use PHPUnit\Framework\TestCase;

class TransferSendedTest extends TestCase
{
    const MODEL_1 = "000001 VIR EUROPEEN EMIS LOGITEL".
        "\nPOUR: M. DUPONT JEAN".
        "\n26 10 SG 00991 CPT 00065498732".
        "\nREF: 32165498765432".
        "\nMOTIF: ANY REASON".
        "\nCHEZ: SOGEFRPP";

    public function testValidateModel1()
    {
        $object = $this->createObject(self::MODEL_1);

        $this->assertEquals('32165498765432', $object->getRef());
        $this->assertEquals('000001', $object->getNumber());
        $this->assertEquals('M. DUPONT JEAN', $object->getFor());
        $this->assertEquals('26 10', $object->getDate());
        $this->assertEquals('00065498732', $object->getAccount());
        $this->assertEquals('ANY REASON', $object->getReason());
        $this->assertEquals('SOGEFRPP', $object->getTo());
    }

    private function createObject(string $details) : TransferSended
    {
        preg_match(TransferSended::PATTERN, $details, $matches);

        $transferSended = TransferSended::create($matches);

        $this->assertInstanceOf(
            TransferSended::class,
            $transferSended
        );

        return $transferSended;
    }
}

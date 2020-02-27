<?php declare(strict_types=1);

namespace Matleo\BankStatementParserBundle\tests\Model;

use Matleo\BankStatementParserBundle\Model\EuropeanDirectDebit;
use PHPUnit\Framework\TestCase;

final class EuropeanDirectDebitTest extends TestCase
{
    const MODEL_1 = "PRELEVEMENT EUROPEEN 7586321565".
        "\nDE: PROVIDER".
        "\nID: FR52YYY654MDJ".
        "\nMOTIF: PRELEVEMENT DU 16.12.2019".
        "\nREF: SIG.85463156.2019-12-16".
        "\nMANDAT SIG9853165";

    public function testModel1()
    {
        $object = $this->createObject(self::MODEL_1);
        $this->assertEquals('7586321565', $object->getNumber());
        $this->assertEquals('PROVIDER', $object->getFrom());
        $this->assertEquals('FR52YYY654MDJ', $object->getId());
        $this->assertEquals('PRELEVEMENT DU 16.12.2019', $object->getReason());
        $this->assertEquals('SIG.85463156.2019-12-16', $object->getRef());
        $this->assertEquals('SIG9853165', $object->getWarrant());
    }

    private function createObject(string $details) : EuropeanDirectDebit
    {
        preg_match(EuropeanDirectDebit::PATTERN, $details, $matches);

        $object = EuropeanDirectDebit::create($matches);

        $this->assertInstanceOf(
            EuropeanDirectDebit::class,
            $object
        );

        return $object;
    }
}

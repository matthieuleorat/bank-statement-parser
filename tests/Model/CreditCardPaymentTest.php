<?php declare(strict_types=1);

namespace Matleo\BankStatementParserBundle\tests\Model;

use Matleo\BankStatementParserBundle\Model\CreditCardPayment;
use PHPUnit\Framework\TestCase;

final class CreditCardPaymentTest extends TestCase
{
    const MODEL_1 = "CARTE X0964 22/12 TRALALA";

    const MODEL_2 = "CARTE X0964 30/12 TROLOLO".
        "\nRA419338";

    public function testModel1()
    {
        $object = $this->createObject(self::MODEL_1);
        $this->assertEquals('22/12', $object->getDate());
        $this->assertEquals("TRALALA", $object->getMerchant());
        $this->assertEquals('X0964', $object->getCardId());
    }

    public function testModel2()
    {
        $object = $this->createObject(self::MODEL_2);
        $this->assertEquals('30/12', $object->getDate());
        $this->assertEquals("TROLOLO\nRA419338", $object->getMerchant());
        $this->assertEquals('X0964', $object->getCardId());
    }

    private function createObject(string $details) : CreditCardPayment
    {
        preg_match(CreditCardPayment::PATTERN, $details, $matches);

        $obj = CreditCardPayment::create($matches);

        $this->assertInstanceOf(
            CreditCardPayment::class,
            $obj
        );

        return $obj;
    }
}

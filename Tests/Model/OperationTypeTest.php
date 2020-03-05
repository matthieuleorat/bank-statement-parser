<?php declare(strict_types=1);

namespace Matleo\BankStatementParser\tests\Model;

use Matleo\BankStatementParser\Model\CreditCardPayment;
use Matleo\BankStatementParser\Model\EuropeanDirectDebit;
use Matleo\BankStatementParser\Model\Operation;
use Matleo\BankStatementParser\Model\OperationTypeGuesser;
use Matleo\BankStatementParser\Model\PermanentTransfert;
use Matleo\BankStatementParser\Model\TransferReceived;
use Matleo\BankStatementParser\Model\TransferSended;
use PHPUnit\Framework\TestCase;

final class OperationTypeTest extends TestCase
{
    public function testGuessCreditCard() : void
    {
        $mockOperationCreditCard = $this->createMock(Operation::class);
        $mockOperationCreditCard->method('getDetails')
            ->willReturn(CreditCardPaymentTest::MODEL_1);

        $type = OperationTypeGuesser::execute($mockOperationCreditCard);
        $this->assertInstanceOf(CreditCardPayment::class, $type);
    }

    public function testGuessEuropeanDirectDebit() : void
    {
        $mockOperationCreditCard = $this->createMock(Operation::class);
        $mockOperationCreditCard->method('getDetails')
            ->willReturn(EuropeanDirectDebitTest::MODEL_1);

        $type = OperationTypeGuesser::execute($mockOperationCreditCard);
        $this->assertInstanceOf(EuropeanDirectDebit::class, $type);
    }

    public function testGuessPermanentTransfert() : void
    {
        $mockOperationCreditCard = $this->createMock(Operation::class);
        $mockOperationCreditCard->method('getDetails')
            ->willReturn(PermanentTransfertTest::MODEL_1);

        $type = OperationTypeGuesser::execute($mockOperationCreditCard);
        $this->assertInstanceOf(PermanentTransfert::class, $type);
    }

    public function testGuessTransferReceived() : void
    {
        $mockOperationCreditCard = $this->createMock(Operation::class);
        $mockOperationCreditCard->method('getDetails')
            ->willReturn(TransferReceivedTest::MODEL_1);

        $type = OperationTypeGuesser::execute($mockOperationCreditCard);
        $this->assertInstanceOf(TransferReceived::class, $type);
    }

    public function testGuessTransferSended() : void
    {
        $mockOperationCreditCard = $this->createMock(Operation::class);
        $mockOperationCreditCard->method('getDetails')
            ->willReturn(TransferSendedTest::MODEL_1);

        $type = OperationTypeGuesser::execute($mockOperationCreditCard);
        $this->assertInstanceOf(TransferSended::class, $type);
    }

    public function testGuessWithoutMatch() : void
    {
        $mockOperationCreditCard = $this->createMock(Operation::class);
        $mockOperationCreditCard->method('getDetails')
            ->willReturn('unmatched operation');

        $type = OperationTypeGuesser::execute($mockOperationCreditCard);
        $this->assertNull($type);
    }
}

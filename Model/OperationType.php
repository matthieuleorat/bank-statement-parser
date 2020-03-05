<?php declare(strict_types=1);

namespace Matleo\BankStatementParser\Model;

class OperationType
{
    /**
     * @var TypeInterface[]
     */
    const PATTERNS = [
        CreditCardPayment::class,
        EuropeanDirectDebit::class,
        PermanentTransfert::class,
        TransferReceived::class,
        TransferSended::class,
        HomeLoan::class,
    ];

    public static function guess(Operation $operation) : ? TypeInterface
    {
        foreach (self::PATTERNS as $type) {
            $obj = $type::createFromString($operation->getDetails());
            if ($obj instanceof TypeInterface) {
                return $obj;
            }
        }

        return null;
    }
}

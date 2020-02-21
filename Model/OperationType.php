<?php declare(strict_types=1);

namespace Matleo\BankStatementParserBundle\Model;

class OperationType
{
    const PATTERNS = [
        CreditCardPayment::class,
        EuropeanDirectDebit::class,
        PermanentTransfert::class,
    ];

    public static function guess(Operation $operation)
    {
        foreach (self::PATTERNS as $type) {
            preg_match($type::PATTERN, $operation->getDetails(), $matches);
            if (count($matches)) {
                    return $type::create($matches);
                break;
            }
        }

        return null;
    }
}

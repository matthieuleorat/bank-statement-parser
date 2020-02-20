<?php

namespace Matleo\BankStatementParserBundle\Model;

class OperationType
{
    // CARTE X5874 RETRAIT DAB SG 22/01 08H45 MEYLAN 00914365
    const TYPE_CREDIT_CARD_WITHDRAW = 'credit_card_withdraw';
    const CARD_WITHDRAW_PATTERN = '/CARTE\s{1}X\d{4}\s{1}RETRAIT.*(\d{2}\/\d{2})(.*)/';

    const PATTERNS = [
        CreditCardPayment::class,
    ];

    public static function guess(Operation $operation)
    {
        foreach (self::PATTERNS as $type) {
            preg_match($type::PATTERN, $operation->getDetails(), $matches);
            dump($operation->getDetails(),$type::PATTERN, $matches);
            if (count($matches)) {
                    return $type::create($matches);
                break;
            }
        }

        return null;
    }
}

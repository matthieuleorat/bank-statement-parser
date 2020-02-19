<?php

namespace Matleo\BankStatementParserBundle\Model;

class OperationType
{
    // CARTE X0868 07/12 SEMITAG
    const TYPE_CREDIT_CARD_PAYEMENT = 'credit_card_payement';
    const CARD_PAYEMENT_PATTERN = '/CARTE\s{1}X\d{4}\s{1}(\d{2}\/\d{2})\s{1}(.*)/';

    // CARTE X5874 RETRAIT DAB SG 22/01 08H45 MEYLAN 00914365
    const TYPE_CREDIT_CARD_WITHDRAW = 'credit_card_withdraw';
    const CARD_WITHDRAW_PATTERN = '/CARTE\s{1}X\d{4}\s{1}RETRAIT.*(\d{2}\/\d{2})(.*)/';

    const PATTERNS = [
        self::TYPE_CREDIT_CARD_PAYEMENT => self::CARD_PAYEMENT_PATTERN,
        self::TYPE_CREDIT_CARD_WITHDRAW => self::CARD_WITHDRAW_PATTERN,
    ];

    /**
     * @var string
     */
    private $type;
}

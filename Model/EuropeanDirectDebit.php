<?php  declare(strict_types=1);

namespace Matleo\BankStatementParserBundle\Model;

class EuropeanDirectDebit
{
    const NAME = 'european_direct_debit';
    const PATTERN = '/^PRELEVEMENT EUROPEEN\s(\d*)\nDE:\s(.*)\nID:\s(.*)\nMOTIF:\s(.*)\nREF:\s(.*)\nMANDAT (.*)$/s';

    /**
     * @var string
     */
    private $number;

    /**
     * @var string
     */
    private $from;

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $reason;

    /**
     * @var string
     */
    private $ref;

    /**
     * @var string
     */
    private $warrant;

    private function __construct() {}

    public static function create(array $matches) : self
    {
        list (, $number, $from, $id, $reason, $ref, $warrant) = $matches;
        $obj = new self();
        $obj->number = $number;
        $obj->from = $from;
        $obj->id = $id;
        $obj->reason = $reason;
        $obj->ref = $ref;
        $obj->warrant = $warrant;

        return $obj;
    }
}

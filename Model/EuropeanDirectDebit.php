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

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getReason(): string
    {
        return $this->reason;
    }

    /**
     * @return string
     */
    public function getRef(): string
    {
        return $this->ref;
    }

    /**
     * @return string
     */
    public function getWarrant(): string
    {
        return $this->warrant;
    }
}

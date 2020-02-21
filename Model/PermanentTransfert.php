<?php declare(strict_types=1);

namespace Matleo\BankStatementParserBundle\Model;

class PermanentTransfert
{
    const NAME = 'permanent_transfert';
    const PATTERN = '/^\d{6}\s{1}VIR\sPERM\nPOUR:\s(.*)\nREF:\s(\d*)\nMOTIF:\s(.*)\nLIB:\s(.*)$/s';

    /**
     * @var string
     */
    private $recepient;

    /**
     * @var string
     */
    private $reference;

    /**
     * @var string
     */
    private $reason;

    /**
     * @var string
     */
    private $label;

    private function __construct() {}

    public static function create(array $matches) : self
    {
        list (, $recepient, $reference, $reason, $label) = $matches;
        $obj = new self();
        $obj->recepient = $recepient;
        $obj->reference = $reference;
        $obj->reason = $reason;
        $obj->label = $label;

        return $obj;
    }
}

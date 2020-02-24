<?php declare(strict_types=1);

namespace Matleo\BankStatementParserBundle\Model;

class TransferReceived
{
    const NAME = 'transfer_received';
    const PATTERN = '/^VIR\sRECU\s(\d+)\nDE:\s(.*)/s';
    const PATTERN_WITH_REASON = '/^VIR\sRECU\s(\d+)\nDE:\s(.*)\nMOTIF:\s(.*)/s';

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $from;

    /**
     * @var string
     */
    private $reason;

    private function __construct() {}

    public static function create(array $matches) : self
    {

        list (, $id, $from) = $matches;
        $obj = new self();
        $obj->id = $id;
        $obj->from = $from;

        preg_match(self::PATTERN_WITH_REASON, $matches[0], $submatches);

        if (count($submatches) == 4) {
            list (, $id, $from2, $reason2) = $submatches;
            $obj->from = $from2;
            $obj->reason = $reason2;
        }

        return $obj;
    }
}

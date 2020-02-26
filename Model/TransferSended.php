<?php declare(strict_types=1);

namespace Matleo\BankStatementParserBundle\Model;

class TransferSended
{
    /**
     "000001 VIR EUROPEEN EMIS LOGITEL
      POUR: M. DUPONT JEAN
      26 10 SG 00991 CPT 00065498732
      REF: 32165498765432
      MOTIF: Noel GrdMaman
      CHEZ: SOGEFRPP";
     */

    const NAME = 'transfer_received';
    const PATTERN = '/^(\d+)\sVIR EUROPEEN EMIS LOGITEL\nPOUR:\s+([\s\S]*?)(\d{2} \d{2})\sSG\s(\d+)\sCPT\s(\d+)(\nREF:\s(\d+))?(\nMOTIF:\s(.*))?(\nCHEZ:\s(.*))?/';

    private $number;

    private $for;

    private $date;

    private $account;

    private $ref;

    private $reason;

    private $to;

    private function __construct()
    {}

    public static function create(array $matches)
    {

    }
}

<?php declare(strict_types=1);

namespace Matleo\BankStatementParserBundle\Model;

class TransferSended
{
    /**
    "000001 VIR EUROPEEN EMIS LOGITEL
    POUR: M. DUPONT JEAN
    26 10 SG 00991 CPT 00065498732
    REF: 32165498765432
    MOTIF: ANY REASON
    CHEZ: SOGEFRPP";
     */

    const NAME = 'transfer_received';

    const REF_KEY = "\nREF: ";
    const REF_SUB_PATTERN = "(".self::REF_KEY."(\d+))?";

    const FOR_KEY = "\nPOUR: ";
    const FOR_SUB_PATTERN = "(".self::FOR_KEY."([\s\S]*?))";

    const REASON_KEY = "\nMOTIF: ";
    const REASON_SUB_PATTERN = "(".self::REASON_KEY."(.*))?";

    const TO_KEY = "\nCHEZ: ";
    const TO_SUB_PATTERN = "(".self::TO_KEY."(.*))?";

    const PATTERN = '/^(\d+)\sVIR EUROPEEN EMIS LOGITEL'.self::FOR_SUB_PATTERN.'(\d{2} \d{2})\sSG\s(\d+)\sCPT\s(\d+)'.self::REF_SUB_PATTERN.''.self::REASON_SUB_PATTERN.''.self::TO_SUB_PATTERN.'/';

    /**
     * @var string
     */
    private $number;
    /**
     * @var string
     */
    private $for;
    /**
     * @var string
     */
    private $date;
    /**
     * @var string
     */
    private $account;
    /**
     * @var string
     */
    private $ref;
    /**
     * @var string
     */
    private $reason;
    /**
     * @var string
     */
    private $to;

    private function __construct()
    {}

    public static function create(array $matches) : TransferSended
    {
        $obj = new self();
        $obj->number = $matches[1];
        $obj->date = $matches[4];
        $obj->account = $matches[6];
        $obj->tryToSetFor($matches);
        $obj->tryToSetReason($matches);
        $obj->tryToSetTo($matches);
        $obj->tryToSetRef($matches);

        return $obj;
    }

    private function tryToSetFor(array $matches) : void
    {
        $this->for = $this->tryToGuess(self::FOR_KEY, $matches);
    }

    private function tryToSetRef(array $matches) : void
    {
        $this->ref = $this->tryToGuess(self::REF_KEY, $matches);
    }

    private function tryToSetTo(array $matches) : void
    {
        $this->to = $this->tryToGuess(self::TO_KEY, $matches);
    }

    private function tryToSetReason(array $matches) : void
    {
        $this->reason = $this->tryToGuess(self::REASON_KEY, $matches);
    }

    private function tryToGuess(string $pattern, array $matches) : ? string
    {
        foreach ($matches as $key => $value) {
            if (substr($value, 0, strlen($pattern)) === $pattern && array_key_exists($key + 1, $matches)) {
                return trim($matches[$key + 1]);
            }
        }

        return null;
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
    public function getFor(): string
    {
        return $this->for;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getAccount(): string
    {
        return $this->account;
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
    public function getReason(): string
    {
        return $this->reason;
    }

    /**
     * @return string
     */
    public function getTo(): string
    {
        return $this->to;
    }
}

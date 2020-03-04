<?php declare(strict_types=1);

namespace Matleo\BankStatementParser\Model;

class TransferReceived
{
    const REF_SUB_PATTERN = "\nREF: ";
    const ID_SUB_PATTERN = "\nID: ";
    const REASON_SUB_PATTERN = "\nMOTIF: ";
    const NAME = 'transfer_received';
    const PATTERN = '/^VIR(?:EMENT)?\s+RECU\s?(.*)\nDE:\s+([\s\S]*?)('.self::REASON_SUB_PATTERN.'([\s\S]*?))?('.self::REF_SUB_PATTERN.'([\s\S]*?))?('.self::ID_SUB_PATTERN.'([\s\S]*?))?$/';

    /**
     * @var string
     */
    private $number;

    /**
     * @var string
     */
    private $from;

    /**
     * @var string|null
     */
    private $reason;

    /**
     * @var string|null
     */
    private $ref;

    /**
     * @var string|null
     */
    private $id;

    private function __construct() {}

    public static function create(array $matches) : self
    {
        $obj = new self();
        $obj->number = $matches[1];
        $obj->from = $matches[2];
        $obj->tryToSetReason($matches);
        $obj->tryToSetRef($matches);
        $obj->tryToSetId($matches);

        return $obj;
    }

    private function tryToSetReason(array $matches) : void
    {
        $this->reason = $this->tryToGuess(self::REASON_SUB_PATTERN, $matches);
    }

    private function tryToSetRef(array $matches) : void
    {
        $this->ref = $this->tryToGuess(self::REF_SUB_PATTERN, $matches);
    }

    private function tryToSetId(array $matches) : void
    {
        $this->id = $this->tryToGuess(self::ID_SUB_PATTERN, $matches);
    }

    private function tryToGuess(string $pattern, array $matches) : ? string
    {
        foreach ($matches as $key => $value) {
            if (substr($value, 0, strlen($pattern)) === $pattern && array_key_exists($key + 1, $matches)) {
                return $matches[$key + 1];
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
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * @return string|null
     */
    public function getReason(): ?string
    {
        return $this->reason;
    }

    /**
     * @return string|null
     */
    public function getRef(): ?string
    {
        return $this->ref;
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }
}

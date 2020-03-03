<?php declare(strict_types=1);

namespace Matleo\BankStatementParserBundle\Model;

class HomeLoan
{
    const NAME = 'home_loan';

    const MONEY_AMOUT = "((\d{1,3}\.)?\d{1,3},\d{2})";

    const REF_LOAN_MATURITY = "ECHEANCE PRET N°";
    const REF_LOAN_MATURITY_SUB_PATTERN = "(".self::REF_LOAN_MATURITY."(\d+))";

    const DEPRECIATED_CAPITAL_KEY = "\nCAPITAL AMORTI : ";
    const DEPRECIATED_CAPITAL_SUB_PATTERN = "(".self::DEPRECIATED_CAPITAL_KEY.self::MONEY_AMOUT.")";

    const INTEREST_KEY = "\nINTERETS : ";
    const INTEREST_SUB_PATTERN = "(".self::INTEREST_KEY.self::MONEY_AMOUT.")";

    const INSURANCE_KEY = "\nASSURANCE : ";
    const INSURANCE_SUB_PATTERN = "(".self::INSURANCE_KEY.self::MONEY_AMOUT.")";

    const REMAINING_CAPITAL_KEY = "\nCAPITAL RESTANT : ";
    const REMAINING_CAPITAL_SUB_PATTERN = "(".self::REMAINING_CAPITAL_KEY."((\d{1,3}\s)?\d{1,3},\d{2}))?";

    const EXPECTED_END_DATE_KEY = "\nDATE PREVISIONNELLE DE FIN : ";
    const EXPECTED_END_DATE_SUB_PATTERN = "(".self::EXPECTED_END_DATE_KEY."(\d{1,2}\/\d{1,2}\/\d{4}))";

    const PATTERN = '/^'.self::REF_LOAN_MATURITY_SUB_PATTERN.self::DEPRECIATED_CAPITAL_SUB_PATTERN.self::INTEREST_SUB_PATTERN.self::INSURANCE_SUB_PATTERN.self::REMAINING_CAPITAL_SUB_PATTERN.self::EXPECTED_END_DATE_SUB_PATTERN.'/';

    /**
     * @var string
     */
    private $loanNumber;
    /**
     * @var string
     */
    private $depreciatedCapital;
    /**
     * @var string
     */
    private $interest;
    /**
     * @var string
     */
    private $insurance;
    /**
     * @var string
     */
    private $remainingCapital;
    /**
     * @var string
     */
    private $expectedEndDate;

    private function __construct()
    {}

    public static function create(array $matches) : self
    {
        $obj = new self();
        $obj->loanNumber = $matches[2];
        $obj->setDepreciatedCapital($matches);
        $obj->setInterest($matches);
        $obj->setInsurance($matches);
        $obj->setRemainingCapital($matches);
        $obj->setExpectedEndDate($matches);

        return $obj;
    }

    private function setDepreciatedCapital(array $matches) : void
    {
        $this->depreciatedCapital = $this->tryToGuess(self::DEPRECIATED_CAPITAL_KEY, $matches);
    }

    private function setInterest(array $matches) : void
    {
        $this->interest = $this->tryToGuess(self::INTEREST_KEY, $matches);
    }

    private function setInsurance(array $matches) : void
    {
        $this->insurance = $this->tryToGuess(self::INSURANCE_KEY, $matches);
    }

    private function setRemainingCapital(array $matches) : void
    {
        $this->remainingCapital = $this->tryToGuess(self::REMAINING_CAPITAL_KEY, $matches);
    }

    private function setExpectedEndDate(array $matches) : void
    {
        $this->expectedEndDate = $this->tryToGuess(self::EXPECTED_END_DATE_KEY, $matches);
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
    public function getLoanNumber(): string
    {
        return $this->loanNumber;
    }

    /**
     * @return string
     */
    public function getDepreciatedCapital(): string
    {
        return $this->depreciatedCapital;
    }

    /**
     * @return string
     */
    public function getInterest(): string
    {
        return $this->interest;
    }

    /**
     * @return string
     */
    public function getInsurance(): string
    {
        return $this->insurance;
    }

    /**
     * @return string
     */
    public function getRemainingCapital(): string
    {
        return $this->remainingCapital;
    }

    /**
     * @return string
     */
    public function getExpectedEndDate(): string
    {
        return $this->expectedEndDate;
    }
}

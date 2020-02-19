<?php declare(strict_types=1);

namespace Matleo\BankStatementParserBundle;

use Matleo\BankStatementParserBundle\Model\OperationType;

class OperationTypeGuesser
{
    public static function guess(string $details) : ? string
    {
        foreach (OperationType::PATTERNS as $type => $pattern) {
            preg_match($pattern, $details, $matches);
            if (count($matches)) {
                return $type;
            }
        }

        return null;
    }
}

<?php
declare(strict_types=1);

namespace App;

/**
 * Class Assets
 * @package App
 */
class Assets
{

    /**
     * @param string|null $aliasNumber
     * @return string|null
     */
    public static function cleanUpAliasNumber(?string $aliasNumber): ?string
    {
        if ($aliasNumber === null) {
            return null;
        }
        $numbers = preg_replace('/\D/i', '', $aliasNumber);
        return empty($numbers) ? null : strval($numbers);
    }
}

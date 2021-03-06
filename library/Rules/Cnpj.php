<?php

/*
 * This file is part of Respect/Validation.
 *
 * (c) Alexandre Gomes Gaigalas <alexandre@gaigalas.net>
 *
 * For the full copyright and license information, please view the "LICENSE.md"
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Respect\Validation\Rules;

class Cnpj extends AbstractRule
{
    public function validate($input): bool
    {
        if (!is_scalar($input)) {
            return false;
        }

        // Code ported from jsfromhell.com
        $cleanInput = preg_replace('/\D/', '', $input);
        $b = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

        if ($cleanInput < 1) {
            return false;
        }

        if (14 != mb_strlen($cleanInput)) {
            return false;
        }

        for ($i = 0, $n = 0; $i < 12; $n += $cleanInput[$i] * $b[++$i]);

        if ($cleanInput[12] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }

        for ($i = 0, $n = 0; $i <= 12; $n += $cleanInput[$i] * $b[$i++]);

        if ($cleanInput[13] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }

        return true;
    }
}

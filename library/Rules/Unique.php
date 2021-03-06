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

class Unique extends AbstractRule
{
    public function validate($input): bool
    {
        if (!is_array($input)) {
            return false;
        }

        return $input == array_unique($input, SORT_REGULAR);
    }
}

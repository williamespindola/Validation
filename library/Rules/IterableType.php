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

class IterableType extends AbstractRule
{
    public function validate($input): bool
    {
        return is_array($input) ||
            $input instanceof \stdClass ||
            $input instanceof \Traversable;
    }
}

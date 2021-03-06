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

namespace Respect\Validation\Rules\Locale;

use Respect\Validation\Rules\AbstractSearcher;

/**
 * Validates whether an input is subdivision code of Nepal or not.
 *
 * ISO 3166-1 alpha-2: NP
 *
 * @see http://www.geonames.org/NP/administrative-division-nepal.html
 *
 * @author Henrique Moody <henriquemoody@gmail.com>
 */
final class NpSubdivisionCode extends AbstractSearcher
{
    /**
     * {@inheritdoc}
     */
    protected function getDataSource(): array
    {
        return [
           '1', // Madhyamanchal
           '2', // Madhya Pashchimanchal
           '3', // Pashchimanchal
           '4', // Purwanchal
           '5', // Sudur Pashchimanchal
           'BA', // Bagmati
           'BH', // Bheri
           'DH', // Dhawalagiri
           'GA', // Gandaki
           'JA', // Janakpur
           'KA', // Karnali
           'KO', // Kosi
           'LU', // Lumbini
           'MA', // Mahakali
           'ME', // Mechi
           'NA', // Narayani
           'RA', // Rapti
           'SA', // Sagarmatha
           'SE', // Seti
       ];
    }
}

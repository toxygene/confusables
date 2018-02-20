<?php

namespace Confusables;

use Normalizer;

/**
 * Replace confusable characters
 *
 * @param string $string
 * @return string
 */
function unconfuse(string $string) : string
{
    $confusables = get_confusables();
    $result = '';
    foreach (preg_split('//u', $string, -1, PREG_SPLIT_NO_EMPTY) as $originalCharacter) {
        $code = str_pad(strtoupper(dechex(mb_ord($originalCharacter, 'utf-8'))), 4, '0', STR_PAD_LEFT);
        if (isset($confusables[$code])) {
            foreach (explode(' ', $confusables[$code]) as $replacementCharacter) {
                $result .= mb_chr(hexdec($replacementCharacter), 'utf-8');
            }
        } else {
            $result .= $originalCharacter;
        }
    }
    return $result;
}

/**
 * Get the skeleton for a unicode string
 *
 * @param string $string
 * @return string
 */
function skeleton(string $string) : string
{
    return normalizer_normalize(
        unconfuse(
            normalizer_normalize(
                $string,
                Normalizer::NFD
            )
        ),
        Normalizer::NFD
    );
}

/**
 * Check if a string is dangerous
 *
 * @param string $string
 * @return bool
 */
function is_dangerous(string $string) : bool
{
    return $string != skeleton($string);
}

/**
 * Check if a string is confusable with another string
 *
 * @param string $a
 * @param string $b
 * @return bool
 */
function is_confusable(string $a, string $b) : bool
{
    return skeleton($a) == skeleton($b);
}

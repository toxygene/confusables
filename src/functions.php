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
        if (isset($confusables[$originalCharacter])) {
            $result .= $confusables[$originalCharacter];
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

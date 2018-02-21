<?php

declare(strict_types=1);

namespace Confusables;

use PHPUnit\Framework\TestCase;

class FunctionsTest extends TestCase
{
    /**
     * @covers \Confusables\skeleton
     * @uses \Confusables\get_confusables
     * @uses \Confusables\unconfuse
     */
    public function testSkeleton()
    {
        $this->assertEquals(
            'paypal',
            skeleton('𝐩ɑ𝛾𝚙𝝰1')
        );

        $this->assertNotEquals(
            'paypal',
            skeleton('𝐩ɑУ𝚙𝝰1')
        );
    }

    /**
     * @covers \Confusables\unconfuse
     * @uses \Confusables\get_confusables
     */
    public function testUnconfuse()
    {
        $this->assertEquals(
            'paypal',
            unconfuse('paypa1')
        );

        $this->assertNotEquals(
            'paУpal',
            unconfuse('paypal')
        );
    }

    /**
     * @covers \Confusables\is_confusable
     * @uses \Confusables\get_confusables
     * @uses \Confusables\skeleton
     * @uses \Confusables\unconfuse
     */
    public function testIsConfusable()
    {
        $this->assertTrue(
            is_confusable(
                'ρ⍺у𝓅𝒂ן',
                '𝔭𝒶ỿ𝕡𝕒ℓ'
            )
        );

        $this->assertFalse(
            is_confusable(
                'jeff',
                'mike'
            )
        );

        $this->assertFalse(
            is_confusable(
                'e',
                'é'
            )
        );

        $this->assertFalse(
            is_confusable(
                'É',
                'é'
            )
        );
    }

    /**
     * @covers \Confusables\is_dangerous
     * @uses \Confusables\get_confusables
     * @uses \Confusables\skeleton
     * @uses \Confusables\unconfuse
     */
    public function testIsDangerous()
    {
        $this->assertTrue(is_dangerous('𝔭𝒶ỿ𝕡𝕒ℓ'));
        $this->assertFalse(is_dangerous('test'));
    }
}

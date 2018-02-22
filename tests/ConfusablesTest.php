<?php

declare(strict_types=1);

namespace Confusables;

use PHPUnit\Framework\TestCase;

class ConfusablesTest extends TestCase
{
    /**
     * @var Confusables
     */
    private $confusables;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->confusables = new Confusables();
    }

    /**
     * @covers \Confusables::skeleton
     * @uses \Confusables::unconfuse
     */
    public function testSkeleton()
    {
        $this->assertEquals(
            'paypal',
            $this->confusables->skeleton('𝐩ɑ𝛾𝚙𝝰1')
        );

        $this->assertNotEquals(
            'paypal',
            $this->confusables->skeleton('𝐩ɑУ𝚙𝝰1')
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
            $this->confusables->unconfuse('paypa1')
        );

        $this->assertNotEquals(
            'paУpal',
            $this->confusables->unconfuse('paypal')
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
            $this->confusables->isConfusable(
                'ρ⍺у𝓅𝒂ן',
                '𝔭𝒶ỿ𝕡𝕒ℓ'
            )
        );

        $this->assertFalse(
            $this->confusables->isConfusable(
                'jeff',
                'mike'
            )
        );

        $this->assertFalse(
            $this->confusables->isConfusable(
                'e',
                'é'
            )
        );

        $this->assertFalse(
            $this->confusables->isConfusable(
                'É',
                'é'
            )
        );
    }
}

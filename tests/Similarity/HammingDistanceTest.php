<?php

namespace NlpTools\Similarity;

use PHPUnit\Framework\TestCase;
use function max;
use function strlen;

class HammingDistanceTest extends TestCase
{
    public function testHammingDistance()
    {
        $dist = new HammingDistance();

        $A = "ABCDE";
        $B = "FGHIJ";
        $C = "10101";
        $D = "11111";

        $this->assertEquals(
            max(strlen($A), strlen($B)),
            $dist->dist($A, $B),
            "Two completely dissimilar strings should have distance equal to max(strlen(\$A),strlen(\$B))"
        );

        $this->assertEquals(
            2,
            $dist->dist($C, $D),
            "10101 ~ 11111 have a hamming distance = 2"
        );
    }
}

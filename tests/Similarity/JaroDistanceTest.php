<?php

namespace NlpTools\Similarity;

use PHPUnit\Framework\TestCase;

class JaroDistanceTest extends TestCase
{
    public function testJaroDistance()
    {
        $dist = new JaroDistance();

        $A = "john";
        $A_arr = array("j", "o", "h", "n");
        $e = "";
        $e_arr = array();

        $this->assertEquals(
            1,
            $dist->dist($A, $A),
            "Similar strings should equate to 1"
        );

        $this->assertEquals(
            1,
            $dist->dist($A_arr, $A_arr),
            "Similar arrays should equate to 1"
        );

        $this->assertEquals(
            0,
            $dist->dist($A, $e),
            "Comparing to an empty string should equate to 0"
        );

        $this->assertEquals(
            0,
            $dist->dist($A_arr, $e_arr),
            "Comparing to an empty array should equate to 0"
        );
    }
}

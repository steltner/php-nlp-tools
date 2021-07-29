<?php

namespace NlpTools\Similarity;

use PHPUnit\Framework\TestCase;

class LevenshteinDistanceTest extends TestCase
{
    public function testLevenshteinDistance()
    {
        $dist = new LevenshteinDistance();

        $a = "kitten";
        $b = "sitting";

        $this->assertEquals(
            3,
            $dist->dist($a, $b),
            "kitten ~ sitting have a levenshtein distance = 3"
        );

        $this->assertEquals(
            0,
            $dist->dist($a, $a),
            "same words have a levenshtein distance = 0"
        );
    }
}

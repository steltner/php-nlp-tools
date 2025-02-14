<?php

namespace NlpTools\Similarity;

use function array_fill_keys;
use function array_intersect_key;
use function count;
use function min;

/**
 * https://en.wikipedia.org/wiki/Overlap_coefficient
 */
class OverlapCoefficient implements SimilarityInterface, DistanceInterface
{
    /**
     * The similarity returned by this algorithm is a number between 0,1
     */
    public function similarity(&$A, &$B)
    {
        // Make the arrays into sets
        $a = array_fill_keys($A, 1);
        $b = array_fill_keys($B, 1);

        // Count the cardinalities of the sets
        $a_count = count($a);
        $b_count = count($b);

        if ($a_count == 0 || $b_count == 0) {
            return 0;
        }

        // Compute the intersection and count its cardinality
        $intersect = count(array_intersect_key($a, $b));

        return $intersect / min($a_count, $b_count);
    }

    public function dist($a, $b)
    {
        return 1 - $this->similarity($a, $b);
    }
}

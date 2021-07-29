<?php

namespace NlpTools\Similarity;

/**
 * This class computes the very simple euclidean distance between
 * two vectors ( sqrt(sum((a_i-b_i)^2)) ).
 */
class Euclidean implements DistanceInterface
{
    /**
     * see class description
     * @param array $a Either a vector or a collection of tokens to be transformed to a vector
     * @param array $b Either a vector or a collection of tokens to be transformed to a vector
     * @return float The euclidean distance between $A and $B
     */
    public function dist($a, $b)
    {
        if (is_int(key($a))) {
            $v1 = array_count_values($a);
        } else {
            $v1 = &$a;
        }
        if (is_int(key($b))) {
            $v2 = array_count_values($b);
        } else {
            $v2 = &$b;
        }

        $r = array();
        foreach ($v1 as $k => $v) {
            $r[$k] = $v;
        }
        foreach ($v2 as $k => $v) {
            if (isset($r[$k])) {
                $r[$k] -= $v;
            } else {
                $r[$k] = $v;
            }
        }

        return sqrt(
            array_sum(
                array_map(
                    function ($x) {
                        return $x * $x;
                    },
                    $r
                )
            )
        );
    }
}

<?php

namespace NlpTools\Similarity;

use function strlen;

/**
 * This class implements the Levenshtein distance of two strings or sets.
 * This accepts 2 strings of arbitrary lengths.
 */
class LevenshteinDistance implements DistanceInterface
{
    /**
     * Count the number of positions that A and B differ.
     *
     * @param string $a
     * @param string $b
     * @return int The Levenshtein distance of the two strings A and B
     */
    public function dist($a, $b)
    {
        $m = strlen($a);
        $n = strlen($b);

        for ($i = 0; $i <= $m; $i++) $d[$i][0] = $i;
        for ($i = 0; $i <= $n; $i++) $d[0][$i] = $i;

        for ($i = 1; $i <= $m; $i++) {
            for ($j = 1; $j <= $n; $j++) {
                $d[$i][$j] = $a[$i - 1] === $b[$j - 1] ? $d[$i - 1][$j - 1] : min($d[$i - 1][$j] + 1,
                    $d[$i][$j - 1] + 1,
                    $d[$i - 1][$j - 1] + 1
                );
            }
        }

        return $d[$m][$n];
    }
}

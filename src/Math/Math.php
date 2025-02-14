<?php

namespace NlpTools\Math;

/**
 * Math Library
 *
 * @author Jericko Tejido <jtbibliomania@gmail.com>
 */
class Math
{
    /**
     * The base 2 log of the given expression
     * mostly used in DFR models
     *
     * @param mixed $expression
     * @return mixed
     */
    public function DFRlog($expression)
    {
        return log($expression) * $this->log2ofE();
    }

    /**
     * Returns the logarithm in base 2 of e, used to change the base of logarithms
     *
     * @return mixed
     */
    public function log2ofE()
    {
        return 1 / log(2);
    }

    /**
     * Stirling formula for the power series.
     *
     * @param mixed n The parameter of the Stirling formula.
     * @param mixed m The parameter of the Stirling formula.
     * @return mixed
     */
    public function stirlingPower($a, $b)
    {
        $diff = $a - $b;

        return ($b + 0.5) * $this->log($a / $b) + $diff * $this->log($a);
    }

    /**
     * Euclidean norm
     * ||x|| = sqrt(x・x) // ・ is a dot product
     *
     * @param array $vector
     * @return mixed
     */
    public function norm(array $vector)
    {
        return sqrt($this->dotProduct($vector, $vector));
    }

    /**
     * Dot product
     * a・b = summation{i=1,n}(a[i] * b[i])
     *
     * @param array $a
     * @param array $b
     * @return mixed
     */
    public function dotProduct(array $a, array $b)
    {
        $dotProduct = 0;
        $keysA = array_keys(array_filter($a));
        $keysB = array_keys(array_filter($b));

        $uniqueKeys = array_unique(array_merge($keysA, $keysB));
        foreach ($uniqueKeys as $key) {
            if (!empty($a[$key]) && !empty($b[$key])) {
                $dotProduct += ($a[$key] * $b[$key]);
            }
        }

        return $dotProduct;
    }
}

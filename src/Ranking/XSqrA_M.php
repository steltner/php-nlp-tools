<?php

namespace NlpTools\Ranking;

/**
 * XSqrA_M is a class that implements the XSqrA_M weighting model which computed the
 * inner product of Pearson's X^2 with the information growth computed
 * with the multinomial M.
 *
 * Frequentist and Bayesian approach to  Information Retrieval. G. Amati. In
 * Proceedings of the 28th European Conference on IR Research (ECIR 2006).
 * LNCS vol 3936, pages 13--24.
 *
 *
 * @author Jericko Tejido <jtbibliomania@gmail.com>
 */
class XSqrA_M implements ScoringInterface
{

    /**
     * @param string $term
     * @return float
     */
    public function score($tf, $docLength, $documentFrequency, $keyFrequency, $termFrequency, $collectionLength, $collectionCount, $uniqueTermsCount)
    {
        $score = 0;

        if ($tf != 0) {
            $mle = $tf / $docLength;

            $smoothedProbability = ($tf + 1) / ($docLength + 1);

            $collectionPrior = $termFrequency / $collectionLength;

            $XSqrA = pow(1 - $mle, 2) / ($tf + 1);

            $InformationDelta = ($tf + 1) * log($smoothedProbability / $collectionPrior) - $tf * log($mle / $collectionPrior) + 0.5 * log($smoothedProbability / $mle);

            $score += $keyFrequency * $tf * $XSqrA * $InformationDelta;
        }

        return $score;
    }
}

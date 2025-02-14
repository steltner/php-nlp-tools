<?php

namespace NlpTools\Ranking\BasicModel;

/**
 * This class implements the BE basic model for randomness. BE stands for Bose-Einstein statistics
 *
 * Gianni Amati and Cornelis Joost Van Rijsbergen. 2002.
 * Probabilistic models of information retrieval based on measuring the
 * divergence from randomness. ACM Trans. Inf. Syst. 20, 4 (October 2002)
 *
 * @author Jericko Tejido <jtbibliomania@gmail.com>
 */
class InExp extends BasicModel implements BasicModelInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Inf1(tf ) = tf · log2(N + 1 / n_exp + 0.5)
     */
    public function score($tfn, $docLength, $documentFrequency, $termFrequency, $collectionLength, $collectionCount)
    {
        $f = $termFrequency / $collectionCount;
        $n_exp = $collectionCount * (1 - exp(-$f));
        $idf = $this->idfDFR($collectionCount, $n_exp);

        return $tfn * $idf;
    }
}

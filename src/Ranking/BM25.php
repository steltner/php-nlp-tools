<?php

namespace NlpTools\Ranking;

use function log;

/**
 * BM25 is a class for ranking documents against a query.
 *
 * The implementation is based on the paper by Stephen E. Robertson, Steve Walker, Susan Jones,
 * Micheline Hancock-Beaulieu & Mike Gatford (November 1994).
 * that can be found at http://trec.nist.gov/pubs/trec3/t3_proceedings.html.
 *
 * Some modifications have been made to allow for non-negative scoring as suggested here.
 * https://doc.rero.ch/record/16754/files/Dolamic_Ljiljana_-_When_Stopword_Lists_Make_the_Difference_20091218.pdf
 *
 * We also made use of a delta(δ) value of 1, which modifies BM25 to account for an issue against
 * penalizing long documents and allowing shorter ones to dominate. The delta values assures BM25
 * to be lower-bounded. (This makes this class BM25+)
 * http://sifaka.cs.uiuc.edu/~ylv2/pub/cikm11-lowerbound.pdf
 *
 *
 * @author Jericko Tejido <jtbibliomania@gmail.com>
 */
class BM25 implements ScoringInterface
{
    const B = 0.75;

    const K1 = 1.2;

    const K3 = 1000;

    const D = 1;

    protected $b;

    protected $k1;

    protected $k3;

    protected $d;

    public function __construct($b = self::B, $k1 = self::K1, $k3 = self::K3, $d = self::D)
    {
        $this->b = $b;
        $this->k1 = $k1;
        $this->k3 = $k3;
        $this->d = $d;
    }

    /**
     * To avoid negative results when the underlying term tj occurs in more than half of
     * the documents (documentFrequency > numberofDocuments/2) we add 1 before getting log().
     * @param string $term
     * @return float
     */
    public function score($tf, $docLength, $documentFrequency, $keyFrequency, $termFrequency, $collectionLength, $collectionCount, $uniqueTermsCount)
    {
        $score = 0;

        if ($tf != 0) {
            $idf = log(1 + (($collectionCount - $documentFrequency + 0.5) / ($documentFrequency + 0.5)));
            $avg_dl = $docLength / $collectionLength;
            $num = $tf * ($this->k1 + 1);
            $denom = $tf + $this->k1 * (1 - $this->b + $this->b * ($docLength / $avg_dl));
            $score += (($this->k3 + 1) * $keyFrequency / ($this->k3 + $keyFrequency)) * $idf * (($num / $denom) + $this->d);
        }

        return $score;
    }
}

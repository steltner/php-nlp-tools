<?php

namespace NlpTools\Ranking;

/**
 * HiemstraLM is a class for ranking documents against a query based on Hiemstra's PHD thesis for language
 * model.
 * https://pdfs.semanticscholar.org/67ba/b01706d3aada95e383f1296e5f019b869ae6.pdf
 *
 *
 * @author Jericko Tejido <jtbibliomania@gmail.com>
 */
class HiemstraLM implements ScoringInterface
{
    const C = 0.15;

    protected $c;

    public function __construct($c = self::C)
    {
        $this->c = $c;
    }

    /**
     * @param string $term
     * @return float
     */
    public function score($tf, $docLength, $documentFrequency, $keyFrequency, $termFrequency, $collectionLength, $collectionCount, $uniqueTermsCount)
    {
        $score = 0;

        if ($tf != 0) {
            $score += $keyFrequency * log(1 + (($this->c * $tf * $collectionLength) / ((1 - $this->c) * $termFrequency * $docLength)));
        }

        return $score;
    }
}

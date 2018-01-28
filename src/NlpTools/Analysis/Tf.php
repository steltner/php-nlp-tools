<?php

namespace NlpTools\Analysis;

use NlpTools\Documents\TrainingSet;
use NlpTools\FeatureFactories\FeatureFactoryInterface;
use NlpTools\FeatureFactories\DataAsFeatures;

/**
 * tf is the number of occurences of the $term in a document with a known $key.
 */

class Tf extends Statistics
{

    protected $tf;

    /**
     * @param TrainingSet $tset The set of documents for which we will compute token stats
     * @param FeatureFactoryInterface $ff A feature factory to translate the document data to 
     * single tokens
     */
    public function __construct(TrainingSet $tset, FeatureFactoryInterface $ff=null)
    {
        parent::__construct($tset, $ff);
    }

    /**
     * Returns number of occurences of the $term in a document with a known $key.
     * (tf)
     * While FreqDist Class is originally implemented as a one-off use to get tf from a collection of 
     * tokens, this should be used to get tf in relation to the entire corpus collection. Using this in 
     * Ranking should reduce reindexing time.
     *
     * @param  string $term
     * @param  int $key
     * @return int
     */
    public function tf($key, $term)
    {
        if ($this->indexByKey($key)) {
            if (isset($this->tf[$key][$term])) {
                return $this->indexByKey($key)[$term];
            } else {
                return 0;
            }
        } else {
            throw new \Exception('Index offset undefined.');
        }
    }

    /**
     * Returns number of all tokens in a document with a known $key.
     * 
     * @param  int $key
     * @return int
     */
    public function numberofDocumentTokens($key)
    {
        if ($this->indexByKey($key)) {
            return array_sum($this->indexByKey($key));
        } else {
            throw new \Exception('Index offset undefined.');
        }
    }

    /**
     * Returns unique terms from a known $key.
     * (hapax legomena)
     *
     * @param  int $key
     * @return array
     */
    public function hapaxes($key)
    {
        if ($this->indexByKey($key)) {
            return array_filter($this->tf[$key], function($term) {
                return $term == 1;
            });
        } else {
            throw new \Exception('Index offset undefined.');
        }
    }

    public function idf($term){}


}
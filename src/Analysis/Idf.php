<?php

namespace NlpTools\Analysis;

use NlpTools\Documents\TrainingSet;
use NlpTools\FeatureFactories\FeatureFactoryInterface;
use NlpTools\FeatureFactories\DataAsFeatures;

/**
 * tf is the number of occurences of the $term in a document with a known $key.
 * idf is the inverse function of the number of documents in which it occurs.
 */

class Idf extends Statistics
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
     * Returns the idf weight containing the query word in the entire collection.
     * 
     * @param  string $term
     * @return mixed
     */
    public function idf($term)
    {

        if (isset($this->documentFrequency[$term])) {
            return log($this->numberofDocuments/$this->documentFrequency[$term]);
        } else {
            return log($this->numberofDocuments);
        }

    }

    public function tf($key, $term){}

}
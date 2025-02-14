<?php

namespace NlpTools\Analysis;

use Exception;
use NlpTools\Documents\TrainingSet;
use NlpTools\FeatureFactories\FeatureFactoryInterface;
use NlpTools\FeatureFactories\DataAsFeatures;

/**
 * Statistics implements global collection statistics for use in different ranking schemes (DFR,VSM, etc.).
 * numberofTokens is the number of all tokens in the entire collection.
 * numberofDocuments is the number of documents in the collection.
 * termFrequency is the number of occurences of the word in the entire collection.
 * documentFrequency is the number of documents containing the word in the entire collection.
 * hapaxes returns an array of unique terms from a document with a known $key.
 */
abstract class Statistics
{
    protected $numberofCollectionTokens;
    protected $numberofDocuments;
    protected $termFrequency;
    protected $documentFrequency;
    protected $tf;

    /**
     * @param TrainingSet $tset The set of documents for which we will compute token stats
     * @param FeatureFactoryInterface|null $ff A feature factory to translate the document data to
     * single tokens
     */
    public function __construct(TrainingSet $tset, FeatureFactoryInterface $ff = null)
    {
        if ($ff === null) {
            $ff = new DataAsFeatures();
        }

        $tset->setAsKey(TrainingSet::OFFSET_AS_KEY);
        $this->numberofCollectionTokens = 0;
        $this->numberofDocuments = 0;
        foreach ($tset as $class => $doc) {
            $this->numberofDocuments++;
            $tokens = $ff->getFeatureArray($class, $doc);
            $flag = array();
            foreach ($tokens as $term) {
                $this->numberofCollectionTokens++;
                $flag[$term] = isset($flag[$term]) && $flag[$term] === true ? true : false;

                if (!isset($this->tf[$class][$term])) {
                    $this->tf[$class][$term] = 0;
                }
                $this->tf[$class][$term]++;

                if (isset($this->termFrequency[$term])) {
                    $this->termFrequency[$term]++;
                } else {
                    $this->termFrequency[$term] = 1;
                }

                if (isset($this->documentFrequency[$term])) {
                    if ($flag[$term] === false) {
                        $flag[$term] = true;
                        $this->documentFrequency[$term]++;
                    }
                } else {
                    $flag[$term] = true;
                    $this->documentFrequency[$term] = 1;
                }
            }
        }
    }

    /**
     * Returns the idf weight containing the query word in the entire collection.
     *
     * @param string $term
     * @return mixed
     */
    abstract public function idf($term);

    /**
     * Returns number of occurences of the $term in a document with a known $key.
     * (tf)
     * While FreqDist Class is originally implemented as a one-off use to get tf from an array of
     * tokens, this should be used to get tf in relation to the entire corpus collection. Using this in
     * Ranking should reduce reindexing time.
     *
     * @param string $term
     * @param int $key
     * @return int
     */
    abstract public function tf($key, $term);

    /**
     * Returns counted tokens in the entire collection.
     *
     * @param int $key
     * @return array
     */
    public function index()
    {
        return $this->termFrequency;
    }

    /**
     * Returns counted tokens of a document with a known $key.
     *
     * @param int $key
     * @return array
     */
    public function indexByKey($key)
    {
        if (isset($this->tf[$key])) {
            return $this->tf[$key];
        } else {
            throw new Exception('Index offset undefined.');
        }
    }

    /**
     * Returns number of documents in the collection.
     *
     * @return mixed
     */
    public function numberofDocuments()
    {
        return $this->numberofDocuments;
    }

    /**
     * Returns number of occurences of the word in the entire collection.
     *
     * @param string $term
     * @return int
     */
    public function termFrequency($term)
    {
        if (isset($this->termFrequency[$term])) {
            return $this->termFrequency[$term];
        } else {
            return 0;
        }
    }

    /**
     * Returns number of documents containing the word in the entire collection.
     *
     * @param string $term
     * @return int
     */
    public function documentFrequency($term)
    {
        if (isset($this->documentFrequency[$term])) {
            return $this->documentFrequency[$term];
        } else {
            return 0;
        }
    }

    /**
     * Returns total number of all tokens in the entire collection.
     *
     * @return int
     */
    public function numberofCollectionTokens()
    {
        return $this->numberofCollectionTokens;
    }
}

<?php

namespace NlpTools\Classifiers;

use NlpTools\Documents\DocumentInterface;

interface ClassifierInterface
{
    /**
     * Decide in which class C member of $classes would $d fit best.
     *
     * @param array $classes A set of classes
     * @param DocumentInterface $d A Document
     * @return string            A class
     */
    public function classify(array $classes, DocumentInterface $d);
}

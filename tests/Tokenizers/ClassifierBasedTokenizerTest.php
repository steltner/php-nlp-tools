<?php

namespace NlpTools\Tokenizers;

use NlpTools\Classifiers\EndOfSentenceRules;
use PHPUnit\Framework\TestCase;

class ClassifierBasedTokenizerTest extends TestCase
{
    public function testTokenizer()
    {
        $tok = new ClassifierBasedTokenizer(
            new EndOfSentenceRules(),
            new WhitespaceTokenizer()
        );

        $text = "We are what we repeatedly do.
                Excellence, then, is not an act, but a habit.";

        $this->assertEquals(
            array(
                "We are what we repeatedly do.",
                "Excellence, then, is not an act, but a habit.",
            ),
            $tok->tokenize($text)
        );
    }
}

<?php

namespace NlpTools\Stemmers;

use Iterator;
use PHPUnit\Framework\TestCase;

/**
 * This class simply provides a bit of functioanlity to test
 * a stemmer agains two lists of words and stems just to keep
 * the test code a bit DRY
 */
class StemmerTestBase extends TestCase
{
    protected function checkStemmer(Stemmer $stemmer, Iterator $words, Iterator $stems)
    {
        foreach ($words as $word) {
            $stem = $stems->current();
            $this->assertEquals(
                $stemmer->stem($word),
                $stem,
                "The stem for '$word' should be '$stem' not '{$stemmer->stem($word)}'"
            );
            $stems->next();
        }
    }
}

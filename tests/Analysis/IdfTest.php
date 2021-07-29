<?php

namespace NlpTools\Analysis;

use NlpTools\Documents\TokensDocument;
use NlpTools\Documents\TrainingSet;
use PHPUnit\Framework\TestCase;

class IdfTest extends TestCase
{
    public function testIdf()
    {
        $ts = new TrainingSet();
        $ts->addDocument(
            "",
            new TokensDocument(array("a", "b", "c", "d"))
        );
        $ts->addDocument(
            "",
            new TokensDocument(array("a", "c", "d"))
        );
        $ts->addDocument(
            "",
            new TokensDocument(array("a"))
        );

        $idf = new Idf($ts);

        $this->assertEquals(
            0.4054651081081644,
            $idf->idf("c"),
        );
        $this->assertEquals(
            1.0986122886681098,
            $idf->idf("b"),
        );
        $this->assertEquals(
            1.0986122886681098,
            $idf->idf("non-existing"),
        );
        $this->assertEquals(
            0,
            $idf->idf("a")
        );

        $this->assertEquals(
            3,
            $idf->numberofDocuments()
        );

        $this->assertEquals(
            3,
            $idf->termFrequency("a")
        );

        $this->assertEquals(
            1,
            $idf->documentFrequency("b")
        );

        $this->assertEquals(
            8,
            $idf->numberofCollectionTokens()
        );
    }
}

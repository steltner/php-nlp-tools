<?php

namespace NlpTools\Analysis;

use PHPUnit\Framework\TestCase;

/**
 * Test the FreqDist class
 *
 * @author Dan Cardin
 */
class FreqDistTest extends TestCase
{
    public function testSimpleFreqDist()
    {
        $freqDist = new FreqDist(array("time", "flies", "like", "an", "arrow", "time", "flies", "like", "what"));
        $this->assertTrue(count($freqDist->getHapaxes()) === 3);
        $this->assertEquals(9, $freqDist->getTotalTokens());
        $this->assertEquals(6, $freqDist->getTotalUniqueTokens());
    }

    public function testSimpleFreqWeight()
    {
        $freqDist = new FreqDist(array("time", "flies", "like", "an", "arrow", "time", "flies", "like", "what"));
        $this->assertEquals(1, $freqDist->getTotalByToken('an'));
        $this->assertEquals(0.1111111111111111, $freqDist->getTokenWeight('an'));
    }

    public function testEmptyHapaxesFreqDist()
    {
        $freqDist = new FreqDist(array("time", "time", "what", "what"));
        $this->assertTrue(count($freqDist->getHapaxes()) === 0);
        $this->assertEquals(4, $freqDist->getTotalTokens());
        $this->assertEquals(2, $freqDist->getTotalUniqueTokens());
    }

    public function testSingleHapaxFreqDist()
    {
        $freqDist = new FreqDist(array("time"));
        $this->assertTrue(count($freqDist->getHapaxes()) === 1);
        $this->assertEquals(1, $freqDist->getTotalTokens());
        $this->assertEquals(1, $freqDist->getTotalUniqueTokens());
    }
}

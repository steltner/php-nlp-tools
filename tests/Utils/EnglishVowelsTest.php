<?php

namespace NlpTools\Utils;

use PHPUnit\Framework\TestCase;

/**
 * @author Dan Cardin
 */
class EnglishVowelsTest extends TestCase
{
    public function testIsVowel()
    {
        $vowelChecker = VowelsAbstractFactory::factory("English");
        $this->assertTrue($vowelChecker->isVowel("man", 1));
    }

    public function testYIsVowel()
    {
        $vowelChecker = VowelsAbstractFactory::factory("English");
        $this->assertTrue($vowelChecker->isVowel("try", 2));
    }
}

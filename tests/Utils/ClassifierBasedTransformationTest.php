<?php

namespace NlpTools\Utils;

use NlpTools\Classifiers\ClassifierInterface;
use NlpTools\Documents\DocumentInterface;
use PHPUnit\Framework\TestCase;

class ClassifierBasedTransformationTest extends TestCase implements ClassifierInterface
{
    public function classify(array $classes, DocumentInterface $d)
    {
        return $classes[$d->getDocumentData() % count($classes)];
    }

    public function testEvenAndOdd()
    {
        $stubEven = $this->createMock(TransformationInterface::class);
        $stubEven->expects($this->any())
            ->method('transform')
            ->will($this->returnValue('even'));
        $stubOdd = $this->createMock(TransformationInterface::class);
        $stubOdd->expects($this->any())
            ->method('transform')
            ->will($this->returnValue('odd'));

        $transform = new ClassifierBasedTransformation($this);
        $transform->register("even", $stubEven);
        $transform->register("odd", $stubOdd);

        $this->assertEquals(
            "odd",
            $transform->transform(3)
        );
        $this->assertEquals(
            "even",
            $transform->transform(4)
        );
    }
}

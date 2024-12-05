<?php

namespace Swis\PHPStan\Reflection\Tests;

use Faker;
use PHPStan\Testing\PHPStanTestCase;
use Swis\PHPStan\Reflection\FakerProviderReflectionExtension;

class FakerProviderReflectionExtensionTest extends PHPStanTestCase
{
    public function testProviderCustomDataIsAvailableOnFakerGenerator(): void
    {
        $faker = new Faker\Generator;
        $faker->addProvider(new BookProvider($faker));

        $reflectionProvider = self::createReflectionProvider();
        $sut = new FakerProviderReflectionExtension($reflectionProvider, [BookProvider::class]);

        $classReflection = $reflectionProvider->getClass(Faker\Generator::class);

        $this->assertTrue($sut->hasMethod($classReflection, 'customBookIsbn'));
        $this->assertTrue($sut->hasProperty($classReflection, 'customBookIsbn'));
    }

    public function testProviderCustomDataIsNotAvailabledOutsideOfFakerGenerator(): void
    {
        $reflectionProvider = self::createReflectionProvider();
        $sut = new FakerProviderReflectionExtension($reflectionProvider, [BookProvider::class]);

        $classReflection = $reflectionProvider->getClass(BookProvider::class);

        $this->assertFalse($sut->hasMethod($classReflection, 'customBookIsbn'));
        $this->assertFalse($sut->hasProperty($classReflection, 'customBookIsbn'));
    }
}

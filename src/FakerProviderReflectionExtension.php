<?php

namespace Swis\PHPStan\Reflection;

use PHPStan\Analyser\OutOfClassScope;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\MethodsClassReflectionExtension;
use PHPStan\Reflection\MissingMethodFromReflectionException;
use PHPStan\Reflection\PropertiesClassReflectionExtension;
use PHPStan\Reflection\PropertyReflection;
use PHPStan\Reflection\ReflectionProvider;

class FakerProviderReflectionExtension implements PropertiesClassReflectionExtension, MethodsClassReflectionExtension
{
    protected ReflectionProvider $reflectionProvider;

    /**
     * @var class-string[]
     */
    protected array $providerClasses = [];

    /**
     * @var array<string, MethodReflection>
     */
    protected array $methodCache = [];

    /**
     * @var array<string, PropertyReflection>
     */
    protected array $propertyCache = [];

    /**
     * @param  class-string[]  $providerClasses
     */
    public function __construct(ReflectionProvider $reflectionProvider, array $providerClasses)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->providerClasses = $providerClasses;
    }

    public function hasMethod(ClassReflection $classReflection, string $methodName): bool
    {
        return $this->findMethodWithCache($classReflection, $methodName) !== null;
    }

    public function getMethod(ClassReflection $classReflection, string $methodName): MethodReflection
    {
        $method = $this->findMethodWithCache($classReflection, $methodName);

        if ($method === null) {
            // This should never happen, because hasMethod() should always be
            // called first.
            throw new \PHPStan\ShouldNotHappenException();
        }

        return $method;
    }

    public function hasProperty(ClassReflection $classReflection, string $propertyName): bool
    {
        return $this->findPropertyWithCache($classReflection, $propertyName) !== null;
    }

    public function getProperty(ClassReflection $classReflection, string $propertyName): PropertyReflection
    {
        $property = $this->findPropertyWithCache($classReflection, $propertyName);

        if ($property === null) {
            // This should never happen, because hasProperty() should always be
            // called first.
            throw new \PHPStan\ShouldNotHappenException();
        }

        return $property;
    }

    protected function findMethodWithCache(ClassReflection $classReflection, string $methodName): ?MethodReflection
    {
        if (array_key_exists($classReflection->getCacheKey().'-'.$methodName, $this->methodCache)) {
            return $this->methodCache[$classReflection->getCacheKey().'-'.$methodName];
        }

        $methodReflection = $this->findMethod($classReflection, $methodName);

        if ($methodReflection !== null) {
            $this->methodCache[$classReflection->getCacheKey().'-'.$methodName] = $methodReflection;

            return $methodReflection;
        }

        return null;
    }

    protected function findMethod(ClassReflection $classReflection, string $methodName): ?MethodReflection
    {
        if ($classReflection->isGeneric()) {
            return null;
        }

        if ($classReflection->getName() === 'Faker\\Generator') {
            foreach ($this->providerClasses as $providerClass) {
                $providerReflection = $this->reflectionProvider->getClass($providerClass);
                try {
                    $methodReflection = $providerReflection->getMethod($methodName, new OutOfClassScope());
                    if (!$methodReflection->isStatic() && $methodReflection->isPublic()) {
                        return $methodReflection;
                    }
                } catch (MissingMethodFromReflectionException $e) {
                    continue;
                }
            }
        }

        return null;
    }

    protected function findPropertyWithCache(ClassReflection $classReflection, string $propertyName): ?PropertyReflection
    {
        if (array_key_exists($classReflection->getCacheKey().'-'.$propertyName, $this->propertyCache)) {
            return $this->propertyCache[$classReflection->getCacheKey().'-'.$propertyName];
        }

        $propertyReflection = $this->findProperty($classReflection, $propertyName);

        if ($propertyReflection !== null) {
            $this->propertyCache[$classReflection->getCacheKey().'-'.$propertyName] = $propertyReflection;

            return $propertyReflection;
        }

        return null;
    }

    protected function findProperty(ClassReflection $classReflection, string $propertyName): ?PropertyReflection
    {
        $method = $this->findMethodWithCache($classReflection, $propertyName);

        if ($method !== null) {
            return new MethodPropertyReflection($method);
        }

        return null;
    }
}

<?php

namespace Swis\PHPStan\Reflection;

use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\PropertyReflection;
use PHPStan\TrinaryLogic;
use PHPStan\Type\Type;

class MethodPropertyReflection implements PropertyReflection
{
    protected MethodReflection $method;

    public function __construct(MethodReflection $method)
    {
        $this->method = $method;
    }

    public function getDeclaringClass(): ClassReflection
    {
        return $this->method->getDeclaringClass();
    }

    public function isStatic(): bool
    {
        return false;
    }

    public function isPrivate(): bool
    {
        return false;
    }

    public function isPublic(): bool
    {
        return true;
    }

    public function getDocComment(): ?string
    {
        return $this->method->getDocComment();
    }

    public function getReadableType(): Type
    {
        return $this->method->getVariants()[0]->getReturnType();
    }

    public function getWritableType(): Type
    {
        return $this->getReadableType();
    }

    public function canChangeTypeAfterAssignment(): bool
    {
        return false;
    }

    public function isReadable(): bool
    {
        return true;
    }

    public function isWritable(): bool
    {
        return false;
    }

    public function isDeprecated(): TrinaryLogic
    {
        return $this->method->isDeprecated();
    }

    public function getDeprecatedDescription(): ?string
    {
        return $this->method->getDeprecatedDescription();
    }

    public function isInternal(): TrinaryLogic
    {
        return $this->method->isInternal();
    }
}

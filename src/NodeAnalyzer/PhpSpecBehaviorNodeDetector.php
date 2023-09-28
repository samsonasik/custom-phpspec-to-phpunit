<?php

declare(strict_types=1);

namespace Rector\PhpSpecToPHPUnit\NodeAnalyzer;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassLike;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Type\ObjectType;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\NodeTypeResolver\NodeTypeResolver;

final class PhpSpecBehaviorNodeDetector
{
    public function __construct(
        private NodeTypeResolver $nodeTypeResolver,
    ) {
    }

    public function isInPhpSpecBehavior(Node\Stmt\Class_|Node\Stmt\ClassMethod|Node\Expr\MethodCall $node): bool
    {
        if ($node instanceof ClassLike) {
            return $this->nodeTypeResolver->isObjectType($node, new ObjectType('PhpSpec\ObjectBehavior'));
        }

        $scope = $node->getAttribute(AttributeKey::SCOPE);
        if (! $scope instanceof Scope) {
            return false;
        }

        $classReflection = $scope->getClassReflection();
        if (! $classReflection instanceof ClassReflection) {
            return false;
        }

        return $classReflection->isSubclassOf('PhpSpec\ObjectBehavior');
    }
}

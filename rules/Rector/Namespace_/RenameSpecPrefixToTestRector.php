<?php

declare(strict_types=1);

namespace Rector\PhpSpecToPHPUnit\Rector\Namespace_;

use PhpParser\Node;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Namespace_;
use Rector\Core\Rector\AbstractRector;
use Rector\PhpSpecToPHPUnit\StringUtils;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

final class RenameSpecPrefixToTestRector extends AbstractRector
{
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Rename spec\\ to Tests\\ namespace', [
            new CodeSample(
                <<<'CODE_SAMPLE'
namespace spec\SomeNamespace;

class SomeTest
{
}
CODE_SAMPLE
                ,
                <<<'CODE_SAMPLE'
namespace spec\SomeNamespace;

class SomeTest
{
}
CODE_SAMPLE
            ),

        ]);
    }

    /**
     * @return array<class-string<\PhpParser\Node>>
     */
    public function getNodeTypes(): array
    {
        return [Namespace_::class];
    }

    /**
     * @param Namespace_ $node
     */
    public function refactor(Node $node): ?Namespace_
    {
        $namespaceName = $this->getName($node);
        if ($namespaceName === null) {
            return null;
        }

        if (! str_starts_with($namespaceName, 'spec\\')) {
            return null;
        }

        $newNamespaceName = StringUtils::removePrefixes($namespaceName, ['spec\\']);
        $node->name = new Name('Tests\\' . $newNamespaceName);

        return $node;
    }
}
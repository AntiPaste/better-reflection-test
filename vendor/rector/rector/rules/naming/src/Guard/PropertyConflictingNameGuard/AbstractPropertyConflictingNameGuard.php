<?php

declare(strict_types=1);

namespace Rector\Naming\Guard\PropertyConflictingNameGuard;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassLike;
use Rector\Naming\ExpectedNameResolver\ExpectedNameResolverInterface;
use Rector\Naming\Guard\GuardInterface;
use Rector\Naming\PhpArray\ArrayFilter;
use Rector\Naming\ValueObject\RenameValueObjectInterface;
use Rector\NodeNameResolver\NodeNameResolver;

class AbstractPropertyConflictingNameGuard implements GuardInterface
{
    /**
     * @var ExpectedNameResolverInterface
     */
    protected $expectedNameResolver;

    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;

    /**
     * @var ArrayFilter
     */
    private $arrayFilter;

    public function __construct(NodeNameResolver $nodeNameResolver, ArrayFilter $arrayFilter)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->arrayFilter = $arrayFilter;
    }

    public function check(RenameValueObjectInterface $renameValueObject): bool
    {
        $conflictingPropertyNames = $this->resolve($renameValueObject->getClassLike());
        return in_array($renameValueObject->getExpectedName(), $conflictingPropertyNames, true);
    }

    /**
     * @param ClassLike $node
     * @return string[]
     */
    public function resolve(Node $node): array
    {
        $expectedNames = [];
        foreach ($node->getProperties() as $property) {
            $expectedName = $this->expectedNameResolver->resolve($property);
            if ($expectedName === null) {
                /** @var string $expectedName */
                $expectedName = $this->nodeNameResolver->getName($property);
            }

            $expectedNames[] = $expectedName;
        }

        return $this->arrayFilter->filterWithAtLeastTwoOccurences($expectedNames);
    }
}

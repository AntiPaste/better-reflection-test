<?php

declare(strict_types=1);

namespace Rector\DowngradePhp74\Tests\Rector\Property\NoDocBlockDowngradeTypedPropertyRector;

use Iterator;
use Rector\Core\Testing\PHPUnit\AbstractRectorTestCase;
use Rector\Core\ValueObject\PhpVersionFeature;
use Rector\DowngradePhp74\Rector\Property\DowngradeTypedPropertyRector;
use Symplify\SmartFileSystem\SmartFileInfo;

final class DowngradeTypedPropertyRectorTest extends AbstractRectorTestCase
{
    /**
     * @requires PHP 7.4
     * @dataProvider provideData()
     */
    public function test(SmartFileInfo $fileInfo): void
    {
        $this->doTestFileInfo($fileInfo);
    }

    public function provideData(): Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }

    /**
     * @return array<string, mixed[]>
     */
    protected function getRectorsWithConfiguration(): array
    {
        return [
            DowngradeTypedPropertyRector::class => [
                DowngradeTypedPropertyRector::ADD_DOC_BLOCK => false,
            ],
        ];
    }

    protected function getRectorClass(): string
    {
        return DowngradeTypedPropertyRector::class;
    }

    protected function getPhpVersion(): string
    {
        return PhpVersionFeature::BEFORE_TYPED_PROPERTIES;
    }
}

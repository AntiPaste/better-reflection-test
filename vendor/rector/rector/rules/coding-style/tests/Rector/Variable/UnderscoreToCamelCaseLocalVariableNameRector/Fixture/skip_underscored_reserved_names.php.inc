<?php

namespace Rector\CodingStyle\Tests\Rector\Variable\UnderscoreToCamelCaseLocalVariableNameRector\Fixture;

final class SkipUnderscoredReservedNames
{
    public function run()
    {
        isset($_SESSION);
        return $_SERVER['host'];
    }
}

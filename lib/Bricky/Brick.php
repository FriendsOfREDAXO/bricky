<?php

/**
 * This file is part of the Bricky package.
 *
 * @author (c) Friends Of REDAXO
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bricky\Brick;

abstract class Brick
{
    const PREFIX = '__';

    abstract public function getName();

    abstract public function getInput();

    abstract public function getBackendOutput(array $brickValues);

    abstract public function getFrontendOutput(array $brickValues);

    public function getClassName()
    {
        return (new \ReflectionClass($this))->getShortName();
    }

    public function getPrefixedName()
    {
        return strtoupper($this->getClassName()).self::PREFIX;
    }

    public function getFragmentDir()
    {
        return __DIR__.'/Brick/'.$this->getClassName().'/fragments/';
    }

}

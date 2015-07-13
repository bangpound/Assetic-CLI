<?php

namespace Bangpound\Assetic;

use Symfony\Component\Process\ExecutableFinder;

function find_executable($name, $default) {
    $finder = new ExecutableFinder();
    return $finder->find($name, $default);
}

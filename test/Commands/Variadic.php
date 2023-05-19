<?php

namespace Kinikit\CLI\Commands;

/**
 * @name variadic
 * @description Variadic example
 */
class Variadic {

    /**
     * Main handle command
     *
     * @param bool $test1 @argument @required A test argument
     * @param string $test2 @option A test option
     * @param string[] $test3 A test variadic
     *
     * @return void
     */
    public function handleCommand($test1, $test2 = null, ...$test3) {

    }

}
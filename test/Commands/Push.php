<?php

namespace Kinikit\CLI\Commands;

/**
 * @name push
 * @description Push the latest code to source control
 *
 */
class Push {


    /**
     * Main handle command
     *
     * @param bool $overwrite @option @required Overwrite the remote version
     * @param string $branch @argument @required Which branch to commit to
     *
     * @return void
     */
    public function handleCommand($overwrite = false, $branch = "main") {

    }


}
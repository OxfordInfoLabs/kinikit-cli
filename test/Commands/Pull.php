<?php

namespace Kinikit\CLI\Commands;

/**
 * @name pull
 * @description Pull the latest code from source control
 */
class Pull {

    /**
     *
     * @param bool $autoMerge @option Auto merge with the remote version
     * @param bool $logErrors @option Log errors
     * @param string $localDir @argument @required Which local directory to write to
     *
     * @return void
     */
    public function handleCommand($autoMerge = false, $logErrors = false, $localDir = ".") {

    }


}
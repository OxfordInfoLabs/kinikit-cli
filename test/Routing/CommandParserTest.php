<?php

namespace Kinikit\CLI\Routing;

use Kinikit\CLI\Commands\Pull;
use Kinikit\CLI\Commands\Push;
use Kinikit\Core\DependencyInjection\Container;
use PHPUnit\Framework\TestCase;

include_once "autoloader.php";

class CommandParserTest extends TestCase {

    public function testCanGetAllCommands() {

        $commandParser = Container::instance()->get(CommandParser::class);
        $commands = $commandParser->getAllCommands();

        $expectedCommands = [
            "push" => new Command("push", "Push the latest code to source control", Push::class, [
                new Option("overwrite", "Overwrite the remote version", true, "bool")
            ], [
                new Argument("branch", "Which branch to commit to", true)
            ]),
            "pull" => new Command("pull", "Pull the latest code from source control", Pull::class, [
                new Option("autoMerge", "Auto merge with the remote version", false, "bool"),
                new Option("logErrors", "Log errors", false, "bool")
            ], [
                new Argument("localDir", "Which local directory to write to", true)
            ], true)
        ];

        $this->assertEquals($expectedCommands, $commands);

    }

}
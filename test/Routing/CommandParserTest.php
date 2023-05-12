<?php

namespace Kinikit\CLI\Routing;

use Kinikit\Core\DependencyInjection\Container;
use PHPUnit\Framework\TestCase;

include_once "autoloader.php";

class CommandParserTest extends TestCase {

    public function testCanGetAllCommands() {

        $commandParser = Container::instance()->get(CommandParser::class);
        $commands = $commandParser->getAllCommands("./Commands");

        $expectedCommands = [
            new Command("push", "Push the latest code to source control", [
                new Option("overwrite", "Overwrite the remote version", true, "bool")
            ], [
                new Argument("branch", "Which branch to commit to", true)
            ]),
            new Command("pull", "Pull the latest code from source control", [
                new Option("autoMerge", "Auto merge with the remote version", false, "bool"),
                new Option("logErrors", "Log errors", false, "bool")
            ], [
                new Argument("localDir", "Which local directory to write to", true)
            ]),
        ];

        $this->assertEquals($expectedCommands, $commands);

    }

}
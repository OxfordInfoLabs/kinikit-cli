<?php

namespace Kinikit\CLI\Routing;

use Garden\Cli\Cli;
use Kinikit\CLI\Commands\Pull;
use Kinikit\Core\DependencyInjection\Container;
use Kinikit\Core\Testing\MockObject;
use Kinikit\Core\Testing\MockObjectProvider;
use PHPUnit\Framework\TestCase;

include_once "autoloader.php";

class RouterTest extends TestCase {


    /**
     * @var MockObject
     */
    private $commandParser;

    /**
     * @var Router
     */
    private $router;

    public function setUp(): void {
        $this->commandParser = MockObjectProvider::instance()->getMockInstance(CommandParser::class);
    }

    public function testCliCreatedCorrectlyForSimpleDefaultCommand() {

        $this->commandParser->returnValue("getAllCommands", [
            "*" => new Command("", "Default Command", "Test", [], [], true)
        ]);

        $this->router = new Router($this->commandParser);

        $expectedCli = new Cli();
        $expectedCli->command("*");

        $this->assertEquals($expectedCli, $this->router->getCli());


        $this->commandParser->returnValue("getAllCommands", [
            new Command("pull", "Default Command", "Test", [], [], true)
        ]);

        $this->router = new Router($this->commandParser);

        $expectedCli = new Cli();
        $expectedCli->command("*")->command("pull")->description("Default Command");

        $this->assertEquals($expectedCli, $this->router->getCli());

    }


    public function testCliCreatedCorrectlyForDefaultCommandWithOptionsAndArgs() {

        $this->commandParser->returnValue("getAllCommands", [
            "default" => new Command("default", "Default Command", "Test", [
                new Option("option", "some option", true, "string")
            ], [
                new Argument("someArg", "some argument", true)
            ], true)
        ]);

        $this->router = new Router($this->commandParser);

        $expectedCli = new Cli();
        $expectedCli->command("*")
            ->opt("option", "some option", true, "string")
            ->arg("someArg", "some argument", true)
            ->command("default")->description("Default Command")
            ->opt("option", "some option", true, "string")
            ->arg("someArg", "some argument", true);

        $this->assertEquals($expectedCli, $this->router->getCli());

    }

    public function testCliCreatedCorrectlyWithMultipleCommands() {

        $this->commandParser->returnValue("getAllCommands", [
            "push" => new Command("push", "Push the latest code to source control", "test1", [
                new Option("overwrite", "Overwrite the remote version", true, "bool")
            ], [
                new Argument("branch", "Which branch to commit to", true)
            ], true),
            "pull" => new Command("pull", "Pull the latest code from source control", "test2", [
                new Option("autoMerge", "Auto merge with the remote version", false, "bool"),
                new Option("logErrors", "Log errors", false, "bool")
            ], [
                new Argument("localDir", "Which local directory to write to", true)
            ])
        ]);

        $this->router = new Router($this->commandParser);

        $expectedCli = new Cli();
        $expectedCli->command("*")
            ->opt("overwrite", "Overwrite the remote version", true, "bool")
            ->arg("branch", "Which branch to commit to", true)
            ->command("push")->description("Push the latest code to source control")
            ->opt("overwrite", "Overwrite the remote version", true, "bool")
            ->arg("branch", "Which branch to commit to", true)
            ->command("pull")
            ->description("Pull the latest code from source control")
            ->opt("autoMerge", "Auto merge with the remote version", false, "bool")
            ->opt("logErrors", "Log errors", false, "bool")
            ->arg("localDir", "Which local directory to write to", true);

        $this->assertEquals($expectedCli, $this->router->getCli());

    }

    public function testCanRouteValidCommands() {

        $mockCommand = MockObjectProvider::instance()->getMockInstance(Pull::class);
        Container::instance()->set(get_class($mockCommand), $mockCommand);

        $this->commandParser->returnValue("getAllCommands", [
            "pull" => new Command("pull", "Pull the latest code from source control", get_class($mockCommand), [
                new Option("autoMerge", "Auto merge with the remote version", false, "bool"),
                new Option("logErrors", "Log errors", false, "bool")
            ], [
                new Argument("localDir", "Which local directory to write to", true)
            ])
        ]);

        $router = new Router($this->commandParser);
        $router->route(["test", "pull", "--logErrors=false", "--autoMerge=true",  "/tmp/bingo"]);

        $this->assertTrue($mockCommand->methodWasCalled("handleCommand", [
            true, false, "/tmp/bingo"
        ]));

    }
}
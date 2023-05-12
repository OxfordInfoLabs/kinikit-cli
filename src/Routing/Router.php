<?php

namespace Kinikit\CLI\Routing;

use Garden\Cli\Cli;
use Kinikit\Core\DependencyInjection\Container;
use Kinikit\Core\Reflection\ClassInspector;
use Kinikit\Core\Reflection\ClassInspectorProvider;
use Kinikit\Core\Reflection\Method;

class Router {

    /**
     * @var CommandParser
     */
    private $commandParser;

    /**
     * @var Cli
     */
    private $cli;

    /**
     * @var Command[]
     */
    private $commands;

    /**
     * @param CommandParser $commandParser
     */
    public function __construct($commandParser) {
        $this->commandParser = $commandParser;
        $this->createCli();
    }

    /**
     * @return Cli
     */
    public function getCli() {
        return $this->cli;
    }


    public function route($argv) {
        $args = $this->cli->parse($argv);

        $className = $this->commands[($args->getCommand())]->getClassName();
        $classInspectorProvider = new ClassInspectorProvider();
        $class = $classInspectorProvider->getClassInspector($className);

        $commandInstance = Container::instance()->get($className);

        $args = array_merge($args->getOpts() ?? [], $args->getArgs() ?? []);

        $method = $class->getPublicMethod("handleCommand");
        $method->call($commandInstance, $args);
    }

    /**
     * Create the CLI using command parser
     *
     * @return void
     */
    private function createCli() {
        $this->cli = new Cli();
        $this->commands = $this->commandParser->getAllCommands();

        foreach ($this->commands as $command) {
            if ($command->isDefault()) {
                $this->cli->command("*");
                foreach ($command->getOptions() as $option) {
                    $this->cli->opt($option->getName(), $option->getDescription(), $option->isRequired(), $option->getType());
                }
                foreach ($command->getArguments() as $argument) {
                    $this->cli->arg($argument->getName(), $argument->getDescription(), $argument->isRequired());
                }
            }
            if ($command->getName() != "") {
                $this->cli->command($command->getName())->description($command->getDescription());
                foreach ($command->getOptions() as $option) {
                    $this->cli->opt($option->getName(), $option->getDescription(), $option->isRequired(), $option->getType());
                }
                foreach ($command->getArguments() as $argument) {
                    $this->cli->arg($argument->getName(), $argument->getDescription(), $argument->isRequired());
                }
            }
        }


    }

}
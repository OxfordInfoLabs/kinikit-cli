<?php

namespace Kinikit\CLI\Routing;

use Garden\Cli\Cli;
use Kinikit\Core\Bootstrapper;
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


    /**
     * Convenience wrapper to initate routing with a one liner
     *
     * @param $argv
     * @return void
     */
    public static function route($argv) {

        // New initialiser
        Container::instance()->get(Bootstrapper::class);

        // Grab and process the route
        $router = Container::instance()->get(Router::class);
        $router->processRoute($argv);

    }


    public function processRoute($argv) {

        $args = $this->cli->parse($argv);

        $command = $this->commands[($args->getCommand())];

        $className = $command->getClassName();
        $classInspectorProvider = new ClassInspectorProvider();
        $class = $classInspectorProvider->getClassInspector($className);

        $commandInstance = Container::instance()->get($className);


        // CLI args
        $argValues = $args->getArgs();

        // Check args
        $commandArguments = $command->getArguments();
        if (sizeof($commandArguments)) {
            $lastArg = array_pop($commandArguments);
            if ($lastArg->isVariadic()) {
                $newArgs = [];
                $variadics = [];
                foreach ($argValues as $key => $value) {
                    if (is_numeric($key)) {
                        $variadics[] = $value;
                    } else {
                        $newArgs[$key] = $value;
                    }
                }
                $newArgs[$lastArg->getName()] = $variadics;
                $argValues = $newArgs;
            }
        }


        $args = array_merge($args->getOpts() ?? [], $argValues ?? []);

        $method = $class->getPublicMethod("handleCommand");
        try {
            $method->call($commandInstance, $args);
        } catch (\Exception $e) {
            print $this->cli->red($e->getMessage()) . "\n";
        }
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
                    if (!$argument->isVariadic())
                        $this->cli->arg($argument->getName(), $argument->getDescription(), $argument->isRequired());
                }
            }
            if ($command->getName() != "") {
                $this->cli->command($command->getName())->description($command->getDescription());
                foreach ($command->getOptions() as $option) {
                    $this->cli->opt($option->getName(), $option->getDescription(), $option->isRequired(), $option->getType());
                }
                foreach ($command->getArguments() as $argument) {
                    if (!$argument->isVariadic())
                        $this->cli->arg($argument->getName(), $argument->getDescription(), $argument->isRequired());
                }
            }
        }


    }

}
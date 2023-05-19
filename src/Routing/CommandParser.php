<?php

namespace Kinikit\CLI\Routing;

use Kinikit\Core\Reflection\ClassInspectorProvider;

class CommandParser {

    /**
     * @var ClassInspectorProvider
     */
    private $classInspectorProvider;


    /**
     * Construct with deps
     *
     * @param ClassInspectorProvider $classInspectorProvider
     */
    public function __construct($classInspectorProvider) {
        $this->classInspectorProvider = $classInspectorProvider;
    }

    /**
     * @param $basePath
     * @return Command[]
     */
    public function getAllCommands($basePath = ".") {

        $commands = [];
        $d = dir($basePath . "/Commands");

        while (false !== ($entry = $d->read())) {
            $className = substr($entry, 0, strpos($entry, "."));
            if (!$className) {
                continue;
            }

            $classInspector = $this->classInspectorProvider->getClassInspector($basePath . "/Commands/" . $entry);

            $annotations = $classInspector->getClassAnnotations();
            $name = $annotations["name"][0]->getValue();
            $description = $annotations["description"][0]->getValue();
            $default = isset($annotations["default"]);
            $options = [];
            $arguments = [];

            $method = $classInspector->getPublicMethod("handleCommand");

            foreach ($method->getMethodAnnotations()["param"] ?? [] as $param) {

                $paramName = "";
                $arg = true;
                $required = false;

                $new = preg_replace_callback(["/@[a-zA-Z0-9]+/", "/\\$[a-zA-Z0-9]+/"], function ($matches) use (&$paramName, &$arg, &$required) {

                    switch ($matches[0]) {
                        case "@required":
                            $required = true;
                            break;
                        case "@option":
                            $arg = false;
                            break;
                    }

                    if (strpos($matches[0], "$") == 0) {
                        $paramName = substr($matches[0], 1);
                    }

                    return "";
                }, $param->getValue());

                $type = substr($new, 0, strpos($new, " "));
                $paramDescription = trim(substr($new, strpos($new, " ")));

                $reflectionParam = $method->getIndexedParameters()[$paramName] ?? null;

                if ($arg) {
                    $arguments[] = new Argument($paramName, $paramDescription, $required, $reflectionParam ? $reflectionParam->isVariadic() : false);
                } else {
                    $options[] = new Option($paramName, $paramDescription, $required, $type);
                }
            }

            $commands[$name ?? "*"] = new Command($name, $description, ltrim($classInspector->getClassName(), "\\"), $options, $arguments, $default);
        }

        ksort($commands);

        return $commands;

    }
}
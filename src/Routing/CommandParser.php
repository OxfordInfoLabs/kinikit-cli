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
            $options = [];
            $arguments = [];

            foreach ($classInspector->getPublicMethod("handleCommand")->getMethodAnnotations()["param"] as $param) {
                $components = explode(" ", $param->getValue());
                $type = array_shift($components);
                $paramName = substr(array_shift($components), 1);
                $property = substr(array_shift($components), 1);
                $required = false;

                if ($components[0] == "@required") {
                    array_shift($components);
                    $required = true;
                }
                $paramDescription = join(" ", $components);

                switch ($property) {
                    case "argument":
                        $arguments[] = new Argument($paramName, $paramDescription, $required);
                        break;
                    case "option":
                        $options[] = new Option($paramName, $paramDescription, $required, $type);
                        break;
                }
            }

            $commands[] = new Command($name, $description, $options, $arguments);
        }


        return $commands;

    }
}
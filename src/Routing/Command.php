<?php

namespace Kinikit\CLI\Routing;

class Command {

    /***
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $className;

    /**
     * @var Option[]
     */
    private $options;

    /**
     * @var Argument[]
     */
    private $arguments;

    /**
     * @var bool
     */
    private $default;

    /**
     * @param string $name
     * @param string $description
     * @param string $className
     * @param Option[] $options
     * @param Argument[] $arguments
     * @param bool $default
     */
    public function __construct($name, $description, $className, $options = [], $arguments = [], $default = false) {
        $this->name = $name;
        $this->description = $description;
        $this->className = $className;
        $this->options = $options;
        $this->arguments = $arguments;
        $this->default = $default;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description) {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getClassName(): string {
        return $this->className;
    }

    /**
     * @param string $className
     */
    public function setClassName(string $className): void {
        $this->className = $className;
    }

    /**
     * @return Option[]
     */
    public function getOptions() {
        return $this->options;
    }

    /**
     * @param Option[] $options
     */
    public function setOptions($options) {
        $this->options = $options;
    }

    /**
     * @return Argument[]
     */
    public function getArguments() {
        return $this->arguments;
    }

    /**
     * @param Argument[] $arguments
     */
    public function setArguments($arguments) {
        $this->arguments = $arguments;
    }

    /**
     * @return bool
     */
    public function isDefault() {
        return $this->default;
    }

    /**
     * @param bool $default
     */
    public function setDefault($default) {
        $this->default = $default;
    }

}
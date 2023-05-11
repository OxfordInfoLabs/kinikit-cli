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
     * @var Option[]
     */
    private $options;

    /**
     * @var Argument[]
     */
    private $arguments;

    /**
     * @param string $name
     * @param string $description
     * @param Option[] $options
     * @param Argument[] $arguments
     */
    public function __construct($name, $description, $options = [], $arguments = []) {
        $this->name = $name;
        $this->description = $description;
        $this->options = $options;
        $this->arguments = $arguments;
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

}
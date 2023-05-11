<?php

namespace Kinikit\CLI\Routing;

class Argument {

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var bool
     */
    private $required;

    /**
     * @param string $name
     * @param string $description
     * @param bool $required
     */
    public function __construct($name, $description, $required) {
        $this->name = $name;
        $this->description = $description;
        $this->required = $required;
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
     * @return bool
     */
    public function isRequired() {
        return $this->required;
    }

    /**
     * @param bool $required
     */
    public function setRequired($required) {
        $this->required = $required;
    }

}
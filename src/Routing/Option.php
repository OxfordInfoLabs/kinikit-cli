<?php

namespace Kinikit\CLI\Routing;

class Option {

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
     * @var string
     */
    private $type;

    /**
     * @param string $name
     * @param string $description
     * @param bool $required
     * @param string $type
     */
    public function __construct($name, $description, $required, $type) {
        $this->name = $name;
        $this->description = $description;
        $this->required = $required;
        $this->type = $type;
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

    /**
     * @return string
     */
    public function getType() {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type) {
        $this->type = $type;
    }

}
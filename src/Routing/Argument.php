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
     * @var bool
     */
    private $variadic;

    /**
     * @param string $name
     * @param string $description
     * @param bool $required
     * @param bool $variadic
     */
    public function __construct($name, $description, $required, $variadic) {
        $this->name = $name;
        $this->description = $description;
        $this->required = $required;
        $this->variadic = $variadic;
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
     * @return bool
     */
    public function isVariadic() {
        return $this->variadic;
    }

    /**
     * @param bool $variadic
     */
    public function setVariadic( $variadic) {
        $this->variadic = $variadic;
    }

}
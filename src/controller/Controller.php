<?php
namespace Ran\controller;

use \Interop\Container\ContainerInterface;

class controller{
	
	protected $container;

    public function __construct(ContainerInterface $container)
    {

        $this->container = $container;

    }

    public function __get($val)
    {

        return $this->container->{$val};

    }
}
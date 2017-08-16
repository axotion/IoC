<?php

class Animal{

    public $name = null;
    public $age = null;

    public function __construct($name, $age)
    {
        $this->name = $name;
        $this->age = $age;
    }

    public function info(){
        echo 'Animal: '.$this->name."<br> Age: ".$this->age."<br>";
    }
}

class IoC{

    public static $services = [];
    private static $app = null;

    public static function init(){
        self::$app = new IoC();
    }

    public static function bind($serviceName, $callback){
        self::$services[$serviceName] = $callback;
    }

    public static function resolve($serviceName){
        return call_user_func(IoC::$services[$serviceName], self::$app);
    }
}
//Initialize IoC
IoC::init();

//Add new services to container
IoC::bind('fish', function ($app){
    return new Animal('Fish', 1);
});

IoC::bind('cat', function($app){
    return new Animal('Cat', '2');
});

IoC::bind('dog', function($app){
    return new Animal('Dog','4');
});
IoC::bind('goat', function($app){
    //Optionally resolve another service from container 
    $test = $app->resolve('fish');
    $test->info();
    return new Animal('Goat','5');
});

//Resolve services from container

$cat = IoC::resolve('cat');
$dog = IoC::resolve('dog');
$goat = IoC::resolve('goat');

$cat->info();
$dog->info();
$goat->info();

<?php
return [
    
    ['route' => '/', 'method' => 'get','controller'=>'HomeController', 'action'=>'index'],
    ['route' => '/users/{id}/text/{iid}', 'method' => 'get','controller'=>'HomeController', 'action'=>'show'],
    ['route' => '/users', 'method' => 'post','controller'=>'HomeController', 'action'=>'store'],
];
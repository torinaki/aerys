<?php

/**
 * examples/hello_world.php
 * 
 * This is the most basic HTTP/1.1 server you can create; it returns a "hello world" message with
 * a 200 status code for every request it receives. To run:
 * 
 * $ php hello_world.php
 * 
 * Once the server has started, request http://127.0.0.1:1337/ in your browser or client of choice.
 */

require dirname(__DIR__) . '/autoload.php';

date_default_timezone_set('GMT');

$handler = function(array $asgiEnv) {
    $status = 200;
    $headers = [];
    $body = '<html><body><h1>Hello, world.</h1></body></html>';
    
    return [$status, $headers, $body];
};

(new Aerys\ServerFactory)->createServer([[
    'listen'  => '*:1337',
    'name'    => '127.0.0.1',
    'handler' => $handler
]])->listen();

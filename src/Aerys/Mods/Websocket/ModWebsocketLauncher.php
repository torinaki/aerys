<?php

namespace Aerys\Mods\Websocket;

use Auryn\Injector,
    Aerys\Config\ModConfigLauncher,
    Aerys\Config\ConfigException;

class ModWebsocketLauncher extends ModConfigLauncher {
    
    private $modClass = 'Aerys\Mods\Websocket\ModWebsocket';
    private $websocketHandlerClass = 'Aerys\Handlers\Websocket\WebsocketHandler';
    private $priorityMap = [
        'onHeaders' => 35
    ];
    
    function launch(Injector $injector) {
        $config = $this->getConfig();
        
        foreach ($config as $requestUri => $endpointArr) {
            if (!isset($endpointArr['endpoint'])) {
                throw new ConfigException(
                    'ModWebsocket config requires an endpoint key in each URI array element'
                );
            } elseif (is_string($endpointArr['endpoint'])) {
                $endpointArr['endpoint'] = $injector->make($endpointArr['endpoint']);
                $config[$requestUri] = $endpointArr;
            }
        }
        
        $handler = $injector->make($this->websocketHandlerClass, [
            ':endpoints' => $config
        ]);
        
        return $injector->make($this->modClass, [
            ':websocketHandler' => $handler
        ]);
    }
    
    function getModPriorityMap() {
        return $this->priorityMap;
    }
    
}

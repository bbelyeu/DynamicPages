<?php

Router::connect('/admin/pages', array(
    'plugin' => 'DynamicPages',
    'controller' => 'Pages',
    'action' => 'index',
    'prefix' => 'admin'
));

Router::connect('/admin/pages/:action', array(
    'plugin' => 'DynamicPages',
    'controller' => 'Pages',
    'prefix' => 'admin'
));

Router::connect('/admin/pages/:action/:id', array(
    'plugin' => 'DynamicPages',
    'controller' => 'Pages',
    'prefix' => 'admin'
), array(
    'pass' => array('id'),
    'id' => '[0-9]+'
));

// dynamic page routing
Router::connect('/:name', array(
    'plugin' => 'DynamicPages',
    'controller' => 'Pages',
    'action' => 'view'
), array(
    'pass' => array('name')
));

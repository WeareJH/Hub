<?php
return array(

    //router
    'router' => array(
        'routes' => array(
            'overtime' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/overtime[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'JhOvertime\Controller\Overtime',
                        'action'     => 'index',
                    ),
                ),

            ),

        ),
    ),

    //Add Overtime Link to Hub navigation
    'spiffy_navigation' => array(
        'containers' => array(
            'jh_hub' => array(
                array(
                    'options' => array(
                        'name' => 'Overtime',
                        'label' => 'Overtime',
                        'route' => 'overtime',
                    ),
                ),
            ),
        ),
    ),
);

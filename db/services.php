<?php
$functions = array(
    'block_custommodules_associate_courses_with_module' =>  array(         //web service function name
        'classname'   => 'blocks_custommodules_external',  //class containing the external function
        'methodname'  => 'associate_courses_with_module',          //external function name
        'classpath'   => 'blocks/custommodules/externallib.php',  //file containing the class/external function
        'description' => 'Associa cursos ao um módulo',    //human readable description of the web service function
        'type'        => 'write',                  //database rights of the web service function (read, write)
        'ajax' => true,  
        'loginrequired' => true,                 //if enabled, the service can be reachable on a default installation
    ),
    'block_custommodules_delete_module' =>  array(         //web service function name
        'classname'   => 'blocks_custommodules_external',  //class containing the external function
        'methodname'  => 'delete_module',          //external function name
        'classpath'   => 'blocks/custommodules/externallib.php',  //file containing the class/external function
        'description' => 'Exclui um módulo',    //human readable description of the web service function
        'type'        => 'write',                  //database rights of the web service function (read, write)
        'ajax' => true,  
        'loginrequired' => true,                 //if enabled, the service can be reachable on a default installation
    )
);
$services = array(
    'custommodulesservice' => array(                                                //the name of the web service
        'functions' => array ('block_custommodules_associate_courses_with_module','block_custommodules_delete_module'), //web service functions of this service                                                                            //any function of this service. For example: 'some/capability:specified'                 
        'restrictedusers' =>0,                                             //if enabled, the Moodle administrator must link some user to this service
                                                                            //into the administration
        'enabled'=>1,                                                       //if enabled, the service can be reachable on a default installation
     )
);

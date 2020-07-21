<?php
$functions = array(
    'block_customcertificates_associate_modules_with_certificate' =>  array(         //web service function name
        'classname'   => 'block_customcertificates_external',  //class containing the external function
        'methodname'  => 'associate_modules_with_certificate',          //external function name
        'classpath'   => 'blocks/customcertificates/externallib.php',  //file containing the class/external function
        'description' => 'Associa módulos a um certificado',    //human readable description of the web service function
        'type'        => 'write',                  //database rights of the web service function (read, write)
        'ajax' => true,
        'loginrequired' => true,                 //if enabled, the service can be reachable on a default installation
    ),
    'block_customcertificates_delete_certificate' =>  array(         //web service function name
        'classname'   => 'block_customcertificates_external',  //class containing the external function
        'methodname'  => 'delete_certificate',          //external function name
        'classpath'   => 'blocks/customcertificates/externallib.php',  //file containing the class/external function
        'description' => 'Exclui um certificado',    //human readable description of the web service function
        'type'        => 'write',                  //database rights of the web service function (read, write)
        'ajax' => true,
        'loginrequired' => true,                 //if enabled, the service can be reachable on a default installation
    )
);
$services = array(
    'customcertificatesservice' => array(                                                //the name of the web service
        'functions' => array('block_customcertificates_associate_modules_with_certificate', 'block_customcertificates_delete_certificate'), //web service functions of this service                                                                            //any function of this service. For example: 'some/capability:specified'                 
        'restrictedusers' => 0,                                             //if enabled, the Moodle administrator must link some user to this service
        //into the administration
        'enabled' => 1,                                                       //if enabled, the service can be reachable on a default installation
    )
);

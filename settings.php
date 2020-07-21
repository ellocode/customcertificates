<?php

defined('MOODLE_INTERNAL') || die;

$settings = new admin_externalpage(
    'report',
    'Módulos e cursos',
    new moodle_url('/blocks/custommodules/modulelist.php'),
    'moodle/category:manage',
    true
);

<?php  // Moodle configuration file
unset($CFG);
global $CFG;
$CFG = new stdClass();
$CFG->dbhost    = 'localhost';
$CFG->dbname    = 'annotator';
$CFG->dbuser    = 'root';
$CFG->dbpass    = '';
$CFG->wwwroot   = 'http://localhost/annotation';
$CFG->dataroot  = 'F:/annotationdata';
$CFG->admin     = 'admin';
$CFG->prefix     = 'antr';

$CFG->directorypermissions = 0777;

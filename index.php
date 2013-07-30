<?php
include 'application/bootstrap.php';
Core\Application::createWebApplication('application/config/webapplication.php')->run();
var_dump(A::app()->getModuleManager()->load('Main'));
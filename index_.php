<?php
require_once  __DIR__.'/vendor/autoload.php';

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

require __DIR__.'/lib/EasyPDO/easypdo.php';

$dd=new EasyPDO();
dd($dd);

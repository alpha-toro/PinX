<?php
/*
*
* @package launchpad
* @subpackage build
*/

$resources = array();

$resources['pinx_process'] = $modx->newObject('modDocument');
$resources['pinx_process']->set('parent', 0);
$resources['pinx_process']->set('pagetitle', 'PinX Process');
$resources['pinx_process']->set('alias', 'pinx-process');
$resources['pinx_process']->set('template', 0);
$resources['pinx_process']->set('published', 1);
$resources['pinx_process']->set('searchable', 0);
$resources['pinx_process']->set('hidemenu', 1);
$resources['pinx_process']->set('richtext', 0);
$resources['pinx_process']->set('container', 1);
$resources['pinx_process']->setContent('[[PinXProcess]]');
$resources['pinx_process']->save();


return $resources;

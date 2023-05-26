<?php
/**
 * @package PinX
 */
require_once (strtr(realpath(dirname(dirname(__FILE__))), '\\', '/') . '/pinximages.class.php');
class PinXImages_mysql extends PinXImages {}
?>
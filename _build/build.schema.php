<?php
/**
 * PinX
 * PinX is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * PinX is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * PinX; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 */
/**
 * Build Schema script
 *
 * @package pinx
 * @subpackage build
 */
$mtime  = microtime();
$mtime  = explode(" ", $mtime);
$mtime  = $mtime[1] + $mtime[0];
$tstart = $mtime;
set_time_limit(0);

// Define package name
define('PKG_NAME', 'PinX');
define('PKG_NAME_LOWER', strtolower(PKG_NAME));

// Define sources
$root = dirname(dirname(__FILE__)).'/';
$sources = array(
    'root'   => $root,
    'core'   => $root . 'core/components/' . PKG_NAME_LOWER . '/',
    'model'  => $root . 'core/components/' . PKG_NAME_LOWER . '/model/',
    'assets' => $root . 'assets/components/' . PKG_NAME_LOWER . '/',
);

// Load modx and configs
require_once dirname(__FILE__) . '/build.config.php';
include_once MODX_CORE_PATH . 'model/modx/modx.class.php';
$modx = new modX();
$modx->initialize('mgr');
$modx->loadClass('transport.modPackageBuilder', '', false, true);

// Used for nice formatting of log messages
echo '<pre>';
$modx->setLogLevel(modX::LOG_LEVEL_INFO);
$modx->setLogTarget('ECHO');

$manager   = $modx->getManager();
$generator = $manager->getGenerator();
$generator->parseSchema($sources['model'] . 'schema/'.PKG_NAME_LOWER.'.mysql.schema.xml', $sources['model']);

$mtime     = microtime();
$mtime     = explode(" ", $mtime);
$mtime     = $mtime[1] + $mtime[0];
$tend      = $mtime;
$totalTime = ($tend - $tstart);
$totalTime = sprintf("%2.4f s", $totalTime);

echo "\nExecution time: {$totalTime}\n";

exit ();

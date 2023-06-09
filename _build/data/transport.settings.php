<?php
/**
 * PinX
 *
 * pinx is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * pinx is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * pinx; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 */
/**
 * Loads system settings into build
 *
 * @package pinx
 * @subpackage build
 */
$settings = array();

/* Settings for the RTE integration */
$settings['pinx.use_richtext']= $modx->newObject('modSystemSetting');
$settings['pinx.use_richtext']->fromArray(array(
    'key' => 'pinx.use_richtext',
    'value' => true,
    'xtype' => 'combo-boolean',
    'namespace' => 'pinx',
    'area' => 'editor',
),'',true,true);

return $settings;

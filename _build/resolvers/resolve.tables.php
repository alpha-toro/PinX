<?php
/**
 * PinX
 *
 *
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
 * Resolve creating db tables
 *
 * @package PinX
 * @subpackage build
 */
if ($object->xpdo) {
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
            /** @var modX $modx */
            $modx      =& $object->xpdo;
            $modelPath = $modx->getOption('pinx.core_path',null,$modx->getOption('core_path').'components/pinx/').'model/';
            $modx->addPackage('PinX',$modelPath);

            /** @var xPDOManager $manager */
            $manager = $modx->getManager();

            $manager->createObjectContainer('PinXLists');

            break;
        case xPDOTransport::ACTION_UPGRADE:
            break;
    }
}
return true;

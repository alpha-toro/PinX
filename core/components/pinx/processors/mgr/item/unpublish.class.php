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
 *
 * @package pinx
 */
/**
 * Publish an Item
 *
 * @package pinx
 * @subpackage processors
 */
class PinXItemUnpublishProcessor extends modObjectUpdateProcessor {
    public $classKey = 'PinXItem';
    public $languageTopic = array('pinx:default');
    public $objectType = 'pinx.pinx';

    public function beforeSave() {
        $this->object->set('published', 0);

        return true;
    }
}

return 'PinXItemUnpublishProcessor';

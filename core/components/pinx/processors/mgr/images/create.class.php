<?php
/**
 * PinX
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
 *
 * @package PinX
 */
/**
 * Create an Image
 *
 * @package PinX
 * @subpackage processors
 */

 class PinXImaesCreateProcessor extends modObjectCreateProcessor {
    public $classKey = 'PinXImages';
    public $languageTopic = array('pinx:default');
    public $objectType = 'pinx.pinx';

    public function beforeSave() {
        $this->setRank();

        return parent::beforeSave();
    }

    /**
     * New Gallery Sets get added to the end of the list
     *
     * return void
     */
    private function setRank() {
        $count = $this->modx->getCount($this->classKey, [
            'set' => $this->getProperty('set', false)
        ]);
        $this->object->set('rank', $count);
    }
 }

 return 'PinXImagesCreateProcessor';

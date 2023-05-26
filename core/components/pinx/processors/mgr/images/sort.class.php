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
 */
/**
 * Sort two items. This was taken from the DD sort used by splittingred
 * in Gallery (https://github.com/splittingred/Gallery)
 *
 * @package PinX
 * @subpackage processors
 */
class PinXImagesSortProcessor extends modObjectUpdateProcessor {
    public $classKey = 'PinXImages';
    public $languageTopic = array('pinx:default');
    public $objectType = 'pinx.pinx';

    public function initialize() {
        $primaryKey = $this->getProperty('source', false);
        $setKey = $this->getProperty('list', false);
        if (empty($primaryKey)) return $this->modx->lexicon($this->objectType.'_err_ns');
        if (empty($setKey)) return $this->modx->lexicon($this->objectType.'_err_ns');

        $this->object = $this->modx->getObject($this->classKey, [
            'list' => $setKey,
            'id'  => $primaryKey
            ]
        );

        if (empty($this->object)) return $this->modx->lexicon($this->objectType.'_err_nfs',array($this->primaryKeyField => $primaryKey));

        if ($this->checkSavePermission && $this->object instanceof modAccessibleObject && !$this->object->checkPolicy('save')) {
            return $this->modx->lexicon('access_denied');
        }

        return true;
    }

    /**
     * {@inheritDoc}
     * @return mixed
     */
    public function process() {
        /* Run the beforeSet method before setting the fields, and allow stoppage */
        $canSave = $this->beforeSet();
        if ($canSave !== true) {
            return $this->failure($canSave);
        }

        $request = $this->getProperties();

        $source = $this->object;

        $target = $this->modx->getObject($this->classKey, [
            'id'  => $this->getProperty('target', false),
            'list' => $this->getProperty('list', false)
        ]);

        if (empty($target)) {
            return $this->failure();
        }

        if ($source->get('rank') < $target->get('rank')) {
            $this->modx->exec("
                UPDATE {$this->modx->getTableName($this->classKey)}
                  SET rank = rank - 1
                WHERE
                  `list` = " . $this->getProperty('list', false) . "
                AND rank <= {$target->get('rank')}
                AND rank > {$source->get('rank')}
                AND rank > 0
            ");
            $newRank = $target->get('rank');
        } else {
            $this->modx->exec("
                UPDATE {$this->modx->getTableName($this->classKey)}
                  SET rank = rank + 1
                WHERE
                  `list` = " . $this->getProperty('list', false) . "
                AND rank >= {$target->get('rank')}
                AND rank < {$source->get('rank')}
            ");
            $newRank = $target->get('rank');
        }
        $source->set('rank', $newRank);
        $source->save();

        $this->afterSave();

        // Report source (dragged item) was changed
        $this->fireAfterSaveEvent();
        $this->logManagerAction();
        return $this->cleanup();
    }
}

return 'PinXImagesSortProcessor';

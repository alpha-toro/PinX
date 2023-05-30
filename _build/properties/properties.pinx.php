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
 * Properties for the PinX snippet.
 *
 * @package pinx
 * @subpackage build
 */
$properties = array(
    array(
        'name'    => 'tpl',
        'desc'    => 'prop_pinx.tpl_desc',
        'type'    => 'textfield',
        'options' => '',
        'value'   => 'pinx-item-tpl',
        'lexicon' => 'pinx:properties',
    ),
    array(
        'name'    => 'setTpl',
        'desc'    => 'prop_pinx.tpl_desc',
        'type'    => 'textfield',
        'options' => '',
        'value'   => 'pinx-set-tpl',
        'lexicon' => 'pinx:properties',
    ),
    array(
        'name'    => 'sortBy',
        'desc'    => 'prop_pinx.sortby_desc',
        'type'    => 'textfield',
        'options' => '',
        'value'   => 'rank',
        'lexicon' => 'pinx:properties',
    ),
    array(
        'name'    => 'sortDir',
        'desc'    => 'prop_pinx.sortdir_desc',
        'type'    => 'textfield',
        'options' => '',
        'value'   => 'ASC',
        'lexicon' => 'pinx:properties',
    ),
    array(
        'name'    => 'outputSeparator',
        'desc'    => 'prop_pinx.outputseparator_desc',
        'type'    => 'textfield',
        'options' => '',
        'value'   => "\n",
        'lexicon' => 'pinx:properties',
    ),
    array(
        'name'    => 'toPlaceholder',
        'desc'    => 'prop_pinx.toplaceholder_desc',
        'type'    => 'combo-boolean',
        'options' => '',
        'value'   => false,
        'lexicon' => 'pinx:properties',
    ),
);

return $properties;

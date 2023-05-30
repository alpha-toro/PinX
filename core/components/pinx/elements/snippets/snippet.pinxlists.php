<?php
/**
 * PinX snippet to put "lists" in <li> format.
 *
 * @package pinx
 * 
 * USAGE: [[PinXLists? &userid=`1`]]
 * 
 */

$PinX = $modx->getService(
    'pinx',
    'PinX',
    $modx->getOption('pinx.core_path', null, $modx->getOption('core_path').'components/pinx/').'model/pinx/',
    $scriptProperties
);
if (!($PinX instanceof PinX)) return 'No PinX Service';

$tpl                = $modx->getOption('tpl', $scriptProperties, 'pinx-item-tpl');
$setTpl             = $modx->getOption('setTpl', $scriptProperties, null);
$sortBy             = $modx->getOption('sortBy', $scriptProperties, 'rank');
$sortDir            = $modx->getOption('sortDir', $scriptProperties, 'ASC');
$showUnpublished    = $modx->getOption('showUnpublished', $scriptProperties, false);
$output             = '<ul>';

$user = $modx->getUser();

if(!$user->get('id')){
    return 'No User ID set.';
}

/* build query for lists */
$c = $modx->newQuery('PinXSet');
$c->where(array('userid' => $user->get('id')));
$c->sortby($sortBy,$sortDir);

if (!$showUnpublished) {
    $c->where(array(
        'published' => true
    ));
}

$sets = $modx->getCollection('PinXSet', $c);

$list = array();
foreach ($sets as $set) {
    $output .= '<li>'.$set->name.'</li>';
}

$output .= '</ul>';

return $output;
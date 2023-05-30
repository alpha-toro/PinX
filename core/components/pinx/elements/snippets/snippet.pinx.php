<?php
/**
 * The base PinX snippet.
 *
 * @package pinx
 * 
 * USAGE: [[PinX? &listid=`1`]]
 * 
 */

$PinX = $modx->getService(
    'pinx',
    'PinX',
    $modx->getOption('pinx.core_path', null, $modx->getOption('core_path').'components/pinx/').'model/pinx/',
    $scriptProperties
);
if (!($PinX instanceof PinX)) return 'No PinX Service';

$set                = $modx->getOption('listid', $scriptProperties, null);
$tpl                = $modx->getOption('tpl', $scriptProperties, 'pinx-item-tpl');
$setTpl             = $modx->getOption('setTpl', $scriptProperties, null);
$sortBy             = $modx->getOption('sortBy', $scriptProperties, 'rank');
$sortDir            = $modx->getOption('sortDir', $scriptProperties, 'ASC');
$limit              = $modx->getOption('limit', $scriptProperties, null);
$limitImages        = $modx->getOption('limitImages', $scriptProperties, null);
$showUnpublished    = $modx->getOption('showUnpublished', $scriptProperties, false);
$showMenu           = $modx->getOption('showMenu', $scriptProperties, false);
$outputSeparator    = $modx->getOption('outputSeparator', $scriptProperties, "\n");
$setOutputSeparator = $modx->getOption('setOutputSeparator', $scriptProperties, "</div>");

$user = $modx->getUser();
if(!$user->get('id')){
    return 'No User ID Set';
} else {
    $userid = $user->get('id');
}


/* build query for lists */
$c = $modx->newQuery('PinXSet');

if (!empty($set)) {
    $c->where(array(
        'id' => $set,
        'userid' => $userid,
    ));
} else {
    $c->where(array(
        'userid' => $userid,
    ));
}

$c->sortby($sortBy,$sortDir);

if (!$showUnpublished) {
    $c->where(array(
        'published' => true
    ));
}
if (!empty($limit)) $c->limit($limit);

// Get collection 
$sets = $modx->getCollection('PinXSet', $c);

// Loop through found lists and build the output
$list = array();
foreach ($sets as $set) {
    // Empty array to hold output from current set
    $setList  = array();
    $setArray = $set->toArray();

    // Loop through items and set output to array
    $ci = $modx->newQuery('PinXItem');

    // Hide unpublished items
    if (!$showUnpublished) {
        $ci->where(array('published' => true));
    }

    $ci->sortby($modx->quote($sortBy), $sortDir);
    if (!empty($limitImages)) $ci->limit($limitImages);

    foreach ($set->getMany('Item', $ci) as $item) {
        $itemArray = $item->toArray();
        $setList[] = $PinX->getChunk($tpl, $itemArray);
    }

    // If no set template is defined, don't output set data
    if (!empty($setTpl)) {
        $setArray = array_merge($setArray, ['count' => count($setList)]);
        $setHeading = $PinX->getChunk($setTpl, $setArray);
    }

    // Collect output
    if (isset($setHeading)) {
        $list[] = $setHeading . "\n" . implode($outputSeparator, $setList);
    } else {
        $list[] = implode($outputSeparator, $setList);

    }
}

// Build output
$output = implode($setOutputSeparator, $list);
$toPlaceholder = $modx->getOption('toPlaceholder', $scriptProperties, false);
if (!empty($toPlaceholder)) {
    $modx->setPlaceholder($toPlaceholder, $output);
    return '';
}

// By default just return output
return $output;
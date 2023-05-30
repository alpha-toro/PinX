<?php
/**
 * Is Pin button pinned.
 *
 * @package pinx
 * 
 * USAGE: [[PinXIsPinned? &image=``]]
 * 
 */

$PinX = $modx->getService(
    'pinx',
    'PinX',
    $modx->getOption('pinx.core_path', null, $modx->getOption('core_path').'components/pinx/').'model/pinx/',
    $scriptProperties
);
if (!($PinX instanceof PinX)) return 'No PinX Service';

$output = '';
$image = $modx->getOption('image', $scriptProperties, null);

if(!$image){
    return 'No Image Set';
}

$user = $modx->getUser();

if(!$user->get('id')){
    return 'No User ID Set';
} else {
    $userid = $user->get('id');
}

/* build query for lists */
$c = $modx->newQuery('PinXSet');
$c->where(array('userid' => $userid));
$sets = $modx->getCollection('PinXSet', $c);

$list = array();
foreach ($sets as $set) {

    $ci = $modx->newQuery('PinXItem');

    foreach ($set->getMany('Item', $ci) as $item) {
        if($image == $item->image){
            $output = 'pinned';
            break;
        }
    }

}

return $output;
<?php
/**
 * PinX snippet to put "lists" in <option> format for form.
 *
 * @package pinx
 * 
 * USAGE: [[!PinXOptions]]
 * 
 */

$PinX = $modx->getService(
    'pinx',
    'PinX',
    $modx->getOption('pinx.core_path', null, $modx->getOption('core_path').'components/pinx/').'model/pinx/',
    $scriptProperties
);
if (!($PinX instanceof PinX)) return 'No PinX Service';

$sortBy             = $modx->getOption('sortBy', $scriptProperties, 'rank');
$sortDir            = $modx->getOption('sortDir', $scriptProperties, 'ASC');
$showUnpublished    = $modx->getOption('showUnpublished', $scriptProperties, false);
$output             = '<div class="mb-3"><label for="pinxlistid" class="form-label">List in:</label><select class="form-select" name="pinxlistid" id="pinxlistid">';


$user = $modx->getUser();
if(!$user->get('id')){
    return true;
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

if($sets){
    foreach ($sets as $set) {
        $output .= '<option value="'.$set->id.'">'.$set->name.'</option>';
    }
    
    $output .= '</select></div>';
    
    return $output;
}

return '';
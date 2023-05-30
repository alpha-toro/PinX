<?php
/**
 * snippet to list galleries
 *
 * @package pinx
 */

$PinX = $modx->getService(
    'pinx',
    'PinX',
    $modx->getOption('pinx.core_path', null, $modx->getOption('core_path').'components/pinx/').'model/pinx/',
    $scriptProperties
);

if (!($PinX instanceof PinX)) return '';

$set = $modx->getOption('set',$scriptProperties,null);
$tpl = $modx->getOption('tpl',$scriptProperties,'Faqs');
$listTpl = $modx->getOption('listTpl',$scriptProperties,'pinx-set-tpl');
$sortBy = $modx->getOption('sortBy',$scriptProperties,'name');
$sortDir = $modx->getOption('sortDir',$scriptProperties,'ASC');
$limit = $modx->getOption('limit',$scriptProperties,null);
$limitQuestions = $modx->getOption('limitQuestions',$scriptProperties,5);
$outputSeparator = $modx->getOption('outputSeparator',$scriptProperties,"\n");
$listOutputSeparator = $modx->getOption('listOutputSeparator',$scriptProperties,"\n");
$showUnpublished = $modx->getOption('showUnpublished', $scriptProperties, false);

/* build query */
$c = $modx->newQuery('PinXSet');

if (!empty($set)) {
    $field = (is_numeric($set)) ? 'id' : 'name';
    $c->where(array(
        $field => $set,
    ));
}

// Hide unpublished sets
if (!$showUnpublished) {
    $c->where(array('published' => true));
}

$c->sortby($modx->quote($sortBy),$sortDir);
if (!empty($limit)) $c->limit($limit);
$items = $modx->getCollection('PinXSet',$c);

/* iterate through items */
$list = array();

$si = 0;
foreach ($items as $item) {
    $si++;
    $itemArray = $item->toArray();
    $itemArray['setidx'] = $si;

    // get PinXItems of this set
    $criteria = $modx->newQuery('PinXItem');
    if (!$showUnpublished) {
        $criteria->where(array('published' => true));
    }
    $criteria->sortby($modx->quote('rank'),'ASC');
    $criteria->limit($limitQuestions);
    $questions = $item->getMany('Item',$criteria);

    $list = array();
    $qi = 0;
    foreach ($questions as $q) {
        $qi++;
    	$qArray = $q->toArray();
        $qArray['idx'] = $qi;
    	$qArray['set_name'] = $itemArray['name'];
	    $list[] = $PinX->getChunk($listTpl,$qArray);
    }
    $itemArray['images'] = implode($listOutputSeparator,$list);

    $list[] = $PinX->getChunk($tpl,$itemArray);
}

/* output */
$output = implode($outputSeparator,$list);
$toPlaceholder = $modx->getOption('toPlaceholder',$scriptProperties,false);
if (!empty($toPlaceholder)) {
    /* if using a placeholder, output nothing and set output to specified placeholder */
    $modx->setPlaceholder($toPlaceholder,$output);
    return '';
}

/* by default just return output */
return $output;

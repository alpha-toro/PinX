<?php
$PinX = $modx->getService(
    'pinx',
    'PinX',
    $modx->getOption('pinx.core_path', null, $modx->getOption('core_path').'components/pinx/').'model/pinx/',
    $scriptProperties
);
if (!($PinX instanceof PinX)) return '{"status":"400"}';

if($_POST){
    
    $c = $modx->newQuery('PinXItem');
    $c->where(array('id' => $_POST['pinxid']));
    $item = $modx->getObject('PinXItem', $c);
    
    if($item->remove()){
        return '{"status":"200"}';
    } else {
        return '{"status":"400"}';
    }
    
}

return '{"status":"400"}';
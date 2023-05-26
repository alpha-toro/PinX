<?php
/**
 *
 * @package PinX
 * [[!PinXProcessor]]
 * Save Data from custom AJAX Form
 */


 if($_POST){

    $PinX = $modx->getService(
        'pinx',
        'PinX',
        $modx->getOption('pinx.core_path', null, $modx->getOption('core_path').'components/pinx/').'model/pinx/',
        $scriptProperties
    );
    if (!($PinX instanceof PinX)) return 'No PinX Service';
    
}

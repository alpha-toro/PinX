<?php
$PinX = $modx->getService(
    'pinx',
    'PinX',
    $modx->getOption('pinx.core_path', null, $modx->getOption('core_path').'components/pinx/').'model/pinx/',
    $scriptProperties
);
if (!($PinX instanceof PinX)) return '{"status":"400"}';

if($_POST){
    
    $user = $modx->getUser();
    $profile = $user->getOne('Profile');
    $fullname = $profile->fullname;
    
    if(!$user->get('id')){
        return '{"status":"400"}';
    }
    
    $listid = $_POST['pinxlistid'];
    
    if($_POST['pinxnewlist']){
        $record = $modx->newObject('PinXSet');
        $record->set('name',$_POST['pinxnewlist']);
        $record->set('userid',$user->get('id'));
        $record->set('username',$fullname);
        $record->save();
        $listid = $modx->lastInsertId();
    }
    
    $record = $modx->newObject('PinXItem');
    $record->set('set',$listid);
    $record->set('title',$_POST['pinxnote']);
    $record->set('image',$_POST['pinximage']);
    
    if (!$record->save()) {
        return '{"status":"400"}';
    } else {
        return '{"status":"200"}';
    }
    
} else {
    return '{"status":"400"}';
}
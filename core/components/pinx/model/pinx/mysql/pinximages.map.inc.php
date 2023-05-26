<?php
/**
 * @package PinX
 */
$xpdo_meta_map['PinXImages']= array (
  'package' => 'PinX',
  'version' => '1.1',
  'table' => 'pinx_images',
  'extends' => 'xPDOSimpleObject',
  'fields' =>
  array (
    'image' => '',
    'rank' => 0,
    'list' => 0
  ),
  'fieldMeta' =>
  array (
    'image' =>
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'rank' =>
    array (
      'dbtype' => 'integer',
      'precision' => '5',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
    'list' =>
    array (
      'dbtype' => 'integer',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
      'index' => 'index',
    ),
  ),
  'composites' =>
  array (
    'Table' =>
    array (
      'class' => 'PinXLists',
      'local' => 'id',
      'foreign' => 'image',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
);

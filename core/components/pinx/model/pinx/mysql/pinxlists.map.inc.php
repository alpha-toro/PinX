<?php
/**
 * @package PinX
 */
$xpdo_meta_map['PinXLists']= array (
  'package' => 'PinX',
  'version' => '1.1',
  'table' => 'pinx_lists',
  'extends' => 'xPDOSimpleObject',
  'fields' =>
  array (
    'title' => '',
    'description' => '',
    'rank' => 0,
    'owner_name' => '',
    'owner_id' => 0
  ),
  'fieldMeta' =>
  array (
    'title' =>
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'owner_name' =>
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'description' =>
    array (
      'dbtype' => 'text',
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
    'owner_id' =>
    array (
      'dbtype' => 'integer',
      'precision' => '5',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
  ),
  'composites' =>
  array (
    'Table' =>
    array (
      'class' => 'PinXImages',
      'local' => 'id',
      'foreign' => 'list',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
);

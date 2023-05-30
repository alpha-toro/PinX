<?php
/**
 * @package pinx
 */
$xpdo_meta_map['PinXSet']= array (
  'package' => 'pinx',
  'version' => '1.1',
  'table' => 'pinx_set',
  'extends' => 'xPDOSimpleObject',
  'fields' =>
  array (
    'name' => '',
    'description' => '',
    'rank' => 0,
    'userid' => 0,
    'username' => '',
    'published' => 1,
  ),
  'fieldMeta' =>
  array (
    'name' =>
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'username' =>
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'userid' =>
    array (
      'dbtype' => 'integer',
      'precision' => '5',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
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
    'published' =>
    array (
      'dbtype' => 'integer',
      'precision' => '1',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 1,
    ),
  ),
  'composites' =>
  array (
    'Item' =>
    array (
      'class' => 'PinXItem',
      'local' => 'id',
      'foreign' => 'set',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
);

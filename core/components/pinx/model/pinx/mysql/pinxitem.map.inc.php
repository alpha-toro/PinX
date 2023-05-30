<?php
/**
 * @package pinx
 */
$xpdo_meta_map['PinXItem']= array (
  'package' => 'pinx',
  'version' => '1.1',
  'table' => 'pinx_items',
  'extends' => 'xPDOSimpleObject',
  'fields' =>
  array (
    'title' => '',
    'image' => '',
    'rank' => 0,
    'type' => 0,
    'published' => 1,
    'set' => 0,
  ),
  'fieldMeta' =>
  array (
    'title' =>
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'image' =>
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
    'type' =>
    array (
      'dbtype' => 'integer',
      'precision' => '1',
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
    'set' =>
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
  'aggregates' =>
  array (
    'Set' =>
    array (
      'class' => 'PinXSet',
      'local' => 'set',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
);

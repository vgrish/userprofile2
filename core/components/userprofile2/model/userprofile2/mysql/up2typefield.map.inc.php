<?php
$xpdo_meta_map['up2TypeField']= array (
  'package' => 'userprofile2',
  'version' => '1.1',
  'table' => 'up2_type_field',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'name' => NULL,
    'type_in' => NULL,
    'type_out' => NULL,
    'active' => 1,
    'rank' => 0,
  ),
  'fieldMeta' => 
  array (
    'name' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
    ),
    'type_in' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
    ),
    'type_out' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
    ),
    'active' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'phptype' => 'integer',
      'null' => true,
      'default' => 1,
    ),
    'rank' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => true,
      'default' => 0,
    ),
  ),
  'composites' => 
  array (
    'Fields' => 
    array (
      'class' => 'up2Fields',
      'local' => 'id',
      'foreign' => 'type',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
);

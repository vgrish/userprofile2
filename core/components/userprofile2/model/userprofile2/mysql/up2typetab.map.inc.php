<?php
$xpdo_meta_map['up2TypeTab']= array (
  'package' => 'userprofile2',
  'version' => '1.1',
  'table' => 'up2_type_tab',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'name_in' => NULL,
    'name_out' => NULL,
    'description' => NULL,
    'active' => 1,
    'rank' => 0,
  ),
  'fieldMeta' => 
  array (
    'name_in' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
    ),
    'name_out' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
    ),
    'description' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => true,
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
      'foreign' => 'tab',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
    'Tabs' => 
    array (
      'class' => 'up2Tabs',
      'local' => 'id',
      'foreign' => 'tab',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
);

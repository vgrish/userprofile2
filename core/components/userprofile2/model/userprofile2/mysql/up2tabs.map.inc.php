<?php
$xpdo_meta_map['up2Tabs']= array (
  'package' => 'userprofile2',
  'version' => '1.1',
  'table' => 'up2_tabs',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'name' => NULL,
    'description' => NULL,
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
  ),
);

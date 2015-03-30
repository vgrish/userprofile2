<?php
$xpdo_meta_map['up2Profile']= array (
  'package' => 'userprofile2',
  'version' => '1.1',
  'table' => 'up2_profile',
  'extends' => 'xPDOObject',
  'fields' => 
  array (
    'id' => NULL,
    'type' => NULL,
    'lastname' => NULL,
    'firstname' => NULL,
    'secondname' => NULL,
    'registration' => '0000-00-00 00:00:00',
    'lastactivity' => '0000-00-00 00:00:00',
    'ip' => '0.0.0.0',
    'extended' => NULL,
    'properties' => NULL,
  ),
  'fieldMeta' => 
  array (
    'id' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'attributes' => 'unsigned',
      'null' => false,
      'index' => 'pk',
    ),
    'type' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
    ),
    'lastname' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
    ),
    'firstname' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
    ),
    'secondname' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
    ),
    'registration' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
      'null' => true,
      'default' => '0000-00-00 00:00:00',
    ),
    'lastactivity' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
      'null' => true,
      'default' => '0000-00-00 00:00:00',
    ),
    'ip' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '16',
      'phptype' => 'string',
      'null' => true,
      'default' => '0.0.0.0',
    ),
    'extended' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'json',
      'null' => true,
      'index' => 'fulltext',
      'indexgrp' => 'extended',
    ),
    'properties' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'json',
      'null' => true,
      'index' => 'fulltext',
      'indexgrp' => 'extended',
    ),
  ),
  'indexes' => 
  array (
    'id' => 
    array (
      'alias' => 'id',
      'primary' => true,
      'unique' => true,
      'type' => 'BTREE',
      'columns' => 
      array (
        'id' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'type' => 
    array (
      'alias' => 'type',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'type' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'lastname' => 
    array (
      'alias' => 'lastname',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'lastname' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'firstname' => 
    array (
      'alias' => 'firstname',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'firstname' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'secondname' => 
    array (
      'alias' => 'secondname',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'secondname' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'registration' => 
    array (
      'alias' => 'registration',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'registration' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'lastactivity' => 
    array (
      'alias' => 'lastactivity',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'lastactivity' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'ip' => 
    array (
      'alias' => 'ip',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'ip' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
  ),
  'aggregates' => 
  array (
    'User' => 
    array (
      'class' => 'modUser',
      'local' => 'id',
      'foreign' => 'id',
      'owner' => 'foreign',
      'cardinality' => 'one',
    ),
    'UserProfile' => 
    array (
      'class' => 'modUserProfile',
      'local' => 'id',
      'foreign' => 'internalKey',
      'owner' => 'foreign',
      'cardinality' => 'one',
    ),
    'TypeProfile' => 
    array (
      'class' => 'up2TypeProfile',
      'local' => 'type',
      'foreign' => 'id',
      'owner' => 'foreign',
      'cardinality' => 'one',
    ),
  ),
);

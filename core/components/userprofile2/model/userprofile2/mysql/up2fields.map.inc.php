<?php
$xpdo_meta_map['up2Fields'] = array(
    'package'    => 'userprofile2',
    'version'    => '1.1',
    'table'      => 'up2_fields',
    'extends'    => 'xPDOSimpleObject',
    'fields'     =>
        array(
            'name_in'  => null,
            'name_out' => null,
            'tab'      => 0,
            'type'     => 0,
            'css'      => null,
            'value'    => null,
            'length'   => 50,
            'required' => 0,
            'readonly' => 0,
            'editable' => 1,
            'active'   => 1,
            'rank'     => 0,
        ),
    'fieldMeta'  =>
        array(
            'name_in'  =>
                array(
                    'dbtype'    => 'varchar',
                    'precision' => '100',
                    'phptype'   => 'string',
                    'null'      => false,
                ),
            'name_out' =>
                array(
                    'dbtype'    => 'varchar',
                    'precision' => '100',
                    'phptype'   => 'string',
                    'null'      => false,
                ),
            'tab'      =>
                array(
                    'dbtype'     => 'tinyint',
                    'precision'  => '3',
                    'phptype'    => 'integer',
                    'attributes' => 'unsigned',
                    'null'       => true,
                    'default'    => 0,
                ),
            'type'     =>
                array(
                    'dbtype'     => 'tinyint',
                    'precision'  => '3',
                    'phptype'    => 'integer',
                    'attributes' => 'unsigned',
                    'null'       => true,
                    'default'    => 0,
                ),
            'css'      =>
                array(
                    'dbtype'    => 'varchar',
                    'precision' => '100',
                    'phptype'   => 'string',
                    'null'      => false,
                ),
            'value'    =>
                array(
                    'dbtype'    => 'varchar',
                    'precision' => '100',
                    'phptype'   => 'string',
                    'null'      => false,
                ),
            'length'   =>
                array(
                    'dbtype'    => 'smallint',
                    'precision' => '5',
                    'phptype'   => 'integer',
                    'null'      => true,
                    'default'   => 50,
                ),
            'required' =>
                array(
                    'dbtype'    => 'tinyint',
                    'precision' => '1',
                    'phptype'   => 'integer',
                    'null'      => true,
                    'default'   => 0,
                ),
            'readonly' =>
                array(
                    'dbtype'    => 'tinyint',
                    'precision' => '1',
                    'phptype'   => 'integer',
                    'null'      => true,
                    'default'   => 0,
                ),
            'editable' =>
                array(
                    'dbtype'    => 'tinyint',
                    'precision' => '1',
                    'phptype'   => 'integer',
                    'null'      => true,
                    'default'   => 1,
                ),
            'active'   =>
                array(
                    'dbtype'    => 'tinyint',
                    'precision' => '1',
                    'phptype'   => 'integer',
                    'null'      => true,
                    'default'   => 1,
                ),
            'rank'     =>
                array(
                    'dbtype'     => 'tinyint',
                    'precision'  => '1',
                    'attributes' => 'unsigned',
                    'phptype'    => 'integer',
                    'null'       => true,
                    'default'    => 0,
                ),
        ),
    'indexes'    =>
        array(
            'tab'  =>
                array(
                    'alias'   => 'tab',
                    'primary' => false,
                    'unique'  => false,
                    'type'    => 'BTREE',
                    'columns' =>
                        array(
                            'tab' =>
                                array(
                                    'length'    => '',
                                    'collation' => 'A',
                                    'null'      => false,
                                ),
                        ),
                ),
            'type' =>
                array(
                    'alias'   => 'type',
                    'primary' => false,
                    'unique'  => false,
                    'type'    => 'BTREE',
                    'columns' =>
                        array(
                            'type' =>
                                array(
                                    'length'    => '',
                                    'collation' => 'A',
                                    'null'      => false,
                                ),
                        ),
                ),
        ),
    'aggregates' =>
        array(
            'TypeField' =>
                array(
                    'class'       => 'up2TypeField',
                    'local'       => 'type',
                    'foreign'     => 'id',
                    'owner'       => 'foreign',
                    'cardinality' => 'one',
                ),
            'TypeTab'   =>
                array(
                    'class'       => 'up2TypeTab',
                    'local'       => 'tab',
                    'foreign'     => 'id',
                    'owner'       => 'foreign',
                    'cardinality' => 'one',
                ),
        ),
);

<?php
$xpdo_meta_map['up2Tabs'] = array(
    'package'    => 'userprofile2',
    'version'    => '1.1',
    'table'      => 'up2_tabs',
    'extends'    => 'xPDOSimpleObject',
    'fields'     =>
        array(
            'tab'      => 0,
            'type'     => 0,
            'editable' => 1,
            'active'   => 1,
            'rank'     => 0,
        ),
    'fieldMeta'  =>
        array(
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
            'TypeProfile' =>
                array(
                    'class'       => 'up2TypeProfile',
                    'local'       => 'type',
                    'foreign'     => 'id',
                    'owner'       => 'foreign',
                    'cardinality' => 'one',
                ),
            'TypeTab'     =>
                array(
                    'class'       => 'up2TypeTab',
                    'local'       => 'tab',
                    'foreign'     => 'id',
                    'owner'       => 'foreign',
                    'cardinality' => 'one',
                ),
        ),
);

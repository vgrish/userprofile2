<?php

$properties = array();

$tmp = array(
    'tpl'             => array(
        'type'  => 'textfield',
        'value' => 'tpl.up2User.Row',
    ),
    'tplWrapper'      => array(
        'type'  => 'textfield',
        'value' => ''
    ),
    'wrapIfEmpty'     => array(
        'type'  => 'combo-boolean',
        'value' => false
    ),
    'returnIds'       => array(
        'type'  => 'combo-boolean',
        'value' => false
    ),
    'sortby'          => array(
        'type'  => 'textfield',
        'value' => 'modUser.id'
    ),
    'sortdir'         => array(
        'type'    => 'list',
        'options' => array(
            array('text' => 'ASC', 'value' => 'ASC'),
            array('text' => 'DESC', 'value' => 'DESC')
        ),
        'value'   => 'ASC',
    ),
    'limit'           => array(
        'type'  => 'numberfield',
        'value' => 10
    ),
    'offset'          => array(
        'type'  => 'numberfield',
        'value' => 0
    ),
    'outputSeparator' => array(
        'type'  => 'textfield',
        'value' => "\n"
    ),
    'toPlaceholder'   => array(
        'type'  => 'textfield',
        'value' => ''
    ),
    'showLog'         => array(
        'type'  => 'combo-boolean',
        'value' => false
    ),
    'groups'          => array(
        'type'  => 'textfield',
        'value' => ''
    ),
    'roles'           => array(
        'type'  => 'textfield',
        'value' => false
    ),
    'users'           => array(
        'type'  => 'textfield',
        'value' => ''
    ),
    'where'           => array(
        'type'  => 'textfield',
        'value' => ''
    ),
    'showInactive'    => array(
        'type'  => 'combo-boolean',
        'value' => false
    ),
    'showBlocked'     => array(
        'type'  => 'combo-boolean',
        'value' => false
    ),
    'idx'             => array(
        'type'  => 'numberfield',
        'value' => ''
    ),
    'totalVar'        => array(
        'type'  => 'textfield',
        'value' => 'total'
    ),
    'select'          => array(
        'type'  => 'textarea',
        'value' => ''
    ),
    'gravatarIcon'    => array(
        'type'  => 'textfield',
        'value' => 'mm',
    ),
    'gravatarSize'    => array(
        'type'  => 'numberfield',
        'value' => '64',
    ),
    'dateFormat'      => array(
        'type'  => 'textfield',
        'value' => 'd F Y, H:i',
    ),

);

foreach ($tmp as $k => $v) {
    $properties[] = array_merge(
        array(
            'name'    => $k,
            'desc'    => PKG_NAME_LOWER . '_prop_' . $k,
            'lexicon' => PKG_NAME_LOWER . ':properties',
        ), $v
    );
}

return $properties;
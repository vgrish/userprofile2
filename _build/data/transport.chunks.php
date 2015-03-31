<?php

$chunks = array();

$tmp = array(

	'up2.content.main' => array(
		'file' => 'up2_content_main',
		'description' => '',
	),
	'up2.content.sidebar' => array(
		'file' => 'up2_content_sidebar',
		'description' => '',
	),


	// вспомогательные чанки
	// чанк списка пользователей
	'up2.list.users' => array(
		'file' => 'up2_list_users',
		'description' => '',
	),
	// секция инфо
	'up2.info.user.main' => array(
		'file' => 'up2_info_user_main',
		'description' => '',
	),
	// секция заметки
	'up2.tickets.user.main' => array(
		'file' => 'up2_tickets_user_main',
		'description' => '',
	),
	// секция комментарии
	'up2.comments.user.main' => array(
		'file' => 'up2_comments_user_main',
		'description' => '',
	),
	//

	// чанки для сниппетов
	'tpl.up2User.Row' => array(
		'file' => 'up2_user_row',
		'description' => '',
	),
	'tpl.up2User.small.Info' => array(
		'file' => 'up2_user_small_info',
		'description' => '',
	),

	//

/*	'up2All.Users' => array(
		'file' => 'up2_all_users',
		'description' => '',
	),*/


/*	'tpl.userprofile2.item' => array(
		'file' => 'item',
		'description' => '',
	),*/
);

// Save chunks for setup options
$BUILD_CHUNKS = array();

foreach ($tmp as $k => $v) {
	/* @avr modChunk $chunk */
	$chunk = $modx->newObject('modChunk');
	$chunk->fromArray(array(
		'id' => 0,
		'name' => $k,
		'description' => @$v['description'],
		'snippet' => file_get_contents($sources['source_core'] . '/elements/chunks/chunk.' . $v['file'] . '.tpl'),
		'static' => BUILD_CHUNK_STATIC,
		'source' => 1,
		'static_file' => 'core/components/' . PKG_NAME_LOWER . '/elements/chunks/chunk.' . $v['file'] . '.tpl',
	), '', true, true);

	$chunks[] = $chunk;

	$BUILD_CHUNKS[$k] = file_get_contents($sources['source_core'] . '/elements/chunks/chunk.' . $v['file'] . '.tpl');
}

unset($tmp);
return $chunks;
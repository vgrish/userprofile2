<?php

$snippets = array();

$tmp = array(
	// список пользователей
	'up2Users' => array(
		'file' => 'up2_users',
		'description' => '',
	),
	// статистика
	'up2UserTotal' => array(
		'file' => 'up2_total',
		'description' => '',
	),

	// краткая инфа о пользователе
	'up2UserSmallInfo' => array(
		'file' => 'up2_small_info',
		'description' => '',
	),
	// ссылки на секции
	'up2UserLinkSections' => array(
		'file' => 'up2_link_sections',
		'description' => '',
	),
	// вся инфа о пользователе
	'up2UserInfo' => array(
		'file' => 'up2_info',
		'description' => '',
	),
);

foreach ($tmp as $k => $v) {
	/* @avr modSnippet $snippet */
	$snippet = $modx->newObject('modSnippet');
	$snippet->fromArray(array(
		'id' => 0,
		'name' => $k,
		'description' => @$v['description'],
		'snippet' => getSnippetContent($sources['source_core'] . '/elements/snippets/snippet.' . $v['file'] . '.php'),
		'static' => BUILD_SNIPPET_STATIC,
		'source' => 1,
		'static_file' => 'core/components/' . PKG_NAME_LOWER . '/elements/snippets/snippet.' . $v['file'] . '.php',
	), '', true, true);

	$properties = include $sources['build'] . 'properties/properties.' . $v['file'] . '.php';
	$snippet->setProperties($properties);

	$snippets[] = $snippet;
}

unset($tmp, $properties);
return $snippets;
<?php

$snippets = array();

$tmp = array(
	'up2Users' => array(
		'file' => 'up2_users',
		'description' => '',
	),
	'up2UserTotal' => array(
		'file' => 'up2_total',
		'description' => '',
	),
	'up2UserComments' => array(
		'file' => 'up2_comments',
		'description' => '',
	),
	// краткая инфа о пользователе + кэширование
	'up2UserSmallInfo' => array(
		'file' => 'up2_small_info',
		'description' => '',
	),
	// ссылки на секции + кэширование
	'up2UserLinkSections' => array(
		'file' => 'up2_link_sections',
		'description' => '',
	),

	/*'userprofile2' => array(
		'file' => 'userprofile2',
		'description' => '',
	),*/
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
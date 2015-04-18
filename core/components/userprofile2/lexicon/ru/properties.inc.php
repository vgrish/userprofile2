<?php


$_lang['userprofile2_prop_limit'] = 'Лимит выборки результатов';
$_lang['userprofile2_prop_offset'] = 'Пропуск результатов с начала выборки';
$_lang['userprofile2_prop_depth'] = 'Глубина поиска ресурсов от каждого родителя.';
$_lang['userprofile2_prop_sortby'] = 'Сортировка выборки.';
$_lang['userprofile2_prop_sortdir'] = 'Направление сортировки';
$_lang['userprofile2_prop_parents'] = 'Список категорий, через запятую, для поиска результатов. По умолчанию выборка ограничена текущим родителем. Если поставить 0 - выборка не ограничивается.';
$_lang['userprofile2_prop_resources'] = 'Список ресурсов, через запятую, для вывода в результатах. Если id ресурса начинается с минуса, этот ресурс исключается из выборки.';
$_lang['userprofile2_prop_threads'] = 'Список веток комментариев, через запятую, для вывода в результатах. Если id ветки начинается с минуса, то она исключается из выборки.';
$_lang['userprofile2_prop_where'] = 'Строка, закодированная в JSON, с дополнительными условиями выборки.';
$_lang['userprofile2_prop_tvPrefix'] = 'Префикс для ТВ плейсхолдеров, например "tv.". По умолчанию параметр пуст.';
$_lang['userprofile2_prop_includeContent'] = 'Выбирать поле "content" у ресурсов.';
$_lang['userprofile2_prop_includeTVs'] = 'Список ТВ параметров для выборки, через запятую. Например: "action,time" дадут плейсхолдеры [[+action]] и [[+time]].';
$_lang['userprofile2_prop_toPlaceholder'] = 'Если не пусто, сниппет сохранит все данные в плейсхолдер с этим именем, вместо вывода не экран.';
$_lang['userprofile2_prop_outputSeparator'] = 'Необязательная строка для разделения результатов работы.';
$_lang['userprofile2_prop_showLog'] = 'Показывать дополнительную информацию о работе сниппета. Только для авторизованных в контекте "mgr".';
$_lang['userprofile2_prop_showUnpublished'] = 'Показывать неопубликованные ресурсы.';
$_lang['userprofile2_prop_showDeleted'] = 'Показывать удалённые ресурсы.';
$_lang['userprofile2_prop_showHidden'] = 'Показывать ресурсы, скрытые в меню.';
$_lang['userprofile2_prop_fastMode'] = 'Если включено - в чанк результата будут подставлены только значения из БД. Все необработанные теги MODX, такие как фильтры, вызов сниппетов и другие - будут вырезаны.';
$_lang['userprofile2_prop_action'] = 'Режим работы сниппета';
$_lang['userprofile2_prop_cacheKey'] = 'Имя кэша сниппета. Если пустое - кэширование результатов будет отключено.';
$_lang['userprofile2_prop_cacheTime'] = 'Время кэширования.';
$_lang['userprofile2_prop_thread'] = 'Имя ветки комментариев. По умолчанию, "resource-[[*id]]".';
$_lang['userprofile2_prop_user'] = 'Выбрать только элементы, созданные этим пользователем.';
$_lang['userprofile2_prop_tpl'] = 'Чанк оформления для каждого результата';

$_lang['userprofile2_prop_dateFormat'] = 'Формат даты комментария, для функции date()';
$_lang['userprofile2_prop_gravatarIcon'] = 'Если аватарка пользователя не найдена, грузить эту картинку на замену.';
$_lang['userprofile2_prop_gravatarSize'] = 'Размер загружаемого аватара';
$_lang['userprofile2_prop_gravatarUrl'] = 'Адрес для загрузки аватаров';

$_lang['userprofile2_prop_tplWrapper'] = 'Чанк-обёртка, для заворачивания всех результатов. Понимает один плейсхолдер: [[+output]]. Не работает вместе с параметром "toSeparatePlaceholders".';
$_lang['userprofile2_prop_cacheKey'] = 'Имя кэша сниппета. Если пустое - кэширование результатов будет отключено.';
$_lang['userprofile2_prop_cacheTime'] = 'Время кэширования.';

$_lang['userprofile2_prop_avatarPath'] = 'Директория для сохранения аватаров пользователей внутри MODX_ASSETS_PATH. По умолчанию - "images/users/".';
$_lang['userprofile2_prop_avatarParams'] = 'JSON строка с параметрами конвертации аватара при помощи phpThumb. По умолчанию - "{"w":274,"h":274,"zc":1,"q":90,"bg":"ffffff","f":"jpg"}".';
$_lang['userprofile2_prop_placeholderPrefix'] = 'Префикс плейсходера.';
$_lang['userprofile2_prop_processSection'] = 'Режим работы сниппета. Будут обработаны только указанные секции';
$_lang['userprofile2_prop_toPlaceholders'] = 'Если не пусто, сниппет сохранит все данные в плейсхолдеры, вместо вывода не экран.';
$_lang['userprofile2_prop_tplCount'] = 'Чанк оформления для каждого результата';
$_lang['userprofile2_prop_tplCounts'] = 'Чанк оформления всех результатов, игнорируется при выводе в плейсходер';
$_lang['userprofile2_prop_returnIds'] = 'Возвращать строку со списком id ресурсов, вместо оформленных результатов.';
$_lang['userprofile2_prop_users'] = 'Список пользователей для вывода, через запятую. Можно использовать usernames и id. Если значение начинается с тире, этот пользователь исключается из выборки.';
$_lang['userprofile2_prop_groups'] = 'Список групп пользователей, через запятую. Можно использовать имена и id. Если значение начинается с тире, значит пользователь не должен присутствовать в этой группе.';
$_lang['userprofile2_prop_roles'] = 'Список ролей пользователей, через запятую. Можно использовать имена и id. Если значение начинается с тире, значит такой роли у пользователя быть не должно.';

$_lang['userprofile2_prop_showInactive'] = 'Показать неактивных.';
$_lang['userprofile2_prop_showBlocked'] = 'Показать заблокированных.';
$_lang['userprofile2_prop_idx'] = 'Вы можете указать стартовый номер итерации вывода результатов.';
$_lang['userprofile2_prop_totalVar'] = 'Имя плейсхолдера для сохранения общего количества результатов.';
$_lang['userprofile2_prop_select'] = 'Список полей для выборки, через запятую. Можно указывать JSON строку с массивом, например {"modResource":"id,pagetitle,content"}.';
$_lang['userprofile2_prop_loadModels'] = 'Список компонентов, через запятую, чьи модели нужно загрузить для построения запроса. Например: "&loadModels=`ms2gallery,msearch2`".';

$_lang['userprofile2_prop_user_id'] = 'Id пользователя.';
$_lang['userprofile2_prop_enabledTabs'] = 'Включить обработку вкладок.';
$_lang['userprofile2_prop_activeTab'] = 'Указать активную вкладку.';
$_lang['userprofile2_prop_excludeFields'] = 'Список исключенных полей, через запятую.';
$_lang['userprofile2_prop_excludeTabs'] = 'Список исключенных вкладок, через запятую.';

$_lang['userprofile2_prop_js'] = 'Подключаемый скрипт.';
$_lang['userprofile2_prop_tplSectionOuter'] = 'Чанк-обертка для секции вкладок.';
$_lang['userprofile2_prop_tplSectionRow'] = 'Чанк оформления для ссылки на секцию.';

$_lang['userprofile2_prop_tplProfile'] = 'Чанк для вывода и редактирования профиля пользователя.';
$_lang['userprofile2_prop_tplConfirm'] = 'Чанк для оформления письма подтверждения.';

$_lang['userprofile2_prop_tplUser'] = 'Общий чанк оформления информации о пользователе.';
$_lang['userprofile2_prop_tplNoUser'] = 'Общий чанк оформления если пользователе не указан';
$_lang['userprofile2_prop_redirectConfirm'] = 'Идентификатор ресурса, на который отправлять юзера после подтверждения.';

$_lang['userprofile2_prop_tplTabsOuter'] = 'Чанк-обертка для секции табов.';
$_lang['userprofile2_prop_tplNavTabsOuter'] = 'Чанк-обертка для секции ссылок табов.';
$_lang['userprofile2_prop_tplNavTabsRow'] = 'Чанк оформления для ссылки на секцию.';
$_lang['userprofile2_prop_tplContentTabsOuter'] = 'Чанк-обертка для секции вкладок.';
$_lang['userprofile2_prop_tplContentTabPane'] = 'Чанк-обертка для секции.';
$_lang['userprofile2_prop_tplContentTabPaneInputRow'] = 'Чанк для поля ввода.';
$_lang['userprofile2_prop_tplContentTabPaneTextareaRow'] = 'Чанк для текстовой области ввода.';

$_lang['userprofile2_prop_Sections'] = 'Список секций в формате "tickets:/users/[id]/tickets/". Наименование секции: ссылка на секцию. Параметр "[id]" будет заменен на id пользователя.';
$_lang['userprofile2_prop_tplSectionOuter'] = 'Чанк-обертка для секции ссылок.';
$_lang['userprofile2_prop_tplSectionRow'] = 'Чанк для ссылки.';
$_lang['userprofile2_prop_tplCountWrapper'] = 'Чанк-обертка для счетчика.';
$_lang['userprofile2_prop_plSection'] = 'Плейсходер активной секции.';
$_lang['userprofile2_prop_plCountPrefix'] = 'Плейсходер счетчиков для секций.';
$_lang['userprofile2_prop_type'] = 'Идентификатор профиля.';
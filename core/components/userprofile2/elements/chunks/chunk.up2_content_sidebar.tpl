<div class="sidebar-block">
    [[!up2UserSmallInfo?
    &tplUser=`@INLINE
    <h4 class="title">
        <a href="/users/[[!+id]]/">[[!+firstname]]</a>
    </h4>
    <div class="row">
        <div class="col-md-4">
            <div>
                <i class="glyphicon glyphicon-user"></i>
                <a href="/users/[[!+id]]/">Профиль</a>
            </div>
            <div style="margin-top:10px;">
                <i class="glyphicon glyphicon-pencil"></i>
                <a href="/topic/">Написать</a>
            </div>
        </div>
        <div class="col-md-4">
            <div>
                <i class="black glyphicon glyphicon-cog"></i>
                <a href="/users/settings/">Настройки</a>
            </div>
            <div style="margin-top:10px;">
                <i class="black glyphicon glyphicon-off"></i>
                <a href="/?action=auth/logout">Выход</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="up2-avatar-wrapper">
                <img src="[[!+avatar]]" class="up2-avatar">
            </div>
        </div>
    </div>
    `
    &tplNoUser=`@INLINE
    <div id="office-remote-form" class="sidebar-block">
        <h4 class="title">Авторизация</h4>
        <p class="alert alert-block alert-warning">
            <big>
                <b>
                    <a href="#auth" rel="nofollow">Вход </a>
                </b>
            </big>
            <br>
            <small>
                information...
            </small>
        </p>
    </div>
    `
    &user_id=`[[!+modx.user.id]]`
    ]]
    <div class="clearfix"></div>
</div>
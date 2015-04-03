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
                    <a href="/users/[[!+id]]/">[[%up2_profile]]</a>
                </div>
                <div style="margin-top:10px;">
                    <i class="glyphicon glyphicon-pencil"></i>
                    <a href="/topic/">[[%up2_write]]</a>
                </div>
            </div>
            <div class="col-md-4">
                <div>
                    <i class="black glyphicon glyphicon-cog"></i>
                    <a href="/users/settings/">[[%up2_settings]]</a>
                </div>
                <div style="margin-top:10px;">
                    <i class="black glyphicon glyphicon-off"></i>
                    <a href="/?action=auth/logout">[[%up2_logout]]</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="up2-avatar-wrapper">
                    <img src="[[!+avatar]]" class="up2-avatar">
                </div>
            </div>
        </div>
        `
        &user_id=`[[!+modx.user.id]]`
    ]]
    <div class="clearfix"></div>
</div>
[[-!upUserTotal?
&user=`[[+id]]`
]]
<div class="up2-list-row">
    <div class="row">
        <div class="col-md-2 col-avatar">
            <div class="up2-avatar-wrapper">
                <img src="[[+avatar]]" class="up2-avatar">
            </div>
        </div>
        <div class="col-md-6">
            <div class="firstname">
                <a href="/users/[[+id]]/">[[+firstname]]</a>
            </div>
            <div class="registered">
                [[%up2_registration]]: [[!+registration_format]]
            </div>
            <div class="lastactivity">
                [[%up2_lastactivity]]: [[!+lastactivity_format]]
            </div>
        </div>
        <div class="col-md-2">
            <a href="/users/[[+id]]/tickets/">
                [[!up2UserTotal?
                &user_id=`[[+id]]`
                &toPlaceholders=`0`
                &processSection=`tickets,,`
                ]]
            </a></div>
        <div class="col-md-2">
            <a href="/users/[[+id]]/comments/">
                [[!up2UserTotal?
                &user_id=`[[+id]]`
                &toPlaceholders=`0`
                &processSection=`,comments,`
                ]]
            </a></div>
    </div>
</div>
<br>
<br>
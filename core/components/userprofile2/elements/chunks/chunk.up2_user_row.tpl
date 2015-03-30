[[-!upUserTotal?
&user=`[[+id]]`
]]
<div class="userprofile-list-row">
    <div class="row">
        <div class="col-md-2 col-avatar">
            <div class="userprofile-avatar-wrapper">
                <img src="[[+avatar]]" class="userprofile-avatar">
            </div>
        </div>
        <div class="col-md-6">
            <div class="fullname">
                <a href="[[+main_url]]/[[+id]]/">[[+fullname]]</a>
            </div>
            <div class="registered">
                [[%up2_field_registration]]: [[!+registration_format]]
            </div>
            <div class="lastactivity">
                [[%up2_field_lastactivity]]: [[!+lastactivity_format]]
            </div>
        </div>
        <div class="col-md-2">
            <a href="[[+main_url]]/[[+id]]/tickets/">
                [[-!+up.total.tickets]]
                [[upUserTotal?
                &user=`[[!+id]]`
                &toPlaceholders=`0`
                &processSection=`tickets,,`
                ]]
            </a></div>
        <div class="col-md-2">
            <a href="[[+main_url]]/[[+id]]/comments/">
                [[-!+up.total.comments]]
                [[upUserTotal?
                &user=`[[!+id]]`
                &toPlaceholders=`0`
                &processSection=`,comments,`
                ]]
            </a></div>
    </div>
</div>
<br>
<br>
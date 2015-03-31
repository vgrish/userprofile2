<div id="tickets-wrapper">
    <div id="tickets-rows">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-6"></div>
            <div class="col-md-2">[[%up2_tickets]]</div>
            <div class="col-md-2">[[%up2_comments]]</div>
        </div>
        <br>

        [[!pdoPage?
            &element=`up2Users`
            &showInactive=`1`
            &limit=`10`
        ]]

        [[!+page.nav]]

    </div>
</div>

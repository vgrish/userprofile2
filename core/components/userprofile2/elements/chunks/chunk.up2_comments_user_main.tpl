[[up2UserSmallInfo?
    &user_id=`[[+vp.user_id]]`
]]

[[up2UserLinkSections?
    &id=`[[+vp.user_id]]`
    &plSection=`[[+vp.section]]`
]]

[[!pdoPage?
    &element=`TicketLatest`
    &tpl=`tpl.Tickets.comment.list.row`
    &user=`[[!+vp.user_id]]`
    &parents=`0`
]]

[[!+page.nav]]
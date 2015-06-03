<?php

/**
 * This software is intended for use with Oxwall Free Community Software http://www.oxwall.org/ and is
 * licensed under The BSD license.

 * ---
 * Copyright (c) 2013, Oxwall Foundation
 * All rights reserved.

 * Redistribution and use in source and binary forms, with or without modification, are permitted provided that the
 * following conditions are met:
 *
 *  - Redistributions of source code must retain the above copyright notice, this list of conditions and
 *  the following disclaimer.
 *
 *  - Redistributions in binary form must reproduce the above copyright notice, this list of conditions and
 *  the following disclaimer in the documentation and/or other materials provided with the distribution.
 *
 *  - Neither the name of the Oxwall Foundation nor the names of its contributors may be used to endorse or promote products
 *  derived from this software without specific prior written permission.

 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES,
 * INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR
 * PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
 * PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED
 * AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

/**
 * @author Podyachev Evgeny <joker.OW2@gmail.com>
 * @package ow_plugins.socialsharing
 * @since 1.6
 */
OW::getRouter()->addRoute( 
    new OW_Route('socialsharing.admin', 'admin/plugins/social-sharing', 'SOCIALSHARING_CTRL_Admin', 'index')
);

OW::getRouter()->addRoute(
    new OW_Route('socialsharing.default_image', 'admin/plugins/social-sharing/default-image', 'SOCIALSHARING_CTRL_Admin', 'defaultImage')
);

/* OW::getRouter()->addRoute(
    new OW_Route('socialsharing.place_list', 'admin/plugins/social-sharing/place_list', 'SOCIALSHARING_CTRL_Admin', 'placeList')
); */

SOCIALSHARING_CLASS_EventHandler::getInstance()->genericInit();

function socialsharing_add_admin_notification( BASE_CLASS_EventCollector $coll )
{
    $config = OW::getConfig();

    if ( $config->getValue('socialsharing', 'api_key') )
    {
        return;
    }

    $coll->add(
            OW::getLanguage()->text( 'socialsharing', 'plugin_installation_notice', array('url' => OW::getRouter()->urlForRoute('socialsharing.admin') ) )
        );
}
OW::getEventManager()->bind('admin.add_admin_notification', 'socialsharing_add_admin_notification');

/*
function socialsharing_events_content_space_between_description_and_wall( BASE_CLASS_EventCollector $event )
{
    $cmp = new SOCIALSHARING_CMP_ShareButtons("ow_left");
    $event->add($cmp->render());
}

OW::getEventManager()->bind('events.view.content.between_description_and_wall', 'socialsharing_events_content_space_between_description_and_wall');

function socialsharing_virtual_gifts_content_between_gift_and_send_button( BASE_CLASS_EventCollector $event )
{
    $cmp = new SOCIALSHARING_CMP_ShareButtons();
    $event->add($cmp->render());
}

OW::getEventManager()->bind('virtualgifts.gifts_view.content.between_gift_and_send_button', 'socialsharing_virtual_gifts_content_between_gift_and_send_button');

function socialsharing_blogs_content_after_archive( BASE_CLASS_EventCollector $event )
{
    $cmp = new SOCIALSHARING_CMP_ShareButtons();
    $event->add($cmp->render());
}

OW::getEventManager()->bind('blogs.buser_blog.content.after_archive', 'socialsharing_blogs_content_after_archive');

function socialsharing_blogs_view_content_after_blog_post( BASE_CLASS_EventCollector $event )
{
    $cmp = new SOCIALSHARING_CMP_ShareButtons("ow_std_margin");
    $event->add($cmp->render());
}

OW::getEventManager()->bind('blogs.blog_view.content.after_blog_post', 'socialsharing_blogs_view_content_after_blog_post');

function socialsharing_groups_brief_info_content_after_group_description( BASE_CLASS_EventCollector $event )
{
    $cmp = new SOCIALSHARING_CMP_ShareButtons();
    $event->add($cmp->render());
}

OW::getEventManager()->bind('groups.brief_info.content.after_group_description', 'socialsharing_groups_brief_info_content_after_group_description');

function socialsharing_links_after_link_description( BASE_CLASS_EventCollector $event )
{
    $cmp = new SOCIALSHARING_CMP_ShareButtons("ow_std_margin");
    $event->add($cmp->render());
}

OW::getEventManager()->bind('links.link_view.content.after_link_description', 'socialsharing_links_after_link_description');

function socialsharing_photo_floatbox_between_description_and_wall( BASE_CLASS_EventCollector $event )
{
    $cmp = new SOCIALSHARING_CMP_ShareButtons("ow_std_margin");
    $event->add($cmp->render());
}

OW::getEventManager()->bind('photo.photo_floatbox.content.between_description_and_wall', 'socialsharing_photo_floatbox_between_description_and_wall');

function socialsharing_photo_album_after_content( BASE_CLASS_EventCollector $event )
{
    $cmp = new SOCIALSHARING_CMP_ShareButtons("ow_std_margin");
    $event->add($cmp->render());
}

OW::getEventManager()->bind('photo.photo_album.content.after_content', 'socialsharing_photo_album_after_content');

function socialsharing_video_view_between_video_and_wall( BASE_CLASS_EventCollector $event )
{
    $cmp = new SOCIALSHARING_CMP_ShareButtons("ow_std_margin");
    $event->add($cmp->render());
}

OW::getEventManager()->bind('video.video_view.content.between_video_and_wall', 'socialsharing_video_view_between_video_and_wall');

function socialsharing_forum_post_after_first_post( BASE_CLASS_EventCollector $event )
{
    $cmp = new SOCIALSHARING_CMP_ShareButtons("ow_std_margin");
    $event->add($cmp->render());
}

OW::getEventManager()->bind('forum.topic.content.after_first_post', 'socialsharing_forum_post_after_first_post');


function socialsharing_newsfeed_item_content_right( BASE_CLASS_EventCollector $event )
{
    $cmp = new SOCIALSHARING_CMP_ShareButtons();
    $event->add($cmp->render());
}

OW::getEventManager()->bind('newsfeed.item.content.right', 'socialsharing_newsfeed_item_content_right');

*/

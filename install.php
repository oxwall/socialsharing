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

if ( !OW::getConfig()->configExists('socialsharing', 'api_key') )
{
    OW::getConfig()->addConfig('socialsharing', 'api_key', '');
}

if ( !OW::getConfig()->configExists('socialsharing', 'order') )
{
    OW::getConfig()->addConfig('socialsharing', 'order', '');
}

// sharing servises

if ( !OW::getConfig()->configExists('socialsharing', 'facebook') )
{
    OW::getConfig()->addConfig('socialsharing', 'facebook', 1);
}

if ( !OW::getConfig()->configExists('socialsharing', 'twitter') )
{
    OW::getConfig()->addConfig('socialsharing', 'twitter', 1);
}

if ( !OW::getConfig()->configExists('socialsharing', 'googlePlus') )
{
    OW::getConfig()->addConfig('socialsharing', 'googlePlus', 1);
}

if ( !OW::getConfig()->configExists('socialsharing', 'pinterest') )
{
    OW::getConfig()->addConfig('socialsharing', 'pinterest', 1);
}

// sharing place
/* 
if ( !OW::getConfig()->configExists('socialsharing', 'place_base') )
{
    OW::getConfig()->addConfig('socialsharing', 'place_base', '1');
}

if ( !OW::getConfig()->configExists('socialsharing', 'place_virtual') )
{
    OW::getConfig()->addConfig('socialsharing', 'place_virtual', '1');
}

if ( !OW::getConfig()->configExists('socialsharing', 'place_events') )
{
    OW::getConfig()->addConfig('socialsharing', 'place_events', '1');
}

if ( !OW::getConfig()->configExists('socialsharing', 'place_blogs') )
{
    OW::getConfig()->addConfig('socialsharing', 'place_blogs', '1');
}

if ( !OW::getConfig()->configExists('socialsharing', 'place_groups') )
{
    OW::getConfig()->addConfig('socialsharing', 'place_groups', '1');
}

if ( !OW::getConfig()->configExists('socialsharing', 'place_links') )
{
    OW::getConfig()->addConfig('socialsharing', 'place_links', '1');
}

if ( !OW::getConfig()->configExists('socialsharing', 'place_photo') )
{
    OW::getConfig()->addConfig('socialsharing', 'place_photo', '1');
}

if ( !OW::getConfig()->configExists('socialsharing', 'place_video') )
{
    OW::getConfig()->addConfig('socialsharing', 'place_video', '1');
}

if ( !OW::getConfig()->configExists('socialsharing', 'place_forum') )
{
    OW::getConfig()->addConfig('socialsharing', 'place_forum', '1');
}

if ( !OW::getConfig()->configExists('socialsharing', 'place_links') )
{
    OW::getConfig()->addConfig('socialsharing', 'place_links', '1');
}

if ( !OW::getConfig()->configExists('socialsharing', 'place_virtual gifts') )
{
    OW::getConfig()->addConfig('socialsharing', 'place_virtual gifts', '1');
} */

OW::getPluginManager()->addPluginSettingsRouteName('socialsharing', 'socialsharing.admin');

$plugin = OW::getPluginManager()->getPlugin('socialsharing');
BOL_LanguageService::getInstance()->importPrefixFromZip($plugin->getRootDir() . 'langs.zip', 'socialsharing');

$image = new UTIL_Image(OW::getPluginManager()->getPlugin('socialsharing')->getRootDir() . 'install' . DS . 'default.jpg');
$imagePath = OW::getPluginManager()->getPlugin('socialsharing')->getUserFilesDir().'default.jpg';

$width = $image->getWidth();
$height = $image->getHeight();

$side = $width >= $height ? $height : $width;
$side = $side > 200 ? 200 : $side;

$image->resizeImage($side, $side, true)->saveImage($imagePath);

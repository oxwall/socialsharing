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
 * @author Sergei Kiselev <arrserg@gmail.com>
 * @package ow_plugins.social_sharing.classes
 * @since 1.7.5
 */
class SOCIALSHARING_CLASS_EventHandler
{
    /**
     * @var SOCIALSHARING_CLASS_EventHandler
     */
    private static $classInstance;

    /**
     * @return SOCIALSHARING_CLASS_EventHandler
     */
    public static function getInstance()
    {
        if ( self::$classInstance === null )
        {
            self::$classInstance = new self();
        }

        return self::$classInstance;
    }

    private function __construct() { }

    public function getSharingButtons( BASE_CLASS_EventCollector $event )
    {
        $params = $event->getParams();

        $entityId = !empty($params['entityId']) ? $params['entityId'] : null;
        $entityType = !empty($params['entityType']) ? $params['entityType'] : null;

        if ( !empty($entityId) && !empty($entityType) )
        {
            $sharingInfoEvent = new OW_Event('socialsharing.get_entity_info', $params, $params);
            OW::getEventManager()->trigger($sharingInfoEvent);

            $data = $sharingInfoEvent->getData();

            $params = array_merge($params, $data);
        }

        $display= isset($params['display']) ? $params['display'] : true;

        if ( !$display )
        {
            return;
        }

        $url = !empty($params['url']) ? $params['url'] : null;
        $description= !empty($params['description']) ? $params['description'] : OW::getDocument()->getDescription();
        $title= !empty($params['title']) ? $params['title'] : OW::getDocument()->getTitle();
        $image= !empty($params['image']) ? $params['image'] : null;
        $class= !empty($params['class']) ? $params['class'] : null;

        $displayBlock = false;//isset($params['displayBlock']) ? $params['displayBlock'] : true;

        $cmp = OW::getClassInstance('SOCIALSHARING_CMP_ShareButtons');
        $cmp->setCustomUrl($url);
        $cmp->setDescription($description);
        $cmp->setTitle($title);
        $cmp->setImageUrl($image);

        $cmp->setDisplayBlock($displayBlock);

        if ( !empty($class) )
        {
            $cmp->setBoxClass($class);
        }

        $event->add($cmp->render());
    }

    public function addJsDeclarations( OW_Event $e )
    {
        //Langs
        OW::getLanguage()->addKeyForJs('socialsharing', 'share_title');
    }

    public function genericInit()
    {
        OW::getEventManager()->bind('socialsharing.get_sharing_buttons', array($this, 'getSharingButtons'));
        OW::getEventManager()->bind(OW_EventManager::ON_FINALIZE, array($this, 'addJsDeclarations'));
    }
}
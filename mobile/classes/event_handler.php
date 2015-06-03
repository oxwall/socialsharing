<?php

/**
 * Copyright (c) 2009, Skalfa LLC
 * All rights reserved.

 * ATTENTION: This commercial software is intended for use with Oxwall Free Community Software http://www.oxwall.org/
 * and is licensed under Oxwall Store Commercial License.
 * Full text of this license can be found at http://www.oxwall.org/store/oscl
 */

/**
 * @author Sergei Kiselev <arrserg@gmail.com>
 * @package ow_plugins.social_sharing.classes
 * @since 1.7.5
 */
class SOCIALSHARING_MCLASS_EventHandler
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

    public function socialsharing_get_sharing_buttons( BASE_CLASS_EventCollector $event )
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

        $cmp = new SOCIALSHARING_MCMP_ShareButtons();
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

    public function init()
    {
        OW::getEventManager()->bind('socialsharing.get_sharing_buttons', array($this, 'socialsharing_get_sharing_buttons'));
    }
}
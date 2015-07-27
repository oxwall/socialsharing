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
 * @package ow_plugins.socialsharing.components
 * @since 1.7.5
 */

class SOCIALSHARING_MCMP_Button extends OW_MobileComponent
{

    protected $class = "";
    protected $title = null;
    protected $description = null;
    protected $url = null;
    protected $imageUrl = null;
    protected $buttonLabelKey = "";
    protected $entityType = "";
    protected $entityId = "";

    public function __construct( $params = array() )
    {
        if ( !OW::getConfig()->getValue('socialsharing', 'api_key') )
        {
            $this->setVisible(false);
        }

        if ( OW::getConfig()->getValue('base', 'guests_can_view') != 1 || OW::getConfig()->getValue('base', 'maintenance'))
        {
            $this->setVisible(false);
        }

        parent::__construct();
    }

    /**
     * @param string $class
     */
    public function setBoxClass( $class )
    {
        $this->class = ( !empty($this->class) ? $this->class . ' ' . $class : $class );
    }

    /**
     * @param string $buttonLabelKey
     */
    public function setButtonLabelKey($buttonLabelKey)
    {
        $this->buttonLabelKey = $buttonLabelKey;
    }

    /**
     * @param $entityType
     */
    public function setEntityType($entityType)
    {
        $this->entityType = $entityType;
    }

    /**
     * @param $entityId
     */
    public function setEntityId($entityId)
    {
        $this->entityId = $entityId;
    }

    /**
     * @param string $url
     */
    public function setCustomUrl( $url )
    {
        if ( !empty($url) )
        {
            $this->url = strip_tags($url);
        }
    }

    /**
     * @param string $description
     */
    public function setDescription( $description )
    {
        if ( !empty($description) )
        {
            $this->description = strip_tags($description);
        }
    }

    /**
     * @param string $title
     */
    public function setTitle( $title )
    {
        if ( !empty($title) )
        {
            $this->title = strip_tags($title);
        }
    }

    /**
     * @param string $url
     */
    public function setImageUrl( $url )
    {
        if ( !empty($url) )
        {
            $this->imageUrl = strip_tags($url);
        }
    }

    public function onBeforeRender()
    {
        $id = "mobile_share_button_" . uniqid(rand(0,999999));

        $this->assign('id', $id);
        $this->assign('class', $this->class);
        $this->assign('buttonLabelKey', $this->buttonLabelKey);

        $data = json_encode(
            array(
                'title' => $this->title,
                'description' => $this->description,
                'url' => $this->url,
                'image' => $this->imageUrl
            )
        );

        if ( !empty($this->imageUrl) )
        {
            OW::getDocument()->addMetaInfo('image', $this->imageUrl, 'itemprop');
            OW::getDocument()->addMetaInfo('og:image', $this->imageUrl, 'property');
        }

        if ( !empty( $this->url ) )
        {
            OW::getDocument()->addMetaInfo('og:url', $this->url, 'property');
        }

        if ( !empty( $this->description ) )
        {
            OW::getDocument()->addMetaInfo('og:description', $this->description, 'property');
        }

        if ( !empty( $this->title ) )
        {
            OW::getDocument()->addMetaInfo('og:title', $this->title, 'property');
        }

        OW::getDocument()->addOnloadScript("
            $('#{$id}').on('click', function(){
                OWM.ajaxFloatBox('SOCIALSHARING_MCMP_ShareButtons', [{$data}], {
                    width: 315,
                    title: OWM.getLanguageText('socialsharing', 'share_title')
                });
            });
        ");

        return parent::onBeforeRender();
    }

}

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
 * @package ow_plugins.socialsharing.components
 * @since 1.6
 */

class SOCIALSHARING_MCMP_Button extends OW_MobileComponent
{

    protected $class = "";
    protected $text_key = "";
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
     * @param string $text_key
     */
    public function setTextKey($text_key)
    {
        $this->text_key = $text_key;
    }

    /**
     * @param string $entityType
     */
    public function setEntityType($entityType)
    {
        $this->entityType = $entityType;
    }

    /**
     * @param string $entityId
     */
    public function setEntityId($entityId)
    {
        $this->entityId = $entityId;
    }

    public function onBeforeRender()
    {
        $this->assign('class', $this->class);
        $this->assign('text_key', $this->text_key);
        OW::getDocument()->addOnloadScript("
            $('.mobile_share_button').on('click', function(){
                OWM.ajaxFloatBox('SOCIALSHARING_MCMP_ShareButtons', ['{$this->entityType}', '{$this->entityId}'], {
                    width: 315,
                    title: OWM.getLanguageText('socialsharing', 'share_title')
                });
            });
        ");

        return parent::onBeforeRender();
    }

}

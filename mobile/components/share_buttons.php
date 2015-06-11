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

class SOCIALSHARING_MCMP_ShareButtons extends SOCIALSHARING_CMP_ShareButtons
{

    public function __construct( $params = array() )
    {
        parent::__construct($params);
        $this->setTemplate(OW::getPluginManager()->getPlugin('socialsharing')->getMobileCmpViewDir().'share_buttons.html');
    }

    public function onBeforeRender()
    {
        $parentReturn = parent::onBeforeRender();
        if ( $this->displayBlock )
        {
            $this->setTemplate(OW::getPluginManager()->getPlugin('socialsharing')->getMobileCmpViewDir().'share_buttons.html');
        }
        return $parentReturn;
    }

    public function isAllowedView()
    {
        if ( !OW::getConfig()->getValue('socialsharing', 'api_key') )
        {
            return false;
        }

        if ( OW::getConfig()->getValue('base', 'guests_can_view') != 1 || OW::getConfig()->getValue('base', 'maintenance'))
        {
            return false;
        }

        return true;
    }
}

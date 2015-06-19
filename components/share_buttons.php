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

class SOCIALSHARING_CMP_ShareButtons extends OW_Component
{
    protected $class = "";
    protected $title = null;
    protected $description = null;
    protected $url = null;
    protected $imageUrl = null;
    protected $displayBlock = true;
    /**
     * Class constructor
     */
    public function __construct( $params = array() )
    {
        $this->imageUrl = SOCIALSHARING_BOL_Service::getInstance()->getDefaultImageUrl();

        if ( !OW::getConfig()->getValue('socialsharing', 'api_key') )
        {
            $this->setVisible(false);
        }

        if ( OW::getConfig()->getValue('base', 'guests_can_view') != 1 || OW::getConfig()->getValue('base', 'maintenance'))
        {
            $this->setVisible(false);
        }

        parent::__construct();

        if ( !empty($params['title']) )
        {
            $this->setTitle($params['title']);
        }

        if ( !empty($params['description']) )
        {
            $this->setDescription($params['description']);
        }

        if ( !empty($params['url']) )
        {
            $this->setCustomUrl($params['url']);
        }

        if ( !empty($params['image']) )
        {
            $this->setImageUrl($params['image']);
        }
    }

    public function setCustomUrl( $url )
    {
        if ( !empty($url) )
        {
            $this->url = strip_tags($url);
        }


    }

    public function setDescription( $description )
    {
        if ( !empty($description) )
        {
            $this->description = strip_tags($description);
        }
    }

    public function setTitle( $title )
    {
        if ( !empty($title) )
        {
            $this->title = strip_tags($title);
        }
    }

    public function setImageUrl( $url )
    {
        if ( !empty($url) )
        {
            $this->imageUrl = strip_tags($url);
        }
    }

    public function setDisplayBlock( $value )
    {
        $this->displayBlock = (boolean) $value;

        if ( $value )
        {
            $this->setBoxClass( 'ow_social_sharing_box' );
        }
    }

    public function onBeforeRender()
    {
        $config = OW::getConfig();

		$apiKey = $config->getValue('socialsharing', 'api_key');

        if ( empty($apiKey) )
        {
            $this->setVisible(false);
        }
		else
		{
			$order = $config->getValue('socialsharing', 'order');
			$defautOrder = SOCIALSHARING_CLASS_Settings::getEntityList();

			if ( !empty($order) )
			{
				$order = json_decode($order, true);

				if( !is_array($order) )
				{
					$order = $defautOrder;
				}

				$result = array();
				foreach ( $order as $key => $item )
				{
					if ( in_array($key, $defautOrder) )
					{
						$result[$key] = $key;
					}
				}

				if ( !empty($order) )
				{
					$order = $result;
				}
				else
				{
					$order = $defautOrder;
				}
			}
			else
			{
				$order = $defautOrder;
			}

			foreach ( $order as $key => $item )
			{
				$var = $config->getValue('socialsharing', $item);

				if ( empty($var) )
				{
					unset($order[$key]);
				}
			}

			$id = uniqid(rand(0,999999));
			$this->assign('id', $id);

			OW::getDocument()->addStyleSheet(OW::getPluginManager()->getPlugin('socialsharing')->getStaticCssUrl().'style.css');

			 $script = "";

			if ( !empty($this->imageUrl) )
			{
				OW::getDocument()->addMetaInfo('image', $this->imageUrl, 'itemprop');
				OW::getDocument()->addMetaInfo('og:image', $this->imageUrl, 'property');

				$script .= " image: ". json_encode($this->imageUrl) .", ";

			}

			if ( !empty( $this->url ) )
			{
				$script .= " url: ". json_encode($this->url) .",";
				OW::getDocument()->addMetaInfo('og:url', $this->url, 'property');
			}

			if ( !empty( $this->description ) )
			{
                $description = strip_tags($this->description);
                $description = UTIL_String::truncate($description, 255, '...');
                $script .= " description: ". json_encode($description) .",";
				OW::getDocument()->addMetaInfo('og:description', $this->description, 'property');
			}

			if ( !empty( $this->title ) )
			{
				$script .= " title: ". json_encode($this->title) .",";
				OW::getDocument()->addMetaInfo('og:title', $this->title, 'property');
			}

			OW::getDocument()->addScript('//s7.addthis.com/js/300/addthis_widget.js#pubid='.urlencode(OW::getConfig()->getValue('socialsharing', 'api_key')).'&async=1');

			$script = substr($script, 0, -1);

			OW::getDocument()->addOnloadScript("
				var addthis_share  =
				{
					{$script}
				};
				addthis.init();
				addthis.toolbox('.addthis_toolbox', {}, addthis_share);
			");

			$this->assign('url', $this->url);
			$this->assign('title', $this->title);
			$this->assign('description', $this->description);

			$this->assign('script', $script);
			$this->assign('order', $order);

			$this->assign('class', $this->class);
			$this->assign('imageUrl', $this->imageUrl);

			if ( $this->displayBlock )
			{
				$this->setTemplate(OW::getPluginManager()->getPlugin('socialsharing')->getCmpViewDir().'share_buttons_block.html');
			}
		}

        return parent::onBeforeRender();
    }

    public function setBoxClass( $class )
    {
        $this->class = ( !empty($this->class) ? $this->class . ' ' . $class : $class );
    }
}


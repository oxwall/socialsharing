<?php

/**
 * Copyright (c) 2014, Skalfa LLC
 * All rights reserved.
 *
 * ATTENTION: This commercial software is intended for exclusive use with SkaDate Dating Software (http://www.skadate.com) and is licensed under SkaDate Exclusive License by Skalfa LLC.
 *
 * Full text of this license can be found at http://www.skadate.com/sel.pdf
 */

$languages = BOL_LanguageService::getInstance()->getLanguages();
foreach ($languages as $lang)
    {
        if ($lang->tag == 'en')
            {
                break;
    }
}

Updater::getLanguageService()->addOrUpdateValue($lang->id, 'socialsharing', 'share_title', 'Share');

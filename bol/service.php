<?php


final class SOCIALSHARING_BOL_Service
{
    /**
     * Class instance
     *
     * @var SOCIALSHARING_BOL_Service
     */
    private static $classInstance;

    /**
     * Class constructor
     *
     */
    private function __construct()
    {
        
    }

    /**
     * Returns class instance
     *
     * @return SOCIALSHARING_BOL_Service
     */
    public static function getInstance()
    {
        if ( null === self::$classInstance )
        {
            self::$classInstance = new self();
        }

        return self::$classInstance;
    }

    public function getDefaultImagePath()
    {
        return OW::getPluginManager()->getPlugin('socialsharing')->getUserFilesDir().'default.jpg';
    }

    public function getDefaultImageUrl()
    {
        return OW::getPluginManager()->getPlugin('socialsharing')->getUserFilesUrl().'default.jpg';
    }

    public function uploadImage( $uploadedFileName )
    {
        $image = new UTIL_Image($uploadedFileName);
        $imagePath = $this->getDefaultImagePath();

        $width = $image->getWidth();
        $height = $image->getHeight();

        $side = $width >= $height ? $height : $width;
        $side = $side > 200 ? 200 : $side;

        $image->resizeImage($side, $side, true)->saveImage($imagePath);
    }
}
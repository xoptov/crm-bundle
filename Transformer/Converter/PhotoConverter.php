<?php

namespace Perfico\CRMBundle\Transformer\Converter;

use Liip\ImagineBundle\Imagine\Cache\CacheManager;

class PhotoConverter extends AbstractEntityConverter
{
    /** @var CacheManager */
    protected $cacheManager;
    protected $defaultAvatar;

    /**
     * @param CacheManager $cacheManager
     */
    public function setCacheManager(CacheManager $cacheManager)
    {
        $this->cacheManager = $cacheManager;
    }

    public function setDefaultAvatar($defaultAvatar)
    {
        $this->defaultAvatar = $defaultAvatar;
    }

    public function reverseConvert($object)
    {
        if (is_string($object)) {
            return $this->cacheManager->getBrowserPath($object, 'user_photo_review');
        }

        return $this->defaultAvatar;
    }
} 
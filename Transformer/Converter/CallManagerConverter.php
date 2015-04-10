<?php

namespace Perfico\CRMBundle\Transformer\Converter;

use Perfico\CRMBundle\Entity\ActivityInterface;
use Perfico\CRMBundle\Entity\UserInterface;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;

class CallManagerConverter extends AbstractEntityConverter
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

    public function convert($value)
    {
    }

    public function convertCollection($values)
    {
    }

    /**
     * @param ActivityInterface $object
     * @return null|array
     */
    public function reverseConvert($object)
    {
        if ($object instanceof ActivityInterface) {
            // Retrieve user for activity
            $user = $object->getUser();

            if ($user instanceof UserInterface) {

                $photo = $this->defaultAvatar;

                if (is_string($user->getPhoto())) {
                    $photo = $this->cacheManager->getBrowserPath($user->getPhoto(), 'user_photo_review');
                }

                return [
                    'id' => $user->getId(),
                    'firstName' => $user->getFirstName(),
                    'middleName' => $user->getMiddleName(),
                    'lastName' => $user->getLastName(),
                    'photo' => $photo
                ];
            }
        }

        return null;
    }

    public function reverseConvertCollection($objects)
    {

    }
} 
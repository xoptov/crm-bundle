<?php

namespace Perfico\CRMBundle\Service\Telephony;

use Perfico\CRMBundle\Entity\UserInterface;
use Perfico\CRMBundle\Entity\ClientInterface;
use Perfico\SipuniBundle\Entity\CallEventInterface;

interface TelephonyManager
{
    /**
     * @param string $value
     * @return boolean
     */
    public function checkFormat($value);

    /**
     * @param CallEventInterface $ce
     * @return UserInterface|null
     */
    public function searchSourceUser(CallEventInterface $ce);

    /**
     * @param CallEventInterface $ce
     * @return UserInterface|null
     */
    public function searchDestinationUser(CallEventInterface $ce);

    /**
     * @param CallEventInterface $ce
     * @return ClientInterface|null
     */
    public function searchSourceClient(CallEventInterface $ce);

    /**
     * @param CallEventInterface $ce
     * @return ClientInterface|null
     */
    public function searchDestinationClient(CallEventInterface $ce);

    /**
     * @param ClientInterface $client
     * @param string $value
     * @return void
     */
    public function prepareNewClient(ClientInterface $client, $value);
} 
<?php

namespace Perfico\CRMBundle\Service\Manager;

use Perfico\CoreBundle\Entity\Contact;
use Perfico\UserBundle\Entity\User;

class ContactManager extends GenericManager
{
    public function create()
    {
        $contact = new Contact();
        $contact->setAccount($this->getCurrentAccount());

        return $contact;
    }

    public function getContacts()
    {
        return $this->em->getRepository('CoreBundle:Contact')->findBy(['account' => $this->getCurrentAccount()]);
    }

    public function getUserContacts(User $user)
    {
        return $this->em->getRepository('CoreBundle:Contact')->findBy(['account' => $this->getCurrentAccount(), 'user' => $user]);
    }

    /**
     * @param string $value
     * @return null
     */
    public function search($value)
    {
        // TODO need implementation
        return null;
    }
} 
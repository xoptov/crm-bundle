<?php

namespace Perfico\CRMBundle\Service\Manager;

use Perfico\CoreBundle\Entity\Contact;

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
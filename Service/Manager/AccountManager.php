<?php

namespace Perfico\CRMBundle\Service\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Perfico\CoreBundle\Entity\Account;
use Perfico\CoreBundle\Entity\Channel;
use Perfico\CoreBundle\Entity\DealState;
use Perfico\CRMBundle\Entity\UserInterface;

class AccountManager
{
    /** @var Account */
    protected $currentAccount;

    /** @var EntityManagerInterface */
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function create(UserInterface $user)
    {
        $domain = 'crm-' . substr(md5($user->getId(), false), 0, 7);
        $account = new Account();
        $account->setDomain($domain);
        $this->em->persist($account);

        return $account;
    }

    /**
     * @param Account $account
     */
    public function setCurrentAccount(Account $account)
    {
        $this->currentAccount = $account;
    }

    /**
     * @return Account
     */
    public function getCurrentAccount()
    {
        return $this->currentAccount;
    }

    /**
     * @param string $domain
     * @return string
     */
    public function getHostFromDomain($domain)
    {
        return explode('.', $domain)[0];
    }

    /**
     * @param Account $account
     * @param bool $andFlush
     * @todo need remove this method after task CRM-272 will done
     */
    public function generate(Account $account, $andFlush = false)
    {
        $channel = new Channel();
        $channel->setAccount($account);
        $channel->setName('Привлечение');

        $dealState = new DealState();
        $dealState->setName('Звонок');
        $dealState->setAccount($account);
        $dealState->setIcon('fa fa-phone');

        $this->em->persist($channel);
        $this->em->persist($dealState);

        if ($andFlush)
        {
            $this->em->flush();
        }
    }
}
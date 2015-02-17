<?php

namespace Perfico\CRMBundle\Service\Manager;

use Perfico\CoreBundle\Entity\Account;

class AccountManager
{
    /** @var Account */
    protected $currentAccount;

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
}
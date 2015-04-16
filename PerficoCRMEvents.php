<?php

namespace Perfico\CRMBundle;

class PerficoCRMEvents
{
    const LOGIN_INITIALIZE = 'perfico.api.login.initialize';

    const LOGIN_SUCCESS = 'perfico.api.login.success';

    const LOGOUT_INITIALIZE = 'perfico.api.logout.initialize';

    const LOGOUT_SUCCESS = 'perfico.api.logout.success';

    const CALL = 'perfico_crm.event.call';

    const CALLEE_CLIENT_NOT_FOUND = 'perifco_crm.event.callee_client_not_found';

    const CALLEE_USER_NOT_FOUND = 'perfico_crm.event.callee_user_not_found';

    const NEW_THE_CALLER = 'perfico_crm.event.new_the_caller';
} 
<?php

namespace App\Traits;

use Aura\Auth\AuthFactory;
use Aura\Auth\Verifier\PasswordVerifier;
use \PDO;

trait Auth
{
    protected $auth;
    protected $loginService;
    protected $logoutService;
    protected $resumeService;

    public function makeAuth()
    {
        //Username/Password Auth init
        $pdo = new PDO('mysql:dbname='.getenv('DB_DATABASE').';host='.getenv('DB_HOST'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
        $hash = new PasswordVerifier(PASSWORD_BCRYPT);
        $cols = [
            'email', // "AS username" is added by the adapter
            'password', // "AS password" is added by the adapter
            'remember_token',
            'api_token'
        ];
        $from = 'users';
        $loginAuthFactory = new AuthFactory($_COOKIE);
        $pdoAdaptor = $loginAuthFactory->newPdoAdapter($pdo, $hash, $cols, $from);
        $this->auth = $loginAuthFactory->newInstance();
        $this->loginService = $loginAuthFactory->newLoginService($pdoAdaptor);
        $this->logoutService = $loginAuthFactory->newLogoutService($pdoAdaptor);
        $this->resumeService = $loginAuthFactory->newResumeService($pdoAdaptor);
    }
}
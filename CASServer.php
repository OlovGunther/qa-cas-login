<?php

define('PHPCAS_PATH','/usr/share/php/CAS.php');
require_once PHPCAS_PATH;

define('CAS_VER',CAS_VERSION_2_0);

$CAS_SETUP = false;

final class CASServer {

    /**
     * Call this method to get singleton
     *
     * @return CASServer
     */
    public static function Instance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new CASServer();
        }
        return $inst;
    }

    /**
     * Private ctor so nobody else can instance it
     *
     */
    private function __construct()
    {
        error_log(print_r(debug_backtrace(), TRUE));

        global $CAS_SETUP;

        if ($CAS_SETUP) return;

        phpCAS::setDebug();
        phpCAS::client(CAS_VER, qa_opt('cas_host'), (int)qa_opt('cas_login_port'), qa_opt('cas_url_context'));

        // SSL certification validation
        if (qa_opt('cas_cert_url') != "") {
            phpCAS::setCasServerCACert(qa_opt('cas_cert_url'));
        }
        else {
            phpCAS::setNoCasServerValidation();
        }

        $CAS_SETUP = true;
    }

    public function isAuthenticated()
    {
        return phpCAS::isAuthenticated();
    }

    public function getUser()
    {
        return phpCAS::getUser();
    }

    public function forceAuthentication()
    {
        phpCAS::forceAuthentication();
    }

    public function logout($url)
    {
        var_dump($_SESSION);

        qa_clear_session_cookie();
        qa_clear_session_user();

        header('Location: '.qa_opt('cas_logout'));
        phpCAS::logout(array('url'=>$url));
    }
}

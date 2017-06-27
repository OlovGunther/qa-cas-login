<?php

require_once 'CASServer.php';

class cas_logout_process {
    var $directory;
    var $urltoroot;

    public function __construct()
    {
        $this->cas = CASServer::Instance();
    }

    function load_module($directory, $urltoroot) {
        $this->directory=$directory;
        $this->urltoroot=$urltoroot;
    } // end function load_module

    function suggest_requests() {
        return array(
            array(
                'title' => 'Logout',
                'request' => 'auth/logout',
                'nav' => 'null',
            ),
        );
    } // end function suggest_requests

    function match_request($request) {
        return $request == 'auth/logout';
    } // end function match_request

    function process_request($tourl) {
        $this->cas->logout($tourl);
        return null;
    } // end function process_request

}
?>

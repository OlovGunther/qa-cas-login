<?php
class cas_logout_redirect
{
    public function process_event($event, $userid, $handle, $cookieid, $params)
    {
        switch($event) {
        case 'u_logout':
            qa_redirect('login');
            break;
        default:
            break;
        }
    }
}

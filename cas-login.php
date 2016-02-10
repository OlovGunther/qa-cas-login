<?php

require_once 'CASServer.php';

class cas_login {

    private $directory;
    private $urltoroot;
    private $pluginkey = 'cas_login';

    public function __construct()
    {
        $this->cas = CASServer::Instance();
    }

    function load_module($directory, $urltoroot) {
        $this->directory = $directory;
        $this->urltoroot = $urltoroot;
    }

    // check_login checks to see if user is already logged in by looking for
    // a cookie or session variable (dependent on 'remember me' setting
    function check_login() {

        error_log('check login');

        if ($this->cas->isAuthenticated()) {

            $handle = $this->cas->getUser();

            $source = 'cas';

            $fields['email'] = '';
            $fields['confirmed'] = false;
            $fields['handle'] = $handle;
            $fields['name'] = $handle;

            $this->cas_login_external_user($source, $handle, $fields);
            return;
        } else {
            return false;
        }

    }

    function match_source($source) {
        return $source == 'cas';
    }


    function login_html($tourl, $context) {


//        if ($this->cas->isAuthenticated()) {

//        } else {
            $this->cas->forceAuthentication();
//        }

    }

    function logout_html ($tourl) {
        require_once QA_INCLUDE_DIR."qa-base.php";

        $_SESSION['logout_url'] = $tourl;
        $logout_url = qa_path('auth/logout', null, qa_path_to_root());
        echo('<a href="'.$logout_url.'">'.qa_lang_html('main/nav_logout').'</a>');
    }




    function cas_login_external_user($source, $identifier, $fields)
    /*
    Call to log in a user based on an external identity provider $source with external $identifier
    A new user is created based on $fields if it's a new combination of $source and $identifier
    */
    {
        if (qa_to_override(__FUNCTION__)) { $args=func_get_args(); return qa_call_override(__FUNCTION__, $args); }

        require_once QA_INCLUDE_DIR.'db/users.php';

        $users=qa_db_user_login_find($source, $identifier);
        $countusers=count($users);

        if ($countusers>1)
        qa_fatal_error('External login mapped to more than one user'); // should never happen

        if ($countusers) // user exists so log them in
        qa_set_logged_in_user($users[0]['userid'], $users[0]['handle'], false, $source);

        else { // create and log in user
            require_once QA_INCLUDE_DIR.'app/users-edit.php';

            qa_db_user_login_sync(true);

            $users=qa_db_user_login_find($source, $identifier); // check again after table is locked

            if (count($users)==1) {
                qa_db_user_login_sync(false);
                qa_set_logged_in_user($users[0]['userid'], $users[0]['handle'] , false, $source);

            } else {

                // Try to log in user by existing handle
                $users = qa_db_user_find_by_handle($identifier);
                if (count($users)==1) {
                    qa_db_user_login_sync(false);
                    qa_set_logged_in_user($users[0]['userid'], $identifier, false, $source);
                    return;
                }


                $handle=qa_handle_make_valid(@$fields['handle']);

                if (strlen(@$fields['email'])) { // remove email address if it will cause a duplicate
                    $emailusers=qa_db_user_find_by_email($fields['email']);
                    if (count($emailusers)) {
                        qa_redirect('login', array('e' => $fields['email'], 'ee' => '1'));
                        unset($fields['email']);
                        unset($fields['confirmed']);
                    }
                }

                $userid=qa_create_new_user((string)@$fields['email'], null /* no password */, $handle,
                isset($fields['level']) ? $fields['level'] : QA_USER_LEVEL_BASIC, @$fields['confirmed']);

                qa_db_user_login_add($userid, $source, $identifier);
                qa_db_user_login_sync(false);

                $profilefields=array('name', 'location', 'website', 'about');

                foreach ($profilefields as $fieldname)
                if (strlen(@$fields[$fieldname]))
                qa_db_user_profile_set($userid, $fieldname, $fields[$fieldname]);

                if (strlen(@$fields['avatar']))
                qa_set_user_avatar($userid, $fields['avatar']);

                qa_set_logged_in_user($userid, $handle, false, $source);
            }
        }
    }

}
?>

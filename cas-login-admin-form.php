<?php

/*
/* This class represents administator settings
/* for the LDAP plugin.
*/

class cas_login_admin_form {

    function option_default($option)   {
        if ($option=='cas_host') return 'https://192.168.33.10';
        if ($option=='cas_login_port') return 443;
        if ($option=='cas_cert_url') return '';

        if ($option=='cas_url_context') return '/cas';
        if ($option=='cas_login_path') return '/cas/login';
        if ($option=='cas_logout_path') return '/cas/logout';

        if ($option=='cas_login_fullname') return 'cn';
        if ($option=='cas_login_mail') return 'mail';

        if ($option=='cas_login_allow_normal') return true;
        if ($option=='cas_login_allow_registration') return false;

        return null;
    }

    function admin_form(&$qa_content) {
        $saved=false;

        if (qa_clicked('cas_login_save_button')) {
            qa_opt('cas_host', qa_post_text('cas_host_field'));
            qa_opt('cas_login_port', (int) qa_post_text('cas_login_port_field'));

            qa_opt('cas_url_context', qa_post_text('cas_url_context_field'));
            qa_opt('cas_login_path', qa_post_text('cas_login_path_field'));
            qa_opt('cas_logout_path', qa_post_text('cas_logout_path_field'));

            qa_opt('cas_login_fullname', qa_post_text('cas_login_fullname_field'));
            qa_opt('cas_login_mail', qa_post_text('cas_login_mail_field'));

            qa_opt('cas_login_allow_normal', (bool) qa_post_text('cas_login_allow_normal_field'));
            qa_opt('cas_login_allow_registration', (bool) qa_post_text('cas_login_allow_registration_field'));

            $saved=true;
        }

        qa_set_display_rules($qa_content, array(
            'cas_login_allow_registration_display' => 'cas_login_allow_normal_field',
        ));

        return array(
            'ok' => $saved ? 'CAS settings saved' : null,

            'fields' => array(
                array(
                    'label' => 'URL for CAS Server',
                        'type' => 'text',
                        'value' => qa_opt('cas_host'),
                        'tags' => 'name="cas_host_field"',
                    ),

                    array(
                        'label' => 'Port for CAS Server (default is 443)',
                        'type' => 'number',
                        'value' => qa_opt('cas_login_port'),
                        'tags' => 'name="cas_login_port_field"',
                    ),

                    array(
                        'label' => 'CAS URL context (typically /cas)',
                        'type' => 'text',
                        'value' => qa_opt('cas_url_context'),
                        'tags' => 'name="cas_url_context_field"'
                    ),

                    array(
                        'label' => 'CAS login path',
                        'type' => 'text',
                        'value' => qa_opt('cas_login_path'),
                        'tags' => 'name="cas_login_path_field"'
                    ),

                    array(
                        'label' => 'CAS logout path',
                        'type' => 'text',
                        'value' => qa_opt('cas_logout_path'),
                        'tags' => 'name="cas_logout_path_field"'
                    ),

                    array(
                        'label' => 'CAS Full name field',
                        'type' => 'text',
                        'value' => qa_opt('cas_login_fullname'),
                        'tags' => 'name="cas_login_fullname_field"',
                    ),

                    array(
                        'label' => 'CAS Email field',
                        'type' => 'text',
                        'value' => qa_opt('cas_login_mail'),
                        'tags' => 'name="cas_login_mail_field"',
                    ),



                    array(
                        'label' => 'Allow normal logins as a fallback to CAS',
                        'type' => 'checkbox',
                        'value' => qa_opt('cas_login_allow_normal'),
                        'tags' => 'name="cas_login_allow_normal_field" id="cas_login_allow_normal_field"',
                    ),

                    array(
                        'id' => 'cas_login_allow_registration_display',
                        'label' => 'Allow registration when normal logins are allowed',
                        'type' => 'checkbox',
                        'value' => qa_opt('cas_login_allow_registration'),
                        'tags' => 'name="cas_login_allow_registration_field"',
                    ),
                ),

                'buttons' => array(
                    array(
                        'label' => 'Save Changes',
                        'tags' => 'name="cas_login_save_button"',
                    ),
                ),
            );
        }

    }

    /*
    Omit PHP closing tag to help avoid accidental output
    */

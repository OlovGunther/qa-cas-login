<?php

/*
  Plugin Name: CAS-Login
  Plugin Description: Allows CAS authentication within Q2A. Based on plugin with
	same name made by mossadal.
  Plugin URI: https://github.com/OlovGunther/qa-cas-login
  Plugin Update Check URI:
  Plugin Version: 1.0
  Plugin Date: 2016-06-27
  Plugin Author: Olov Günther-Hanssen
  Plugin License: Free
  Plugin Minimum Question2Answer Version: 1.4
*/

error_reporting(E_ALL);

// don't allow this page to be requested directly from browser
if (!defined('QA_VERSION')) {
	header('Location: ../../');
	exit;
}

qa_register_plugin_module('login','cas-login.php','cas_login','CAS Login');
qa_register_plugin_layer('cas-login-layer.php','CAS Login Layer');
qa_register_plugin_module('page','cas-login-logout-page.php','cas_logout_process','CAS Logout Process');
qa_register_plugin_module('module', 'cas-login-admin-form.php', 'cas_login_admin_form', 'CAS Login');
qa_register_plugin_module('event', 'cas-logout-redirect.php', 'cas_logout_redirect', 'Logout Redirection');
/*
  Omit PHP closing tag to help avoid accidental output
*/

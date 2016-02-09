<?php

/*
  Plugin Name: CAS-Login
  Plugin Description: Allows CAS authentication within Q2A
  Plugin URI: https://github.com/mossadal/qa-cas-login
  Plugin Update Check URI:
  Plugin Version: 1.0
  Plugin Date: 2016-02-08
  Plugin Author: Frank Wikström
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
qa_register_plugin_module('filter', 'cas-filter.php', 'cas_filter', 'CAS filters');
/*
  Omit PHP closing tag to help avoid accidental output
*/

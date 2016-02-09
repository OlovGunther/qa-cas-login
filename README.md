# qa-cas-login

## README

qa-cas-login is an CAS authentication mechanism for
Question2Answer. In it's current form, it is intended to
replace the existing Q2A login form.

## INSTALL

First make sure that [phpCAS](https://wiki.jasig.org/display/casc/phpcas) is
installed on your server. On apt based Linux distibutions
```
sudo apt-get install php-cas
```
should work.



To install the plugin:

1. Add the qa-cas-login directory with plugin files to the qa-plugin directory for your Q2A install.

2. Change the options for the plugin in the administrator interface.

3. If your CAS settings are configured correctly, that should be it!

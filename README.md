# get_mysql_db_php_from_cms_oo PHP v.5.4+

Possible usage for: DevOps automation, backups sripting and much more.

Get create MySQL database(s) & user(s) SQL script from popular CMS such as Wordpress, Drupal, Joomla!, Magento, Laravel & Yii2 Frameworks.
Yii2 Framework config detection works for both advanced & basic application templates.

Please, let me know If you want to add some more missing CMS and Frameworks written on PHP.

In case if you want to detect Laravel vendor libs istallation:
```
$ composer install
```

Get create MySQL database(s) & user(s) SQL queries.

Usage:
```
$ php get_create_mysql_db.php /home/taras/public_html
```

Get drop MySQL database(s) & user(s) SQL queries.

Usage:
```
$ php get_drop_mysql_db.php /home/taras/public_html
```

Generate .my.cnf configuration file from MySQL settings to use instead of credentials.

Usage:
```
$ php get_create_my_cnf.php /home/taras/public_html > /home/taras/.my-secure.cnf
```

[![ko-fi](https://ko-fi.com/img/githubbutton_sm.svg)](https://ko-fi.com/L3L5LJ3TB)

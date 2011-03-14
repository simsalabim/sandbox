A bulk of stuff not to increase repos count.

=== yet-another-crawler ===

MVC-driven crawler written in PHP 5.2, AJAX/noJS modes implemented, crawles info from http://www.bn.ru/
  
=== thirdapter ===

simple MVC bicycle written in PHP 5.2, developed during implemenation of 'yet-another-crawler'. Main idea is using 3rd-party adapters for as much components as possible (template engines, ORM). For now Smarty-adapter is ready.

=== phpdumper - improved PHP variable dumper with web interface ===
==== What is it? ====
Simple variables dumper for easy debugging, instead of standard function var_dump(), analog of FirePHP.
==== Advantages ====
 * Response headers aren't modified, distingueshes of FirePHP
 * Browser-independent
 * All logging advantages: information available at all time and in different environments (stage, production)
 * Posibility of easy debugging of Web-services(REST, JSON, SOAP) in cases you can't do print_r not to break response
 * Convenient web-interface representing information about variables
 * Backlog/trace is implemented
 * Posibility to "stick" debug invokation not to increase number of logging entries
 * Debug panel interface representing both log and target pages
==== How to use it ====
Just download, include in your file and invoke Du::mp($your_variable); 
Dependencies: <a href="http://code.google.com/p/phpquery/">phpQuery</a>
<img src="http://img89.imageshack.us/img89/5729/phpdumperpanel.png" />

=== NLOG - Simple MVC-driven blog on PHP 5.3 and MySQL ===
==== User priveleged to post: ====
{{{
login: ololo
password: trololo
}}}

SQL-dump 'database.sql' is in the root of repo.
Web-server settings: DocumentRoot: nlog/www

==== Pages: ====
 # nlog.dev - authorisation
 # nlog.dev/posts - posts list (automatically redirects here after successful authorisation)
 # nlog.dev/posts/show?id=1 - view post specified by id with its comments 
 # nlog.dev/posts/create - create blog entry (only available for authorised users, who have editor previlegies)

<img src="http://img825.imageshack.us/img825/1092/nlog.png" />


Author: Alexander Kaupanin <kaupanin@gmail.com>
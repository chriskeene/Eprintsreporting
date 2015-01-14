Eprints Reporting
=================

A simple set of pages to list and report on Eprints data. Using PHP and CodeIgniter.

Author: Chris Keene, University of Sussex. 2014.

Install
=======
- Download from github
- rename SAMPLEdatabase.php in application/config - enter your database credentials
- in application/config/config.php set your repository name and url at the top of the file.
- replace the current (Sussex) template files in application/views/templates with your own

If you run in to problems, try downloading and extracting codeignitor from the official site, and then copying the application folder from here over the top of the default one. Then setup your Database connection.

Requirements
============
Webserver running PHP which has access to your eprints database (just requires read access, i.e. SELECT) 

Notes
=====
Some reports use custom fields on our IR and so will fail unless you by chance have setup fields of the same name.

Some mysql-specific queries are used. Should work with other DB backends with a little tweaking in the model file.

This is all basic stuff, and most developers could knock something up that does the same, only with better code, very quickly. It's designed for back-office working, and to be limited to just those who support the respository. If you are making it available on a public webserver you may wish to do a security review first.

Our repository is called SRO, I've tried to avoid any references to SRO, though some may still remain in the code.
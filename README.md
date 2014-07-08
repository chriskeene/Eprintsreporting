Eprints Reporting
=================

A simple set of pages to list and report on Eprints data. Using PHP and CodeIgniter.

Author: Chris Keene, University of Sussex. 2014.

Install
=======
- Download from github
- rename SAMPLEdatabase.php in application/config - enter your database credentials
- in application/config/config.php set your respository name and url at the top of the file.
- replace the current template files in application/views/templates with your own

Requirements
============
Webserver running PHP which has access to your eprints database (just requires read access, i.e. SELECT) 

Notes
=====
Some reports use custom fields on our IR and so will fail unless you by chance have setup fields of the same name.


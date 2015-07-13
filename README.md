Eprints Reporting
=================

A simple set of pages to list and report on Eprints data. Using PHP and CodeIgniter.

Author: Chris Keene, University of Sussex. 2014-2015.

It's licensed under the MIT License.  
You can use it as you wish, just don't blame me or expect support.

Note the code complies with the CWBP coding standard*

Install
=======
- Download from github. 
- Rename SAMPLEdatabase.php in application/config - enter your database credentials
- In application/config/config.php set your repository name and url at the top of the file.
- Replace the current (Sussex) template files in application/views/templates with your own

If you extract the files in to directory 'reports' on the server http://www.example.edu/ then the base url will be:
http://www.example.edu/report/eprintsreporting/

If you run in to problems, try downloading and extracting CodeIgnitor from the official site, and then copying the application folder from here over the top of the default one. Then set-up your Database connection etc.
You may need to fiddle with the .htaccess file.

Requirements
============
A Web server running PHP (5.1.6 and above) which has read (SELECT) SQL access to your Eprints database.

Adding and changing the reports
===============================

Refer to the CodeIgniter v2 documentation. 
http://www.codeigniter.com/userguide2/toc.html

The main files are in the application directory. The only file you may need to edit outside of this is .htaccess. Anyone familar with the MVC model for web applications will be familar with the layout

* controllers/eprintsreporting.php - Essentially the pages and urls
* models/eprintsreporting_model.php - functions to return data from the database 
* views/ - snippets of html for displaying a page or part of a page
* views/templates - guess.
* libraries/Ergeneral.php - a file with a few common functions, plus some settings such as item type names
* config/ - config files.

For an example, see the 'gettopjournals' in the controller, which is the page which displays the journals most published in, either for the whole repository or a given School. This uses the get_topjournals function in the model file, and uses the 'topjournal.php' view html for displaying the list.

Notes
=====
Some reports use custom fields on our IR and so will fail unless you by chance have set up fields of the same name.

This applies in particular to the University Structure. We have Schools and within them Departments. Items are added to Eprints at the Department level, but reported on at the School level, hence the SQL will select an item and look at the parent (school) or the division it is associated with (department). It should be a fairly quick job to go through the Model file and update any queries based on Schools and adapt them for your local needs. note in the where clause "subject_ancestors.pos=1" which selects the ancestor 1 up in the tree, ie the School. We also have some locally created funder fields and OA status fields.

Some Mysql specific queries are used. Should work with other DB back-ends with a little tweaking in the Model file.


This code is all basic stuff. Most developers could knock something up that does the same, and more, only with better code, quite quickly. It's designed for back-office working, and to be limited to just those who support the repository. If you are making it available on a public web server you may wish to do a security review first.

Our repository is called SRO, I've tried to avoid any references to SRO, though some may still remain in the code.

License
=======
The MIT License (MIT)

Copyright (c) 2015 CJ Keene (chriskeene@gmail.com) 

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.



(* Chris Writes Bad PHP)
Eprints Reporting
=================

A simple set of pages to list and report on Eprints data. Using PHP and CodeIgniter.

Author: Chris Keene, University of Sussex. 2014-2015.

Note the code complies with the CWBP coding standard*

It's licensed under the MIT License.  
You can use it as you wish, just don't blame me or expect support.

Install
=======
- Download from github
- rename SAMPLEdatabase.php in application/config - enter your database credentials
- in application/config/config.php set your repository name and url at the top of the file.
- replace the current (Sussex) template files in application/views/templates with your own

If you run in to problems, try downloading and extracting CodeIgnitor from the official site, and then copying the application folder from here over the top of the default one. Then set-up your Database connection etc.

Requirements
============
A Web server (duh) running PHP which has access to your Eprints database (just requires read access, i.e. SELECT).. 

Notes
=====
Some reports use custom fields on our IR and so will fail unless you by chance have set up fields of the same name.

This applies in particular to the University Structure. We have Schools and within them Departments. Items are added to Eprints at the Department level, but reported on at the School level, hence the SQL will select an item and look at the parent (school) or the division it is associated with (department). It should be a failry quick job to go through the Model file and update any queries based on Schools and adapt them for your local needs. note in the where clause "subject_ancestors.pos=1" which selects the ancestor 1 up in the tree, ie the School. We also have some locally created funder fields and OA status fields.

Some Mysql specific queries are used. Should work with other DB backends with a little tweaking in the Model file.


This code is all basic stuff. Most developers could knock something up that does the same, and more, only with better code, very quickly. It's designed for back-office working, and to be limited to just those who support the repository. If you are making it available on a public web server you may wish to do a security review first.

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



* Chris Writes Bad PHP
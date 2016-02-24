##################
Bot Cards Exchange
##################

This webapp is an "engine" for managing the trading of "bot cards",
the excuse for ACIT4850 assignments in the Winter 2016 term..

*****************
Programming Style
*****************

Some of the programming design decisions reflected:

-   The architecture adheres more to the "model-view-adapter" convention,
    where the view is unaware of the source of data and the model is unaware of
    how any data might be presented. The controllers are go-betweens.
-   Views are templated - an overall one for page layout, and then
    individual templates for the panels that are assembled to make up a page.
-   View fragments are used to style single "records" on their own,
    improving cohesion.
-   A base controller takes care of assembling finished pages, using the 
    master template.
-   A base model takes care of CRUD functionality.
-   The CodeIgniter framework folder has been moved outside of the webapp,
    in this case to a "system3" folder at the same hierarchy level as the 
    document root.
-   An ".htaccess" file is incorporated, to configure Apache to remove
    index.php from any URLs.

***************
Project Folders
***************

/application    the obvious
/assets         CSS, javascript & media
/data           avatar images, XML data

Assumed: CI system folder is in ../system3

*******
License
*******

Please see the `license
agreement <http://codeigniter.com/userguide3/license.html>`_

*********
Resources
*********

-  `Informational website <https://codeigniter.com/>`_
-  `Source code repo <https://github.com/bcit-ci/CodeIgniter/>`_
-  `User Guide <https://codeigniter.com/userguide3/>`_
-  `Community Forums <https://forum.codeigniter.com/>`_
-  `Community Wiki <https://github.com/bcit-ci/CodeIgniter/wiki/>`_
-  `Community IRC <https://codeigniter.com/irc>`_

****************
Using the engine
****************

The ACIT4850 students have been tasked with building bot card trader webapps,
which will broker the purchase and sale of bot trading cards for their
users.

A course designer should create a separate repository for their course content,
which will mostly be a "data" folder instead of the "testdata" folder
shown here. You can also create a downloads folder, with anything
you to share with your users directly. To setup your course, deploy this
webapp as the document root for a domain or subdomain, and then copy
the data folders from your course repository. Boom!

The repo should only contain the data folder, and a composer.json to update
the engine (once that feature is enabled).

The data folder should contain:
- course.xml, with course metadata
- materials.xml, describing the kinds of content used in the course,
- organizer.xml, providing a trail through the content
- logo.png, a 40x40 icon to use for the course "brand"
- custom.css, over-riding colors for your course

A thought ... if you setup a course X with its repo, then locally 
"git remote add engine https://github.com/jedi-academy/engine.git", then
you could just "git pull engine master" to update your course with the latest
engine updates :)

***************
Acknowledgement
***************

This webapp was written by James Parry, Instructor in Computer Systems
Technology at the British Columbia Institute of Technology,
and Project Lead for CodeIgniter.

CodeIgniter is a project of B.C.I.T.
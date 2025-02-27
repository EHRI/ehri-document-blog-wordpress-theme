# EHRI Wordpress Theme

Website: [https://blog.ehri-project.eu](https://blog.ehri-project.eu)

## About

A Wordpress theme for the EHRI Document Blog based on the UnderStrap framework.

## License
EHRI WordPress Theme, Copyright 2019 King's College London
Distributed under the terms of the GNU GPL version 2

http://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html

## Developing With npm, Grunt and SASS

### Installing Dependencies
- Make sure you have installed Node.js on your computer globally
- Run: `$ npm install`

### Running
To work with and compile your Sass files on the fly start:

- `$ npm run watch`

### Build
To create a ready-for-production version of your CSS and JS files:

- `$ npm run dist`

This will result in a zipped file in the `pkg` folder that you can upload to your Wordpress site.

### Supported Plugins

This theme includes some theming support for the following plugins:

 - Contextual Related Posts (CRP) (Disable default plugin rendered output on posts and pages)
 - EZ-Toc (Enable "Prevent loading of default styles..." and disable "Sticky TOC")
 - Simple Lightbox (SLB)
 - Co-Authors Plus

It is also assumed that the Widget Context plugin is used to control the display of sidebar widgets in posts and pages.

### Theme Configuration

This theme assumes some settings in the Wordpress theme configurator:

 - static home page, set to a blank page (named e.g. "Home") - set template to "Homepage". The front page
   hero image is this page's featured image.
 - posts page, set to another blank page (named e.g. "All Articles"). The default template should be used
   here.

#### Widgets

Add the following widgets to the right sidebar with the given context (via the Widget Content plugin):

 - Text widget titled "About the Project": context Front Page only
 - Author Info [EHRI]: context All Author archives
 - Post Metadata [EHRI]: context All Posts
 - Post Comment Info [EHRI]: context All Posts
 - Post Categories [EHRI]: context All Posts
 - Post Tags [EHRI]: context All Posts
 - Link List [EHRI]: context All posts
 - Author List [EHRI]: context blog page, search results, all archives
 - Table of contents titled "Summary": context All Posts
 - Categories: context Front Page, blog page, search results, 404 error page, all archives
 - Tag Cloug titled "Tags": context blog page, search results, 404 error page, all archives

#### Menus

 - Main (header) nav menu should be named "main"
   - Map page (empty page with Map template)
   - About
   - How to Contribute
 - Footer menus should be named "footer1" and "footer2" (if needed)
   - Home
   - About
   - Contribute

Licenses & Credits
=
- UnderStrap: http://understrap.com | (Code licensed under GNU GPL v2.0)
- Font Awesome: http://fontawesome.io/license (Font: SIL OFL 1.1, CSS: MIT License)
- Bootstrap: http://getbootstrap.com | https://github.com/twbs/bootstrap/blob/master/LICENSE (Code licensed under MIT documentation under CC BY 3.0.)
and of course
- jQuery: https://jquery.org | (Code licensed under MIT)
- WP Bootstrap Navwalker by Edward McIntyre: https://github.com/twittem/wp-bootstrap-navwalker | GNU GPL
- Bootstrap Gallery Script based on Roots Sage Gallery: https://github.com/roots/sage/blob/5b9786b8ceecfe717db55666efe5bcf0c9e1801c/lib/gallery.php


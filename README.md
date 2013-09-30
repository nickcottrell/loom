Loom
====
dynamically weaves together jekyll site
---------------------------------------


Loom is basically a "flat" file based CMS. That means there is no database, but the user is able to use the app to generate new pages, write and retrieve information. The architecture is highly experimental and is designed to suit specific use cases where it might be easier to create a custom server that can run jekyll or there might be benefit to ultimately being able to export a static site from a simple CMS. It's really just kind of a fun set up. 

Loom stores information in flat files, which are used (by [Jekyll](https://github.com/mojombo/jekyll/)) to generate a static site. The `loom-webapp` contains PHP that writes flat "post" files into the `loom-jekyll/_posts` directory. The app runs `jekyll` in the `loom-jekyll` directory which is configured to build a static site in the `loom-site/public` directory.

Since there is no database, loom uses a simple JSON API to store information. Each page that is generated in the site contains a corresponding JSON file, which is located at `http://url.com/page/feed`. That's how you can access the information.


### Static Site:

Loom requires [Jekyll](https://github.com/mojombo/jekyll/). Learn about it and install it. Once installed, you should just be able to Jekyll on the command line in the "loom-jekyll" directory. Loom is used to create the "post" files. The jekyll directory is set up here to work as a normal jekyll site, but highly leverages the "permalink" feature usually used for "posts" to basically create all of the pages in a given site. Since the layout is specified by the `.textile` files, you can simply change layouts and use the jekyll "category" feature if you want to create a site with different sections and layouts.
	
	
### Local Loom
* Run a PHP server on the `loom-webapp` directory
* Run any web server you want on the `loom-site/public` directory

### Loom in Production
Good luck.



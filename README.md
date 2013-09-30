Loom
====
Dynamically weaves together jekyll
-----------------------------------


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


### Posting

Form fields are generated dynamically to streamline the variable handling in the form templates. That way, Loom will look for JSON data to see if it can find any default values. If there are no default values, the fields will be left blank. If they find something, it will fill in the corresponding values. 

In both cases, the `name` value is defined by the initial key that is passed in. That way, default JSON value or not, whatever ultimately is posted from the field on submit will get handled as a key value pair.

To create a form field, add the following inside a `<form>` element:

	<? textarea('headline');?>

In the corresponding *jekyll layout* template use:

	{{ page.headline }}

When the data is posted using the form, the data gets added to the flat "post" files jekyll uses to generate the site. Loom passes data from the forms into the jekyll files.


### Editing

When Loom detects an "edit" parameter, it will fill the form with the data associated with a particular page. The parameter looks like this:

	?edit=http://url.com/this/post/feed
	
The URL is the JSON feed that contains the information posted by Jekyll, along side the corresponding web page. Each textarea element will look for the edit param and if it finds it, it then searches the JSON for the corresponding data. If it doesn't find anything it will just leave the forms blank.


### Deleting

To delete a post, Loom looks at the edit param and posts a new post to the corresponding URL with a `deleted` Jekyll "layout", which is basically an empty layout. It essentially replaces the page with a dud page. That way, you always have a date-stamped flat file that is never actually deleted. 

To revert this feature, simply remove the dud file and run jekyll. That should restore it to the previous post for that URL.

### Other Hacks

Use params for any particular variable in a form, which will default the text for that particular form field.

	?title=helloworld
	



Loom
====
Dynamically weaves together jekyll
-----------------------------------


Loom is basically a "flat" file based CMS. That means there is no database, but the user is able to use the app to generate new pages, write and retrieve information. The architecture is highly experimental and is designed to suit specific use cases where it might be easier to create a custom server that can run jekyll or there might be benefit to ultimately being able to export a static site from a simple CMS. It's really just kind of a fun set up. 

Loom stores information in flat files, which are used (by [Jekyll](https://github.com/mojombo/jekyll/)) to generate a static site. The `loom-webapp` contains PHP that writes flat "post" files into the `loom-jekyll/_posts` directory. The app runs `jekyll` in the `loom-jekyll` directory which is configured to build a static site in the `loom-site/public` directory.

Since there is no database, loom uses a simple JSON API to store information. Each page that is generated in the site contains a corresponding JSON file, which is located at `http://url.com/page/feed`. That's how you can access the information.


### Static Site:

Loom requires [Jekyll](https://github.com/mojombo/jekyll/). Learn about it and install it. Once installed, you should just be able to run Jekyll on the command line in the `loom-jekyll` directory. The jekyll directory is set up here to work as a normal jekyll site, but highly leverages the "permalink" feature usually used for "posts" to basically create all of the pages in a given site, as opposed to being used only for blog posts. Since the layout is specified by the `.textile` files, you can determine the "layout" with the flat file and also configure the "category" if you want to create a site with different sections and layouts. Since Loom is used to generate the "post" files in the jekyll site, it is effectively acting as a CMS to manage the flat files that are used to configure the site content. A CMS that uses Jekyll as the engine.

One of the more interesting and experimental features of Loom is that instead of storing data in a database, it stores the data in JSON. Every page of the static site contains a corresponding "feed" page that contains the data posted from the submitted form. Loom accesses the JSON data when editing and deleting posts.	
	
### Local Loom
* Run a PHP server on the `loom-webapp` directory
* Run any web server you want on the `loom-site/public` directory

### Loom in Production
Good luck. You'll need to configure your server so that the script can run Jekyll in the appropriate directory. You'll also need to address the countless security issues associated with allowing a user to use the app to generate new files on the server. It can be done, but it's definitely not a plug-and-play type of thing.


### Posting

Form fields are generated dynamically to streamline the variable handling in the form templates. That way, Loom will look for JSON data to see if it can find any default values. If there are no default values, the fields will be left blank. If they find something, it will fill in the corresponding values. 

In both cases, the `name` value is defined by the initial key that is passed in. That way, default JSON value or not, whatever ultimately is posted from the field on submit will get handled as a key value pair.

To create a form field, add the following inside a `<form>` element:

	<? textarea('headline');?>

In the corresponding *jekyll layout* template use:

	{{ page.headline }}

When the data is posted using the form, the data gets added to the flat "post" files jekyll uses to generate the site. Loom passes data from the forms into the jekyll files.

In a few cases, some of the standard jekyll/YAML variables such as `layout`,`permalink`,`category` will be required to properly generate a page. For example, the `permalink` is required to tell jekyll where you want you page to exist in the site. For this demo, the permalink value is set by the following text entered into the formfield by the user:

	post
	
But could be anything you want, such as:

	post/samples/pages/foo/bar
	
This will post the page at the following location:

	http://url.com/post/samples/pages/foo/bar/
	
In addition to each page that's posted, Loom will create a corresponding "feed" page, which stores all of the values in JSON. The corresponding URL is always the URL + `/feed/`. For example, the feed URL for the link above would be:

	http://url.com/post/samples/pages/foo/bar/feed/


	
### Editing

When Loom detects an "edit" parameter, it will fill the form with the data associated with a particular page. The parameter looks like this:

	?edit=http://url.com/this/post/feed
	
The URL is the JSON feed that contains the information posted by Jekyll, along side the corresponding web page. Each textarea element will look for the edit param and if it finds it, it then searches the JSON for the corresponding data. If it doesn't find anything it will just leave the forms blank.

This is why Loom uses a special function to render it's form fields. The function is checks the JSON or param value (see "Other Hacks") and fills it in with the default data if detected.

	<? textarea('headline');?>
	


### Deleting

To delete a post, Loom looks at the edit param and posts a new post to the corresponding URL with a `deleted` Jekyll "layout", which is basically an empty layout. It essentially replaces the page with a dud page. That way, you always have a date-stamped flat file that is never actually deleted. 

To revert this feature, simply remove the dud file and run jekyll. That should restore it to the previous post for that URL.

### Other Hacks

Use params for any particular variable in a form, which will default the text for that particular form field.

	?title=helloworld
	
The param can be handy for mutli-stepped forms or for transferring data from one step to another.



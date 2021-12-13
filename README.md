# Select Primary Category


### Description
* A plugin that allows the users to select a primary category for posts.
* Shortcode to display posts by selected primary category.

### Installation
1. Add the plugin folder to WordPress' plugin directory.
2. Activate the plugin from Admin > Plugins.
3. Start using it.

### Shortcode

`[spc_posts type="post" category="news" ppp="10" orderby="name" order="ASC"]`

== Supported Shortcode Attributes ==

* type: The value should be the name of posttype. Default value is `any`. Example: `type="post"`
* category: The value should be the name of the category. Default value is `uncategorized`. Example: `category="news"`
* ppp: The number of posts per page you want to get in the result. Default value is `-1`. Example: `ppp=10`
* orderby: Use to retrieve the posts by specific parameter. Default value is `date`. Example: `orderby=name`
* order: Use to designate the ascending or descending order for the 'orderby' parameter. Default value is `DESC`. Example: `order:ASC`

Refer this link for orderby and order parameters, https://developer.wordpress.org/reference/classes/wp_query/#order-orderby-parameters

### Changelog
== Version 1.0 ==
* Initial release.
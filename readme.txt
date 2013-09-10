=== Relate Groups to Blogs ===

Contributors: spurge, lakrisgubben, alfreddatakillen
Tags: buddypress, groups, blogs
Requires at least: WordPress 3.4.2, BuddyPress 1.6.1
Tested up to: WordPress 3.4.2 / BuddyPress 1.6.1
Stable tag: 1.2.1

Makes it possible to relate groups to blogs and define the relationships
to whatever you want.

== Description ==

When groups are started or edited, you can relate them to several blogs.
These relationships will then be displayed on both groups pages and on a
blog widget.

On group pages, related blogs can be shown in the group header and on a
seperate group page.

This plugin is highly customizable. You can change where to show the
blog-group relationships and some titles and descriptions. All html
output can be overriden with your own templates.

= Available languages =

* English (built-in)
* Swedish

== Installation ==

Download and upload the plugin to your plugins folder. Then activate it
in your network administration.

Set where to show the blog-group relationships, titles and descriptions
in the network admin settings pages.

= Overriding templates =

These templates are overridable:

* bp-relate-groups-to-blogs-admin.php - administration form in the
  network admin.
* bp-relate-groups-to-blogs-display[-group-name].php - group page display.
* bp-relate-groups-to-blogs-edit[-group-name].php - group edit page.
* bp-relate-groups-to-blogs-widget.php - blog widget that shows related
  groups.
* bp-relate-groups-to-blogs-widget-form.php - blog widget edit form.

== Changelog ==

= v1.2.1 =

* Removed annoying warning when requesting an empty blog list.

= v1.2 =

* Group edit page description is editable
* Group edit page searchfield label is editable
* Enable/disable blog slogan in blog list

= v1.1.2 =

* Blog list in group header is hidden if there are no related blogs.
* Annoying autocomplete in blog search field is gone.

= v1.1 =

* Widget is hidden if there are no groups related.
* Widget default title is editable.

= v1.0 =

* Added widget for displaying groups in blog sidebar.
* Network admins can set the following: tab title, if tab is enabled,
page title, page description, if groups can set their own
descriptions, if blog shall be visible in group headers.

= v0.8 =

* Blogs can be added in groups admin.
* Related blogs are displayed on a group tab.
* Groups can add descriptions on group tab.

== Notes ==

License.txt - contains the licensing details for this component.

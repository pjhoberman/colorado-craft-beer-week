=== The Events Calendar: Community Events ===

Contributors: PaulHughes01, jazbek, jbrinley, roblagatta, shane.pearlman, codearachnid, peterchester, reid.peifer, jonahcoyote, ModernTribe
Tags: widget, events, simple, tooltips, grid, month, list, calendar, event, venue, community, registration, api, dates, date, plugin, posts, sidebar, template, theme, time, google maps, google, maps, conference, workshop, concert, meeting, seminar, summit, forum, shortcode, The Events Calendar, The Events Calendar PRO
Donate link: http://m.tri.be/29
Requires at least: 3.6
Tested up to: 3.8
Stable tag: 3.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Community Events is an add-on for The Events Calendar that empowers users to submit and manage their events on your website.

== Description ==

Content

= The Events Calendar: Community Events =

* Frontend user event submission (anonymous & logged in)
* Decide whether submissions are published or saved to draft
* Style submission form using custom templates

Note: you'll need to have the latest version of <a href="http://m.tri.be/3j">The Events Calendar</a> installed for this plugin to function.

== Installation ==

= Install =

1. From the dashboard of your site, navigate to Plugins --> Add New.
2. Select the Upload option and hit "Choose File."
3. When the popup appears select the the-events-calendar-community-events.x.x.zip file from your desktop. (The 'x.x' will change depending on the current version number).
4. Follow the on-screen instructions and wait as the upload completes.
5. When it's finished, activate the plugin via the prompt. A message will show confirming activation was successful.
6. For access to new updates, make sure you have added your valid License Key under Events --> Settings --> Licenses.

= Requirements =

* WordPress 3.6
* PHP 5.2
* The Events Calendar 3.2 or above

== Documentation ==

Community Events extends the functionality of Modern Tribe's The Events Calendar (http://m.tri.be/3j) to allow for frontend event submission on your WordPress site. With pretty permalinks enabled, the frontend fields are accessible at the following URLs:

Events list: /events/community/list/
Specific page in events list: /events/community/list/page/[num]
Add a new event: /events/community/add/
Edit an already-submitted event: /events/community/edit/[id] ( redirects to /events/community/list/[post-type]/id )
Delete an already-submitted event: /events/community/delete/[id]

Where /events/ is the TEC slug defined on the main settings tab, and /community/ is the CE slug defined on the Community settings tab (e.g. you can tweak the first 2 parts of the URL).

= Shortcodes =

Shortcodes are only available for users who have permalinks turned off; this method will NOT work if you're running with a pretty permalinks structure. These will only work on pages, so don't try them in posts/events/widgets/etc.

Shortcode information

Create a page and use the following:

[tribe_community_events_title] as title
[tribe_community_events] in content

You can add this page to the menu.

== Screenshots ==

1. Frontend event submission form
2. List of a user's submitted events
3. Community Events email notification example

== Frequently Asked Questions ==

= Where do I go to file a bug or ask a question? =

Please visit the forum for questions or comments: http://m.tri.be/3h

== Contributors ==

The plugin is produced by <a href="http://m.tri.be/3i">Modern Tribe Inc</a>.

= Current Contributors =

* <a href="http://profiles.wordpress.org/users/jbrinley">Jonathan Brinley</a>
* <a href="http://profiles.wordpress.org/users/jazbek">Jessica Yazbek</a>
* <a href="http://profiles.wordpress.org/users/roblagatta">Rob La Gatta</a>
* <a href="http://profiles.wordpress.org/users/peterchester">Peter Chester</a>
* <a href="http://profiles.wordpress.org/users/reid.peifer">Reid Peifer</a>
* <a href="http://profiles.wordpress.org/users/shane.pearlman">Shane Pearlman</a>

= Past Contributors =
* <a href="http://profiles.wordpress.org/users/paulhughes01">Paul Hughes</a>
* <a href="http://profiles.wordpress.org/users/codearachnid">Timothy Wood</a>
* <a href="http://profiles.wordpress.org/users/jonahcoyote">Jonah West</a>
* <a href="http://profiles.wordpress.org/users/jkudish">Joachim Kudish</a>
* <a href="http://profiles.wordpress.org/users/nciske">Nick Ciske</a>
* Justin Endler

= Translators =

* Brazilian Portuguese from Luiza Libardi
* Czech from Petr Bastan
* Finnish by Ari-Pekka Koponen
* French by Bastien BC
* German by by Dieter Dannecker
* Italian from Roberto Scano
* Romanian by Mihai Burcea
* Spanish from Frank Rondon

* Previous translators include H√©ctor Gil Rizo, Jan, Marc Galliath, Jurgen Michiels, Vanessa Bianchi, Marco Infussi, Ali Senhaji, Oliver Heinrich, and Petr Bastan

== Add-Ons ==

But wait: there's more! We've got a whole stable of plugins available to help you kick ass at what you do. Check out a full list of the products below, and over at the <a href="http://m.tri.be/3k">Modern Tribe website.</a>

Our Free Plugins:

* <a href="http://wordpress.org/extend/plugins/advanced-post-manager/" target="_blank">Advanced Post Manager</a>
* <a href="http://wordpress.org/plugins/blog-copier/" target="_blank">Blog Copier</a>
* <a href="http://wordpress.org/plugins/image-rotation-repair/" target="_blank">Image Rotation Widget</a>
* <a href="http://wordpress.org/plugins/widget-builder/" target="_blank">Widget Builder</a>

Our Premium Plugins:

* <a href="http://m.tri.be/2c" target="_blank">The Events Calendar PRO</a>
* <a href="http://m.tri.be/2e" target="_blank">The Events Calendar: Eventbrite Tickets</a>
* <a href="http://m.tri.be/2g" target="_blank">The Events Calendar: Community Events</a>
* <a href="http://m.tri.be/2h" target="_blank">The Events Calendar: Facebook Events</a>
* <a href="http://m.tri.be/2i" target="_blank">The Events Calendar: WooCommerce Tickets</a>
* <a href="http://m.tri.be/ci" target="_blank">The Events Calendar: EDD Tickets Tickets</a>
* <a href="http://m.tri.be/cu" target="_blank">The Events Calendar: WPEC Tickets</a>
* <a href="http://m.tri.be/dp" target="_blank">The Events Calendar: Shopp Tickets</a>
* <a href="http://m.tri.be/fa" target="_blank">The Events Calendar: Filter Bar</a>

== Upgrade Notice ==

This upgrade requires The Events Calendar 3.0+

== Changelog ==

= IMPORTANT NOTICE =

3.0 is a complete overhaul of the plugin, and as a result we're starting the changelog fresh. For release notes from the 2.x lifecycle, see <a href="http://m.tri.be/k">our 2.x release notes.</a>

= 3.4 =

* Added a “View Submitted Event” link that appears after a submission has gone through
* Addressed an issue where the datepicker would not honor the core WordPress (thanks to lamagia on the forums for the report!)
* Fixed a bug for PRO users where the custom venue and organizer configured in PRO would remain even after that plugin was deactivated

= 3.3 =

* Community now uses the same events template setting as core plugin views
* Default Events Template can now be chosen to display the submission form etc (not previously allowed)
* User-submitted data is more thoroughly scrubbed for malicious data
* Incorporated updated German translation files, courtesy of Oliver Heinrich
* Incorporated updated French translation files, courtesy of Bastien BC

= 3.2 =

* Fixed a bug where recurring event instances were not visible on the "My Events" list under certain settings
* Fixed a handful of minor PHP notices
* Added a minor improvement to recurrence settings fieldset display
* Fixed a bug where the datepicker was huge in some themes
* Template overrides for Community Events in your theme should now all be inside the [your-theme]/tribe-events/community directory; a deprecated notice will be generated if they are directly in the [your-theme]/tribe-events folder
* Incorporated updated French translation files, courtesy of Ali Senhaji

= 3.1 =

= SUBSTANTIAL UPDATES TO TEMPLATES! =

If you have customized your community events templates you'll probably have to redo your customizations for this upgrade. Proceed with caution!

The templates have been completely reorganized and substantially cleaned up. This will make it much easier for theme developers to work with the templates in the future.

Additional Changes:

* Improved behavior of recurring events deletion from My Events list
* Cannot reach the community list page *
* Fixed bug where new venues submitted via Community weren't being published along with their event
* Community now uses the specified Events template under Settings > Display
* Improved spam prevention technique (honeypot) implemented on the Community submission form
* Community submission form now respects default venue setting and hides the other venue fields (address, etc.)
* Community submission form now respects default content fields
* Event Website URL field is no longer missing from the Community submission form
* Styles are no longer stripped from Community submissions
* Fixed bug where the saved venues dropdown wasn't displaying on the Community submit form
* New Venues and Organizers no longer overwrite existing ones when editing an event
* Fixed bug where submit form wasn't working properly for anonymous users in some cases
* Users can now always view their My Events listing
* Users will no longer be redirected to wp-login.php upon logout, if they do not have dashboard access
* Updated translations: Romanian (new), Finnish (new)
* Various minor bug and security fixes

= 3.0.1 =

* Performance improvements to the plugin update engine
* Fixed two strings that weren't being translated in the admin bar menu

= 3.0 =

Updated version number to 3.0.x for plugin version consistency

= 1.0.7 =

* Fix plugin update system on multisite installations

= 1.0.6 =

*Small features, UX and Content Tweaks:*

* Code modifications to ensure compatibility with The Events Calendar/Events Calendar PRO 3.0.
* Incorporated new Norwegian translation files, courtesy of Eyolf Steffensen.
* Incorporated new Polish translation files, courtesy of Lukasz Kruszewski-Zelman.
* Incorporated new Swedish translation files, courtesy of Ben Andersen.
* Incorporated new Croatian translation files, courtesy of Jasmina Kovacevic.

*Bug Fixes:*

* Addressed a vulnerability where certain shortcodes can be used to exploit  sites running older versions of Community Events.
* Custom field values are no longer wiped after submitting when failing to check the anti-spam checkbox.
* Frontend community form now loads properly in WordPress 3.5 environments.
* Reinforced capabilities blocking unwanted users from the site admin.
* Users lacking organizer/venue edit permissions now see an appropriate error message.
* By removing the Next Event widget from Events Calendar PRO (see 3.0 release notes), we've eliminated the problem where Community and the Next Event widget conflicted when placed together on a page.
* Addressed a warning ("Creating default object from empty value") that impacted certain users.
* Corrected untranslatable elements in event-form.php.
* Addressed a bug causing labels to appear below fields on the frontend submit form for certain users.
* Redirect URLS (as configured under Events -> Settings -> Community) now function as expected.
* Removed various styling problems on the Twenty Twelve theme in WP 3.5.

= 1.0.5 =

*Small features, UX and Content Tweaks:*

(None this time)

*Bug Fixes:*

* Various bug fixes.

= 1.0.4 =

*Small features, UX and Content Tweaks:*

* Incorporated updated German translation files, courtesy of Marc Galliath.

*Bug Fixes:*

* Fixed a bug that led to a fatal error in the WordPress 3.5 beta 2.
* Removed an illegal HTML style tag from the frontend Community form.

= 1.0.3 =

*Small features, UX and Content Tweaks:*

* Clarified messaging regarding pre-populated "Free" text on cost field.
* Disabled comments from the frontend submission form.
* Added a filter -- 'tribe_community_events_event_categories' -- to allow users to filter the category list that appears on the frontend submission form.
* Added a new hook -- $args = apply_filters( 'tribe_community_events_my_events_query', $args ); -- at a user's request. This alteration allows you to tap into the WotUser object and pull out a list of events the user has access to and add them into this query.
* Incorporated new Dutch language files, courtesy of Jurgen Michiels.
* Incorporated new French language files, courtesy of Vanessa Bianchi.
* Incorporated new Italian language files, courtesy of Marco Infussi.
* Incorporated new German language files, courtesy of Marc Galliath.
* Incorporated new Czech language files, courtesy of Petr Bastan.

*Bug Fixes:*

* Removed a duplicate name attribute from venue-meta-box.php.
* Categories now save on events submitted by subscriber-level members.
* Categories now save on events submitted by anonymous users.
* The default state selection as configured in Events Calendar PRO now appears (along with the country) on the frontend submission form.
* Subscriber-level users may now edit events when that option is enabled under Events --> Settings --> Community.
* Reconfigured the cost field to work for frontend submissions on sites running the Eventbrite Tickets add-on + Community Events.
* Removed any lingering redirects to the WP Router Placeholder Page.
* My Events filtering options no longer conflict with the calendar widget.
* Fixed a broken link in the message that appears when Community Events is activated without the core The Events Calendar.
* Removed code causing a division by zero error in tribe-community-events.class.php.
* Styles from Community-related pages (events-admin-ui.css) no longer load on non-Community pages.
* Cleared up untranslatable language strings found in the 1.0.2 POT file.

= 1.0.2 =

*Bug Fixes:*

* Removed unclear/confusing message warning message regarding the need for plugin consistency and added clearer warnings with appropriate links when plugins or add-ons are out date.

= 1.0.1 =

*Small features, UX and Content Tweaks:*

* Removed the pagination range setting from the Community tab on Settings -> The Events Calendar.
* Added body classes for both the community submit (tribe_community_submit) and list (tribe_community_list) pages.
* Incorporated new Spanish translation files, courtesy of Hector at Signo Creativo.
* Incorporated new German translation files, courtesy of Mark Galliath.
* Added boolean template tags for tribe_is_community_my_events_page() and tribe_is_community_edit_event_page()
* Added new "Events" admin bar menu with Community-specific options

*Bug Fixes:*

* Rewrite rules are now being flushed when the allowAnonymousSubmissions setting is changed.
* Duplicate venues and organizers are no longer created with each new submission.
* Community no longer deactivates the Events Calendar PRO advanced post manager.
* Clarified messaging regarding the difference between trash/delete settings options.
* Header for status column is no longer missing in My Events.

= 1.0 =

Initial release
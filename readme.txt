=== Acknowledge Me ===
Contributors: Shelob9
Tags: github, contributors, acknowledgment, pods
Donate link: http://pods.io
Requires at least: 3.8.0
Tested up to: 4.1
Stable tag: 0.2.2
License: GPL v2+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt

Shows contributors to a Github repo, retrieved via the GitHub API.

== Description ==
A Community Building Tool By [Pods](http://pods.io/pods)

To output as HTML via PHP, use `echo acknowledge_me_display( $owner, $repo, $header_text = false, $total = 100 )` where `$owner` is the user name or organization name for the repo, and `$repo` is the repo name. Optionally add some header text or change the limit for the number of contributors.

Example, show 50 contributors to `https://github.com/pods-framework/pods/` with `acknowledge_me_display( 'pods-framework', 'pods', 'Pods Is Brought To You By:', 50 );`

Or use shortcode `[acknowledge_me owner="pods-framework" repo="pods" header_text="Pods Is Brought To You By:" total="50"]`

This plugin copyright 2015 Pods Foundation LLC. Licensed under the terms of the GPL v2 or later. Based on the code for the [underscores.me site](https://github.com/Automattic/underscores.me/), which is copyright Automattic, hugobaeta, kovshenin and GPL licensed.

== Installation ==
1. Unpack the entire contents of this plugin zip file into your plugins folder locally
1. Upload to your site
1. Navigate to `wp-admin/plugins.php` on your site (your WP Admin plugin page)
1. Activate this plugin

== Frequently Asked Questions ==
Can I Show Only Contributors For A Specific Version?

No. This isn't something the GitHub API supports.


== Screenshots ==
1. Example

== Changelog ==
= Version 1 January 11, 2015 =
Initial version.

== Upgrade Notice ==
= Version 1 January 11, 2015 =
Initial version.

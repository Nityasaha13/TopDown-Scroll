=== Top-Down Scroll – Scroll to Top Button ===
Contributors: nityasaha
Donate link: https://buymeacoffee.com/nityasaha
Tags: scroll to top, back to top, go to top, scroll to top button, smooth scroll
Requires at least: 6.0
Tested up to: 7.1
Requires PHP: 7.4
Stable tag: 1.3.6
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Add a scroll to top button and an optional scroll to bottom button to any WordPress theme. Custom icon, color, size and position.

== Description ==

Top-Down Scroll adds a **scroll to top button** to your WordPress site, plus an optional **scroll to bottom button**, so visitors can jump to either end of a long page in a single click.

Long posts, documentation pages, product listings and endless-scroll archives all leave readers stranded at the bottom of the page. A back to top button fixes that, and this plugin adds one without you touching a single line of code.

Everything is configured on one screen under **Appearance &rarr; Top-Down Scroll**. There is no shortcode to place and no template file to edit: switch a button on and it appears across your whole site.

= Why use Top-Down Scroll? =

* **Two buttons, controlled separately** &mdash; turn on the scroll to top button, the scroll to bottom button, or both.
* **Shows only when it is useful** &mdash; the top button appears once a visitor has scrolled past 10% of the page, and the bottom button hides as they approach the end, so neither button sits on top of your content when it is not needed.
* **Smooth scrolling** &mdash; clicking a button glides the page to the top or bottom instead of jumping there.
* **Use your own icon** &mdash; pick any image or SVG from your media library, or keep the built-in arrows.
* **Match your brand colors** &mdash; choose a background color and a separate hover color with the built-in color picker.
* **Left or right** &mdash; place the buttons on whichever side suits your layout.
* **Adjustable icon size** &mdash; set the size in pixels to suit your design.
* **Works with any theme** &mdash; the buttons are output through `wp_footer`, so block themes, classic themes and page builders are all supported.
* **Translation ready** &mdash; every piece of interface text can be translated.

= How it works =

Once activated, the plugin renders a fixed-position button in the corner of your site. As the visitor scrolls, the button appears; clicking it smooth-scrolls the page back to the top. If you also enable the scroll to bottom button, a second button sits beside it and jumps the visitor to the end of the page.

You stay in control of how the buttons look. Upload a custom arrow, a chevron, a logo mark or any icon you like, set its size, and give it a background and hover color that fits your design.

== Installation ==

= From your WordPress dashboard =

1. Go to **Plugins &rarr; Add New**.
2. Search for **Top-Down Scroll**.
3. Click **Install Now**, then **Activate**.
4. Go to **Appearance &rarr; Top-Down Scroll** to configure your buttons.

= Manual installation =

1. Upload the `top-down-scroll` folder to the `/wp-content/plugins/` directory, or upload the zipped folder via **Plugins &rarr; Add New &rarr; Upload Plugin**.
2. Activate the plugin through the **Plugins** menu in WordPress.
3. Go to **Appearance &rarr; Top-Down Scroll** to configure your buttons.

== Frequently Asked Questions ==

= How do I add a scroll to top button in WordPress? =

Install and activate Top-Down Scroll, then go to **Appearance &rarr; Top-Down Scroll** and switch on **Scroll to top**. The button is added to every page of your site straight away, with no shortcode or theme editing required.

= Where do I find the plugin settings? =

Under **Appearance &rarr; Top-Down Scroll** in your WordPress dashboard. There is also a **Settings** link next to Top-Down Scroll on the Plugins screen.

= Can I show only the scroll to top button? =

Yes. The scroll to top and scroll to bottom buttons are independent, so you can enable either one on its own or use both together.

= Can I use my own icon or image? =

Yes. Click **Select icon** next to either button and choose any image from your media library. SVG and PNG both work. Leave it empty to use the built-in arrow.

= Can I change the button color? =

Yes. The settings screen has a color picker for the button background and a second one for the hover color, so the button can change color when a visitor points at it.

= Can I move the button to the left or the right? =

Yes. The **Position** setting places both buttons on either the left or the right side of the screen.

= How do I change the size of the button icon? =

Set a value in the **Icon size** field. The default is 20px, and 18&ndash;25px works best when both buttons are enabled at once.

= When does the scroll to top button appear? =

The top button appears once the visitor has scrolled past roughly 10% of the page, so it stays out of the way at the very top. The bottom button hides once they are within the last 10% of the page.

= Does it work with my theme? =

Yes, as long as your theme calls `wp_footer()`, which every properly built theme does. Block themes, classic themes and page builder layouts are all supported.

= Does the button work on mobile? =

Yes. The buttons use fixed positioning and stay in the corner of the screen on phones and tablets just as they do on desktop.

= Does clicking the button scroll smoothly? =

Yes. Both buttons use native smooth scrolling, so the page glides to the top or bottom rather than jumping instantly.

== Screenshots ==

1. The scroll to top and scroll to bottom buttons on the front end of a site.
2. The plugin settings screen under Appearance &rarr; Top-Down Scroll.

== Changelog ==

= 1.3.6 =
* Redesigned the settings screen: card-based layout, toggle switches, a segmented position control and clearer icon previews
* Added a "Settings saved" confirmation notice
* Added input sanitization for the icon size setting

= 1.3.5 =
* Compatabillity

= 1.3.4 =
* Compatabillity

= 1.3.2 =
* Compatabillity

= 1.3.1 =
* Security and optimization

= 1.3 =
* Bug-free

= 1.2 =
* All required features added

= 1.1 =
* First release

== Upgrade Notice ==

= 1.3.6 =
Refreshed settings screen and a fixed asset cache-busting version. Your existing settings and front-end buttons are unchanged.

# Simple Cookie Consent

A lightweight and customisable WordPress plugin for cookie consent management.

## Description

Simple Cookie Consent is a user-friendly WordPress plugin that allows you to easily add a customisable cookie consent banner to your website. With various styling options and configurable settings, you can ensure your site complies with cookie consent regulations while maintaining your site's aesthetic.

## Installation

1. Download the plugin zip file.
2. Log in to your WordPress admin panel.
3. Go to Plugins > Add New.
4. Click on the "Upload Plugin" button at the top of the page.
5. Click "Choose File" and select the downloaded zip file.
6. Click "Install Now".
7. After installation, click "Activate Plugin".

The Simple Cookie Consent plugin is now installed and activated on your WordPress site.

## Configuration

After activation, you can configure the plugin by going to Settings > Cookie Consent in your WordPress admin panel. Here's a breakdown of each option:

1. **HTML Code**: This is the HTML code that will load into the `<head>` of the page if consent is given. Use this to load Google Analytics, etc.

2. **Consent Message**: The message displayed on the consent banner. Use {{SITE_NAME}} as a placeholder for your site name.

3. **Background Color**: Choose the background color for the consent banner.

4. **Text Color**: Select the color for the text on the consent banner.

5. **Button Background Color**: Set the background color for the consent buttons.

6. **Button Text Color**: Choose the color for the text on the consent buttons.

7. **Link Color**: Set the color for any links in the consent message.

8. **Privacy Policy URL**: Enter the URL of your privacy policy page.

9. **Cookie Policy URL**: Enter the URL of your cookie policy page.

10. **Consent Period (days)**: Set the number of days before asking for consent again.

11. **Delete settings on deactivation**: Choose whether to delete all plugin settings when the plugin is deactivated.

## Frequently Asked Questions

### Does this comply with GDPR?

While this plugin is designed with GDPR considerations in mind, we cannot guarantee full compliance as GDPR requirements can be complex and vary based on your specific use case. We recommend consulting with a GDPR expert or legal professional to ensure your implementation meets all necessary requirements. This plugin is provided "as is" without any warranties.

### Does this work with Consent Management Platforms?

At present, this plugin does not integrate directly with Consent Management Platforms. It operates as a standalone solution for basic cookie consent management.

### How do I change the look and feel of the banner?

The appearance of the banner can be easily customised by editing the CSS. The plugin's CSS file is clear and well-structured, making it straightforward to modify. You can find the CSS file at `wp-content/plugins/simple-cookie-consent/css/simple-cookie-consent.css`.

### Can I add my own custom scripts when consent is given?

Yes, you can add your own custom HTML or scripts in the "HTML Code" field in the plugin settings. This code will be executed once the user gives their consent.

### Is this plugin compatible with caching plugins?

Yes, this plugin should be compatible with most caching plugins. The cookie consent banner is loaded dynamically using JavaScript, which typically bypasses page caching.

## Support

If you encounter any issues or have questions about the plugin, please open an issue.

## License

This plugin is licensed under the GPL v2 or later.
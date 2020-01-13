<?php

/**
 * Plugin Name:       Modularity Comments
 * Plugin URI:        https://github.com/helsingborg-stad/modularity-comments
 * Description:       Display tile-style post/page grid
 * Version:           1.0.0
 * Author:            Nikolas Ramstedt
 * Author URI:        https://github.com/helsingborg-stad
 * License:           MIT
 * License URI:       https://opensource.org/licenses/MIT
 * Text Domain:       modularity-comments
 * Domain Path:       /languages
 */

 // Protect agains direct file access
if (! defined('WPINC')) {
    die;
}

define('MODULARITYCOMMENTS_PATH', plugin_dir_path(__FILE__));
define('MODULARITYCOMMENTS_URL', plugins_url('', __FILE__));
define('MODULARITYCOMMENTS_TEMPLATE_PATH', MODULARITYCOMMENTS_PATH . 'templates/');
define('MODULARITYCOMMENTS_MODULE_PATH', MODULARITYCOMMENTS_PATH . 'source/php/Module');


load_plugin_textdomain('modularity-comments', false, plugin_basename(dirname(__FILE__)) . '/languages');

require_once MODULARITYCOMMENTS_PATH . 'source/php/Vendor/Psr4ClassLoader.php';
require_once MODULARITYCOMMENTS_PATH . 'Public.php';

// Instantiate and register the autoloader
$loader = new ModularityComments\Vendor\Psr4ClassLoader();
$loader->addPrefix('ModularityComments', MODULARITYCOMMENTS_PATH);
$loader->addPrefix('ModularityComments', MODULARITYCOMMENTS_PATH . 'source/php/');
$loader->register();

// Start application
new ModularityComments\App();

// Acf auto import and export
add_action('plugins_loaded', function () {
    $acfExportManager = new \AcfExportManager\AcfExportManager();
    $acfExportManager->setTextdomain('modularity-testimonials');
    $acfExportManager->setExportFolder(MODULARITYCOMMENTS_PATH . 'source/php/acf-fields/');
    $acfExportManager->autoExport(array(
        'modularity-comments' => 'group_5e1c32c1e342e'
    ));
    $acfExportManager->import();
});

/**
 * Registers the module
 */
add_action('plugins_loaded', function () {
    if (function_exists('modularity_register_module')) {
        modularity_register_module(
            MODULARITYCOMMENTS_MODULE_PATH ."/Comments/",
            'Comments'
        );
    }
});

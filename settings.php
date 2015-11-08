<?php
require_once __DIR__ . '/inc/base.php';
insertHeader();

$config = new \Bookshelf\Core\Configuration(true);
?>

<h1>Settings</h1>
<p>Currently, all settings are read-only. To actually modify them, you will have to do that manually either in the config.ini file or the database.
<br>Only configuration values from the database are shown on this page.</p>

<p>
    Library directory: <input type="text" disabled value="<?php echo $config->getLibraryDir(); ?>">
    <br>Debugging enabled: <input type="text" disabled value="<?php echo $config->getDebuggingEnabled() ? 'true' : 'false'; ?>">
    <br>Base URL: <input type="text" disabled value="<?php echo $config->getBaseUrl(); ?>">
</p>
<?php
insertFooter();

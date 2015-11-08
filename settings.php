<?php
require_once __DIR__ . '/inc/base.php';
insertHeader();

$config = new \Bookshelf\Core\Configuration(true);

if(isset($_POST['libraryDir'])) {
    $config->setLibraryDir($_POST['libraryDir']);
}
if(isset($_POST['debuggingEnabled'])) {
    $bool = false;
    if($_POST['debuggingEnabled'] == 'true' || $_POST['debuggingEnabled'] == 'yes') {
        $bool = true;
    }
    elseif($_POST['debuggingEnabled'] == 'false' || $_POST['debuggingEnabled'] == 'no') {
        $bool = false;
    }
    else {
        $bool = (bool)$_POST['debuggingEnabled'];
    }
    
    $config->setDebuggingEnabled((bool)$bool);
}
if(isset($_POST['baseUrl'])) {
    $config->setBaseUrl($_POST['baseUrl']);
}
?>

<h1>Settings</h1>

<form action="#" method="post">
    <!-- Yes, this *is* an actual, real *table*. No, it doesn't have a border but it is a table nonetheless. No table-layouting but a table :) -->
    <table id="settingsTable">
        <tr><td class="settingsLabel">Library directory:</td><td class="settingsInput"><input name="libraryDir" type="text" value="<?php echo $config->getLibraryDir(); ?>"></td></tr>
        <tr><td class="settingsLabel">Debugging enabled:</td><td class="settingsInput"><input name="debuggingEnabled" type="text" value="<?php echo $config->getDebuggingEnabled() ? 'true' : 'false'; ?>"></td></tr>
        <tr><td class="settingsLabel">Base URL:</td><td class="settingsInput"><input name="baseUrl" type="text" value="<?php echo $config->getBaseUrl(); ?>"></td></tr>
    </table>

    <input type="submit">
</form>
<?php
insertFooter();

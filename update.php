<?php
require_once __DIR__ . '/inc/base.php';
insertHeader();

$config = new \Bookshelf\Core\Configuration(true);
$base_url = $config->getBaseUrl();
?>
    <h1>Update</h1>
<?php
$updater = new \Bookshelf\Utility\Updater();

switch($_GET['performUpgrade']) {
    case 'performUpgrade':
        if(!($updater->update_necessary && $updater->update_possible)) {
            echo '<div class="error"><span class="bold">Error:</span> Upgrade not possible.</div>';
            break;
        }

        $updater->performUpgrade();
        break;
    default:
        if($updater->update_necessary) {
            ?>
            <p>A new version of Bookshelf is available!</p>
            <p><span class="bold">New version:</span> <?php echo $updater->new_version_text; ?><br>
                <span class="bold">Release notice:</span> <?php echo $updater->release_notice; ?></p>
            <?php
            if($updater->update_possible) {
                ?>
                <p>An automatic update appears to be possible.</p>
                <p>
                    Click <a href="<?php echo $updater->new_version_download; ?>">here</a> to download the new version and install it manually.<br>
                    Click <a href="<?php echo $base_url; ?>/update.php?performUpgrade=performUpgrade">here</a> to perform the automatic upgrade.
                </p>
                <?php
            }
            else {
                ?>
                <p>An automatic update is unfortunately not possible as your version of Bookshelf is too old and not supported anymore:</p>
                <pre><?php echo $updater->legacy_notice; ?></pre>
                <p>
                    Click <a href="<?php echo $updater->new_version_download; ?>">here</a> to download the new version and install it manually.<br>
                </p>
                <?php
            }
        }
        else {
            echo 'You are already using the latest version of Bookshelf. No update is necessary at this time.';
        }
        break;
}

insertFooter();

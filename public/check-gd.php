<?php
// Check if GD extension is enabled
if (extension_loaded('gd')) {
    echo "GD extension is enabled!";
    echo "<br>GD Version: " . gd_info()['GD Version'];
} else {
    echo "GD extension is NOT enabled!";
}
?>

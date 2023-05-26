<?php
/**
 * Build the setup options form.
 *
 * @package PinX
 * @subpackage build
 */
/* set some default values */

/* get values based on mode */
switch ($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
        $output = '<h2>Alpha Toro PinX Installer</h2>
        <p>Thanks for installing PinX! Please visit https://www.alphatoro.com for support.</p><br />';
        break;
    case xPDOTransport::ACTION_UPGRADE:
    case xPDOTransport::ACTION_UNINSTALL:
        break;
}

return $output;

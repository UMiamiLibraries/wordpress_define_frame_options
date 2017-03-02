<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin/partials
 */
?>

<div>
    <div>
        <h2>Define X-Frame Options</h2>
    </div>
    <div>
        <div>
            <a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-Frame-Options">More information about X-Frame Options</a>
            <p>Please select the option</p>
        </div>
        <div>
            <ul>
                <li case="DENY">
                    <input type="radio"><label>DENY</label></input>
                </li>
                <li case="SAMEORIGIN">
                    <input type="radio"><label>SAMEORIGIN</label></input>
                </li>
                <li case="ALLOW-FROM">
                    <input type="radio"><label>ALLOW-FROM</label></input>
                    <input id="url" placeholder="Insert a trusted site URL"></input>
                </li>
            </ul>
            <div>
                <button id="save_changes" disabled="disabled">Save changes</button>
            </div>
        </div>
    </div>
</div>



# note_ckgdoku
Plugin to insert the note plugin source code in dokuwiki using the ckgdoku/ckgedit editor (https://github.com/turnermm/ckgdoku / https://www.dokuwiki.org/plugin:ckgedit).

## Installation
Refer to: https://www.dokuwiki.org/plugin:ckgedit:configuration#extra_plugins.
Unzip the files to your `dokuwiki/lib/plugins/ckgedit/ckeditor/plugins/` or `dokuwiki/lib/plugins/ckgdoku/ckeditor/plugins/` folder and rename the folder to **note**.

## Dokuwiki configuration

Add the text **Note** to the dokuwiki **plugin»ckgedit»extra_plugins** or **plugin»ckgdoku»extra_plugins** configuration.

## Note: This plugin will work in either ckgdoku or ckgedit. 

It is no longer necessary to manually add this plugin to the `extra_plugins` list.  Instead, as above, unzip the plugin into the ckeditor plugins folder, and then add the plugin's toolbar button Name to the `extra_plugins` configuration option in the ckgdoku or ckgedit section of the Configuration Manager.  See the instructions in the ckgedit's documentation at dokuwiki.org: https://www.dokuwiki.org/plugin:ckgedit:configuration#extra_plugins. 

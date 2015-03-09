<?php

/**
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * 
 * @author Michael <michael@krmr.org>
 * @author Juergen-aus-Koeln <H-J-Schuemmer@Web.de>
 */
$lang['groups']                = 'Gruppe die den Timer für die Sperre deaktivieren darf (veraltet)';
$lang['fck_preview']           = 'Gruppe für FCK Vorschau';
$lang['guest_toolbar']         = 'Gästen Symbolleiste anzeigen';
$lang['guest_media']           = 'Gäste können Mediendateien verlinken';
$lang['open_upload']           = 'Gäste können Hochladen';
$lang['default_fb']            = 'Standardzugang für Dateiauswahl. Mit none wird ACL nicht verwendet.';
$lang['openfb']                = 'Dateiauswahl öffnen. Damit bekommt der Benutzer Zugang zur kompletten Verzeichnisstruktur, unabhängig von seinen Berechtigungen. ACL wird weiterhin für Uploads angewandt.';
$lang['dw_edit_display']       = 'Welche Benutzer haben Zugang zur Schaltfläche "DW Edit". Auswahl: "all" für alle Benutzer, "admin" für nur admin und managers; "none" für niemand. Der Standard ist "all".';
$lang['smiley_as_text']        = 'Smileys in CKGeditor als Text anzeigen (werden im Browser trotzdem als Bild angezeigt)';
$lang['editor_bak']            = 'Backup in meta/&lt;namespace&gt;.ckgedit speichern';
$lang['create_folder']         = 'Schaltfläche für neues Verzeichnis in der Dateiauswahl anzeigen (y/n)';
$lang['dwedit_ns']             = 'Komma-separierte Liste von Namesräumen und/oder Seiten für die ckgedit automatisch zum DokuWiki Editor wechselt. Akzeptiert auch teilweise Übereinstimmungen';
$lang['acl_del']               = 'Der Standard (nicht aktiviert) erlaubt Benutzern mit Berechtigung zum Hochladen auch Mediendatein zu löschen. Wenn das Kontrollkästchen aktiviert ist, braucht der Benutzer die Berechtigung im Verzeichnis zu Löschen.';
$lang['auth_ci']               = 'Beim Benutzername nicht Groß- und Kleinschreibung unterscheiden, damit kann man sich als BENUTZER und benutzer anmelden';
$lang['nix_style']             = 'Für Windows Server (Vista und höhere). Diese Einstellung ermöglicht den Zugriff auf data\media über cgkedit\CKeditor\userfiles, wenn in userfiles Links zu media und file erstellt wurden';
$lang['no_symlinks']           = 'Automatisches Erstellen von symbolischen Links in ckgedit/userfiles deaktivieren';
$lang['direction']             = 'Schreibrichtung in CKeditor: <b>nocheck</b>: ckgedit verändert die vorgegebene Schreibrichtung nicht, <b>dokuwiki</b>: die aktuelle Schreibrichtung von Dokuwiki, <b>ltr</b>: von links nach rechts; <b>rtl</b>: von rechts nach links.';
$lang['scayt_auto']            = 'Automatische Rechtschreibungprüfung aktivieren. Voreinstellung ist "on", um die Rechtschreibprüfung abzuschalten "off" auswählen';
$lang['scayt_lang']            = 'Standardsprache für automatische Überprüfung auswählen.';
$lang['smiley_hack']           = 'Beim Umzug auf einen neuen Server die URL für die Smileys des CKEditor zurücksetzen. Dies erfolgt für jede Seite getrennt wenn die Seite zum Bearbeiten geöffnet und gespeichert wird. Diese Option sollte normalerweise ausgeschaltet bleiben.';
$lang['complex_tables']        = 'Den komplexen Algorithmus für Tabellen verwenden. Im Vergleich zur normalen Verarbeitung von Tabellen sollte man damit bessere Ergebnisse erhalten, wenn man komplexe Strukturen von rowspans und colspans verwendet. Erfordert etwas mehr Verarbeitungszeit.';
$lang['duplicate_notes']       = 'Auf true setzen damit Benutzer mehrere Fußnoten mit demselben Fußnotentext erstellen können. Damit werden fehlerhafte Fußnoten verhindert.';
$lang['winstyle']              = 'Verwende direkten Pfad zum Medienverzeichnis anstatt fckeditor/userfiles. Dafür muss fckeditor/userfiles/.htaccess.security nach data/media kopiert und in .htaccess umbenannt werden';
$lang['other_lang']            = 'Als Standardsprache für den CKEditor wird die im Browser eingestellte Sprache verwendet. Alternativ kann hier eine andere Sprache ausgewählt werden. Diese ist unabhängig von der für DokuWiki gewählten Sprache.';
$lang['dw_priority']           = 'DokuWiki-Editor als Standard verwenden';
$lang['preload_ckeditorjs']    = 'Für schnelleres Laden des Editors Javascript für CKEditor im voraus laden';
$lang['nofont_styling']        = 'Schriftstile im Editor als Plugin markup anzeigen. Mehr Details dazu auf der Plugin-Seite für ckgedit auf Dokuwiki.org';
$lang['font_options']          = 'Schriftoptionen entfernen';
$lang['color_options']         = 'Farboptionen entfernen';
$lang['alt_toolbar']           = 'Funktionen, die aus der CKEditor-Toolbar entfernt werden sollen';

<?php
/**
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 *
 * @author w.-g.esders <esders@esders.eu>
 * @author Gunnar Lindenblatt <gunnar.lindenblatt@gmail.com>
 * @author WhitesnakeS04 <whitesnakess04@gmail.com>
 * @author Leo Rudin <leo.rudin@gmx.ch>
 * @author Juergen-aus-Koeln <H-J-Schuemmer@Web.de>
 * @author liz <marliza@web.de>
 * @author Christoph Ziehr <info@einsatzleiterwiki.de>
 */
$lang['fck_preview']           = 'FCK Vorschau Gruppe';
$lang['guest_toolbar']         = 'Werkzeugleiste für Gäste anzeigen';
$lang['guest_media']           = 'Gäste können Medien-Dateien verlinken';
$lang['open_upload']           = 'Gäste können hochladen';
$lang['default_fb']            = 'Standardmäßiger Zugang zum Durchsuchen der Dateien. Ohne diesen werden die Regeln der Zugangsverwaltung nicht angewendet.';
$lang['openfb']                = 'Öffentlich alle Dateien durchsuchbar. Benutzer erhalten Zugang zur gesamten Verzeichnisstruktur, unabhängig von der jeweiligen Zugangsberechtigung. Die Zugriffsrechte gelten weiterhin bei Uploads.';
$lang['dw_edit_display']       = 'Kontrolliert, welche Benutzer Zugang zur "DW Edit"-Taste haben. Möglichkeiten: "Alle" für alle Benutzer; "Admin" ausschließlich für Administratoren und Manager; "Niemand" für Keinen. Standardwert ist "Alle".';
$lang['dw_edit_display_o_all'] = 'Alle';
$lang['dw_edit_display_o_admin'] = 'Admin';
$lang['dw_edit_display_o_none'] = 'Niemand';
$lang['smiley_as_text']        = 'Smileys im CKeditor als Text anzeigen (wird im Browser weiterhin als Grafik angezeigt)';
$lang['editor_bak']            = 'Sicherung auf meta/&lt;namespace&gt;.ckgedit speichern';
$lang['create_folder']         = 'Aktiviere den neuen-Ordner-Button im Datei-Browser (y/n)';
$lang['dwedit_ns']             = 'Komma-getrennte Liste aus Namensräumen und Seiten, bei welchen automatisch auf den ursprünglichen Dokuwiki-Editor umgeschaltet wird; Teilausdrücke werden akzeptiert.';
$lang['acl_del']               = 'Default (kein Haken gesetzt) ermöglicht Benutzern mit Upload-Rechten media-Dateien zu löschen; wenn der Haken gesetzt wurde, benötigt der Benutzer die Berechtigung, aus dem Verzeichnis heraus zu löschen.';
$lang['auth_ci']               = 'Die ID des Benutzer-Logins ist schreibungsunabhängig, d.h. beide Schreibweisen USER und user sind möglich.';
$lang['nix_style']             = 'Für Windows-Server (Vista und später): Diese Einstellung ermöglicht den Zugang zu data\media durch ckgedit\CKeditor\userfiles, sofern Links zu media und file erfolgreich in userfiles angelegt wurden.';
$lang['no_symlinks']           = 'Automatische Erstellung symbolischer Links unter ckgedit/userfiles deaktivieren.';
$lang['direction']             = 'Einstellen der Sprach-Richtung in CKeditor: <b>nocheck</b>: ckgedit nimmt keine Einstellungsänderungen der Default-Richtung vor;  <b>dokuwiki</b>: die aktuelle Dokuwiki Sprach-Richtung; <b>ltr</b>: von links nach rechts ; <b>rtl</b>: von rechts nach links.';
$lang['scayt_auto']            = 'Aktiviere die SCAYT-Rechtschreibprüfung automatisch; Vorbelegt ist "An" = eingeschaltet. Zum Ausschalten von SCAYT auf "Aus" umstellen.';
$lang['scayt_auto_o_on'] = 'An';
$lang['scayt_auto_o_off'] = 'Aus';
$lang['scayt_auto_o_disable'] = 'Deaktiviert';
$lang['scayt_lang']            = 'Standard-Sprache für die SCAYT-Rechtschreibprüfung auswählen.';
$lang['smiley_hack']           = 'Bei Umzug auf neuen Server, die URL für CKeditor\'s Smileys zurücksetzen. Dies passiert seitenweise, sobald die Seite zur Bearbeitung geladen und gespeichert wird. Diese Option sollte i.d.R. ausgeschaltet sein.';
$lang['complex_tables']        = 'Den Algorithmus für komplexe Tabellen standardmäßig aktivieren. Im Gegensatz zur Standard-Syntaxanalyse von Tabellen, erreicht man hiermit bessere Ergebnisse, wenn Zellen miteinander über Zeilen oder Spalten hinweg verbunden werden. Jedoch auf Kosten leicht erhöhter Durchlaufzeit.';
$lang['duplicate_notes']       = 'Setze dies auf "true", wenn Anwender mehrere, gleichlautende Fußnoten erstellen; verhindert, dass in diesem Fall die Funktionalität der Fußnoten beschädigt wird.';
$lang['winstyle']              = 'Direkte Pfadangabe zum media-Verzeichnis verwenden anstatt fckeditor/userfiles. Dafür muss fckeditor/userfiles/.htaccess.security zu data/media kopiert und in .htaccess umbenannt werden.';
$lang['other_lang']            = 'Ihre Standard-Sprache für den CKEditor ist die Sprache, die auch Ihr Browser besitzt. Sie können jedoch hier eine andere Sprache wählen; unabhängig von der Sprache im Dokuwiki Inteface.';
$lang['dw_priority']           = 'Den Dokuwiki-Editor als Standard-Editor verwenden';
$lang['preload_ckeditorjs']    = 'Die Javascript-Umgebung für den Ckeditor vorab laden, um den Editor-Aufruf zu beschleunigen';
$lang['nofont_styling']        = 'Font Styles (= Schriftschnitt) im Editor als Plugin-Markup anzeigen. Weitere Informationen auf der ckgedit-Plugin-Seite unter Dokuwiki.org.';
$lang['font_options']          = 'Entfernt die Option zum Einstellen der Schriftart.';
$lang['color_options']         = 'Entfernt Farb-Optionen.';
$lang['alt_toolbar']           = 'Funktionen, die nicht in der Werkzeugleiste angezeigt werden sollen';
$lang['mfiles']                = 'mfile-Unterstützung einschalten.';
$lang['extra_plugins']         = 'Durch Kommata getrennte Liste zusätzlicher CKeditor Plugins zum Einfügen in die Toolbar. Siehe Details bei "ckgedit plugin\'s" <a href=\'https://www.dokuwiki.org/ plugin:ckgedit:configuration#extra_plugins\'>config page</a>';
$lang['dw_users'] = "Gruppenname der Benutzer, deren Standardeditor der DokuWiki-Editor ist, wenn <b>dw_priority</b> aktiviert ist. Wenn dieser Eintrag keinen Wert besitzt, haben alle Benutzer standardmäßig den DokuWiki-Editor, wenn <b>dw_priority</b> aktiviert ist.";
$lang['allow_ckg_filebrowser'] = 'Auswählen, welche(n) Datei/Medien Browser Benutzer verwenden können';
$lang['default_ckg_filebrowser'] = 'Auswählen, welche(r) Datei/Medien Browser standardmäßig verwendet wird. Wenn der gewählte Browser unzulässig ist, wird überschrieben.';
$lang['htmlblock_ok']          = 'Bei Verwendung von <code>HTML_BLOCK</code>s muss entweder diese Option oder die DokuWiki-Option <code>htmlok</code> eingeschaltet sein. Es stellt nicht das gleiche Sicherheitsrisiko dar wie <code>htmlok</code>. Dennoch sollte es nur in einer vertrauenswürdigen Benutzerumgebung und nicht in einem offenen Wiki verwendet werden. ';
$lang['dblclk']                = '<code>off</code> schaltet das Bearbeiten einzelner Abschnitte (Sections) per Doppelklick mit dem DokuWiki-Editor aus (siehe:  <a href=\'https://www.dokuwiki.org/plugin:ckgedit#direct_access_to_dokuwiki_editor\'>direct_access_to_dokuwiki_editor</a>) 	';
$lang['preserve_enc']          = 'Bewahre URL-Kodierung, falls die De-Akzent-Option von dokuwiki aktiv ist.';
$lang['gui']                   = 'Wähle CKEditor GUI (grafische Benutzeroberfläche)';
$lang['rel_links']             = 'Aktiviere Unterstützung für relative interne Verknüpfungen und Bildverknüpfungen.';
$lang['style_sheet'] = 'Ein alternatives Stylesheet für den CKEditor verwenden.' .
    ' Für weitere Informationen siehe das <b>CKEditor CSS Tool</b>, unter <em>weitere Plugins</em> im <code>Admin</code>-Bereich.' .
    ' Alternativ sind weitere Informationen auf der ckgedit plugin Seite zu finden.';	

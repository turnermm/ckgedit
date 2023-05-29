<?php

/**
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 *
 * @author Gerrit Uitslag <klapinklapin@gmail.com>
 * @author Coen Eisma <info@coeneisma.nl>
 * @author Mijndert <mijndert@mijndertstuij.nl>
 * @author Peter van Diest <peter.van.diest@xs4all.nl>
 */
$lang['groups']                = 'Groep met rechten om lock timer uit te schakelen (afgeschaft)';
$lang['fck_preview']           = 'FCK Voorbeeld Groep';
$lang['guest_toolbar']         = 'Toon werkbalk aan Gast';
$lang['guest_media']           = 'Gast mag Media bestanden linken';
$lang['open_upload']           = 'Gast mag uploaden';
$lang['default_fb']            = 'Standaard bestandstoegang permissies. Als \'none\', dan wordt ACL niet toegepast.';
$lang['openfb']                = 'Open bestandsbenadering. De gebruiker krijgt hierdoor toegang tot de volledige directory structuur, ongeacht de gebruikersrechten dit al dan niet toelaten. ACL is wel van toepassing op uploads.';
$lang['dw_edit_display']       = 'Welke gebruikers mogen de "DW Editor" knop gebruiken. Selecteer: "all" voor alle gebruikers; "admin" voor administrator en beheerders; "none" voor niemand. Standaardwaarde is "all".';
$lang['smiley_as_text']        = 'Toon smileys als tekst in FCKeditor (wordt wel als afbeelding getoond in de browser)';
$lang['editor_bak']            = 'Sla backup op in meta/&lt;namespace&gt;.ckgedit';
$lang['create_folder']         = 'Activeer knop Aanmaken map in bestandsverkenner (y/n)';
$lang['dwedit_ns']             = 'Komma-gescheiden lijst van namespaces waarbij ckgedit automatisch terugschakelt naar de oorspronkelijke DokuWiki Editor.';
$lang['acl_del']               = 'Standaardinstelling (niet aangevinkt) staat gebruikers met upload rechten toe om mediabestanden te verwijderen; indien aangevinkt, dan heeft gebruiker de verwijder-permissie nodig om het bestand uit de map te verwijderen.';
$lang['auth_ci']               = 'De gebruikers login is niet hoofdletter gevoelig, dus je kan inloggen met zowel GEBRUIKER als gebruiker';
$lang['nix_style']             = 'Voor Windows Servers (Vista en later).  Deze parameter maakt het mogelijk om data\media te benaderen met ckgedit\ckeditor\userfiles, indien links naar media en bestand succesvol aangemaakt zijn in userfiles';
$lang['no_symlinks']           = 'Deactiveert automatische creatie van symbolische links in ckgedit/userfiles. Deze optie moet uitgeschakeld worden tijdens updaten.';
$lang['direction']             = 'Zet de schrijf- en lees richting van de taal in CKeditor:  <b>nocheck</b>: geen wijziging van de standaard schrijfrichting in ckgedit;  <b>dokuwiki</b>:  gebruik de Dokuwiki taal schrijfrichting;  <b>ltr</b>: Links-naar-rechts; <b>rtl</b>: Rechts-naar-links.';
$lang['scayt_auto']            = 'Stelt in of de SCAYT spellingcontrole, tijdens-het-typen, al actief is bij openen van het bewerkvenster. Standaard op <code>off</code>; de gebruiker kan de spellingscontrole inschakelen per pagina. Om de Scayt spellingscontrole compleet te verwijderen, kies <code>disable</code>. (Zie voor meer achtergrond <a href="https://www.dokuwiki.org/plugin:ckgedit:configuration#scayt_auto">ckgedit:configuration#scayt_auto</a>") ';
$lang['scayt_lang']            = 'Activeer de SCAYT standaard taalcode.';
$lang['smiley_hack']           = 'Reset de URL voor FCKeditor\'s smilies bij verhuizing naar nieuwe server. Dit wordt pagina per pagina uitgevoerd bij het openen en bewaren van de pagina.  Deze optie zou normaal uit moeten staan.';
$lang['complex_tables']        = 'Gebruik het complex tables algorithm, in tegenstelling tot het standaard ontleding algoritme. Dit zou een beter resultaat geven wanneer complexe rowspans en colspans gemengd worden.';
$lang['duplicate_notes']       = 'Zet deze optie op true (aanvinken) wanneer gebruikers meerdere voetnoten maken met dezelfde voettekst; deze optie is noodzakelijk om te voorkomen dat de voetnoten corrupt raken.';
$lang['winstyle']              = 'Gebruik een direct pad naar de mediamap in plaats van fckeditor/userfiles. Deze functie kopieert <br />fckeditor/userfiles/.htaccess.security  naar data/media/.htaccess. Zo niet, dan moet dit handmatig gedaan worden.';
$lang['other_lang']            = 'De standaardtaal voor de CKGEditor is de taal zoals ingesteld voor de browser. Je kunt echter een andere taal kiezen, onafhankelijk van de taal van het Dokuwiki-interface.';
$lang['dw_priority']           = 'Maak DokuWiki editor de standaard editor';
$lang['preload_ckeditorjs']    = 'Laad het javascript van de CKGeditor van tevoren om in het vervolg het laden van de editor te versnellen.';
$lang['nofont_styling']        = 'Toon lettertypestijlen in de editor als plugin markup. Voor details, zie de ckgedit-pluginpagina van Dokuwiki.org.';
$lang['font_options']          = 'Lettertype opties verwijderen';
$lang['color_options']         = 'Kleur opties verwijderen';
$lang['alt_toolbar']           = 'Functies om de CKEditor tool te verwijderen';
$lang['mfiles']                = 'mfile-ondersteuning aanzetten';
$lang['extra_plugins']         = 'Kommagescheiden lijst van aanvullende CKeditor plugins die aan de werkbalk toegevoegd worden. Zie de <a href=\'https://www.dokuwiki.org/plugin:ckgedit:configuration#extra_plugins\'>Configuration Page</a> van de ckgedit plugin voor details';
$lang['dw_users']              = 'Groepsnaam van de gebruikers voor wie de standaard Dokuwiki-bewerkvenster weergegeven wordt, als <b>dw_priority</b> wordt ingeschakeld. Als er geen groepsnaam wordt opgegeven, dan krijgen alle gebruikers het originele DokuWiki-bewerkvenster als de optie <b>dw_priority</b> wordt ingeschakeld.';
$lang['allow_ckg_filebrowser'] = 'Selecteer welke bestandsbrowser(s) gebruikers kunnen gebruiken';
$lang['default_ckg_filebrowser'] = 'Selecteer welke bestandsbrowser standaard wordt gebruikt. Dit wordt overschreven als de geselecteerde bestandsbrowser niet is toegestaan.';
$lang['captcha_auth']          = 'ACL-niveau waarop de captcha wordt uitgeschakeld als de captcha plugin\'s <code>forusers</code> is ingeschakeld. De standaardwaarde is <code>ACL_CREATE</code>, dit betekent dat elke gebruiker met <code>ACL_EDIT</code> of lager een captcha krijgt, en met <code>ACL_CREATE</code> of hoger niet.';
$lang['htmlblock_ok']          = 'Als <code>HTML_BLOCK</code>-blokken worden gebruikt, dan moet of deze instelling of DokuWiki\'s <code>htmlok</code> optie worden ingeschakeld. Deze instelling geeft niet hetzelfde veiligheidsrisico als <code>htmlok</code>.  Desalniettemin moet deze instelling alleen gebruikt worden in een vertrouwde gebruikersomgeving, en niet in een open wiki.';
$lang['dblclk']                = 'Kies <code>uit</code> om de dubbelklik-functie uit te schakelen die de gebruiker alinea\'s laat bewerken in het standaard DokuWiki\'s bewerkvenster (zie:  <a href=\'https://www.dokuwiki.org/plugin:ckgedit#direct_access_to_dokuwiki_editor\'>direct_access_to_dokuwiki_editor</a>)';
$lang['preserve_enc']          = 'Behoud url-encodering in url\'s als DokuWiki\'s deaccent optie actief is';
$lang['gui']                   = 'Kies een CKEditor GUI';
$lang['rel_links']             = 'Activateer ondersteuning voor relatieve interne verwijzingen en afbeeldingsverwijzingen';

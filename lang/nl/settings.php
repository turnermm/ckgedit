<?php

/**
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 *
 * @author Gerrit <klapinklapin@gmail.com>
 * @author Coen Eisma <info@coeneisma.nl>
 * @author Mijndert <mijndert@mijndertstuij.nl>
 * @author Peter van Diest <peter.van.diest@xs4all.nl>
 */
$lang['gui']                   = 'Kies een CKEditor GUI';
$lang['_fbrowser']             = 'Ckgedit Bestandbrowser';
$lang['guest_media']           = 'Gast mag Media bestanden linken';
$lang['open_upload']           = 'Gast mag uploaden';
$lang['default_fb']            = 'Standaard bestandstoegang permissies. Als \'none\', dan wordt ACL niet toegepast.';
$lang['acl_del']               = 'Standaardinstelling (niet aangevinkt) staat gebruikers met upload rechten toe om mediabestanden te verwijderen; indien aangevinkt, dan heeft gebruiker de verwijder-permissie nodig om het bestand uit de map te verwijderen.';
$lang['openfb']                = 'Open bestandsbenadering. De gebruiker krijgt hierdoor toegang tot de volledige directory structuur, ongeacht de gebruikersrechten dit al dan niet toelaten. ACL is wel van toepassing op uploads.';
$lang['create_folder']         = 'Activeer knop Aanmaken map in bestandsverkenner (y/n)';
$lang['allow_ckg_filebrowser'] = 'Selecteer welke bestandsbrowser(s) gebruikers kunnen gebruiken';
$lang['default_ckg_filebrowser'] = 'Selecteer welke bestandsbrowser standaard wordt gebruikt. Dit wordt overschreven als de geselecteerde bestandsbrowser niet is toegestaan.';
$lang['nix_style']             = 'Voor Windows Servers (Vista en later).  Deze parameter maakt het mogelijk om data\media te benaderen met ckgedit\ckeditor\userfiles, indien links naar media en bestand succesvol aangemaakt zijn in userfiles';
$lang['winstyle']              = 'Gebruik een direct pad naar de mediamap in plaats van fckeditor/userfiles. Deze functie kopieert <br />fckeditor/userfiles/.htaccess.security  naar data/media/.htaccess. Zo niet, dan moet dit handmatig gedaan worden.';
$lang['complex_tables']        = 'Gebruik het complex tables algorithm, in tegenstelling tot het standaard ontleding algoritme. Dit zou een beter resultaat geven wanneer complexe rowspans en colspans gemengd worden.';
$lang['duplicate_notes']       = 'Zet deze optie op true (aanvinken) wanneer gebruikers meerdere voetnoten maken met dezelfde voettekst; deze optie is noodzakelijk om te voorkomen dat de voetnoten corrupt raken.';
$lang['_tools']                = 'Ckgedit Editor Tools';
$lang['guest_toolbar']         = 'Toon werkbalk aan Gast';
$lang['dw_edit_display']       = 'Welke gebruikers mogen de "DW Editor" knop gebruiken. Selecteer: "all" voor alle gebruikers; "admin" voor administrator en beheerders; "none" voor niemand. Standaardwaarde is "all".';
$lang['dw_edit_display_o_all'] = 'alle';
$lang['dw_edit_display_o_admin'] = 'beheerder';
$lang['dw_edit_display_o_none'] = 'geen';
$lang['smiley_as_text']        = 'Toon smileys als tekst in FCKeditor (wordt wel als afbeelding getoond in de browser)';
$lang['editor_bak']            = 'Sla backup op in meta/&lt;namespace&gt;.ckgedit';
$lang['dwedit_ns']             = 'Komma-gescheiden lijst van namespaces waarbij ckgedit automatisch terugschakelt naar de oorspronkelijke DokuWiki Editor.';
$lang['auth_ci']               = 'De gebruikers login is niet hoofdletter gevoelig, dus je kan inloggen met zowel GEBRUIKER als gebruiker';
$lang['smiley_hack']           = 'Reset de URL voor FCKeditor\'s smilies bij verhuizing naar nieuwe server. Dit wordt pagina per pagina uitgevoerd bij het openen en bewaren van de pagina.  Deze optie zou normaal uit moeten staan.';
$lang['other_lang']            = 'De standaardtaal voor de CKGEditor is de taal zoals ingesteld voor de browser. Je kunt echter een andere taal kiezen, onafhankelijk van de taal van het Dokuwiki-interface.';
$lang['direction']             = 'Zet de schrijf- en lees richting van de taal in CKeditor:  <b>nocheck</b>: geen wijziging van de standaard schrijfrichting in ckgedit;  <b>dokuwiki</b>:  gebruik de Dokuwiki taal schrijfrichting;  <b>ltr</b>: Links-naar-rechts; <b>rtl</b>: Rechts-naar-links.';
$lang['_editor']               = 'Ckgedit Editor Functionaliteiten';
$lang['scayt_auto']            = 'Stelt in of de SCAYT spellingcontrole, tijdens-het-typen, al actief is bij openen van het bewerkvenster. Standaard op <code>off</code>; de gebruiker kan de spellingscontrole inschakelen per pagina. Om de Scayt spellingscontrole compleet te verwijderen, kies <code>disable</code>. (Zie voor meer achtergrond <a href="https://www.dokuwiki.org/plugin:ckgedit:configuration#scayt_auto">ckgedit:configuration#scayt_auto</a>") ';
$lang['scayt_auto_o_on']       = 'aan';
$lang['scayt_auto_o_off']      = 'uit';
$lang['scayt_auto_o_disable']  = 'uitgeschakeld';
$lang['scayt_lang']            = 'Activeer de SCAYT standaard taalcode.';
$lang['nofont_styling']        = 'Toon lettertypestijlen in de editor als plugin markup. Voor details, zie de ckgedit-pluginpagina van Dokuwiki.org.';
$lang['font_options']          = 'Lettertype opties verwijderen';
$lang['color_options']         = 'Kleur opties verwijderen';
$lang['alt_toolbar']           = 'Functies om de CKEditor tool te verwijderen';
$lang['htmlblock_ok']          = 'Als <code>HTML_BLOCK</code>-blokken worden gebruikt, dan moet of deze instelling of DokuWiki\'s <code>htmlok</code> optie worden ingeschakeld. Deze instelling geeft niet hetzelfde veiligheidsrisico als <code>htmlok</code>.  Desalniettemin moet deze instelling alleen gebruikt worden in een vertrouwde gebruikersomgeving, en niet in een open wiki.';
$lang['_xtras']                = 'Gkgedit Extra\'s';
$lang['mfiles']                = 'mfile-ondersteuning aanzetten';
$lang['extra_plugins']         = 'Kommagescheiden lijst van aanvullende CKeditor plugins die aan de werkbalk toegevoegd worden. Zie de <a href=\'https://www.dokuwiki.org/plugin:ckgedit:configuration#extra_plugins\'>Configuration Page</a> van de ckgedit plugin voor details';
$lang['dblclk']                = 'Kies <code>uit</code> om de dubbelklik-functie uit te schakelen die de gebruiker alinea\'s laat bewerken in het standaard DokuWiki\'s bewerkvenster (zie:  <a href=\'https://www.dokuwiki.org/plugin:ckgedit#direct_access_to_dokuwiki_editor\'>direct_access_to_dokuwiki_editor</a>)';
$lang['preserve_enc']          = 'Behoud url-encodering in url\'s als DokuWiki\'s deaccent optie actief is';
$lang['rel_links']             = 'Activateer ondersteuning voor relatieve interne verwijzingen en afbeeldingsverwijzingen';
$lang['style_sheet']           = 'Gebruik een alternatief stijlbestand voor de Ckeditor bewerkvenster. Voor meer informatie zie de <b>CKEditor editor CSS tool</b>, onder <em>Aanvullende Plugins</em> op de <code>Beheer</code>-pagina. Of zie de ckgedit pluginpagina.';
$lang['imgpaste']              = 'Als de imgpaste plugin is geïnstalleerd, gebruik imgpaste naming system voor hernoemen van de opgeslagen afbeeldingen.';

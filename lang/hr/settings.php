<?php

/**
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 *
 * @author Davor Turkalj <turki.bsc@gmail.com>
 */
$lang['groups']                = 'Grupa koja može onemogućiti vrijeme zaključavanja (zastarjelo)';
$lang['fck_preview']           = 'FCK grupa za pretpregled';
$lang['guest_toolbar']         = 'Prikaži alatnu traku i gostima';
$lang['guest_media']           = 'Gosti mogu se povezati na medijske datoteke';
$lang['open_upload']           = 'Gosti mogu učitati';
$lang['default_fb']            = 'Podrazumijevani pristup datotekama. Ako je ništa, ACL se ne primjenjuje.';
$lang['openfb']                = 'Otvori pregled datoteka. Ovo omogućava korisnicima pristup cijeloj strukturi mapa, bez obzira na ovlaštenja. Ali ACL se ipak primjenjuje kod učitavanja.';
$lang['dw_edit_display']       = 'Kontrolira tko ima pristup "DW uređivač" gumbu. Odabiri su: "all" za sve korisnike; "admin" samo za administratore i upravitelje; "none" za nikoga. Inicijalno je "all".';
$lang['smiley_as_text']        = 'Prikazuj smješkiće kao tekst u CK uređivaču (u pregledniku će i dalje biti prikazani kao slike)';
$lang['editor_bak']            = 'Snimi sigurnosnu kopiju u meta/&lt;namespace&gt;.ckgedit';
$lang['create_folder']         = 'Omogući gumb za kreiranje mapa u pregledniku datoteka (y/n)';
$lang['dwedit_ns']             = 'Zarezom odvojena lista imenskih prostora i/ili stranica gdje se isključivo koristi klasičan DokuWiki uređivač; prihvaća djelomična poklapanja';
$lang['acl_del']               = 'Inicijalna postavka (neoznačeno) omogućava korisnicima s ovlastima učitavanja da brišu medijske datoteke; ako je označeno tada korisnik treba imati ovlasti brisanja da može brisati u mapi.';
$lang['auth_ci']               = 'Korisnička prijava je neosjetljiva na mala/VELIKA slova, što znači je svejedno da li se prijavite kao KORISNIK i korisnik';
$lang['nix_style']             = 'Za Windows poslužitelje (Vista i noviji). Ova postavka omogućava pristup data\media kroz ckgedit\CKeditor\userfiles, ako su uspješno napravljene poveznice prema media i file mapama u mapi userfiles.';
$lang['no_symlinks']           = 'Onemogući automatsko kreiranje simboličkih veza u ckgedit/userfiles.';
$lang['direction']             = 'Postavi smjer pisanja u CK uređivaču: <b>nocheck</b>: koristiti će se podrazumijevani smjer pisanja; <b>dokuwiki</b>: prema postavki jezika u Dokuwiki-u; <b>ltr</b>: S lijeva na desno; <b>rtl</b>: S desna na lijevo.';
$lang['scayt_auto']            = 'Automatski omogući SCAYT provjeru pravopisa. Inicijalno je "on" odnosno uključeno. Odaberite "off" da ga isključite';
$lang['scayt_lang']            = 'Postavite SCAYT jezik';
$lang['smiley_hack']           = 'Resetirati URL adrese za smješke u CK uređivaču pri micanju na novi server. To se izvodi za svaku stranicu pri svakom njenom učitavanju i snimanju. Normalno ova opcija treba biti isključena.';
$lang['complex_tables']        = 'Koristi algoritam za kompleksne tabele. Suprotno standardnoj obradi tabela, ovo treba dati bolje rezultate kada se koriste kompleksni oblici spojenih redova i kolona. Međutim zahtjeva više vremena za obradu.';
$lang['duplicate_notes']       = 'Postavi na "true" ako korisnici kreiraju više fusnota s istim tekstom; obavezno kako bi se izbjegla oštećenja fusnota. ';
$lang['winstyle']              = 'Koristi direktne staze do medijskih datoteka umjesto kroz fckeditor/userfiles. Ovo zahtjeva da fckeditor/userfiles/.htaccess.security bude kopiran u data/media i preimenovan u .htaccess';
$lang['other_lang']            = 'Vaš inicijalni jezik za CK uređivač je jezik postavljen u vašem pregledniku. Međutim vi možete ovdje odabrati drugi jezik; to je neovisno o jeziku postavljenom u Dokuwiki-u.';
$lang['dw_priority']           = 'Postavi klasičan dokuwiki uređivač kao podrazumijevani';
$lang['preload_ckeditorjs']    = 'Odmah učitati java skript kod CK uređivača da se ubrzaju naknadna učitavanja uređivača';
$lang['nofont_styling']        = 'Prikaži stilove znakovlja u uređivaču kao oznake dodataka. Pogledajte detalje o ckgedit dodatku na Dokuwiki.org.';
$lang['font_options']          = 'Ukloni opcije znakovlja.';
$lang['color_options']         = 'Ukloni opcije boje.';
$lang['alt_toolbar']           = 'Funkcije koje se uklanjaju iz alatne trake u CK uređivaču';
$lang['mfiles']                = 'Omogući mfile podršku';
$lang['extra_plugins']         = 'Zarezom odvojena lista dodatnih Ckeditor dodataka koji će biti dodani na alatnu traku. Pogledajte ckgedit <a href=\'https://www.dokuwiki.org/plugin:ckgedit:configuration#extra_plugins\'>uputu o podešavanju</a> za detalje';
$lang['dw_users']              = 'Ime grupe korisnika čiji je podrazumijevani Dokuwiki uređivač kada je odabran <b>dw_priority</b>. Ako nije definiran, tada će svima ugrađeni Dokuwiki uređivač biti podrazumijevani ako je odabran <b>dw_priority</b>.';
$lang['allow_ckg_filebrowser'] = 'Odaberite koji datoteka/media pretraživač korisnici mogu koristiti';
$lang['default_ckg_filebrowser'] = 'Odaberite koji datoteka/media pretraživač je podrazumijevani. Ovo će biti nadjačano ako odabrani pretraživač nije dopušten';
$lang['captcha_auth']          = 'ACL nivo na kojem je captcha isključen kada je opcija captcha dodatka <code>forusers</code> uključena. Podrazumijevana vrijednost je <code>ACL_CREATE</code>, što znači da svi korisnici sa  <code>ACL_EDIT</code> ili manje, će se prikazati captcha, za <code>ACL_CREATE</code> ili više neće.';
$lang['htmlblock_ok']          = 'Kada se koristi <code>HTML_BLOCK</code> ili ova postavka ili Dokuwiki <code>htmlok</code> postavka mora biti omogućena. Ona ne znači isti nivo sigurnosnog rizika kao <code>htmlok</code>. Unatoč tome ona ipak bi trebal biti korištena samo u sigurnim korisničkim okolinama, a ne na otvorenom wiki-u.';
$lang['dblclk']                = 'Postavi na <code>isključi</code> da se isključi mogućnost uređivanja odjeljka Dokuwiki urednikom dvoklikom (vidi: <a href=\'https://www.dokuwiki.org/plugin:ckgedit#direct_access_to_dokuwiki_editor\'>direct_access_to_dokuwiki_editor</a>)';
$lang['preserve_enc']          = 'Sačuvaj kodiranje URL veza kada je Dokuwiki deaccent opcija aktivna.';
$lang['gui']                   = 'Odaberi CKEditor GUI.';
$lang['rel_links']             = 'Aktiviraj podršku za relativne interne i slikovne poveznice';

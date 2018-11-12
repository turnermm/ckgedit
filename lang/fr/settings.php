<?php

/**
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 *
 * @author salabdou <salabdou@gmail.com>
 * @author TJ619 <rockandrollfever0@gmail.com>
 * @author Laurent Marquet <laurent.marquet@laposte.net>
 * @author Blacklord049
 * @author Schplurtz le Déboulonné <Schplurtz@laposte.net>
 */
$lang['groups']                = 'Groupe autorisé à désativer le verrou minuté (obsolète)';
$lang['fck_preview']           = 'Groupe de prévisualisation FCK';
$lang['guest_toolbar']         = 'Afficher la barre d\'outil pour les invités';
$lang['guest_media']           = 'Les invités peuvent faire des liens sur les fichiers medias';
$lang['open_upload']           = 'Les invités peuvent uploader';
$lang['default_fb']            = 'Accès à la navigation des fichiers par défaut. Avec none, ACL ne s\'applique pas.';
$lang['openfb']                = 'Ouvre la navigation des fichiers. Cela donne accès à l\'utilisateur à toute la structure de répertoires, qu\'il/elle ait les permissions ou pas. ACL s\'applique toujours pour l\'upload.';
$lang['dw_edit_display']       = 'Contrôle quels utilisateurs ont accès au bouton "Éditeur DW". Choix: "all" pour tous les utilisateurs; "admin" pour les admin et gestionnaires seulement; "none" pour personne. "all" par défaut.';
$lang['smiley_as_text']        = 'Affiche les émoticones comme du texte dans CKeditor (sera toujours affiché comme une image dans le navigateur)';
$lang['editor_bak']            = 'Sauve le backup sur meta/&lt;namespace&gt;.ckgedit';
$lang['create_folder']         = 'Activer le bouton de création de dossier dans le navigateur de fichier (o/n)';
$lang['dwedit_ns']             = 'Liste des namespaces, séparés par des virgules, et/ou des pages où ckgedit bascule automatiquement sur l\'éditeur natif de DW; Accepte les correspondances partielles.';
$lang['acl_del']               = 'Par défault (case non cochée) autorise les utilisateurs avec "upload permission" à supprimer les fichiers de media; Si la case est cochée, alors l\'utilisateur doit avoir la permission "delete" pour supprimer dans le répertoire.';
$lang['auth_ci']               = 'L\'identifiant de l\'utilisateur est non-sensible à la casse, ce qui fait que l\'on peut s\'identifier avec UTILISATEUR et utilisateur';
$lang['nix_style']             = 'Pour les serveurs Windows Servers (Vista et suivants). Ce paramètre rend possible l\'accès à "data\media" à travers "ckgedit\CKeditor\userfiles", si les liens aux medias et fichiers ont été créés avec succès dans "userfiles"';
$lang['no_symlinks']           = 'Désactive la création automatique des liens symboliques dans ckgedit/userfiles';
$lang['direction']             = 'Définit la direction de langue dans CKeditor:  <b>nocheck</b>: ckgedit ne fera aucun changement au paramètre de direction par défaut; <b>dokuwiki</b>: le paramètre courant de Dokuwiki de direction de langue; <b>ltr</b>: Gauche-à-droite; <b>rtl</b>: Droite-à-gauche.';
$lang['scayt_auto']            = 'Active automatiquement le vérificateur d\'orthographe SCAYT. Par défaut sur "on". Pour le désactiver, sélectionner "off"';
$lang['scayt_lang']            = 'Définir le langage par défaut de SCAYT';
$lang['smiley_hack']           = 'Mettre à zéro l\'URL pour les émoticones CKeditor\'s lors d\'un changement de serveur. C\'est fait, page par page, quand la page est chargée pour édition et sauveagrdée. Cette option devrait normalement être sur "off".';
$lang['complex_tables']        = 'Utiliser l\'algorithme des tableaux complexes. À l\'opposé de la gestion standard des tableaux, cela donnera un meilleur résultat lors d\'arrangements complexes de "rowspans" et "colspans", mais cela demande beaucoup plus de temps de traitement.';
$lang['duplicate_notes']       = 'Choisir "true" si les utilisateurs créent de multiples notes de bas de page avec le même texte; Requis pour éviter la corruption des notes.';
$lang['winstyle']              = 'Utiliser le chemin direct au répertoire des medias à la place de "fckeditor/userfiles". Cela requiert de copier le fichier "fckeditor/userfiles/.htaccess.security" dans "data/media" et de le renommer ".htaccess".';
$lang['other_lang']            = 'Votre langue par défaut pour CKEditor est la langue par défaut du navigateur. Vous pouvez, cependant, choisir une autre langue ici; C\'est indépendant de la langue d\'interface de Dokuwiki.';
$lang['dw_priority']           = 'Définir l\'éditeur DokuWiki comme éditeur par défaut';
$lang['preload_ckeditorjs']    = 'Pré-charger le fichier javascript de CKeditor pour accélérer le chargement ultérieur de l\'éditeur';
$lang['nofont_styling']        = 'Affiche les styles de police dans l\'éditeur comme "plugin markup". Voir la page de plugin de CKGedit plugin sur Dokuwiki.org pour les détails.';
$lang['font_options']          = 'Retire les options de police d\'écriture';
$lang['color_options']         = 'Retire les options de colorations';
$lang['alt_toolbar']           = 'Fonctions à retirer de la barre d\'outils CKEditor';
$lang['mfiles']                = 'Activer la gestion des \'mfiles\'';
$lang['extra_plugins']         = 'Liste des extensions (séparées par des virgules) à ajouter dans la barre d\'outils de CKEditor. Voir la page à propos des plugins CKGEdit pour plus de détails.';
$lang['dw_users']              = 'Nom du groupe d\'utilisateurs pour lesquels l\'éditeur par défaut est celui de DokuWiki quand <b>dw_priority</b> est sélectionné. Si non défini, tous les utilisateurs utiliseront l\'éditeur natif lorsque <b>dw_priority</b> est coché.';
$lang['allow_ckg_filebrowser'] = 'Sélectionnez le ou les navigateurs de fichiers/médias que les utilisateurs peuvent utiliser';
$lang['default_ckg_filebrowser'] = 'Sélectionnez quel navigateur de fichier/média est le navigateur par défaut. Ceci sera annulé si le navigateur sélectionné n\'est pas autorisé';
$lang['captcha_auth']          = 'Niveau d\'ACL à partir duquel le captcha est désactivé lorsque l\'option <code>forusers</code> du greffon <a href="https://www.dokuwiki.org/plugin:captcha">captcha</a> est activée. Le défaut est <code>ACL_CREATE</code>, ce qui signifie que les utilisateurs n\'ayant que <code>ACL_EDIT</code> ou moins auront le captcha, et ceux qui ont <code>ACL_CREATE</code> ou plus ne l\'auront pas.';
$lang['htmlblock_ok']          = 'Lors de l\'utilisation de <code>HTML_BLOCK</code>, il faut activer soit ce réglage, soit <code><a href="https://www.dokuwiki.org/fr:config:htmlok">htmlok</a></code> de DokuWiki.Cette option ci ne pose pas les mêmes risques de sécurité que <code>htmlok</code>. Néanmoins, il ne faudrait l\'utiliser que dans un environnement de confiance et pas dans un wiki ouvert.';
$lang['dblclk']                = 'Réglez sur <code>off</code> pour désactiver la fonctionnalité d\'édition sur double clic dans l\'éditeur DokuWiki (voir <a href=\'https://www.dokuwiki.org/plugin:ckgedit#direct_access_to_dokuwiki_editor\'>direct_access_to_dokuwiki_editor</a>, en anglais).';
$lang['preserve_enc']          = 'Conservez le codage d’URL dans les URL lorsque l’option dokuwiki deaccent est active.';
$lang['gui']                   = 'Sélectionnez CKEditor GUI.';
$lang['rel_links']             = 'Activer la prise en charge des liens relatifs internes et d\'image.';

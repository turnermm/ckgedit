<?php

/**
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 *
 * @author Olaf Reitmaier <olafrv@gmail.com>
 */
$lang['groups']                = 'Grupo al que se le permite deshabilitar el temporizador de bloqueos (obsoleto)';
$lang['fck_preview']           = 'Previsualizar Grupo FCK';
$lang['guest_toolbar']         = 'Mostrar Barra de Herramientas a los Invitados';
$lang['guest_media']           = 'Pueden los Invitados Vincular Archivos Multimedia';
$lang['open_upload']           = 'Pueden los Invitados Cargar';
$lang['default_fb']            = 'Acceso de exploración de archivos Predeterminado. Con ninguno (none), las listas de control de acceso (acl) no aplican.';
$lang['openfb']                = 'Abrir Explorador de Archivos. Otorga al usuario acceso a la estructura completa de directorios, sin importar si tiene o no permisos. Las listas de control de ';
$lang['dw_edit_display']       = 'Controla cuáles usuarios tienen acceso al botón "Editor DW". Opciones "all" para todos los usuarios; "admin" para admin y administradores solamente; "none" para ninguno. Por defecto en "all".';
$lang['smiley_as_text']        = 'Mostrar emoticones como texto en el Editor CK (se mostrarán como imágenes en el navegador)';
$lang['editor_bak']            = 'Guardar respaldo en meta/&lt;namespace&gt;.ckgedit';
$lang['create_folder']         = 'Habilitar botón de creación de carpetas en explorador de archivos (y/n)';
$lang['dwedit_ns']             = 'Lista separada de espacios de nombres y páginas donde ckgedit automáticamente cambie hacia el Editor nativo de DokuWiki; aceptar coincidencias parciales.';
$lang['acl_del']               = 'Predeterminado (no chequeado) permite a los usuarios con permite de borrar archivos ';
$lang['auth_ci']               = 'El nombre de usuario (login id) es sensible a mayúsculas/minúsculas, es decir, usted puede iniciar sesión con ambos USUARIO y usuario';
$lang['nix_style']             = 'Para servidores Windows (Vista y posteriores). Este parámetro hace posible acceder data\media a través de ckgedit\CKeditor\userfiles, si los enlaces a media y file han sido creados en userfiles';
$lang['no_symlinks']           = 'Deshabiltiar la creación automática de enlaces simbólicos en ckgedit/userfiles.';
$lang['direction']             = 'Define la dirección del lenguaje en el editor CK: <b>nocheck</b>: ckgedit no hará cambios en el sentido por defecto; <b>dokuwiki</b>: la dirección actual del lenguaje en Dokuwiki; <b>ltr</b>: Izquierda-a-derecha ; <b>rtl</b>: Derecha-a-izquierda.';
$lang['scayt_auto']            = 'Automáticamente habilitar el corrector ortográfico SCAYT. Por defecto es "on". Para deshabilitarlo seleccione "off".';
$lang['scayt_lang']            = 'Definir el lenguaje por defecto de SCAYT';
$lang['smiley_hack']           = 'Reiniciar la URL de los emoticones del editor CK cuando se está moviendo a un nuevo servidor. Esto se hace página por página cuando se carga para editarla y se guarda.  Esta opción debería normalmente estar apagada.';
$lang['complex_tables']        = 'Usar el algoritmo de tablas complejas. Opuesto al estándar de interpretación de tablas, este debería dar mejores resultados cuando se mezclan arreglos complejos de rowspan y colspans.  Per ligeramente con mayor tiempo de procesamiento.';
$lang['duplicate_notes']       = 'Defina esto en true si los usuarios crean múltiples notas al pie con el mismo texto; requerido para prevenir que las notas al pie se corrompan.';
$lang['winstyle']              = 'Utilizar la ruta directa al directorio media en lugar de fckeditor/userfiles. Esta función copia <br/>fckeditor/userfiles/.htaccess.security a data/media/.htaccess; si no, esto debe hacerse de forma manual.';
$lang['other_lang']            = 'Por defecto, el idioma predeterminado del editor CK es el idioma del navegador. Sin embargo, usted puede seleccionar otro idioma aquí, esto es independiente del lenguaje de la interfaz de Dokuwiki';
$lang['dw_priority']           = 'Hacer Dokuwiki el editor predeterminado: no funciona en farms';
$lang['preload_ckeditorjs']    = 'Precargar el javascript del editor CK para acelerar las subsecuentes cargas del editor';
$lang['nofont_styling']        = 'Mostrar los estilos de fuentes en el editor como etiquetas. Véa la página del plugin ckgedit en Dokuwiki.org para más detalles.';
$lang['font_options']          = 'Deshabilitar las opciones de fuentes.';
$lang['color_options']         = 'Deshabilitar las opciones de Color.';
$lang['alt_toolbar']           = 'Funciones a ocultar en la barra de herramientas del Editor CK.<br /><br /> Cualquier función puede ser ocultada incluyéndola como en una lista separada por comas:<br /><br />Bold, Italic, Underline, Strike, Subscript, Superscript, RemoveFormat, Find, Replace, SelectAll, Scayt, Image, Table, Tags, Link, Unlink, Format, Styles,TextColor, BGColor, NumberedList, BulletedList, Cut, Copy, Paste, PasteText, PasteFromWord, Undo, Redo, Source, Maximize, About.';
$lang['mfiles']                = 'Habilita el soporte mfile';
$lang['extra_plugins']         = 'Listado separado por comas de plugins adicionales del editor CK que serán añadidos a la barra de herramientas. Véa los plugins de ckgedit <a href=\'https://www.dokuwiki.org/plugin:ckgedit:configuration#extra_plugins\'>config page</a> para más detalles.';
$lang['dw_users']              = 'Nombre del grupo de usuarios para quienes el editor por defecto es el editor de Dokuwiki cuando <b>dw_priority</b> está seleccionado. Si no está definido, entonces todos los usuarios usan el editor nativo de Dokuwiki cuando <b>dw_priority</b> esté seleccionado.';

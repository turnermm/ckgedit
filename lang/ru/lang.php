<?php

/**
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 *
 * @author Nikita <obraztsov568@gmail.com>
 * @author Ianka Kryukov <IanisKr@mail.ru>
 * @author serg <sergey_art82@inbox.ru>
 * @author Artem Trutko <trutko@facebook.com>
 * @author Evgeniy Bekhterev <jbe@mail.ru>
 */
$lang['btn_dw_edit']           = 'Переключить в DokuWiki Редактор';
$lang['dw_btn_fck_preview']    = 'CKG предпросмотр';
$lang['dw_btn_lang']           = 'Язык';
$lang['title_dw_delete']       = 'Удалить страницу';
$lang['title_dw_edit']         = 'Сохранить текущий текст, выйти и переключить редактор с CKEditor на обычный DokuWiki Editor. (Поменяется при следующем редактировании.)';
$lang['dw_btn_revert']         = 'Вернуться';
$lang['title_dw_revert']       = 'Вернуться к предыдущей резервной копии';
$lang['title_dw_lang']         = 'Выбрать язык';
$lang['title_dw_cancel']       = 'Выйти из редактроа';
$lang['btn_fck_edit']          = 'Переключить в CKG Редактор';
$lang['confirm_delete']        = 'Уверены что хотите удалить страницу?';
$lang['confirm_preview']       = 'Вся несохраненная работа будет потерянв';
$lang['editor_height']         = 'Высота редактора';
$lang['editor_height_title']   = 'Изменение размера редактора после повторной загрузки';
$lang['dw_btn_backup']         = 'Резервная копия';
$lang['title_dw_backup']       = 'Окно резервного копирования и возобновления блокировки';
$lang['backup_empty']          = 'Буфер резервной копии выглядит пустым. Продолжить?';
$lang['btn_draft']             = 'Загрузить черновик';
$lang['title_draft']           = 'Обзор, Показать, Редактировать черновик';
$lang['btn_exit_draft']        = 'Выйти из черновика';
$lang['title_exit_draft']      = 'Возврат к текущему документу';
$lang['draft_msg']             = 'За этим документом закреплен файл черновика. Кнопка черновик осуществляет переключение между этим документом и черновиком. Вы можете редактировать и сохранять каждую из них.';
$lang['whats_this']            = 'Что это?';
$lang['complex_tables']        = 'Включить Комплексные Таблицы';
$lang['minor_changes']         = 'Небольшое изменение';
$lang['discard_edits']         = 'Для сохранения изменений нажмите ОК; для отмены нажмите Отмена';
$lang['dw_btn_styling']        = 'Редактировать Шрифты';
$lang['title_styling']         = 'Открыть с помощью стилей шрифта, как показано в разметки';
$lang['js']['font_err_1']      = 'Стили шрифтов нельзя включить в ссылки. Нажмите OK чтобы принять следующие корректировки: ';
$lang['js']['font_err_2']      = 'Для пересмотра, введите полную разметку ссылок Dokuwiki ниже, включая скобки. Чтобы вернуться в редактор, нажмите кнопку Отмена.';
$lang['js']['font_err_throw']  = 'Ошибка форматирования шрифта';
$lang['js']['dwp_save_err']    = 'Невозможно сохранить изменения в:';
$lang['js']['dwp_updated']     = 'Приоритет редактора обновлен до:';
$lang['js']['dwp_not_sel']     = 'Приоритет редактора не выбран: он будет определяться настройкой конфигурации группы dw_users';
$lang['js']['mediamgr_notice'] = 'Используйте диалоговое окно "ссылка" для вставки';
$lang['js']['font_conflict']   = 'Парсер обнаружил один или несколько конфликтов ссылок-шрифтов. Нажав кнопку ОК, вы можете вернуться в редактор и удалить стили шрифтов. Для получения дополнительной информации см.: https://www.dokuwiki.org/plugin:ckgedit:font_styling#conflicts_with_dokuwiki_links';
$lang['js']['ckg_paste_restart'] = 'При перезагрузке редактора будет включена дополнительная поддержка вставки';
$lang['js']['on']              = 'вкл.';
$lang['js']['off']             = 'выкл.';
$lang['js']['broken_image_1']  = 'Используйте плагин imagePaste с Dokuwiki Mediamanager или попробуйте инструмент MS Word Paste.';
$lang['js']['broken_image_2']  = 'Ctrl-v изображения с необработанными данными более 2,5М могут висеть. Это изображение является:';
$lang['mediamgr_imgonly']      = 'Используйте Image Dialog только для изображений,  Link Dialog-для других носителей. Этот файл является:';
$lang['uprofile_title']        = 'Выберите редактор по умолчанию';
$lang['btn_val_dw_fb']         = 'DW файловый браузер';
$lang['btn_val_ckg_fb']        = 'CKG файловый браузер';
$lang['btn_title_dw_fb']       = 'Сохраните и закройте редактор, а затем переключитесь на DW файловый браузер ';
$lang['btn_title_ckg_fb']      = 'Сохраните и закройте редактор и переключитесь на файловый браузер CKG';
$lang['formatdel']             = 'Разметка, удаленная из заголовков: не поддерживается Dokuwiki';
$lang['fontdel']               = 'Разметка шрифта удалена из ссылок: не поддерживается Dokuwiki';
$lang['ckgcke_conflict']       = 'Обнаружена копия ckgedit. Либо ckgedit, либо ckgedit должны быть отключены.';
$lang['ws_cantcopy']           = 'Для установки winstyle: не удается скопировать в';
$lang['ws_copiedhtaccess']     = 'Для winstyle установки, скопированные с включенной безопасностью .htaccess в data/media
См. ckgedit/fckeditor/userfiles/.htacess.security';
$lang['userfiles_perm']        = 'Пожалуйста, проверьте разрешения; ckgedit не может получить доступ';
$lang['sym_not created_1']     = 'Невозможно создать';
$lang['sym_not created_2']     = 'Не удается создать символические ссылки для filebrowser: не удается получить доступ:';
$lang['sym_not created_3']     = 'Произошла ошибка при попытке создать символические ссылки в';
$lang['syms_created']          = 'В каталоге userfiles были созданы следующие ссылки:';
$lang['dblclk']                = '<b>Новая функция:</b> дважды щелкните окно браузера, чтобы открыть редактор DW для редактирования раздела при наведении курсора. <b>См.: </b><a href=\'https://www.dokuwiki.org/plugin:ckgedit#direct_access_to_dokuwiki_editor\'>direct_access_to_dokuwiki_editor</a>';
$lang['dblclk_reminder']       = '<b>Напоминание</b>';
$lang['ckg_img_paste']         = 'Включить дополнительную поддержку вставки изображений';
$lang['ckg_img_paste_title']   = 'Во избежание двойной вставки, или для включения вставки';
$lang['on']                    = 'вкл.';
$lang['off']                   = 'выкл.';
$lang['broken_image']          = 'Используйте плагин imagePaste с Dokuwiki Mediamanager или попробуйте инструмент MS Word Paste. Необработанные данные Ctrl-v изображений более 2,5М могут висеть. Это изображение является:';

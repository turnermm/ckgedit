<?php

/**
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 *
 * @author RainSlide <RainSlide@outlook.com>
 * @author chenb <chenb84@foxmail.com>
 * @author 2576562185 <2576562185@qq.com>
 */
$lang['btn_dw_edit']           = 'DW 原生编辑器';
$lang['dw_btn_fck_preview']    = 'CKG 预览';
$lang['dw_btn_lang']           = '语言';
$lang['title_dw_delete']       = '删除页面';
$lang['title_dw_edit']         = '保存并退出，并切换回原生DokuWiki编辑器';
$lang['dw_btn_revert']         = '回滚';
$lang['title_dw_revert']       = '回滚到上次备份';
$lang['title_dw_lang']         = '选择需拼写检查的语言';
$lang['title_dw_cancel']       = '退出编辑器';
$lang['btn_fck_edit']          = 'CKG 可视编辑器';
$lang['confirm_delete']        = '您确定要删除这个页面吗？';
$lang['confirm_preview']       = '未经存储的改动将会丢失。';
$lang['editor_height']         = '编辑器高度';
$lang['editor_height_title']   = '打开时重置编辑器大小';
$lang['dw_btn_backup']         = '备份';
$lang['title_dw_backup']       = "备份编辑器窗口和更新锁定";
$lang['backup_empty']          = "备份缓冲区似乎为空。 你想继续吗？";
$lang['btn_draft']             = '获取草稿';
$lang['title_draft']           = '查看、展示、编辑草稿';
$lang['btn_exit_draft']        = '退出草稿';
$lang['title_exit_draft']      = '返回到当前文档';
$lang['draft_msg']             = '此文档有一份草稿。“草稿”按钮可在文档与草稿间来回切换。你可以独立地编辑、保存它们。';
$lang['whats_this']            = '这是什么？';
$lang['complex_tables']        = '启用复杂型表格';
$lang['minor_changes']         = '小修改';
$lang['discard_edits']         = '点“确定”保存，点“取消”撤销修改';
$lang['dw_btn_styling']        = '修改字体';
$lang['title_styling']         = '以显示为Markup标记的字体样式打开';
$lang['js']['font_err_1']      = '字体样式不能包含在链接中。 单击确定以接受以下更正：';
$lang['js']['font_err_2']      = '要进行修订，请在下面输入完整的Dokuwiki链接标记，包括方括号。 要返回编辑器，请单击“取消”。';
$lang['js']['font_err_throw']  = '字体格式错误';
$lang['js']['dwp_save_err']    = '无法将更改保存到：';
$lang['js']['dwp_updated']     = '编辑器优先级已更新为：';
$lang['js']['dwp_not_sel']     = '未选择编辑器优先级：它将由dw_users组配置设置确定';
$lang['js']['mediamgr_notice'] = '使用链接对话框插入';
$lang['js']['font_conflict']   = "解析器发现一个或多个链接字体冲突。 通过单击“确定”，您可以返回到编辑器并删除字体样式。 有关更多信息，请参见：https://www.dokuwiki.org/plugin:ckgedit:font_styling#conflicts_with_dokuwiki_links";
$lang['mediamgr_imgonly']      = '“图像对话框”仅用于图像，“链接对话框”用于其他媒体。 该文件是：';
$lang['uprofile_title']        = '选择您的默认编辑器';
$lang['btn_val_dw_fb']         = 'DW 文件浏览器';
$lang['btn_val_ckg_fb']        = 'CKG 文件浏览器';
$lang['btn_title_dw_fb']       = '保存并关闭当前编辑器并切换至 DW 文件浏览器';
$lang['btn_title_ckg_fb']      = '保存并关闭当前编辑器并切换至 CKG 文件浏览器';
$lang['formatdel']             = '从标题中删除Markup标记：Dokuwiki不支持';
$lang["fontdel"]               ='从链接中删除了字体Markup标记：Dokuwiki不支持';
$lang["ws_cantcopy"]           ='对于winstyle设置：无法复制到';
$lang["ws_copiedhtaccess"]     ='对于winstyle设置，复制 security-enabled .htaccess 到 data/media' ."\n" .'参见 ckgedit/fckeditor/userfiles/.htacess.security';
$lang["userfiles_perm"]        ='请检查权限； ckgedit无法访问';
$lang['sym_not created_1']     = '无法创建';
$lang["sym_not created_2"]     = '无法为文件浏览器创建符号链接：无法访问：';
$lang["sym_not created_3"]     = '尝试在其中创建符号链接时发生错误';
$lang["syms_created"]          = '在userfiles目录中创建了以下链接：';
$lang['dblclk']                ="<b>新功能:</b> 双击浏览器窗口以打开DW编辑器，以便在光标处进行章节编辑。 <b>参见: </b><a href='https://www.dokuwiki.org/plugin:ckgedit#direct_access_to_dokuwiki_editor'>direct_access_to_dokuwiki_editor</a>. ";
$lang['dblclk_reminder']       = "<b>提醒</b> ";
$lang['ckg_img_paste']         = '启用辅助图像粘贴支持';
$lang['ckg_img_paste_title']   = '禁用以防止重复粘贴，或启用以允许粘贴';
$lang['js']['ckg_paste_restart'] = '重新加载编辑器时，将允许补充粘贴支持';
$lang['on']                    = '启用';
$lang['off']                   = '禁用';
$lang['js']['on']              = '启用';
$lang['js']['off']             = '禁用';
$lang['broken_image']          = "将imagePaste插件与Dokuwiki Mediamanager一起使用，或尝试使用MS Word Paste Tool。 超过2.5M的Ctrl-v图像原始数据可能会挂起。 该图像是：" ; 
$lang['js']['broken_image_1']  = "将imagePaste插件与Dokuwiki Mediamanager一起使用，或尝试使用MS Word Paste Tool。";
$lang['js']['broken_image_2']  =  "超过2.5M的Ctrl-v图像原始数据可能会挂起。 该图像是： " ; 
$lang['menu']                  = 'CKEditor编辑器CSS工具'; 
$lang['default_stylesheet']    = '为当前模板创建样式表';
$lang['alt_stylesheet']        = '为另一个模板创建样式表'; 
$lang['style_sheet']           = '创建样式表';
$lang['style_sheet_msg']       = '为当前模板创建样式表：';
$lang['alt_style_sheet_msg']   = '为以下对象创建样式表：';
$lang['checkbox']              = '复制到ckeditor/css';
$lang['stylesheet_oinfo']      = '信息';
$lang['stylesheet_cinfo']      = '关闭信息';
$lang['js']['stylesheet_oinfo'] = '信息';
$lang['js']['stylesheet_cinfo'] = '关闭信息';
$lang['js']['lock_msg']         = "您编辑此页面的锁将在一分钟后到期\n";
$lang['js']['willexpire']       = '您编辑此页面的锁将在一分钟后到期\n 为避免冲突，请使用备份按钮重置锁定计时器。';

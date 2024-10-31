<?php

/**
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 *
 * @author 小命Leaflet <2532846822@qq.com>
 * @author 切 <3537509263@qq.com>
 */
$lang['fck_preview']           = 'FCK 预览组';
$lang['guest_toolbar']         = '向访客显示工具栏';
$lang['guest_media']           = '访客可以链接到媒体文件';
$lang['open_upload']           = '访客可以上传文件';
$lang['default_fb']            = '默认文件浏览访问权限。如果选择“无”，则访问控制列表（ACL）管理器不适用';
$lang['openfb']                = 'Open the file to browse. This gives the user access to the entire directory structure, whether the user has permissions or not. The ACL still applies to uploads.';
$lang['dw_edit_display']       = 'Control which users can access the "DW Edit" button. Choice: "All" for all users; "Administrator" applies only to administrators and managers; "None" for anyone. The default is "All".';
$lang['dw_edit_display_o_all'] = '全部';
$lang['dw_edit_display_o_admin'] = 'admin';
$lang['dw_edit_display_o_none'] = '无';
$lang['smiley_as_text']        = 'Display emoticons as text in CKeditor (It will still appear as an image in the browser.)';
$lang['editor_bak']            = '将备份保存到 meta/<namespace>.ckgedit';
$lang['create_folder']         = '在文件浏览器中启用文件夹创建按钮（是/否）';
$lang['dwedit_ns']             = '逗号分隔的命名空间和/或页面列表，ckgedit 会自动切换到原生 DokuWiki 编辑器；接受部分匹配。';
$lang['acl_del']               = '默认情况下（未勾选），允许具有上传权限的用户删除媒体文件；如果勾选该选项，则用户需要具备删除权限才能从文件夹中删除文件';
$lang['auth_ci']               = '用户登录 ID 不区分大小写，即您可以使用 USER 或 user 登录';
$lang['nix_style']             = '针对Windows服务器（Vista及更高版本）。此设置使得可以通过ckgedit\CKeditor\userfiles访问data\media，前提是已成功在userfiles中创建了指向媒体文件和文件的链接';
$lang['direction']             = '在CKeditor中设置语言方向：<b>nocheck</b>：ckgedit不会更改默认方向设置；<b>dokuwiki</b>：当前Dokuwiki的语言方向；<b>ltr</b>：从左到右；<b>rtl</b>：从右到左';
$lang['scayt_auto']            = '设置Scayt即时拼写检查器在启动时是否启用。默认值为<code>关闭</code>；用户可以在每个页面上单独重新启用拼写检查。要完全移除Scayt拼写检查器，请选择<code>禁用</code>。（请参见<a href="https://www.dokuwiki.org/plugin:ckgedit:configuration#scayt_auto">ckgedit:configuration#scayt_auto</a>）';
$lang['scayt_auto_o_on']       = '开启';
$lang['scayt_auto_o_off']      = '关闭';
$lang['scayt_auto_o_disable']  = '禁用';
$lang['scayt_lang']            = '设置SCAYT默认语言';
$lang['smiley_hack']           = '重置CKeditor表情符号的URL，当移动到新服务器时。此操作在编辑和保存页面时逐页进行。此选项通常应保持关闭状态。';
$lang['complex_tables']        = '使用复杂表格算法。与标准表格解析相比，这应该在混合使用行合并和列合并的复杂布局时提供更好的结果，但处理时间会稍微增加。';
$lang['duplicate_notes']       = '如果用户创建多个相同的脚注文本，请将此设置为true；这是防止脚注被损坏所必需的。';
$lang['winstyle']              = '使用直接路径访问媒体目录，而不是 fckeditor/userfiles。此功能会将 `fckeditor/userfiles/.htaccess.security` 复制到 `data/media/.htaccess`；如果没有完成此操作，则需要手动执行。';
$lang['other_lang']            = 'CKEditor 的默认语言是您浏览器设置的语言。不过，您可以在这里选择其他语言；这与 Dokuwiki 界面语言无关。';
$lang['nofont_styling']        = '在编辑器中以插件标记的形式显示字体样式。有关详细信息，请参见 Dokuwiki.org 上的 ckgedit 插件页面。';
$lang['font_options']          = '移除字体选项';
$lang['color_options']         = '移除颜色选项';
$lang['alt_toolbar']           = '从 CKEditor 工具栏中移除的功能。<br /><br />任何其他功能可以通过在文本框中以逗号分隔的列表形式包含来移除：<br /><br />粗体、斜体、下划线、删除线、下标、上标、清除格式、查找、替换、全选、Scayt、图像、表格、标签、链接、取消链接、格式、样式、文本颜色、背景颜色、编号列表、项目符号列表、剪切、复制、粘贴、粘贴文本、从 Word 粘贴、撤销、重做、源代码、最大化、关于。';
$lang['mfiles']                = '启用 mfile 支持';
$lang['extra_plugins']         = '以逗号分隔的额外 CKEditor 插件列表，将添加到工具栏中。有关详细信息，请参阅 ckgedit 插件的 [配置页面](https://www.dokuwiki.org/plugin:ckgedit:configuration#extra_plugins)';
$lang['allow_ckg_filebrowser'] = '选择用户可以使用哪些文件/媒体浏览器';
$lang['default_ckg_filebrowser'] = '选择默认的文件/媒体浏览器。如果所选浏览器不被允许，此选项将被覆盖。';
$lang['htmlblock_ok']          = '在使用 `<code>HTML_BLOCK</code>` 时，必须启用此设置或 Dokuwiki 的 `<code>htmlok</code>` 选项。虽然它的安全风险不如 `<code>htmlok</code>` 高，但仍应仅在可信的用户环境中使用，而不应在开放的维基中使用。';
$lang['dblclk']                = '设置为 `<code>off</code>` 可禁用双击功能，从而禁用使用 Dokuwiki 编辑器进行节编辑的功能（参见： <a href=\'https://www.dokuwiki.org/plugin:ckgedit#direct_access_to_dokuwiki_editor\'>direct_access_to_dokuwiki_editor</a>）';
$lang['preserve_enc']          = '在 Dokuwiki 的去重音选项启用时，保留 URLs 中的 URL 编码。';
$lang['gui']                   = '选择 CKEditor 的GUI界面';
$lang['rel_links']             = '激活对相对内部链接和图像链接的支持';
$lang['style_sheet']           = '在 CKeditor 编辑窗口使用备用样式表。有关更多信息，请参阅 <b>CKEditor 编辑器 CSS 工具</b>，该工具位于 <em>附加插件</em> 部分的 <code>管理员</code> 页面上。或者，请查看 ckgedit 插件页面。';
$lang['imgpaste']              = '如果安装了 imgpaste 插件，请使用 imgpaste 命名系统来命名您保存的图像。';

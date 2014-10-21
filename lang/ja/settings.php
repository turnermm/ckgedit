<?php

/**
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * 
 * @author Nobuyuki Fukuyori <self@spumoni.org>
 */
$lang['groups']                = 'ロックの期限を無効化できるグループ（廃止予定）';
$lang['middot']                = '&amp;nbsp; に &amp;middot; を使うグループのカンマで区切ったリスト';
$lang['big_files']             = '巨大なファイルを安全に編集する';
$lang['big_file_sz']           = '巨大なファイルのサイズ（bytes）';
$lang['big_file_tm']           = '巨大なファイルを処理する際のタイムアウト（秒）';
$lang['fck_preview']           = 'FCK プレビューグループ';
$lang['guest_toolbar']         = 'ゲストに対してツールバーを表示';
$lang['guest_media']           = 'ゲストはメディアファイルにリンク可能';
$lang['open_upload']           = 'ゲストはメディアファイルをアップロード可能';
$lang['default_fb']            = 'ファイルブラウザーのデフォルトのアクセス権。noneの場合、ACLは適用されません。';
$lang['openfb']                = 'ファイルブラウザーをオープンにする。これによってユーザーはパーミッションに関係なくすべてのディレクトリ構造にアクセスできます。ただしアップロードにはACLが適用されます。';
$lang['dw_edit_display']       = '"テキストモード"ボタンを使用できるユーザーを制限する。<b>all</b>: すべてのユーザー、<b>admin</b>: adminとmanagerのみ、<b>none</b>: 誰も使用できない。デフォルトは<b>all</b>。';
$lang['smiley_as_text']        = 'CKeditorで顔文字を文字列で表示（この設定を有効にしても表示の際は画像として表示されます）';
$lang['editor_bak']            = 'meta/&lt;namespace&gt;.ckgedit にバックアップを保存';
$lang['create_folder']         = 'ファイルブラウザーでフォルダ作成ボタンを有効にする。 (y/n)';
$lang['dwedit_ns']             = 'テキストモードに自動的に切り替える名前空間のリスト（カンマ区切り）';
$lang['acl_del']               = 'デフォルト（チェックしない）の場合、アップロード権限を持つユーザーにメディアファイルを削除する権限を与えます。チェックした場合、フォルダからファイルを削除するには削除の権限が必要です。';
$lang['auth_ci']               = 'ユーザーのログインIDは大文字小文字を区別しない。つまりUSERとuserのいずれでもログイン可能';
$lang['nix_style']             = 'Windowsのサーバー（Vista以降）用の設定。この設定を有効にすると userfiles にメディアとファイルへのリンクを正常に作ることができる場合に、data\media に ckgedit\CKeditor\userfiles でアクセスできるようにします。';
$lang['no_symlinks']           = 'ckgedit/userfiles にシンボリックリンクを自動で作成しない';
$lang['direction']             = 'CKeditorでの文字の方向:  <b>nocheck</b>: ckgeditはデフォルトの方向の設定を変更しない。  <b>dokuwiki</b>:  Dokuwikiの文字の方向の設定に従う。  <b>ltr</b>: 左から右。 <b>rtl</b>: 右から左。';
$lang['scayt_auto']            = 'スペルチェッカーを自動的に有効化。デフォルトは"on"。スペルチェッカーを無効にするには"off"を選択してください。';
$lang['scayt_lang']            = 'スペルチェッカーのデフォルト言語';
$lang['smiley_hack']           = '新しいサーバーに移動した時にCKeditorの顔文字のURLを初期化。これはページごとにページが編集のために読み込まれ、保存された時に行われます。このオプションは通常はoffにします。';
$lang['complex_tables']        = '複雑な表のアルゴリズムを使用。通常の表のパースに比べて、rowspanやcolspanを使った複雑な表をより良くパースできますが、処理時間がやや長くなります。';
$lang['duplicate_notes']       = 'ユーザーが同じ脚注テキストに対して複数の脚注を付ける場合にチェックしてください。脚注が衝突しないようにするために必要です。';
$lang['winstyle']              = 'fckeditor/userfiles の代わりにメディアディレクトリへの直接のパスを使用。このためには fckeditor/userfiles/.htaccess.security を data/media にコピーして .htaccess にリネームする必要があります。';
$lang['other_lang']            = 'CKEditorのデフォルト言語。デフォルトではブラウザの言語が使われますが、ここで他の言語を選択できます。この設定はDokuwikiのインターフェイスの言語とは独立しています。';
$lang['dw_priority']           = 'Dokuwikiのエディタを標準に設定';
$lang['preload_ckeditorjs']    = 'CKEditorを事前に読み込み、編集を始める時の遅延時間を減らします。';

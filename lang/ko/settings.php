<?php

/**
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 *
 * @author Myeongjin <aranet100@gmail.com>
 */
$lang['groups']                = '잠금 타이머를 비활성화하도록 허용하는 그룹 (사용되지 않음)';
$lang['fck_preview']           = 'FCK 미리 보기 그룹';
$lang['guest_toolbar']         = '손님에게 도구 모음을 표시';
$lang['guest_media']           = '손님이 미디어 파일로 링크할 수 있음';
$lang['open_upload']           = '손님이 올릴 수 있음';
$lang['default_fb']            = '기본 파일 찾아보기 접근. none이면, acl이 적용되지 않습니다.';
$lang['openfb']                = '파일 찾아보기를 엽니다. 사용자가 권한이 있는지 없는지에 따라 사용자에게 전체 디렉터리 구조에 접근할 수 있도록 줍니다. ACL은 여전히 올리기에 적용됩니다.';
$lang['dw_edit_display']       = '"DW 편집" 버튼으로 접근할 수 있는 사용자를 제어합니다. 선택: "all"은 모든 사용자; "admin"은 admin 및 manager만; "none"은 아무도 없음. 기본값은 "all"입니다.';
$lang['smiley_as_text']        = 'CKeditor에서 이모티콘을 텍스트로 표시 (여전히 브라우저에서는 그림으로 표시됩니다)';
$lang['editor_bak']            = 'meta/&lt;namespace&gt;.ckgedit에 백업을 저장';
$lang['create_folder']         = '파일 브라우저에서 폴더 만들기 버튼 활성화 (y/n)';
$lang['dwedit_ns']             = 'ckgedit가 네이티브 도쿠위키 편집기로 자동으로 전환할 이름공간 및/또는 문서의 쉼표로 구분된 목록; 부분적인 일치를 허용합니다.';
$lang['acl_del']               = '기본값 (상자가 체크되지 않음)으로 올리기 권한이 있는 사용자에게 미디어 파일을 삭제할 권한을 허용합니다; 상자게 체크되어 있으면, 사용자는 폴더에서 삭제하려면 삭제 권한이 필요합니다.';
$lang['auth_ci']               = '사용자 로그인 id는 대소문자를 구분하지 않습니다, 즉 USER와 user 둘 다 로그인할 수 있습니다';
$lang['nix_style']             = 'Windows 서버 (Vista 이상)를 위해 이 설정은 미디어와 파일로의 링크가 성공적으로 userfiles에 만들어지는 경우, ckgedit\CKeditor\userfiles를 통해 data/media에 접근할 수 있도록 합니다';
$lang['no_symlinks']           = 'ckgedit/userfiles에 심볼릭 링크를 자동으로 만들기를 비활성화합니다.';
$lang['direction']             = 'CKeditor에서의 언어 방향 설정:  <b>nocheck</b>: ckgedit는 기본 방향 설정을 바꾸지 않습니다;  <b>dokuwiki</b>:  현재 도쿠위키 언어 방향;  <b>ltr</b>: 왼쪽에서 오른쪽; <b>rtl</b>: 오른쪽에서 왼쪽.';
$lang['scayt_auto']            = 'SCAYT 맞춤법 검사기를 자동으로 활성화합니다. 기본값은 "on"입니다; SCAYT를 끄려면 "off"를 선택하세요';
$lang['scayt_lang']            = 'SCAYT 기본 언어를 설정합니다.';
$lang['smiley_hack']           = '새 서버로 이동했을 때 CKeditor 이모티콘의 URL을 재설정합니다. 문서별로 문서가 편집을 위해 불러오고, 저장되었을 때 이루어집니다. 이 옵션은 일반적으로 off로 설정해야 합니다.';
$lang['complex_tables']        = '복잡한 표 알고리즘을 사용합니다. 표의 표준 구문 분석에 비해 rowspan과 colspan을 사용한 복잡한 표를 더 잘 표시해야 합니다. 그러나 처리 시간이 다소 길어집니다.';
$lang['duplicate_notes']       = '사용자가 같은 각주 텍스트에 여러 각주를 붙이는 경우 이것을 true로 설정하세요; 각주가 충돌하지 않도록 하기 위해 필요합니다.';
$lang['winstyle']              = 'fckeditor/userfiles 대신 미디어 디렉터리에 직접 경로를 사용합니다. 이를 위해서는 fckeditor/userfiles/.htaccess.security를 data/media에 복사하여 .htaccess 이름을 바꿀 필요가 있습니다.';
$lang['other_lang']            = 'CKEditor의 기본 언어로 브라우저의 언어로 설정됩니다. 하지만, 여기에서 다른 언어를 선택할 수 있습니다; 이것은 도쿠위키의 인터페이스 언어와는 독립적입니다.';
$lang['dw_priority']           = '<b>dw_priority</b>: 도쿠위키 편집기를 기본 편집기로 사용';
$lang['preload_ckeditorjs']    = 'CKEditor의 자바스크립트를 미리 읽어 편집기를 불러올 때의 지연 시간을 줄이기';
$lang['nofont_styling']        = '편집기에서 글꼴 스타일을 플러그인 마크업으로 표시합니다. 자세한 내용은 Dokuwiki.org에서 ckgedit 플러그인 문서를 보세요.';
$lang['font_options']          = '글꼴 옵션을 제거합니다.';
$lang['color_options']         = '색 옵션을 제거합니다.';
$lang['alt_toolbar']           = 'CKEditor 도구 모음에서 제거할 기능<br /><br />텍스트 상자에 쉼표로 구분된 목록으로 다른 기능들을 포함하여 제거할 수 있습니다:<br /><br />Bold, Italic, Underline, Strike, Subscript, Superscript, RemoveFormat, Find, Replace, SelectAll, Scayt, Image, Table, Tags, Link, Unlink, Format, Styles,TextColor, BGColor, NumberedList, BulletedList, Cut, Copy, Paste, PasteText, PasteFromWord, Undo, Redo, Source, Maximize, About.';
$lang['mfiles']                = 'mfile 지원 활성화';
$lang['extra_plugins']         = '도구 모음에 추가할 추가적인 Ckeditor 플러그인의 쉼표로 구분된 목록. 자세한 사항은 ckgedit 플러그인의 <a href=\'https://www.dokuwiki.org/plugin:ckgedit:configuration#extra_plugins\'>설정 문서</a>를 보세요';
$lang['dw_users']              = '<b>dw_priority</b>가 선택되어 있을 때 편집기 기본값을 도쿠위키 편집기로 사용할 사용자의 그룹 이름. 정의하지 않으면, 모든 사용자가 <b>dw_priority</b>가 선택되어 있을 때 네이티브 도쿠위키 편집기를 사용합니다.';

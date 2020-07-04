<?php

/**
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 *
 * @author Thien Hau <thienhau.9a14@gmail.com>
 */
$lang['groups']                = 'Nhóm được phép vô hiệu hóa bộ đếm thời gian khóa (lỗi thời)';
$lang['fck_preview']           = 'Nhóm xem trước FCK';
$lang['guest_toolbar']         = 'Hiển thị thanh công cụ cho Khách';
$lang['guest_media']           = 'Khách có thể liên kết đến tập tin phương tiện';
$lang['open_upload']           = 'Khách có thể tải lên';
$lang['default_fb']            = 'Truy cập duyệt tập tin mặc định. Không có, acl không áp dụng.';
$lang['openfb']                = 'Mở Duyệt Tập tin. Điều này cho phép thành viên truy cập vào toàn bộ cấu trúc đường dẫn, cho dù thành viên có quyền hay không. ACL vẫn áp dụng cho tải lên.';
$lang['dw_edit_display']       = 'Kiểm soát những thành viên có quyền truy cập vào  nút "Trình sửa đổi DW". Lựa chọn: "all" cho tất cả thành viên; "admin" chỉ dành cho quản trị viên và người quản lý; "none" không ai có thể truy cập. Mặc định là "all".';
$lang['smiley_as_text']        = 'Hiển thị mặt cười dưới dạng văn bản trong CKeditor (vẫn sẽ hiển thị dưới dạng hình ảnh trong trình duyệt)';
$lang['editor_bak']            = 'Lưu bản sao lưu vào meta/&lt;namespace&gt;.ckgedit';
$lang['create_folder']         = 'Kích hoạt nút tạo thư mục trong trình duyệt tập tin (y/n)';
$lang['dwedit_ns']             = 'Danh sách các không gian tên và/hoặc trang được phân tách bằng dấu phẩy nơi ckgedit tự động chuyển sang Trình sửa đổi DokuWiki gốc; chấp nhận một phần phù hợp.';
$lang['acl_del']               = 'Mặc định (hộp không được đánh dấu) cho phép thành viên có quyền tải lên để xóa các tập tin phương tiện; nếu hộp được đánh dấu, thì thành viên cần xóa quyền xóa khỏi thư mục.';
$lang['auth_ci']               = 'Id đăng nhập thành viên không phân biệt chữ hoa chữ thường, nghĩa là bạn có thể đăng nhập với tư cách là cả THÀNH VIÊN và thành viên';
$lang['nix_style']             = 'Dành cho Windows Servers (Vista trở lên).  Cài đặt này cho phép truy cập data\media thông qua ckgedit\CKeditor\userfiles, nếu liên kết đến phương tiện và tập tin đã được tạo thành công trong tập tin người dùng';
$lang['no_symlinks']           = 'Vô hiệu hóa tự động tạo các liên kết tượng trưng trong ckgedit/userfiles.  Tùy chọn này nên được tắt khi cập nhật.';
$lang['direction']             = 'Đặt hướng ngôn ngữ trong CKeditor:  <b>nocheck</b>: ckgedit sẽ không thay đổi cài đặt hướng mặc định;  <b>dokuwiki</b>:  hướng ngôn ngữ Dokuwiki hiện tại;  <b>ltr</b>: Trái sang phải ; <b>rtl</b>: Phải sang trái.';
$lang['scayt_auto']            = 'Đặt có hay không trình kiểm tra chính tả khi nhập Scayt đang hoạt động khi khởi động. Mặc định là <code>off</code>;người dùng có thể kích hoạt lại kiểm tra chính tả trên cơ sở mỗi trang. Để xóa hoàn toàn trình kiểm tra chính tả Scayt, chọn <code>disable</code>. (Xem <a href="https://www.dokuwiki.org/plugin:ckgedit:configuration#scayt_auto">ckgedit:configuration#scayt_auto</a>") ';
$lang['scayt_lang']            = 'Đặt ngôn ngữ mặc định SCAYT.';
$lang['smiley_hack']           = 'Đặt lại URL cho mặt cười của CKeditor khi chuyển sang máy chủ mới. Điều này được thực hiện trên một trang theo cơ sở trang khi trang được tải để sửa đổi và lưu. Tùy chọn này thường nên được tắt.';
$lang['complex_tables']        = 'Sử dụng thuật toán bảng phức tạp. Trái ngược với phân tích cú pháp tiêu chuẩn của các bảng, điều này sẽ cho kết quả tốt hơn khi trộn các sắp xếp phức tạp của các rowspans và colspans. Nhưng thời gian xử lý nhiều hơn một chút.';
$lang['duplicate_notes']       = 'Đặt điều này thành đúng nếu thành viên tạo nhiều chú thích với cùng một văn bản chú thích; cần thiết để ngăn ghi chú bị hỏng.';
$lang['winstyle']              = 'Sử dụng đường dẫn trực tiếp đến đường dẫn phương tiện thay vì fckeditor/userfiles. Chức năng này sao chép <br />fckeditor/userfiles/.htaccess.security đến data/media/.htaccess; nếu không, điều này nên được thực hiện thủ công';
$lang['other_lang']            = 'Ngôn ngữ mặc định của bạn cho CKEditor là ngôn ngữ được đặt cho trình duyệt của bạn. Tuy nhiên, bạn có thể chọn một ngôn ngữ khác ở đây; nó độc lập với ngôn ngữ giao diện Dokuwiki.';
$lang['dw_priority']           = 'Đặt trình sửa đổi Dokuwiki làm trình sửa đổi mặc định: không hoạt động trong các trang trại';
$lang['preload_ckeditorjs']    = 'Tải trước javascript của ckeditor để tăng tốc độ tải trình sửa đổi sau';
$lang['nofont_styling']        = 'Hiển thị kiểu phông chữ trong trình sửa đổi dưới dạng đánh dấu plugin. Xem trang plugin ckgedit tại Dokuwiki.org để biết chi tiết.';
$lang['font_options']          = 'Xóa tùy chọn phông chữ.';
$lang['color_options']         = 'Xóa tùy chọn màu.';
$lang['alt_toolbar']           = 'Các chức năng muốn loại bỏ khỏi thanh công cụ CKEditor.<br /><br /> Bất kỳ chức năng nào khác có thể được loại bỏ bằng cách đưa chúng vào danh sách được phân tách bằng dấu phẩy trong hộp văn bản:<br /><br />Bold (In đậm), Italic (In nghiêng), Underline (Gạch chân), Strike (Gạch xuyên ngang), Subscript (Chỉ số dưới), Superscript (Chỉ số trên), RemoveFormat (Xóa định dạng), Find (Tìm), Replace (Thay thế), SelectAll (Chọn tất cả), Scayt (Kiểm tra chính tả Scayt), Image (Hình ảnh), Table (Bảng), Tags (Thẻ), Link (Liên kết), Unlink (Bỏ liên kết), Format (Định dạng), Styles (Kiểu cách),TextColor (Màu văn bản), BGColor (Màu nền), NumberedList (Danh sách đánh số), BulletedList (Danh sách không đánh số), Cut (Cắt), Copy (Sao chép), Paste (Dán), PasteText (Dán văn bản thường), PasteFromWord  (Dán từ Word), Undo (Hoàn tác), Redo (Làm lại), Source (Nguồn), Maximize (Phóng to), About (Về).';
$lang['mfiles']                = 'Cho phép hỗ trợ mfile';
$lang['extra_plugins']         = 'Danh sách các plugin Ckeditor được phân tách bằng dấu phẩy được thêm vào thanh công cụ. Xem <a href=\'https://www.dokuwiki.org/plugin:ckgedit:configuration#extra_plugins\'>trang cấu hình</a> plugin của ckgedit để biết chi tiết';
$lang['dw_users']              = 'Tên nhóm thành viên có trình sửa đổi mặc định cho trình soạn thảo Dokuwiki khi <b>dw_priority</b> được chọn. Nếu không được xác định, thì tất cả thành viên sẽ nhận được trình sửa đổi Dokuwiki riêng khi <b>dw_priority</b> được chọn';
$lang['allow_ckg_filebrowser'] = 'Chọn trình duyệt Tập tin/phương tiện thành viên có thể sử dụng';
$lang['default_ckg_filebrowser'] = 'Chọn trình duyệt Tập tin/phương tiện mặc định. Điều này sẽ bị ghi đè nếu trình duyệt được chọn không được phép';
$lang['captcha_auth']          = 'Mức độ ACL mà captcha bị tắt khi tùy chọn <code>forusers</code> của plugin captcha được đặt thành đúng. Mặc định là <code>ACL_CREATE</code>, có nghĩa là bất kỳ thành viên nào với <code>ACL_EDIT</code> hoặc ít hơn sẽ có được captcha <code>ACL_CREATE</code> hoặc cao hơn sẽ không.';
$lang['htmlblock_ok']          = 'Khi sử dụng <code>HTML_BLOCK</code>s  cài đặt này hoặc tùy chọn <code>htmlok</code> của Dokuwiki phải được kích hoạt. Nó không gây ra mức độ rủi ro bảo mật tương tự như <code>htmlok</code>. Tuy nhiên, nó chỉ nên được sử dụng trong môi trường thành viên đáng tin cậy chứ không phải trong wiki mở.';
$lang['dblclk']                = 'Đặt <code>off</code> để tắt tính năng nhấp đúp cho phép sửa đổi phần bằng trình sửa đổi Dokuwiki (xem:  <a href=\'https://www.dokuwiki.org/plugin:ckgedit#direct_access_to_dokuwiki_editor\'>direct_access_to_dokuwiki_editor</a>)';
$lang['preserve_enc']          = 'Giữ nguyên urlencoding trong url khi tùy chọn vô hiệu hóa dokuwiki đang hoạt động.';
$lang['gui']                   = 'Chọn GUI CKEditor.';
$lang['rel_links']             = 'Kích hoạt hỗ trợ cho các liên kết hình ảnh và nội bộ liên quan';

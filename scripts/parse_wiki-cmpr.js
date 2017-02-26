function parse_wikitext(id){if(ckgedit_dwedit_reject){var dom=GetE('ebut_cancel');dom.click();return true;}
var useComplexTables=getComplexTables();function fontConflict(){var regex=/\>\s+(\*\*|__|\/\/|'')\s+_\s+\1\s+<\/font>/gm;results=results.replace(regex,function(m){m=m.replace(/\s+/g,"");return m;});regex=new RegExp("\\>(.*?)(\\]\\]\\<\\/font\\>)|(\\<\\/font\\>\\]\\])","gm");if(results.match(regex))
return true;regex=new RegExp("(\\{\\{(.*?)\\.\\w{2,4})\\|\\<font");if(results.match(regex))
return true;regex=new RegExp("\\{\\{(.*?)\\.\\w{2,4}\\|[:\\w\\-\\.\\s]+\\<\\/font");if(results.match(regex))
return true;regex=new RegExp('\\>\\{\\{(.*?)\\.\\w+\\<\\/font\\>\\b','gm');if(results.match(regex))
return true;return false;}
function check_rowspans(rows,start_row,ini){var tmp=new Array();for(var i=start_row;i<rows.length;i++){for(var col=0;col<rows[i].length;col++){if(rows[i][col].rowspan>0){var _text=rows[i][col].text;tmp.push({row:i,column:col,spans:rows[i][col].rowspan,text:_text});if(!ini)
break;}}}
return tmp;}
function insert_rowspan(row,col,spans,rows,shift){var prev_colspans=rows[row][col].colspan?rows[row][col].colspan:0;rows[row][col].rowspan=0;for(i=0;i<spans-1;i++){rows[++row].splice(col,0,{type:'td',rowspan:0,colspan:prev_colspans,prev_colspan:prev_colspans,text:" ::: "});}}
function reorder_span_rows(rows){var tmp_start=check_rowspans(rows,0,true);var num_spans=tmp_start.length;if(!num_spans)
return false;var row=tmp_start[0].row;var col=tmp_start[0].column;insert_rowspan(row,col,tmp_start[0].spans,rows);num_spans--;for(var i=0;i<num_spans;i++){row++;var tmp=check_rowspans(rows,row,false);if(tmp.length){insert_rowspan(tmp[0].row,tmp[0].column,tmp[0].spans,rows);}}
return true;}
function insert_table(rows){if(!useComplexTables)
return;for(var i=0;i<rows.length;i++){if(!reorder_span_rows(rows))
break;;}
results+="\n";for(var i=0;i<rows.length;i++){results+="\n";for(var col=0;col<rows[i].length;col++){var type=rows[i][col].type=='td'?'|':'^';results+=type;var align=rows[i][col].align?rows[i][col].align:false;if(align=='center'||align=='right'){results+="  ";}
results+=rows[i][col].text;if(align=='center'||align=='left'){results+="  ";}
if(rows[i][col].colspan){for(var n=0;n<rows[i][col].colspan-1;n++){results+=type;}}}
results+='|';}}
window.dwfckTextChanged=false;if(id!='bakup')
draft_delete();var line_break="\nL_BR_K  \n";var markup={'b':'**','i':'//','em':'//','u':'__','br':line_break,'strike':'<del>','del':'<del>','s':'<del>',p:"\n\n",'a':'[[','img':'\{\{','strong':'**','h1':"\n====== ",'h2':"\n===== ",'h3':"\n==== ",'h4':"\n=== ",'h5':"\n== ",'td':"|",'th':"^",'tr':" ",'table':"\n\n",'ol':"  - ",'ul':"  * ",'li':"",'code':"\'\'",'pre':"\n<",'hr':"\n\n----\n\n",'sub':'<sub>','font':"",'align':"",'sup':'<sup>','div':"\n\n",'span':"\n",'dl':"\n",'dd':"\n",'dt':"\n"};var markup_end={'del':'</del>','s':'</del>','strike':'</del>','p':" ",'br':" ",'a':']]','img':'\}\}','h1':" ======\n",'h2':" =====\n",'h3':" ====\n",'h4':" ===\n",'h5':" ==\n",'td':" ",'th':" ",'tr':"|\n",'ol':" ",'ul':" ",'li':"\n",'pre':"\n</",'sub':'</sub>','sup':'</sup> ','div':"\n\n",'p':"\n\n",'font':"</font>",'align':"</align>",'span':" ",};markup['temp_u']="CKGE_TMP_u";markup['temp_strong']="CKGE_TMP_strong";markup['temp_em']="CKGE_TMP_em";markup['temp_i']="CKGE_TMP_i";markup['temp_b']="CKGE_TMP_b";markup['temp_del']="CKGE_TMP_del";markup['temp_strike']="CKGE_TMP_strike";markup['temp_code']="CKGE_TMP_code";markup['temp_sup']="CKGE_TMP_sup";markup['temp_csup']="CKGE_TMP_csup";markup['temp_sub']="CKGE_TMP_sub";markup['temp_csub']="CKGE_TMP_csub";markup['temp_del']="CKGE_TMP_del";markup['temp_cdel']="CKGE_TMP_cdel";markup['temp_strike']="CKGE_TMP_del";markup['temp_cstrike']="CKGE_TMP_cdel";markup['temp_s']="CKGE_TMP_del";markup['temp_cs']="CKGE_TMP_cdel";var $FORMAT_SUBST={'CKGE_TMP_b':'**','CKGE_TMP_strong':'**','CKGE_TMP_em':'\/\/','CKGE_TMP_u':'__','CKGE_TMP_sup':'<sup>','CKGE_TMP_sub':'<sub>','CKGE_TMP_cdel':'</del>','CKGE_TMP_csub':'</sub>','CKGE_TMP_csup':'</sup>','CKGE_TMP_del':'<del>','CKGE_TMP_strike':'<del>','CKGE_TMP_code':"\'\'"};markup['blank']="";markup['fn_start']='((';markup['fn_end']='))';markup['row_span']=":::";markup['p_insert']='_PARA__TABLE_INS_';markup['format_space']='_FORMAT_SPACE_';markup['pre_td']='<';var format_chars={'strong':true,'b':true,'i':true,'em':true,'u':true,'del':true,'strike':true,'code':true,'sup':true,'sub':true,'s':true};var results="";var HTMLParser_LBR=false;var HTMLParser_PRE=false;var HTMLParser_Geshi=false;var HTMLParser_TABLE=false;var HTMLParser_COLSPAN=false;var HTMLParser_FORMAT_SPACE=false;var HTMLParser_MULTI_LINE_PLUGIN=false;var HTMLParser_NOWIKI=false;var HTMLFormatInList=false;var HTMLAcroInList=false;var HTML_InterWiki=false;var HTMLParserFont=false;var HTMLParserFontInfix=false;var CurrentTable;var HTMLParserTopNotes=new Array();var HTMLParserBottomNotes=new Array();var HTMLParserOpenAngleBracket=false;var HTMLParserParaInsert=markup['p_insert'];var geshi_classes='(br|co|coMULTI|es|kw|me|nu|re|st|sy)[0-9]';String.prototype.splice=function(idx,rem,s){return(this.slice(0,idx)+s+this.slice(idx+Math.abs(rem)));};String.frasl=new RegExp("⁄\|&frasl;\|&#8260;\|&#x2044;",'g');geshi_classes=new RegExp(geshi_classes);HTMLParser(CKEDITOR.instances.wiki__text.getData(),{attribute:"",link_title:"",link_class:"",image_link_type:"",td_align:"",in_td:false,td_colspan:0,td_rowspan:0,rowspan_col:0,last_column:-1,row:0,col:0,td_no:0,tr_no:0,current_row:false,in_table:false,in_multi_plugin:false,is_rowspan:false,list_level:0,prev_list_level:-1,list_started:false,xcl_markup:false,in_link:false,link_formats:new Array(),last_tag:"",code_type:false,in_endnotes:false,is_smiley:false,geshi:false,downloadable_code:false,export_code:false,code_snippet:false,downloadable_file:"",external_mime:false,in_header:false,curid:false,format_in_list:false,prev_li:new Array(),link_only:false,in_font:false,using_fonts:false,interwiki:false,bottom_url:false,font_family:"inherit",font_size:"inherit",font_weight:"inherit",font_color:"inherit",font_bgcolor:"inherit",font_style:"inherit",is_mediafile:false,end_nested:false,mfile:false,in_align:false,align_param:'left',backup:function(c1,c2){var c1_inx=results.lastIndexOf(c1);var c2_inx=results.indexOf(c2,c1_inx);if(c1_inx==-1||c2_inx==-1)
return;if(c1.length+c2_inx==c2_inx){var left_side=results.substring(0,c1_inx);var right_side=results.substring(c2_inx);results=left_side+right_side;return true;}
return false;},is_iwiki:function(class_name,title){var iw_type=class_name.match(/iw_(\w+\.?\w{0,12})/);var iw_title=title.split(/\//);var interwiki_label=iw_title[iw_title.length-1];interwiki_label=interwiki_label.replace(String.frasl,"\/");if(!interwiki_label.match(/oIWIKIo.*?cIWIKIc/)){interwiki_label='oIWIKIo'+interwiki_label+'cIWIKIc';}
interwiki_label=interwiki_label.replace(/^.*?oIWIKIo/,'oIWIKIo');interwiki_label=interwiki_label.replace(/cIWIKIc.*/,'cIWIKIc');iw_type[1]=iw_type[1].replace(/_(\w{2})/,"."+"$1");this.attr=iw_type[1]+'>'+interwiki_label;HTML_InterWiki=true;this.interwiki=true;},start:function(tag,attrs,unary){if(markup[tag]){if(format_chars[tag]&&this.in_link){this.link_formats.push(tag);return;}
if(format_chars[tag]&&(this.in_font||this.in_header)){results+=" ";var t='temp_'+tag;results+=markup[t];results+=" ";return;}else if(tag=='acronym'){return;}
if(format_chars[tag]&&this.in_endnotes){if(tag=='sup')
return;}
if(tag=='ol'||tag=='ul'){this.prev_list_level=this.list_level;this.list_level++;if(this.list_level==1)
this.list_started=false;if(this.list_started)
this.prev_li.push(markup['li']);markup['li']=markup[tag];return;}else if(!this.list_level){markup['li']="";this.prev_li=new Array();}
this.is_mediafile=false;if(tag=='img'){var img_size="?";var width;var height;var style=false;var img_align='';var alt="";var from_clipboard=false;this.is_smiley=false;this.in_link=false;}
if(tag=='a'){var local_image=true;var type="";this.xcl_markup=false;this.in_link=true;this.link_pos=results.length;this.link_formats=new Array();this.footnote=false;var bottom_note=false;this.id="";this.external_mime=false;var media_class=false;this.export_code=false;this.code_snippet=false;this.downloadable_file="";var qs_set=false;this.link_only=false;save_url="";this.interwiki=false;this.bottom_url=false;this.link_title=false;var interwiki_title="";var interwiki_class="";}
if(tag=='p'){this.in_link=false;if(this.in_table){tag='p_insert';HTMLParser_TABLE=true;}}
if(tag=='table'){this.td_no=0;this.tr_no=0;this.in_table=true;this.is_rowspan=false;this.row=-1;this.rows=new Array();CurrentTable=this.rows;this.table_start=results.length;}else if(tag=='tr'){this.tr_no++;this.td_no=0;this.col=-1;this.row++;this.rows[this.row]=new Array();this.current_row=this.rows[this.row];}else if(tag=='td'||tag=='th'){this.td_no++;this.col++;this.current_row[this.col]={type:tag,rowspan:0,colspan:0,text:""};this.cell_start=results.length;this.current_cell=this.current_row[this.col];if(this.td_rowspan&&this.rowspan_col==this.td_no&&this.td_no!=this.last_column){this.is_rowspan=true;this.td_rowspan--;}else{this.is_rowspan=false;}}
var matches;this.attr=false;this.format_tag=false;if(format_chars[tag])
this.format_tag=true;var dwfck_note=false;for(var i=0;i<attrs.length;i++){if(tag=='td'||tag=='th'){if(attrs[i].name=='colspan'){this.current_row[this.col].colspan=attrs[i].value;}
if(attrs[i].name=='class'){if((matches=attrs[i].value.match(/(left|center|right)/))){this.current_row[this.col].align=matches[1];}}
if(attrs[i].name=='rowspan'){this.current_row[this.col].rowspan=attrs[i].value}}
if(attrs[i].escaped=='u'&&tag=='em'){tag='u';this.attr='u'
break;}
if(tag=='div'){if(attrs[i].name=='class'&&attrs[i].value=='footnotes'){tag='blank';this.in_endnotes=true;}
break;}
if(tag=='dl'&&attrs[i].name=='class'&&attrs[i].value=='file'){this.downloadable_code=true;HTMLParser_Geshi=true;return;}
if(tag=='span'&&attrs[i].name=='class'){if(attrs[i].value=='np_break')
return;}
if(tag=='span'&&attrs[i].name=='class'){if(attrs[i].value=='curid'){this.curid=true;return;}
if(attrs[i].value=='multi_p_open'){this.in_multi_plugin=true;HTMLParser_MULTI_LINE_PLUGIN=true;return;}
if(attrs[i].value=='multi_p_close'){this.in_multi_plugin=false;return;}
if(attrs[i].value.match(geshi_classes)){tag='blank';this.geshi=true;break;}}
if(tag=='p'){if(attrs[i].name=='style'){if(!this.in_align)
results+="__ALIGN__";this.in_align=true;matches=attrs[i].value.match(/text-align:\s*([A-Za-z0-9]+);?/);if(matches){this.align_param=matches[1];}}}
if(tag=='span'&&!ckgedit_xcl_styles){if(attrs[i].name=='style'){if(!this.in_font)
results+="__STYLE__";this.in_font=true;this.using_fonts=true;matches=attrs[i].value.match(/font-family:\s*([\w\-\s,]+);?/);if(matches){this.font_family=matches[1];}
matches=attrs[i].value.match(/font-size:\s*(.*)/);if(matches){matches[1]=matches[1].replace(/;/,"");this.font_size=matches[1];}
matches=attrs[i].value.match(/font-weight:\s*(\w+);?/);if(matches){this.font_weight=matches[1];}
matches=attrs[i].value.match(/.*?color:\s*(.*)/);var bgcolor_found=false;if(matches){matches[1]=matches[1].replace(/;/,"");if(matches[0].match(/background/)){this.font_bgcolor=matches[1];}else{this.font_color=matches[1];}}
if(!bgcolor_found){matches=attrs[i].value.match(/background:\s*(\w+)/);if(matches&&matches[0].match(/background/)){this.font_bgcolor=matches[1];}}}}
if(tag=='td'||tag=='th'){if(tag=='td'){results=results.replace(/\^$/,'|');}
this.in_td=true;if(attrs[i].name=='align'){this.td_align=attrs[i].escaped;}else if(attrs[i].name=='class'){matches=attrs[i].value.match(/\s*(\w+)align/);if(matches){this.td_align=matches[1];}}else if(attrs[i].name=='colspan'){HTMLParser_COLSPAN=true;this.td_colspan=attrs[i].escaped;}else if(attrs[i].name=='rowspan'){this.td_rowspan=attrs[i].escaped-1;this.rowspan_col=this.td_no;}
HTMLParser_TABLE=true;}
if(tag=='a'){if(attrs[i].name=='title'){this.link_title=attrs[i].escaped;if(interwiki_class){interwiki_title=attrs[i].escaped;}else
this.link_title=this.link_title.replace(/\s+.*$/,"");}else if(attrs[i].name=='class'){if(attrs[i].value.match(/fn_top/)){this.footnote=true;}else if(attrs[i].value.match(/fn_bot/)){bottom_note=true;}else if(attrs[i].value.match(/mf_(png|gif|jpg|jpeg)/i)){this.link_only=true;}
this.link_class=attrs[i].escaped;media_class=this.link_class.match(/mediafile/);}else if(attrs[i].name=='id'){this.id=attrs[i].value;}else if(attrs[i].name=='type'){type=attrs[i].value;}else if(attrs[i].name=='href'&&!this.code_type){var http=attrs[i].escaped.match(/https*:\/\//)?true:false;if(http)
save_url=attrs[i].escaped;if(attrs[i].escaped.match(/\/lib\/exe\/detail.php/)){this.image_link_type='detail';}else if(attrs[i].escaped.match(/exe\/fetch.php/)){this.image_link_type='direct';}
if(this.link_class&&this.link_class.match(/media/)&&!this.link_title){var link_find=attrs[i].escaped.match(/media=(.*)/);if(link_find)
this.link_title=link_find[1];}
var media_type=attrs[i].escaped.match(/fetch\.php.*?media=.*?\.(png|gif|jpg|jpeg)$/i);if(media_type)
media_type=media_type[1];if(attrs[i].escaped.match(/^https*:/)){this.attr=attrs[i].escaped;local_image=false;}
if(attrs[i].escaped.match(/^ftp:/)){this.attr=attrs[i].escaped;local_image=false;}else if(attrs[i].escaped.match(/do=export_code/)){this.export_code=true;}else if(attrs[i].escaped.match(/^nntp:/)){this.attr=attrs[i].escaped;local_image=false;}else if(attrs[i].escaped.match(/^mailto:/)){this.attr=attrs[i].escaped.replace(/mailto:/,"");local_image=false;}else if(attrs[i].escaped.match(/m-files/)){this.attr=attrs[i].escaped;this.mfile=attrs[i].escaped;local_image=false;}else if(attrs[i].escaped.match(/^file:/)){var url=attrs[i].value.replace(/file:[\/]+/,"");url=url.replace(/[\/]/g,'\\');url='\\\\'+url;this.attr=url;local_image=false;}
else if(http&&!media_type&&(matches=attrs[i].escaped.match(/fetch\.php(.*)/))){if(matches[1].match(/media=/)){elems=matches[1].split(/=/);this.attr=elems[1];}else{matches[1]=matches[1].replace(/^\//,"");this.attr=matches[1];}
if(typeof config_animal!=='undefined'){var regex=new RegExp(config_animal+'\/file\/(.*)');matches=attrs[i].escaped.match(regex);if(matches&&matches[1])
this.attr=matches[1];if(this.attr)
this.attr=this.attr.replace(/\//g,':');}
local_image=false;this.attr=decodeURIComponent?decodeURIComponent(this.attr):unescape(this.attr);if(!this.attr.match(/^:/)){this.attr=':'+this.attr;}
this.external_mime=true;}else{local_image=false;matches=attrs[i].escaped.match(/doku.php\?id=(.*)/);if(!matches){matches=attrs[i].escaped.match(/doku.php\/(.*)/);}
if(matches){if(!matches[1].match(/\?/)&&matches[1].match(/&amp;/)){qs_set=true;matches[1]=matches[1].replace(/&amp;/,'?')}}
if(matches&&matches[1]){if(!matches[1].match(/^:/)){this.attr=':'+matches[1];}else{this.attr=matches[1];}
if(this.attr.match(/\.\w+$/)){if(type&&type=='other_mime'){this.external_mime=true;}else{for(var n=i+1;n<attrs.length;n++){if(attrs[n].value.match(/other_mime/))
this.external_mime=true;break;}}}}else{matches=attrs[i].value.match(/\\\\/);if(matches){this.attr=attrs[i].escaped;local_image=false;}}}
if(this.link_class=='media'){if(attrs[i].value.match(/http:/)){local_image=false;}}
if(!this.attr&&this.link_title){if(matches=this.link_class.match(/media(.*)/)){this.link_title=decodeURIComponent(safe_convert(this.link_title));this.attr=this.link_title;var m=matches[1].split(/_/);if(m&&m[1]){media_type=m[1];}else if(m){media_type=m[0];}else
media_type='mf';if(!this.attr.match(/^:/)&&!this.attr.match(/^https?\:/)){this.attr=':'+this.attr.replace(/^\s+/,"");}
this.external_mime=true;local_image=false;}}
if(this.attr.match&&this.attr.match(/%[a-fA-F0-9]{2}/)&&(matches=this.attr.match(/userfiles\/file\/(.*)/))){matches[1]=matches[1].replace(/\//g,':');if(!matches[1].match(/^:/)){matches[1]=':'+matches[1];}
this.attr=decodeURIComponent?decodeURIComponent(matches[1]):unescape(matches[1]);this.attr=decodeURIComponent?decodeURIComponent(this.attr):unescape(this.attr);this.external_mime=true;}else if(this.attr&&this.attr.match(/%[a-fA-F0-9]{2}/)){this.attr=decodeURIComponent(this.attr);this.attr=decodeURIComponent(this.attr);}
if(this.link_title&&this.link_title.match(/Snippet/))
this.code_snippet=true;if(attrs[i].value.match(/^#/)&&this.link_class.match(/wikilink/)){this.attr=attrs[i].value;this.link_title=false;}
if(this.link_class.match(/wikilink/)&&this.link_title){this.external_mime=false;if(!this.attr){this.attr=this.link_title;}
if(!this.attr.match(/^:/)){this.attr=':'+this.attr;}
if(this.attr.match(/\?.*?=/)){var elems=this.attr.split(/\?/);elems[0]=elems[0].replace(/\//g,':');this.attr=elems[0]+'?'+elems[1];}else{this.attr=this.attr.replace(/\//g,':');}
if(!qs_set&&attrs[i].name=='href'){if(!this.attr.match(/\?.*?=/)&&!attrs[i].value.match(/doku.php/)){var qs=attrs[i].value.match(/(\?.*)$/);if(qs&&qs[1])
this.attr+=qs[1];}}}else if(this.link_class.match(/mediafile/)&&this.link_title&&!this.attr){this.attr=this.link_title;this.external_mime=true;if(!this.attr.match(/^:/)){this.attr=':'+this.attr;}}else if(this.link_class.match(/interwiki/)){interwiki_class=this.link_class;}
if(this.link_class=='urlextern'&&!this.mfile&&save_url){this.attr=save_url;this.external_mime=false;}
if(this.in_endnotes){if(this.link_title){this.bottom_url=this.link_title;}else if(this.attr){this.bottom_url=this.attr;}}
this.link_title="";this.link_class="";}}
if(interwiki_class&&interwiki_title){this.is_iwiki(interwiki_class,interwiki_title);interwiki_class="";interwiki_title="";}
if(tag=='sup'){if(attrs[i].name=='class'){matches=attrs[i].value.split(/\s+/);if(matches[0]=='dwfcknote'){this.attr=matches[0];tag='blank';if(oDokuWiki_FCKEditorInstance.oinsertHtmlCodeObj.notes[matches[1]]){dwfck_note='(('+oDokuWiki_FCKEditorInstance.oinsertHtmlCodeObj.notes[matches[1]]+'))';}
break;}}}
if(tag=='pre'){if(attrs[i].name=='class'){var elems=attrs[i].escaped.split(/\s+/);if(elems.length>1){this.attr=attrs[i].value;this.code_type=elems[0];}else{this.attr=attrs[i].escaped;this.code_type=this.attr;}
if(this.downloadable_code){this.attr=this.attr.replace(/\s*code\s*/,"");this.code_type='file';}
HTMLParser_PRE=true;if(this.in_table)
tag='pre_td';break;}}else if(tag=='img'){if(attrs[i].name=='alt'){alt=attrs[i].value;}
if(attrs[i].name=='type'){this.image_link_type=attrs[i].value;}
if(attrs[i].name=='src'){var src="";if(matches=attrs[i].escaped.match(/fetch\.php.*?(media=.*)/)){var elems=matches[1].split('=');src=elems[1];if(matches=attrs[i].escaped.match(/(media.*)/)){var elems=matches[1].split('=');var uri=elems[1];src=decodeURIComponent?decodeURIComponent(uri):unescape(uri);}
if(!src.match(/https?:/)&&!src.match(/^:/))
src=':'+src;}else if(attrs[i].escaped.match(/https?:\/\//)){src=attrs[i].escaped;src=src.replace(/\?.*?$/,"");}
else if(matches=attrs[i].escaped.match(/\/_media\/(.*)/)){var elems=matches[1].split(/\?/);src=elems[0];src=src.replace(/\//g,':');if(!src.match(/^:/))
src=':'+src;}
else if(matches=attrs[i].escaped.match(/\/lib\/exe\/fetch.php\/(.*)/)){var elems=matches[1].split(/\?/);src=elems[0];if(!src.match(/^:/))
src=':'+src;}else{matches=attrs[i].escaped.match(/^.*?\/userfiles\/image\/(.*)/);if(!matches&&typeof config_animal!=='undefined'){var regex=new RegExp(config_animal+'\/image\/(.*)$');matches=attrs[i].escaped.match(regex);}
if(!matches){var regex=doku_base+'data/media/';regex=regex.replace(/([\/\\])/g,"\\$1");regex='^.*?'+regex+'(.*)';regex=new RegExp(regex);matches=attrs[i].escaped.match(regex);}
if(matches&&matches[1]){src=matches[1].replace(/\//g,':');src=':'+src;}else{src=decodeURIComponent?decodeURIComponent(attrs[i].escaped):unescape(attrs[i].escaped);if(src.search(/data:image.*?;base64/)>-1){from_clipboard=true;}}
if(src&&src.match(/lib\/images\/smileys/)){this.is_smiley=true;}}
this.attr=src;if(this.attr&&this.attr.match&&this.attr.match(/%[a-fA-F0-9]{2}/)){this.attr=decodeURIComponent(safe_convert(this.attr));this.attr=decodeURIComponent(safe_convert(this.attr));}}
else if(attrs[i].name=='width'&&!style){width=attrs[i].value;}else if(attrs[i].name=='height'&&!style){height=attrs[i].value;}else if(attrs[i].name=='style'){var match=attrs[i].escaped.match(/width:\s*(\d+)/);if(match){width=match[1];var match=attrs[i].escaped.match(/height:\s*(\d+)/);if(match)
height=match[1];}}else if(attrs[i].name=='align'||attrs[i].name=='class'){if(attrs[i].escaped.match(/(center|middle)/)){img_align='center';}else if(attrs[i].escaped.match(/right/)){img_align='right';}else if(attrs[i].escaped.match(/left/)){img_align='left';}else{img_align='';}}}}
if(this.is_smiley){if(alt){results+=alt+' ';alt="";}
this.is_smiley=false;return;}
if(this.link_only)
tag='img';if(tag=='br'){if(this.in_multi_plugin){results+="\n";return;}
if(!this.code_type){HTMLParser_LBR=true;}else if(this.code_type){results+="\n";return;}
if(this.in_table){results+=HTMLParserParaInsert;return;}
if(this.list_started){results+='_LIST_EOFL_';}else{results+='\\\\  ';return;}}else if(tag.match(/^h(\d+|r)/)){var str_len=results.length;if(tag.match(/h(\d+)/)){this.in_header=true;}
if(str_len){if(results.charCodeAt(str_len-1)==32){results=results.replace(/\x20+$/,"");}}}else if(this.last_col_pipes){if(format_chars[tag])
results+=markup[tag];tag='blank';}else if(dwfck_note){results+=dwfck_note;return;}
if(tag=='b'||tag=='i'&&this.list_level){if(results.match(/(\/\/|\*)(\x20)+/)){results=results.replace(/(\/\/|\*)(\x20+)\-/,"$1\n"+"$2-");}}
if(tag=='li'&&this.list_level){if(this.list_level==1&!this.list_started){results+="\n";this.list_started=true;}
results=results.replace(/[\x20]+$/,"");for(var s=0;s<this.list_level;s++){if(results.match(/_FORMAT_SPACE_\s*$/)){results=results.replace(/_FORMAT_SPACE_\s*$/,"\n");}
if(this.list_level>1){results+='  ';}}
if(this.prev_list_level>0&&markup['li']==markup['ol']){this.prev_list_level=-1;}}
if(tag=='a'&&local_image){this.xcl_markup=true;return;}else if(tag=='a'&&(this.export_code||this.code_snippet)){return;}else if(tag=='a'&&this.footnote){tag='fn_start';}else if(tag=='a'&&bottom_note){HTMLParserTopNotes.push(this.id);}else if(tag=='a'&&this.external_mime){if(this.in_endnotes){this.link_class='media';return;}
if(media_class&&media_class=='mediafile'){results+=markup['img'];results+=this.attr+'|';this.is_mediafile=true;}
return;}else if(this.in_font){if(tag=='a'){results=results.replace(/__STYLE__/,'[['+this.attr+'|');this.in_font=false;}
return;}
if(this.in_endnotes&&tag=='a')
return;if(this.code_type&&tag=='span')
tag='blank';if(this.mfile&&!this.attr){this.attr=this.mfile;}
results+=markup[tag];if(tag=='td'||tag=='th'||(this.last_col_pipes&&this.td_align=='center')){if(this.is_rowspan){results+=markup['row_span']+' | ';this.is_rowspan=false;}
if(this.td_align=='center'||this.td_align=='right'){results+='  ';}}else if(tag=='a'&&this.attr){this.attr=this.attr.replace(/%7c/,'%257c');results+=this.attr+'|';}else if(tag=='img'){var link_type=this.image_link_type;this.image_link_type="";if(this.link_only)
link_type='link_only';if(!link_type||from_clipboard){link_type='nolink';}else if(link_type=='detail'){link_type="";}
if(link_type=='link_only'){img_size='?linkonly';}else if(link_type){img_size+=link_type+'&';}
if(width&&height){img_size+=width+'x'+height;}else if(width){img_size+=width;}else if(!link_type){img_size="";}
if(img_align&&img_align!='left'){results+='  ';}
this.attr+=img_size;if(img_align=='center'||img_align=='left'){this.attr+='  ';}
results+=this.attr+'}}';this.attr='src';}else if(tag=='pre'||tag=='pre_td'){if(this.downloadable_file)
this.attr+=' '+this.downloadable_file;if(!this.attr)
this.attr='code';results+=this.attr+'>';this.downloadable_file="";this.downloadable_code=false;}}},end:function(tag){if(format_chars[tag]&&(this.in_font||this.in_header)){results+=" ";if(tag=='sup'||tag=='sub'||tag=='del'||tag=='strike'||tag=='s'){var t='temp_c'+tag;}else
var t='temp_'+tag;results+=markup[t];results+=" ";return;}
if(this.in_endnotes&&tag=='a')
return;if(this.in_link&&format_chars[current_tag]&&this.link_formats.length){return;}else if(tag=='a'&&!this.link_formats.length)
this.in_link=false;if(this.link_only){this.link_only=false;return;}
if(!markup[tag])
return;if(tag=='sup'&&this.attr=='dwfcknote'){return;}
if(this.is_smiley){this.is_smiley=false;if(tag!='li')
return;}
if(tag=='span'&&this.in_font&&!ckgedit_xcl_styles){tag='font';var font_str='<font '+this.font_size+'/'+this.font_family+';;'+this.font_color+';;'+this.font_bgcolor+">";var inherits=font_str.match(/(inherit)/g);if(inherits&&inherits.length<3)
HTMLParserFontInfix=true;var font_start=results.lastIndexOf('__STYLE__');results=results.splice(font_start,9,font_str);results=results.replace(/_FORMAT_SPACE_<font/m,"<font");this.font_size='inherit';this.font_family='inherit';this.font_color='inherit';this.font_bgcolor='inherit';this.in_font=false;HTMLParserFont=true;results=results.replace(/__STYLE__/g,"");}
if(tag=='p'&&this.in_align&&!this.in_table){tag='align';var align_str='<align '+this.align_param+'>';var align_start=results.lastIndexOf('__ALIGN__');results=results.splice(align_start,11,align_str);results=results.replace(/_FORMAT_SPACE_<align/m,"<align");this.in_align=false;this.align_param='left';results=results.replace(/__ALIGN__/g,"");}
if(tag=='span'&&this.curid){this.curid=false;return;}
if(tag=='dl'&&this.downloadable_code){this.downloadable_code=false;return;}
if(useComplexTables&&(tag=='td'||tag=='th')){this.current_cell.text=results.substring(this.cell_start);this.current_cell.text=this.current_cell.text.replace(/:::/gm,"");this.current_cell.text=this.current_cell.text.replace(/^[\s\|\^]+/,"");}
if(tag=='a'&&(this.export_code||this.code_snippet)){this.export_code=false;this.code_snippet=false;return;}
if(this.code_type&&tag=='span')
tag='blank';var current_tag=tag;if(this.footnote){tag='fn_end';this.footnote=false;}else if(tag=='a'&&this.xcl_markup){this.xcl_markup=false;return;}else if(tag=='table'){this.in_table=false;if(useComplexTables){results=results.substring(0,this.table_start);insert_table(this.rows);}}
if(tag=='p'&&this.in_table){tag='p_insert';HTMLParser_TABLE=true;}
if(this.geshi){this.geshi=false;return;}
if(tag=='code'&&!this.list_started){if(results.match(/''\s*$/m)){results=results.replace(/''\s*$/,"\n");return;}}else if(tag=='a'&&this.attr=='src'){if(this.backup('\[\[','\{'))
return;}
if(this.end_nested){this.end_nested=false;return;}
if(tag=='ol'||tag=='ul'){this.list_level--;if(!this.list_level)
this.format_in_list=false;if(this.prev_li.length){markup['li']=this.prev_li.pop();this.end_nested=true;return;}
tag="\n\n";}else if(tag=='a'&&this.external_mime){this.external_mime=false;if(this.is_mediafile){tag='}} ';}else
return;}else if(tag=='pre'){tag=markup_end[tag];if(this.code_type){tag+=this.code_type+">";}else{var codeinx=results.lastIndexOf('code');var fileinx=results.lastIndexOf('file');if(fileinx>codeinx){this.code_type='file';}else
this.code_type='code';tag+=this.code_type+">";}
this.code_type=false;}else if(markup_end[tag]){tag=markup_end[tag];}else if(this.attr=='u'&&tag=='em'){tag='u';}else if(tag=='acronym'){}
else{tag=markup[tag];}
if(current_tag=='tr'){if(this.last_col_pipes){tag="\n";this.last_col_pipes="";}
if(this.td_rowspan&&this.rowspan_col==this.td_no+1){this.is_rowspan=false;this.last_column=this.td_no;this.td_rowspan--;tag='|'+markup['row_span']+"|\n";}}else if(current_tag=='td'||current_tag=='th'){this.last_col_pipes="";this.in_td=false;}else if(current_tag.match(/h\d+/)){this.in_header=false;}
if(markup['li']){if(results.match(/\n$/)&&!this.list_level){tag="";}}
if(this.in_endnotes&&current_tag=='sup'){return}
results+=tag;if(format_chars[current_tag]){if(this.list_level){this.format_in_list=true;HTMLFormatInList=true;}
results+=markup['format_space'];HTMLParser_FORMAT_SPACE=markup['format_space'];}
this.last_tag=current_tag;if(this.td_colspan&&!useComplexTables){if(this.td_align=='center')
results+=' ';var _colspan="|";if(current_tag=='th')
_colspan='^';var colspan=_colspan;for(var i=1;i<this.td_colspan;i++){colspan+=_colspan;}
this.last_col_pipes=colspan;results+=colspan;this.td_colspan=false;}else if(this.td_align=='center'){results+=' ';this.td_align='';}
if(current_tag=='a'&&this.link_formats.length){var end_str=results.substring(this.link_pos);var start_str=results.substring(0,this.link_pos);var start_format="";var end_format="";for(var i=0;i<this.link_formats.length;i++){var fmt=markup[this.link_formats[i]];var endfmt=markup_end[this.link_formats[i]]?markup_end[this.link_formats[i]]:fmt;start_format+=markup[this.link_formats[i]];end_format=endfmt+end_format;}
start_str+=start_format;end_str+=end_format;results=start_str+end_str;this.link_formats=new Array();this.in_link=false;}else if(current_tag=='a'){this.link_formats=new Array();this.in_link=false;}},chars:function(text){text=text.replace(/\t/g,"    ");if(text.match(/~~START_HTML_BLOCK~~/)){text=text.replace(/~~START_HTML_BLOCK~~\n*/,"~~START_HTML_BLOCK~~\n<code>\n");}
if(text.match(/~~CLOSE_HTML_BLOCK~~/)){text=text.replace(/~~CLOSE_HTML_BLOCK~~\n*/gm,"\n</code>\n\n~~CLOSE_HTML_BLOCK~~\n\n");}
if(this.interwiki){text=text.replace(String.frasl,"\/");}
if(this.interwiki&&results.match(/>\w+\s*\|$/)){this.interwiki=false;if(this.attr){results+=text;}else{results=results.replace(/>\w+\s*\|$/,'>'+text);}
return;}
if(this.in_multi_plugin){text=text.replace('&lt; ','&lt;');}
text=text.replace(/&#39;/g,"'");text=text.replace(/^(&gt;)+/,function(match,quotes){return(match.replace(/(&gt;)/g,"\__QUOTE__"));});results=results.replace(/([\/\*_])_FORMAT_SPACE_([\/\*_]{2})_FORMAT_SPACE_$/,"$1$2@@_SP_@@");if(text.match(/^&\w+;/)){results=results.replace(/_FORMAT_SPACE_\s*$/,"");}
if(this.link_only){if(text){replacement='|'+text+'}} ';results=results.replace(/\}\}\s*$/,replacement);}
return;}
if(!this.code_type){if(!this.last_col_pipes){text=text.replace(/\x20{6,}/,"   ");text=text.replace(/^(&nbsp;)+\s*$/,'_FCKG_BLANK_TD_');text=text.replace(/(&nbsp;)+/,' ');}
if(this.format_tag){if(!this.list_started||this.in_table)
text=text.replace(/^\s+/,'@@_SP_@@');}else if(this.last_tag=='a'){text=text.replace(/^\s{2,}/," ");}else if(!this.using_fonts)
text=text.replace(/^\s+/,'');if(text.match(/nowiki&gt;/)){HTMLParser_NOWIKI=true;}
if(this.format_in_list||(HTMLParserFont&&this.list_started)){text=text.replace(/^[\n\s]+$/g,'');if(text.match(/\n{2,}\s{1,}/)){text=text.replace(/\n{2,}/,"\n");}}
if(this.in_td&&!text){text="_FCKG_BLANK_TD_";this.in_td=false;}}else{text=text.replace(/&lt;\s/g,'<');text=text.replace(/\s&gt;/g,'>');var geshi=text.match(/^\s*geshi:\s+(.*)$/m);if(geshi){results=results.replace(/<(code|file)>\s*$/,'<'+"$1"+' '+geshi[1]+'>');text=text.replace(geshi[0],"");}}
if(this.attr&&this.attr=='dwfcknote'){if(text.match(/fckgL\d+/)){return;}
if(text.match(/^[\-,:;!_]/)){results+=text;}else{results+=' '+text;}
return;}
if(this.downloadable_code&&(this.export_code||this.code_snippet)){this.downloadable_file=text;return;}
if(this.last_tag=='a'&&text.match(/^[\.,;\:\!]/)){results=results.replace(/\s$/,"");}
if(this.in_header){text=text.replace(/---/g,'&mdash;');text=text.replace(/--/g,'&ndash;');}
if(this.list_started){results=results.replace(/_LIST_EOFL_\s*L_BR_K\s*$/,'_LIST_EOFL_');}
if(!this.code_type){if(!results.match(/\[\[\\\\.*?\|$/)&&!text.match(/\w:(\\(\w?))+/)){if(!text.match(/\\\\[\w\.\-\_]+\\[\w\.\-\_]+/)){text=text.replace(/([\\])/g,'%%$1%%');}
text=text.replace(/([\*])/g,'_CKG_ASTERISK_');}}
if(this.in_endnotes&&HTMLParserTopNotes.length){if(text.match(/\w/)&&!text.match(/^\s*\d\)\s*$/)){text=text.replace(/\)\s*$/,"_FN_PAREN_C_");var index=HTMLParserTopNotes.length-1;if(this.bottom_url){if(this.link_class&&this.link_class=='media'){text='{{'+this.bottom_url+'|'+text+'}}';}else
text='[['+this.bottom_url+'|'+text+']]';}
if(HTMLParserBottomNotes[HTMLParserTopNotes[index]]){text=text.replace('(','L_PARgr');text=text.replace(')','R_PARgr');HTMLParserBottomNotes[HTMLParserTopNotes[index]]+=' '+text;}else{text=text.replace('(','L_PARgr');text=text.replace(')','R_PARgr');HTMLParserBottomNotes[HTMLParserTopNotes[index]]=text;}}
this.bottom_url=false;return;}
if(text&&text.length){results+=text;}
results=results.replace(/(&\w+;)\s*([\*\/_]{2})_FORMAT_SPACE_(\w+)/,"$1$2$3");if(this.list_level&&this.list_level>1){results=results.replace(/(\[\[.*?\]\])([ ]+[\*\-].*)$/," $1\n$2");}
try{var regex=new RegExp('([\*\/\_]{2,})_FORMAT_SPACE_([\*\/\_]{2,})('+RegExp.escape(text)+')$');if(results.match(regex)){results=results.replace(regex,"$1$2$3");}}catch(ex){}
if(!HTMLParserOpenAngleBracket){if(text.match(/&lt;/)){HTMLParserOpenAngleBracket=true;}}},comment:function(text){},dbg:function(text,heading){if(text.replace){text=text.replace(/^\s+/g,"");text=text.replace(/^\n$/g,"");text=text.replace(/&/g,"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;");if(!text)
return;}
if(heading){heading='<b>'+heading+"</b>\n";}
HTMLParser_DEBUG+=heading+text+"\n__________\n";}});results=results.replace(/(\[\[\\\\)(.*?)\]\]/gm,function(match,brackets,block){block=block.replace(/\\/g,"_SMB_");return brackets+block+']]';});results=results.replace(/%%\\%%/g,'_ESC_BKSLASH_');results=results.replace(/%*\\%*([^\w]{1})%*\\%*/g,"$1");results=results.replace(/_SMB_/g,"\\");results=results.replace(/(\s*={2,}).*?CKGE_TMP_(\w+)(.*?).*?CKGE_TMP_c?\2.*?\1/gm,function(m,tag){m=m.replace(/CKGE_TMP_\w+/gm,"");var v=jQuery("#formatdel").val();if(!v){jQuery('#dw__editform').append('<input type="hidden" id="formatdel" name="formatdel" value="del" />');}
return m;});results=results.replace(/\s?(CKGE_TMP_\w+)\s?/gm,function(m,tag){if($FORMAT_SUBST[tag])
return $FORMAT_SUBST[tag];return m;});results=results.replace(/(\s*={2,})(.*?)(\[\[|\{\{)(.*?)(\]\]|\}\})(.*?)\1/gm,function(m,h_markup,whatever,bracket_1,inner,bracket_2,end_str){end_str=end_str.replace(/\[\[(.*?)\|(.*?)\]\]/g,"$2");end_str=end_str.replace(/\{\{(.*?)\|(.*?)\}\}/g,"$2");m=h_markup+" "+whatever+" "+inner.replace(/.*?\|(.*?)/,"$1")+" "+end_str+" "+h_markup;var v=jQuery("#formatdel").val();if(!v){jQuery('#dw__editform').append('<input type="hidden" id="formatdel" name="formatdel" value="del" />');}
return m;});if(id=='test'){if(!HTMLParser_test_result(results))
return;}
results=results.replace(/\{ \{ rss&gt;Feed:/mg,'{{rss&gt;http://');results=results.replace(/~ ~ (NOCACHE|NOTOC)~ ~/mg,'~~'+"$1"+'~~');if(HTML_InterWiki){var ReplaceLinkMatch=function(tag,link){tag_1=tag.replace(/oIWIKIo(.*)cIWIKIc/,"$1");if(tag_1==link)
return true;link=link.replace(/\s/,'%20');return(link==tag_1);};results=results.replace(/\[\[(\w+\.?\w{0,12})>(.*?)\|(.*?)\]\]/gm,function(match,id,iw_replace,link_text){if(iw_replace=='oIWIKIocIWIKIc')
iw_replace=link_text;if((iw_replace=='oIWIKIo'+link_text.replace(/\s/,'%20')+'cIWIKIc')||(iw_replace==link_text)||ReplaceLinkMatch(iw_replace,link_text)){link_text="";}else{link_text="|"+link_text;}
return('[['+id+'>'+iw_replace+link_text+']]');});}
results=results.replace(/>.*?oIWIKIo(.*?)cIWIKIc/mg,'>'+"$1");if(HTMLParser_FORMAT_SPACE){if(HTMLParser_COLSPAN){results=results.replace(/\s*([\|\^]+)((\W\W_FORMAT_SPACE_)+)/gm,function(match,pipes,format){format=format.replace(/_FORMAT_SPACE_/g,"");return(format+pipes);});}
results=results.replace(/&quot;/g,'"');var regex=new RegExp(HTMLParser_FORMAT_SPACE+'([\\-]{2,})',"g");results=results.replace(regex," $1");results=results.replace(/\]\](\*\*|\/\/|\'\'|__|<\/del>)_FORMAT_SPACE_/,"]]$1@@_SP_@@");var regex=new RegExp("(&amp;|\\W|\\w|\\d)(\\*\\*|\\/\\/|\\'\\'|__|<\/del>)+"+HTMLParser_FORMAT_SPACE+'(\\w|\\d)',"g");results=results.replace(regex,"$1$2$3");var regex=new RegExp(HTMLParser_FORMAT_SPACE+'@@_SP_@@',"g");results=results.replace(regex,' ');results=results.replace(/([\*\/_]{2})@@_SP_@@(&\w+;)/g,"$1 $2");results=results.replace(/\n@@_SP_@@\n/g,'');results=results.replace(/@@_SP_@@\n/g,'');results=results.replace(/@@_SP_@@/g,' ');var regex=new RegExp(HTMLParser_FORMAT_SPACE+'([^\\)\\]\\}\\{\\-\\.,;:\\!\?"\x94\x92\u201D\u2019'+"'"+'])',"g");results=results.replace(regex," $1");regex=new RegExp(HTMLParser_FORMAT_SPACE,"g");results=results.replace(regex,'');if(HTMLFormatInList){results=results.replace(/(\s+[\-\*_]\s*)([\*\/_\']{2})(.*?)(\2)([^\n]*)\n+/gm,function(match,list_type,format,text,list_type_close,rest){return(list_type+format+text+list_type_close+rest+"\n");});}}
var line_break_final="\\\\";if(HTMLParser_LBR){results=results.replace(/(L_BR_K)+/g,line_break_final);results=results.replace(/L_BR_K/gm,line_break_final);results=results.replace(/(\\\\)\s+/gm,"$1 \n");}
if(HTMLParser_PRE){results=results.replace(/\s+<\/(code|file)>/g,"\n</"+"$1"+">");if(HTMLParser_Geshi){results=results.replace(/\s+;/mg,";");results=results.replace(/&lt;\s+/mg,"<");results=results.replace(/\s+&gt;/mg,">");}}
if(HTMLParser_TABLE){results+="\n"+line_break_final+"\n";var regex=new RegExp(HTMLParserParaInsert,"g");results=results.replace(regex,' '+line_break_final+' ');results=results.replace(/(\||\^)[ ]+(\||\^)\s$/g,"$1\n");results=results.replace(/(\||\^)[ ]+(\||\^)/g,"$1");}
results=results.replace(/_FCKG_BLANK_TD_/g," ");if(HTMLParserOpenAngleBracket){results=results.replace(/\/\/&lt;\/\/\s*/g,'&lt;');}
if(HTMLParserFont)
{String.prototype.font_link_reconcile=function(v){if(v==1){regex=/\[\[(.*?)(<font[^\>]+>)([^<]+(\]\])?)[^\>]+\/font>\s*(\]\])/gm;}else
regex=/(<font[^\>\{]+>)\{\{(:?.*?)\|(:?.*?)<\/font>/gm;return(this.replace(regex,function(m,a,b,c){a=a.replace(/\n/gm,"");a=a.replace(/\s/gm,"");a=a.replace(/[\[\]\{\}]/g,"");a=a.replace(/\|/g,"");c=c.replace(/\n/gm,"");c=c.replace(/\s/gm,"");c=c.replace(/[\[\]\}\{]/g,"");if(v==1)
c='[['+a+'|'+c+']]';else
c='{{'+b+'|'+c+'}}';var val=prompt(LANG.plugins.ckgedit.font_err_1+"\n"+c+"\n"+LANG.plugins.ckgedit.font_err_2);if(val==null){if(ckgedit_to_dwedit){ckgedit_to_dwedit=false;return c;}else
throw new Error(LANG.plugins.ckgedit.font_err_throw);}
if(val)
return val;return c;}));}
if(HTMLParserFontInfix){results=results.replace(/<\/font>\s{1}/gm,"</font>");}
if(fontConflict()){if(confirm(LANG.plugins.ckgedit.font_conflict))
return;var v=jQuery("#fontdel").val();if(!v){jQuery('#dw__editform').append('<input type="hidden" id="fontdel" name="fontdel" value="del" />');}}
results=results.font_link_reconcile(1);results=results.font_link_reconcile(2);var regex=/\>\s+(\*\*|__|\/\/|'')\s+_\s+\1\s+<\/font>/gm;results=results.replace(regex,function(m){m=m.replace(/\s+/g,"");return m;});results=results.replace(/\[\[(.*?)\|(<font[^\>]+>)(.*?)(<\/font>)\s*(\]\])\s*/gm,function(match,a,b,c){match='[['+a+'|'+c+']]';var v=jQuery("#fontdel").val();if(!v){jQuery('#dw__editform').append('<input type="hidden" id="fontdel" name="fontdel" value="del" />');}
return match;});results=results.replace(/(\s*={2,})\s*(.*?)(<font[^\>]+>)(.*?)(<\/font>)(.*?)\s*\1/gm,function(match){match=match.replace(/<\/font>/g," ");match=match.replace(/<font.*?>/g," ");var v=jQuery("#formatdel").val();if(!v){jQuery('#dw__editform').append('<input type="hidden" id="formatdel" name="formatdel" value="del" />');}
return match;});}
if(HTMLParserTopNotes.length){results=results.replace(/<sup>\(\(\){2,}\s*<\/sup>/g,"");results=results.replace(/\(\(+(\d+)\)\)+/,"(($1))");for(var i in HTMLParserBottomNotes){var matches=i.match(/_(\d+)/);var pattern=new RegExp('(\<sup\>)*[\(]+'+matches[1]+'[\)]+(<\/sup>)*');HTMLParserBottomNotes[i]=HTMLParserBottomNotes[i].replace(/(\d+)_FN_PAREN_C_/,"");results=results.replace(pattern,'(('+HTMLParserBottomNotes[i].replace(/_FN_PAREN_C_/g,") ")+'))');}
results=results.replace(/<sup><\/sup>/g,"");results=results.replace(/((<sup>\(\(\d+\)\)\)?<\/sup>))/mg,function(fn){if(!fn.match(/p>\(\(\d+/)){return"";}
return fn;});}
results=results.replace(/(={3,}.*?)(\{\{.*?\}\})(.*?={3,})/g,"$1$3\n\n$2");results=results.replace(/(<sup>)*\s*\[\[\s*\]\]\s*(<\/sup>)*\n*/g,"");results=results.replace(/<sup>\s*\(\(\d+\)\)\s*<\/sup>/mg,"");if(HTMLParser_MULTI_LINE_PLUGIN){results=results.replace(/<\s+/g,'<');results=results.replace(/&lt;\s+/g,'<');}
if(HTMLParser_NOWIKI){var nowiki_escapes='%';var regex=new RegExp('(['+nowiki_escapes+'])',"g");results=results.replace(/(&lt;nowiki&gt;)(.*?)(&lt;\/nowiki&gt;)/mg,function(all,start,mid,close){mid=mid.replace(/%%(.)%%/mg,"NOWIKI_$1_");return start+mid.replace(regex,"NOWIKI_$1_")+close;});}
results=results.replace(/__SWF__(\s*)\[*/g,"{{$1");results=results.replace(/\|.*?\]*(\s*)__FWS__/g,"$1}}");results=results.replace(/(\s*)__FWS__/g,"$1}}");results=results.replace(/\n{3,}/g,'\n\n');results=results.replace(/_LIST_EOFL_/gm," "+line_break_final+" ");if(useComplexTables){if(results.indexOf('~~COMPLEX_TABLES~~')==-1){results+="~~COMPLEX_TABLES~~\n";}}
if(!useComplexTables){results=results.replace(/~~COMPLEX_TABLES~~/gm,"");}
results=results.replace(/_CKG_ASTERISK_/gm,'*');results=results.replace(/_ESC_BKSLASH_/g,'\\');if(id=='test'){if(HTMLParser_test_result(results)){alert(results);}
return;}
results=results.replace(/divalNLine/gm,"\n")
var dwform=GetE('dw__editform');dwform.elements.fck_wikitext.value=results;if(id=='bakup'){return;}
if(id){var dom=GetE(id);dom.click();return true;}}
jQuery(document).ready(function(){jQuery("#ebut_test").mousedown(function(){parse_wikitext('test');});jQuery("#ebtn__delete").click(function(){return confirm(JSINFO['confirm_delete']);});jQuery("#ebtn__delete").mouseup(function(){draft_delete();});jQuery("#ebtn__dwedit").click(function(){ckgedit_to_dwedit=true;setDWEditCookie(2,this);parse_wikitext('edbtn__save');this.form.submit();});jQuery("#ebtn__fbswitch").click(function(){if(getCookie('ckgFbOpt')=='dokuwiki'){document.cookie='ckgFbOpt=ckgedit;';}else{document.cookie='ckgFbOpt=dokuwiki;';}
parse_wikitext('edbtn__save');this.form.submit();});jQuery("#ckgedit_draft_btn").click(function(){ckgedit_get_draft();});jQuery("#backup_button").click(function(){renewLock(true);});jQuery("#revert_to_prev_btn").click(function(){revert_to_prev();});jQuery("#no_styling_btn").click(function(){this.form.styling.value="no_styles";this.form.prefix.value="";this.form.suffix.value="";this.form.rev.value="";});jQuery("#ebut_cancel").mouseup(function(){draft_delete();});jQuery("#save_button").mousedown(function(){if(!window.dwfckTextChanged&&!JSINFO['cg_rev']){ckgedit_dwedit_reject=true;parse_wikitext('ebut_cancel');}else{parse_wikitext('edbtn__save');}});});
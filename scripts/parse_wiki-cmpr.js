function parse_wikitext(C){if(ckgedit_dwedit_reject){var f=GetE("ebut_cancel");f.click();return true}var A=getComplexTables();function F(){var i=/\>\s+(\*\*|__|\/\/|'')\s+_\s+\1\s+<\/font>/gm;r=r.replace(i,function(v){v=v.replace(/\s+/g,"");return v});i=new RegExp("\\>(.*?)(\\]\\]\\<\\/font\\>)|(\\<\\/font\\>\\]\\])","gm");if(r.match(i)){return true}i=new RegExp("(\\{\\{(.*?)\\.\\w{2,4})\\|\\<font");if(r.match(i)){return true}i=new RegExp("\\{\\{(.*?)\\.\\w{2,4}\\|[:\\w\\-\\.\\s]+\\<\\/font");if(r.match(i)){return true}i=new RegExp("\\>\\{\\{(.*?)\\.\\w+\\<\\/font\\>\\b","gm");if(r.match(i)){return true}return false}function n(W,X,v){var U=new Array();for(var T=X;T<W.length;T++){for(var S=0;S<W[T].length;S++){if(W[T][S].rowspan>0){var V=W[T][S].text;U.push({row:T,column:S,spans:W[T][S].rowspan,text:V});if(!v){break}}}}return U}function E(V,v,T,U,i){var S=U[V][v].colspan?U[V][v].colspan:0;U[V][v].rowspan=0;for(N=0;N<T-1;N++){U[++V].splice(v,0,{type:"td",rowspan:0,colspan:S,prev_colspan:S,text:" ::: "})}}function z(W){var T=n(W,0,true);var v=T.length;if(!v){return false}var X=T[0].row;var S=T[0].column;E(X,S,T[0].spans,W);v--;for(var V=0;V<v;V++){X++;var U=n(W,X,false);if(U.length){E(U[0].row,U[0].column,U[0].spans,W)}}return true}function m(U){if(!A){return}for(var S=0;S<U.length;S++){if(!z(U)){break}}r+="\n";for(var S=0;S<U.length;S++){r+="\n";for(var v=0;v<U[S].length;v++){var T=U[S][v].type=="td"?"|":"^";r+=T;var W=U[S][v].align?U[S][v].align:false;if(W=="center"||W=="right"){r+="  "}r+=U[S][v].text;if(W=="center"||W=="left"){r+="  "}if(U[S][v].colspan){for(var V=0;V<U[S][v].colspan-1;V++){r+=T}}}r+="|"}}window.dwfckTextChanged=false;if(C!="bakup"){draft_delete()}var w="\nL_BR_K  \n";var H={b:"**",i:"//",em:"//",u:"__",br:w,strike:"<del>",del:"<del>",s:"<del>",p:"\n\n",a:"[[",img:"{{",strong:"**",h1:"\n====== ",h2:"\n===== ",h3:"\n==== ",h4:"\n=== ",h5:"\n== ",td:"|",th:"^",tr:" ",table:"\n\n",ol:"  - ",ul:"  * ",li:"",code:"''",pre:"\n<",hr:"\n\n----\n\n",sub:"<sub>",font:"",blockquote:"<blockquote>",sup:"<sup>",div:"\n\n",span:"\n",dl:"\n",dd:"\n",dt:"\n"};var o={del:"</del>",s:"</del>",strike:"</del>",p:" ",br:" ",a:"]]",img:"}}",h1:" ======\n",h2:" =====\n",h3:" ====\n",h4:" ===\n",h5:" ==\n",td:" ",th:" ",tr:"|\n",ol:" ",ul:" ",li:"\n",pre:"\n</",sub:"</sub>",sup:"</sup> ",div:"\n\n",p:"\n\n",font:"</font>",span:" ",blockquote:"</blockquote>"};H.temp_u="CKGE_TMP_u";H.temp_strong="CKGE_TMP_strong";H.temp_em="CKGE_TMP_em";H.temp_i="CKGE_TMP_i";H.temp_b="CKGE_TMP_b";H.temp_del="CKGE_TMP_del";H.temp_strike="CKGE_TMP_strike";H.temp_code="CKGE_TMP_code";H.temp_sup="CKGE_TMP_sup";H.temp_csup="CKGE_TMP_csup";H.temp_sub="CKGE_TMP_sub";H.temp_csub="CKGE_TMP_csub";H.temp_del="CKGE_TMP_del";H.temp_cdel="CKGE_TMP_cdel";H.temp_strike="CKGE_TMP_del";H.temp_cstrike="CKGE_TMP_cdel";H.temp_s="CKGE_TMP_del";H.temp_cs="CKGE_TMP_cdel";var l={CKGE_TMP_b:"**",CKGE_TMP_strong:"**",CKGE_TMP_em:"//",CKGE_TMP_u:"__",CKGE_TMP_sup:"<sup>",CKGE_TMP_sub:"<sub>",CKGE_TMP_cdel:"</del>",CKGE_TMP_csub:"</sub>",CKGE_TMP_csup:"</sup>",CKGE_TMP_del:"<del>",CKGE_TMP_strike:"<del>",CKGE_TMP_code:"''"};H.blank="";H.fn_start="((";H.fn_end="))";H.row_span=":::";H.p_insert="_PARA__TABLE_INS_";H.format_space="_FORMAT_SPACE_";H.pre_td="<";var t={strong:true,b:true,i:true,em:true,u:true,del:true,strike:true,code:true,sup:true,sub:true,s:true};var r="";var R=false;var s=false;var b=false;var M=false;var h=false;var K=false;var O=false;var L=false;var g=false;var J=false;var q=false;var Q=false;HTMLLinkInList=false;var P=false;var B;var c=new Array();var y=new Array();var e=false;var d=H.p_insert;var I="(br|co|coMULTI|es|kw|me|nu|re|st|sy)[0-9]";String.prototype.splice=function(i,S,v){return(this.slice(0,i)+v+this.slice(i+Math.abs(S)))};String.frasl=new RegExp("⁄|&frasl;|&#8260;|&#x2044;","g");I=new RegExp(I);HTMLParser(CKEDITOR.instances.wiki__text.getData(),{attribute:"",link_title:"",link_class:"",image_link_type:"",td_align:"",in_td:false,td_colspan:0,td_rowspan:0,rowspan_col:0,last_column:-1,row:0,col:0,td_no:0,tr_no:0,current_row:false,in_table:false,in_multi_plugin:false,is_rowspan:false,list_level:0,prev_list_level:-1,list_started:false,xcl_markup:false,in_link:false,link_formats:new Array(),last_tag:"",code_type:false,in_endnotes:false,is_smiley:false,geshi:false,downloadable_code:false,export_code:false,code_snippet:false,downloadable_file:"",external_mime:false,in_header:false,curid:false,format_in_list:false,prev_li:new Array(),link_only:false,in_font:false,using_fonts:false,interwiki:false,bottom_url:false,font_family:"inherit",font_size:"inherit",font_weight:"inherit",font_color:"inherit",font_bgcolor:"inherit",font_style:"inherit",is_mediafile:false,end_nested:false,mfile:false,backup:function(T,S){var V=r.lastIndexOf(T);var v=r.indexOf(S,V);if(V==-1||v==-1){return}if(T.length+v==v){var U=r.substring(0,V);var i=r.substring(v);r=U+i;return true}return false},is_iwiki:function(S,U){var T=S.match(/iw_(\w+\.?\w{0,12})/);var i=U.split(/\/\//);var v=i[i.length-1];if(!v.match(/oIWIKIo.*?cIWIKIc/)){v="oIWIKIo"+v+"cIWIKIc"}v=v.replace(/^.*?oIWIKIo/,"oIWIKIo");v=v.replace(/cIWIKIc.*/,"cIWIKIc");T[1]=T[1].replace(/_(\w{2})/g,".$1");this.attr=T[1]+">"+decodeURIComponent(v);q=true;this.interwiki=true},start:function(aw,aa,ak){if(H[aw]){if(t[aw]&&this.in_link){this.link_formats.push(aw);return}if(t[aw]&&(this.in_font||this.in_header)){r+=" ";var ar="temp_"+aw;r+=H[ar];r+=" ";return}else{if(aw=="acronym"){return}}if(t[aw]&&this.in_endnotes){if(aw=="sup"){return}}if(aw=="ol"||aw=="ul"){if(this.in_table){o.li="\\\\";jQuery("#dw__editform").append('<input type="hidden" id="linkintbl" name="linkintbl" value="del" />')}else{o.li="\n"}this.prev_list_level=this.list_level;this.list_level++;if(this.list_level==1){this.list_started=false}if(this.list_started){this.prev_li.push(H.li)}H.li=H[aw];return}else{if(!this.list_level){H.li="";this.prev_li=new Array()}}this.is_mediafile=false;if(aw=="img"){var av="?";var v;var T;var ax=false;var ai="";var ad="";var aj=false;this.is_smiley=false;this.in_link=false}if(aw=="a"){var ah=true;var aD="";this.xcl_markup=false;this.in_link=true;this.link_pos=r.length;this.link_formats=new Array();this.footnote=false;var ab=false;this.id="";this.external_mime=false;var aC=false;this.export_code=false;this.code_snippet=false;this.downloadable_file="";var ag=false;this.link_only=false;save_url="";this.interwiki=false;this.bottom_url=false;this.link_title=false;var ap="";var ae=""}if(aw=="p"){this.in_link=false;if(this.in_table){aw="p_insert";M=true}}if(aw=="table"){this.td_no=0;this.tr_no=0;this.in_table=true;this.is_rowspan=false;this.row=-1;this.rows=new Array();B=this.rows;this.table_start=r.length}else{if(aw=="tr"){this.tr_no++;this.td_no=0;this.col=-1;this.row++;this.rows[this.row]=new Array();this.current_row=this.rows[this.row]}else{if(aw=="td"||aw=="th"){this.td_no++;this.col++;this.current_row[this.col]={type:aw,rowspan:0,colspan:0,text:""};this.cell_start=r.length;this.current_cell=this.current_row[this.col];if(this.td_rowspan&&this.rowspan_col==this.td_no&&this.td_no!=this.last_column){this.is_rowspan=true;this.td_rowspan--}else{this.is_rowspan=false}}}}var S;this.attr=false;this.format_tag=false;if(t[aw]){this.format_tag=true}var ac=false;for(var aA=0;aA<aa.length;aA++){if(aw=="td"||aw=="th"){if(aa[aA].name=="colspan"){this.current_row[this.col].colspan=aa[aA].value}if(aa[aA].name=="class"){if((S=aa[aA].value.match(/(left|center|right)/))){this.current_row[this.col].align=S[1]}}if(aa[aA].name=="rowspan"){this.current_row[this.col].rowspan=aa[aA].value}}if(aa[aA].escaped=="u"&&aw=="em"){aw="u";this.attr="u";break}if(aw=="div"){if(aa[aA].name=="class"&&aa[aA].value=="footnotes"){aw="blank";this.in_endnotes=true}break}if(aw=="dl"&&aa[aA].name=="class"&&aa[aA].value=="file"){this.downloadable_code=true;b=true;return}if(aw=="span"&&aa[aA].name=="class"){if(aa[aA].value=="np_break"){return}}if(aw=="span"&&aa[aA].name=="class"){if(aa[aA].value=="curid"){this.curid=true;return}if(aa[aA].value=="multi_p_open"){this.in_multi_plugin=true;O=true;return}if(aa[aA].value=="multi_p_close"){this.in_multi_plugin=false;return}if(aa[aA].value.match(I)){aw="blank";this.geshi=true;break}}if(aw=="span"&&!ckgedit_xcl_styles){if(aa[aA].name=="style"){if(!this.in_font){r+="__STYLE__"}this.in_font=true;this.using_fonts=true;S=aa[aA].value.match(/font-family:\s*([\w\-\s,]+);?/);if(S){this.font_family=S[1]}S=aa[aA].value.match(/font-size:\s*(.*)/);if(S){S[1]=S[1].replace(/;/,"");this.font_size=S[1]}S=aa[aA].value.match(/font-weight:\s*(\w+);?/);if(S){this.font_weight=S[1]}S=aa[aA].value.match(/.*?color:\s*(.*)/);var ao=false;if(S){S[1]=S[1].replace(/;/,"");if(S[0].match(/background/)){this.font_bgcolor=S[1]}else{this.font_color=S[1]}}if(!ao){S=aa[aA].value.match(/background:\s*(\w+)/);if(S&&S[0].match(/background/)){this.font_bgcolor=S[1]}}}}if(aw=="td"||aw=="th"){if(aw=="td"){r=r.replace(/\^$/,"|")}this.in_td=true;if(aa[aA].name=="align"){this.td_align=aa[aA].escaped}else{if(aa[aA].name=="class"){S=aa[aA].value.match(/\s*(\w+)align/);if(S){this.td_align=S[1]}}else{if(aa[aA].name=="colspan"){h=true;this.td_colspan=aa[aA].escaped}else{if(aa[aA].name=="rowspan"){this.td_rowspan=aa[aA].escaped-1;this.rowspan_col=this.td_no}}}}M=true}if(aw=="a"){if(aa[aA].name=="title"){this.link_title=aa[aA].escaped;if(ae){ap=aa[aA].escaped}else{this.link_title=this.link_title.replace(/\s+.*$/,"")}}else{if(aa[aA].name=="class"){if(aa[aA].value.match(/fn_top/)){this.footnote=true}else{if(aa[aA].value.match(/fn_bot/)){ab=true}else{if(aa[aA].value.match(/mf_(png|gif|jpg|jpeg)/i)){this.link_only=true}else{if(aa[aA].value.match(/interwiki/)){aa[aA].value=aa[aA].value.replace(/\./g,"_");this.link_class=aa[aA].value;continue}}}}this.link_class=aa[aA].escaped;aC=this.link_class.match(/mediafile/)}else{if(aa[aA].name=="id"){this.id=aa[aA].value}else{if(aa[aA].name=="type"){aD=aa[aA].value}else{if(aa[aA].name=="href"&&!this.code_type){var Z=aa[aA].escaped.match(/https*:\/\//)?true:false;if(Z){save_url=aa[aA].escaped}if(aa[aA].escaped.match(/\/lib\/exe\/detail.php/)){this.image_link_type="detail"}else{if(aa[aA].escaped.match(/exe\/fetch.php/)){this.image_link_type="direct"}}if(this.link_class&&this.link_class.match(/media/)&&!this.link_title){var am=aa[aA].escaped.match(/media=(.*)/);if(am){this.link_title=am[1]}}var au=aa[aA].escaped.match(/fetch\.php.*?media=.*?\.(png|gif|jpg|jpeg)$/i);if(au){au=au[1]}if(aa[aA].escaped.match(/^https*:/)){this.attr=aa[aA].escaped;ah=false}if(aa[aA].escaped.match(/^ftp:/)){this.attr=aa[aA].escaped;ah=false}else{if(aa[aA].escaped.match(/do=export_code/)){this.export_code=true}else{if(aa[aA].escaped.match(/^nntp:/)){this.attr=aa[aA].escaped;ah=false}else{if(aa[aA].escaped.match(/^mailto:/)){this.attr=aa[aA].escaped.replace(/mailto:/,"");ah=false}else{if(aa[aA].escaped.match(/m-files/)){this.attr=aa[aA].escaped;this.mfile=aa[aA].escaped;ah=false}else{if(aa[aA].escaped.match(/^file:/)){var U=aa[aA].value.replace(/file:[\/]+/,"");U=U.replace(/[\/]/g,"\\");U="\\\\"+U;this.attr=U;ah=false}else{if(Z&&!au&&(S=aa[aA].escaped.match(/fetch\.php(.*)/))){if(S[1].match(/media=/)){Y=S[1].split(/=/);this.attr=Y[1]}else{S[1]=S[1].replace(/^\//,"");this.attr=S[1]}if(typeof config_animal!=="undefined"){var V=new RegExp(config_animal+"/file/(.*)");S=aa[aA].escaped.match(V);if(S&&S[1]){this.attr=S[1]}if(this.attr){this.attr=this.attr.replace(/\//g,":")}}ah=false;this.attr=decodeURIComponent?decodeURIComponent(this.attr):unescape(this.attr);if(!this.attr.match(/^:/)){this.attr=":"+this.attr}this.external_mime=true}else{ah=false;S=aa[aA].escaped.match(/doku.php\?id=(.*)/);if(S&&save_url){var an=DOKU_BASE+"doku.php";if(!aa[aA].escaped.match(an)){this.link_class=="urlextern";this.attr=save_url;S=null}}if(!S){S=aa[aA].escaped.match(/doku.php\/(.*)/)}if(S){if(!S[1].match(/\?/)&&S[1].match(/&amp;/)){ag=true;S[1]=S[1].replace(/&amp;/,"?")}}if(S&&S[1]){if(!S[1].match(/^:/)){this.attr=":"+S[1]}else{this.attr=S[1]}if(this.attr.match(/\.\w+$/)){if(aD&&aD=="other_mime"){this.external_mime=true}else{for(var ay=aA+1;ay<aa.length;ay++){if(aa[ay].value.match(/other_mime/)){this.external_mime=true}break}}}}else{S=aa[aA].value.match(/\\\\/);if(S){this.attr=aa[aA].escaped;ah=false}}}}}}}}}if(this.link_class=="media"){if(aa[aA].value.match(/http:/)){ah=false}}if(!this.attr&&this.link_title){if(S=this.link_class.match(/media(.*)/)){this.link_title=decodeURIComponent(safe_convert(this.link_title));this.attr=this.link_title;var az=S[1].split(/_/);if(az&&az[1]){au=az[1]}else{if(az){au=az[0]}else{au="mf"}}if(!this.attr.match(/^:/)&&!this.attr.match(/^https?\:/)){this.attr=":"+this.attr.replace(/^\s+/,"")}this.external_mime=true;ah=false}}if(this.attr.match&&this.attr.match(/%[a-fA-F0-9]{2}/)&&(S=this.attr.match(/userfiles\/file\/(.*)/))){S[1]=S[1].replace(/\//g,":");if(!S[1].match(/^:/)){S[1]=":"+S[1]}this.attr=decodeURIComponent?decodeURIComponent(S[1]):unescape(S[1]);this.attr=decodeURIComponent?decodeURIComponent(this.attr):unescape(this.attr);this.external_mime=true}else{if(this.attr&&this.attr.match(/%[a-fA-F0-9]{2}/)){this.attr=decodeURIComponent(this.attr);this.attr=decodeURIComponent(this.attr)}}if(this.link_title&&this.link_title.match(/Snippet/)){this.code_snippet=true}if(aa[aA].value.match(/^#/)&&this.link_class.match(/wikilink/)){this.attr=aa[aA].value;this.link_title=false}if(this.link_class.match(/wikilink/)&&this.link_title){this.external_mime=false;if(!this.attr){this.attr=this.link_title}if(!this.attr.match(/^:/)){this.attr=":"+this.attr}if(this.attr.match(/\?.*?=/)){var Y=this.attr.split(/\?/);Y[0]=Y[0].replace(/\//g,":");this.attr=Y[0]+"?"+Y[1]}else{this.attr=this.attr.replace(/\//g,":")}if(!ag&&aa[aA].name=="href"){if(!this.attr.match(/\?.*?=/)&&!aa[aA].value.match(/doku.php/)){var aB=aa[aA].value.match(/(\?.*)$/);if(aB&&aB[1]){this.attr+=aB[1]}}}}else{if(this.link_class.match(/mediafile/)&&this.link_title&&!this.attr){this.attr=this.link_title;this.external_mime=true;if(!this.attr.match(/^:/)){this.attr=":"+this.attr}}else{if(this.link_class.match(/interwiki/)){ae=this.link_class}}}if(this.link_class=="urlextern"&&!this.mfile&&save_url){this.attr=save_url;this.external_mime=false}if(this.in_endnotes){if(this.link_title){this.bottom_url=this.link_title}else{if(this.attr){this.bottom_url=this.attr}}}this.link_title="";this.link_class=""}}}}}}if(ae&&ap){this.is_iwiki(ae,ap);ae="";ap=""}if(aw=="sup"){if(aa[aA].name=="class"){S=aa[aA].value.split(/\s+/);if(S[0]=="dwfcknote"){this.attr=S[0];aw="blank";if(oDokuWiki_FCKEditorInstance.oinsertHtmlCodeObj.notes[S[1]]){ac="(("+oDokuWiki_FCKEditorInstance.oinsertHtmlCodeObj.notes[S[1]]+"))"}break}}}if(aw=="pre"){if(aa[aA].name=="class"){var Y=aa[aA].escaped.split(/\s+/);if(Y.length>1){this.attr=aa[aA].value;this.code_type=Y[0]}else{this.attr=aa[aA].escaped;this.code_type=this.attr}if(this.downloadable_code){this.attr=this.attr.replace(/\s*code\s*/,"");this.code_type="file"}s=true;if(this.in_table){aw="pre_td"}break}}else{if(aw=="img"){if(aa[aA].name=="alt"){ad=aa[aA].value}if(aa[aA].name=="type"){this.image_link_type=aa[aA].value}if(aa[aA].name=="src"){var al="";if(S=aa[aA].escaped.match(/fetch\.php.*?(media=.*)/)){var Y=S[1].split("=");al=Y[1];if(S=aa[aA].escaped.match(/(media.*)/)){var Y=S[1].split("=");var W=Y[1];al=decodeURIComponent?decodeURIComponent(W):unescape(W)}if(!al.match(/https?:/)&&!al.match(/^:/)){al=":"+al}}else{if(aa[aA].escaped.match(/https?:\/\//)){al=aa[aA].escaped;al=al.replace(/\?.*?$/,"")}else{if(S=aa[aA].escaped.match(/\/_media\/(.*)/)){var Y=S[1].split(/\?/);al=Y[0];al=al.replace(/\//g,":");if(!al.match(/^:/)){al=":"+al}}else{if(S=aa[aA].escaped.match(/\/lib\/exe\/fetch.php\/(.*)/)){var Y=S[1].split(/\?/);al=Y[0];if(!al.match(/^:/)){al=":"+al}}else{S=aa[aA].escaped.match(/^.*?\/userfiles\/image\/(.*)/);if(!S&&typeof config_animal!=="undefined"){var V=new RegExp(config_animal+"/image/(.*)$");S=aa[aA].escaped.match(V)}if(!S){var V=doku_base+"data/media/";V=V.replace(/([\/\\])/g,"\\$1");V="^.*?"+V+"(.*)";V=new RegExp(V);S=aa[aA].escaped.match(V)}if(S&&S[1]){al=S[1].replace(/\//g,":");al=":"+al}else{al=decodeURIComponent?decodeURIComponent(aa[aA].escaped):unescape(aa[aA].escaped);if(al.search(/data:image.*?;base64/)>-1){aj=true}}}}}}if(al&&al.match(/lib\/images\/smileys/)){this.is_smiley=true}this.attr=al;if(this.attr&&this.attr.match&&this.attr.match(/%[a-fA-F0-9]{2}/)){this.attr=decodeURIComponent(safe_convert(this.attr));this.attr=decodeURIComponent(safe_convert(this.attr))}}else{if(aa[aA].name=="width"&&!ax){v=aa[aA].value}else{if(aa[aA].name=="height"&&!ax){T=aa[aA].value}else{if(aa[aA].name=="style"){var X=aa[aA].escaped.match(/width:\s*(\d+)/);if(X){v=X[1];var X=aa[aA].escaped.match(/height:\s*(\d+)/);if(X){T=X[1]}}}else{if(aa[aA].name=="align"||aa[aA].name=="class"){if(aa[aA].escaped.match(/(center|middle)/)){ai="center"}else{if(aa[aA].escaped.match(/right/)){ai="right"}else{if(aa[aA].escaped.match(/left/)){ai="left"}else{ai=""}}}}}}}}}}}if(this.is_smiley){if(ad){r+=ad+" ";ad=""}this.is_smiley=false;return}if(this.link_only){aw="img"}if(aw=="br"){if(this.in_multi_plugin){r+="\n";return}if(!this.code_type){R=true}else{if(this.code_type){r+="\n";return}}if(this.in_table){r+=d;return}if(this.list_started){r+="_LIST_EOFL_"}else{r+="\\\\  ";return}}else{if(aw.match(/^h(\d+|r)/)){var af=r.length;if(aw.match(/h(\d+)/)){this.in_header=true}if(af){if(r.charCodeAt(af-1)==32){r=r.replace(/\x20+$/,"")}}}else{if(this.last_col_pipes){if(t[aw]){r+=H[aw]}aw="blank"}else{if(ac){r+=ac;return}}}}if(aw=="b"||aw=="i"&&this.list_level){if(r.match(/(\/\/|\*)(\x20)+/)){r=r.replace(/(\/\/|\*)(\x20+)\-/,"$1\n$2-")}}if(this.in_table&&aw=="li"){}if(aw=="li"&&this.list_level){if(this.list_level==1&!this.list_started){r+="\n";this.list_started=true}r=r.replace(/[\x20]+$/,"");for(var at=0;at<this.list_level;at++){if(r.match(/_FORMAT_SPACE_\s*$/)){r=r.replace(/_FORMAT_SPACE_\s*$/,"\n")}if(this.list_level>1){r+="  "}}if(this.prev_list_level>0&&H.li==H.ol){this.prev_list_level=-1}}if(aw=="a"&&this.list_level){HTMLLinkInList=true}if(aw=="a"&&ah){this.xcl_markup=true;return}else{if(aw=="a"&&(this.export_code||this.code_snippet)){return}else{if(aw=="a"&&this.footnote){aw="fn_start"}else{if(aw=="a"&&ab){c.push(this.id)}else{if(aw=="a"&&this.external_mime){if(this.in_endnotes){this.link_class="media";return}if(aC&&aC=="mediafile"){r+=H.img;r+=this.attr+"|";this.is_mediafile=true}return}else{if(this.in_font){if(aw=="a"){r=r.replace(/__STYLE__/,"[["+this.attr+"|");this.in_font=false}return}}}}}}if(this.in_endnotes&&aw=="a"){return}if(this.code_type&&aw=="span"){aw="blank"}if(this.mfile&&!this.attr){this.attr=this.mfile}r+=H[aw];if(aw=="td"||aw=="th"||(this.last_col_pipes&&this.td_align=="center")){if(this.is_rowspan){r+=H.row_span+" | ";this.is_rowspan=false}if(this.td_align=="center"||this.td_align=="right"){r+="  "}}else{if(aw=="a"&&this.attr){this.attr=this.attr.replace(/%7c/,"%257c");r+=this.attr+"|"}else{if(aw=="img"){var aq=this.image_link_type;this.image_link_type="";if(this.link_only){aq="link_only"}if(!aq||aj){aq="nolink"}else{if(aq=="detail"){aq=""}}if(aq=="link_only"){av="?linkonly"}else{if(aq){av+=aq+"&"}}if(v&&T){av+=v+"x"+T}else{if(v){av+=v}else{if(!aq){av=""}}}if(ai&&ai!="left"){r+="  "}this.attr+=av;if(ai=="center"||ai=="left"){this.attr+="  "}if(ad){r+=this.attr+"|"+ad+"}}"}else{r+=this.attr+"}}"}this.attr="src"}else{if(aw=="pre"||aw=="pre_td"){if(this.downloadable_file){this.attr+=" "+this.downloadable_file}if(!this.attr){this.attr="code"}r+=this.attr+">";this.downloadable_file="";this.downloadable_code=false}}}}}},end:function(ah){if(t[ah]&&(this.in_font||this.in_header)){r+=" ";if(ah=="sup"||ah=="sub"||ah=="del"||ah=="strike"||ah=="s"){var ag="temp_c"+ah}else{var ag="temp_"+ah}r+=H[ag];r+=" ";return}if(this.in_endnotes&&ah=="a"){return}if(this.in_link&&t[ad]&&this.link_formats.length){return}else{if(ah=="a"&&!this.link_formats.length){this.in_link=false}}if(this.link_only){this.link_only=false;return}if(!H[ah]){return}if(ah=="sup"&&this.attr=="dwfcknote"){return}if(this.is_smiley){this.is_smiley=false;if(ah!="li"){return}}if(ah=="span"&&this.in_font&&!ckgedit_xcl_styles){ah="font";var ab="<font "+this.font_size+"/"+this.font_family+";;"+this.font_color+";;"+this.font_bgcolor+">";var ae=ab.match(/(inherit)/g);if(ae&&ae.length<3){P=true}var X=r.lastIndexOf("__STYLE__");r=r.splice(X,9,ab);r=r.replace(/_FORMAT_SPACE_<font/m,"<font");this.font_size="inherit";this.font_family="inherit";this.font_color="inherit";this.font_bgcolor="inherit";this.in_font=false;Q=true;r=r.replace(/__STYLE__/g,"")}if(ah=="span"&&this.curid){this.curid=false;return}if(ah=="dl"&&this.downloadable_code){this.downloadable_code=false;return}if(A&&(ah=="td"||ah=="th")){this.current_cell.text=r.substring(this.cell_start);this.current_cell.text=this.current_cell.text.replace(/:::/gm,"");this.current_cell.text=this.current_cell.text.replace(/^[\s\|\^]+/,"")}if(ah=="a"&&(this.export_code||this.code_snippet)){this.export_code=false;this.code_snippet=false;return}if(this.code_type&&ah=="span"){ah="blank"}var ad=ah;if(this.footnote){ah="fn_end";this.footnote=false}else{if(ah=="a"&&this.xcl_markup){this.xcl_markup=false;return}else{if(ah=="table"){this.in_table=false;if(A){r=r.substring(0,this.table_start);m(this.rows)}}}}if(ah=="p"&&this.in_table){ah="p_insert";M=true}if(this.geshi){this.geshi=false;return}if(ah=="code"&&!this.list_started){if(r.match(/''\s*$/m)){r=r.replace(/''\s*$/,"\n");return}}else{if(ah=="a"&&this.attr=="src"){if(this.backup("[[","{")){return}}}if(this.end_nested){this.end_nested=false;return}if((ah=="ol"||ah=="ul")&&!this.in_table){this.list_level--;if(!this.list_level){this.format_in_list=false}if(this.prev_li.length){H.li=this.prev_li.pop();this.end_nested=true;return}ah="\n\n"}else{if(ah=="a"&&this.external_mime){this.external_mime=false;if(this.is_mediafile){ah="}} "}else{return}}else{if(ah=="pre"){ah=o[ah];if(this.code_type){ah+=this.code_type+">"}else{var S=r.lastIndexOf("code");var U=r.lastIndexOf("file");if(U>S){this.code_type="file"}else{this.code_type="code"}ah+=this.code_type+">"}this.code_type=false}else{if(o[ah]){ah=o[ah]}else{if(this.attr=="u"&&ah=="em"){ah="u"}else{if(ah=="acronym"){}else{ah=H[ah]}}}}}}if(ad=="tr"){if(this.last_col_pipes){ah="\n";this.last_col_pipes=""}if(this.td_rowspan&&this.rowspan_col==this.td_no+1){this.is_rowspan=false;this.last_column=this.td_no;this.td_rowspan--;ah="|"+H.row_span+"|\n"}}else{if(ad=="td"||ad=="th"){this.last_col_pipes="";this.in_td=false}else{if(ad.match(/h\d+/)){this.in_header=false}}}if(H.li){if(r.match(/\n$/)&&!this.list_level){ah=""}}if(this.in_endnotes&&ad=="sup"){return}r+=ah;if(t[ad]){if(this.list_level){this.format_in_list=true;g=true}r+=H.format_space;K=H.format_space}this.last_tag=ad;if(this.td_colspan&&!A){if(this.td_align=="center"){r+=" "}var T="|";if(ad=="th"){T="^"}var W=T;for(var Y=1;Y<this.td_colspan;Y++){W+=T}this.last_col_pipes=W;r+=W;this.td_colspan=false}else{if(this.td_align=="center"){r+=" ";this.td_align=""}}if(ad=="a"&&this.link_formats.length){var af=r.substring(this.link_pos);var Z=r.substring(0,this.link_pos);var v="";var ac="";for(var Y=0;Y<this.link_formats.length;Y++){var V=H[this.link_formats[Y]];var aa=o[this.link_formats[Y]]?o[this.link_formats[Y]]:V;v+=H[this.link_formats[Y]];ac=aa+ac}Z+=v;af+=ac;r=Z+af;this.link_formats=new Array();this.in_link=false}else{if(ad=="a"){this.link_formats=new Array();this.in_link=false}}},chars:function(U){U=U.replace(/\t/g,"    ");if(this.code_type=="code"){U=U.replace(/(\n?|\s+)\\/gm,"$1CBL__Bksl")}if(U.match(/~~START_HTML_BLOCK~~/)){U=U.replace(/~~START_HTML_BLOCK~~\n*/,"~~START_HTML_BLOCK~~\n<code>\n")}if(U.match(/~~CLOSE_HTML_BLOCK~~/)){U=U.replace(/~~CLOSE_HTML_BLOCK~~\n*/gm,"\n</code>\n\n~~CLOSE_HTML_BLOCK~~\n\n")}if(this.interwiki){}if(this.interwiki&&r.match(/>\w+\s*\|$/)){this.interwiki=false;if(this.attr){r+=U}else{r=r.replace(/>\w+\s*\|$/,">"+U)}return}if(this.in_multi_plugin){U=U.replace("&lt; ","&lt;")}U=U.replace(/&#39;/g,"'");U=U.replace(/^(&gt;)+/,function(W,V){return(W.replace(/(&gt;)/g,"__QUOTE__"))});U=U.replace(/&not;ags/g,"&notags");r=r.replace(/([\/\*_])_FORMAT_SPACE_([\/\*_]{2})_FORMAT_SPACE_$/,"$1$2@@_SP_@@");if(U.match(/^&\w+;/)){r=r.replace(/_FORMAT_SPACE_\s*$/,"")}if(this.link_only){if(U){replacement="|"+U+"}} ";r=r.replace(/\}\}\s*$/,replacement)}return}if(!this.code_type){if(!this.last_col_pipes){U=U.replace(/\x20{6,}/,"   ");U=U.replace(/^(&nbsp;)+\s*$/,"_FCKG_BLANK_TD_");U=U.replace(/(&nbsp;)+/," ")}if(this.format_tag){if(!this.list_started||this.in_table){U=U.replace(/^\s+/,"@@_SP_@@")}}else{if(this.last_tag=="a"){U=U.replace(/^\s{2,}/," ")}else{if(!this.using_fonts){U=U.replace(/^\s+/,"")}}}if(U.match(/nowiki&gt;/)){L=true}if(this.format_in_list||(Q&&this.list_started)){U=U.replace(/^[\n\s]+$/g,"");if(U.match(/\n{2,}\s{1,}/)){U=U.replace(/\n{2,}/,"\n")}}if(this.in_td&&!U){this.in_td=false}}else{U=U.replace(/&lt;\s/g,"<");U=U.replace(/\s&gt;/g,">");var i=U.match(/^\s*geshi:\s+(.*)$/m);if(i){r=r.replace(/<(code|file)>\s*$/,"<$1 "+i[1]+">");U=U.replace(i[0],"")}}if(this.attr&&this.attr=="dwfcknote"){if(U.match(/fckgL\d+/)){return}if(U.match(/^[\-,:;!_]/)){r+=U}else{r+=" "+U}return}if(this.downloadable_code&&(this.export_code||this.code_snippet)){this.downloadable_file=U;return}if(this.last_tag=="a"&&U.match(/^[\.,;\:\!]/)){r=r.replace(/\s$/,"")}if(this.in_header){U=U.replace(/---/g,"&mdash;");U=U.replace(/--/g,"&ndash;")}if(this.list_started){r=r.replace(/_LIST_EOFL_\s*L_BR_K\s*$/,"_LIST_EOFL_")}if(!this.code_type){if(!r.match(/\[\[\\\\.*?\|$/)&&!U.match(/\w:(\\(\w?))+/)){if(!U.match(/\\\\[\w\.\-\_]+\\[\w\.\-\_]+/)){U=U.replace(/([\\])/g,"%%$1%%")}U=U.replace(/([\*])/g,"_CKG_ASTERISK_")}}if(this.in_endnotes&&c.length){if(U.match(/\w/)&&!U.match(/^\s*\d\)\s*$/)){U=U.replace(/\)\s*$/,"_FN_PAREN_C_");var v=c.length-1;if(this.bottom_url){if(this.link_class&&this.link_class=="media"){U="{{"+this.bottom_url+"|"+U+"}}"}else{U="[["+this.bottom_url+"|"+U+"]]"}}if(y[c[v]]){U=U.replace("(","L_PARgr");U=U.replace(")","R_PARgr");y[c[v]]+=" "+U}else{U=U.replace("(","L_PARgr");U=U.replace(")","R_PARgr");y[c[v]]=U}}this.bottom_url=false;return}if(U&&U.length){r+=U}r=r.replace(/(&\w+;)\s*([\*\/_]{2})_FORMAT_SPACE_(\w+)/,"$1$2$3");if(this.list_level&&this.list_level>1){r=r.replace(/(\[\[.*?\]\])([ ]+[\*\-].*)$/," $1\n$2")}try{var T=new RegExp("([*/_]{2,})_FORMAT_SPACE_([*/_]{2,})("+RegExp.escape(U)+")$");if(r.match(T)){r=r.replace(T,"$1$2$3")}}catch(S){}if(!e){if(U.match(/&lt;/)){e=true}}},comment:function(i){},dbg:function(v,i){if(v.replace){v=v.replace(/^\s+/g,"");v=v.replace(/^\n$/g,"");v=v.replace(/&/g,"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;");if(!v){return}}if(i){i="<b>"+i+"</b>\n"}HTMLParser_DEBUG+=i+v+"\n__________\n"}});r=r.replace(/(\[\[\\\\)(.*?)\]\]/gm,function(i,S,v){v=v.replace(/\\/g,"_SMB_");return S+v+"]]"});r=r.replace(/%%\\%%/g,"_ESC_BKSLASH_");r=r.replace(/%*\\%*([^\w\\]{1})%*\\%*/g,"$1");r=r.replace(/_SMB_/g,"\\");r=r.replace(/(\s*={2,}).*?CKGE_TMP_(\w+)(.*?).*?CKGE_TMP_c?\2.*?\1/gm,function(S,i){S=S.replace(/CKGE_TMP_\w+/gm,"");var T=jQuery("#formatdel").val();if(!T){jQuery("#dw__editform").append('<input type="hidden" id="formatdel" name="formatdel" value="del" />')}return S});r=r.replace(/\s?(CKGE_TMP_\w+)\s?/gm,function(v,i){if(l[i]){return l[i]}return v});r=r.replace(/(\s*={2,})(.*?)(\[\[|\{\{)(.*?)(\]\]|\}\})(.*?)\1/gm,function(i,S,Y,W,U,V,X){X=X.replace(/\[\[(.*?)\|(.*?)\]\]/g,"$2");X=X.replace(/\{\{(.*?)\|(.*?)\}\}/g,"$2");i=S+" "+Y+" "+U.replace(/.*?\|(.*?)/,"$1")+" "+X+" "+S;var T=jQuery("#formatdel").val();if(!T){jQuery("#dw__editform").append('<input type="hidden" id="formatdel" name="formatdel" value="del" />')}return i});if(C=="test"){if(!HTMLParser_test_result(r)){return}}r=r.replace(/\{ \{ rss&gt;Feed:/mg,"{{rss&gt;http://");r=r.replace(/\{ \{ rss&gt;sFeed:/mg,"{{rss&gt;https://");r=r.replace(/~ ~ (NOCACHE|NOTOC)~ ~/mg,"~~$1~~");if(q){var u=function(i,v){tag_1=i.replace(/oIWIKIo(.*)cIWIKIc/,"$1");if(tag_1==v){return true}v=v.replace(/\s/,"%20");return(v==tag_1)};r=r.replace(/\[\[(\w+\.?\w{0,12})>(.*?)\|(.*?)\]\]/gm,function(v,T,S,i){if(S=="oIWIKIocIWIKIc"){S=i}if((S=="oIWIKIo"+i.replace(/\s/,"%20")+"cIWIKIc")||(S==i)||u(S,i)){i=""}else{i="|"+i}return("[["+T+">"+S+i+"]]")})}r=r.replace(/>.*?oIWIKIo(.*?)cIWIKIc/mg,">$1");if(K){if(h){r=r.replace(/\s*([\|\^]+)((\W\W_FORMAT_SPACE_)+)/gm,function(i,v,S){S=S.replace(/_FORMAT_SPACE_/g,"");return(S+v)})}r=r.replace(/&quot;/g,'"');var j=new RegExp(K+"([\\-]{2,})","g");r=r.replace(j," $1");r=r.replace(/\]\](\*\*|\/\/|\'\'|__|<\/del>)_FORMAT_SPACE_/,"]]$1@@_SP_@@");var j=new RegExp("(&amp;|\\W|\\w|\\d)(\\*\\*|\\/\\/|\\'\\'|__|</del>)+"+K+"(\\w|\\d)","g");r=r.replace(j,"$1$2$3");var j=new RegExp(K+"@@_SP_@@","g");r=r.replace(j," ");r=r.replace(/([\*\/_]{2})@@_SP_@@(&\w+;)/g,"$1 $2");r=r.replace(/\n@@_SP_@@\n/g,"");r=r.replace(/@@_SP_@@\n/g,"");r=r.replace(/@@_SP_@@/g," ");var j=new RegExp(K+"([^\\)\\]\\}\\{\\-\\.,;:\\!?\"\x94\x92\u201D\u2019'])","g");r=r.replace(j," $1");j=new RegExp(K,"g");r=r.replace(j,"");if(g){r=r.replace(/^(\s+[\-\*_]\s*)([\*\/_\']{2})(.*?)(\2)([^\n]*)\n+/gm,function(S,i,U,V,v,T){return(i+U+V+v+T+"\n")})}}if(HTMLLinkInList){r=r.replace(/(\*|-).*?(\[\[|\{\{).*?(\]\]|\}\})([\s\w\/\-\x3A-\x40\x5B-\x60\x7B-\x7F,;\>\<\&]+)\n\n/mg,function(T,S,i,U,v){T=T.replace(/[\n]$/,"");return(T)})}var p="\\\\";if(R){r=r.replace(/(L_BR_K)+/g,p);r=r.replace(/L_BR_K/gm,p);r=r.replace(/(\\\\)\s+/gm,"$1 \n")}if(s){r=r.replace(/\s+<\/(code|file)>/g,"\n</$1>");if(b){r=r.replace(/\s+;/mg,";");r=r.replace(/&lt;\s+/mg,"<");r=r.replace(/\s+&gt;/mg,">")}}if(M){r+="\n"+p+"\n";var j=new RegExp(d,"g");r=r.replace(j," "+p+" ");r=r.replace(/(\||\^)[ ]+(\||\^)\s$/g,"$1\n");r=r.replace(/(\||\^)[ ]+(\||\^)/g,"$1")}r=r.replace(/_FCKG_BLANK_TD_/g," ");if(e){r=r.replace(/\/\/&lt;\/\/\s*/g,"&lt;")}if(Q){String.prototype.font_link_reconcile=function(i){if(i==1){j=/\[\[(.*?)(<font[^\>]+>)([^<]+(\]\])?)[^\>]+\/font>\s*(\]\])/gm}else{j=/(<font[^\>\{]+>)\{\{(:?.*?)\|(:?.*?)<\/font>/gm}return(this.replace(j,function(S,T,v,V){T=T.replace(/\n/gm,"");T=T.replace(/\s/gm,"");T=T.replace(/[\[\]\{\}]/g,"");T=T.replace(/\|/g,"");V=V.replace(/\n/gm,"");V=V.replace(/[\[\]\}\{]/g,"");if(i==1){V="[["+T+"|"+V+"]]"}else{V="{{"+v+"|"+V+"}}"}var U=prompt(LANG.plugins.ckgedit.font_err_1+"\n"+V+"\n"+LANG.plugins.ckgedit.font_err_2);if(U==null){if(ckgedit_to_dwedit){ckgedit_to_dwedit=false;return V}else{throw new Error(LANG.plugins.ckgedit.font_err_throw)}}if(U){return U}return V}))};if(P){r=r.replace(/<\/font>\s{1}/gm,"</font>")}if(F()){if(confirm(LANG.plugins.ckgedit.font_conflict)){return}var G=jQuery("#fontdel").val();if(!G){jQuery("#dw__editform").append('<input type="hidden" id="fontdel" name="fontdel" value="del" />')}}r=r.font_link_reconcile(1);r=r.font_link_reconcile(2);var j=/\>\s+(\*\*|__|\/\/|'')\s+_\s+\1\s+<\/font>/gm;r=r.replace(j,function(i){i=i.replace(/\s+/g,"");return i});r=r.replace(/\[\[(.*?)\|(<font[^\>]+>)(.*?)(<\/font>)\s*(\]\])\s*/gm,function(U,S,i,V){U="[["+S+"|"+V+"]]";var T=jQuery("#fontdel").val();if(!T){jQuery("#dw__editform").append('<input type="hidden" id="fontdel" name="fontdel" value="del" />')}return U});r=r.replace(/(\s*={2,})\s*(.*?)(<font[^\>]+>)(.*?)(<\/font>)(.*?)\s*\1/gm,function(S){S=S.replace(/<\/font>/g," ");S=S.replace(/<font.*?>/g," ");var i=jQuery("#formatdel").val();if(!i){jQuery("#dw__editform").append('<input type="hidden" id="formatdel" name="formatdel" value="del" />')}return S})}if(c.length){r=r.replace(/<sup>\(\(\){2,}\s*<\/sup>/g,"");r=r.replace(/\(\(+(\d+)\)\)+/,"(($1))");for(var N in y){var a=N.match(/_(\d+)/);var k=new RegExp("(<sup>)*[(]+"+a[1]+"[)]+(</sup>)*");y[N]=y[N].replace(/(\d+)_FN_PAREN_C_/,"");r=r.replace(k,"(("+y[N].replace(/_FN_PAREN_C_/g,") ")+"))")}r=r.replace(/<sup><\/sup>/g,"");r=r.replace(/((<sup>\(\(\d+\)\)\)?<\/sup>))/mg,function(i){if(!i.match(/p>\(\(\d+/)){return""}return i})}r=r.replace(/(={3,}.*?)(\{\{.*?\}\})(.*?={3,})/g,"$1$3\n\n$2");r=r.replace(/(<sup>)*\s*\[\[\s*\]\]\s*(<\/sup>)*\n*/g,"");r=r.replace(/<sup>\s*\(\(\d+\)\)\s*<\/sup>/mg,"");if(O){r=r.replace(/<\s+/g,"<");r=r.replace(/&lt;\s+/g,"<")}if(L){var x="%";var j=new RegExp("(["+x+"])","g");r=r.replace(/(&lt;nowiki&gt;)(.*?)(&lt;\/nowiki&gt;)/mg,function(v,T,i,S){i=i.replace(/%%(.)%%/mg,"NOWIKI_$1_");return T+i.replace(j,"NOWIKI_$1_")+S})}r=r.replace(/__SWF__(\s*)\[*/g,"{{$1");r=r.replace(/\|.*?\]*(\s*)__FWS__/g,"$1}}");r=r.replace(/(\s*)__FWS__/g,"$1}}");r=r.replace(/\n{3,}/g,"\n\n");r=r.replace(/_LIST_EOFL_/gm," "+p+" ");if(A){if(r.indexOf("~~COMPLEX_TABLES~~")==-1){r+="~~COMPLEX_TABLES~~\n"}}if(!A){r=r.replace(/~~COMPLEX_TABLES~~/gm,"")}r=r.replace(/_CKG_ASTERISK_/gm,"*");r=r.replace(/_ESC_BKSLASH_/g,"\\");r=r.replace(/divalNLine/gm,"\n");if(C=="test"){if(HTMLParser_test_result(r)){alert(r)}return}var D=GetE("dw__editform");D.elements.fck_wikitext.value=r;if(C=="bakup"){return}if(C){var f=GetE(C);f.click();return true}}jQuery(document).ready(function(){var a=false;jQuery(document).on("keypress","input#edit__summary",function(b){if(b.which==13){a=true;jQuery("#save_button").trigger("mousedown")}});jQuery("#ebut_test").mousedown(function(){parse_wikitext("test")});jQuery("#ebtn__delete").click(function(){if(a){a=false;return}return confirm(JSINFO.confirm_delete)});jQuery("#ebtn__delete").mouseup(function(){draft_delete()});jQuery("#ebtn__dwedit").click(function(){ckgedit_to_dwedit=true;setDWEditCookie(2,this);parse_wikitext("edbtn__save");this.form.submit()});jQuery("#ebtn__fbswitch").click(function(){if(getCookie("ckgFbOpt")=="dokuwiki"){document.cookie="ckgFbOpt=ckgedit;SameSite=Lax"}else{document.cookie="ckgFbOpt=dokuwiki;SameSite=Lax"}parse_wikitext("edbtn__save");this.form.submit()});jQuery("#ckgedit_draft_btn").click(function(){ckgedit_get_draft()});jQuery("#backup_button").click(function(){renewLock(true)});jQuery("#revert_to_prev_btn").click(function(){revert_to_prev()});jQuery("#no_styling_btn").click(function(){this.form.styling.value="no_styles";this.form.prefix.value="";this.form.suffix.value="";this.form.rev.value=""});jQuery("#ebut_cancel").mouseup(function(){if(this.form.template&&this.form.template.value=="tpl"){return}if(window.dwfckTextChanged){return}draft_delete()});jQuery("#save_button").mousedown(function(){if(this.form.template&&this.form.template.value=="tpl"){window.dwfckTextChanged=true}if(!window.dwfckTextChanged&&!JSINFO.cg_rev){ckgedit_dwedit_reject=true;parse_wikitext("ebut_cancel")}else{parse_wikitext("edbtn__save")}})});
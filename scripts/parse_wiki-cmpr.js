function parse_wikitext(B){if(ckgedit_dwedit_reject){var f=GetE("ebut_cancel");f.click();return true}var z=getComplexTables();function n(T,U,O){var R=new Array();for(var Q=U;Q<T.length;Q++){for(var P=0;P<T[Q].length;P++){if(T[Q][P].rowspan>0){var S=T[Q][P].text;R.push({row:Q,column:P,spans:T[Q][P].rowspan,text:S});if(!O){break}}}}return R}function D(S,O,Q,R,i){var P=R[S][O].colspan?R[S][O].colspan:0;R[S][O].rowspan=0;for(K=0;K<Q-1;K++){R[++S].splice(O,0,{type:"td",rowspan:0,colspan:P,prev_colspan:P,text:" ::: "})}}function y(T){var Q=n(T,0,true);var O=Q.length;if(!O){return false}var U=Q[0].row;var P=Q[0].column;D(U,P,Q[0].spans,T);O--;for(var S=0;S<O;S++){U++;var R=n(T,U,false);if(R.length){D(R[0].row,R[0].column,R[0].spans,T)}}return true}function m(R){if(!z){return}for(var P=0;P<R.length;P++){if(!y(R)){break}}r+="\n";for(var P=0;P<R.length;P++){r+="\n";for(var O=0;O<R[P].length;O++){var Q=R[P][O].type=="td"?"|":"^";r+=Q;var T=R[P][O].align?R[P][O].align:false;if(T=="center"||T=="right"){r+="  "}r+=R[P][O].text;if(T=="center"||T=="left"){r+="  "}if(R[P][O].colspan){for(var S=0;S<R[P][O].colspan-1;S++){r+=Q}}}r+="|"}}window.dwfckTextChanged=false;if(B!="bakup"){draft_delete()}var v="\nL_BR_K  \n";var E={b:"**",i:"//",em:"//",u:"__",br:v,strike:"<del>",del:"<del>",s:"<del>",p:"\n\n",a:"[[",img:"{{",strong:"**",h1:"\n====== ",h2:"\n===== ",h3:"\n==== ",h4:"\n=== ",h5:"\n== ",td:"|",th:"^",tr:" ",table:"\n\n",ol:"  - ",ul:"  * ",li:"",code:"''",pre:"\n<",hr:"\n\n----\n\n",sub:"<sub>",font:"\n",sup:"<sup>",div:"\n\n",span:"\n",dl:"\n",dd:"\n",dt:"\n"};var o={del:"</del>",s:"</del>",strike:"</del>",p:" ",br:" ",a:"]]",img:"}}",h1:" ======\n",h2:" =====\n",h3:" ====\n",h4:" ===\n",h5:" ==\n",td:" ",th:" ",tr:"|\n",ol:" ",ul:" ",li:"\n",pre:"\n</",sub:"</sub>",sup:"</sup> ",div:"\n\n",p:"\n\n",font:"\n\n</font> ",span:" "};E.temp_u="CKGE_TMP_u";E.temp_strong="CKGE_TMP_strong";E.temp_em="CKGE_TMP_em";E.temp_i="CKGE_TMP_i";E.temp_b="CKGE_TMP_b";E.temp_del="CKGE_TMP_del";E.temp_strike="CKGE_TMP_strike";E.temp_code="CKGE_TMP_code";E.temp_sup="CKGE_TMP_sup";E.temp_csup="CKGE_TMP_csup";E.temp_sub="CKGE_TMP_sub";E.temp_csub="CKGE_TMP_csub";E.temp_del="CKGE_TMP_del";E.temp_cdel="CKGE_TMP_cdel";E.temp_strike="CKGE_TMP_del";E.temp_cstrike="CKGE_TMP_cdel";E.temp_s="CKGE_TMP_del";E.temp_cs="CKGE_TMP_cdel";var l={CKGE_TMP_b:"**",CKGE_TMP_strong:"**",CKGE_TMP_em:"//",CKGE_TMP_u:"__",CKGE_TMP_sup:"<sup>",CKGE_TMP_sub:"<sub>",CKGE_TMP_csub:"</sub>",CKGE_TMP_csup:"</sup>",CKGE_TMP_del:"<del>",CKGE_TMP_strike:"<del>",CKGE_TMP_code:"''"};E.blank="";E.fn_start="((";E.fn_end="))";E.row_span=":::";E.p_insert="_PARA__TABLE_INS_";E.format_space="_FORMAT_SPACE_";E.pre_td="<";var t={strong:true,b:true,i:true,em:true,u:true,del:true,strike:true,code:true,sup:true,sub:true,s:true};var r="";var N=false;var s=false;var b=false;var J=false;var h=false;var H=false;var L=false;var I=false;var g=false;var G=false;var q=false;var M=false;var A;var c=new Array();var x=new Array();var e=false;var d=E.p_insert;var F="(br|co|coMULTI|es|kw|me|nu|re|st|sy)[0-9]";String.prototype.splice=function(i,P,O){return(this.slice(0,i)+O+this.slice(i+Math.abs(P)))};String.frasl=new RegExp("⁄|&frasl;|&#8260;|&#x2044;","g");F=new RegExp(F);HTMLParser(CKEDITOR.instances.wiki__text.getData(),{attribute:"",link_title:"",link_class:"",image_link_type:"",td_align:"",in_td:false,td_colspan:0,td_rowspan:0,rowspan_col:0,last_column:-1,row:0,col:0,td_no:0,tr_no:0,current_row:false,in_table:false,in_multi_plugin:false,is_rowspan:false,list_level:0,prev_list_level:-1,list_started:false,xcl_markup:false,in_link:false,link_formats:new Array(),last_tag:"",code_type:false,in_endnotes:false,is_smiley:false,geshi:false,downloadable_code:false,export_code:false,code_snippet:false,downloadable_file:"",external_mime:false,in_header:false,curid:false,format_in_list:false,prev_li:new Array(),link_only:false,in_font:false,interwiki:false,bottom_url:false,font_family:"inherit",font_size:"inherit",font_weight:"inherit",font_color:"inherit",font_bgcolor:"inherit",font_style:"inherit",is_mediafile:false,end_nested:false,mfile:false,backup:function(Q,P){var S=r.lastIndexOf(Q);var O=r.indexOf(P,S);if(S==-1||O==-1){return}if(Q.length+O==O){var R=r.substring(0,S);var i=r.substring(O);r=R+i;return true}return false},is_iwiki:function(P,R){var Q=P.match(/iw_(\w+\.?\w{0,12})/);var i=R.split(/\//);var O=i[i.length-1];O=O.replace(String.frasl,"/");if(!O.match(/oIWIKIo.*?cIWIKIc/)){O="oIWIKIo"+O+"cIWIKIc"}O=O.replace(/^.*?oIWIKIo/,"oIWIKIo");O=O.replace(/cIWIKIc.*/,"cIWIKIc");Q[1]=Q[1].replace(/_(\w{2})/,".$1");this.attr=Q[1]+">"+O;q=true;this.interwiki=true},start:function(ar,X,ah){if(E[ar]){if(t[ar]&&this.in_link){this.link_formats.push(ar);return}if(t[ar]&&(this.in_font||this.in_header)){r+=" ";var an="temp_"+ar;r+=E[an];r+=" ";return}else{if(ar=="acronym"){return}}if(t[ar]&&this.in_endnotes){if(ar=="sup"){return}}if(ar=="ol"||ar=="ul"){this.prev_list_level=this.list_level;this.list_level++;if(this.list_level==1){this.list_started=false}if(this.list_started){this.prev_li.push(E.li)}E.li=E[ar];return}else{if(!this.list_level){E.li="";this.prev_li=new Array()}}this.is_mediafile=false;if(ar=="img"){var aq="?";var O;var Q;var at=false;var af="";var aa="";var ag=false;this.is_smiley=false;this.in_link=false}if(ar=="a"){var ae=true;var az="";this.xcl_markup=false;this.in_link=true;this.link_pos=r.length;this.link_formats=new Array();this.footnote=false;var Y=false;this.id="";this.external_mime=false;var ay=false;this.export_code=false;this.code_snippet=false;this.downloadable_file="";var ac=false;this.link_only=false;save_url="";this.interwiki=false;this.bottom_url=false;this.link_title=false;var al="";var ab=""}if(ar=="p"){this.in_link=false;if(this.in_table){ar="p_insert";J=true}}if(ar=="table"){this.td_no=0;this.tr_no=0;this.in_table=true;this.is_rowspan=false;this.row=-1;this.rows=new Array();A=this.rows;this.table_start=r.length}else{if(ar=="tr"){this.tr_no++;this.td_no=0;this.col=-1;this.row++;this.rows[this.row]=new Array();this.current_row=this.rows[this.row]}else{if(ar=="td"||ar=="th"){this.td_no++;this.col++;this.current_row[this.col]={type:ar,rowspan:0,colspan:0,text:""};this.cell_start=r.length;this.current_cell=this.current_row[this.col];if(this.td_rowspan&&this.rowspan_col==this.td_no&&this.td_no!=this.last_column){this.is_rowspan=true;this.td_rowspan--}else{this.is_rowspan=false}}}}var P;this.attr=false;this.format_tag=false;if(t[ar]){this.format_tag=true}var Z=false;for(var aw=0;aw<X.length;aw++){if(ar=="td"||ar=="th"){if(X[aw].name=="colspan"){this.current_row[this.col].colspan=X[aw].value}if(X[aw].name=="class"){if((P=X[aw].value.match(/(left|center|right)/))){this.current_row[this.col].align=P[1]}}if(X[aw].name=="rowspan"){this.current_row[this.col].rowspan=X[aw].value}}if(X[aw].escaped=="u"&&ar=="em"){ar="u";this.attr="u";break}if(ar=="div"){if(X[aw].name=="class"&&X[aw].value=="footnotes"){ar="blank";this.in_endnotes=true}break}if(ar=="dl"&&X[aw].name=="class"&&X[aw].value=="file"){this.downloadable_code=true;b=true;return}if(ar=="span"&&X[aw].name=="class"){if(X[aw].value=="np_break"){return}}if(ar=="span"&&X[aw].name=="class"){if(X[aw].value=="curid"){this.curid=true;return}if(X[aw].value=="multi_p_open"){this.in_multi_plugin=true;L=true;return}if(X[aw].value=="multi_p_close"){this.in_multi_plugin=false;return}if(X[aw].value.match(F)){ar="blank";this.geshi=true;break}}if(ar=="span"&&!ckgedit_xcl_styles){if(X[aw].name=="style"){if(!this.in_font){r+="__STYLE__"}this.in_font=true;P=X[aw].value.match(/font-family:\s*([\w\-\s,]+);?/);if(P){this.font_family=P[1]}P=X[aw].value.match(/font-size:\s*(.*)/);if(P){P[1]=P[1].replace(/;/,"");this.font_size=P[1]}P=X[aw].value.match(/font-weight:\s*(\w+);?/);if(P){this.font_weight=P[1]}P=X[aw].value.match(/.*?color:\s*(.*)/);var ak=false;if(P){P[1]=P[1].replace(/;/,"");if(P[0].match(/background/)){this.font_bgcolor=P[1]}else{this.font_color=P[1]}}if(!ak){P=X[aw].value.match(/background:\s*(\w+)/);if(P&&P[0].match(/background/)){this.font_bgcolor=P[1]}}}}if(ar=="td"||ar=="th"){if(ar=="td"){r=r.replace(/\^$/,"|")}this.in_td=true;if(X[aw].name=="align"){this.td_align=X[aw].escaped}else{if(X[aw].name=="class"){P=X[aw].value.match(/\s*(\w+)align/);if(P){this.td_align=P[1]}}else{if(X[aw].name=="colspan"){h=true;this.td_colspan=X[aw].escaped}else{if(X[aw].name=="rowspan"){this.td_rowspan=X[aw].escaped-1;this.rowspan_col=this.td_no}}}}J=true}if(ar=="a"){if(X[aw].name=="title"){this.link_title=X[aw].escaped;if(ab){al=X[aw].escaped}else{this.link_title=this.link_title.replace(/\s+.*$/,"")}}else{if(X[aw].name=="class"){if(X[aw].value.match(/fn_top/)){this.footnote=true}else{if(X[aw].value.match(/fn_bot/)){Y=true}else{if(X[aw].value.match(/mf_(png|gif|jpg|jpeg)/i)){this.link_only=true}}}this.link_class=X[aw].escaped;ay=this.link_class.match(/mediafile/)}else{if(X[aw].name=="id"){this.id=X[aw].value}else{if(X[aw].name=="type"){az=X[aw].value}else{if(X[aw].name=="href"&&!this.code_type){var W=X[aw].escaped.match(/https*:\/\//)?true:false;if(W){save_url=X[aw].escaped}if(X[aw].escaped.match(/\/lib\/exe\/detail.php/)){this.image_link_type="detail"}else{if(X[aw].escaped.match(/exe\/fetch.php/)){this.image_link_type="direct"}}if(this.link_class&&this.link_class.match(/media/)&&!this.link_title){var aj=X[aw].escaped.match(/media=(.*)/);if(aj){this.link_title=aj[1]}}var ap=X[aw].escaped.match(/fetch\.php.*?media=.*?\.(png|gif|jpg|jpeg)$/i);if(ap){ap=ap[1]}if(X[aw].escaped.match(/^https*:/)){this.attr=X[aw].escaped;ae=false}if(X[aw].escaped.match(/^ftp:/)){this.attr=X[aw].escaped;ae=false}else{if(X[aw].escaped.match(/do=export_code/)){this.export_code=true}else{if(X[aw].escaped.match(/^nntp:/)){this.attr=X[aw].escaped;ae=false}else{if(X[aw].escaped.match(/^mailto:/)){this.attr=X[aw].escaped.replace(/mailto:/,"");ae=false}else{if(X[aw].escaped.match(/m-files/)){this.attr=X[aw].escaped;this.mfile=X[aw].escaped;ae=false}else{if(X[aw].escaped.match(/^file:/)){var R=X[aw].value.replace(/file:[\/]+/,"");R=R.replace(/[\/]/g,"\\");R="\\\\"+R;this.attr=R;ae=false}else{if(W&&!ap&&(P=X[aw].escaped.match(/fetch\.php(.*)/))){if(P[1].match(/media=/)){V=P[1].split(/=/);this.attr=V[1]}else{P[1]=P[1].replace(/^\//,"");this.attr=P[1]}if(config_animal){var S=new RegExp(config_animal+"/file/(.*)");P=X[aw].escaped.match(S);if(P&&P[1]){this.attr=P[1]}if(this.attr){this.attr=this.attr.replace(/\//g,":")}}ae=false;this.attr=decodeURIComponent?decodeURIComponent(this.attr):unescape(this.attr);if(!this.attr.match(/^:/)){this.attr=":"+this.attr}this.external_mime=true}else{ae=false;P=X[aw].escaped.match(/doku.php\?id=(.*)/);if(!P){P=X[aw].escaped.match(/doku.php\/(.*)/)}if(P){if(!P[1].match(/\?/)&&P[1].match(/&amp;/)){ac=true;P[1]=P[1].replace(/&amp;/,"?")}}if(P&&P[1]){if(!P[1].match(/^:/)){this.attr=":"+P[1]}else{this.attr=P[1]}if(this.attr.match(/\.\w+$/)){if(az&&az=="other_mime"){this.external_mime=true}else{for(var au=aw+1;au<X.length;au++){if(X[au].value.match(/other_mime/)){this.external_mime=true}break}}}}else{P=X[aw].value.match(/\\\\/);if(P){this.attr=X[aw].escaped;ae=false}}}}}}}}}if(this.link_class=="media"){if(X[aw].value.match(/http:/)){ae=false}}if(!this.attr&&this.link_title){if(P=this.link_class.match(/media(.*)/)){this.link_title=decodeURIComponent(safe_convert(this.link_title));this.attr=this.link_title;var av=P[1].split(/_/);if(av&&av[1]){ap=av[1]}else{if(av){ap=av[0]}else{ap="mf"}}if(!this.attr.match(/^:/)&&!this.attr.match(/^https?\:/)){this.attr=":"+this.attr.replace(/^\s+/,"")}this.external_mime=true;ae=false}}if(this.attr.match&&this.attr.match(/%[a-fA-F0-9]{2}/)&&(P=this.attr.match(/userfiles\/file\/(.*)/))){P[1]=P[1].replace(/\//g,":");if(!P[1].match(/^:/)){P[1]=":"+P[1]}this.attr=decodeURIComponent?decodeURIComponent(P[1]):unescape(P[1]);this.attr=decodeURIComponent?decodeURIComponent(this.attr):unescape(this.attr);this.external_mime=true}if(this.link_title&&this.link_title.match(/Snippet/)){this.code_snippet=true}if(X[aw].value.match(/^#/)&&this.link_class.match(/wikilink/)){this.attr=X[aw].value;this.link_title=false}if(this.link_class.match(/wikilink/)&&this.link_title){this.external_mime=false;if(!this.attr){this.attr=this.link_title}if(!this.attr.match(/^:/)){this.attr=":"+this.attr}if(this.attr.match(/\?.*?=/)){var V=this.attr.split(/\?/);V[0]=V[0].replace(/\//g,":");this.attr=V[0]+"?"+V[1]}else{this.attr=this.attr.replace(/\//g,":")}if(!ac&&X[aw].name=="href"){if(!this.attr.match(/\?.*?=/)&&!X[aw].value.match(/doku.php/)){var ax=X[aw].value.match(/(\?.*)$/);if(ax&&ax[1]){this.attr+=ax[1]}}}}else{if(this.link_class.match(/mediafile/)&&this.link_title&&!this.attr){this.attr=this.link_title;this.external_mime=true;if(!this.attr.match(/^:/)){this.attr=":"+this.attr}}else{if(this.link_class.match(/interwiki/)){ab=this.link_class}}}if(this.link_class=="urlextern"&&!this.mfile){this.attr=save_url;this.external_mime=false}if(this.in_endnotes){if(this.link_title){this.bottom_url=this.link_title}else{if(this.attr){this.bottom_url=this.attr}}}this.link_title="";this.link_class=""}}}}}}if(ab&&al){this.is_iwiki(ab,al);ab="";al=""}if(ar=="sup"){if(X[aw].name=="class"){P=X[aw].value.split(/\s+/);if(P[0]=="dwfcknote"){this.attr=P[0];ar="blank";if(oDokuWiki_FCKEditorInstance.oinsertHtmlCodeObj.notes[P[1]]){Z="(("+oDokuWiki_FCKEditorInstance.oinsertHtmlCodeObj.notes[P[1]]+"))"}break}}}if(ar=="pre"){if(X[aw].name=="class"){var V=X[aw].escaped.split(/\s+/);if(V.length>1){this.attr=X[aw].value;this.code_type=V[0]}else{this.attr=X[aw].escaped;this.code_type=this.attr}if(this.downloadable_code){this.attr=this.attr.replace(/\s*code\s*/,"");this.code_type="file"}s=true;if(this.in_table){ar="pre_td"}break}}else{if(ar=="img"){if(X[aw].name=="alt"){aa=X[aw].value}if(X[aw].name=="type"){this.image_link_type=X[aw].value}if(X[aw].name=="src"){var ai="";if(P=X[aw].escaped.match(/fetch\.php.*?(media=.*)/)){var V=P[1].split("=");ai=V[1];if(P=X[aw].escaped.match(/(media.*)/)){var V=P[1].split("=");var T=V[1];ai=decodeURIComponent?decodeURIComponent(T):unescape(T)}if(!ai.match(/https?:/)&&!ai.match(/^:/)){ai=":"+ai}}else{if(X[aw].escaped.match(/https?:\/\//)){ai=X[aw].escaped;ai=ai.replace(/\?.*?$/,"")}else{if(P=X[aw].escaped.match(/\/_media\/(.*)/)){var V=P[1].split(/\?/);ai=V[0];ai=ai.replace(/\//g,":");if(!ai.match(/^:/)){ai=":"+ai}}else{if(P=X[aw].escaped.match(/\/lib\/exe\/fetch.php\/(.*)/)){var V=P[1].split(/\?/);ai=V[0];if(!ai.match(/^:/)){ai=":"+ai}}else{P=X[aw].escaped.match(/^.*?\/userfiles\/image\/(.*)/);if(!P&&config_animal){var S=new RegExp(config_animal+"/image/(.*)$");P=X[aw].escaped.match(S)}if(!P){var S=doku_base+"data/media/";S=S.replace(/([\/\\])/g,"\\$1");S="^.*?"+S+"(.*)";S=new RegExp(S);P=X[aw].escaped.match(S)}if(P&&P[1]){ai=P[1].replace(/\//g,":");ai=":"+ai}else{ai=decodeURIComponent?decodeURIComponent(X[aw].escaped):unescape(X[aw].escaped);if(ai.search(/data:image.*?;base64/)>-1){ag=true}}if(ai&&ai.match(/lib\/images\/smileys/)){this.is_smiley=true}}}}}this.attr=ai;if(this.attr&&this.attr.match&&this.attr.match(/%[a-fA-F0-9]{2}/)){this.attr=decodeURIComponent(safe_convert(this.attr));this.attr=decodeURIComponent(safe_convert(this.attr))}}else{if(X[aw].name=="width"&&!at){O=X[aw].value}else{if(X[aw].name=="height"&&!at){Q=X[aw].value}else{if(X[aw].name=="style"){var U=X[aw].escaped.match(/width:\s*(\d+)/);if(U){O=U[1];var U=X[aw].escaped.match(/height:\s*(\d+)/);if(U){Q=U[1]}}}else{if(X[aw].name=="align"||X[aw].name=="class"){if(X[aw].escaped.match(/(center|middle)/)){af="center"}else{if(X[aw].escaped.match(/right/)){af="right"}else{if(X[aw].escaped.match(/left/)){af="left"}else{af=""}}}}}}}}}}}if(this.is_smiley){if(aa){r+=aa+" ";aa=""}this.is_smiley=false;return}if(this.link_only){ar="img"}if(ar=="br"){if(this.in_multi_plugin){r+="\n";return}if(!this.code_type){N=true}else{if(this.code_type){r+="\n";return}}if(this.in_table){r+=d;return}if(this.list_started){r+="_LIST_EOFL_"}else{r+="\\\\  ";return}}else{if(ar.match(/^h(\d+|r)/)){var ad=r.length;if(ar.match(/h(\d+)/)){this.in_header=true}if(ad){if(r.charCodeAt(ad-1)==32){r=r.replace(/\x20+$/,"")}}}else{if(this.last_col_pipes){if(t[ar]){r+=E[ar]}ar="blank"}else{if(Z){r+=Z;return}}}}if(ar=="b"||ar=="i"&&this.list_level){if(r.match(/(\/\/|\*)(\x20)+/)){r=r.replace(/(\/\/|\*)(\x20+)\-/,"$1\n$2-")}}if(ar=="li"&&this.list_level){if(this.list_level==1&!this.list_started){r+="\n";this.list_started=true}r=r.replace(/[\x20]+$/,"");for(var ao=0;ao<this.list_level;ao++){if(r.match(/_FORMAT_SPACE_\s*$/)){r=r.replace(/_FORMAT_SPACE_\s*$/,"\n")}if(this.list_level>1){r+="  "}}if(this.prev_list_level>0&&E.li==E.ol){this.prev_list_level=-1}}if(ar=="a"&&ae){this.xcl_markup=true;return}else{if(ar=="a"&&(this.export_code||this.code_snippet)){return}else{if(ar=="a"&&this.footnote){ar="fn_start"}else{if(ar=="a"&&Y){c.push(this.id)}else{if(ar=="a"&&this.external_mime){if(this.in_endnotes){this.link_class="media";return}if(ay&&ay=="mediafile"){r+=E.img;r+=this.attr+"|";this.is_mediafile=true}return}else{if(this.in_font){return}}}}}}if(this.in_endnotes&&ar=="a"){return}if(this.code_type&&ar=="span"){ar="blank"}if(this.mfile&&!this.attr){this.attr=this.mfile}r+=E[ar];if(ar=="td"||ar=="th"||(this.last_col_pipes&&this.td_align=="center")){if(this.is_rowspan){r+=E.row_span+" | ";this.is_rowspan=false}if(this.td_align=="center"||this.td_align=="right"){r+="  "}}else{if(ar=="a"&&this.attr){this.attr=this.attr.replace(/%7c/,"%257c");r+=this.attr+"|"}else{if(ar=="img"){var am=this.image_link_type;this.image_link_type="";if(this.link_only){am="link_only"}if(!am||ag){am="nolink"}else{if(am=="detail"){am=""}}if(am=="link_only"){aq="?linkonly"}else{if(am){aq+=am+"&"}}if(O&&Q){aq+=O+"x"+Q}else{if(O){aq+=O}else{if(!am){aq=""}}}if(af&&af!="left"){r+="  "}this.attr+=aq;if(af=="center"||af=="left"){this.attr+="  "}r+=this.attr+"}}";this.attr="src"}else{if(ar=="pre"||ar=="pre_td"){if(this.downloadable_file){this.attr+=" "+this.downloadable_file}if(!this.attr){this.attr="code"}r+=this.attr+">";this.downloadable_file="";this.downloadable_code=false}}}}}},end:function(ad){if(t[ad]&&(this.in_font||this.in_header)){r+=" ";if(ad=="sup"||ad=="sub"||ad=="del"||ad=="strike"||ad=="s"){var ac="temp_c"+ad}else{var ac="temp_"+ad}r+=E[ac];r+=" ";return}if(this.in_endnotes&&ad=="a"){return}if(this.link_only){this.link_only=false;return}if(!E[ad]){return}if(ad=="sup"&&this.attr=="dwfcknote"){return}if(this.is_smiley){this.is_smiley=false;if(ad!="li"){return}}if(ad=="span"&&this.in_font&&!ckgedit_xcl_styles){ad="font";var Y="<font "+this.font_size+"/"+this.font_family+";;"+this.font_color+";;"+this.font_bgcolor+">\n\n";var U=r.lastIndexOf("__STYLE__");r=r.splice(U,9,Y);this.font_size="inherit";this.font_family="inherit";this.font_color="inherit";this.font_bgcolor="inherit";this.in_font=false;M=true}if(ad=="span"&&this.curid){this.curid=false;return}if(ad=="dl"&&this.downloadable_code){this.downloadable_code=false;return}if(z&&(ad=="td"||ad=="th")){this.current_cell.text=r.substring(this.cell_start);this.current_cell.text=this.current_cell.text.replace(/:::/gm,"");this.current_cell.text=this.current_cell.text.replace(/^[\s\|\^]+/,"")}if(ad=="a"&&(this.export_code||this.code_snippet)){this.export_code=false;this.code_snippet=false;return}if(this.code_type&&ad=="span"){ad="blank"}var aa=ad;if(this.footnote){ad="fn_end";this.footnote=false}else{if(ad=="a"&&this.xcl_markup){this.xcl_markup=false;return}else{if(ad=="table"){this.in_table=false;if(z){r=r.substring(0,this.table_start);m(this.rows)}}}}if(ad=="p"&&this.in_table){ad="p_insert";J=true}if(this.geshi){this.geshi=false;return}if(ad=="code"&&!this.list_started){if(r.match(/''\s*$/m)){r=r.replace(/''\s*$/,"\n");return}}else{if(ad=="a"&&this.attr=="src"){if(this.backup("[[","{")){return}}}if(this.end_nested){this.end_nested=false;return}if(ad=="ol"||ad=="ul"){this.list_level--;if(!this.list_level){this.format_in_list=false}if(this.prev_li.length){E.li=this.prev_li.pop();this.end_nested=true;return}ad="\n\n"}else{if(ad=="a"&&this.external_mime){this.external_mime=false;if(this.is_mediafile){ad="}} "}else{return}}else{if(ad=="pre"){ad=o[ad];if(this.code_type){ad+=this.code_type+">"}else{var P=r.lastIndexOf("code");var R=r.lastIndexOf("file");if(R>P){this.code_type="file"}else{this.code_type="code"}ad+=this.code_type+">"}this.code_type=false}else{if(o[ad]){ad=o[ad]}else{if(this.attr=="u"&&ad=="em"){ad="u"}else{if(ad=="acronym"){}else{ad=E[ad]}}}}}}if(aa=="tr"){if(this.last_col_pipes){ad="\n";this.last_col_pipes=""}if(this.td_rowspan&&this.rowspan_col==this.td_no+1){this.is_rowspan=false;this.last_column=this.td_no;this.td_rowspan--;ad="|"+E.row_span+"|\n"}}else{if(aa=="td"||aa=="th"){this.last_col_pipes="";this.in_td=false}else{if(aa.match(/h\d+/)){this.in_header=false}}}if(E.li){if(r.match(/\n$/)&&!this.list_level){ad=""}}if(this.in_link&&t[aa]&&this.link_formats.length){return}if(this.in_endnotes&&aa=="sup"){return}r+=ad;if(t[aa]){if(this.list_level){this.format_in_list=true;g=true}r+=E.format_space;H=E.format_space}this.last_tag=aa;if(this.td_colspan&&!z){if(this.td_align=="center"){r+=" "}var Q="|";if(aa=="th"){Q="^"}var T=Q;for(var V=1;V<this.td_colspan;V++){T+=Q}this.last_col_pipes=T;r+=T;this.td_colspan=false}else{if(this.td_align=="center"){r+=" ";this.td_align=""}}if(aa=="a"&&this.link_formats.length){var ab=r.substring(this.link_pos);var W=r.substring(0,this.link_pos);var O="";var Z="";for(var V=0;V<this.link_formats.length;V++){var S=E[this.link_formats[V]];var X=o[this.link_formats[V]]?o[this.link_formats[V]]:S;O+=E[this.link_formats[V]];Z=X+Z}W+=O;ab+=Z;r=W+ab;this.link_formats=new Array();this.in_link=false}else{if(aa=="a"){this.link_formats=new Array();this.in_link=false}}},chars:function(R){R=R.replace(/\t/g,"    ");if(R.match(/~~START_HTML_BLOCK~~/)){R=R.replace(/~~START_HTML_BLOCK~~\n*/,"~~START_HTML_BLOCK~~\n<code>\n")}if(R.match(/~~CLOSE_HTML_BLOCK~~/)){R=R.replace(/~~CLOSE_HTML_BLOCK~~\n*/gm,"\n</code>\n\n~~CLOSE_HTML_BLOCK~~\n\n")}if(this.interwiki){R=R.replace(String.frasl,"/")}if(this.interwiki&&r.match(/>\w+\s*\|$/)){this.interwiki=false;if(this.attr){r+=R}else{r=r.replace(/>\w+\s*\|$/,">"+R)}return}if(this.in_multi_plugin){R=R.replace("&lt; ","&lt;")}R=R.replace(/&#39;/g,"'");R=R.replace(/^(&gt;)+/,function(T,S){return(T.replace(/(&gt;)/g,"__QUOTE__"))});r=r.replace(/([\/\*_])_FORMAT_SPACE_([\/\*_]{2})_FORMAT_SPACE_$/,"$1$2");if(R.match(/^&\w+;/)){r=r.replace(/_FORMAT_SPACE_\s*$/,"")}if(this.link_only){if(R){replacement="|"+R+"}} ";r=r.replace(/\}\}\s*$/,replacement)}return}if(!this.code_type){if(!this.last_col_pipes){R=R.replace(/\x20{6,}/,"   ");R=R.replace(/^(&nbsp;)+\s*$/,"_FCKG_BLANK_TD_");R=R.replace(/(&nbsp;)+/," ")}if(this.format_tag){if(!this.list_started||this.in_table){R=R.replace(/^\s+/,"@@_SP_@@")}}else{if(this.last_tag=="a"){R=R.replace(/^\s{2,}/," ")}else{R=R.replace(/^\s+/,"")}}if(R.match(/nowiki&gt;/)){I=true}if(this.format_in_list){R=R.replace(/^[\n\s]+$/g,"");if(R.match(/\n{2,}\s{1,}/)){R=R.replace(/\n{2,}/,"\n")}}if(this.in_td&&!R){R="_FCKG_BLANK_TD_";this.in_td=false}}else{R=R.replace(/&lt;\s/g,"<");R=R.replace(/\s&gt;/g,">");var i=R.match(/^\s*geshi:\s+(.*)$/m);if(i){r=r.replace(/<(code|file)>\s*$/,"<$1 "+i[1]+">");R=R.replace(i[0],"")}}if(this.attr&&this.attr=="dwfcknote"){if(R.match(/fckgL\d+/)){return}if(R.match(/^[\-,:;!_]/)){r+=R}else{r+=" "+R}return}if(this.downloadable_code&&(this.export_code||this.code_snippet)){this.downloadable_file=R;return}if(this.last_tag=="a"&&R.match(/^[\.,;\:\!]/)){r=r.replace(/\s$/,"")}if(this.in_header){R=R.replace(/---/g,"&mdash;");R=R.replace(/--/g,"&ndash;")}if(this.list_started){r=r.replace(/_LIST_EOFL_\s*L_BR_K\s*$/,"_LIST_EOFL_")}if(!this.code_type){if(!r.match(/\[\[\\\\.*?\|$/)&&!R.match(/\w:(\\(\w?))+/)){if(!R.match(/\\\\[\w\.\-\_]+\\[\w\.\-\_]+/)){R=R.replace(/([\\])/g,"%%$1%%")}R=R.replace(/([\*])/g,"_CKG_ASTERISK_")}}if(this.in_endnotes&&c.length){if(R.match(/\w/)&&!R.match(/^\s*\d\)\s*$/)){R=R.replace(/\)\s*$/,"_FN_PAREN_C_");var O=c.length-1;if(this.bottom_url){if(this.link_class&&this.link_class=="media"){R="{{"+this.bottom_url+"|"+R+"}}"}else{R="[["+this.bottom_url+"|"+R+"]]"}}if(x[c[O]]){R=R.replace("(","L_PARgr");R=R.replace(")","R_PARgr");x[c[O]]+=" "+R}else{R=R.replace("(","L_PARgr");R=R.replace(")","R_PARgr");x[c[O]]=R}}this.bottom_url=false;return}if(R&&R.length){r+=R}r=r.replace(/(&\w+;)\s*([\*\/_]{2})_FORMAT_SPACE_(\w+)/,"$1$2$3");if(this.list_level&&this.list_level>1){r=r.replace(/(\[\[.*?\]\])([ ]+[\*\-].*)$/," $1\n$2")}try{var Q=new RegExp("([*/_]{2,})_FORMAT_SPACE_([*/_]{2,})("+RegExp.escape(R)+")$");if(r.match(Q)){r=r.replace(Q,"$1$2$3")}}catch(P){}if(!e){if(R.match(/&lt;/)){e=true}}},comment:function(i){},dbg:function(O,i){if(O.replace){O=O.replace(/^\s+/g,"");O=O.replace(/^\n$/g,"");O=O.replace(/&/g,"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;");if(!O){return}}if(i){i="<b>"+i+"</b>\n"}HTMLParser_DEBUG+=i+O+"\n__________\n"}});r=r.replace(/(\[\[\\\\)(.*?)\]\]/gm,function(i,P,O){O=O.replace(/\\/g,"_SMB_");return P+O+"]]"});r=r.replace(/%%\\%%/g,"_ESC_BKSLASH_");r=r.replace(/%*\\%*([^\w]{1})%*\\%*/g,"$1");r=r.replace(/_SMB_/g,"\\");r=r.replace(/(\s*={2,})\s*CKGE_TMP_(\w+)(.*?)\s*CKGE_TMP_c?\2/gm,function(O,i){O=O.replace(/CKGE_TMP_\w+/gm,"");var P=jQuery("#formatdel").val();if(!P){jQuery("#dw__editform").append('<input type="hidden" id="formatdel" name="formatdel" value="del" />')}return O});r=r.replace(/(CKGE_TMP_\w+)/gm,function(O,i){if(l[i]){return l[i]}return O});if(B=="test"){if(!HTMLParser_test_result(r)){return}}r=r.replace(/\{ \{ rss&gt;Feed:/mg,"{{rss&gt;http://");r=r.replace(/~ ~ (NOCACHE|NOTOC)~ ~/mg,"~~$1~~");if(q){var u=function(i,O){tag_1=i.replace(/oIWIKIo(.*)cIWIKIc/,"$1");if(tag_1==O){return true}O=O.replace(/\s/,"%20");return(O==tag_1)};r=r.replace(/\[\[(\w+\.?\w{0,12})>(.*?)\|(.*?)\]\]/gm,function(O,Q,P,i){if(P=="oIWIKIocIWIKIc"){P=i}if((P=="oIWIKIo"+i.replace(/\s/,"%20")+"cIWIKIc")||(P==i)||u(P,i)){i=""}else{i="|"+i}return("[["+Q+">"+P+i+"]]")})}r=r.replace(/>.*?oIWIKIo(.*?)cIWIKIc/mg,">$1");if(H){if(h){r=r.replace(/\s*([\|\^]+)((\W\W_FORMAT_SPACE_)+)/gm,function(i,O,P){P=P.replace(/_FORMAT_SPACE_/g,"");return(P+O)})}r=r.replace(/&quot;/g,'"');var j=new RegExp(H+"([\\-]{2,})","g");r=r.replace(j," $1");var j=new RegExp("(\\w|\\d)(\\*\\*|\\/\\/|\\'\\'|__|</del>)"+H+"(\\w|\\d)","g");r=r.replace(j,"$1$2$3");var j=new RegExp(H+"@@_SP_@@","g");r=r.replace(j," ");r=r.replace(/([\*\/_]{2})@@_SP_@@(&\w+;)/g,"$1 $2");r=r.replace(/\n@@_SP_@@\n/g,"");r=r.replace(/@@_SP_@@\n/g,"");r=r.replace(/@@_SP_@@/g," ");var j=new RegExp(H+"([^\\)\\]\\}\\{\\-\\.,;:\\!?\"\x94\x92\u201D\u2019'])","g");r=r.replace(j," $1");j=new RegExp(H,"g");r=r.replace(j,"");if(g){r=r.replace(/(\s+[\-\*_]\s*)([\*\/_\']{2})(.*?)(\2)([^\n]*)\n+/gm,function(P,i,R,S,O,Q){return(i+R+S+O+Q+"\n")})}}var p="\\\\";if(N){r=r.replace(/(L_BR_K)+/g,p);r=r.replace(/L_BR_K/gm,p);r=r.replace(/(\\\\)\s+/gm,"$1 \n")}if(s){r=r.replace(/\s+<\/(code|file)>/g,"\n</$1>");if(b){r=r.replace(/\s+;/mg,";");r=r.replace(/&lt;\s+/mg,"<");r=r.replace(/\s+&gt;/mg,">")}}if(J){r+="\n"+p+"\n";var j=new RegExp(d,"g");r=r.replace(j," "+p+" ");r=r.replace(/(\||\^)[ ]+(\||\^)\s$/g,"$1\n");r=r.replace(/(\||\^)[ ]+(\||\^)/g,"$1")}r=r.replace(/_FCKG_BLANK_TD_/g," ");if(e){r=r.replace(/\/\/&lt;\/\/\s*/g,"&lt;")}if(M){r=r.replace(/(<font[^\>]+>)([^<]+\]\])[^\>]+\/font>/gm,function(P,O,i){i=i.replace(/\n/gm,"");i=i.replace(/\s/gm,"");var Q=prompt(LANG.plugins.ckgedit.font_err_1+"\n [["+i+"\n"+LANG.plugins.ckgedit.font_err_2);if(Q==null){throw new Error(LANG.plugins.ckgedit.font_err_throw)}if(Q){return Q}return"[["+i});r=r.replace(/(\|<font[^\>]+>)([^<]+)<\/font>([^\]]+)\]\]/gm,function(Q,O,i){i=i.replace(/\n/gm,"");Q="|"+i+"]]";var P=jQuery("#fontdel").val();if(!P){jQuery("#dw__editform").append('<input type="hidden" id="fontdel" name="fontdel" value="del" />')}return Q})}if(c.length){r=r.replace(/<sup>\(\(\){2,}\s*<\/sup>/g,"");r=r.replace(/\(\(+(\d+)\)\)+/,"(($1))");for(var K in x){var a=K.match(/_(\d+)/);var k=new RegExp("(<sup>)*[(]+"+a[1]+"[)]+(</sup>)*");x[K]=x[K].replace(/(\d+)_FN_PAREN_C_/,"");r=r.replace(k,"(("+x[K].replace(/_FN_PAREN_C_/g,") ")+"))")}r=r.replace(/<sup><\/sup>/g,"");r=r.replace(/((<sup>\(\(\d+\)\)\)?<\/sup>))/mg,function(i){if(!i.match(/p>\(\(\d+/)){return""}return i})}r=r.replace(/(={3,}.*?)(\{\{.*?\}\})(.*?={3,})/g,"$1$3\n\n$2");r=r.replace(/(<sup>)*\s*\[\[\s*\]\]\s*(<\/sup>)*\n*/g,"");r=r.replace(/<sup>\s*\(\(\d+\)\)\s*<\/sup>/mg,"");if(L){r=r.replace(/<\s+/g,"<");r=r.replace(/&lt;\s+/g,"<")}if(I){var w="%";var j=new RegExp("(["+w+"])","g");r=r.replace(/(&lt;nowiki&gt;)(.*?)(&lt;\/nowiki&gt;)/mg,function(O,Q,i,P){i=i.replace(/%%(.)%%/mg,"NOWIKI_$1_");return Q+i.replace(j,"NOWIKI_$1_")+P})}r=r.replace(/__SWF__(\s*)\[*/g,"{{$1");r=r.replace(/\|.*?\]*(\s*)__FWS__/g,"$1}}");r=r.replace(/(\s*)__FWS__/g,"$1}}");r=r.replace(/\n{3,}/g,"\n\n");r=r.replace(/_LIST_EOFL_/gm," "+p+" ");if(z){if(r.indexOf("~~COMPLEX_TABLES~~")==-1){r+="~~COMPLEX_TABLES~~\n"}}else{r=r.replace(/~~COMPLEX_TABLES~~/gm,"")}r=r.replace(/_CKG_ASTERISK_/gm,"*");r=r.replace(/_ESC_BKSLASH_/g,"\\");if(B=="test"){if(HTMLParser_test_result(r)){alert(r)}return}var C=GetE("dw__editform");C.elements.fck_wikitext.value=r;if(B=="bakup"){return}if(B){var f=GetE(B);f.click();return true}}jQuery(document).ready(function(){jQuery("#ebut_test").mousedown(function(){parse_wikitext("test")});jQuery("#ebtn__delete").click(function(){return confirm(JSINFO.confirm_delete)});jQuery("#ebtn__delete").mouseup(function(){draft_delete()});jQuery("#ebtn__dwedit").click(function(){setDWEditCookie(2,this);parse_wikitext("edbtn__save");this.form.submit()});jQuery("#ckgedit_draft_btn").click(function(){ckgedit_get_draft()});jQuery("#backup_button").click(function(){renewLock(true)});jQuery("#revert_to_prev_btn").click(function(){revert_to_prev()});jQuery("#no_styling_btn").click(function(){this.form.styling.value="no_styles";this.form.prefix.value="";this.form.suffix.value="";this.form.rev.value=""});jQuery("#ebut_cancel").mouseup(function(){draft_delete()});jQuery("#save_button").mousedown(function(){if(!window.dwfckTextChanged){ckgedit_dwedit_reject=true;parse_wikitext("ebut_cancel")}else{parse_wikitext("edbtn__save")}})});
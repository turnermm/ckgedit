oDokuWiki_FCKEditorInstanceInLinkDialog=true;var update_ckgeditInternalLink,update_ckgeditMediaLink;var fckgInternalInputId,fckgMediaInputId,ckgeditIwikiData,ckgeditIwikiIndex;var ck_m_files_protocol,ckg_dialog,linkOpt;window.onbeforeunload=function(){};CKEDITOR.dialog.add("link",function(b){oDokuWiki_FCKEditorInstance.Lang=b.lang;ck_m_files_protocol=oDokuWiki_FCKEditorInstance.mfiles?["m-files://\u200E","m-files://"]:"";var y=oDokuWiki_FCKEditorInstance.dwiki_doku_base;var T=CKEDITOR.plugins.link;var g=new Object();g.doku_base=new RegExp("^"+y.replace(/\//g,"\\/"),"g");g.media_internal=/lib\/exe\/fetch\.php\/(.*)/;g.media_rewrite_1=/^_media\/(.*)/;g.media_rewrite_1Doku_Base=new RegExp("^"+y+"_media/(.*)");g.media_rewrite_2=/exe\/fetch.php\?media=(.*)/;g.internal_link=/doku.php\?id=(.*)/;g.internal_link_rewrite_2=/doku.php\/(.*)/;g.internal_link_rewrite_1=new RegExp("^"+y+"(?!_media)(.*)");g.samba=/file:\/\/\/\/\/(.*)/;g.interwiki=/^(.*?)oIWIKIo(.*?)cIWIKIc/;g.samba_unsaved=/^\\\\\w+(\\\w.*)/;ckg_dialog=CKEDITOR.dialog;var D;var J={InternalLink:"internal link",LinkText:"<span style='font-weight:bold'>Link Display Text</span><br />User defined Text (takes precedence over Page Name or  ID)",InternalMedia:"internal media",LinkPageOrId:"Page Name creates default Dokuwiki Link: <code>[[namespace:page|]]</code><br />ID creates: <code>[[namespace:page|namespace:page]]</code>",MediaFileLink:"link to media file",SMBLabel:"Samba Share",GetHeadingsLabel:"Get Headings",QStringLabel:"Query String (For example: value_1=1&value_2=2) ",ResetQS:"Reset Query String",NotSetOption:"Not Set",AdvancedInfo:"To create anchors from Dokuwiki headers, click on the Get Headings button, select the header, click OK. You can go back, select a new page and get new headers.",AdvancedTabPrompt:"Use the advanced tab to create page anchors and query strings",SMBExample:"Enter your share as: \\\\Server\\directory\\file",InterWikiLink:"Interwiki Link",InterWikiType:"Interwiki Type",InterwikiPlaceHolder:"Interwiki Replacement Text",InterwikiInfo:"<div style='max-width:350px; white-space: pre-wrap;border:1px solid #cccccc; margin:auto; overflow:auto; padding:4px;line-height:125%;'>Dokuwiki's interwiki links are short-cuts which look like this: <span style='font-weight:600'>[[wp&gt;Shakespeare]]</span>, which will create a link to the English Wikipedia article on Shakespeare.  The <span style='font-weight:600'>wp</span> part designates a link pattern;  the text following the '<span style='font-weight:900'>&gt;</span>' will be inserted into the link, replacing  a place holder, which is enclosed in curly brackets, as in <span style='font-weight:600'>{NAME}</span>. When there is no place holder, the replacement text will be appended to the end of the link.</div>",MediaFileLink:"link to media file",URLText:"<span style='font-weight:bold'>URL Display Text (optional, defaults to url)</span>"};var s=b.lang.fbrowser?b.lang.fbrowser:J;var k=function(W){if(s[W]&&s[W]!=""){return s[W]}return J[W]};jQuery.ajax({method:"POST",url:DOKU_BASE+"lib/exe/ajax.php",data:{call:"iwiki_list"},async:true,dataType:"json"}).done(function(W){retv=W;ckgeditIwikiData=retv}).fail(function(W,Y,X){alert(Y);alert(X)});var R=function(){var Z=this.getDialog();var ab=Z.getContentElement("advanced","internalAnchor").getInputElement().$.id;var W=document.getElementById(ab);var Y=Z.getContentElement("info","internal").getInputElement().$.id;Y=document.getElementById(Y).value;if(!Y){return}var X={push:function(ad,ac){this.stack[this.Index]=(new Option(ad,ac,false,false));this.Index++},Index:0,stack:undefined,selection:"",ini:function(ac){this.stack=W.options;this.stack.length=0;this.Index=0;this.push(ac,"")}};var aa="dw_id="+Y;b.config.jquery.post(b.config.ckedit_path+"get_headers.php",aa,function(ag,ac){if(ac=="success"){var ah=decodeURIComponent(ag);if(ah.match(/^\s*__EMPTY__\s*$/)){X.ini("No Headers Found");X.selection="";return}X.ini("Headings Menu");var af=ah.split("@@");for(var ae in af){var ad=af[ae].split(/;;/);X.push(ad[0],ad[1])}}},"html")};var C=function(){doku_linkwiz.init(jQuery("#dw__editform"),b);doku_linkwiz.val="global";doku_linkwiz.toggle()};var M=function(W){return jQuery.ajax({method:"POST",url:DOKU_BASE+"lib/exe/ajax.php",data:{dw_id:encodeURIComponent(W),call:call="use_heads"},async:true,dataType:"html"}).fail(function(X,Z,Y){alert("Error: "+Z+"/"+Y)})};var U=function(){return D};var q;var n=function(){oDokuWiki_FCKEditorInstance.isLocalDwikiBrowser=false;oDokuWiki_FCKEditorInstance.isUrlExtern=false;oDokuWiki_FCKEditorInstance.isDwikiMediaFile=false;var Z=this.getDialog(),ac=["urlOptions","anchorOptions","emailOptions","internalOptions","mediaOptions","sambaOptions","interwikiOptions"],ab=this.getValue(),aa=Z.definition.getContents("upload"),W=aa&&aa.hidden;Z.hidePage("advanced");if(ab=="internal"){oDokuWiki_FCKEditorInstance.isLocalDwikiBrowser=true;Z.showPage("advanced")}else{if(ab=="media"){oDokuWiki_FCKEditorInstance.isDwikiMediaFile=true}}if(ab=="url"){oDokuWiki_FCKEditorInstance.isUrlExtern=true;if(!W){Z.showPage("upload")}}else{if(!W){Z.hidePage("upload")}}for(var Y=0;Y<ac.length;Y++){var X=Z.getContentElement("info",ac[Y]);if(!X){continue}X=X.getElement().getParent().getParent();if(ac[Y]==ab+"Options"){X.show()}else{X.hide()}}Z.layout()};var L=/^javascript:/,N=/^mailto:([^?]+)(?:\?(.+))?$/,j=/subject=([^;?:@&=$,\/]*)/,V=/body=([^;?:@&=$,\/]*)/,v=/^#(.*)$/,c=/^((?:http|https|ftp|news|m-files):\/\/)?(.*)$/,w=/^(_(?:self|top|parent|blank))$/,p=/^javascript:void\(location\.href='mailto:'\+String\.fromCharCode\(([^)]+)\)(?:\+'(.*)')?\)$/,I=/^javascript:([^(]+)\(([^)]+)\)$/;var r=y.replace("/","/")+"doku.php?id=(.*)$";var a="/"+r+"/";var m=/\s*window.open\(\s*this\.href\s*,\s*(?:'([^']*)'|null)\s*,\s*'([^']*)'\s*\)\s*;\s*return\s*false;*\s*/;var A=/(?:^|,)([^=]+)=(\d+|yes|no)/gi;var o=function(Z,W){var ap=(W&&(W.data("cke-saved-href")||W.getAttribute("href")))||"",ad,ao,al,ae,ag={};if((ad=ap.match(L))){if(l=="encode"){ap=ap.replace(p,function(au,aw,av){return"mailto:"+String.fromCharCode.apply(String,aw.split(","))+(av&&u(av))})}else{if(l){ap.replace(I,function(aA,aC,ax){if(aC==K.name){ag.type="email";var aB=ag.email={};var av=/[^,\s]+/g,aw=/(^')|('$)/g,au=ax.match(av),aD=au.length,az,aE;for(var ay=0;ay<aD;ay++){aE=decodeURIComponent(u(au[ay].replace(aw,"")));az=K.params[ay].toLowerCase();aB[az]=aE}aB.address=[aB.name,aB.domain].join("@")}})}}}if(!ag.type){var am=W?W.getAttribute("class"):"";if((al=ap.match(v))){ag.type="anchor";ag.anchor={};ag.anchor.name=ag.anchor.id=al[1]}else{if((ao=ap.match(N))){var af=ap.match(j),ah=ap.match(V);ag.type="email";var aj=(ag.email={});aj.address=ao[1];af&&(aj.subject=decodeURIComponent(af[1]));ah&&(aj.body=decodeURIComponent(ah[1]))}else{if((ae=ap.match(g.media_internal))||(ae=ap.match(g.media_rewrite_1))||(ae=ap.match(g.media_rewrite_2))||(ae=ap.match(g.media_rewrite_1Doku_Base))){ag.type="media";ag.url={};ag.url.protocol="";ag.url.url="";ag.url.selected=ae[1]}else{if((ae=ap.match(a))||(ae=ap.match(g.internal_link_rewrite_2))||(ae=ap.match(g.internal_link_rewrite_1))){ag.type="internal";ag.url={};var Y=ae[1].split("=");ag.url.selected=Y[1];ag.url.protocol="";ag.url.url=""}else{if(ae=ap.match(g.samba)){ag.type="samba";ag.url={};ag.url.url="";ag.url.protocol="";ag.url.selected="\\\\"+ae[1].replace(/\//g,"\\")}else{if(ae=ap.match(g.samba_unsaved)){ag.type="samba";ag.url={};ag.url.url="";ag.url.protocol="";ag.url.selected=ae[0]}else{if(ae=ap.match(g.interwiki)||am.match(/interwiki/)){var ak="";if(ae&&ae[2]){ak=decodeURIComponent(ae[2])}ag.url={};q=W.getAttribute("class");var ac=ckg_dialog.getContentElement("info","iwiki_shortcut");var aq=ac.getInputElement().$.id;var ai=document.getElementById(aq);var ab=q.match(/iw_([^\s]+)/);var aa=ab[1].replace(/_/,".");if(!ak){var an=ckgeditIwikiData[aa];an=an.replace(/\{\w+\}$/,"");var X=new RegExp(an+"(.*)");ab=ap.match(X);ak=ab[1]}aa=ckgeditIwikiIndex[aa];if(aa){ai.selectedIndex=aa}else{ai.selectedIndex="0"}ac.disable();ag.type="interwiki";ag.url.selected=ak;ag.url.url=ak}else{if(ap&&(ae=ap.match(c))){ag.type="url";ag.url={};ag.url.protocol=ae[1];ag.url.url=ae[2]}else{ag.type="url"}}}}}}}}}if(W){var at=W.getAttribute("target");ag.target={};ag.adv={};var ar=this}this._.selectedElement=W;return ag};var E=function(W){if(!W){return}document.getElementById(fckgInternalInputId).disabled=true;document.getElementById(fckgInternalInputId).style.fontWeight="bold";document.getElementById(fckgInternalInputId).style.backgroundColor="#DDDDDD";W=W.replace(/^[\/\:]/,"");W=W.replace(/\//g,":");W=":"+W;document.getElementById(fckgInternalInputId).value=W};update_ckgeditInternalLink=E;var d=function(W){if(!W){return}W=W.replace(/^[\/\:]/,"");W=W.replace(/\//g,":");W=":"+W;document.getElementById(fckgMediaInputId).value=W};update_ckgeditMediaLink=d;var t=function(W){for(i in W){msg=i+"="+W[i];if(!confirm(msg)){break}}};var z=function(X,W){if(W[X]){this.setValue(W[X][this.id]||"")}};var P=function(W){return z.call(this,"target",W)};var O=function(W){return z.call(this,"adv",W)};var S=function(X,W){if(!W[X]){W[X]={}}W[X][this.id]=this.getValue()||""};var B=function(W){return S.call(this,"target",W)};var Q=function(W){return S.call(this,"adv",W)};function u(W){return W.replace(/\\'/g,"'")}function F(W){return W.replace(/'/g,"\\$&")}var l=b.config.emailProtection||"";if(l&&l!="encode"){var K={};l.replace(/^([^(]+)\(([^)]+)\)$/,function(W,X,Y){K.name=X;K.params=[];Y.replace(/[^,\s]+/g,function(Z){K.params.push(Z)})})}function f(Y){var W,X=K.name,ac=K.params,aa,ab;W=[X,"("];for(var Z=0;Z<ac.length;Z++){aa=ac[Z].toLowerCase();ab=Y[aa];Z>0&&W.push(",");W.push("'",ab?F(encodeURIComponent(Y[aa])):"","'")}W.push(")");return W.join("")}function x(X){var W,aa=X.length,Y=[];for(var Z=0;Z<aa;Z++){W=X.charCodeAt(Z);Y.push(W)}return"String.fromCharCode("+Y.join(",")+")"}function H(X){var W=X.getAttribute("class");return W?W.replace(/\s*(?:cke_anchor_empty|cke_anchor)(?:\s*$)?/g,""):""}var G=b.lang.common,h=b.lang.link;linkOpt={};var e=CKEDITOR.instances.wiki__text.config.filebrowserBrowseUrl;if(e.indexOf("fckeditor")===-1){linkOpt={type:"button",id:"browse1",label:G.browseServer,onClick:C}}else{linkOpt={type:"button",id:"browse1",label:G.browseServer,filebrowser:"info:url"}}return{title:h.title,minWidth:375,minHeight:250,contents:[{id:"info",label:h.info,title:h.info,elements:[{id:"linkType",type:"select",label:h.type,"default":"url",items:[[h.toUrl,"url"],[k("InternalLink"),"internal"],[k("InternalMedia"),"media"],[h.toEmail,"email"],[k("SMBLabel"),"samba"],[k("InterWikiLink"),"interwiki"]],onChange:n,setup:function(W){if(W.type){this.setValue(W.type)}},commit:function(W){W.type=this.getValue()}},{type:"vbox",id:"urlOptions",children:[{type:"hbox",widths:["25%","75%"],children:[{id:"protocol",type:"select",label:G.protocol,"default":"http://",items:[["http://\u200E","http://"],["https://\u200E","https://"],["ftp://\u200E","ftp://"],["news://\u200E","news://"],ck_m_files_protocol],setup:function(W){if(W.url){this.setValue(W.url.protocol||"")}},commit:function(W){if(!W.url){W.url={}}W.url.protocol=this.getValue()}},{type:"text",id:"url",label:G.url,required:true,onLoad:function(){this.allowOnChange=true},onKeyUp:function(){this.allowOnChange=false;var Y=this.getDialog().getContentElement("info","protocol"),W=this.getValue(),X=/^(http|https|ftp|news|m-files):\/\/(?=.)/i,aa=/^((javascript:)|[#\/\.\?])/i;var Z=X.exec(W);if(Z){this.setValue(W.substr(Z[0].length));Y.setValue(Z[0].toLowerCase())}else{if(aa.test(W)){Y.setValue("")}}this.allowOnChange=true},onChange:function(){if(this.allowOnChange){this.onKeyUp()}},validate:function(){var W=this.getDialog();if(W.getContentElement("info","linkType")&&W.getValueOf("info","linkType")!="url"){return true}if(this.getDialog().fakeObj){return true}var X=CKEDITOR.dialog.validate.notEmpty(h.noUrl);return X.apply(this)},setup:function(W){this.allowOnChange=false;if(W.url){this.setValue(W.url.url)}this.allowOnChange=true},commit:function(W){this.onChange();if(!W.url){W.url={}}W.url.url=this.getValue();this.allowOnChange=false}}],setup:function(W){if(!this.getDialog().getContentElement("info","linkType")){this.getElement().show()}}},{type:"text",id:"url_text",label:k("URLText"),required:false}]},{type:"vbox",id:"internalOptions",children:[linkOpt,{type:"text",id:"internal",label:k("InternalLink"),required:true,setup:function(W){if(W){if(W.url&&W.url.selected){var X=W.url.selected.replace(/^\:/,"");this.setValue(":"+X)}}}},{type:"text",id:"internal_text",label:k("LinkText"),required:false},{type:"radio",id:"ilinkstyle",label:k("LinkPageOrId"),items:[["Page Name","page"],["ID","id"]],"default":"page",required:false},{id:"anchorsmsg",type:"html",html:k("AdvancedTabPrompt")}]},{type:"vbox",id:"interwikiOptions",children:[{type:"text",id:"interwiki",label:k("InterwikiPlaceHolder"),required:true,setup:function(W){if(W){if(W.url&&W.url.selected){var X=W.url.selected.replace(/^\:/,"");this.setValue(X)}}},commit:function(W){if(!W.url){W.url={}}W.url.selection=this.getValue()}},{id:"iwiki_shortcut",type:"select",label:k("InterWikiType"),"default":"",items:[["Not Set","Not-Set"]],setup:function(W){if(W.url){this.setValue(W.url.iwiki_shortcut||"")}},commit:function(W){if(!W.url){W.url={}}W.url.iwiki_shortcut=this.getValue()}},{id:"iwikimsg",type:"html",html:k("InterwikiInfo")}]},{type:"vbox",id:"mediaOptions",children:[{type:"button",id:"browse2",filebrowser:"info:media",label:G.browseServer},{type:"text",id:"media",label:k("MediaFileLink"),required:true,setup:function(W){if(W){if(W.url&&W.url.selected){var X=W.url.selected.replace(/^\:/,"");this.setValue(":"+X)}}}}]},{type:"vbox",id:"sambaOptions",children:[{type:"html",id:"smb_msg",html:k("SMBExample")},{type:"text",id:"samba",width:"50",label:k("SMBLabel"),required:true,setup:function(W){if(W.url&&W.url.selected){this.setValue(W.url.selected)}}}]},{type:"vbox",id:"emailOptions",padding:1,children:[{type:"text",id:"emailAddress",label:h.emailAddress,required:true,validate:function(){var W=this.getDialog();if(!W.getContentElement("info","linkType")||W.getValueOf("info","linkType")!="email"){return true}var X=CKEDITOR.dialog.validate.notEmpty(h.noEmail);return X.apply(this)},setup:function(X){if(X.email){this.setValue(X.email.address)}var W=this.getDialog().getContentElement("info","linkType");if(W&&W.getValue()=="email"){this.select()}},commit:function(W){if(!W.email){W.email={}}W.email.address=this.getValue()}},{type:"text",id:"emailSubject",label:h.emailSubject,setup:function(W){if(W.email){this.setValue(W.email.subject)}},commit:function(W){if(!W.email){W.email={}}W.email.subject=this.getValue()}},{type:"textarea",id:"emailBody",label:h.emailBody,rows:3,"default":"",setup:function(W){if(W.email){this.setValue(W.email.body)}},commit:function(W){if(!W.email){W.email={}}W.email.body=this.getValue()}}],setup:function(W){if(!this.getDialog().getContentElement("info","linkType")){this.getElement().hide()}}}]},{id:"upload",label:h.upload,title:h.upload,hidden:true,filebrowser:"uploadButton",elements:[{type:"file",id:"upload",label:G.upload,style:"height:40px",size:29},{type:"fileButton",id:"uploadButton",label:G.uploadSubmit,filebrowser:"info:url","for":["upload","upload"]}]},{id:"advanced",label:h.advanced,title:h.advanced,elements:[{id:"msg",type:"html",html:"<p style='max-width:350px; white-space: pre-wrap;'>"+k("AdvancedInfo")+"</p>"},{id:"internalAnchor",type:"select","default":"",items:[["Not Set",""]],setup:function(W){if(W.hash){this.setValue(W.hash)}},commit:function(W){W.hash=this.getValue()}},{type:"button",id:"getheaders",onClick:R,label:k("GetHeadingsLabel")},{type:"html",html:"<br />"},{type:"text",id:"queryString",label:k("QStringLabel"),setup:function(W){if(W.qstring){this.setValue(W.qstring)}},commit:function(W){W.qstring=this.getValue()}},{type:"button",id:"clearquerystring",onClick:function(){var X=this.getDialog();var Y=X.getContentElement("advanced","queryString").getInputElement().$.id;var W=document.getElementById(Y);W.value=""},label:k("ResetQS")},{type:"vbox",padding:1,hidden:true,children:[{type:"hbox",widths:["45%","55%"],children:[{type:"text",label:h.cssClasses,"default":"",id:"advCSSClasses",setup:O,commit:Q},{type:"text",label:h.charset,"default":"",id:"advCharset",setup:O,commit:Q}]}]}]}],onShow:function(){var Y=this.getParentEditor(),X=Y.getSelection(),W=null;if((W=T.getSelectedLink(Y))&&W.hasAttribute("href")){X.selectElement(W)}else{W=null}this.setupContent(o.apply(this,[Y,W]))},onOk:function(){var Y=function(Z){if(!Z){Z=document.getElementById(fckgInternalInputId).value;if(!Z.match(/^:\w+/)){var aa=top.getCurrentWikiNS()+":";aa=aa.replace(/:$/,"");var ab=new RegExp(":?"+aa+":");if(!Z.match(ab)){Z=aa+":"+Z;Z=Z.replace(/\:{2,}/g,":")}}}Z=Z.replace(/^.*?\/data\/pages\//,"");Z=Z.replace(/^\:/,"");Z=":"+Z.replace(/\//g,":");return Z};var X=jQuery.proxy(function(aN,aE){var ag=false;var aF=new RegExp(oDokuWiki_FCKEditorInstance.imageUploadAllowedExtensions);var aC={},ap=[],aA="page",ao=this,aO=false,Z=this.getParentEditor();var aK=false;var aG="";switch(aN.type||"url"){case"media":if(document.getElementById(fckgMediaInputId).value){aN.url.url=document.getElementById(fckgMediaInputId).value}aN.adv.advTitle=aN.url.url;var an=aN.url.url.match(/(\.(\w+))$/);aG=aN.url.url.replace(/^:/,"");aN.url.url=top.dokuBase+"doku.php?id="+aN.url.url;if(an[1].match(aF)){aN.adv.advContentType="linkonly"}else{aN.adv.advContentType="other_mime";aN.url.url=top.dokuBase+"lib/exe/fetch.php?media="+aG;aK=true}aN.adv.advCSSClasses="media mediafile";if(an){aN.adv.advCSSClasses+=" mf_"+an[2]}var al=(aN.url&&aN.url.protocol!=undefined)?aN.url.protocol:"http://",ab=(aN.url&&CKEDITOR.tools.trim(aN.url.url))||"";aC["data-cke-saved-href"]=(ab.indexOf("/")===0)?ab:al+ab;break;case"internal":ag=this.getValueOf("info","internal_text");ilinkstyle=this.getValueOf("info","ilinkstyle");if(!aN.url.url){aN.url.url=document.getElementById(fckgInternalInputId).value;if(!aN.url.url.match(/^:\w+/)){var aL=top.getCurrentWikiNS()+":";aL=aL.replace(/:$/,"");var ac=new RegExp(":?"+aL+":");if(!aN.url.url.match(ac)){aN.url.url=aL+":"+aN.url.url;aN.url.url=aN.url.url.replace(/\:{2,}/g,":")}}}aN.url.url=aN.url.url.replace(/^.*?\/data\/pages\//,"");aN.url.url=aN.url.url.replace(/^\:/,"");aN.url.url=":"+aN.url.url.replace(/\//g,":");aN.adv.advCSSClasses="wikilink1";if(aE&&oDokuWiki_FCKEditorInstance.useheading=="y"){var aH=aE;var ax=aH.replace(/^:/,"");var aw=aN.url.url.replace(/^:/,"");if(ax!=aw){aN.adv.advTitle=aH;aO=true}else{aO=false}}if(ilinkstyle=="page"&&!aO){var ae=aN.url.url.split(":");aN.adv.advTitle=ae.pop()}else{if(!aO){aN.adv.advTitle=aN.url.url}}aN.url.url=top.dokuBase+"doku.php?id="+aN.url.url;if(aN.hash){aN.url.url+="#"+aN.hash}if(aN.qstring){aN.url.url+="&"+aN.qstring}var al=(aN.url&&aN.url.protocol!=undefined)?aN.url.protocol:"http://",ab=(aN.url&&CKEDITOR.tools.trim(aN.url.url))||"";aC["data-cke-saved-href"]=(ab.indexOf("/")===0)?ab:al+ab;break;case"interwiki":if(q){aN.adv.advCSSClasses=q}else{aN.adv.advCSSClasses="interwiki iw_"+aN.url.iwiki_shortcut}var aa=ckgeditIwikiData[aN.url.iwiki_shortcut];aN.adv.advTitle=aN.url.selection;if(aN.url.selection){aN.url.selection="oIWIKIo"+aN.url.selection+"cIWIKIc"}if(aa.match(/\{.*?\}/)){aN.url.url=ckgeditIwikiData[aN.url.iwiki_shortcut].replace(/{.*?}/,aN.url.selection)}else{aN.url.url=aa+aN.url.selection}aC["data-cke-saved-href"]=aN.url.url;break;case"url":var al=(aN.url&&aN.url.protocol!=undefined)?aN.url.protocol:"http://",ab=(aN.url&&CKEDITOR.tools.trim(aN.url.url))||"";aC["data-cke-saved-href"]=(ab.indexOf("/")===0)?ab:al+ab;url_text=this.getValueOf("info","url_text");break;case"anchor":var ai=(aN.anchor&&aN.anchor.name),aB=(aN.anchor&&aN.anchor.id);aC["data-cke-saved-href"]="#"+(ai||aB||"");break;case"samba":if(!aN.url.url){aN.url.url=document.getElementById(U()).value}if(!aN.url.url){alert("Missing Samba Url");return false}aN.url.protocol="";var al="";ab=(aN.url&&CKEDITOR.tools.trim(aN.url.url))||"";aC["data-cke-saved-href"]=(ab.indexOf("/")===0)?ab:al+ab;aN.adv.advCSSClasses="windows";aN.adv.advTitle=aN.url.url;break;case"email":var ay,au=aN.email,aJ=au.address;switch(l){case"":case"encode":var ad=encodeURIComponent(au.subject||""),av=encodeURIComponent(au.body||"");var af=[];av&&af.push("body="+av);ad&&af.push("subject="+ad);af=af.length?"?"+af.join("&"):"";if(l=="encode"){ay=["javascript:void(location.href='mailto:'+",x(aJ)];af&&ay.push("+'",F(af),"'");ay.push(")")}else{ay=["mailto:",aJ,af]}break;default:var ak=aJ.split("@",2);au.name=ak[0];au.domain=ak[1];ay=["javascript:",f(au)]}aC["data-cke-saved-href"]=ay.join("");break}if(aN.adv){var aD=function(aP,aQ){var aR=aN.adv[aP];if(aR){aC[aQ]=aR}else{ap.push(aQ)}};aD("advId","id");aD("advLangDir","dir");aD("advAccessKey","accessKey");if(aN.adv.advName){aC.name=aC["data-cke-saved-name"]=aN.adv.advName}else{ap=ap.concat(["data-cke-saved-name","name"])}aD("advLangCode","lang");aD("advTabIndex","tabindex");if(!aK){aD("advTitle","title")}aD("advContentType","type");aD("advCSSClasses","class");aD("advCharset","charset");aD("advStyles","style");aD("advRel","rel")}var aj=Z.getSelection();var ar=aj.getSelectedText()?aj.getSelectedText():false;aC.href=aC["data-cke-saved-href"];if(!this._.selectedElement){var am=aj.getRanges(true);if(am.length==1&&am[0].collapsed){var az=new CKEDITOR.dom.text(aN.type=="email"?aN.email.address:aC["data-cke-saved-href"],Z.document);am[0].insertNode(az);am[0].selectNodeContents(az);aj.selectRanges(am)}if(navigator.userAgent.match(/(Trident|MSIE)/)){var aM=Z.document.createElement("a");aM.setAttribute("href",aC.href);if(!ar&&(aN.type=="media"||aN.type=="internal")){if(ag){aM.setHtml(ag)}else{aM.setHtml(aN.adv.advTitle)}}else{aM.setHtml(aj.getSelectedText())}for(attr in aC){if(attr.match(/href/i)){continue}aM.setAttribute(attr,aC[attr])}Z.insertElement(aM)}else{var aI=new CKEDITOR.style({element:"a",attributes:aC});aI.type=CKEDITOR.STYLE_INLINE;aI.apply(Z.document)}}else{var ah=this._.selectedElement,at=ah.data("cke-saved-href"),aq=ah.getHtml();if(aK){aC.type="other_mime";aC.title=":"+aG}ah.setAttributes(aC);ah.removeAttributes(ap);if(aN.adv&&aN.adv.advName&&CKEDITOR.plugins.link.synAnchorSelector){ah.addClass(ah.getChildCount()?"cke_anchor":"cke_anchor_empty")}if(at==aq||aN.type=="email"&&aq.indexOf("@")!=-1){ah.setHtml(aN.type=="email"?aN.email.address:aC["data-cke-saved-href"])}aj.selectElement(ah);delete this._.selectedElement}if(ag){az.setText(ag)}else{if(url_text){az.setText(url_text)}else{if(az&&aN.adv.advTitle){az.setText(aN.adv.advTitle)}}}},this);var W={};this.commitContent(W);if(W.type=="internal"&&oDokuWiki_FCKEditorInstance.useheading=="y"){jQuery.when(M(Y(W.url.url)).then(function(Z){X(W,Z)}))}else{X(W)}},onLoad:function(){ckg_iwi_Select_Id_x=this.getContentElement("info","iwiki_shortcut").getInputElement().$.id;var Y=function(){if(!ckgeditIwikiData){return}ac();var ad=document.getElementById(ckg_iwi_Select_Id_x);this.stack=ad.options;this.stack.length=0;this.stack[0]=(new Option("Not Set","not-set",false,false));ckgeditIwikiIndex=new Array();var af=1;for(var ae in ckgeditIwikiData){this.stack[af]=new Option(ae+" >> "+ckgeditIwikiData[ae],ae,false,false);ckgeditIwikiIndex[ae]=af;af++}};var X=setInterval(function(){Y()},1000);var ac=function(){clearInterval(X)};oDokuWiki_FCKEditorInstance.isDwikiImage=false;fckgInternalInputId=this.getContentElement("info","internal").getInputElement().$.id;fckgMediaInputId=this.getContentElement("info","media").getInputElement().$.id;D=this.getContentElement("info","samba").getInputElement().$.id;var aa=this.getContentElement("info","iwiki_shortcut").getInputElement().$.id;this.getContentElement("info","media").disable();this.hidePage("advanced");this.showPage("info");ckg_dialog=this;var Z=this._.tabs.advanced&&this._.tabs.advanced[0];var W=this;var ab=k("NotSetOption");Z.on("focus",function(ae){var af=W.getContentElement("advanced","internalAnchor").getInputElement().$.id;var ad=document.getElementById(af);ad.selectedIndex=-1;ad.options.length=0;ad.options[0]=new Option(ab,"",false,false)})},onFocus:function(){var W=this.getContentElement("info","linkType"),X;if(W&&W.getValue()=="url"){X=this.getContentElement("info","url");X.select()}}}});var doku_linkwiz={$wiz:null,$entry:null,result:null,timer:null,textArea:null,selected:null,$ck:null,init:function(b,a){var c=b.position();$ck=a;if(doku_linkwiz.$wiz){return}doku_linkwiz.$wiz=jQuery(document.createElement("div")).dialog({autoOpen:false,draggable:true,title:LANG.linkwiz,resizable:false}).html("<div>"+LANG.linkto+' <input type="text" class="edit" id="link__wiz_entry" autocomplete="off" /></div><div id="link__wiz_result"></div>').parent().attr("id","link__wiz").css({position:"absolute",top:(c.top+20)+"px",left:(c.left+80)+"px","z-index":"20000"}).hide().appendTo(".dokuwiki:first");doku_linkwiz.textArea=b[0];doku_linkwiz.result=jQuery("#link__wiz_result")[0];jQuery(doku_linkwiz.result).css("position","relative");doku_linkwiz.$entry=jQuery("#link__wiz_entry");if(JSINFO.namespace){doku_linkwiz.$entry.val(JSINFO.namespace+":")}jQuery("#link__wiz .ui-dialog-titlebar-close").click(doku_linkwiz.hide);doku_linkwiz.$entry.keyup(doku_linkwiz.onEntry);jQuery(doku_linkwiz.result).delegate("a","click",doku_linkwiz.onResultClick)},onEntry:function(a){if(a.keyCode==37||a.keyCode==39){return true}if(a.keyCode==27){doku_linkwiz.hide();a.preventDefault();a.stopPropagation();return false}if(a.keyCode==38){doku_linkwiz.select(doku_linkwiz.selected-1);a.preventDefault();a.stopPropagation();return false}if(a.keyCode==40){doku_linkwiz.select(doku_linkwiz.selected+1);a.preventDefault();a.stopPropagation();return false}if(a.keyCode==13){if(doku_linkwiz.selected>-1){var b=doku_linkwiz.$getResult(doku_linkwiz.selected);if(b.length>0){doku_linkwiz.resultClick(b.find("a")[0])}}else{if(doku_linkwiz.$entry.val()){doku_linkwiz.insertLink(doku_linkwiz.$entry.val())}}a.preventDefault();a.stopPropagation();return false}doku_linkwiz.autocomplete()},getResult:function(a){DEPRECATED("use doku_linkwiz.$getResult()[0] instead");return doku_linkwiz.$getResult()[0]||null},$getResult:function(a){return jQuery(doku_linkwiz.result).find("div").eq(a)},select:function(b){if(b<0){doku_linkwiz.deselect();return}var d=doku_linkwiz.$getResult(b);if(d.length===0){return}doku_linkwiz.deselect();d.addClass("selected");var a=d.position().top;var c=a+d.outerHeight()-jQuery(doku_linkwiz.result).innerHeight();if(a<0){jQuery(doku_linkwiz.result)[0].scrollTop+=a}else{if(c>0){jQuery(doku_linkwiz.result)[0].scrollTop+=c}}doku_linkwiz.selected=b},deselect:function(){if(doku_linkwiz.selected>-1){doku_linkwiz.$getResult(doku_linkwiz.selected).removeClass("selected")}doku_linkwiz.selected=-1},onResultClick:function(a){if(!jQuery(this).is("a")){return}a.stopPropagation();a.preventDefault();doku_linkwiz.resultClick(this);return false},resultClick:function(b){doku_linkwiz.$entry.val(b.title);if(b.title==""||b.title.substr(b.title.length-1)==":"){doku_linkwiz.autocomplete_exec()}else{if(jQuery(b.nextSibling).is("span")){doku_linkwiz.insertLink(b.nextSibling.innerHTML)}else{doku_linkwiz.insertLink("")}}},insertLink:function(e){var b=doku_linkwiz.$entry.val(),d,c;if(!b){return}b=":"+b.replace(/^:/,"");var a=CKEDITOR.dialog.getCurrent();a.getContentElement("info","internal").setValue(b);a.getContentElement("info","internal_text").setValue(b);doku_linkwiz.hide();doku_linkwiz.$entry.val(doku_linkwiz.$entry.val().replace(/[^:]*$/,""))},autocomplete:function(){if(doku_linkwiz.timer!==null){window.clearTimeout(doku_linkwiz.timer);doku_linkwiz.timer=null}doku_linkwiz.timer=window.setTimeout(doku_linkwiz.autocomplete_exec,350)},autocomplete_exec:function(){var a=jQuery(doku_linkwiz.result);doku_linkwiz.deselect();a.html('<img src="'+DOKU_BASE+'lib/images/throbber.gif" alt="" width="16" height="16" />').load(DOKU_BASE+"lib/exe/ajax.php",{call:"linkwiz",q:doku_linkwiz.$entry.val()})},show:function(){doku_linkwiz.$wiz.show();doku_linkwiz.$entry.focus();doku_linkwiz.autocomplete();var a=doku_linkwiz.$entry.val();doku_linkwiz.$entry.val("");doku_linkwiz.$entry.val(a)},hide:function(){doku_linkwiz.$wiz.hide();doku_linkwiz.textArea.focus()},toggle:function(){if(doku_linkwiz.$wiz.css("display")=="none"){doku_linkwiz.show()}else{doku_linkwiz.hide()}}};
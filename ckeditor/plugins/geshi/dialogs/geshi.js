CKEDITOR.dialog.add("geshiDialog",function(k){var e,n=new Array();var b,c,f,m,j;var a=function(){var p=window.location.pathname;var i=window.location.search;var o=p.match(/\/(.*?)\/(doku.php)?\/?(.*)/);if(qs_match=i.match(/id=([\w:_\.]+)\b/)){c=qs_match[1];b=o[0]}else{if(!o[2]){c=o[3];b=o[1]+"/doku.php"}else{c=o[3];b=o[2]+"/doku.php"}}if(!b){b="doku.php"}if(!c){c="start"}return{href:b,id:c}};var l=function(p,r){var q="start";var o=r?r:"temp."+p;var i=a();return'<dl class="file"><dt><a href="'+i.href+"?do=export_code&id="+i.id+'&codeblock=0" title="Download Snippet" class="mediafile mf_'+p+'">'+o+'</a></dt> <dd><pre class="file '+p+'">'};var d=function(){return"</pre> </dd></dl>"};n=k.config.geshi_opts;if(!n.match(/ENotfound/)){n=n.split(";;");var h;for(var g=0;g<n.length;g++){h=n[g];n[g]=new Array(h)}n.unshift(["Not Set"]);j="display:block";m="display:none"}else{m="display:inline";j="display:none";n=[]}return{title:"Abbreviation Properties",minWidth:600,minHeight:350,contents:[{id:"tab-basic",label:"Basic Settings",elements:[{type:"textarea",rows:18,cols:80,id:"geshi",label:k.lang.geshi.code,validate:CKEDITOR.dialog.validate.notEmpty(k.lang.geshi.code_empty)},{type:"hbox",widths:["33%","33%","33%"],children:[{type:"select",id:"ckg_geshi_lang",label:"Select language",items:n,"default":n[0],style:j,onChange:function(i){}},{type:"text",id:"language",label:"<html><span title='"+k.lang.geshi.tooltip+"' style = 'color:blue;text-decoration:underline;'  onmouseover='this.style.cursor=\"pointer\";'>"+k.lang.geshi.quick_srch+"</span></html>",width:"125px",onChange:function(p){var r=this.getValue().toLowerCase();r=r.escapeRegExpCkg(r);var q=new RegExp("^"+r);for(var o=1;o<n.length;o++){if(q.test(n[o])){r=n[o];break}}if(r){f.getContentElement("tab-basic","ckg_geshi_lang").setValue(r)}}},{type:"text",id:"file",label:k.lang.geshi.file||"File name",width:"175px"},{type:"radio",id:"which",label:k.lang.geshi.which,items:[[k.lang.geshi.codeblock,"block"],[k.lang.geshi.snippet,"snippet"],["Plain text","text"]],"default":"block",style:"color: green",onClick:function(){e=this.getValue()}}]}]}],onShow:function(){var i=this;f=i;selection=k.getSelection();var o=selection.getSelectedText();i.getContentElement("tab-basic","geshi").setValue(o);String.prototype.escapeRegExpCkg=function(p){return p.replace(/[.*+?^${}()|[\]\\]/g,"\\$&")}},onOk:function(){var o=this,i;var r=o.getValueOf("tab-basic","geshi");r=r.replace(/</,"&lt;");r=r.replace(/>/,"&gt;");var q=o.getValueOf("tab-basic","which");var p=o.getValueOf("tab-basic","ckg_geshi_lang");if(p.match(/Not Set/i)){if(q=="text"){p="text"}else{p=""}}if(!p){if(confirm("Language not found. Try again?")){return false}}if(p){if(p=="text"){r=r.replace(/^(.*?)\n$/gm,"<p>$1</p>");i=r}else{if(q=="block"){i='<pre class="code '+p+'">'+r+"</pre>"}else{i=l(p,o.getValueOf("tab-basic","file"))+r+d()}}k.insertHtml(i)}}}});
!function(){var a={},b=function(b){for(var c=a[b],e=c.deps,f=c.defn,g=e.length,h=new Array(g),i=0;i<g;++i)h[i]=d(e[i]);var j=f.apply(null,h);if(void 0===j)throw"module ["+b+"] returned undefined";c.instance=j},c=function(b,c,d){if("string"!=typeof b)throw"module id must be a string";if(void 0===c)throw"no dependencies for "+b;if(void 0===d)throw"no definition function for "+b;a[b]={deps:c,defn:d,instance:void 0}},d=function(c){var d=a[c];if(void 0===d)throw"module ["+c+"] was undefined";return void 0===d.instance&&b(c),d.instance},e=function(a,b){for(var c=a.length,e=new Array(c),f=0;f<c;++f)e[f]=d(a[f]);b.apply(null,e)},f={};f.bolt={module:{api:{define:c,require:e,demand:d}}};var g=c,h=function(a,b){g(a,[],function(){return b})};h("1",document),h("2",window),g("0",["1","2"],function(a,b){return function(c){function d(){function a(a){"remove"===a&&this.each(function(a,b){var d=c(b);d&&d.remove()}),this.find("span.mceEditor,div.mceEditor").each(function(a,b){var c=k().get(b.id.replace(/_parent$/,""));c&&c.remove()})}function b(b){var c,d=this;if(null!=b)a.call(d),d.each(function(a,c){var d;(d=k().get(c.id))&&d.setContent(b)});else if(d.length>0&&(c=k().get(d[0].id)))return c.getContent()}function c(a){var b=null;return a&&a.id&&i.tinymce&&(b=k().get(a.id)),b}function d(a){return!!(a&&a.length&&i.tinymce&&a.is(":tinymce"))}var f={};h.each(["text","html","val"],function(a,g){var i=f[g]=h.fn[g],j="text"===g;h.fn[g]=function(a){var f=this;if(!d(f))return i.apply(f,arguments);if(a!==e)return b.call(f.filter(":tinymce"),a),i.apply(f.not(":tinymce"),arguments),f;var g="",k=arguments;return(j?f:f.eq(0)).each(function(a,b){var d=c(b);g+=d?j?d.getContent().replace(/<(?:"[^"]*"|'[^']*'|[^'">])*>/g,""):d.getContent({save:!0}):i.apply(h(b),k)}),g}}),h.each(["append","prepend"],function(a,b){var g=f[b]=h.fn[b],i="prepend"===b;h.fn[b]=function(a){var b=this;return d(b)?a!==e?("string"==typeof a&&b.filter(":tinymce").each(function(b,d){var e=c(d);e&&e.setContent(i?a+e.getContent():e.getContent()+a)}),g.apply(b.not(":tinymce"),arguments),b):void 0:g.apply(b,arguments)}}),h.each(["remove","replaceWith","replaceAll","empty"],function(b,c){var d=f[c]=h.fn[c];h.fn[c]=function(){return a.call(this,c),d.apply(this,arguments)}}),f.attr=h.fn.attr,h.fn.attr=function(a,g){var i=this,j=arguments;if(!a||"value"!==a||!d(i))return g!==e?f.attr.apply(i,j):f.attr.apply(i,j);if(g!==e)return b.call(i.filter(":tinymce"),g),f.attr.apply(i.not(":tinymce"),j),i;var k=i[0],l=c(k);return l?l.getContent({save:!0}):f.attr.apply(h(k),j)}}var e,f,g,h,i,j=[];i=c?c:b,h=i.jQuery;var k=function(){return i.tinymce};h.fn.tinymce=function(c){function e(){var a=[],b=0;g||(d(),g=!0),o.each(function(d,e){var f,g=e.id,h=c.oninit;g||(e.id=g=k().DOM.uniqueId()),k().get(g)||(f=k().createEditor(g,c),a.push(f),f.on("init",function(){var c,d=h;o.css("visibility",""),h&&++b==a.length&&("string"==typeof d&&(c=d.indexOf(".")===-1?null:k().resolve(d.replace(/\.\w+$/,"")),d=k().resolve(d)),d.apply(c||k(),a))}))}),h.each(a,function(a,b){b.render()})}var l,m,n,o=this,p="";if(!o.length)return o;if(!c)return k()?k().get(o[0].id):null;if(o.css("visibility","hidden"),i.tinymce||f||!(l=c.script_url))1===f?j.push(e):e();else{f=1,m=l.substring(0,l.lastIndexOf("/")),l.indexOf(".min")!=-1&&(p=".min"),i.tinymce=i.tinyMCEPreInit||{base:m,suffix:p},l.indexOf("gzip")!=-1&&(n=c.language||"en",l=l+(/\?/.test(l)?"&":"?")+"js=true&core=true&suffix="+escape(p)+"&themes="+escape(c.theme||"modern")+"&plugins="+escape(c.plugins||"")+"&languages="+(n||""),i.tinyMCE_GZ||(i.tinyMCE_GZ={start:function(){function a(a){k().ScriptLoader.markDone(k().baseURI.toAbsolute(a))}a("langs/"+n+".js"),a("themes/"+c.theme+"/theme"+p+".js"),a("themes/"+c.theme+"/langs/"+n+".js"),h.each(c.plugins.split(","),function(b,c){c&&(a("plugins/"+c+"/plugin"+p+".js"),a("plugins/"+c+"/langs/"+n+".js"))})},end:function(){}}));var q=a.createElement("script");q.type="text/javascript",q.onload=q.onreadystatechange=function(a){a=a||b.event,2===f||"load"!=a.type&&!/complete|loaded/.test(q.readyState)||(k().dom.Event.domLoaded=1,f=2,c.script_loaded&&c.script_loaded(),e(),h.each(j,function(a,b){b()}))},q.src=l,a.body.appendChild(q)}return o},h.extend(h.expr[":"],{tinymce:function(a){var b;return!!(a.id&&"tinymce"in i&&(b=k().get(a.id),b&&b.editorManager===k()))}})}}),d("0")()}();
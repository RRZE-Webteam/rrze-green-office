(()=>{var e,o,l,r,n,t,s,a,i,c,u,__;e=window.wp.blocks,o=window.wp.element,l=window.wp.blockEditor,r=window.wp.components,n=window.wp.i18n,t=o.createElement,s=e.registerBlockType,a=l.InspectorControls,i=r.PanelBody,c=r.TextControl,u=r.ColorPicker,s("greenoffice/quote-block",{title:(__=n.__)("Green Office","rrze-green-office"),icon:"format-quote",category:"widgets",attributes:{cssClasses:{type:"string",default:""},backgroundColor:{type:"string",default:"#ffffff"},borderColor:{type:"string",default:"#000000"}},edit:function(e){var o=e.attributes,l=e.setAttributes;return[t(a,{key:"inspector"},t(i,{title:__("Block Settings","rrze-green-office"),initialOpen:!0},t(c,{label:__("CSS Classes","rrze-green-office"),value:o.cssClasses,onChange:function(e){l({cssClasses:e})}}),t("div",{style:{marginBottom:"20px"}},t(u,{label:__("Background Color","rrze-green-office"),color:o.backgroundColor,onChangeComplete:function(e){l({backgroundColor:e.hex})},disableAlpha:!0})),t("div",{style:{marginBottom:"20px"}},t(u,{label:__("Border Color","rrze-green-office"),color:o.borderColor,onChangeComplete:function(e){l({borderColor:e.hex})},disableAlpha:!0})))),t("blockquote",{className:"rrze-green-office "+o.cssClasses,style:{backgroundColor:o.backgroundColor,borderColor:o.borderColor,borderStyle:"solid"},lang:"de"},t("p",{},t("span",{className:"wouf-ucfirst"},__("Wuff!","rrze-green-office"))," ",t("span",{className:"wouf-ucfirst wouf-uppercase"},__("Wuff!","rrze-green-office"))),t("cite",{},"🐶 Green Office"))]},save:function(){return null}})})();
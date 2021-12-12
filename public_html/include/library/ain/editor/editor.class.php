<?php


defined('AIN') or exit('NO DICE!');

class AIN_Editor
{
	private $_aParams = array();

	
	
	
	/**
	 * Gets the HTML output of the current textarea editor.
	 *
	 * @param string $iId ID of the textarea name, which also creates a unique ID for the HTML <textarea>
	 * @param array $aParams Any special params that the specific form behaves different from other forms can be passed here.
	 * @return string Returns the HTML output of the <textarea>
	 */
	public function get($iId, $aParams = array())
	{
	




$return = <<<HTML
<script type="text/javascript" src="/static/editor/v1/scripts/language/en/editor_lang.js"></script>
<script type="text/javascript" src="/static/editor/v1/scripts/innovaeditor.js"></script>
<script type="text/javascript">		
\$Behavior.AIN_PLUGIN_EDITOR = function()
{
	jQuery(document).ready(function($){

		create_editor('/');

		setTimeout(function() {
			
			for(var i = 0;i < oUtil.arrEditor.length;i++) {
			  var oEditor = eval("idContent" + oUtil.arrEditor[i]);
			  var sHTML;
			  if(navigator.appName.indexOf("Microsoft") != -1) {
				sHTML = oEditor.document.documentElement.outerHTML
			  }else {
				sHTML = getOuterHTML(oEditor.document.documentElement)
			  }
			  sHTML = sHTML.replace(/FONT-FAMILY/g, "font-family");
			  var urlRegex = /font-family?:.+?(\;|,|")/g;
			  var matches = sHTML.match(urlRegex);
			  if(matches) {
				for(var j = 0, len = matches.length;j < len;j++) {
				  var sFont = matches[j].replace(/font-family?:/g, "").replace(/;/g, "").replace(/,/g, "").replace(/"/g, "");
				  sFont=sFont.split("'").join('');
				  sFont = jQuery.trim(sFont);
				  var sFontLower = sFont.toLowerCase();
				  if(sFontLower != "serif" && sFontLower != "arial" && sFontLower != "arial black" && sFontLower != "bookman old style" && sFontLower != "comic sans ms" && sFontLower != "courier" && sFontLower != "courier new" && sFontLower != "garamond" && sFontLower != "georgia" && sFontLower != "impact" && sFontLower != "lucida console" && sFontLower != "lucida sans unicode" && sFontLower != "ms sans serif" && sFontLower != "ms serif" && sFontLower != "palatino linotype" && sFontLower != "tahoma" && sFontLower != 
				  "times new roman" && sFontLower != "trebuchet ms" && sFontLower != "verdana") {
					sURL = "http://fonts.googleapis.com/css?family=" + sFont + "&subset=latin,cyrillic";
					var objL = oEditor.document.createElement("LINK");
					objL.href = sURL;
					objL.rel = "StyleSheet";
					oEditor.document.documentElement.childNodes[0].appendChild(objL)
				  }
				}
			  }
			}
		}, 100);

	});			
}			
function create_editor( root ) {

	var use_br = false;
	var use_div = true;
	
	oUtil.initializeEditor("wysiwygeditor",  {
		width: "98%", 
		height: "350", 
		css: root + "/static/editor/v1/scripts/style/default.css",
		useBR: use_br,
		useDIV: use_div,
		groups:[
			["grpEdit1", "", ["Paragraph", "TextDialog", "FontDialog", "Subscript", "Superscript", "ForeColor", "BackColor", "BRK", "Bold", "Italic", "Underline", "Strikethrough", "DLEPasteText", "Styles", "RemoveFormat"]],
			["grpEdit2", "", ["JustifyLeft", "JustifyCenter", "JustifyRight", "JustifyFull", "BRK", "Bullets", "Numbering", "Indent", "Outdent"]],
			["grpEdit3", "", ["TableDialog", "DLESmiles", "FlashDialog", "CharsDialog", "Line", "BRK", "LinkDialog", "DLELeech", "ImageDialog", "DLEUpload", "YoutubeDialog"]],
			["grpEdit4", "", ["DLEQuote", "DLECode", "DLEHide", "DLESpoiler", "CustomTag", "BRK", "DLEVideo", "DLEAudio", "DLEMedia", "HTML5Video", "DLETypograf"]],
			["grpEdit5", "", ["SearchDialog", "SourceDialog", "BRK", "Undo", "Redo"]]
		],
		arrCustomButtons:[		

			["DLEUpload", "modalDialog(\$.ajaxBox('$aParams[call]', 'dId=$aParams[dId]'),680,370)", "xeber.bb_t_up", "dle_upload.gif"],
		
	
			["DLEPasteText", "modalDialog('"+ root +"/static/editor/v1/scripts/common/webpastetext.htm',450,380)", "Вставить как простой текст", "btnPaste.gif"],
			["DLETypograf", "tag_typograf()", "Типографская обработка текста", "dle_tt.gif"],
			["DLEQuote", "DLEcustomTag('[quote]', '[/quote]')", "Вставка цитаты", "dle_quote.gif"],
			["DLECode", "DLEcustomTag('[code]', '[/code]')", "Вставка исходного кода", "dle_code.gif"],
			["DLEHide", "DLEcustomTag('[hide]', '[/hide]')", "Вставка скрытого текста", "dle_hide.gif"],
			["DLESpoiler", "DLEcustomTag('[spoiler]', '[/spoiler]')", "Вставка спойлера", "dle_spoiler.gif"],
			["DLELeech", "DLEcustomTag('[leech=http://]', '[/leech]')", "Вставка защищенной ссылки", "dle_leech.gif"],
			["HTML5Video", "modalDialog('"+ root +"/static/editor/v1/scripts/common/webvideo.htm',690,330)", "HTML5 Video", "btnMedia.gif"],
			["DLEVideo", "modalDialog('"+ root +"/static/editor/v1/scripts/common/webbbvideo.htm',400,250)", "Вставка видео (BB Codes)", "dle_video.gif"],
			["DLEAudio", "modalDialog('"+ root +"/static/editor/v1/scripts/common/webbbaudio.htm',400,200)", "Вставка аудиотрека (mp3) (BB Codes)", "dle_mp3.gif"],
			["DLEMedia", "modalDialog('"+ root +"/static/editor/v1/scripts/common/webbbmedia.htm',400,250)", "Воспроизведение видео с видеосервисов (BB Codes)", "dle_media.gif"]
		],
		arrCustomTag: [
			["Вставка разрыва между страницами", "{PAGEBREAK}"],
			["Вставка ссылки на страницу", "[page=1][/page]"]
		]
		}
	);	
};
</script>
HTML;



		return $return;
	
	}	
}
?>
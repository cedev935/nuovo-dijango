CKEDITOR.plugins.add("shortcode", {
    onLoad: function(editor) {
		CKEDITOR.document.appendStyleSheet(CKEDITOR.getUrl(this.path + "style.css"))
	},
	init: function(editor) {
		//var b = CKEDITOR.env;
		editor.ui.addButton("TextGroup", {
			label: "TextGroup",
			click: function(editor) {
				//var selectedText = editor.elementMode == CKEDITOR.ELEMENT_MODE_INLINE ? editor.container.getText() : editor.document.getBody().getText();
                $('#textGroup_sc_modal').modal('show');
			},
			toolbar: "shortcode"
		});
        editor.ui.addButton("Chart", {
			label: "Chart",
			click: function(editor) {
                $('#chart_sc_modal').modal('show');
			},
			toolbar: "shortcode"
		});
	}
});
// (function() {
//     //Section 1 : Code to execute when the toolbar button is pressed
//     var a = {
//         exec: function(editor) {
//             var theSelectedText = editor.getSelection().getNative();
//             alert(theSelectedText);
//         }
//     },

//     //Section 2 : Create the button and add the functionality to it
//     b='add_shortcode';
//     CKEDITOR.plugins.add(b, {
//         init: function(editor) {
//             editor.addCommand(b, a);
//             editor.ui.addButton("addShortCode", {
//                 label: 'Add ShortCode', 
//                 icons: this.path + 'shortcode.png',
//                 command: b,
//                 // click: function(editor) {
//                 //     var b = a.elementMode == CKEDITOR.ELEMENT_MODE_INLINE ? a.container.getText() : a.document.getBody().getText();
//                 //     (b = b.replace(/\s/g, "")) ? a.execCommand("checkspell"): alert("Nothing to check!")
//                 // },
//                 toolbar: "spellchecker,10"
//             });
//         }
//     }); 
// })();
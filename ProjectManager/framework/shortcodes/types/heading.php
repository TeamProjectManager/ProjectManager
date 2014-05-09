<script type="text/javascript">
var HRDialog = {
	local_ed : 'ed',
	init : function(ed) {
		HRDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertHR(ed) {
	 
		// Try and remove existing style / blockquote
		tinyMCEPopup.execCommand('mceRemoveNode', false, null);
		 
		// set up variables to contain our input values
		var title = jQuery('input#heading-title').val();
		var margin_top = jQuery('input#heading-margin-top').val();
		var margin_bottom = jQuery('input#heading-margin-bottom').val(); 
		 
		 
		//set highlighted content variable
		var mceSelected = tinyMCE.activeEditor.selection.getContent();
		
		// setup the output of our shortcode
		var output = '';
		
		output = '&nbsp;';
		output = '[heading title="' + title + '"';
		
		if(margin_top) {
			output += ' margin_top="'+ margin_top +'" ';
		}
		
		if(margin_bottom) {
			output += ' margin_bottom="'+ margin_bottom +'" ';
		}
		
		output += ']';

		tinyMCEPopup.execCommand('mceReplaceContent', false, output);
		 
		// Return
		tinyMCEPopup.close();
	}
};
tinyMCEPopup.onInit.add(HRDialog.init, HRDialog);
 
</script>
<form action="/" method="get" accept-charset="utf-8">
	<div class="form-section clearfix">
        <label for="heading-title">Title</label>
        <input type="text" name="heading-title" value="" id="heading-title" />
    </div>
	<div class="form-section clearfix">
        <label for="heading-margin-top">Margin Top</label>
        <input type="text" name="heading-margin-top" value="" id="v-margin-top" />
    </div>
  	<div class="form-section clearfix">
        <label for="heading-margin-bottom">Margin Bottom</label>
        <input type="text" name="heading-margin-bottom" value="" id="heading-margin-bottom" />
    </div>
        
	<a href="javascript:HRDialog.insert(HRDialog.local_ed)" id="insert" style="display: block; line-height: 24px;">Insert</a>
</form>
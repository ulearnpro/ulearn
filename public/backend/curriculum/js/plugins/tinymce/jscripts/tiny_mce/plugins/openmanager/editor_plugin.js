/**
 * Contributing: http://tinymce.moxiecode.com/contributing
 */

(function() {
	// Load plugin specific language pack
	var strPluginURL;
	
	tinymce.PluginManager.requireLangPack('openmanager');

	tinymce.create('tinymce.plugins.OpenManager', {
		/**
		 * Initializes the plugin, this will be executed after the plugin has been created.
		 * This call is done before the editor instance has finished it's initialization so use the onInit event
		 * of the editor instance to intercept that event.
		 *
		 * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
		 * @param {string} url Absolute URL to where the plugin is located.
		 */
		init : function(ed, url) {
			strPluginURL = url;             
			// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceElvtImage');
			ed.addCommand('mceElvtImage', function() {
				ed.windowManager.open({
					file : url + '/index.php?d='+encodeURI(tinyMCE.activeEditor.getParam('open_manager_upload_path')),
					//file : url + '/dialog.htm',
					width : 720 + parseInt(ed.getLang('openmanager.delta_width', 0)),
					height : 450 + parseInt(ed.getLang('openmanager.delta_height', 0)),
					inline : 1
				}, {
					plugin_url : url, // Plugin absolute URL
					some_custom_arg : 'custom arg' // Custom argument
				});
				
				//ccSimpleUploader();
			});

			// Register openmanager button
			ed.addButton('openmanager', {
				title : 'Open Manager',
				cmd : 'mceElvtImage',
				image : url + '/assets/img/icon.gif'
			});

			// Add a node change handler, selects the button in the UI when a image is selected
			ed.onNodeChange.add(function(ed, cm, n) {
				cm.setActive('openmanager', n.nodeName == 'IMG');
			});
		},

		/**
		 * Creates control instances based in the incomming name. This method is normally not
		 * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
		 * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
		 * method can be used to create those.
		 *
		 * @param {String} n Name of the control to create.
		 * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
		 * @return {tinymce.ui.Control} New control instance or null if no control was created.
		 */
		createControl : function(n, cm) {
			return null;
		},
		getPluginURL: function() {
            return strPluginURL;
        },

		/**
		 * Returns information about the plugin as a name/value array.
		 * The current keys are longname, author, authorurl, infourl and version.
		 *
		 * @return {Object} Name/value array containing information about the plugin.
		 */
		getInfo : function() {
			return {
				longname : 'Open Manager',
				author : 'Ross Morsali',
				authorurl : 'http://www.weareelevate.com/',
				infourl : 'http://www.designsandcode.com/posts/openmanager',
				version : "1.0"
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('openmanager', tinymce.plugins.OpenManager);
})();


// this function can get called from the plugin inint (above) or from the callback on advlink/advimg plugins..
// in the latter case, win and type will be set.. In the rist case, we will just update the main editor window
// with the path of the uploaded file
function openmanager(field_name, url, type, win) {    
    var strPluginPath = tinyMCE.activeEditor.plugins.openmanager.getPluginURL();						// get the path to the uploader plugin    
    var strUploaderURL = strPluginPath + "/index.php";												// generate the path to the uploader script    
    var strUploadPath = encodeURI(tinyMCE.activeEditor.getParam('open_manager_upload_path'));					// get the relative upload path

    if (strUploaderURL.indexOf("?") < 0)															// if we were called without any GET params
        strUploaderURL = strUploaderURL + "?type=" + type + "&d=" + strUploadPath;					// add our own params 
    else
        strUploaderURL = strUploaderURL + "&type=" + type + "&d=" + strUploadPath;
    
    tinyMCE.activeEditor.windowManager.open({														// open the plugin popup
        file            : strUploaderURL,
        title           : 'Open Manager',
        width           : 720,  
        height          : 450,
        resizable       : "no", 
        inline          : 1,        // This parameter only has an effect if you use the inlinepopups plugin!
        close_previous  : "no"
    }, {
        window : win,
        input : field_name
    });
  
    return false;
}
// This function will get called when the uploader is done uploading the file and ready to update
// calling dialog and close the upload popup
// strReturnURL should be the string with the path to the uploaded file
function ClosePluginPopup (strReturnURL) {
    var win = tinyMCEPopup.getWindowArg("window");                                          // insert information now
    if (!win)
        tinyMCE.activeEditor.execCommand('mceInsertContent', false, strReturnURL);
    else
    {
        win.document.getElementById(tinyMCEPopup.getWindowArg("input")).value = strReturnURL;	
	    if (typeof(win.ImageDialog) != "undefined")                                             // are we an image browser
	    {		
		    if (win.ImageDialog.getImageData) win.ImageDialog.getImageData();                   // we are, so update image dimensions and preview if necessary
		    if (win.ImageDialog.showPreviewImage) win.ImageDialog.showPreviewImage(strReturnURL);
	    }	
	}
	tinyMCEPopup.close();	                                                                    // close popup window
}
(function() {
  tinymce.create("tinymce.plugins.insert_button_plugin", {

    //url argument holds the absolute url of our plugin directory
    init : function(ed, url) {
      url = url.replace("/js", "");

      //add new button    
      ed.addButton("insert_button", {
        title : "Insert Button",
        cmd : "insert_button",
        image : url + "/images/dashicon.svg"
      });

      //button functionality.
      ed.addCommand("insert_button", function() {
        var selected_text = ed.selection.getContent();
        //If text is selected_text when button is clicked
        if( selected_text ){
          //Wrap shortcode around it.
          content =  '[insert_button text="'+selected_text+'" link="" class=""]';
        } else {
          content =  '[insert_button text="'+selected_text+'" link="" class=""]';
        }
        ed.execCommand('mceInsertContent', false, content);
      });

    },

    createControl : function(n, cm) {
      return null;
    },

    getInfo : function() {
      return {
        longname : "Insert Button",
        author : "AndresTheGiant",
        version : "1.0.0"
      };
    }
  });

  tinymce.PluginManager.add("insert_button_plugin", tinymce.plugins.insert_button_plugin);
})();
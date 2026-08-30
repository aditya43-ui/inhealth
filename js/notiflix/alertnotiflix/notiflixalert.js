(function($) {
	
// Shortuct functions
myAlert = function (message, title = "Perhatian!", callback, type = "") {
    Notiflix.Confirm.Show(
            title,
            message,
            'Ok',
            null,
            null,
            null,
            // extend the init options for this confirm box (v2.5.0 and the next versions)
                    {
                        width: '320px',
                        messageMaxLength: 1000,
                        // etc...
                    },
                    );
        }

myConfirm = function (message, title = "Perhatian!", callback) {

    Notiflix.Confirm.Show(
            title,
            message,
            'Ya',
            'Tidak',
            // ok button callback
                    function () {
                        if (callback)
                            callback(true);
                    },
                    // cancel button callback
                            function () {
                                if (callback)
                                    callback(false);
                            },
                            // extend the init options for this confirm box (v2.5.0 and the next versions)
                                    {
                                        width: '320px',
                                        borderRadius: '8px',
                                        // etc...
                                    },
                                    );

                        };
	
      	
                
	myPrompt = function(message, value, title, callback) {
            
		dialog.prompt({
			title: title,
			message: message,
			button: "Simpan",
			// required: true,
			position: "absolute",
			animation: "slide",
			input: {
				type: "text",
				placeholder: "Inputkan Data"
			},
//			validate: function(value){
//				if( $.trim(value) === "" ){
//					return false;
//				}
//			},
			callback:callback
		});
		return false;
	};
	
})(jQuery);


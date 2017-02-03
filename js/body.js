$(document).ready(function() {
		 

	/* on vérifie que tous les inputs du block 1 est fonctionnel */
	$("#button-next").addClass("disabled");
		verify("#mail_exp");
		verify("#mail_rec");
		verify("#content");
		verify("#subject");
	});
	
	function addFileTransfert(key){
		var val = $("#files").val();
		$('.list-file').append('<div class="item upload upload-'+key+'"><div class="load load-'+key+'"></div>'+val+'</div>');
	}

    function verify(key){
      $(key).keyup(function(){
        if($(key).hasClass("invalid") || $(key).val()=='') {
            $("#button-next").addClass("disabled");
          }

          verifyAll(["#mail_exp", "#mail_rec", "#content", "#subject"]);
      });
    }

	function verifyAll(inputs){
		var error = 0;
		for(var i = 0; i < inputs.length; i++){
			if($(inputs[i]).hasClass("invalid") || $(inputs[i]).val() == '') {
				error++;
			}
		}
		if(error == 0){
			<!-- $("#button-next").removeClass("disabled"); -->
			$("i").removeClass("disabled");
		}
	}
	
	function makeid()
	{
		var text = "";
		var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

		for( var i=0; i < 5; i++ )
			text += possible.charAt(Math.floor(Math.random() * possible.length));

		return text;
	}
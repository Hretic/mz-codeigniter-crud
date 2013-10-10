	if (typeof jQuery  == "undefined") {
	   var e = document.createElement("script");
	   e.src = base_url+"crud_assets/js/jquery.js";
	   e.type = "text/javascript";
	   document.getElementsByTagName("head")[0].appendChild(e); 
	   load_richtext();
	}
	else
	{ 
	load_richtext(); 
	}
	
	
	function load_richtext(){
		
	   var e = document.createElement("script");
	   e.src = base_url+"crud_assets/markitup/sets/default/set.js";
	   e.type = "text/javascript";
	   document.getElementsByTagName("head")[0].appendChild(e); 
	
	   var e = document.createElement("script");
	   e.src = base_url+"crud_assets/markitup/jquery.markitup.js";
	   e.type = "text/javascript";
	   document.getElementsByTagName("head")[0].appendChild(e); 
	   
	   console.log('is not');
	}
	
	 function chekc_jquery(){
		   if (typeof jQuery  == "undefined") 
		   {
			   window.setTimeout(function() {
				   chekc_jquery();
				   console.log("checking");
				}, 100);
		   }
		   else
		   {
		    $('body').append('<div class="crud_popup"  id="crud_slidenotice" style="display:none">'+
				'<div class="crud_main">'+           	
				' <span class="crud_msg"></span>'+
				'<br />'+
					'<a href="javascript:void(0)" class="crud_close" onclick="slideup();">X</a>'+
					'<br style="clear:both;" />'+
				'</div>'+
			'</div>');
			
			$(document).ready(function(e) {
				$('.crud_checkall').click(function(){
					if(this.checked)
					$('.crud_inputs').attr('checked' , true );
					else
					$('.crud_inputs').attr('checked' , false );
				})
			});
			
		   documentready();
		   }
	 }
	 chekc_jquery();
	 
	 
	 
	 
	 function slideup(){
	  $('.crud_popup').fadeOut();
		$('#crud_slidenotice .crud_msg').html('');
		$('#crud_slidenotice').fadeOut();
	 }
	 
     function slidedown(msg){
		$('.crud_popup').not('#crud_slidenotice').fadeOut();
		$('#crud_slidenotice .crud_msg').html(msg);
		$('#crud_slidenotice').fadeIn();
	 }
	 
	 
	 
	 
	 	function delete_(){
		
		var crud_inputs = Array();
		
		$('.crud_inputs').each(function(index, element) {
            if(this.checked)
			crud_inputs.push($(this).val());
			
        });
		
		
		if(crud_inputs.length == 0 )
		{
			return false;
		}
		
		$('.CrudDelete_Btn').attr('disabled' , true );
		
		$.post(base_url+'crud/action/delete' ,
		 {crud_inputs:crud_inputs ,  id_fild:id_fild  , tbl:tbl }
		  , function(data){
			  
		    $('.CrudDelete_Btn').attr('disabled' , false );
			data = $.trim(data);
			
			if(data == 'ok')
			{
				$('.crud_inputs').each(function(index, element) {
					if(this.checked)
					$(this).parents('tr:first').fadeOut().remove();
					
				});
			}
			else
			slidedown(data);
			
		})
	}
	
	
	
	



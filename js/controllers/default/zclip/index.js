$(function(){
    $('#copy').zclip({
        path:   $('#assetpath').val(),        
        copy:   function() {return $.trim($('#ref_link').text()); },
        afterCopy:function(){
            $('#copy').val('Скопированно');
            setTimeout(function() {
            	$('#copy').val('Копировать');
            },3000);  
			alert("Ссылка скопирована");
        }
    });
})


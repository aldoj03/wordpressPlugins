
 
jQuery(document).ready(function ($) {
    
    $('div[id^="post-"]').children().append('<button class="delete_post">Delete food :(</button>');
    $("button.delete_post").click( function(){
        var food = $(this).parents('.food-card');
        var id = food.data('id');
        console.log(id);  
         jQuery.ajax({
            type: "post",
            url: ajax_var.url,
            data: "action=" + ajax_var.action + "&nonce=" + ajax_var.nonce + "&id=" + id,
            success: function(result){
                console.log(result);                   
                food.fadeOut(function () {                    
                  food.remove(); 
                })
                
       
            }
        }); 
    });


    
});
 
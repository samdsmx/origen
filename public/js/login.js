var loginbox = $('#boxLogin');
var loginform = $('#formLogin');

$(document).ready(function(){
    $('#alertLogin').animate( { opacity:'0'} , 50000, function(){
        $('#alertLogin').hide();
    });
    
    loginform.submit(function(e){ 
        e.preventDefault();
        
        var thisForm = $(this);
        var userinput = $('#loginUsuario');
        var passinput = $('#loginContrasena');
        
        if(userinput.val() == '' || passinput.val() == '') {
            highlight_error(userinput);
            highlight_error(passinput);
            
            loginbox.effect('pulsate');
            
            return false;
        }else{
            loginbox.animate( {height:'toggle' , opacity:'0'} , 3000, function(){
                setTimeout(function(){
                    thisForm.unbind('submit').submit();
                }, 1000);
            });
            
            return true;
        }  
    });

    $('#loginUsuario, #loginContrasena').on('keyup',function(){
        highlight_error($(this));
    }).focus(function(){
        highlight_error($(this));
    }).blur(function(){
        highlight_error($(this));
    });
    
});

function highlight_error(element) {
    if(element.val() == '') {
        element.parent().removeClass('has-success');
        element.parent().addClass('has-error');
    } else {
        element.parent().removeClass('has-error');
        element.parent().addClass('has-success');
    }
}
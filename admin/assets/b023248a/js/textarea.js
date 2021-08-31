$(function(){
    // let placeholder = 'Опишите вашу заявку' + '\n' + 'Например: Нужен ремонт квартиры...';
    let placeholder = 'Например: нужен срочно сантехник';
    $('.order-form-textarea').attr('placeholder',placeholder);
    
    $('.order-form-textarea').focus(function(){
        if($(this).val() === placeholder){
            $(this).attr('placeholder',placeholder);
        }
    });
    
    $('.order-form-textarea').blur(function(){
        if($(this).val() === ''){
            $(this).attr('placeholder',placeholder);
        }    
    }); 
});
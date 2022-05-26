JQuery(document).ready(function(){
    JQuery('#register_submit').on('click', function(e){
    e.preventDefault();
    var username = JQuery('#username').val();
    var email = JQuery('#email').val();
    var phone = JQuery('#phone').val();
    var business_name = JQuery('#business_name').val();
    var business_address = JQuery('#business_address').val();
    var password = JQuery('#password').val();
    // I am applying validation here
    $('#validation').validate({
    rules: {
    username: {
       required: true
       },
    email: {
        required: true,
        email: true
       },
    phone: {
        required: true,
        matches: "[0-9]+",  // <-- no such method called "matches"!
         minlength:10,
        maxlength:10
    },
    business_name: {
        required: true
        },
    business_address: {
        required: true
    },
    password: {
        required: true,
        minlength: 6,
        maxlength: 30,
        required: true,
        pwcheck: true 
     },
     }
    }) 
   $.ajax({
     type: 'post',
     url: ajax_url, //I have defined this in fuctions.php
     data: { action: 'test', get_username: username, get_email: email},
     success: function(response){
     $('#insert').html(response);    
     }
   });   
   });
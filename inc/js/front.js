$(document).ready(function(){

//live showinformation
$(".live").keyup(function(){
  $($(this).data('class')).text($(this).val());
});
  // switch bettween product img
  $('.pictures__container  img').click(function(){       
    var $image=$(this).attr('src');     
    $('#pic').attr('src',$image);
    });
//switch beetwin login register
    $('.btn-switch').click(function(){
    $('.signup').show();
    $('.login').hide();
      });

      $('.btn-switch1').click(function(){
      $('.signup').hide();
      $('.login').show();
  });
  // add asterix on required field
$('').each(function(){
  if($(this).attr('required')== 'required'){
      $(this).after('<span class="asterisk">*</span>');
  }
});
//====================================================
//start valdition form
//================================================
$(".signup").submit(function(event){
  event.preventDefault();
  var name=$("#username").val();
  var fulluser=$("#fullname").val();
  var email=$("#email").val();
  var password1=$("#password1").val();
  var password2=$("#password2").val();
  var address=$("#address").val();
  var submit=$("#submit").val();
  $(".message").load("validation-form.php",{
      name:name,
      fullname:fulluser,
      email:email,
      password1:password1,
      password2:password2,
      address:address,
      submit:submit

  });
 

});


//=================================
//fin validation
//==================================================

/////////////////active link of sub category
$('li-link').click(function(){
  $(this).addClass('li-active');
});

///////// add & insert info of product\\\\\\\\\\
$(".add").submit(function(e){ 
  e.preventDefault();
  var formData=new FormData(this); 
  $.ajax({
    url:'newads.php?do=insert',
    type: 'POST',
    data:formData,
    success:function (data){
      $(".msg-error").html(data);
    },
    contentType:false,
    processData:false,
    cache:false
    }); 
});


$(".edit").submit(function(e){
 
  e.preventDefault();
  var formData=new FormData(this);
 
  $.ajax({
    url:'newads.php?do=update',
    type: 'POST',
    data:formData,
    success:function (data){
      $(".msg-error").html(data);
    },
    contentType:false,
    processData:false,
    cache:false
    }); 
});

    //////////////////insert comment//////////
    $(".insComment").submit(function(e){ 
      e.preventDefault();
  var formData=new FormData(this);
      
      $.ajax({
        url:'insert_comment.php',
        type: 'POST',
        data:formData,
        success:function (data){
          $(".msg-error").html(data);
        },
        contentType:false,
        processData:false,
        cache:false
        }); 
     });


  });
 
/*
=============
Product Details Bottom
=============
 */

const btns = document.querySelectorAll(".detail-btn");
const detail = document.querySelector(".product-detail__bottom");
const contents = document.querySelectorAll(".content");

if (detail) {
  detail.addEventListener("click", e => {
    const target = e.target.closest(".detail-btn");
    if (!target) return;

    const id = target.dataset.id;
    if (id) {
      Array.from(btns).forEach(btn => {
        // remove active from all btn
        btn.classList.remove("active");
        e.target.closest(".detail-btn").classList.add("active");
      });
      // hide other active
      Array.from(contents).forEach(content => {
        content.classList.remove("active");
      });
      const element = document.getElementById(id);
      element.classList.add("active");
    }
  });
}

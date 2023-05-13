$(function(){
  'use strict';
//live showinformation
$(".live").keyup(function(){
  $($(this).data('class')).text($(this).val());
});
 
/// option category page
$('.option span').click(function(){
  $(this).addClass('active').siblings('span').removeClass('active');

    if($(this).data('view') === 'full'){
    
      $('table #cathid').fadeIn(200);
     
    }else{ $('table #cathid').fadeOut(200);}
});
 
//////////////////// next

$("#next").click(function(){
  var nextPage =($('.pageno_44').val());
  var nextpage =parseInt(nextPage);
  nextpage=nextpage+1;

  $.ajax({
      type: 'POST',
      url: 'pagination.php',
      data: { pageno: nextPage },
      success: function(data){
          if(data != ''){                          
              $('#response').html(data);
              $('.pageno').val(nextPage);
              $('.pageno_44').val(nextpage);
          } else {                                 
              $(".pageno_44").hide();
          }
      }
  });

  });
  ////////////////////num page
  $("button").click(function next(){
  $(this).addClass('btn-page').siblings('button').removeClass('btn-page');

    var nextPage =parseInt($(this).val());
   
    $.ajax({
        type: 'POST',
        url: 'pagination.php',
        data: { pageno: nextPage },
        success: function(data){
            if(data != ''){                          
                $('#response').html(data);
                $('.pageno').val(nextPage);
                $('.pageno_44').val(nextPage+1);
            } /*else {                                 
                $("#loader").hide();
            }*/
        }
    });
  
    });
  ////////////////// prev
  $("#prev").click(function(){
   
   var nextPage =($('.pageno').val())-1;
    $.ajax({
        type: 'POST',
        url: 'pagination.php',
        data: { pageno: nextPage },
        success: function(data){
            if(nextPage>1){                          
                $('#response').html(data);
                $('.pageno').val(nextPage);
                $('.pageno_44').val(nextPage+1);
            }
        }
    });

    });    
//====================================================
//start valdition form
//================================================

 


$(".add").submit(function(e){ 
  e.preventDefault();
  var formData=new FormData(this); 
  $.ajax({
    url:'members.php?do=insert',
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
    url:'members.php?do=update',
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


//=================================
//fin validation
//==================================================
  });
  

 

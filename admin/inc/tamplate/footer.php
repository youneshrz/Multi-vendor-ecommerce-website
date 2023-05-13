<br>
<div class="text-center" style="
    line-height: 40px;
    background: #9e9e9d;
    font-size: 15px;
    font-weight: 600;
    font-family: auto;
    ">copy right 2020,all right resarved</div>
<!-- Footer -->

    <script src="inc/js/jquery-3.4.1.min.js"></script>
   
    <script src="inc/js/bootstrap.min.js"></script>
   
  
    <script src="inc/js/backend.js"></script>

    <script>
    
    function getchildoption(selected){
     if(typeof selected === 'undefined'){var selected='';}
            //var parentid=$(this).val();
           var parentid=$('select[name="parent"]').val();
           // console.log(parentid);
            $.ajax({
              url: 'child.php',
              type: 'POST',
              data:{keyname:parentid,selected:selected },
              success:function(data){
          $('#child').html(data);
              },
              error:function(){alert("something went wrong with the child option");},
            });
          }
          $('select[name="parent"]').change(function(){getchildoption()});
    </script>
    
   
</body>
</html>
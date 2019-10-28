<script>
 
 $('.newbtn').bind("click" , function () {
        $('#fileToUpload').click();
 });
 
  function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#profile_photo')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
                
            }
        }
	$( function() {
    $( "#datepicker" ).datepicker({
      changeMonth: true,
      changeYear: true,
	dateFormat:'yy-mm-dd'
    });
  } );
  
  
	$( function() {
    $( "#datepicker1" ).datepicker({
      changeMonth: true,
      changeYear: true,
	dateFormat:'yy-mm-dd'
    });
  } );  
  
</script>
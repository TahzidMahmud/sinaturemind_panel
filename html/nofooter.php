<style>
    
@media print {
   
  #prntt  {
    visibility: hidden;
  }
  [title~="Nagbak Payment"]{
      visibility: hidden;
  }
  /*#printdiv, #printdiv * {*/
  /*  visibility: visible;*/
  /*}*/
  /*#printdiv {*/
  /*  position: absolute;*/
  /*  width: 100%;*/
  /*  left: 0;*/
  /*  top: 0;*/
  /*}*/
</style>

<script src="./theme/assets/js/jquery.min.js"></script>
        <script src="./theme/assets/js/bootstrap.bundle.min.js"></script>
        <script src="./theme/assets/js/waves.js"></script>
        <script src="./theme/assets/js/feather.min.js"></script>
        <script src="./theme/assets/js/simplebar.min.js"></script>
        <script src="./theme/assets/js/jquery.validate.min.js"></script>
        <!-- Sweet-Alert  -->
        <script src="./theme/plugins/sweet-alert2/sweetalert2.min.js"></script>
        
        <script>
            function highlitenav(nvi){
                var len = $('#navbar li').length;
                var $listItems = $('#navbar li');
                $listItems.removeClass('active');
                // for(var i=1; i<len; i++){
                //         $('#navitem'+i).removeClass('active');
                //     }
                $('#'+nvi).addClass('active');
                
            } 
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                onOpen: function(toast) {
                  toast.addEventListener('mouseenter', Swal.stopTimer)
                  toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
              })
        </script>
        <?php echo $this->script;?>
        <script>
     $('#prntt').on('click',function(){
            //   console.log('hiut')
                  window.print()
              })
</script>
</body>
</html>
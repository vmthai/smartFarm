<?php 
    require_once('./views/includes/header.php');
    require_once('./views/includes/js.php');
    require_once('./views/includes/topMenu.php');
    require_once('./views/includes/adminMenu.php');
    // require_once('./views/includes/content.php');
    require_once('./views/includes/modal.php');
?>
    <!-- Content -->
    <div id='Mcontent' class="card" style="padding-top: 80px; padding-right: 20px; padding-bottom: 0px; padding-left: 20px;">
        <div class="app-content content container-fluid">
            <div class="content-wrapper">
              <!-- <div id="content-breadcrumbs"></div> -->
              <div class="content-body" style="min-height: 560px;"><!-- Description -->

                <div id="main-content"></div>
                <div id="loading">
                    <div id="loading-image">
                        <span class="icon-spinner" style="font-size: 77px;"></span>
                    </div>
                </div>
                <footer class="footer navbar-fixed-bottom footer-light navbar-border">
                  <p class="clearfix text-muted text-sm-center mb-0 px-2"><span class="float-md-left d-xs-block d-md-inline-block">Copyright  &copy; 2017 <a href="https://bsiamtech.com" target="_blank" class="text-bold-800 grey darken-2">Far Control </a>, All rights reserved. </span><span class="float-md-right d-xs-block d-md-inline-block"> <i class="icon-heart5 pink"></i></span></p>
                </footer> 

              </div><!--CLOSE Description -->
            </div><!--CLOSE content-wrapper -->
        </div>   
    </div> 

    <script type="text/javascript">
      var WEB_HTTP_HOST = "<?=_HTTP_HOST_?>";

        $(function() {
            var _url_last = "<?=$url_last?>";
            var _id_maminmenu = "<?=$id_maminmenu?>";
            if(_url_last!=""){
              fncLoadContent(_url_last); 
              if(_id_maminmenu!=""){ 
                $('#li-nav-item'+_id_maminmenu).addClass('open');
              }
            }
        }); 

        $(window).load(function() {
            $('#loading').hide();//setTimeout(function(){$('#loading').hide();},100)
        });
        $( document ).ajaxStart(function() {
          $( "#loading" ).show();
        });
        $( document ).ajaxStop(function() {
          $( "#loading" ).hide();
        });
      $( document ).ajaxError(function() {
        $( "#loading" ).hide();
        $('#md-error p' ).text('!!!Ajax Error');
        $('#md-error').modal('show');
      });
    </script>
<?php 
    require_once('./views/includes/footer.php');
?>
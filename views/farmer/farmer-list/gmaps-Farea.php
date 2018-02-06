<!DOCTYPE html>
<html class="loading">
  <head>
  <style>
        html, body, #basic-map {
      height: 100%;
      margin: 0px;
      padding: 0px
    }
    a[href^="https://maps.google.com/maps"]{display:none !important}/*GOOGLE Logo*/
    a[href^="http://maps.google.com/maps"]{display:none !important}/*GOOGLE Logo*/
      
    .gmnoprint a, .gmnoprint span {
        display:none;
    }
    a[href^="https://www.google.com/maps"]{display:none !important}/*รายงานข้อผิดพล*/  
    </style>  
  </head>
    <body>
        <div id="basic-map"></div>

        <!-- BEGIN VENDOR JS-->
        <script src="<?=_HTTP_HOST_?>/app-assets/js/core/libraries/jquery.min.js" type="text/javascript"></script>

        <!-- BEGIN VENDOR JS-->
        <!-- BEGIN PAGE VENDOR JS-->
        <!-- <script src="//maps.googleapis.com/maps/api/js?key=AIzaSyBDkKetQwosod2SZ7ZGCpxuJdxY3kxo5Po" type="text/javascript"></script> -->
        <script src="<?=_HTTP_HOST_?>/app-assets/vendors/js/charts/gmaps.min.js" type="text/javascript"></script>
        <!-- END PAGE VENDOR JS-->

        <script src="<?=_HTTP_HOST_?>/app-assets/js/scripts/charts/gmaps/maps.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL JS-->
    </body>
</html>
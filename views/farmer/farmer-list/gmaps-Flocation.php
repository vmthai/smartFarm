<!DOCTYPE html>
<html class="loading">
  <head>
          <!-- Bootstrap CSS -->    

    <link rel="apple-touch-icon" sizes="60x60" href="<?=_HTTP_HOST_?>/app-assets/images/ico/apple-icon-60.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?=_HTTP_HOST_?>/app-assets/images/ico/apple-icon-76.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?=_HTTP_HOST_?>/app-assets/images/ico/apple-icon-120.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?=_HTTP_HOST_?>/app-assets/images/ico/apple-icon-152.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?=_HTTP_HOST_?>/app-assets/images/ico/favicon.ico">
    <link rel="shortcut icon" type="image/png" href="<?=_HTTP_HOST_?>/app-assets/images/ico/favicon-32.png">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="<?=_HTTP_HOST_?>/app-assets/css/bootstrap.css">
    <!-- font icons-->
    <link rel="stylesheet" type="text/css" href="<?=_HTTP_HOST_?>/app-assets/fonts/icomoon.css">
    <link rel="stylesheet" type="text/css" href="<?=_HTTP_HOST_?>/app-assets/fonts/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" type="text/css" href="<?=_HTTP_HOST_?>/app-assets/vendors/css/extensions/pace.css">
    <!-- END VENDOR CSS-->
    <!-- BEGIN ROBUST CSS-->
    <link rel="stylesheet" type="text/css" href="<?=_HTTP_HOST_?>/app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="<?=_HTTP_HOST_?>/app-assets/css/app.css">
    <link rel="stylesheet" type="text/css" href="<?=_HTTP_HOST_?>/app-assets/css/colors.css">
    <!-- END ROBUST CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="<?=_HTTP_HOST_?>/app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href=".<?=_HTTP_HOST_?>/app-assets/css/core/menu/menu-types/vertical-overlay-menu.css">
    <link rel="stylesheet" type="text/css" href="<?=_HTTP_HOST_?>/app-assets/css/pages/login-register.css">
    <!-- END Page Level CSS-->
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
    #panel {
        position: absolute;
        top: 0px;
        background-color: #fff;
        z-index: 5;
        width: 39%;
        margin:0px auto;
        left:0;
        right:0;
        height:45px;
        -moz-border-radius-bottomright: 10px;
        border-bottom-right-radius: 10px;
        -moz-border-radius-bottomleft: 10px;
        border-bottom-left-radius: 10px;
/*         
        padding: 0px;
        border: 0px solid #999;
        text-align: center;
        font-family: 'Roboto','sans-serif';
        line-height: 30px;
        padding-left: 10px; */
    }
    #in-panel{

        margin-right:15px;

    }
    </style>  
  </head>
    <body>
        <div id="basic-map"></div>

        <div id="panel" style="text-align: center;">

              
            <div id="in-panel">
<!--                 <div class="col-md-2">
                    <button type="button" class="btn btn-warning" style="float:right; margin-right:-14px;" id="xAGgroup_map"><i class="icon-undo"></i> Back
                    </button>
                </div> -->
                    <div class="col-md-9 left">
                        <fieldset class="form-group" >
                            <input width="100%" type="text" id="namePlace" class="form-control" placeholder="ค้นหา [สถานที่] [อำเภอ]" name="namePlace" style="font-size:1rem;">
                            <div class="form-control-position">
                            <i id="SearchPlace" class="icon-search primary lighten-2 font-medium-4" style="margin-left:-30px;"></i>
                                                                                   
                        </fieldset> 
                    </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-primary" style="float:left; margin-left:-20px;" id="changeLocation"><i class="icon-check2"></i> Change
                    </button>  
                </div>
            </div>

        </div>


        <!-- BEGIN VENDOR JS-->
        <script src="<?=_HTTP_HOST_?>/app-assets/js/core/libraries/jquery.min.js" type="text/javascript"></script>

        <!-- BEGIN VENDOR JS-->
        <!-- BEGIN PAGE VENDOR JS-->
        <!-- <script src="//maps.googleapis.com/maps/api/js?key=AIzaSyBDkKetQwosod2SZ7ZGCpxuJdxY3kxo5Po" type="text/javascript"></script> -->
        <script src="<?=_HTTP_HOST_?>/app-assets/vendors/js/charts/gmaps.min.js" type="text/javascript"></script>
        <!-- END PAGE VENDOR JS-->

        <script src="<?=_HTTP_HOST_?>/app-assets/js/scripts/charts/gmaps/maps_findLocation.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL JS-->
    </body>
</html>
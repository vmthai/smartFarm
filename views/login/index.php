<?php 
    require_once('./views/includes/header.php');
    require_once('./views/includes/js.php');
?>
  <body data-open="click" data-menu="vertical-menu" data-col="1-column" class="vertical-layout vertical-menu 1-column  blank-page blank-page">
    <!-- ////////////////////////////////////////////////////////////////////////////-->
    <div class="app-content container-fluid">
      <div class="content-wrapper">

        <div class="content-body">
          <section class="flexbox-container">
            <div class="col-md-4 offset-md-4 col-xs-10 offset-xs-1  box-shadow-2 p-0">
                <div class="card border-grey border-lighten-3 m-0">
                    <div class="card-header no-border">
                        <div class="card-title text-xs-center">
                            <div class="p-1"><img src="<?=_HTTP_HOST_?>/app-assets/images/logo/smart-farm.png" alt="branding logo"></div>
                        </div>
                        <h6 class="card-subtitle line-on-side text-muted text-xs-center font-small-3 pt-2"><span>Login with FAR-Control</span></h6>
                    </div>
                    <div class="card-body collapse in">
                        <div class="card-block">
                            <form class="form-horizontal" id="frm-main" novalidate><!--action="smartFarm_user.php"-->
                                <div class="form-group control-group">
                                    <input type="text" class="form-control form-control-lg input-lg" id="username" name="username" placeholder="Your Username" required>
                                    <div class="form-control-position">
                                        <i class="icon-head"></i>
                                    </div>
                                </div>
                                <div class="form-group control-group">
                                    <input type="password" class="form-control form-control-lg input-lg" id="password"
                                    name="password" placeholder="Enter Password" required>
                                    <div class="form-control-position">
                                        <i class="icon-key3"></i>
                                    </div>
                                </div>
                                <fieldset class="form-group row">
                                    <div class="col-md-6 col-xs-12 text-xs-center text-md-left">
                                        <fieldset>
                                            <input type="checkbox" id="remember-me" class="chk-remember">
                                            <label for="remember-me"> Remember Me</label>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6 col-xs-12 text-xs-center text-md-right"><a href="recover-password.html" class="card-link">Forgot Password?</a></div>
                                </fieldset>
                                <button id="btn-login" type="submit" class="btn btn-primary btn-lg btn-block"><i class="icon-unlock2"></i> Login</button>

                                            <!-- Modal -->
                                            <div class="modal fade text-xs-left" id="backdrop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4" aria-hidden="true">
                                              <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <h4 class="modal-title" id="myModalLabel4">Basic Modal</h4>
                                                  </div>
                                                  <div class="modal-body">
                                                    <h5>Check First Paragraph</h5>
                                                    <p>Oat cake ice cream candy chocolate cake chocolate cake cotton candy dragée apple pie. Brownie carrot cake candy canes bonbon fruitcake topping halvah. Cake sweet roll cake cheesecake cookie chocolate cake liquorice. Apple pie sugar plum powder donut soufflé.</p>
                                                    <p>Sweet roll biscuit donut cake gingerbread. Chocolate cupcake chocolate bar ice cream. Danish candy cake.</p>
                                                    <hr>
                                                    <h5>Some More Text</h5>
                                                    <p>Cupcake sugar plum dessert tart powder chocolate fruitcake jelly. Tootsie roll bonbon toffee danish. Biscuit sweet cake gummies danish. Tootsie roll cotton candy tiramisu lollipop candy cookie biscuit pie.</p>
                                                  </div>
                                                  <div class="modal-footer">
                                                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-outline-primary">Save changes</button>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>

                            </form>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="">
                            <!--p class="float-sm-left text-xs-center m-0"><a href="recover-password.html" class="card-link">Recover password</a></p-->
                            <p class="float-sm-right text-xs-center m-0"> <a href="register-simple.html" class="card-link">Sign Up</a></p>
                        </div>
                    </div>
                </div>
            </div>
          </section>
        </div>
      </div>
    </div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->

<?php 
    require_once('./views/includes/modal.php');
?>
  <script type="text/javascript">

 $('#btn-login').click(function(e) {
    $('#btn-login').addClass('disabled');
 });
  $("#frm-main input").jqBootstrapValidation({
      preventSubmit: true,
      submitError: function($form, event, errors) {
        console.log(1);
          $('#btn-login').removeClass('disabled');
          $('#md-error p' ).text("กรุณากรอกข้อมูลที่สำคัญให้ครบ");
          $('#md-error').modal('show');
      },
      submitSuccess: function($form, event) {
          event.preventDefault();
            ajaxRequest("home/home/login", $("#frm-main").serialize(), 'POST')
                .done(function(r) { 

                    if(r == 'logout'){
                      fncLogout();
                        return false;
                    }
                    //$('#btn-login').removeClass('disabled');
                    obj = JSON.parse(r);     
                    if(obj.result=='true') {
                         window.location.href = obj.url;
                    } else {
                      $('#md-error p' ).text(obj.message);
                      $('#md-error').modal('show');
                    }

                }).fail(function(r) {
                    return;
                }); 
      }
  });

  </script>
  </body>
</html>

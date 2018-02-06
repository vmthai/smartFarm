    <div data-scroll-to-active="true" class="main-menu menu-fixed menu-light menu-accordion menu-shadow">
      <!-- main menu header-->
      <div class="main-menu-header">
        <input type="text" placeholder="ADMINISTRATOR" class="menu-search form-control round" readonly="" />
        <!--h5> ADMINISTRATOR </h5-->
      </div>
      <!-- / main menu header-->
      <!-- main menu content-->
      <div class="main-menu-content">
        <ul id="main-menu-navigation" data-menu="menu-navigation" class="navigation navigation-main">
        <?php 
        foreach($data->menu as $key => $value){

          if($value->have_parent==0) { ?>
          <li class="nav-item">
            <a href="javascript:fncLoadContent('<?=$value->url?>');" >
              <i class="<?=$value->fa?>"></i>
              <span data-i18n="nav.dash.main" class="menu-title"><?=$value->name?></span>
            </a>
          </li>
        <?php  } else { ?>

          <li class="nav-item" id="li-nav-item<?=$value->id?>">
            <a href="#" >
              <i class="<?=$value->fa?>"></i>
              <span data-i18n="nav.dash.main" class="menu-title"><?=$value->name?></span>
            </a>
            <ul class="menu-content">
              <?php foreach($value->parent as $k => $v){?>
              <li><a href="javascript:fncLoadContent('<?=$v->url?>');" class="menu-itemc blue-grey"><?=$v->name?></a>
              </li>       
              <?php  } ?>
                          
            </ul>
          </li>
      <?php } } ?>   
       
          <li class="navigation-divider"></li>


            </ul>
          </li>

        </ul>
      </div>
      <!-- /main menu content-->
      <!-- main menu footer-->
      <!-- include includes/menu-footer-->
      <!-- main menu footer-->
    </div>
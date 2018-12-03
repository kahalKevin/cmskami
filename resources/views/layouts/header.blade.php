        <!-- Header-->
        <header id="header" class="header">  
            <div class="top-left">
                <div class="navbar-header"> 
                    <a class="navbar-brand" href="/"> <h3><b>{{ env('APP_NAME', 'CMS') }}</strong></b></h3></a>
                    <a class="navbar-brand hidden" href="/"><img src="/assets/admin/images/logo2.png" alt="Logo"></a> 
                    <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a> 
                </div> 
            </div>
            <div class="top-right"> 
                <div class="header-menu"> 

                    <div class="user-menu">
                            <a class="nav-link" href="{{ url('logout') }}"><i class="fa fa-power-off"></i> Logout</a>
                    </div>
                </div>  
            </div>
        </header><!-- /header -->
        <!-- Header-->

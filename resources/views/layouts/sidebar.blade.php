    <!-- Left Panel --> 
    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default"> 
            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="{{ (Request::is('/') || Request::is('/') ? 'active' : '') }}" >
                        <a href="{{ url('/') }}"><i class="menu-icon fa fa-laptop"></i>Dashboard </a>
                    </li>
                    <li class="menu-title">Super Store</li><!-- /.menu-title -->                    
                    <li class="menu-item-has-children dropdown {{ (Request::is('master-data') || Request::is('master-data/*') ? 'active' : '') }}">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-table"></i>Master Data</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-table"></i><a href="{{ url('/master-data/users') }}">User</a></li>
                            <li><i class="fa fa-table"></i><a href="{{ url('/master-data/sizes') }}">Size</a></li>
                            <li><i class="fa fa-table"></i><a href="{{ url('/master-data/leagues') }}">League</a></li>
                            <li><i class="fa fa-table"></i><a href="{{ url('/master-data/sleeves') }}">Sleeve</a></li>
                            <li><i class="fa fa-table"></i><a href="{{ url('/master-data/clubs') }}">Club</a></li>
                            <li><i class="fa fa-table"></i><a href="{{ url('/master-data/players') }}">Player</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-cogs"></i>Website Management</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-table"></i><a href="{{ url('/web-management/home') }}">Home Banner</a></li>
                            <li><i class="fa fa-table"></i><a href="{{ url('/web-management/adsInventory') }}">Ads Banner/Inventory Banner</a></li>
                            <li><i class="fa fa-table"></i><a href="{{ url('/web-management/privacyPolicy') }}">Privacy Policy</a></li>
                            <li><i class="fa fa-table"></i><a href="{{ url('/web-management/termUser') }}">Term of Use</a></li>
                            <li><i class="fa fa-table"></i><a href="{{ url('/web-management/aboutUs') }}">About Us</a></li>
                            <li><i class="fa fa-table"></i><a href="{{ url('/web-management/contactUs') }}">Contact Us</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown {{ (Request::is('category-product') || Request::is('category-product/*') ? 'active' : '') }}">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-cogs"></i>Category & Product</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-table"></i><a href="{{ url('/category-product/category') }}">Category</a></li>
                            <li><i class="fa fa-table"></i><a href="{{ url('/category-product/product') }}">Product</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-cogs"></i>Order Management</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-table"></i><a href="{{ url('/order-management/incoming-order') }}">Incoming Order</a></li>
                            <li><i class="fa fa-table"></i><a href="{{ url('/order-management/order') }}">All Order</a></li>
                        </ul>
                    </li> 
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-cogs"></i>Report</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li>
                                <i class="fa fa-table"></i><a href="{{ url('/order-management/incoming-order') }}">Sales</a>
                            </li>
                            <li>
                                <i class="fa fa-table"></i><a href="{{ url('/report/registrant') }}">Registrant</a>
                            </li>
                            <li>
                                <i class="fa fa-table"></i><a href="{{ url('/order-management/incoming-order') }}">Subscriber</a>
                            </li>
                            <li>
                                <i class="fa fa-table"></i><a href="{{ url('/order-management/incoming-order') }}">Contact Us</a>
                            </li>
                        </ul>
                    </li>                                        
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside><!-- /#left-panel --> 
    <!-- Left Panel -->
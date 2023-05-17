<header class="header-style-1">

    <!-- ======= TOP MENU ============================================== -->
    <div class="top-bar animate-dropdown">
        <div class="container">
            <div class="header-top-inner">
                <div class="cnt-account">
                    <ul class="list-unstyled">
                        <li><a href="#"><i class="icon fa fa-user"></i>
                                @if(session()->get('language') == 'hindi')मेरी प्रोफाइल @else My profile @endif
                            </a></li>
                        <li><a href="#"><i class="icon fa fa-heart"></i>
                                @if(session()->get('language') == 'hindi')इच्छा-सूची @else Wishlist @endif
                            </a></li>
                        <li><a href="#"><i class="icon fa fa-shopping-cart"></i>
                                @if(session()->get('language') == 'hindi')मेरी गाड़ी @else My Cart @endif
                            </a></li>
                        <li><a href="#"><i class="icon fa fa-check"></i>
                                @if(session()->get('language') == 'hindi')चेक आउट @else Checkout @endif
                            </a></li>
                        @auth
                        <li><a href="{{ route('login') }}"><i class="icon fa fa-user"></i>
                                @if(session()->get('language') == 'hindi')उपयोगकर्ता रूपरेखा @else User Profile @endif
                            </a></li>
                        @else
                        <li><a href="{{ route('login') }}"><i class="icon fa fa-lock"></i>
                                @if(session()->get('language') == 'hindi')लॉग इन / रजिस्टर @else Login/Register @endif
                            </a></li>
                        @endauth
                    </ul>
                </div>
                <!-- /.cnt-account -->

                <div class="cnt-block">
                    <ul class="list-unstyled list-inline">
                        <li class="dropdown dropdown-small"> <a href="#" class="dropdown-toggle" data-hover="dropdown"
                                data-toggle="dropdown"><span class="value">
                                    @if(session()->get('language') == 'hindi') रुपया @else USD @endif
                                </span><b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">USD</a></li>
                                <li><a href="#">INR</a></li>
                                <li><a href="#">GBP</a></li>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-small">
                            <a href="#" class="dropdown-toggle" data-hover="dropdown" data-toggle="dropdown">
                                <span class="value">
                                    @if(session()->get('language') == 'hindi') भाषा: हिन्दी @else Language @endif
                                </span>
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                @if(session()->get('language') == 'hindi')
                                <li><a href="{{ route('english.language') }}">English</a></li>
                                @else
                                <li><a href="{{ route('hindi.language') }}">हिन्दी</a></li>
                                @endif
                            </ul>
                        </li>
                    </ul>
                    <!-- /.list-unstyled -->
                </div>
                <!-- /.cnt-cart -->
                <div class="clearfix"></div>
            </div>
            <!-- /.header-top-inner -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.header-top -->
    <!-- ===== TOP MENU : END ============================================== -->
    <div class="main-header">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-3 logo-holder">
                    <!-- ======== LOGO ============================================================= -->
                    <div class="logo"> <a href="{{ url('/')  }}"> <img
                                src="{{ asset('frontend/assets/images/logo.png') }}" alt="logo"> </a>
                    </div>
                    <!-- /.logo -->
                    <!-- ========= LOGO : END ============================================================= -->
                </div>
                <!-- /.logo-holder -->

                <div class="col-xs-12 col-sm-12 col-md-7 top-search-holder">
                    <!-- /.search-row -->
                    <!-- ========== SEARCH AREA ============================================================= -->
                    <div class="search-area">
                        <form>
                            <div class="control-group">
                                <ul class="categories-filter animate-dropdown">
                                    <li class="dropdown"> <a class="dropdown-toggle" data-toggle="dropdown"
                                            href="category.html">Categories <b class="caret"></b></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li class="menu-header">Computer</li>
                                            <li role="presentation"><a role="menuitem" tabindex="-1"
                                                    href="category.html">- Clothing</a></li>
                                            <li role="presentation"><a role="menuitem" tabindex="-1"
                                                    href="category.html">- Electronics</a></li>
                                            <li role="presentation"><a role="menuitem" tabindex="-1"
                                                    href="category.html">- Shoes</a></li>
                                            <li role="presentation"><a role="menuitem" tabindex="-1"
                                                    href="category.html">- Watches</a></li>
                                        </ul>
                                    </li>
                                </ul>
                                <input class="search-field" placeholder="Search here..." />
                                <a class="search-button" href="#"></a>
                            </div>
                        </form>
                    </div>
                    <!-- /.search-area -->
                    <!-- ============ SEARCH AREA : END ============================================================= -->
                </div>
                <!-- /.top-search-holder -->

                <div class="col-xs-12 col-sm-12 col-md-2 animate-dropdown top-cart-row">
                    <!-- ========== SHOPPING CART DROPDOWN ============================================================= -->

                    <div class="dropdown dropdown-cart"> <a href="#" class="dropdown-toggle lnk-cart"
                            data-toggle="dropdown">
                            <div class="items-cart-inner">
                                <div class="basket"> <i class="glyphicon glyphicon-shopping-cart"></i> </div>
                                <div class="basket-item-count"><span class="count">2</span></div>
                                <div class="total-price-basket"> <span class="lbl">cart -</span> <span
                                        class="total-price"> <span class="sign">$</span><span
                                            class="value">600.00</span> </span> </div>
                            </div>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <div class="cart-item product-summary">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <div class="image"> <a href="detail.html"><img
                                                        src="{{ asset('frontend/assets/images/cart.jpg') }}" alt=""></a>
                                            </div>
                                        </div>
                                        <div class="col-xs-7">
                                            <h3 class="name"><a href="index.php?page-detail">Simple Product</a></h3>
                                            <div class="price">$600.00</div>
                                        </div>
                                        <div class="col-xs-1 action"> <a href="#"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.cart-item -->
                                <div class="clearfix"></div>
                                <hr>
                                <div class="clearfix cart-total">
                                    <div class="pull-right"> <span class="text">Sub Total :</span><span
                                            class='price'>$600.00</span> </div>
                                    <div class="clearfix"></div>
                                    <a href="checkout.html"
                                        class="btn btn-upper btn-primary btn-block m-t-20">Checkout</a>
                                </div>
                                <!-- /.cart-total-->

                            </li>
                        </ul>
                        <!-- /.dropdown-menu-->
                    </div>
                    <!-- /.dropdown-cart -->

                    <!-- ====== SHOPPING CART DROPDOWN : END============================================================= -->
                </div>
                <!-- /.top-cart-row -->
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container -->

    </div>
    <!-- /.main-header -->

    <!-- ========== NAVBAR ============================================== -->
    <div class="header-nav animate-dropdown">
        <div class="container">
            <div class="yamm navbar navbar-default" role="navigation">
                <div class="navbar-header">
                    <button data-target="#mc-horizontal-menu-collapse" data-toggle="collapse"
                        class="navbar-toggle collapsed" type="button">
                        <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span
                            class="icon-bar"></span> <span class="icon-bar"></span> </button>
                </div>
                <div class="nav-bg-class">
                    <div class="navbar-collapse collapse" id="mc-horizontal-menu-collapse">
                        <div class="nav-outer">
                            <ul class="nav navbar-nav">

                                <li class="active dropdown yamm-fw">
                                    <a href="{{ url('/') }}" data-hover="dropdown" class="dropdown-toggle"
                                        data-toggle="dropdown">
                                        @if(session()->get('language') == 'hindi')घर @else Home @endif

                                    </a>
                                </li>

                                <!-- // Get Category Table Data // -->
                                @php
                                $categories = App\Models\Category::orderby('category_name_en', 'ASC')->get();
                                @endphp

                                @foreach ($categories as $category)
                                <!-- Start Sub category foreach  -->
                                <li class="dropdown yamm mega-menu">

                                    <a href="{{ url('/') }}" data-hover="dropdown" class="dropdown-toggle"
                                        data-toggle="dropdown">
                                        @if(session()->get('language') == 'hindi') {{ $category->category_name_hin }}
                                        @else {{ $category->category_name_en }} @endif
                                    </a>

                                    <ul class="dropdown-menu container">
                                        <li>
                                            <div class="yamm-content ">
                                                <div class="row">
                                                    <!-- // Get SubCategory Table Data // -->
                                                    @php
                                                    $subcategories = App\Models\SubCategory::where('category_id',
                                                    $category->id)->orderby('subcategory_name_en',
                                                    'ASC')->get();
                                                    @endphp

                                                    @foreach ($subcategories as $subcategory)
                                                    <!-- /.Start Sub category foreach  -->
                                                    <div class="col-xs-12 col-sm-6 col-md-2 col-menu">
                                                        <a href="{{ url('subcategory/product/'.$subcategory->id.'/'.$subcategory->subcategory_slug_en ) }}">
                                                        <h2 class="title">
                                                            @if(session()->get('language') == 'hindi') {{
                                                            $subcategory->subcategory_name_hin }} @else {{
                                                            $subcategory->subcategory_name_en }} @endif
                                                        </h2>
                                                    </a>
                                                        @php
                                                        $subsubcategories =
                                                        App\Models\SubSubCategory::where('subcategory_id',
                                                        $subcategory->id)->orderby('subsubcategory_name_en',
                                                        'ASC')->get();
                                                        @endphp
                                                        @foreach ( $subsubcategories as $subsubcategory)
                                                        <!-- Start Sub Sub category foreach  -->
                                                        <ul class="links">
                                                            <li>
                                                                <a href="{{ url('subsubcategory/product/'.$subsubcategory->id.'/'.$subsubcategory->subsubcategory_slug_en ) }}">
                                                                    @if(session()->get('language') == 'hindi') {{
                                                                    $subsubcategory->subsubcategory_name_hin }} @else {{
                                                                    $subsubcategory->subsubcategory_name_en }} @endif
                                                                </a>
                                                            </li>
                                                        </ul>
                                                        @endforeach
                                                        <!-- Start Sub Sub category foreach  -->
                                                    </div>
                                                    @endforeach
                                                    <!-- /.End Sub category foreach  -->


                                                    <div class="col-xs-12 col-sm-6 col-md-4 col-menu banner-image">
                                                        <img class="img-responsive"
                                                            src="{{ asset('frontend/assets/images/banners/top-menu-banner.jpg') }}"
                                                            alt="">
                                                    </div>
                                                    <!-- /.yamm-content -->

                                                </div>
                                            </div>
                                        </li>
                                    </ul>

                                </li>
                                @endforeach
                                <!-- /.End category foreach  -->

                                <li class="dropdown navbar-right special-menu">
                                    <a href="#">Todays offer</a>
                                </li>
                            </ul>
                            <!-- /.navbar-nav -->
                            <div class="clearfix"></div>
                        </div>
                        <!-- /.nav-outer -->
                    </div>
                    <!-- /.navbar-collapse -->

                </div>
                <!-- /.nav-bg-class -->
            </div>
            <!-- /.navbar-default -->
        </div>
        <!-- /.container-class -->

    </div>
    <!-- /.header-nav -->
    <!-- ========== NAVBAR : END ============================================== -->

</header>

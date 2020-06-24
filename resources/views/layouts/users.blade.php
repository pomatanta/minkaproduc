<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Minka Market</title>
        
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{asset('assets/images/icons/favicon.ico')}}">
        <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <script type="text/javascript">
        WebFontConfig = {
            google: { families: [ 'Open+Sans:300,400,600,700,800','Poppins:300,400,500,600,700','Segoe Script:300,400,500,600,700' ] }
        };
        (function(d) {
            var wf = d.createElement('script'), s = d.scripts[0];
            wf.src = 'assets/js/webfont.js';
            wf.async = true;
            s.parentNode.insertBefore(wf, s);
        })(document);
    </script>

    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">

    <!-- Main CSS File -->
    <link rel="stylesheet" href="{{asset('assets/css/style.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/admin.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/fontawesome-free/css/all.min.css')}}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>

    
    <?php
        if(auth::check()){
            $carrito = DB::table('carrito as c')
            ->join('producto as p','c.idproducto','=','p.id')
            ->select('c.cantidad','p.poster','p.titulo','p.precio_ahora','c.id')
            ->where('iduser','=',auth()->user()->id)
            ->orderby('c.id','desc')
            ->limit(2)
            ->get();
            $carrito_total = DB::table('carrito')
            ->where('iduser','=',auth()->user()->id)
            ->get();
            $num_compras = count($carrito_total);
        }
        $config = DB::table('configuraciones')
        ->first();
    ?>
    <div class="page-wrapper">
        <header class="header">
            <div class="header-top" style="background: #232f3e !important; color: white !important;border: none !important">
                <div class="container">
                    <div class="header-left header-dropdowns">
  

                    <!--     <div class="dropdown compare-dropdown">
                            <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                <i class="icon-retweet"></i> Compare (2)
                            </a>

                            <div class="dropdown-menu" >
                                <div class="dropdownmenu-wrapper">
                                    <ul class="compare-products">
                                        <li class="product">
                                            <a href="#" class="btn-remove" title="Remove Product"><i class="icon-cancel"></i></a>
                                            <h4 class="product-title"><a href="product.html">Lady White Top</a></h4>
                                        </li>
                                        <li class="product">
                                            <a href="#" class="btn-remove" title="Remove Product"><i class="icon-cancel"></i></a>
                                            <h4 class="product-title"><a href="product.html">Blue Women Shirt</a></h4>
                                        </li>
                                    </ul>

                                    <div class="compare-actions">
                                        <a href="#" class="action-link">Clear All</a>
                                        <a href="#" class="btn btn-primary">Compare</a>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div><!-- End .header-left -->

                    <div class="header-right">

                        <div class="header-dropdown dropdown-expanded">
                            <a href="#">Mi cuenta</a>
                            <div class="header-menu">
                                <ul>
                                    <li><a href="{{route('contacto')}}">CONTACTENOS</a></li>
                                    @if (!auth::check())
                                        <li><a href="{{route('login.user')}}">INICIAR SESIÓN</a></li>
                                        
                                    @else
                                        <li><a href="{{route('cuenta')}}">MI CUENTA </a>
                                       
                                        </li>

                            <li class="nav-item dropdown">
                                <a >
                                    @if(Auth::user()->avatar)
                                    <img src="{{ Auth::user()->avatar }}"  class="rounded-circle" alt="HelPic" height="30" alt="Imagen de perfil">
                                    @endif
                                    {{ Auth::user()->name }} 
                                  
                                </a>

                               
                            </li>

                              <li>
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        Cerrar sesión
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>


                                    @endif
                                </ul>
                            </div><!-- End .header-menu -->
                        </div><!-- End .header-dropown -->
                    </div><!-- End .header-right -->
                </div><!-- End .container -->
            </div><!-- End .header-top -->

            <div class="navbar" style="background: #0033FF">
                <div class="container">
                    <div class="header-left">
                        <a href="{{route('inicio')}}" class="logo">
                        <img src="{{asset('config/'.$config->logo)}}" alt="devctheme Logo" width="160" hesight="100">
                        </a>
                    </div><!-- End .header-left -->

                    <div class="header-center">
                        <div class="header-search">
                            <a class="search-toggle" role="button"> <p class="small text-center text-light">Buscar <i class="icon-magnifier text-light"></i></p></a>
                            {!! Form::open(array('url'=>'productos','method'=>'GET','autocomplete'=>'off','role'=>'search'))!!}
                                <div class="header-search-wrapper">
                                    
                                    
                                    <input type="search" class="small form-control" placeholder="Buscar por producto,marca o categoria." name="buscar"  required>
                                    
                                    
                                    
                                    <button class="btn" type="submit" type="submit"><i class="icon-magnifier"></i></button>
                                </div><!-- End .header-search-wrapper -->
                            {{Form::close()}}
                        </div><!-- End .header-search -->
                    </div><!-- End .headeer-center -->

                    <div class="header-right">
                        <button class="mobile-menu-toggler" type="button">
                            <i class="icon-menu"></i>
                        </button>
                        <div class="header-contact">
                            <span>Llamanos</span>
                            <a href="tel:#"><strong>{{$config->telefono}}</strong></a>
                        </div><!-- End .header-contact -->


                       @if (Auth::check())
                            <div class="dropdown cart-dropdown">
                                <a class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                    <span class="cart-count"><?php echo $num_compras?></span>
                                </a>
                                
                                <div class="dropdown-menu" >
                                    <div class="dropdownmenu-wrapper">
                                        <div class="dropdown-cart-products">
                                            
                                            @if (count($carrito)>0)
                                                @foreach ($carrito as $item)
                                                    <div class="product">
                                                        <div class="product-details">
                                                            <h4 class="product-title">
                                                                <a href="product.html">{{$item->titulo}}</a>
                                                            </h4>

                                                            <span class="cart-product-info">
                                                                <span class="cart-product-qty">{{$item->cantidad}}</span>
                                                                = S/<?php echo $item->precio_ahora * $item->cantidad?>
                                                            </span>
                                                        </div><!-- End .product-details -->

                                                        <figure class="product-image-container">
                                                            <a href="product.html" class="product-image">
                                                                <img src="{{asset('poster/'.$item->poster)}}" alt="product">
                                                            </a>
                                                            <form action="{{route('quitar.carrito',$item->id)}}" method="POST" style="margin-bottom: 0px !important; cursor:pointer">
                                                                @csrf
                                                        
                                                                <input name="_method" type="hidden" value="DELETE">
                                                                <button type="submit" class="btn-remove"  title="Eliminar producto"><i class="icon-cancel"></i></button>
                                                            </form>
                                                            
                                                        </figure>
                                                    </div><!-- End .product -->
                                                @endforeach
                                            @else
                                                <div class="product">
                                                    <div class="product-details">
                                                        <h4>Carrito vacio :(</h4>
                                                    </div>
                                                </div>
                                            @endif

                                            
                                        </div><!-- End .cart-product -->

                                      

                                        <div class="dropdown-cart-action" style="margin-top:8px">
                                            <a href="{{route('carrito')}}" class="btn">Ver carrito</a>   
                                        </div><!-- End .dropdown-cart-total -->
                                    </div><!-- End .dropdownmenu-wrapper -->
                                </div><!-- End .dropdown-menu -->
                                
                            </div><!-- End .dropdown -->
                       @endif
                    </div><!-- End .header-right -->
                </div><!-- End .container -->
            </div><!-- End .header-middle -->



            <div class="header-bottom sticky-header" style="background: #636B6F   !important; color: white !important;border: none !important">
                <div class="container">
                    <nav class="main-nav">
                        <ul class="menu sf-arrows">
                            <li><a class="item-primary" href="{{route('inicio')}}">Inicio</a></li>
                            <li><a class="item-primary" href="{{route('productos')}}">Productos</a></li>
                            @if (auth::check())
                                <li><a href="{{route('mis_compras')}}" class="item-primary">Mis compras</a></li>
                            @endif
                            <li>
                                <?php 
                                
                                    $categorias = DB::table('categoria')
                                    ->orderby('titulo','asc')
                                    ->get();
                                                                
                                ?>
                                <a href="#" class="sf-with-ul item-primary">Categorias</a>
                                <div class="megamenu megamenu-fixed-width">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                   {{--  <div class="menu-title">
                                                        <a href="#">Filtro<span class="tip tip-new">New!</span></a>
                                                    </div> --}}
                                                    <ul>
                                                        @foreach ($categorias as $item)
                                                        <li><a href="{{route('productos.categoria',strtolower($item->titulo))}}"><i class="{{$item->icono}}"></i> {{$item->titulo}}</a></li>
                                                        @endforeach
                                                    </ul>
                                                </div><!-- End .col-lg-6 -->
                                                
                                            </div><!-- End .row -->
                                        </div><!-- End .col-lg-8 -->
                                        
                                    </div>
                                </div><!-- End .megamenu -->
                            </li>
                           
                                    
                            
                            
                        </ul>
                    </nav>
                </div><!-- End .header-bottom -->
            </div><!-- End .header-bottom -->
        </header><!-- End .header -->
        @yield('user-content')

        <footer class="footer" style="background: #232f3e !important">
            <div class="footer-middle">
                <div class="container">
                    <div class="footer-ribbon">
                        {{$config->titulo}}
                    </div><!-- End .footer-ribbon -->
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="widget">
                                <h4 class="widget-title">Contactanos</h4>
                                <ul class="contact-info">
                                    <li>
                                        <span class="contact-info-label">Dirección:</span><?php echo $config->direccion?>
                                    </li>
                                    <li>
                                        <span class="contact-info-label">Telefono:</span>Toll Free <a href="tel:"><?php echo $config->telefono?></a>
                                    </li>
                                    <li>
                                        <span class="contact-info-label">Correo:</span> <a href="mailto:mail@example.com"><?php echo $config->correo?></a>
                                    </li>
                                    <li>
                                        <span class="contact-info-label">Ateanción:</span>
                                        <?php echo $config->horario?>
                                    </li>
                                </ul>
                                <div class="social-icons">
                                    <a href="#" class="social-icon" target="_blank"><i class="icon-facebook"></i></a>
                                    <a href="#" class="social-icon" target="_blank"><i class="icon-twitter"></i></a>
                                    <a href="#" class="social-icon" target="_blank"><i class="icon-linkedin"></i></a>
                                </div><!-- End .social-icons -->
                            </div><!-- End .widget -->
                        </div><!-- End .col-lg-3 -->

                        <div class="col-lg-9">
                            <div class="widget widget-newsletter">
                                <h4 class="widget-title">NOSOTROS</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p>Venta de productos de primera necesitad!!
                                           Lo enviamos a la puerta de tu hogar!! Con los protocolos de limpieza y seguridad!¡COMPRA CON UN CLICK </p>
                                    </div><!-- End .col-md-6 -->

                                    <div class="col-md-6">
                                        <form action="#">
                                            <input type="email" class="form-control" placeholder="Correo electrónico" required>

                                            <input type="submit" class="btn" value="Inscribirme">
                                        </form>
                                    </div><!-- End .col-md-6 -->
                                </div><!-- End .row -->
                            </div><!-- End .widget -->

                            <div class="row">
                                <div class="col-md-5">
                                    <div class="widget">
                                        <h4 class="widget-title">MI CUENTA</h4>

                                        <div class="row">
                                            <div class="col-sm-6 col-md-5">
                                                <ul class="links">
                                                    <li><a href="{{route('cuenta')}}">Perfil</a></li>
                                                    <li><a href="{{route('contacto')}}">Contactanos</a></li>
                                                    <li><a href="{{route('mis_compras')}}">Compras</a></li>
                                                </ul>
                                            </div><!-- End .col-sm-6 -->
                                            <div class="col-sm-6 col-md-5">
                                                <ul class="links">
                                                    <li><a href="{{route('carrito')}}">Mi carrito</a></li>
                                                    <li><a href="{{route('productos')}}">Productos</a></li>
                                                    <li><a href="{{route('login.user')}}" class="login-link">Login</a></li>
                                                </ul>
                                            </div><!-- End .col-sm-6 -->
                                        </div><!-- End .row -->
                                    </div><!-- End .widget -->
                                </div><!-- End .col-md-5 -->

                                <div class="col-md-7">
                                    <div class="widget">
                                        <h4 class="widget-title">Proveedor</h4>
                                        
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <ul class="links">
                                                    <li><a href="#">Sofwend</a></li>
                                             
                                                </ul>
                                            </div><!-- End .col-sm-6 -->
                               <!--              <div class="col-sm-6">
                                                <ul class="links">
                                                    <li><a href="#">Powerful Admin Panel</a></li>
                                                    <li><a href="#">Mobile & Retina Optimized</a></li>
                                                </ul>
                                            </div><!-- End .col-sm-6 -->
                                        </div><!-- End .row -->
                                    </div><!-- End .widget -->
                                </div><!-- End .col-md-7 -->
                            </div><!-- End .row -->
                        </div><!-- End .col-lg-9 -->
                    </div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .footer-middle -->

            <div class="container">
                <div class="footer-bottom">
                    <p class="footer-copyright">{{$config->titulo}}. &copy;  2020.  Todos los derechos reservados.</p>

                    <img src="{{asset('assets/images/payments.png')}}" alt="payment methods" class="footer-payments">
                </div><!-- End .footer-bottom -->
            </div><!-- End .container -->
        </footer><!-- End .footer -->
    </div><!-- End .page-wrapper -->

    <div class="mobile-menu-overlay"></div><!-- End .mobil-menu-overlay -->

    <div class="mobile-menu-container">
        <div class="mobile-menu-wrapper">
            <span class="mobile-menu-close"><i class="icon-cancel"></i></span>
            <nav class="mobile-nav">
                <ul class="mobile-menu">
                    <li class="active"><a href="{{route('inicio')}}">Inicio</a></li>
                    @if (!auth::check())
                    <li class="active"><a href="{{route('login.user')}}">Iniciar sesión</a></li>
                    @endif
                    <li>
                        <a href="">Categorias</a>
                        <ul>
            
                            @foreach ($categorias as $item)
                                <li><a href="{{route('productos.categoria',strtolower($item->titulo))}}"><i class="{{$item->icono}}"></i> {{$item->titulo}}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li><a class="item-primary" href="{{route('productos')}}">Productos</a></li>
                    <li><a class="item-primary" href="{{route('contacto')}}">Contacto</a></li>
                    @if (auth::check())
                        <li><a href="{{route('mis_compras')}}" class="item-primary">Mis compras</a></li>

                    @endif
                </ul>
            </nav><!-- End .mobile-nav -->

            <div class="social-icons">
                <a href="#" class="social-icon" target="_blank"><i class="icon-facebook"></i></a>
                <a href="#" class="social-icon" target="_blank"><i class="icon-twitter"></i></a>
                <a href="#" class="social-icon" target="_blank"><i class="icon-instagram"></i></a>
            </div><!-- End .social-icons -->
        </div><!-- End .mobile-menu-wrapper -->
    </div><!-- End .mobile-menu-container -->

   
    <div class="modal fade" id="addCartModal" tabindex="-1" role="dialog" aria-labelledby="addCartModal" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body add-cart-box text-center">
            <p>You've just added this product to the<br>cart:</p>
            <h4 id="productTitle"></h4>
            <img src="" id="productImage" width="100" height="100" alt="adding cart image">
            <div class="btn-actions">
                <a href="cart.html"><button class="btn-primary">Go to cart page</button></a>
                <a href="#"><button class="btn-primary" data-dismiss="modal">Continue</button></a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <a id="scroll-top" href="#top" title="Top" role="button"><i class="icon-angle-up"></i></a>

    <!-- Plugins JS File -->
    <script src="{{asset('assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins.min.js')}}"></script>
    
    <!-- Main JS File -->
    <script src="{{asset('assets/js/main.min.js')}}"></script>
    <script src="{{asset('assets/js/nouislider.min.js')}}"></script>
    <script src="https://checkout.culqi.com/js/v3"></script>
    <script>
        
    
   
    </script>
    @stack('scripts')
</body>
</html>

@extends('layouts.users')
@section('user-content')
<main class="main">
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('inicio')}}"><i class="icon-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">Carrito de compras</li>
            </ol>
        </div><!-- End .container -->
    </nav>
    <?php 
    
    $config = DB::table('configuraciones')
    ->first();
?>
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                @if (Session::has('danger'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{Session::get('danger')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div> 
                @endif

                <div class="cart-table-container">
                    @if (count($carrito)>0)
                        <table class="table table-cart">
                            <thead>
                                <tr>
                                    <th class="product-col">Producto</th>
                                    <th class="price-col">Precio</th>
                                    <th class="qty-col">Cantidad</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            @foreach ($carrito as $item)
                                <tbody >
                                    <tr class="product-row" >
                                        <td class="product-col" >
                                            <figure class="product-image-container">
                                                <a href="{{route('productos')}}" class="product-image">
                                                    <img src="{{asset('poster/'.$item->poster)}}" alt="product">
                                                </a>
                                            </figure>
                                            <h2 class="product-title">
                                                <a href="{{route('producto',$item->slug)}}">{{$item->titulo}}</a>
                                            </h2>
                                        </td>
                                        <td>
                                            @if ($config->tipo_moneda == 'Soles')
                                                    S/.
                                                @elseif($config->tipo_moneda == 'Dolares')
                                                    $
                                                @endif
                                            {{$item->precio_ahora}}
                                    <input type="hidden" value="{{$item->precio_ahora}}" name="precio_ahora[]" id="precio_ahora[]">
                                        </td>
                                        <td>
                                            {{-- {{$item->cantidad}} uni. --}}
                                               <div class="product-single-qty" onclick="EnviarCantidad()" >
                                    <input class="horizontal-quantity form-control"   id="cantidad[]" name="cantidad[]" type="text">
                                         <input type="hidden" value="{{$item->idproducto}}"  class="item"  name="idproducto[]" id="idproducto[]"> 
                                            </div>
                                        </td>
                                        <td class="total_neto">
                                            S/. <label id="subtotalpre" name="subtotalpre"><?php echo $item->precio_ahora * $item->cantidad?></label>
                                                    
                                               
                                            </td>
                                    </tr>
                                    <tr class="product-action-row">
                                        <td colspan="4" class="clearfix">
                                        
                                            
                                            <div class="float-right">
                                                <form action="{{route('quitar.carrito',$item->id)}}" method="POST" style="margin-bottom: 0px !important; cursor:pointer">
                                                    @csrf
                                                    <input name="_method" type="hidden" value="DELETE">
                                                    <button type="submit" title="Quitar producto" style="border: none !important;
                                                    background: none !important;" class="btn-remove"><span class="sr-only">Eliminar</span></button>
                                                </form>
                                            </div><!-- End .float-right -->
                                        </td>
                                    </tr>

                                
                                </tbody>
                            @endforeach

                            <tfoot>
                                <tr>
                                    <td colspan="4" class="clearfix">
                                        <div class="float-left">
                                            <a href="{{route('productos')}}" class="btn btn-outline-secondary">Continuar comprando</a>
                                        </div><!-- End .float-left -->

                                    
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    @else
                        <h1 class="mt-4" style="font-weight: 300">Tu carrito está vacio.</h1>
                    @endif
                </div><!-- End .cart-table-container -->

               {{--  <div class="cart-discount">
                    <h4>Apply Discount Code</h4>
                    <form action="#">
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm" placeholder="Enter discount code"  required>
                            <div class="input-group-append">
                                <button class="btn btn-sm btn-primary" type="submit">Apply Discount</button>
                            </div>
                        </div><!-- End .input-group -->
                    </form>
                </div><!-- End .cart-discount --> --}}
            </div><!-- End .col-lg-8 -->

            <div class="col-lg-4">
                <div class="cart-summary">
                    <h3>Detalles</h3>

                    <h4>
                        <a data-toggle="collapse" href="#total-estimate-section" class="collapsed" role="button" aria-expanded="false" aria-controls="total-estimate-section">ENVIO</a>
                    </h4>

                    <div class="collapse show" id="total-estimate-section">
                        <form action="#">
                            <div class="form-group form-group-sm">
                                <label>Direcciones</label>
                                <div class="select-custom">
                                    <select class="form-control form-control-sm" id="direccion">
                                        @foreach ($direcciones as $item)
                                            <option value="{{$item->id}}">{{$item->direccion}}</option>
                                        @endforeach                                       
                                    </select>
                                </div><!-- End .select-custom -->
                            </div><!-- End .form-group -->

                           
                        </form>
                    </div><!-- End #total-estimate-section -->

                    <table class="table table-totals">
                        <tbody>
                            <tr>
                                <td>Total</td>
                                <td>
                                    @if ($config->tipo_moneda == 'Soles')
                                                    S/.
                                                @elseif($config->tipo_moneda == 'Dolares')
                                                    $
                                                @endif
                                    {{$total}}</td>
                            </tr>
                         



                              
                            <tr>
                                <td>Descuento</td>
                                <td>$0.00</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>Total a pagar</td>
                                <td>
                                    
                                    @if ($config->tipo_moneda == 'Soles')
                                                    S/.
                                                @elseif($config->tipo_moneda == 'Dolares')
                                                    $
                                                @endif
                                    {{$total}}</td>
                            </tr>
                        </tfoot>
                    </table>

                    <div class="checkout-methods">
                        
                        @if (count($carrito)>0)
                           {{--  <div id="paypal-button-container">                                                                     
                            </div> --}}
                        @else
                            
                        @endif
                        <script src="https://www.paypalobjects.com/api/checkout.js"></script>
                        
                    </div><!-- End .checkout-methods -->
                    <button id="buyButton" class="btn btn-primary btn-block" style="padding:10px;border: none;background: #dd0d0d"><i class="fas fa-credit-card"></i> Pagar con tarjeta</button>
                     <button  id="ButtonEfetivo" class="btn btn-primary btn-block" type="submit"></i>Pagar en efectivo</button>
                </div><!-- End .cart-1summary -->
            </div><!-- End .col-lg-4 -->
        </div><!-- End .row -->
    </div><!-- End .container -->

    <div class="mb-6"></div><!-- margin -->
</main>
@push('scripts')
<script>

    var moneda ;

    var total_culqui;

    
function cleanChar(str, char) {
    console.log('cleanChar()'); // HACK: trace
    while (true) {
        var result_1 = str.replace(char, '');
        if (result_1 === str) {
            break;
        }
        str = result_1;
    }
    return str;
};

    if('<?php echo $config->tipo_moneda?>' == 'Soles'){
        var moneda = 'PEN'; 
    }else if('<?php echo $config->tipo_moneda?>' == 'Dolares'){
        var moneda = 'USD'; 
    }

    if(moneda == 'PEN'){
        inicio = '.';

         Totalpre  = parseInt('<?php echo $total?>');
          

           TotalPrecio = ('<?php echo $total ?>');
         total_culqui =  ('<?php echo $totaltarjeta ?>');


    }else if(moneda == 'USD'){
        // total_culqui = parseInt('<?php echo $total?>')* parseInt('3.35');
    }

    paypal.Button.render({
    env: '<?php echo $config->paypal_mode?>', 
    style: {

        label: 'paypal',  // checkout | credit | pay | buynow | generic
        size:  'responsive', // small | medium | large | responsive
        shape: 'pill',   // pill | rect
        color: 'gold'   // gold | blue | silver | black
    },


    client: {
        sandbox:    '<?php echo $config->paypal_client_id?>',
        production: '<?php echo $config->paypal_client_id_production?>'
    },

 

    payment: function(data, actions) {
        if('<?php echo $authenticate?>'){

            return actions.payment.create({
                payment: {
                    transactions: [
                        {
                            amount: { total: '<?php echo $total?>', currency: 'USD' },
                            description:"Compras en Minka Market, TOTAL A PAGAR: <?php echo $total?>USD" ,
                        }
                    ]
                }
            });
        }else{
            window.location.href = "{{URL::to('')}}"
        }
    },

    
    onAuthorize: function(data, actions) {
   
        
        return actions.payment.execute().then(function() {
           
           var productos = '<?php echo $data_productos?>';
           var cantidades = '<?php echo $data_cantidades?>';
           var transanccion  = data.paymentID;
           var codigo = '<?php echo uniqid();?>';
           var direccion = document.getElementById('direccion').value;
           window.location="../../../../venta/checkout/detalles/"+codigo+"/"+transanccion+"/"+productos+"/"+cantidades+"/"+direccion+'/'+'<?php echo $total?>'+'/USD/paypal';

        });
    }

}, 
// '#paypal-button-container'
);

/***********************************************************************/


Culqi.publicKey = '<?php echo $config->culqui_key_public?>';

  
Culqi.settings({

    title: '<?php echo $config->titulo?>',
    currency: moneda,
    amount: total_culqui,
});
// Usa la funcion Culqi.open() en el evento que desees
$('#buyButton').on('click', function(e) {


          console.log(total_culqui);

        // console.log('TotalPrecio');
        // console.log(TotalPrecio);
        // console.log('TotalPre');
        // console.log(Totalpre);
        // console.log('Total');
        // console.log(Total);

        //        total
    // Abre el formulario con las opciones de Culqi.settings
  var cantidades = '<?php echo $data_cantidades?>';
   let Valdireccion =  document.getElementById('direccion').value;
  if(cantidades){
  if(Valdireccion){

    Culqi.open();
    e.preventDefault();

   }else{
   
     
      alert("Por favor Necesita ingresar una Dirección y numero de telefono");
   return window.location="../../cuenta/direcciones";
   }

    }else{
         alert("No selecciono ningún Producto");
    }



});

function culqi() {

 
  if (Culqi.token) { 
        let token = Culqi.token.id;
        let productos = '<?php echo $data_productos?>';
        let cantidades = '<?php echo $data_cantidades?>';
        let transanccion  = token;
        let codigo = '<?php echo uniqid();?>';
        let direccion = document.getElementById('direccion').value;

         console.log(cantidades);
          console.log(total_culqui);
  
     return window.location="../../../../venta/checkout/detalles/"+codigo+"/"+transanccion+"/"+productos+"/"+cantidades+"/"+direccion+'/'+total_culqui+'/'+moneda+'/culqi';
  } else { 
      console.log(Culqi.error);
      alert(Culqi.error.user_message);
  }



};



$('#ButtonEfetivo').on('click', function(e) {
    // Abre el formulario con las opciones de Culqi.settings

   let Valdireccion =  document.getElementById('direccion').value;

  var cantidades = '<?php echo $data_cantidades?>';

    if(cantidades){
   if(Valdireccion){
     let token = '56456';
        let productos = '<?php echo $data_productos?>';
        let cantidades = '<?php echo $data_cantidades?>';
        let transanccion  = token;
        let codigo = '<?php echo uniqid();?>';
        let direccion = document.getElementById('direccion').value;
  
     return window.location="../../../../venta/checkout/detalles/"+codigo+"/"+transanccion+"/"+productos+"/"+cantidades+"/"+direccion+'/'+total_culqui+'/'+moneda+'/efectivo';
   }else{
   
     
      alert("Por favor Necesita ingresar una Dirección y numero de telefono");
   return window.location="../../cuenta/direcciones";
   }

    }else{
         alert("No selecciono ningún Producto");
    }
 

});

   
    function EnviarCantidad(){



var cantidad   = document.getElementsByName("cantidad[]");
var idproducto = document.getElementsByName("idproducto[]");
var precio_ahora = document.getElementsByName("precio_ahora[]");

   // for ( var i=1; n = idproducto.length; i < n; i +=2) {  //pre-incremento de 2  y bucle para primer parcial
    
   //         console.log(idproducto);
        
   //       }
   //     }
    var cant = [];
    var prodid = [];
    var precioahora = [];
    var subtotalprex = [];


    //Recorro todos los nodos que encontre que coinciden con ese nombre
    for(var i=0;i<cantidad.length;i++){
        //Añado el valor que contienen los campos

        cant.push(cantidad[i].value);
         prodid.push(idproducto[i].value);
         precioahora.push(precio_ahora[i].value);
        precioahora.push(precio_ahora[i].value);

             // console.log(cant[i]);
             // console.log(prodid[i]);
             //  console.log(precioahora[i]);

    }


       //var idproducto = document.getElementById("idproducto[]").value;
     
// var elements = document.getElementById("idproducto[]").value;
// let valor = $("#idproducto[]").val();
// for(i=0;i<mutli_education.length;i++)
// {
// alert(mutli_education[i].value);
// }



        
      //  var precio_ahora = document.getElementById("precio_ahora").value;
       //var cantidadx = document.getElementById("cantidad").value;
        // var precio_ahora = document.getElementById("precio_ahora").value;
        // var cantidad = document.getElementById("cantidad").value;



    // var subtotalprex = precio_ahora * cantidadx;
    // console.log(subtotalprex);
    // document.getElementById('subtotalpre').innerHTML = subtotalprex;
  

     
};


</script>
@endpush
@endsection

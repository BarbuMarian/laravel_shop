
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-item nav-link active" href="{{route('sorting')}}">Home <span class="sr-only">(current)</span></a>
          <a href="{{route('product.shoppingCart')}}"><i class="fas fa-shopping-cart nav-item nav-link"></i>
             <span class="badge">{{session()->has('cart') ? session()->get('cart')->totalQty : ''}}</span>
         </a>
         <a href="{{ route('logAdmin') }}" class=" nav-item nav-link">logare</a>
        </div>
      </div>
    </nav>

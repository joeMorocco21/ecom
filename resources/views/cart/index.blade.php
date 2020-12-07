@extends('layouts.master')
@section('extra-meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
@if(Cart::count() > 0)

<div class="px-4 px-lg-0">

  <div class="pb-5">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 p-5 bg-white rounded shadow-sm mb-5">

          <!-- Shopping cart table -->
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col" class="border-0 bg-light">
                    <div class="p-2 px-3 text-uppercase">Produit</div>
                  </th>
                  <th scope="col" class="border-0 bg-light">
                    <div class="py-2 text-uppercase">Prix</div>
                  </th>
                  <th scope="col" class="border-0 bg-light">
                    <div class="py-2 text-uppercase">Quantité</div>
                  </th>
                  <th scope="col" class="border-0 bg-light">
                    <div class="py-2 text-uppercase">Supprimé</div>
                  </th>
                </tr>
              </thead>
              <tbody>
                @foreach(Cart::content() as $product)
                <tr>
                  <th scope="row" class="border-0">
                    <div class="p-2">
                      <img src="{{ $product->model->image }}" alt="" width="70" class="img-fluid rounded shadow-sm">
                      <div class="ml-3 d-inline-block align-middle">
                        <h5 class="mb-0"> <a href="#" class="text-dark d-inline-block align-middle">{{ $product->model->title }}</a></h5><span class="text-muted font-weight-normal font-italic d-block">Category: </span>
                      </div>
                    </div>
                  </th>
                  <td class="border-0 align-middle"><strong>{{ getPrices($product->subtotal()) }}</strong></td>
                  <td class="border-0 align-middle"><strong>
                  <select name="qty" id="qty" data-id="{{ $product->rowId }}" data-stock="{{ $product->model->stock }}" class="custom-select">
                  @for ($i = 1; $i <= 6; $i++)
                  <option value="{{ $i }}" {{ $i == $product->qty ? 'selected' : '' }} >{{ $i }}</option>
                  @endfor
                  </select>
                  </strong></td>
                  <td class="border-0 align-middle">
                  <form action="{{ route('cart.destroy', $product->rowId) }}" method="post">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-warning"><span class="glyphicon glyphicon-trash"></span></button>
                  </form>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <!-- End -->
        </div>
      </div>

      <div class="row py-5 p-4 bg-white rounded shadow-sm">
        <div class="col-lg-6">
          <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Coupon code</div>
        @if (!request()->session()->has('coupon'))
        <div class="p-4">
            <p class="font-italic mb-4">If you have a coupon code, please enter it in the box below</p>
            <form action="{{ route('cart.store.coupon') }}" method="POST">
             @csrf 
            <div class="input-group mb-4 border rounded-pill p-2">
            <input type="text" placeholder="Apply coupon" aria-describedby="button-addon3" name="code" class="form-control border-0">
              <div class="input-group-append border-0">
                <button id="button-addon3" type="submit" class="btn btn-dark px-4 rounded-pill"><i class="fa fa-gift mr-2"></i>Apply coupon</button>
              </div>

            </div>
            </form>            
          </div>

        @else
        <div class="p-4">
            <p class="font-italic mb-4">Un coupon est déja appliqué</p>
        </div>
        @endif
          <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Instructions for seller</div>
          <div class="p-4">
            <p class="font-italic mb-4">If you have some information for the seller you can leave them in the box below</p>
            <textarea name="" cols="30" rows="2" class="form-control"></textarea>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Détails de la commande </div>
          <div class="p-4">
            <p class="font-italic mb-4">Shipping and additional costs are calculated based on values you have entered.</p>
            <ul class="list-unstyled mb-4">
              <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Sous-total</strong><strong>{{ getPrices(Cart::subtotal()) }}</strong></li>
              @if (request()->session()->has('coupon'))
              <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Coupon {{ request()->session()->get('coupon')['code'] }}
                <form action="{{ route('cart.destroy.coupon') }}" method="POST" class="d-inline-block">
              @csrf
              @method('DELETE')
              <button type="submit"  class="btn btn-sm btn-outline-danger">
              <span class="glyphicon glyphicon-trash"></span>
              </button> 
              </form>
              </strong><strong>{{ getPrices(request()->session()->get('coupon')['remise']) }}</strong></li>
              <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Sous-Total*</strong>
              <strong>{{ getPrices(Cart::subtotal() - request()->session()->get('coupon')['remise']) }} </strong></li>
              <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Taxe*</strong><strong>
                {{ getPrices((Cart::subtotal() - request()->session()->get('coupon')['remise']) * (config('cart.tax') / 100)) }}
              </strong></li>
              <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Total*</strong>
              <strong>
              {{ getPrices((Cart::subtotal() - request()->session()->get('coupon')['remise']) * (config('cart.tax') / 100) + Cart::subtotal() - request()->session()->get('coupon')['remise'] ) }}

              </strong></li>
              @else
              <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Taxe</strong><strong>{{ getPrices(Cart::tax()) }}</strong></li>
              <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Total</strong>
                <h5 class="font-weight-bold">{{ getPrices(Cart::total()) }}</h5>
              </li>
              @endif
            </ul><a href="{{ route('checkout.index') }}" class="btn btn-dark rounded-pill py-2 btn-block">Passé la commande</a>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
@else
<p>Votre panier est vide.</p>
@endif
@endsection
@section('extra-js')
<script>
var selects = document.querySelectorAll('#qty');
Array.from(selects).forEach((element)=>{
  element.addEventListener('change', function (){
    var rowId = this.getAttribute('data-id');
    var stock = this.getAttribute('data-stock');
    var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    fetch(
      `panier/${rowId}`,
      {
        headers: {
          "Content-Type": "application/json",
          "Accept": "application/json, text-plain, */*",
          "X-Requested-With": "XMLHttpRequest",
          "X-CSRF-TOKEN": token
        },
        method: 'patch',
        body: JSON.stringify({
          qty: this.value,
          stock: stock
        })
      }
    ).then((data)=>{
      console.log(data);
      location.reload();
    }).catch((error) => {
      console.log(error)
    })
  });
});
</script>
@endsection
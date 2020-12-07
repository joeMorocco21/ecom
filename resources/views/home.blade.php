@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
@foreach (Auth()->user()->orders as $order)
<div class="card">
<div class="card-header">
Commande passée le {{ Carbon\Carbon::parse
($order->payment_created_at)->format('d/m/Y à H:i')}}
dun montant de <strong>{{ getPrices( $order->amount ) }}</strong>
</div>
<div class="card-body">
<h6>Listes des produits</h6>
@foreach (unserialize($order->products) as $product)
<div>Nom du produit: {{ $product[0] }}</div>
<div>Prix: {{ getPrices( $product[1] ) }}</div>
<div>Qantité: {{ $product[2] }}</div>


@endforeach
</div>
</div>

@endforeach

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

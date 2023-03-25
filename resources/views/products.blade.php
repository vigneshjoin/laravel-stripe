@include('layout.header')

    <div class="card">
        <div class="section">
            <div class="row">
                @foreach($products as $product)
                <div class="col-4 mt-1">
                <div class="card">
                <div class="card-body">
                    <div class="">
                        <div class="">
                            <h4 class="">Product Name :{{$product->name}}</h4>
                            <div class="">Description : {{$product->description}}</div>
                            <div class="">Price: Rs.{{$product->price}}</div>
                        </div>

                        <div class="mt-3">
                            <a href="{{route('product', [$product->id])}}" class="btn btn-info btn-lg btn-rounded">Buy Now</a>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

@include('layout.footer')

@extends('products.layout')

@section('content')

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Show Product</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('products.index') }}"> Back</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                {{ $product->name }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Details:</strong>
                {{ $product->detail }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Price:</strong>
                {{ $product->price }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Image:</strong>
                <img src="/product/fetch_image/{{ $product->id }}" class="img"  width=315/>
            </div>
        </div>

        {{-- <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Product Detail:</strong>
                @foreach ($product->product_images as $productImage)
                    <img src="/product/fetch_detail/{{ $productImage->id }}" class="img" width=115 />
                @endforeach
            </div>
        </div> --}}
    </div>
    @
    <div class="table-responsive-lg">
            <table class="table" id = "detail-table">
                <thead>
                    <tr>
                        <th class="col-8 text-center ">Product Detail</th>
                        <th class="col-4 text-center">Action</th>          
                    </tr>
                </thead>
                <tbody id="detail-body">         
                    @foreach ($product->product_images as $productImage)
                        <tr id="detail_{{ $productImage->id }}">                        
                            <td class="text-center">
                                <img src="/product/fetch_detail/{{ $productImage->id }}" class="img" width=115 />
                            </td>                  
                            <td class="text-center"><a href="javascript:void(0)" data-id="{{ $productImage->id }}" class="btn btn-danger btn-xs delete-detail">Delete</a></td>
                        </tr> 
                    @endforeach
                </tbody>
            </table>
    </div>
@endsection

@section('scripts')    
    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({             
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        
          
           
            $('body').on('click', '.delete-detail', function () {
                var detail_id = $(this).data("id");
                if(confirm("Are You sure want to delete !" )){
                    $.ajax({
                        type: "DELETE",
                        url: "{{ url('image_detail')}}"+'/'+ detail_id + '/delete',
                        success: function (data) {
                            $("#detail_" + detail_id).remove();
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });
                }
                
            });
        });
    </script>
@endsection
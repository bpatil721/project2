<x-fronted-header></x-fronted-header>
    <div class="col-md-8">
        <div class="justify-content-between">
            <div class="">
                Products
            </div>
            <div>
                <button id="add-product"> Add Product</button>
            </div>
            <div class="col-md-8">
                <div id="product-html"></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="product-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="product-form">
                    <div class="col-md-8">
                        <input type="hidden" name="product_id" id="product_id">
                        <div class="col-md-6">
                            <label for="title">Title</label>
                            <input type="text" name="title" id="title">
                        </div>
                        <div class="col-md-6">
                            <label for="sku">Sku</label>
                            <input type="number" name="sku" id="sku">
                        </div>
                        <div class="col-md-6">
                            <label for="category">Category</label>
                            <select name="category">
                                @foreach($categories as $cat)
                                    <option value="{{$cat['id']}}" >{{ $cat['title'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="Quantity">Qty</label>
                            <div class="d-flex">
                            <button id="incr_pro" type="button">+</button>
                            <input type="number" id="qty" name="qty" class="mx-2" width="50px" value="1">
                            <button id="dec_pro" type="button">-</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" id="submit" class="btn btn-primary">Save changes</button>
            </div>
          </div>
        </div>
      </div>
    <script>
        $('#add-product').on('click',function(){
            $('#product_id').val();
            $("#product-form")[0].reset();
            $('#product-modal').modal('show');
        })
        $("#incr_pro").on('click',function(){
            let qty = $('#qty').val();
            qtyUpdate(qty,'incre');  
        })
        $("#dec_pro").on('click',function(){
            let qty = $('#qty').val();
            qtyUpdate(qty,'decre');  
        })

        function qtyUpdate(qty,type){
            if(type =='incre'){
                qty = Number(qty)+1;
                $("#qty").val(qty);
            }else{
                if(qty > 1){
                    qty = Number(qty)-1;
                    $("#qty").val(qty);
                }
            }
        }
        $("#submit").on('click', async function(){
            pid = $('#product_id').val();
            if(pid){
                url = `{{url('product-update')}}`;
            }else{
                let url =`{{route('add-product')}}`;
            }
            let Productdata = new FormData($("#product-form")[0]);
            Productdata.append('_token', $('meta[name="csrf-token"]').attr('content'));
            let data = Productdata;
            let res = await submitAjax(url,data,'POST');
            if(res.status){
                toastr.success(res.msg);
                $('#product-modal').modal('hide');
                getData();
            }else{
                toastr.error(res.msg);
            }
        })
        $(document).on('click','.edit',function(){
            id = $(this).data('id');
            let data = $(this).data('product');
            Object.keys(data).forEach(key =>{
                $("#"+key).val(data[key]);
            });
            $("#product_id").val(id);
            $('#product-modal').modal('show');

        })

    </script>
    @push('script')
    <script>
        getData();    
        async function getData(){
            url=`{{route('get-product-data')}}`;
            pdata= new FormData();
            pdata.append('_token',$('meta[name="csrf-token"]').attr('content'));
            let res = await submitAjax(url,pdata ,'POST');
            if(res){
                $("#product-html").html(res.html);
            }
        }
    </script>
    @endpush
<x-fronted-footer></x-fronted-footer>
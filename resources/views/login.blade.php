    <html>
        <head>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
            <script src="{{url('assets/js/common.js')}}"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
            <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>      
            <meta name='csrf-token' content="{{csrf_token()}}">
        </head>
        <body>
            <div class="container">
                <div class="col-md-6">
                    <form method="post" id="login-form">
                        @csrf
                        <div class="col-md-6">
                            <label for="email">Email</label>
                            <input type="text" name="email" id="email" class="form-control">
                        
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="password">Password</label>
                            <input type="text" name="password" id="password" class="form-control">
                        </div>
                        <div class="col-md-6 form-group">
                                <button type="button" id="login">Submit</button>
                        </div>
                    </form>
                </div>
            </div>        

        </body>
       <script src="https://www.google.com/recaptcha/api.js"></script>
        <script>
            $('#login').on('click',async function(){
                url = `{{url('post-login')}}`;
                data = new FormData($('#login-form')[0]);
                data.append('_token',$('meta[name="csrf-token"]').attr('content'));
                res = await submitAjax(url,data,'POST')
                if(res.status){
                    toastr.success(res.msg)
                    window.location.href =`{{route('dashboard')}}`
                }else{
                    toastr.error(res.msg)
                }
            })
        </script>
    </html>

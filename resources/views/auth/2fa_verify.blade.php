<html>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
       
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>      
        <meta name='csrf-token' content="{{csrf_token()}}">
    </head>
    <body>
    <div class="container">
        <div class="row py-5 justify-content-center">
            <div class="col-md-6">
                <div class="card p-4 bg-white">
                    <h2>Two-Factor Authentication</h2>

                <form method="POST" action="{{ route('2fa') }}">
                    @csrf
                    <div class="form-group">
                        <p>Please enter the  <strong>OTP</strong> generated on your Authenticator App. <br> Ensure you submit the current one because it refreshes every 30 seconds.</p>
                        <label for="one_time_password">Enter the 6-digit OTP from your app:</label>
                        <input type="number" name="one_time_password" class="form-control" required>
                    </div>
                    @if (count($errors) > 0)
                       @foreach ($errors->all() as $error)
                        <p class="text-danger">{{ $error }}</p>
                    @endforeach
                    @endif
                    <button class="btn btn-primary mt-3" type="submit">Verify</button>
                </form>
                </div>
            </div>
        </div>
    </div>
<script src="{{url('assets/js/common.js')}}"></script>
</body>
</html>
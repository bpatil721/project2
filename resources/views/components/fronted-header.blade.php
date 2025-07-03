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
        <aside>
        <nav>
            <div class="nav-item">
                <!-- navigation content like links goes here -->
                <div class="col-md-2" style="background-color: beige;">
                    <ul>
                        <li>
                            <a href="{{route('dashboard')}}">Dashboard</a>
                        </li>
                        <li>
                            <a href="{{route('product')}}">Product</a>
                        </li>
                        <li>
                            <a href="{{route('profile')}}">Profile</a>
                        </li>
                    </ul>
                 
                    @if (Auth::guard('user')->user()->google2fa_secret)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('2fa.disable.form') }}">Disable 2FA</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('2fa.setup') }}">Enable 2FA </a>
                        </li>
                    @endif
                </div>
                <div  class="col-md-2">
                    <button type="button" id="logout">Logout</button>
                </div>
            </div>
        
        </nav>
        </aside>
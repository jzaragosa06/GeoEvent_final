<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>Login and Registration Form | GEOEVENT</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #121213;
            padding: 30px;
        }
        .container {
            position: absolute;
            width: 100%;
            height: 100%;
            background: #fff;
            padding: 40px 30px;
            perspective: 2700px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            font-size: 50px;
            font-weight: 600;
            text-shadow: 0 4px 8px rgb(34, 34, 34);
            color: #ffffff;
        }
        .container .cover {
            position: absolute;
            top: 0;
            left: 50%;
            height: 100%;
            width: 50%;
            z-index: 98;
            transition: all 1s ease; 
            transform-origin: left;
            transform-style: preserve-3d;
        }

        .container #flip:checked ~ .cover {
            transform: rotateY(-180deg);
        }
        .container .cover .front,
        .container .cover .back {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
        }
        .cover .back {
            transform: rotateY(180deg);
            backface-visibility: hidden;
        }
        .container .cover::before,
        .container .cover::after {
            content: '';
            position: absolute;
            height: 100%;
            width: 100%;
            background: #8185b8;
            opacity: 0.5;
            z-index: 12;
        }
        .container .cover::after {
            opacity: 0.3;
            transform: rotateY(180deg);
            backface-visibility: hidden;
        }
        .container .cover img {
            position: absolute;
            height: 100%;
            width: 100%;
            object-fit: cover;
            z-index: 10;
        }
        .container .cover .text {
            position: absolute;
            z-index: 130;
            height: 100%;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .cover .text .text-1,
        .cover .text .text-2 {
            font-size: 26px;
            font-weight: 600;
            color: #fff;
            text-align: center;
        }
        .cover .text .text-2 {
            font-size: 15px;
            font-weight: 500;
        }
        .container .forms {
            height: 100%;
            width: 100%;
            padding: 20px;
            background: #fff;
        }
        .container .form-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .form-content .login-form,
        .form-content .signup-form {
            padding: 30px;
            width: calc(100% / 2 - 25px);
        }
        .forms .form-content .title {
            text-align: center;
            font-size: 30px;
            font-weight: 500;
            color: #000000;
        }
        .forms .form-content .title:before {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            height: 3px;
            width: 25px;
            background: #462ecc;
        }
        .forms .signup-form .title:before {
            width: 20px;
        }
        .forms .form-content .input-boxes {
            margin-top: 30px;
        }
        .forms .form-content .input-box {
            display: flex;
            align-items: center;
            height: 50px;
            width: 100%;
            margin: 10px 0;
            position: relative;
        }
        .form-content .input-box input {
            height: 100%;
            width: 100%;
            outline: none;
            border: none;
            padding: 0 30px;
            font-size: 16px;
            font-weight: 500;
            border-bottom: 2px solid rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }
        .form-content .input-box input:focus,
        .form-content .input-box input:valid {
            border-color: #252e29;
        }
        .form-content .input-box i {
            position: absolute;
            color: #312ecc;
            font-size: 17px;
        }
        .forms .form-content .text {
            font-size: 14px;
            font-weight: 500;
            color: #333;
        }
        .forms .form-content .text a {
            text-decoration: none;
        }
        .forms .form-content .text a:hover {
            text-decoration: underline;
        }
        .forms .form-content .button {
            color: #fff;
            margin-top: 40px;
        }
        .forms .form-content .button input {
            color: #fff;
            background: #2e31cc;
            border-radius: 6px;
            padding: 0;
            cursor: pointer;
            transition: all 0.4s ease;
        }
        .forms .form-content .button input:hover {
            background: #3f27aa;
        }
        .forms .form-content label {
            color: #ff0000;
            cursor: pointer;
        }
        .forms .form-content label:hover {
            text-decoration: underline;
        }
        .forms .form-content .login-text,
        .forms .form-content .sign-up-text {
            text-align: center;
            margin-top: 25px;
        }
        .container #flip {
            display: none;
        }
        @media (max-width: 730px) {
            .container .cover {
                display: none;
            }
            .form-content .login-form,
            .form-content .signup-form {
                width: 100%;
            }
            .form-content .signup-form {
                display: none;
            }
            .container #flip:checked ~ .forms .signup-form {
                display: block;
            }
            .container #flip:checked ~ .forms .login-form {
                display: none;
            }
        }
    </style>
</head>
<body>
    @if (session('alert'))
        <script>
            Swal.fire({
                icon: '{{ session('alert.type') }}',
                title: '{{ session('alert.title') }}',
                text: '{{ session('alert.text') }}',
            });
        </script>
    @endif
    <div class="container">
        <input type="checkbox" id="flip" {{ session('form') == 'signup' ? 'checked' : '' }}>
        <div class="cover">
            <div class="front">
                <img src="cover.jpg" alt="">
                <div class="text">
                    <div class="header">GeoEvent<i class='bx bxs-map'></i></div>
                </div>
            </div>
            <div class="back">
                {{-- <div class="text">
                    <span class="text-1">Complete miles of journey <br> with one step</span>
                    <span class="text-2">Let's get started</span>
                </div> --}}
                <div class="header">GeoEvent<i class='bx bxs-map'></i></div>
            </div>
        </div>
        <div class="forms">
            <div class="form-content">
                <div class="login-form">
                    <div class="title">Login to your account<i class='bx bxs-user'></i></div>
                    <form action="{{route('login')}}" method="POST">
                        @csrf
                        <div class="input-boxes">
                            <div class="input-box">
                                <i class="fas fa-envelope"></i>
                                <input type="text" placeholder="Enter your email" name="email" required><br>
                            </div>
                            @error('email')
                                    <div>{{$message}}</div>
                                @enderror
                            <div class="input-box">
                                <i class="fas fa-lock"></i>
                                <input type="password" placeholder="Enter your password" name="password" required>
                            </div>
                            @error('password')
                                    <div>{{$message}}</div>
                                @enderror
                            <div class="text"><a href="#">Forgot password?</a></div>
                            <div class="button input-box">
                                <input type="submit" value="Log In">
                            </div>
                            <div class="text sign-up-text">Don't have an account? <label for="flip">Sign up now</label></div>
                        </div>
                    </form>
                </div>
                <div class="signup-form">
                    <div class="title">Create your Geoevent Account<i class='bx bxs-user-plus'></i></div>
                    <form action="{{route('register')}}" method="POST">
                        @csrf
                        <div class="input-boxes">
                            <div class="input-box">
                                <i class="fas fa-user"></i>
                                <input type="text" placeholder="Enter your name" name="name" required>
                            </div>
                            @error('name')
                                    <div>{{$message}}</div>
                                @enderror
                            <div class="input-box">
                                <i class="fas fa-envelope"></i>
                                <input type="text" placeholder="Enter your email"name="email" required>
                                </div>
                            @error('email')
                                    <div>{{$message}}</div>
                                @enderror
                            <div class="input-box">
                                <i class="fas fa-lock"></i>
                                <input type="password" placeholder="Enter your password" name="password" required>
                               </div>
                             @error('password')
                                    <div>{{$message}}</div>
                                @enderror
                            <div class="button input-box">
                                <input type="submit" value="Create Account">
                            </div>
                            <div class="text sign-up-text">Already have an account? <label for="flip">Login now</label></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

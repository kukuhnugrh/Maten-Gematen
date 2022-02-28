<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mande Gematen</title>

    <!-- icon -->
    <link rel="icon" href="{{ asset('assets/img/icon.ico') }}" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('assets/font-awesome-icons-4.7.0/css/font-awesome.min.css') }}">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/gematen-login.css') }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <title>Document</title>

    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- MDI Icons -->
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">

</head>

<body>
    <div id="wrapper" class="container-fluid">
        <div id="form-wrapper" class="p-4">
            <div id="login-header" class="h-25 d-flex flex-column justify-content-center align-items-center"> 
                <div class="d-flex justify-content-center align-items-center mb-3">
                    <img src="{{ asset('assets/img/icon.ico') }}" class="rounded-circle">
                    <p class="gradient-text text-center w-100">Mande Gematen</p>
                </div>
            </div>
            @error('error')
            <div class="text-danger text-center fs-6">{{ $message }}</div>
            @enderror
            <div id="login-form" class="h-75 d-flex flex-column justify-content-center align-items-center">
                <form class="w-100 mb-5" action="{{route('login.post')}}" method="post">
                    @csrf
                    <div class="mb-3 w-100">
                        <label for="inputEmail" class="form-label fw-bold fs-6">Email</label>
                        <input type=" email" class="form-control shadow-none @error('email') is-invalid @enderror" id="inputEmail" aria-describedby="emailHelp" placeholder="nama@email.com" name="email">
                        @error('email')
                        <div class="text-danger fs-6">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-5">
                        <label for="inputPassword" class="form-label fw-bold fs-6">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control shadow-none @error('password') is-invalid @enderror" id="inputPassword" name="password">
                            <span class="input-group-text" id="showPasswordToogle"><i id="tooggle-icon" class="fa fa-eye-slash" aria-hidden="true"></i></span>
                        </div>
                        @error('password')
                        <div class="text-danger fs-6">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-100" style="background-color: #DC413E; border-color: #DC413E;">Login</button>
                </form>
                <div class="mb-3" style="color: #7f8c8d;">
                    atau
                </div>
                <a id="login-with-google" href="{{ route('auth/google') }}">
                    <div class="d-flex justify-content-center align-items-center">
                        <img src="{{ asset('assets/img/google_icon.png') }}" class="rounded-circle">
                        <p class="text-center">Masuk Dengan Google</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <!-- Validation -->
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/additional-methods.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#inputEmail').on('input', function() {
                console.log('coba');
                $(this).validate();
                $(this).valid();
                $('#inputEmail-error').addClass('text-danger fs-6');
            });
            $('#showPasswordToogle').on('click', function() {
                $('#tooggle-icon').toggleClass("fa-eye fa-eye-slash");
                var inputType = $('#inputPassword').attr('type');
                if (inputType == 'password') {
                    $('#inputPassword').attr('type', 'text');
                } else {
                    $('#inputPassword').attr('type', 'password');
                }
            });
            jQuery.extend(jQuery.validator.messages, {
                required: "This field is required.",
                remote: "Please fix this field.",
                email: "format email anda salah ",
                url: "Please enter a valid URL.",
                date: "Please enter a valid date.",
                dateISO: "Please enter a valid date (ISO).",
                number: "Please enter a valid number.",
                digits: "Please enter only digits.",
                creditcard: "Please enter a valid credit card number.",
                equalTo: "Please enter the same value again.",
                accept: "Please enter a value with a valid extension.",
                maxlength: jQuery.validator.format("Please enter no more than {0} characters."),
                minlength: jQuery.validator.format("Please enter at least {0} characters."),
                rangelength: jQuery.validator.format("Please enter a value between {0} and {1} characters long."),
                range: jQuery.validator.format("Please enter a value between {0} and {1}."),
                max: jQuery.validator.format("Please enter a value less than or equal to {0}."),
                min: jQuery.validator.format("Please enter a value greater than or equal to {0}.")
            });
        });
    </script>

    <!-- Boostrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>

</html>
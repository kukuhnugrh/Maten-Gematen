<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Login Admin</title>

    <!-- icon -->
    <link rel="icon" href="{{ asset('assets/img/icon.ico') }}" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/gematen-login.css') }}?v=<?php echo time(); ?>">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- MDI Icons -->
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">

</head>

<body>
    <div id="wrapper" class="container-fluid">
        <div id="form-wrapper" class="p-4">
            <div id="login-header" class="d-flex flex-column justify-content-center align-items-center"> 
                <div class="d-flex justify-content-center align-items-center w-100 px-5">
                    <img src="{{ asset('assets/img/icon.ico') }}" class="rounded-circle">
                    <div class="flex-grow-1">
                        <p class="gradient-text text-center w-100">Mande Gematen</p>
                    </div>
                </div>
            </div>
            @error('error')
            <div class="alert alert-danger alert-dismissible fade show mt-2 mb-0" role="alert">
                <i class="fa-solid fa-triangle-exclamation mx-2"></i> {{ $message }}
                <button type="button" data-bs-dismiss="alert" aria-label="Close"><i class="fa-solid fa-triangle-exclamation mx-2"></i></button>
            </div>
            @enderror
            <div id="login-form" class="d-flex flex-column justify-content-center align-items-center">
                <form class="w-100 mb-3" action="{{ route('loginadmin.post', ['role'=>'admin']) }}" method="post">
                    @csrf
                    <div class="mb-3 w-100">
                        <label for="email" class="form-label fw-bold">Email</label>
                        <input type="email" class="form-control shadow-none @error('email') is-invalid @enderror" id="email" placeholder="nama@email.com" name="email" autocomplete="email" required>
                        @error('email')
                        <div class="text-danger fs-6">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-5">
                        <label for="password" class="form-label fw-bold">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control shadow-none @error('password') is-invalid @enderror" id="password" name="password" autocomplete="password" required>
                            <span class="input-group-text" id="showPasswordToogle"><i id="tooggle-icon" class="fa fa-eye-slash" aria-hidden="true"></i></span>
                        </div>
                        @error('password')
                        <div class="text-danger fs-6">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="h-25 d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary">Masuk</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Validation -->
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/additional-methods.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#email').on('input', function() {
                console.log('coba');
                $(this).validate();
                $(this).valid();
                $('#email-error').addClass('text-danger fs-6');
            });
            $('#showPasswordToogle').on('click', function() {
                $('#tooggle-icon').toggleClass("fa-eye fa-eye-slash");
                var inputType = $('#password').attr('type');
                if (inputType == 'password') {
                    $('#password').attr('type', 'text');
                } else {
                    $('#password').attr('type', 'password');
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
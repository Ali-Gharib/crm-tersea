@extends('layouts.app')

@section('title', 'Login')

@section('content')
<form id="login-form">
    <input type="email" name="email" placeholder="Email">
    <input type="password" name="password" placeholder="Password">
    <button type="button" id="login-button">Login</button>
</form>
<div id="login-message"></div>
@endsection

@section("scriptbtn")
<script>
    $(document).ready(function() {
        $('#login-button').click(function() {
            var formData = $('#login-form').serialize();

            $.ajax({
                url: '/api/login', // Your API endpoint
                type: 'POST',
                data: formData,
                success: function(response) {
                    // Handle successful login
                    localStorage.setItem('token', response.token);

                    $('#login-message').text('Login successful!');
                    // Redirect or do other actions as needed
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    var errorMessage = xhr.responseJSON.message;
                    $('#login-message').text('Error: ' + errorMessage);
                }
            });
        });
    });

    </script>
@endsection



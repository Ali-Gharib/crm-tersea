@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="container">
    <h1>Add Employee</h1>
    <form id="add-employee-form">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" required>
        </div>
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <div id="add-employee-message"></div>
</div>
@endsection

@section("scriptbtn")



<script>
    $(document).ready(function() {




        $('#add-employee-form').submit(function(e) {

  // Retrieve token from localStorage
  var token = localStorage.getItem('token');

// Check if token exists
if (!token) {
    console.error('Token not found in localStorage');
    return;
}


            e.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                url: '/api/employee',
                type: 'POST',
                headers: {
            'Authorization': 'Bearer ' + token // Include token in Authorization header
        },
                data: formData,
                success: function(response) {
                    $('#add-employee-message').html('<div class="alert alert-success" role="alert">Employee added successfully!</div>');
                    // Clear form fields after successful submission
                    $('#add-employee-form')[0].reset();
                },
                error: function(xhr, status, error) {
                    var errorMessage = xhr.responseJSON.message || 'Error adding employee';
                    $('#add-employee-message').html('<div class="alert alert-danger" role="alert">' + errorMessage + '</div>');
                }
            });
        });
    });
</script>

@endsection



@extends('layouts.app')

@section('title', 'Login')

@section('content')
<h1>Employee List</h1>
<table class="table table-striped">

       <a href="{{ route("employee.create") }}"  class="btn btn-primary"> create employé</a>


    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody id="employee-list"></tbody>
</table>




@endsection

@section("scriptbtn")
<script>
    $(document).ready(function() {


        function fetchEmployees() {
    // Retrieve token from localStorage
    var token = localStorage.getItem('token');

    // Check if token exists
    if (!token) {
        console.error('Token not found in localStorage');
        return;
    }

    // Make AJAX request with token in headers
    $.ajax({
        url: '/api/employee',
        type: 'GET',
        dataType: 'json',
        headers: {
            'Authorization': 'Bearer ' + token // Include token in Authorization header
        },
        success: function(response) {
            console.log("response" , response)
            // Clear existing list items
            $('#employee-list').empty();
            // Iterate over the employee array and append list items
            $.each(response?.users, function(index, employee) {
                $('#employee-list').append('<tr><td>' + employee.name + '</td><td>' + employee.email + '</td></tr>');
            });
        },
        error: function(xhr, status, error) {
            console.error('Error fetching employees:', error);
            $('#employee-list').append('<tr><td colspan="2">Error fetching employees</td></tr>');
        }
    });
}

// Fetch employees when the page loads
fetchEmployees();



        });
    </script>
@endsection



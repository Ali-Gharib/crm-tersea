@extends('layouts.app')

@section('title', 'Login')

@section('content')



    <div class="container">
        <h1>Company List</h1>
        <a href="{{ route('societe.create') }}" class="btn btn-primary"> create Societe</a>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Created At</th>
                    <th>Action</th>

                </tr>
            </thead>
            <tbody id="company-list"></tbody>
        </table>
    </div>








    <!-- Attach User Modal -->
    <div class="modal fade" id="attachUserModal" tabindex="-1" role="dialog" aria-labelledby="attachUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="attachUserModalLabel">Attach User to Company</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form to attach user to company -->
                    <form id="attach-user-form">
                        <input type="hidden" id="societe_id" name="societe_id"> <!-- Hidden input field for company id -->
                        <div class="form-group">
                            <label for="user_id">Select User:</label>
                            <select class="form-control" id="user_id" name="user_id">
                                <!-- Options will be populated dynamically using JavaScript -->
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Attach User</button>
                    </form>
                    <div id="attach-user-message"></div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scriptbtn')
    <script>
        var token;
        $(document).ready(function() {



            // Retrieve token from localStorage
            token = localStorage.getItem('token');

            // Check if token exists
            if (!token) {
                console.error('Token not found in localStorage');
                return;
            }


            fetchCompanies();
















            // Function to handle attaching user to company
            $('#attach-user-form').submit(function(e) {
                e.preventDefault();
                var token = localStorage.getItem('token');
                var formData = $(this).serialize();

                $.ajax({
                    url: '/api/societé/invitation',
                    type: 'POST',
                    data: formData,
                    headers: {
                        'Authorization': 'Bearer ' + token
                    },
                    success: function(response) {
                        $('#attach-user-message').html(
                            '<div class="alert alert-success" role="alert">User attached to company successfully!</div>'
                        );
                        $('#attach-user-form')[0].reset();
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = xhr.responseJSON.message ||
                            'Error attaching user to company';
                        $('#attach-user-message').html(
                            '<div class="alert alert-danger" role="alert">' + errorMessage +
                            '</div>');
                    }
                });
            });







        });


        function fetchCompanies() {


            $.ajax({
                url: '/api/societé',
                type: 'GET',
                dataType: 'json',
                headers: {
                    'Authorization': 'Bearer ' + token // Include token in Authorization header
                },
                success: function(response) {
                    $('#company-list').empty();
                    $.each(response?.Societé, function(index, company) {
                        // Format the date
                        var createdAt = new Date(company.created_at);
                        var formattedDate = createdAt.toDateString();

                        // Append rows to the table body
                        var row = '<tr>';
                        row += '<td>' + company.name + '</td>';
                        row += '<td>' + formattedDate + '</td>';
                        row += '<td>';
                        row +=
                            '<button type="button" class="btn btn-primary btn-sm mr-2" onclick="editCompany(' +
                            company.id + ')">Edit</button>';
                        row +=
                            '<button type="button" class="btn btn-danger btn-sm" onclick="deleteCompany(' +
                            company.id + ')">Delete</button>';
                        row +=
                            '<button type="button" class="btn btn-success btn-sm ml-2" onclick="attachUser(' +
                            company.id +
                            ')" data-toggle="modal" data-target="#attachUserModal">Attach User</button>';

                        row += '</td>';
                        row += '</tr>';
                        $('#company-list').append(row);
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching companies:', error);
                    $('#company-list').append(
                        '<tr><td colspan="2">Error fetching companies</td></tr>');
                }
            });
        }



        function editCompany(id) {
            // Implement your edit logic here
            // Construct the edit URL with the company ID
            var editUrl = '/societe/edit/' + id;

            // Redirect the user to the edit URL
            window.location.href = editUrl;
        }

        function deleteCompany(id) {
            // Implement your delete logic here
            if (confirm('Are you sure you want to delete this company?')) {
                $.ajax({
                    url: '/api/societé/' + id,
                    type: 'DELETE',
                    headers: {
                        'Authorization': 'Bearer ' + token // Include token in Authorization header
                    },
                    success: function(response) {
                        alert('Company deleted successfully');
                        // Reload the company list after deletion
                        fetchCompanies();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error deleting company:', error);
                        alert('Error deleting company');
                    }
                });
            }
        }

        function attachUser(companyId) {
            $('#societe_id').val(companyId); // Set company id in hidden input field

            // AJAX request to fetch list of employees
            $.ajax({
                url: '/api/employee', // Adjust the URL as per your route
                type: 'GET',
                dataType: 'json',
                headers: {
                    'Authorization': 'Bearer ' + token // Include token in Authorization header
                },
                success: function(response) {
                    // Clear existing options in the select dropdown
                    $('#user_id').empty();

                    // Add an empty option for default selection
                    $('#user_id').append($('<option>', {
                        value: '',
                        text: 'Select User...'
                    }));

                    // Iterate over the list of employees and add them as options
                    $.each(response.users, function(index, employee) {
                        $('#user_id').append($('<option>', {
                            value: employee.id,
                            text: employee
                                .name // Assuming employee object has 'id' and 'name' properties
                        }));
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching employees:', error);
                    // Optionally, display an error message or handle the error
                }
            });
        }
    </script>
@endsection

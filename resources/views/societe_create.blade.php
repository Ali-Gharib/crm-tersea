@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="container">
        <h1>Add Company</h1>
        <form id="add-company-form">
            <div class="form-group">
                <label for="name">Name </label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter company name"
                    value="{{ $societe->name ?? '' }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <div id="add-company-message"></div>
    </div>
@endsection

@section('scriptbtn')

    <script>
        $(document).ready(function() {
            $('#add-company-form').submit(function(e) {
                e.preventDefault();
                // Retrieve token from localStorage
                var token = localStorage.getItem('token');

                // Check if token exists
                if (!token) {
                    console.error('Token not found in localStorage');
                    return;
                }

                var formData = $(this).serialize();
                var urlApi =
                    '{{ empty($societe) ? '/api/societé' : '/api/societé/' . $societe->id }}'; // Corrected URL with quotes
                var methodApi = '{{ empty($societe) ? 'POST' : 'PUT' }}'; // Corrected method with quotes
                $.ajax({
                    url: urlApi,
                    type: methodApi,
                    data: formData,
                    headers: {
                        'Authorization': 'Bearer ' + token // Include token in Authorization header
                    },
                    success: function(response) {
                        var message =
                            '{{ empty($societe) ? 'Company added successfully!' : 'Company update successfully!' }}'
                        $('#add-company-message').html(
                            '<div class="alert alert-success" role="alert">' + message +
                            '</div>'
                        );
                        // Clear form fields after successful submission

                        @if (empty($societe))
                            $('#add-company-form')[0].reset();
                        @endif
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = xhr.responseJSON.message || 'Error adding company';
                        $('#add-company-message').html(
                            '<div class="alert alert-danger" role="alert">' + errorMessage +
                            '</div>');
                    }
                });
            });
        });
    </script>

@endsection

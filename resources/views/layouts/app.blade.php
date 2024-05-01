<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">


    <!-- Include your CSS files here -->
</head>

<body>
    <!-- Header section -->
    <header>
        <nav>
            <!-- Your navigation links -->
        </nav>
    </header>

    <!-- Main content section -->
    <main>
        <div id="app">
            @yield('content')

        </div>
    </main>

    <!-- Footer section -->
    <footer>
        <!-- Your footer content -->
    </footer>

    <!-- Include your JavaScript files here -->
</body>

</html>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>




@yield('scriptbtn')

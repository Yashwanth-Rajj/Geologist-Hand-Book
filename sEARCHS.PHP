<?php 
include 'Connection.php'; 
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Geologist Handbook</title>
    <!-- Required Bootstrap and JS dependencies -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl5+5hb7MrFnrE9hg8BaS+V8N/VRBUzz2aL+4W1AlC" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybN4I4ogKecpFsKwz1E9G8zCh3zl7Sk2HAkNfElQe5R1zFdo9" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2LcEZG5lzMHks5q9mNuk6Zz9eYGmGZ9gS5f14fuTs" crossorigin="anonymous"></script>

    <style>
    /* Default table styles */
    #results-table {
        font-family: Georgia, serif;
    }

    .search-input {
        font-family: Georgia, serif;
    }

    .highlight {
        background-color: yellow;
        font-weight: bold;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    th {
        background-color: #343a40;
        color: white;
        text-align: left;
    }

    td {
        border: 1px solid #ddd;
    }

    /* Justify text in the "Explanation" column */
    td[data-label="Explanation"] {
        text-align: justify;
    }

    /* Mobile-specific styles */
    @media (max-width: 768px) {
        #results-table {
            display: block;
        }

        #results-table thead {
            display: none;
        }

        #results-table tbody tr {
            display: block;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        #results-table tbody tr td {
            display: block;
            padding: 5px 10px;
            border: none;
        }

        #results-table tbody tr td[data-label="Title"] {
            font-weight: bold;
            font-size: 1.1em;
            margin-bottom: 5px;
        }

        #results-table tbody tr td[data-label="Explanation"] {
            margin-top: 10px;
            text-align: justify;
        }
    }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="searchs.php">Geologist Handbook</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
    </div>
</nav>
    <!-- Main Content -->
    <div class="container my-4">
        <h1 class="text-center mb-3">Search Geology Rules</h1>
        
        <!-- Search Form -->
        <div class="d-flex justify-content-center mb-3">
            <input type="text" id="search" class="form-control search-input" placeholder="Type to search...">
        </div>

        <!-- Table Section -->
        <div class="table-responsive">
            <table id="results-table" class="table table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">View</th>
                        <th scope="col">Act</th>
                        <th scope="col">Chapter No</th>
                        <th scope="col">Chapter Name</th>
                        <th scope="col">Section</th>
                        <th scope="col">Title</th>
                        <th scope="col">Explanation</th>
                    </tr>
                </thead>
                <tbody id="results-body">
                    <!-- Data will be dynamically injected here -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#search').on('keyup', function() {
                let query = $(this).val();

                // Send AJAX request
                $.ajax({
                    url: 'search.php',
                    method: 'POST',
                    data: { search: query },
                    success: function(response) {
                        $('#results-body').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error: " + error);
                        $('#results-body').html('<tr><td colspan="8" class="text-center text-danger">An error occurred. Please try again later.</td></tr>');
                    }
                });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"
            integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuuRv3W5HzQHc7Sjq/Jzj69j/n8uQe7BScO3nm9"
            crossorigin="anonymous"></script>
    
    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-2">
        <p class="mb-0">&copy; 2024 Geologist Handbook. All Rights Reserved.</p>
    </footer>
</body>

</html>

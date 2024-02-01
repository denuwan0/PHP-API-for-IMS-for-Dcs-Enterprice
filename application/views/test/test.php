<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Unit Test</title>
    <!-- Include Bootstrap CSS from CDN -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Unit Test</h1>
        <div class="alert alert-primary" role="alert">
            <?php echo $this->unit->report(); ?>
        </div>
        <!-- Your unit test content goes here -->
    </div>

    <!-- Include Bootstrap JS and jQuery from CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

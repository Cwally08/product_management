<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Product Management</a>
        
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="add_product_form.php">Add Product</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="dashboard.php">Product Management Dashboard</a>
                </li>
            </ul>
        </div>
        
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>
    <div class="container-fluid">
    <div class="row justify-content-center">
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="container mt-4">
                <h2 class="text-center">Add Product</h2>
                <div class="d-flex justify-content-center">
                    <form id="product-form" method="POST" enctype="multipart/form-data" class="w-50">
                       <div class="form-group">
                            <label for="name">Product Name:</label>
                            <input type="text" class="form-control" id="name" name="name" pattern="[A-Za-z0-9\s]+" required>
                        </div>
                        <div class="form-group">
                            <label for="unit">Unit:</label>
                            <input type="text" class="form-control" id="unit" name="unit" pattern="[A-Za-z0-9\s]+" required>
                        </div>
                        <div class="form-group">
                            <label for="price">Price:</label>
                            <input type="number" class="form-control" id="price" name="price" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="expiry">Date of Expiry:</label>
                            <input type="date" class="form-control" id="expiry" name="expiry" required>
                        </div>
                        <div class="form-group">
                            <label for="inventory">Available Inventory:</label>
                            <input type="number" class="form-control" id="inventory" name="inventory" step="1" required>
                        </div>
                        <div class="form-group">
                            <label for="image">Product Image:</label>
                            <input type="file" class="form-control-file" id="image" name="image" accept="image/*" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Product</button>
                      </form>
                </div>
            </div>
        </main>
    </div>
</div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="add_product.js"></script>
</body>
</html>

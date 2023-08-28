$(document).ready(function() {

    // delete
    function deleteProduct(productId) {
        $.ajax({
            type: "POST",
            url: "delete_product.php", 
            data: { id: productId },
            success: function(response) {
                console.log("Product deleted successfully:", response);
                fetchProducts();
            },
            error: function(xhr, status, error) {
                console.error("AJAX request error:", error);
            }
        });
    }

    $(document).on("click", ".delete-product", function() {
        var productId = $(this).data("product-id");

        $("#deleteModal").modal("show");
        $("#confirmDelete").on("click", function() {
            deleteProduct(productId);
            $("#deleteModal").modal("hide");
        });
    });

    // display products
    function displayProducts(products) {
        var productsContainer = $("#products-container");
        productsContainer.empty();

        if (products.length === 0) {
            productsContainer.append("<p>No products found</p>");
            return;
        }

        var totalInventoryCost = 0;
        var tableHtml = `
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Image</th>
                        <th scope="col">Name</th>
                        <th scope="col">Unit</th>
                        <th scope="col">Price</th>
                        <th scope="col">Expiry Date</th>
                        <th scope="col">Available Inventory</th>
                        <th scope="col">Available Inventory Cost</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
        `;

        products.forEach(function(product) {
            var productRow = `
                <tr>
                    <td><img src="${product.image_path}" alt="Product Image" width="100" height="100"></td>
                    <td>${product.name}</td>
                    <td>${product.unit}</td>
                    <td>₱${product.price}</td>
                    <td>${product.expiry_date}</td>
                    <td>${product.inventory}</td>
                    <td>₱${(product.price * product.inventory).toFixed(2)}</td>
                    <td>
                        <button class="btn btn-primary edit-product" data-product-id="${product.id}">Edit</button>
                        <button class="btn btn-danger delete-product" data-product-id="${product.id}">Delete</button>
                    </td>
                </tr>
            `;

            totalInventoryCost += product.price * product.inventory;
            tableHtml += productRow;
        });

        tableHtml += `
                </tbody>
            </table>
            <div class="total-inventory-cost mt-3">
                <p>Total Inventory Cost: ₱${totalInventoryCost.toFixed(2)}</p>
            </div>
        `;
        productsContainer.append(tableHtml);
    }
         
    // fetch products
    function fetchProducts() {
        $.ajax({
            type: "GET",
            url: "fetch_products.php",
            success: function(response) {
                console.log("Fetched products:", response);
                displayProducts(response);
            },
            error: function(xhr, status, error) {
                console.error("AJAX request error:", error);
            }
        });
    }

    // edit modal and fetch product details
    function openEditModal(productId) {
            $.ajax({
                type: "GET",
                url: "get_product_details.php",
                data: { id: productId },
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        console.log("Product details fetched:", response.product);
                        populateEditModal(response.product);
                        $("#editModal").modal("show");
                    } else {
                        console.error("Product details fetch failed:", response.error);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX request error:", error);
                }
            });
        }


    function populateEditModal(product) {
    var modalContent = `
        <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel">Edit Product</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="editForm">
                <input type="hidden" name="id" value="${product.id}">
                <label for="name">Name:</label>
                <input type="text" name="name" value="${product.name || ''}" required><br>
                <label for="unit">Unit:</label>
                <input type="text" name="unit" value="${product.unit || ''}" required><br>
                <label for="price">Price:</label>
                <input type="number" name="price" value="${product.price || ''}" required><br>
                <label for="expiry_date">Expiry Date:</label>
                <input type="date" name="expiry_date" value="${product.expiry_date ? formatDate(product.expiry_date) : ''}" required><br>
                <label for="inventory">Inventory:</label>
                <input type="number" name="inventory" value="${product.inventory || ''}" required><br>
            </form>
        </div>
        <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary save-changes">Save Changes</button>
        </div>
    `;

        $("#editModal .modal-content").html(modalContent);
        $(".save-changes").off("click");
        $(".save-changes").on("click", function() {
            var formData = $("#editForm").serialize();
            updateProduct(formData);
        });
    }


    function formatDate(date) {
        var formattedDate = new Date(date);
        var year = formattedDate.getFullYear();
        var month = String(formattedDate.getMonth() + 1).padStart(2, '0');
        var day = String(formattedDate.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }
        $("#saveChanges").on("click", function() {
        var formData = $("#editForm").serialize();
        formData = formData.replace(/expiry_date=[\d/]+/, `expiry_date=${formatDateToDatabase($('#expiry_date').val())}`);
        updateProduct(formData);
    });

    // update product data
    function updateProduct(formData) {
    $.ajax({
        type: "POST",
        url: "update_product.php",
        data: formData,
        success: function(response) {
            console.log("Product updated successfully:", response);
            if (response.success) {
                fetchProducts(); 
                $("#editModal").modal("hide"); 
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX request error:", error);
            }
        });
    }

    $(document).on("click", ".edit-product", function() {
        var productId = $(this).data("product-id");
        openEditModal(productId);
    });

    fetchProducts();
});
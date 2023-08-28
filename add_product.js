$(document).ready(function() {
    $("#product-form").submit(function(event) {
        event.preventDefault(); 
        
        var formData = new FormData(this);

        console.log("Submitting form..."); 

        $.ajax({
            type: "POST",
            url: "add_product.php",
            data: formData,
            contentType: false,
            processData: false,
            timeout: 15000, 
            success: function(response) {
                console.log("Response:", response); 
                try {
                    response = JSON.parse(response);
                    
                    if (response.status === "success") {
                        console.log(response.message);
                        alert("Product added successfully!");
                        $("#product-form")[0].reset();
                    } else {
                        console.error(response.message);
                        alert("Error: " + response.message);
                    }
                } catch (error) {
                    console.error("Error parsing JSON response:", error);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX request error:", error);
            }
        });
    });
});

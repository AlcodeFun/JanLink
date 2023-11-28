
var products = [];
$(document).ready(function () {
    // Load products on page load
    loadProducts();
  
    // Function to load products using AJAX
    function loadProducts() {
      $.ajax({
        url: 'server-pedagang.php',
        type: 'GET',
        success: function (response) {
          var products = JSON.parse(response);
          var tableBody = $('#productTableBody');
          tableBody.empty();
  
          // Loop through products and append to table
          products.forEach(function (product) {
            var row = '<tr>';
            row += '<td>' + product.ID_Product + '</td>';
            row += '<td>' + product.nama_produk + '</td>';
            row += '<td>' + product.deskripsi + '</td>';
            row += '<td>' + product.harga + '</td>';
            row += '<td>' + product.ID_Pedagang + '</td>';
            row += '<td>' + product.thum_produk + '</td>';
            row += '<td><button class="btn btn-sm btn-primary" onclick="editProduct(' + product.ID_Product + ')">Edit</button> ';
            row += '<button class="btn btn-sm btn-danger" onclick="deleteProduct(' + product.ID_Product + ')">Delete</button></td>';
            row += '</tr>';
  
            tableBody.append(row);
          });
        },
        error: function (error) {
          console.log(error);
        }
      });
    }
  
    // Function to open Add/Edit Product modal
    function openProductModal(title, productData = null) {
      $.ajax({
        url: 'modal-pedagang-crud.php',
        type: 'POST',
        data: { title: title, productData: productData },
        success: function (response) {
          $('#productModal').html(response);
          $('#productModal').modal('show');
        },
        error: function (error) {
          console.log(error);
        }
      });
    }
  
    // Function to handle Add Product button click
    $('#addProductBtn').click(function () {
      openProductModal('Add Product');
    });
  
    // Function to handle Edit Product button click
    window.editProduct = function (productID) {
      var product = null;
  
      // Find the product with the given ID
      products.forEach(function (p) {
        if (p.ID_Product === productID) {
          product = p;
          return;
        }
      });
  
      if (product !== null) {
        openProductModal('Edit Product', product);
      }
    };
  
    // Function to handle Delete Product button click
    window.deleteProduct = function (productID) {
      var confirmation = confirm('Are you sure you want to delete this product?');
  
      if (confirmation) {
        // Implement AJAX call to delete the product
        $.ajax({
          url: 'server-pedagang.php',
          type: 'DELETE',
          data: JSON.stringify({ ID_Product: productID }),
          contentType: 'application/json',
          success: function (response) {
            alert(response.message);
            loadProducts(); // Reload the table after deletion
          },
          error: function (error) {
            console.log(error);
          }
        });
      }
    };
  
    // Implement other CRUD operations as needed
  });
  
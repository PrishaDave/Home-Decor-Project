<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ page import="java.util.List, java.util.ArrayList" %>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home Decor</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <header>
        <h1>Home Decor</h1>
        <p>Enhance your living space with our curated collection</p>
    </header>

    <section class="dashboard">
        <% 
            // Initialize session attributes if not set
            List<String> products = (List<String>) session.getAttribute("products");
            List<String> soldOutProducts = (List<String>) session.getAttribute("soldOutProducts");

            if (products == null) {
                products = new ArrayList<>();
                session.setAttribute("products", products);
            }
            if (soldOutProducts == null) {
                soldOutProducts = new ArrayList<>();
                session.setAttribute("soldOutProducts", soldOutProducts);
            }

            // Handle form submission for adding a new product
            String newProduct = request.getParameter("newProduct");
            if (newProduct != null && !newProduct.trim().isEmpty()) {
                products.add(newProduct.trim());
            }

            // Handle marking product as sold out
            String soldOutProduct = request.getParameter("soldOutProduct");
            if (soldOutProduct != null && products.contains(soldOutProduct)) {
                products.remove(soldOutProduct);
                soldOutProducts.add(soldOutProduct);
            }
        %>

        <!-- Display Product Stats -->
        <div class="product-info">
            <h2>Product Overview</h2>
            <p>Total Products: <%= products.size() + soldOutProducts.size() %></p>
            <p>Available Products: <%= products.size() %></p>
            <p>Sold Out Products: <%= soldOutProducts.size() %></p>
        </div>

        <!-- Available Products List -->
        <div class="product-list">
            <h3>Available Products</h3>
            <ul>
                <% for (String product : products) { %>
                    <li>
                        <form action="homeDecor.jsp" method="post" style="display:inline;">
                            <input type="hidden" name="soldOutProduct" value="<%= product %>">
                            <button type="submit">Mark as Sold Out</button>
                        </form>
                        <%= product %>
                    </li>
                <% } %>
            </ul>
        </div>

        <!-- Sold Out Products List -->
        <div class="sold-out-list">
            <h3>Sold Out Products</h3>
            <ul>
                <% for (String product : soldOutProducts) { %>
                    <li><%= product %></li>
                <% } %>
            </ul>
        </div>

        <!-- Add New Product Form -->
        <div class="product-form">
            <h3>Add a New Product</h3>
            <form action="homeDecor.jsp" method="post">
                <label for="newProduct">Product Name:</label>
                <input type="text" id="newProduct" name="newProduct" required>
                <button type="submit">Add Product</button>
            </form>
        </div>
    </section>

    <footer>
        <p>&copy; 2024 Home Decor. All rights reserved.</p>
    </footer>
</body>
</html>

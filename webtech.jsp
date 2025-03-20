<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home Decor Heaven</title>
    <link rel="stylesheet" type="text/css" href="styles.css"> <!-- Link to external CSS -->
</head>
<body>
    <header>
        <div class="logo">
            <h1>Home Decor Heaven</h1>
            <p>Your Space, Styled Perfectly</p>
        </div>
        <nav>
            <ul>
                <li><a href="home.jsp">Home</a></li>
                <li><a href="shop.jsp">Shop</a></li>
                <li><a href="about.jsp">About Us</a></li>
                <li><a href="contact.jsp">Contact</a></li>
            </ul>
        </nav>
    </header>

    <section class="banner">
        <h2>Transform Your Home with Our Unique Decor</h2>
        <p>Explore our curated collection of stylish and affordable decor items.</p>
        <a href="shop.jsp" class="btn">Shop Now</a>
    </section>

    <section class="featured-products">
        <h3>Featured Products</h3>
        <div class="product-grid">
            <jsp:useBean id="productBean" class="com.home.decor.ProductBean" />
            <c:forEach var="product" items="${productBean.featuredProducts}">
                <div class="product">
                    <img src="${product.image}" alt="${product.name}" />
                    <h4>${product.name}</h4>
                    <p>${product.description}</p>
                    <p class="price">$${product.price}</p>
                    <a href="product.jsp?id=${product.id}" class="btn">View Details</a>
                </div>
            </c:forEach>
        </div>
    </section>

    <footer>
        <p>&copy; 2024 Home Decor Heaven. All rights reserved.</p>
        <ul class="socials">
            <li><a href="#">Facebook</a></li>
            <li><a href="#">Instagram</a></li>
            <li><a href="#">Pinterest</a></li>
            <li><a href="#">Twitter</a></li>
        </ul>
    </footer>
</body>
</html>

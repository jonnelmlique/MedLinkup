.hero-section {
position: relative;
height: 40vh;
width: 155vh;
display: flex;
justify-content: center;
align-items: center;
color: white;
text-align: center;
padding: 0 20px;
margin-top: 56px;
margin-left: auto;
margin-right: auto;
}
.hero-section::before {
content: "";
position: absolute;
top: 0;
left: 0;
width: 100%;
height: 100%;
background-image: url("hero.jpg");
background-size: cover;
background-position: center;
opacity: 0.6;
z-index: -1;
}

.hero-section h1 {
font-size: 2rem;
margin-bottom: 20px;
font-weight: bold;
}

.hero-section p {
font-size: 1.2rem;
margin-bottom: 40px;
}

.product-section {
padding: 50px 0;
background-color: #ffffff;
}

.product-card {
border: 1px solid #dee2e6;
border-radius: 8px;
margin-bottom: 20px;
box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
width: 210px;
margin-right: 18px;
}

.product-card img {
width: 100%;
border-radius: 8px 8px 0 0;
}

.product-card-body {
padding: 15px;
}

.product-card-title {
font-weight: bold;
margin-bottom: 5px;
font-size: 16px;
}

.product-card-title {
color: #212529;
}

.product-card:hover {
transform: scale(1);
transition: transform 0.2s ease-in-out;
border-color: #1c9601;
}

.product-card-price {
color: #5ab347;
font-weight: bold;
margin-bottom: 5px;
}

.btn {
padding: 5px 10px;
font-size: 14px;
margin-top: 170px;
}

.card-product:hover {
transform: scale(1);
transition: transform 0.2s ease-in-out;
border-color: #1c9601;
}

.category-section {
margin-top: 50px;
}

#categoryCarousel {
margin-top: 30px;
}

.btn.btn-primary {
background-color: #4caf50;
border-color: #4caf50;
}
.btn.btn-primary:hover {
background-color: #1c9601;
border-color: #1c9601;
}

.text-truncate {
color: #5ab347;
}
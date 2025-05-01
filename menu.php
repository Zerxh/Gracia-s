<?php
session_start(); 
$isLoggedIn = isset($_SESSION['email']);
$isLoggedIn = isset($_SESSION['fullName']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - Gracia's Restaurant</title>
    <link rel="stylesheet" href="menu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header class="navbar">
        <div class="logo">
            <img src="img/logo.jpg" alt="Gracia's Logo">
            <p>GRACIA'S</p>
        </div>

        <nav>
            <ul>
                <li class="lia"><a href="homepage.php">Home</a></li>
                <li class="lia"><a href="menu.php">Menu</a></li>
                <li class="lia"><a href="#about">About Us</a></li>
                <?php if($isLoggedIn): ?>
                    <li id="logout"><a href="login.php?logout=true">Log Out</a></li>
                    <li id="user-welcome" style="color:white; padding:10px;">
                        Welcome, <?php echo htmlspecialchars($_SESSION['fullName']); ?>
                    </li>
                <?php else: ?>
                    <li id="login"><a href="login.php">Log In</a></li>
                    <li id="signup"><a href="User_Reg.php">Sign Up</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <!-- Sidebar Navigation -->
    <div class="menu-container">
        <div class="sidebar">     
            <div class="menu-categories">
                <div class="menu-category active" data-section="rice">
                    <i class="fas fa-utensils"></i>
                    <span>RICE MEALS</span>
                </div>
                <div class="menu-category" data-section="silog">
                    <i class="fas fa-egg"></i>
                    <span>SILOG MEALS</span>
                </div>
                <div class="menu-category" data-section="beef">
                    <i class="fas fa-hamburger"></i>
                    <span>BEEF PARES</span>
                </div>
                <div class="menu-category" data-section="platter">
                    <i class="fas fa-people-arrows"></i>
                    <span>PLATTERS</span>
                </div>
                <div class="menu-category" data-section="snacks">
                    <i class="fas fa-popcorn"></i>
                    <span>SNACKS</span>
                </div>
                <div class="menu-category" data-section="bilao"> 
                    <i class="fas fa-birthday-cake"></i>
                    <span>BILAO</span>
                </div>
            </div>
        </div>

        <!-- Main Menu Content -->
        <div class="menu-content">
            <!-- Rice Meals Section -->
            <div class="menu-section active" id="rice">
                <h2 class="section-title">Rice Meals</h2>
                <div class="menu-grid">
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="img/pork-bistek.jpeg" alt="Pork Bistek">
                            <span class="item-price">₱75</span>
                        </div>
                        <div class="item-info">
                            <h3>Pork Bistek</h3>
                            <p>Tender pork slices marinated in soy sauce and calamansi, served with steamed rice.</p>
                            <div class="item-controls">
                                <button class="decrease-qty">-</button>
                                <input type="text" min="1" value="1" class="item-qty">
                                <button class="increase-qty">+</button>
                                <button class="add-to-cart">🛒</button>
                            </div>
                        </div>
                    </div>

                    <div class="menu-item">
                        <div class="item-image">
                            <img src="img/bopis.jpeg" alt="Bopis">
                            <span class="item-price">₱75</span>
                        </div>
                        <div class="item-info">
                            <h3>Bopis</h3>
                            <p>Spicy minced pork lungs and heart cooked with onions, peppers, and chili.</p>
                            <div class="item-controls">
                                <button class="decrease-qty">-</button>
                                <input type="text" min="1" value="1" class="item-qty">
                                <button class="increase-qty">+</button>
                                <button class="add-to-cart">🛒</button>
                            </div>
                        </div>
                    </div>

                    <div class="menu-item">
                        <div class="item-image">
                            <img src="img/dinuguan.jpeg" alt="Dinuguan">
                            <span class="item-price">₱80</span>
                        </div>
                        <div class="item-info">
                            <h3>Dinuguan</h3>
                            <p>Savory pork blood stew with meat and vinegar, a Filipino classic.</p>
                            <div class="item-controls">
                                <button class="decrease-qty">-</button>
                                <input type="text" min="1" value="1" class="item-qty">
                                <button class="increase-qty">+</button>
                                <button class="add-to-cart">🛒</button>
                            </div>
                        </div>
                    </div>

                    <div class="menu-item">
                        <div class="item-image">
                            <img src="img/papaitan.jpg" alt="Papaitan">
                            <span class="item-price">₱85</span>
                        </div>
                        <div class="item-info">
                            <h3>Papaitan</h3>
                            <p>Bitter soup made from goat or beef innards, flavored with bile and spices.</p>
                            <div class="item-controls">
                                <button class="decrease-qty">-</button>
                                <input type="text" min="1" value="1" class="item-qty">
                                <button class="increase-qty">+</button>
                                <button class="add-to-cart">🛒</button>
                            </div>
                        </div>
                    </div>

                    <div class="menu-item">
                        <div class="item-image">
                            <img src="img/fried-chicken.jpeg" alt="2 PC Chicken">
                            <span class="item-price">₱90</span>
                        </div>
                        <div class="item-info">
                            <h3>2 PC Chicken</h3>
                            <p>Crispy fried chicken served with steamed rice and special gravy.</p>
                            <div class="item-controls">
                                <button class="decrease-qty">-</button>
                                <input type="text" min="1" value="1" class="item-qty">
                                <button class="increase-qty">+</button>
                                <button class="add-to-cart">🛒</button>
                            </div>
                        </div>
                    </div>

                    <div class="menu-item">
                        <div class="item-image">
                            <img src="img/Pork-katsu.jpg" alt="Pork Katsu">
                            <span class="item-price">₱100</span>
                        </div>
                        <div class="item-info">
                            <h3>Pork Katsu</h3>
                            <p>Breaded and deep-fried pork cutlet served with tonkatsu sauce and rice.</p>
                            <div class="item-controls">
                                <button class="decrease-qty">-</button>
                                <input type="text" min="1" value="1" class="item-qty">
                                <button class="increase-qty">+</button>
                                <button class="add-to-cart">🛒</button>
                            </div>
                        </div>
                    </div>

                    <div class="menu-item">
                        <div class="item-image">
                            <img src="img/liempo.jpg" alt="Liempo">
                            <span class="item-price">₱110</span>
                        </div>
                        <div class="item-info">
                            <h3>Liempo</h3>
                            <p>Grilled pork belly marinated in special sauce, served with rice and atchara.</p>
                            <div class="item-controls">
                                <button class="decrease-qty">-</button>
                                <input type="text" min="1" value="1" class="item-qty">
                                <button class="increase-qty">+</button>
                                <button class="add-to-cart">🛒</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Silog Meals Section -->
            <div class="menu-section" id="silog">
                <h2 class="section-title">Silog Meals</h2>
                <div class="menu-grid">
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="img/hamsilog.jpeg" alt="Ham Silog">
                            <span class="item-price">₱55</span>
                        </div>
                        <div class="item-info">
                            <h3>Hamsilog</h3>
                            <p>Ham, fried rice, and sunny-side-up egg - a classic Filipino breakfast.</p>
                            <div class="item-controls">
                                <button class="decrease-qty">-</button>
                                <input type="text" min="1" value="1" class="item-qty">
                                <button class="increase-qty">+</button>
                                <button class="add-to-cart">🛒</button>
                            </div>
                        </div>
                    </div>

                    <div class="menu-item">
                        <div class="item-image">
                            <img src="img/hotsilog.jpeg" alt="Hotsilog">
                            <span class="item-price">₱60</span>
                        </div>
                        <div class="item-info">
                            <h3>Hotsilog</h3>
                            <p>Hotdog, fried rice, and egg - simple yet satisfying breakfast combo.</p>
                            <div class="item-controls">
                                <button class="decrease-qty">-</button>
                                <input type="text" min="1" value="1" class="item-qty">
                                <button class="increase-qty">+</button>
                                <button class="add-to-cart">🛒</button>
                            </div>
                        </div>
                    </div>

                    <div class="menu-item">
                        <div class="item-image">
                            <img src="img/sisilog.jpeg" alt="Sisilog">
                            <span class="item-price">₱85</span>
                        </div>
                        <div class="item-info">
                            <h3>Sisilog</h3>
                            <p>Sizzling pork sisig with garlic fried rice and sunny-side-up egg.</p>
                            <div class="item-controls">
                                <button class="decrease-qty">-</button>
                                <input type="text" min="1" value="1" class="item-qty">
                                <button class="increase-qty">+</button>
                                <button class="add-to-cart">🛒</button>
                            </div>
                        </div>
                    </div>

                    <div class="menu-item">
                        <div class="item-image">
                            <img src="img/Spamsilog.jpeg" alt="Spamsilog">
                            <span class="item-price">₱85</span>
                        </div>
                        <div class="item-info">
                            <h3>Spamsilog</h3>
                            <p>Pan-fried spam, garlic fried rice, and egg - a comfort food favorite.</p>
                            <div class="item-controls">
                                <button class="decrease-qty">-</button>
                                <input type="text" min="1" value="1" class="item-qty">
                                <button class="increase-qty">+</button>
                                <button class="add-to-cart">🛒</button>
                            </div>
                        </div>
                    </div>

                    <div class="menu-item">
                        <div class="item-image">
                            <img src="img/lumpiasilog.jpg" alt="Lumpiasilog">
                            <span class="item-price">₱85</span>
                        </div>
                        <div class="item-info">
                            <h3>Lumpiasilog</h3>
                            <p>Crispy pork spring rolls with garlic fried rice and egg.</p>
                            <div class="item-controls">
                                <button class="decrease-qty">-</button>
                                <input type="text" min="1" value="1" class="item-qty">
                                <button class="increase-qty">+</button>
                                <button class="add-to-cart">🛒</button>
                            </div>
                        </div>
                    </div>

                    <div class="menu-item">
                        <div class="item-image">
                            <img src="img/bangsilog.jpg" alt="Bangsilog">
                            <span class="item-price">₱90-100</span>
                        </div>
                        <div class="item-info">
                            <h3>Bangsilog</h3>
                            <p>Fried milkfish (bangus), garlic fried rice, and egg - a healthy choice.</p>
                            <div class="item-controls">
                                <button class="decrease-qty">-</button>
                                <input type="text" min="1" value="1" class="item-qty">
                                <button class="increase-qty">+</button>
                                <button class="add-to-cart">🛒</button>
                            </div>
                        </div>
                    </div>

                    <div class="menu-item">
                        <div class="item-image">
                            <img src="img/tapsilog.jpeg" alt="Tapsilog">
                            <span class="item-price">₱95</span>
                        </div>
                        <div class="item-info">
                            <h3>Tapsilog</h3>
                            <p>Tender beef tapa, garlic fried rice, and egg - our bestseller!</p>
                            <div class="item-controls">
                                <button class="decrease-qty">-</button>
                                <input type="text" min="1" value="1" class="item-qty">
                                <button class="increase-qty">+</button>
                                <button class="add-to-cart">🛒</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Beef Pares Section -->
            <div class="menu-section" id="beef">
                <h2 class="section-title">Beef Pares</h2>
                <div class="menu-grid">
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="img/pares.jpg" alt="Plain Pares">
                            <span class="item-price">₱55</span>
                        </div>
                        <div class="item-info">
                            <h3>Plain Pares</h3>
                            <p>Tender beef chunks simmered in savory-sweet sauce.</p>
                            <div class="item-controls">
                                <button class="decrease-qty">-</button>
                                <input type="text" min="1" value="1" class="item-qty">
                                <button class="increase-qty">+</button>
                                <button class="add-to-cart">🛒</button>
                            </div>
                        </div>
                    </div>

                    <div class="menu-item">
                        <div class="item-image">
                            <img src="img/pares-rice.jpeg" alt="Pares with Rice">
                            <span class="item-price">₱65</span>
                        </div>
                        <div class="item-info">
                            <h3>Pares with Rice</h3>
                            <p>Beef pares served with steamed rice.</p>
                            <div class="item-controls">
                                <button class="decrease-qty">-</button>
                                <input type="text" min="1" value="1" class="item-qty">
                                <button class="increase-qty">+</button>
                                <button class="add-to-cart">🛒</button>
                            </div>
                        </div>
                    </div>

                    <div class="menu-item">
                        <div class="item-image">
                            <img src="img/pares_shanghai.jpg" alt="Pares Combo">
                            <span class="item-price">₱115</span>
                        </div>
                        <div class="item-info">
                            <h3>Pares Combo with Pork Shanghai</h3>
                            <p>Beef pares with rice and 4 pieces of pork shanghai.</p>
                            <div class="item-controls">
                                <button class="decrease-qty">-</button>
                                <input type="text" min="1" value="1" class="item-qty">
                                <button class="increase-qty">+</button>
                                <button class="add-to-cart">🛒</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Platters Section -->
            <div class="menu-section" id="platter">
                <h2 class="section-title">Platters (4-5 servings)</h2>
                <div class="menu-grid">
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="img/bopis.jpeg" alt="Bopis Platter">
                            <span class="item-price">₱350</span>
                        </div>
                        <div class="item-info">
                            <h3>Bopis Platter</h3>
                            <p>Spicy minced pork lungs and heart perfect for sharing.</p>
                            <div class="item-controls">
                                <button class="decrease-qty">-</button>
                                <input type="text" min="1" value="1" class="item-qty">
                                <button class="increase-qty">+</button>
                                <button class="add-to-cart">🛒</button>
                            </div>
                        </div>
                    </div>

                    <div class="menu-item">
                        <div class="item-image">
                            <img src="img/dinuguan.jpeg" alt="Dinuguan Platter">
                            <span class="item-price">₱350</span>
                        </div>
                        <div class="item-info">
                            <h3>Dinuguan Platter</h3>
                            <p>Savory pork blood stew for group dining.</p>
                            <div class="item-controls">
                                <button class="decrease-qty">-</button>
                                <input type="text" min="1" value="1" class="item-qty">
                                <button class="increase-qty">+</button>
                                <button class="add-to-cart">🛒</button>
                            </div>
                        </div>
                    </div>

                    <div class="menu-item">
                        <div class="item-image">
                            <img src="img/sissisig.jpg" alt="Sisig Platter">
                            <span class="item-price">₱400</span>
                        </div>
                        <div class="item-info">
                            <h3>Sizzling Sisig Platter</h3>
                            <p>Crispy pork sisig served sizzling on a hot plate.</p>
                            <div class="item-controls">
                                <button class="decrease-qty">-</button>
                                <input type="text" min="1" value="1" class="item-qty">
                                <button class="increase-qty">+</button>
                                <button class="add-to-cart">🛒</button>
                            </div>
                        </div>
                    </div>

                    <div class="menu-item">
                        <div class="item-image">
                            <img src="img/pork-bistek.jpeg" alt="Pork Bistek Platter">
                            <span class="item-price">₱380</span>
                        </div>
                        <div class="item-info">
                            <h3>Pork Bistek Platter</h3>
                            <p>Tender pork slices in soy-calamansi sauce for sharing.</p>
                            <div class="item-controls">
                                <button class="decrease-qty">-</button>
                                <input type="text" min="1" value="1" class="item-qty">
                                <button class="increase-qty">+</button>
                                <button class="add-to-cart">🛒</button>
                            </div>
                        </div>
                    </div>

                    <div class="menu-item">
                        <div class="item-image">
                            <img src="img/shanghai.jpg" alt="Shanghai Platter">
                            <span class="item-price">₱300</span>
                        </div>
                        <div class="item-info">
                            <h3>Shanghai Platter (20pcs)</h3>
                            <p>Crispy pork spring rolls perfect for parties.</p>
                            <div class="item-controls">
                                <button class="decrease-qty">-</button>
                                <input type="text" min="1" value="1" class="item-qty">
                                <button class="increase-qty">+</button>
                                <button class="add-to-cart">🛒</button>
                            </div>
                        </div>
                    </div>

                    <div class="menu-item">
                        <div class="item-image">
                            <img src="img/gbutter.jpeg" alt="Garlic Shrimp Platter">
                            <span class="item-price">₱450</span>
                        </div>
                        <div class="item-info">
                            <h3>Garlic Buttered Shrimp Platter</h3>
                            <p>Succulent shrimp in rich garlic butter sauce.</p>
                            <div class="item-controls">
                                <button class="decrease-qty">-</button>
                                <input type="text" min="1" value="1" class="item-qty">
                                <button class="increase-qty">+</button>
                                <button class="add-to-cart">🛒</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Snacks Section -->
            <div class="menu-section" id="snacks">
                <h2 class="section-title">Snacks</h2>
                
                <div class="category-group">
                    <h3 class="category-title">FRIES</h3>
                    <div class="menu-grid">
                        <div class="menu-item">
                            <div class="item-image">
                                <img src="img/150.jpeg" alt="150g Fries">
                                <span class="item-price">₱99</span>
                            </div>
                            <div class="item-info">
                                <h3>150g (1 flavor)</h3>
                                <p>Crunchy fries with your choice of seasoning.</p>
                                <div class="item-controls">
                                    <button class="decrease-qty">-</button>
                                    <input type="text" min="1" value="1" class="item-qty">
                                    <button class="increase-qty">+</button>
                                    <button class="add-to-cart">🛒</button>
                                </div>
                            </div>
                        </div>

                        <div class="menu-item">
                            <div class="item-image">
                                <img src="img/350.jpeg" alt="350g Fries">
                                <span class="item-price">₱159</span>
                            </div>
                            <div class="item-info">
                                <h3>350g (2 flavors)</h3>
                                <p>Larger serving with two different seasonings.</p>
                                <div class="item-controls">
                                    <button class="decrease-qty">-</button>
                                    <input type="text" min="1" value="1" class="item-qty">
                                    <button class="increase-qty">+</button>
                                    <button class="add-to-cart">🛒</button>
                                </div>
                            </div>
                        </div>

                        <div class="menu-item">
                            <div class="item-image">
                                <img src="img/750.jpeg" alt="750g Fries">
                                <span class="item-price">₱259</span>
                            </div>
                            <div class="item-info">
                                <h3>750g (3 flavors)</h3>
                                <p>Party size with three different seasonings.</p>
                                <div class="item-controls">
                                    <button class="decrease-qty">-</button>
                                    <input type="text" min="1" value="1" class="item-qty">
                                    <button class="increase-qty">+</button>
                                    <button class="add-to-cart">🛒</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="category-group">
                    <h3 class="category-title">BEEF</h3>
                    <div class="menu-grid">
                        <div class="menu-item">
                            <div class="item-image">
                                <img src="img/pili.jpg" alt="Pili Cheesesteak">
                                <span class="item-price">₱120</span>
                            </div>
                            <div class="item-info">
                                <h3>Pili Cheesesteak B1T1</h3>
                                <p>Buy 1 take 1 cheesy beef sandwich.</p>
                                <div class="item-controls">
                                    <button class="decrease-qty">-</button>
                                    <input type="text" min="1" value="1" class="item-qty">
                                    <button class="increase-qty">+</button>
                                    <button class="add-to-cart">🛒</button>
                                </div>
                            </div>
                        </div>

                        <div class="menu-item">
                            <div class="item-image">
                                <img src="img/que.jpeg" alt="Quesadillas">
                                <span class="item-price">₱150</span>
                            </div>
                            <div class="item-info">
                                <h3>Quesadillas (4pcs)</h3>
                                <p>Cheesy beef filled tortillas with dipping sauce.</p>
                                <div class="item-controls">
                                    <button class="decrease-qty">-</button>
                                    <input type="text" min="1" value="1" class="item-qty">
                                    <button class="increase-qty">+</button>
                                    <button class="add-to-cart">🛒</button>
                                </div>
                            </div>
                        </div>

                        <div class="menu-item">
                            <div class="item-image">
                                <img src="img/sisilog.jpeg" alt="Nachos">
                                <span class="item-price">₱180</span>
                            </div>
                            <div class="item-info">
                                <h3>Nachos 1 Cart</h3>
                                <p>Crispy tortilla chips with cheese and toppings.</p>
                                <div class="item-controls">
                                    <button class="decrease-qty">-</button>
                                    <input type="text" min="1" value="1" class="item-qty">
                                    <button class="increase-qty">+</button>
                                    <button class="add-to-cart">🛒</button>
                                </div>
                            </div>
                        </div>

                        <div class="menu-item">
                            <div class="item-image">
                                <img src="img/sisilog.jpeg" alt="Nachos Platter">
                                <span class="item-price">₱280</span>
                            </div>
                            <div class="item-info">
                                <h3>Nachos Platter (3-4 servings)</h3>
                                <p>Large nachos with beef, cheese, and all the fixings.</p>
                                <div class="item-controls">
                                    <button class="decrease-qty">-</button>
                                    <input type="text" min="1" value="1" class="item-qty">
                                    <button class="increase-qty">+</button>
                                    <button class="add-to-cart">🛒</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="category-group">
                    <h3 class="category-title">PASTA</h3>
                    <div class="menu-grid">
                        <div class="menu-item">
                            <div class="item-image">
                                <img src="img/hamsilog.jpeg" alt="Spaghetti">
                                <span class="item-price">₱120</span>
                            </div>
                            <div class="item-info">
                                <h3>Spaghetti</h3>
                                <p>Classic Filipino-style sweet spaghetti with meat sauce.</p>
                                <div class="item-controls">
                                    <button class="decrease-qty">-</button>
                                    <input type="text" min="1" value="1" class="item-qty">
                                    <button class="increase-qty">+</button>
                                    <button class="add-to-cart">🛒</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bilao Section -->
            <div class="menu-section" id="bilao">
                <h2 class="section-title">Bilao (Large Trays)</h2>
                <div class="menu-grid">
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="img/l-chi.jpg" alt="L-Chicken Wings">
                            <span class="item-price">₱550</span>
                        </div>
                        <div class="item-info">
                            <h3>L-Chicken Wings (30pcs)</h3>
                            <p>30 pieces of our signature chicken wings with dip.</p>
                            <div class="item-controls">
                                <button class="decrease-qty">-</button>
                                <input type="text" min="1" value="1" class="item-qty">
                                <button class="increase-qty">+</button>
                                <button class="add-to-cart">🛒</button>
                            </div>
                        </div>
                    </div>

                    <div class="menu-item">
                        <div class="item-image">
                            <img src="img/l-spa.jpg" alt="L-Spaghetti">
                            <span class="item-price">₱450</span>
                        </div>
                        <div class="item-info">
                            <h3>L-Spaghetti</h3>
                            <p>Large tray of Filipino-style spaghetti good for 10-12 people.</p>
                            <div class="item-controls">
                                <button class="decrease-qty">-</button>
                                <input type="text" min="1" value="1" class="item-qty">
                                <button class="increase-qty">+</button>
                                <button class="add-to-cart">🛒</button>
                            </div>
                        </div>
                    </div>

                    <div class="menu-item">
                        <div class="item-image">
                            <img src="img/l-bih.jpg" alt="L-Pancit Bihon">
                            <span class="item-price">₱400</span>
                        </div>
                        <div class="item-info">
                            <h3>L-Pancit Bihon</h3>
                            <p>Large bilao of rice noodles with vegetables and meat.</p>
                            <div class="item-controls">
                                <button class="decrease-qty">-</button>
                                <input type="text" min="1" value="1" class="item-qty">
                                <button class="increase-qty">+</button>
                                <button class="add-to-cart">🛒</button>
                            </div>
                        </div>
                    </div>

                    <div class="menu-item">
                        <div class="item-image">
                            <img src="img/l-can.jpg" alt="L-Pancit Canton">
                            <span class="item-price">₱420</span>
                        </div>
                        <div class="item-info">
                            <h3>L-Pancit Canton</h3>
                            <p>Large bilao of egg noodles with vegetables and meat.</p>
                            <div class="item-controls">
                                <button class="decrease-qty">-</button>
                                <input type="text" min="1" value="1" class="item-qty">
                                <button class="increase-qty">+</button>
                                <button class="add-to-cart">🛒</button>
                            </div>
                        </div>
                    </div>

                    <div class="menu-item">
                        <div class="item-image">
                            <img src="img/hotsilog.jpeg" alt="M-Pork Shanghai">
                            <span class="item-price">₱380</span>
                        </div>
                        <div class="item-info">
                            <h3>M-Pork Shanghai (50pcs)</h3>
                            <p>Medium bilao of 50 pieces pork spring rolls.</p>
                            <div class="item-controls">
                                <button class="decrease-qty">-</button>
                                <input type="text" min="1" value="1" class="item-qty">
                                <button class="increase-qty">+</button>
                                <button class="add-to-cart">🛒</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Drinks Section -->
            <div class="menu-section" id="drinks">
                <h2 class="section-title">Drinks</h2>
                
                <div class="category-group">
                    <h3 class="category-title">PITCHER (₱59)</h3>
                    <div class="menu-grid drinks-grid">
                        <div class="menu-item drink-item">
                            <div class="item-image">
                                <img src="img/pitcher-drinks.jpg" alt="Pitcher Drinks">
                            </div>
                            <div class="item-info">
                                <h3>Pitcher Drinks</h3>
                                <div class="drink-flavors">
                                    <p><i class="fas fa-check"></i> Apple Iced Tea</p>
                                    <p><i class="fas fa-check"></i> Lemon Iced Tea</p>
                                    <p><i class="fas fa-check"></i> Cucumber Lemonade</p>
                                    <p><i class="fas fa-check"></i> Red Iced Tea</p>
                                    <p><i class="fas fa-check"></i> Blue Lemonade</p>
                                    <p><i class="fas fa-check"></i> Pineapple</p>
                                    <p><i class="fas fa-check"></i> Gulaman</p>
                                    <p><i class="fas fa-check"></i> Calamansi</p>
                                </div>
                                <div class="item-controls">
                                    <button class="add-to-cart">Add to Order</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
  

         
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart Structure -->
    <div class="cart-icon">
        <i class="fas fa-shopping-cart"></i>
        <span class="cart-count">0</span>
    </div>
    
   <!-- Cart Preview -->
<div class="cart-preview" style="display:none; background: white; padding: 20px; border-radius: 8px; width: 350px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center; margin: 20px auto;">
    <h3>Your Cart</h3>
    <div class="cart-items"></div>
    <h4 style="margin-top: 10px;">Total: <span class="total-amount">₱0.00</span></h4>
    <button class="checkout-btn" onclick="openCheckout()" style="margin-top: 15px;  color: white; padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer; font-size: 16px;">Checkout</button>
</div>

 <script>
        const isLoggedIn = <?php echo $isLoggedIn ? 'true' : 'false'; ?>;
    </script>
 
<div id="loginModal">
        <div id="loginModalContent">
            <span class="close">&times;</span>
            <h2>Login Required</h2>
            <p>You need to sign up or log in to proceed to checkout.</p>
            <button onclick="window.location.href='login.php'">Login</button>
            <button onclick="window.location.href='User_Reg.php'">Sign Up</button>
        </div>
    </div>

<!-- Checkout Modal -->
<div id="checkoutModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); justify-content:center; align-items:center; z-index:9999;">
  <div style="background:white; padding:30px; border-radius:12px; width:340px; text-align:center; position:relative; box-shadow: 0 5px 15px rgba(0,0,0,0.3);">
    <button onclick="closeCheckout()" style="position:absolute; top:10px; right:10px; background:none; border:none; font-size:24px; font-weight:bold; color:#333; cursor:pointer;">&times;</button>

    <div style="margin-bottom: 20px;">
        <img src="img/gcash.jpeg" alt="GCash Logo" style="width:140px;">
    </div>
   <!-- Exit button inside Modal -->
<button id="closeModalBtn" style="position:absolute;top:10px;right:10px;">×</button>

    <h3 style="margin-bottom: 20px;">Checkout Details</h3>

    <form id="checkoutForm" action="checkout.php" method="POST">
      <input type="text" name="customer_name" placeholder="Enter Full Name" required style="width:100%; padding:10px; margin-bottom:15px; border-radius:6px; border:1px solid #ccc;"><br>
      <input type="text" name="customer_number" placeholder="Enter GCash Number" required style="width:100%; padding:10px; margin-bottom:20px; border-radius:6px; border:1px solid #ccc;"><br>

      <input type="hidden" name="total_amount" id="total_amount_input">
      <input type="hidden" name="cart_data" id="cart_data_input">

      <button type="submit" style="background:#0076c0; width:100%; padding:12px; font-size:18px; border:none; border-radius:6px; color:white; cursor:pointer;">Confirm and Pay</button>
    </form>
  </div>
</div>
<!-- Hidden input to pass login status to JavaScript -->
<input type="hidden" id="isLoggedIn" value="<?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>">


    <footer id ="about">
        <div class="footer-container">
            <div class="footer-column">
                <div id="logo-footer">GRACIA'S</div>
                <div class="footer-location">
                    <i class="fas fa-map-marker-alt"></i>
                    <p>14B Divina St. North Poblacion,<br>Masinloc, Philippines</p>
                </div>
            </div>
            <div class="footer-column">
                <h3>Quick Links</h3>
                <ul class="footer-links">
                    <li><a href="homepage.php">Home</a></li>
                    <li><a href="menu.php">Menu</a></li>
                    <li><a href="#about">About Us</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Contact Us</h3>
                <ul class="footer-contact">
                    <li><i class="fas fa-phone"></i> +63 912 345 6789</li>
                    <li><i class="fas fa-envelope"></i> info@gracias.com</li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Follow Us</h3>
                <div class="social-media">
                    <a href="https://web.facebook.com/ggraciass.2020" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.instagram.com/sorbetesbygracias/" target="_blank"><i class="fab fa-instagram"></i></a>
                    <a href="#" target="_blank"><i class="fab fa-twitter"></i></a>
                </div>
                <div class="business-hours">
                    <h4>Business Hours</h4>
                    <p>Monday-Sunday: 8:00 AM - 10:00 PM</p>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p class="copyright">&copy; 2025 Gracia's Restaurant. All rights reserved.</p>
        </div>
    </footer>
    <script src="menu.js"></script>

</body>
</html>
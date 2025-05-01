
    document.addEventListener('DOMContentLoaded', function() {
        // Category switching
        const categories = document.querySelectorAll('.menu-category');
        const menuSections = document.querySelectorAll('.menu-section');

        categories.forEach(category => {
            category.addEventListener('click', function() {
                categories.forEach(c => c.classList.remove('active'));
                this.classList.add('active');

                menuSections.forEach(section => section.classList.remove('active'));
                document.getElementById(this.getAttribute('data-section')).classList.add('active');

                document.querySelector('.menu-content').scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        });

        // Cart functionality
        const cart = {
            items: [],
            total: 0,

            addItem: function(name, price, qty) {
                const existingItem = this.items.find(item => item.name === name);

                if (existingItem) {
                    existingItem.qty += qty;
                } else {
                    this.items.push({
                        name: name,
                        price: price,
                        qty: qty
                    });
                }

                this.updateTotal();
                this.updateCartDisplay();
            },

            removeItem: function(index) {
                this.items.splice(index, 1);
                this.updateTotal();
                this.updateCartDisplay();
            },

            updateItemQty: function(index, newQty) {
                if (newQty > 0) {
                    this.items[index].qty = newQty;
                } else {
                    this.removeItem(index);
                }
                this.updateTotal();
                this.updateCartDisplay();
            },

            updateTotal: function() {
                this.total = this.items.reduce((sum, item) => sum + (item.price * item.qty), 0);
            },

            updateCartDisplay: function() {
                const cartItemsContainer = document.querySelector('.cart-items');
                const cartCount = document.querySelector('.cart-count');
                const totalAmount = document.querySelector('.total-amount');
                const cartPreview = document.querySelector('.cart-preview');

                const itemCount = this.items.reduce((count, item) => count + item.qty, 0);
                cartCount.textContent = itemCount;

                if (this.items.length > 0) {
                    cartPreview.style.display = 'block';
                } else {
                    cartPreview.style.display = 'none';
                }

                cartItemsContainer.innerHTML = '';

                this.items.forEach((item, index) => {
                    const cartItem = document.createElement('div');
                    cartItem.className = 'cart-item';

                    cartItem.innerHTML = `
                        <span class="cart-item-name">${item.name}</span>
                        <span class="cart-item-price">₱${item.price.toFixed(2)}</span>
                        <input type="number" min="1" value="${item.qty}" class="cart-item-qty"
                               data-index="${index}">
                        <button class="cart-item-remove" data-index="${index}">
                            <i class="fas fa-times"></i>
                        </button>
                    `;

                    cartItemsContainer.appendChild(cartItem);
                });

                totalAmount.textContent = `₱${this.total.toFixed(2)}`;

                cartCount.classList.add('cart-update');
                setTimeout(() => {
                    cartCount.classList.remove('cart-update');
                }, 500);

                document.querySelectorAll('.cart-item-qty').forEach(input => {
                    input.addEventListener('change', function() {
                        const index = parseInt(this.getAttribute('data-index'));
                        const newQty = parseInt(this.value);
                        cart.updateItemQty(index, newQty);
                    });
                });

                document.querySelectorAll('.cart-item-remove').forEach(button => {
                    button.addEventListener('click', function() {
                        const index = parseInt(this.getAttribute('data-index'));
                        cart.removeItem(index);
                    });
                });
            }
        };

        function openCheckout() {
            document.getElementById('checkoutModal').style.display = 'flex';
            let total = document.querySelector('.total-amount').innerText.replace('₱','');
            document.getElementById('total_amount_input').value = total.trim();
            document.getElementById('cart_data_input').value = JSON.stringify(cart.items);
        }

        function closeCheckout() {
            document.getElementById('checkoutModal').style.display = 'none';
        }

        function openLoginModal() {
            document.getElementById('loginModal').style.display = 'block';
        }

        function closeLoginModal() {
            document.getElementById('loginModal').style.display = 'none';
        }

        // Close modal properly
        document.getElementById('closeModalBtn').addEventListener('click', function() {
            closeCheckout();
        });

        document.querySelector('.close').addEventListener('click', function() {
            closeLoginModal();
        });

        // Add to cart buttons
        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', function() {
                const menuItem = this.closest('.menu-item');
                const itemName = menuItem.querySelector('h3').textContent;
                const itemPriceText = menuItem.querySelector('.item-price').textContent;
                const itemPrice = parseFloat(itemPriceText.replace(/[^0-9.]/g, ''));
                const itemQty = parseInt(menuItem.querySelector('.item-qty').value);

                cart.addItem(itemName, itemPrice, itemQty);

                menuItem.querySelector('.item-qty').value = 1;

                // Show feedback
                const feedback = document.createElement('div');
                feedback.textContent = 'Added to cart!';
                feedback.style.position = 'fixed';
                feedback.style.bottom = '20px';
                feedback.style.left = '50%';
                feedback.style.transform = 'translateX(-50%)';
                feedback.style.backgroundColor = '#28a745';
                feedback.style.color = 'white';
                feedback.style.padding = '10px 20px';
                feedback.style.borderRadius = '5px';
                feedback.style.zIndex = '1000';
                document.body.appendChild(feedback);

                setTimeout(() => {
                    feedback.style.opacity = '0';
                    feedback.style.transition = 'opacity 0.5s';
                    setTimeout(() => feedback.remove(), 500);
                }, 2000);
            });
        });

        // Quantity controls
        document.querySelectorAll('.increase-qty').forEach(button => {
            button.addEventListener('click', function() {
                const qtyInput = this.previousElementSibling;
                qtyInput.value = parseInt(qtyInput.value) + 1;
            });
        });

        document.querySelectorAll('.decrease-qty').forEach(button => {
            button.addEventListener('click', function() {
                const qtyInput = this.nextElementSibling;
                const currentValue = parseInt(qtyInput.value);
                if (currentValue > 1) {
                    qtyInput.value = currentValue - 1;
                }
            });
        });

        // Checkout button
        document.querySelector('.checkout-btn').addEventListener('click', function() {
            if (!isLoggedIn) {
                openLoginModal();
            } else if (cart.items.length > 0) {
                openCheckout();
            } else {
                alert('Your cart is empty!');
            }
        });

        // Close checkout modal
        document.querySelector('.close-checkout-btn').addEventListener('click', function() {
            closeCheckout();
        });

        // Initialize cart display
        cart.updateCartDisplay();
    });


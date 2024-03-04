<?php
header('Content-Type: application/javascript');
session_start();
?>

document.addEventListener("DOMContentLoaded", function() {
    var isLoggedIn = <?php echo isset($_SESSION['logged_in']) && $_SESSION['logged_in'] ? 'true' : 'false'; ?>;
    var userName = "<?php echo isset($_SESSION['fname']) ? $_SESSION['fname'] : 'Guest'; ?>";
    
    var headerHTML = `
        <div class="logo">
            <img src="style/logo.png" alt="REACH" height="50">
        </div>
        <div class="menu">
            <a href="index.php">Home</a>
            <a href="contact-us.php">Contact us</a>
            <a href="courses.php">Courses</a>
            <div class="account">
                <p>Account</p>
                <div class="account-overlay" style="display: none;">
                    <div class="profile" style="display: ` + (isLoggedIn ? 'flex' : 'none') + `;">
                        <img src="style/no-profile-image.svg" alt="no-image" width="20">
                        <p>` + userName + `</p>
                    </div>
                    <div class="account-utilities" style="display: ` + (isLoggedIn ? 'flex' : 'none') + `;">
                        <a href="account.php">Settings</a>
                        <a href="support.php">Help & Support</a>
                        <a href="feedback.php">Give Feedback</a>
                        <a href="#" id="logoutLink">Logout</a>
                    </div>
                    <div class="login" style="display: ` + (!isLoggedIn ? 'block' : 'none') + `;">
                        <h1>You need to login</h1>
                        <div class="button">
                            <a href="login.php">Login</a>
                            <a href="register.php">Register</a>
                        </div>
                    </div>
                </div>
            </div>
            <a href="about-us.php">About us</a>
            <a href="student-support.php">Student support</a>
            <div class="cart">
                <img src="style/cart.svg" alt="cart">
                <div class="cart-items" style="display: none;">
                    <h1>No items</h1>
                </div>
            </div>
        </div>
        <div class="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
    `;

    var headerElement = document.querySelector("header");
    if(headerElement) {
        headerElement.innerHTML = headerHTML;
    }

    var footerHTML = `    
    <p>Copyright and privacy</p>
    `;

    var footerElement = document.querySelector('footer');
    if(footerElement) {
        footerElement.innerHTML = footerHTML;
    }

    document.querySelector('#logoutLink').addEventListener('click', function(e) {
        e.preventDefault();
        fetch('logout.php', { method: 'POST' })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    window.location.href = 'login.php';
                }
            })
            .catch(error => console.error('Error:', error));
    });

    document.querySelector('.account > p').addEventListener('click', function() {
        var accountOverlay = document.querySelector('.account-overlay');
        var cartItems = document.querySelector('.cart-items');
        accountOverlay.style.display = accountOverlay.style.display === 'flex' ? 'none' : 'flex';
        if(cartItems.style.display === 'flex') {
            cartItems.style.display = 'none';
        }
    });

    document.querySelector('.cart img').addEventListener('click', function() {
        var cartItems = document.querySelector('.cart-items');
        var accountOverlay = document.querySelector('.account-overlay');
        cartItems.style.display = cartItems.style.display === 'flex' ? 'none' : 'flex';
        if(accountOverlay.style.display === 'flex') {
            accountOverlay.style.display = 'none';
        }
    });

    function addToCart(courseName, coursePrice) {
        var cartItemsContainer = document.querySelector('.cart-items');
        var noItemsMessage = document.querySelector('.cart-items h1');
        if(noItemsMessage) noItemsMessage.style.display = 'none';
        var itemDiv = document.createElement('div');
        itemDiv.className = 'item';
        itemDiv.innerHTML = `<p>${courseName} (${coursePrice})</p><img src="style/remove.svg" alt="delete" class="remove-cart-item">`;
        cartItemsContainer.appendChild(itemDiv);
        cartItemsContainer.style.display = 'flex';
    }

    var addButton = document.getElementById('add');
    if(addButton) {
        addButton.addEventListener('click', function(e) {
            e.preventDefault();
            var courseName = this.getAttribute('data-course-name');
            var coursePrice = this.getAttribute('data-course-price');
            addToCart(courseName, coursePrice);
        });
    }

    document.body.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('remove-cart-item')) {
            e.target.parentElement.remove();
            var items = document.querySelectorAll('.cart-items .item');
            if(items.length === 0) {
                var noItemsMessage = document.querySelector('.cart-items h1');
                if(noItemsMessage) noItemsMessage.style.display = 'block';
                document.querySelector('.cart-items').style.display = 'none';
            }
        }
    });
});

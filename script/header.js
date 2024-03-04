document.addEventListener("DOMContentLoaded", function() {
    var isLoggedIn = false;
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
                <div class="account-overlay">
                    <div class="profile">
                        <img src="no-profile-image.png" alt="no-image">
                        <p>My Name</p>
                    </div>
                    <div class="account-utilities">
                        <a href="">Settings</a>
                        <a href="">Help & Support</a>
                        <a href="">Give Feedback</a>
                        <a href="">Logout</a>
                    </div>
                    <div class="login">
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

    function addToCart(courseName, coursePrice) {
        var cartItemsContainer = document.querySelector('.cart-items');
        var noItemsMessage = document.querySelector('.cart-items h1');
        var itemDiv = document.createElement('div');
        itemDiv.className = 'item';
        itemDiv.innerHTML = `<p>${courseName} (${coursePrice})</p><img src="style/remove.svg" alt="delete" class="remove-cart-item">`;
        cartItemsContainer.appendChild(itemDiv);
        noItemsMessage.style.display = 'none';
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
                document.querySelector('.cart-items h1').style.display = 'block';
                document.querySelector('.cart-items').style.display = 'none';
            }
        }
    });

    var cartIcon = document.querySelector('.cart img');
    if(cartIcon) {
        cartIcon.addEventListener('click', function() {
            var cartItemsContainer = document.querySelector('.cart-items');
            if(cartItemsContainer.style.display === 'flex') {
                cartItemsContainer.style.display = 'none';
            } else {
                cartItemsContainer.style.display = 'flex';
            }
        });
    }

    var accountUtilities = document.querySelector('.account-utilities');
    var profile = document.querySelector('.profile');
    var login = document.querySelector('.login');

    if (!isLoggedIn) {
        if (accountUtilities && profile) {
            accountUtilities.style.display = 'none';
            profile.style.display = 'none';
        }
        if (login) {
            login.style.display = 'block';
        }
    } else {
        if (accountUtilities && profile) {
            accountUtilities.style.display = 'block';
            profile.style.display = 'block';
        }
        if (login) {
            login.style.display = 'none';
        }
    }
});

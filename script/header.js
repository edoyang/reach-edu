document.addEventListener("DOMContentLoaded", function() {
    var headerHTML = `
        <div class="logo">
            <img src="" alt="REACH">
        </div>
        <div class="menu">
            <a href="index.html">Home</a>
            <a href="contact-us.html">Contact us</a>
            <a href="courses.html">Courses</a>
            <a href="account.html">Account</a>
            <a href="about-us.html">About us</a>
            <a href="student-support.html">Student support</a>
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

    var footerHTML =`    
    <p>Copyright and privacy</p>
    `

    var footerElement = document.querySelector('footer');
    if(footerElement) {
        footerElement.innerHTML = footerHTML;
    }
});

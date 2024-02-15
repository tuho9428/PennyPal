<?php
include 'partials/header.php';
?>


<section>
    <div class="container">

        <img src="./images/contact1.jpg" style="width: 100%; height: auto;" alt="Home 1">
    </div>
</section>


<section>
    <div class="bottom-container">
        <div class="contact">
            <h3>Contact Us</h3>
            <p>Email: info@example.com</p>
            <p>Phone: +1 123 456 789</p>
        </div>


        <div class="form-container">
            <form action="submit_form.php" method="post">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" placeholder="Enter your Name" required>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="Enter a valid email address" required>
                </div>

                <div class="form-group">
                    <label for="message">Message:</label>
                    <textarea id="message" name="message" placeholder="Enter your message" required></textarea>
                </div>

                <button type="submit">Submit</button>
            </form>
        </div>
    </div>

</section>




<?php
include 'partials/footer.php';
?>

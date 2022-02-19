<div class="prices-banner-img ">
    <img src="assets/images/contact-banner.png " alt=" ">
</div>


</section>
<!--********* contact banner section end************-->


<!--********* contact info section start************-->
<section>
    <div class="container contact">
        <h2 class="faq-heading ">Contact</h2>

        <div class="underline-design ">
            <div class="line " style="margin-right: 10px;"></div>
            <img src="assets/images/faq-star.png " alt=" ">
            <div class="line " style="margin-left: 10px;"></div>
        </div>

        <div class="row">
            <div class="contact-info text-center">
                <div class="col-md-4">
                    <img src="assets/images/location.png" alt="">
                    <p class="mt-4">1111 Lorem ipsum text 100,</p>
                    <p>Lorem ipsum AB</p>
                </div>
                <div class="col-md-4">
                    <img src="assets/images/phone-call.png" alt="">
                    <p class="mt-4">+49 (40) 123 56 7890</p>
                    <p>+49 (40) 987 56 0000</p>
                </div>
                <div class="col-md-4">
                    <img src="assets/images/msg-icon.png" alt="">
                    <p class="mt-4">info@helperland.com</p>
                </div>
            </div>
        </div>
        <hr>
    </div>
</section>
<!--********* contact info section end************-->


<!--********* contact get-in-touch section start************-->

<section class="get-in-touch">
    <div class="container">
        <h2 class="faq-heading ">Get in touch with us</h2>

        <div class="contact-form">

            <form action="<?php echo $arr['base_url'] . '?controller=user&function=submit_contactForm'; ?>" method="POST">

                <?php

                if (isset($_GET['status']) == 1) {
                    echo "<div class='status-message' style='display:flex;'>";
                    echo "<p class='text-success'>Your reposne is successfully submitted! We will get back to you soon.</p>";
                    echo "<a  onclick='hideMessage()'><i class='fa fa-close'></i></a>";
                    echo "</div>";
                }

                if (isset($_GET['message']) && $_GET['message'] != '') {
                    foreach (explode(",", $_GET['message']) as $e) {
                        echo "<div class='response-text' style='display:block;'>";
                        echo "<p class='text-danger'>";
                        echo $e;
                        echo "</p>";
                        echo "</div>";
                    }
                }
                ?>

                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <input type="text" class="form-control names" value="" name="firstname" placeholder="First name" onfocusout="showMessage(this.id)" id="fname" required>

                        <p class="text-danger msg-text mb-0"></p>

                    </div>
                    <div class="col-md-6 col-sm-12">
                        <input type="text" class="form-control names" name="lastname" onfocusout="showMessage(this.id)" placeholder="Last name" id="lname" required>
                        <p class="text-danger msg-text mb-0"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <input type="email" class="form-control" id="email" onfocusout="showMessage(this.id)" aria-describedby="emailHelp" placeholder="Enter email" name="email" required>
                            <p class="text-danger msg-text mb-0"></p>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group d-flex">
                            <div class="input-group-prepend">
                                <div class="input-group-text">+91</div>
                            </div>
                            <input type="number" maxlength="10" class="form-control phone" onfocusout="showMessage(this.id)" name="phone" id="phone" placeholder="Mobile number" required>

                        </div>
                        <p class="text-danger msg-text mb-0"></p>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12 col-sm-12 subject-selection">
                        <select name="subject-select" class="subject-select">
                            <option value="General">General</option>
                            <option value="Inquiry">Inquiry</option>
                            <option value="Renewal">renewal</option>
                            <option value="Revocation">revocation</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-sm-12 form-group">
                        <textarea name="msg-area" id="contact-msg" onfocusout="showMessage(this.id)" class="msg-textarea form-control" placeholder="Message" required></textarea>
                        <p class="text-danger mb-0" id="textarea-msg"></p>
                    </div>
                </div>

                <div class="submit">
                    <button type="submit" name="submit" class="form-submit">Submit</button>
                    <!-- <input type="submit" value="submit" name="submit" id="submit"> -->
                </div>

            </form>

        </div>
    </div>
</section>

<section class="map">
    <div class="googleMap">
    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d80662.4942729429!2d7.076017238758908!3d50.81814219143823!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sin!4v1644903952282!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </div>
</section>
<!--********* contact get-in-touch section end************-->

<?php
include 'footer.php';
?>

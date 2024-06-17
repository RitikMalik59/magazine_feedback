<?php include "./config/db_connect.php"; ?>
<?php include "includes/header.php"; ?>
<?php require './vendor/autoload.php'; ?>
<?php

use Hashids\Hashids;

?>

<h2 class="display-6 text-center mt-5">Magazine Feedback Form</h2>

<div class="container">
    <div class="row ">
        <div class="col-md-9 mx-auto">
            <div class="card card-body shadow  mt-3">
                <p class="fs-6 fw-medium">Thanks for being a part of Clean India Journal - The Voice of the Indian Cleaning Industry. Being a responsible magazine, we are on the journey of constant improvement. Kindly share your valuable feedback to help us serve the cleaning & hygiene professionals better and A Clean India at large.</p>
                <form class="row g-3" id="feedback_form" action="./users/submit_feedback.php" method="post">
                    <div class=" bg-secondary-subtle mt-5">
                        <h5 class="text-center pt-1">Personal Information </h5>
                    </div>
                    <?php
                    if (isset($_GET['_id'])) {

                        // hashing URL ID for security
                        $hashids = new Hashids('', 15);
                        $hash_id = $_GET['_id'];
                        $decoded_id = $hashids->decode($hash_id); // [1, 2, 3]
                        $id = $decoded_id[0];

                        $query = "SELECT name, designation, company, phone, email FROM old_records WHERE id = ?";
                        $stmt = $connection->prepare($query);
                        $stmt->execute([$id]);
                        $row_count = $stmt->rowCount();

                        if ($row_count > 0) {

                            $row = $stmt->fetchAll();
                            $data = $row[0];

                            $name = $data['name'] ?? '';
                            $designation = $data['designation'] ?? '';
                            $company = $data['company'] ?? '';
                            $phone = $data['phone'] ?? '';
                            $email = $data['email'] ?? '';

                            // var_dump($data);
                        }
                    }

                    ?>

                    <input type="hidden" name="id" value="<?= $id; ?>">

                    <div class="col-md-12">
                        <label class="form-label">Name:<sup class="text-danger">*</sup></label>
                        <input type="text" name="name" value="<?= $name ?? '' ?>" class="form-control" required>
                        <span class="invalid-feedback"><br /></span>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Designation:<sup class="text-danger">*</sup></label>
                        <input type="text" name="designation" value="<?= $designation ?? '' ?>" class="form-control" required>
                        <span class="invalid-feedback"><br /></span>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Company:<sup class="text-danger">*</sup></label>
                        <input type="text" name="company" value="<?= $company ?? '' ?>" class="form-control" required>
                        <span class="invalid-feedback"><br /></span>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Phone:<sup class="text-danger">*</sup></label>
                        <input type="text" name="phone" value="<?= $phone ?? '' ?>" class="form-control" required>
                        <span class="invalid-feedback"><br /></span>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email:<sup class="text-danger">*</sup></label>
                        <input type="email" name="email" value="<?= $email ?? '' ?>" class="form-control" required>
                        <span class="invalid-feedback"><br /></span>
                    </div>

                    <div class=" bg-secondary-subtle mt-5">
                        <h5 class="text-center pt-1">Feedback Questions </h5>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-bold">Which Topic did you find most interesting to read from May issue ? <sup class="text-danger">*</sup></label>
                        <div id="errorToShow"></div>
                        <?php
                        $options_for_answer_1 = [
                            'Cover story - Gated Communities Rising High with Smart Solutions',
                            'The Story of Transforming Spaces & Lives',
                            'Driving the Eco-Friendly Evolution',
                            'Changing Dynamics with Cleaning Automation',
                            'Minding the Gap: Communication Strategies for Facility Managers',
                            '9-level Changes through Tech-driven FM',
                            'Sustainable Pest Management Measures: Innovating for a Greener Future',
                            'Healthcare : Are you in Safe Hands? - Understanding the how, what, why, where, and when of handwashing today',
                            'Chemical Safety & Hygiene in Manufacturing - Protecting People and the Environment',
                            'Evolving Towards Sustianbility : Greening of Commercial Washing',
                            'Global Success Stories - Traceability of Zero-Waste Initiatives',
                            'Corporate Sector Contribution to Augmenting Water Body Revival',
                            'Globe Toyota on Autocare - Dealers Take the Lead',
                            'Innovative Commercial Laundry Solution : Energy-efficient, low operational costs and linen longevity',
                        ];
                        ?>
                        <?php

                        foreach ($options_for_answer_1 as $key => $value) : ?>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="answer_1[]" value="<?= $value; ?>" id="answer1_option<?= $key; ?>">
                                <label class="form-check-label" for="answer1_option<?= $key; ?>">
                                    <?= $value; ?>
                                </label>
                            </div>

                        <?php endforeach; ?>

                        <span class="invalid-feedback"><br /></span>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-bold">Which section in the magazine, is the most interesting read for you ? <sup class="text-danger">*</sup></label>
                        <?php
                        $options_for_answer_2 = [
                            'Products & Systems',
                            'Industry Talks',
                            'Case Studies',
                            'Hygiene',
                            'Facility Management',
                            'Technologically Speaking',
                            'Pest Management',
                            'Laundry',
                            'Waste Management',
                            'Autocare',
                        ];
                        ?>
                        <?php

                        foreach ($options_for_answer_2 as $key => $value) : ?>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="answer_2[]" value="<?= $value; ?>" id="answer2_option<?= $key; ?>">
                                <label class="form-check-label" for="answer2_option<?= $key; ?>">
                                    <?= $value; ?>
                                </label>
                            </div>

                        <?php endforeach; ?>
                        <span id="errorToShow"></span>
                        <span class="invalid-feedback"><br /></span>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Have you Purchased / Plan to Purchase any products listed in the magazine ? <sup class="text-danger">*</sup></label>
                        <div class="input-group">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="answer_3" id="yes" value="yes" required>
                                <label class="form-check-label" for="yes">
                                    Yes
                                </label>
                            </div>
                            <div class="form-check mx-5">
                                <input class="form-check-input" type="radio" name="answer_3" id="no" value="no" required>
                                <label class="form-check-label" for="no">
                                    No
                                </label>
                            </div>
                        </div>
                        <div id="share_details" class="mt-3"></div>
                        <span class="invalid-feedback"><br /></span>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-bold" for="question_4">Which Company Ads did you find interesting ? <sup class="text-danger">*</sup></label>
                        <input type="text" name="answer_4" class="form-control" id="question_4" required>
                        <span class="invalid-feedback"><br /></span>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-bold" for="question_5">Any additional suggestions / feedback regarding the overall content ? <sup class="text-danger">*</sup></label>
                        <textarea class="form-control" name="answer_5" id="question_5" rows="3" required></textarea>
                        <span class="invalid-feedback"><br /></span>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-bold" for="question_6">Do mention the topics you would like to read in future issues ? <sup class="text-danger">*</sup></label>
                        <input type="text" name="answer_6" class="form-control" id="question_6" required>
                        <span class="invalid-feedback"><br /></span>
                    </div>
                    <div class="row justify-content-md-center mt-5 mb-3">
                        <div class="col-6 d-grid gap-2">
                            <input type="submit" class="btn btn-success" name="feedback_submit" value="Submit Feedback">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // console.log('validator');
        // just for the demos, avoids form submit
        // jQuery.validator.setDefaults({
        //     debug: true,
        //     success: "valid"
        // });
        $("#feedback_form").validate({
            // Specify validation rules
            rules: {
                // The key name on the left side is the name attribute
                // of an input field. Validation rules are defined
                // on the right side
                name: "required",
                designation: "required",
                company: "required",
                phone: {
                    required: true,
                    maxlength: 12,
                    minlength: 10,
                    digits: true
                },
                email: {
                    required: true,
                    // Specify that email should be validated
                    // by the built-in "email" rule
                    email: true
                },
                "answer_1[]": {
                    required: true,
                    minlength: 1
                },
                "answer_2[]": {
                    required: true,
                    minlength: 1
                }

            },
            // Specify validation error messages
            messages: {
                name: "Please enter your Name",
                designation: "Please enter your Designation",
                company: {
                    required: "Please provide a company name",
                    // minlength: "Your password must be at least 5 characters long"
                },
                phone: {
                    required: "Please enter your valid phone number",
                    minlength: "Your phone number must be at least 10 characters long",
                    maxlength: "Your phone number must not be more than 12 characters long"
                },
                email: "Please enter a valid email address"
            },
            "answer_1[]": "Please select at least one checkbox.",
            "answer_2[]": "Please select at least one checkbox.",
            errorPlacement: function(label, element) {
                if (element.attr("name") === "answer_1[]" || element.attr("name") === "answer_2[]" || element.attr("name") === "answer_3") {
                    // error.appendTo("#errorToShow");
                    element.parent().parent().append(label); // this would append the label after all your checkboxes/labels (so the error-label will be the last element in <div class="controls"> )
                    // element.append('#errorToShow'); // this would append the label after all your checkboxes/labels (so the error-label will be the last element in <div class="controls"> )
                } else {
                    label.insertAfter(element); // standard behaviour
                }
            },
            // Make sure the form is submitted to the destination defined
            // in the "action" attribute of the form when valid
            submitHandler: function(form) {
                form.submit();
            }

        });
    });
</script>

<?php include "includes/footer.php"; ?>
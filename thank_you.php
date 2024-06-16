<?php include "includes/header.php"; ?>

<div class="vh-100 d-flex justify-content-center align-items-center">
    <div class="col-md-9">
        <div class="border border-3 border-success"></div>
        <div class="card  bg-white shadow p-5">
            <div class="mb-4 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="text-success" width="75" height="75" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                    <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z" />
                </svg>
            </div>
            <div class="text-center">
                <!-- <h1>Thank You !</h1>    -->
                <h2>Feedback Submitted Successfully !</h2>
                <p class="fs-5">Thank you for sharing your insights. Your inputs will help us make the magazine better. </p>
                <!-- <button class="btn btn-outline-success"><a href="./index.php" class="link-success link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover text-decoration-none">Back Home</a></button> -->
                <button class="btn btn-success"><a href="./index.php" class="link-light  text-decoration-none">Go Back </a></button>
            </div>
        </div>
    </div>
</div>

<?php
// if (isset($_GET['id'])) {
//     $id = $_GET['id'];
//     echo $id;
// }

?>

<script>
    $(document).ready(function() {
        console.log("thank you page ready!");
        const id = <?php echo $id; ?>;
        // console.log(id);
        // console.log(APPROOT);

        $.ajax({
            url: "./users/send_email.php",
            type: "GET",
            data: {
                id: id
            },
            success: function(response) {
                console.log(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });


        //   $('input[type=radio][name=answer_3]').change(function() {
        //     // console.log(this.value);
        //     if (this.value == 'yes') {
        //         $('#share_details').html('<textarea class="form-control" name="answer_3" id="question_3" placeholder="Kindly share the details ." rows="2"></textarea>');
        //     }
        //     else if (this.value == 'no') {
        //         $('#share_details').html('');
        //     }
        // });
    });
</script>

<?php include "includes/footer.php"; ?>
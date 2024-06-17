<?php include "../config/db_connect.php"; ?>
<?php include APPROOT . "/admin/includes/admin_header.php"; ?>
<?php
is_loggedIn();
?>

<h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>

<div class="table-responsive mt-2" id="feedbackTable">
    <table class="table table-hover table-striped table-bordered caption-top">
        <caption class="text-center fw-bold">List of Feedback of Users</caption>
        <thead class="table-dark">
            <tr>
                <th class="text-center" scope="col">ID</th>
                <th class="text-center" scope="col">Name</th>
                <th class="text-center" scope="col">Designation </th>
                <th class="text-center" scope="col">Company</th>
                <th class="text-center" scope="col">Phone</th>
                <th class="text-center" scope="col">Email</th>
                <th class="text-center" scope="col">Answer 1</th>
                <th class="text-center" scope="col">Answer 2</th>
                <th class="text-center" scope="col">Answer 3</th>
                <th class="text-center" scope="col">Answer 4</th>
                <th class="text-center" scope="col">Answer 5</th>
                <th class="text-center" scope="col">Answer 6</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">

            <?php
            $query = "SELECT * FROM feedback ORDER BY id DESC ";
            $stmt = $connection->prepare($query);
            $stmt->execute();
            $row_count = $stmt->rowCount();

            if ($row_count > 0) :

                $data = $stmt->fetchAll();

                foreach ($data as $key => $user) :

                    $answer_1 = strlen($user['answer_1']) > 20 ? substr($user['answer_1'], 0, 20) . "..." : $user['answer_1'];
            ?>
                    <tr>
                        <td class="text-center" scope="row"><?php echo $user['id']; ?></td>
                        <td class="text-center" scope="row"><?php echo $user['name']; ?></td>
                        <td class="text-center" scope="row"><?php echo $user['designation']; ?></td>
                        <td class="text-center" scope="row"><?php echo $user['company']; ?></td>
                        <td class="text-center" scope="row"><?php echo $user['phone']; ?></td>
                        <td class="text-center" scope="row"><?php echo $user['email']; ?></td>
                        <td class="text-center text-truncate" style="max-width: 150px;" scope="row"><?php echo $user['answer_1']; ?></td>
                        <td class="text-center text-truncate" style="max-width: 150px;" scope="row"><?php echo $user['answer_2']; ?></td>
                        <td class="text-center text-truncate" style="max-width: 150px;" scope="row"><?php echo $user['answer_3']; ?></td>
                        <td class="text-center text-truncate" style="max-width: 150px;" scope="row"><?php echo $user['answer_4']; ?></td>
                        <td class="text-center text-truncate" style="max-width: 150px;" scope="row"><?php echo $user['answer_5']; ?></td>
                        <td class="text-center text-truncate" style="max-width: 150px;" scope="row"><?php echo $user['answer_6']; ?></td>
                    </tr>
                <?php endforeach; ?>

            <?php else : echo ' <tr>
                                    <th>No User Data Available.</th>
                                </tr> ';
            ?>

            <?php endif; ?>

        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        // console.log('ready document index page');
        $('#feedbackTable td').on("dblclick", function() {

            $(this).toggleClass("text-truncate");

        });

    });
</script>

<?php include APPROOT . "/admin/includes/admin_footer.php"; ?>
<?php include "../config/db_connect.php"; ?>
<?php include APPROOT . "/admin/layouts/admin_header.php"; ?>
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

            // Determine the total number of records
            $sql = "SELECT COUNT(id) as count FROM feedback";
            $result = $connection->prepare($sql);
            $result->execute();
            $row = $result->fetchAll()[0];
            $total_records =  $row['count'];

            // Define how many results you want per page
            $results_per_page = 3;

            // Determine the total number of pages available
            $total_pages = ceil($total_records / $results_per_page);

            // Determine which page number visitor is currently on
            if (isset($_GET['page']) && is_numeric($_GET['page'])) {
                $page = (int)$_GET['page'];
            } else {
                $page = 1;
            }
            // Determine the SQL LIMIT starting number for the results on the displaying page
            $start_from = ($page - 1) * $results_per_page;

            // Retrieve the data
            // $sql = "SELECT id, name, email FROM users LIMIT $start_from, $results_per_page";
            // $result = $conn->query($sql);

            $query = "SELECT * FROM feedback ORDER BY id DESC LIMIT $start_from, $results_per_page";
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

    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center mt-5">
            <!-- Previous button -->
            <li class="page-item <?php if ($page <= 1) {
                                        echo 'disabled';
                                    } ?>">
                <a class="page-link" href="<?php if ($page <= 1) {
                                                echo '#';
                                            } else {
                                                echo "index.php?page=" . ($page - 1);
                                            } ?>">Previous</a>
            </li>

            <!-- Page number links -->
            <?php
            for ($i = 1; $i <= $total_pages; $i++) {
                echo "<li class='page-item";
                if ($i == $page) echo " active";
                echo "'><a class='page-link' href='index.php?page=" . $i . "'>" . $i . "</a></li>";
            }
            ?>

            <!-- Next button -->
            <li class="page-item <?php if ($page >= $total_pages) {
                                        echo 'disabled';
                                    } ?>">
                <a class="page-link" href="<?php if ($page >= $total_pages) {
                                                echo '#';
                                            } else {
                                                echo "index.php?page=" . ($page + 1);
                                            } ?>">Next</a>
            </li>
        </ul>
    </nav>
</div>

<script>
    $(document).ready(function() {
        // console.log('ready document index page');
        $('#feedbackTable td').on("dblclick", function() {

            $(this).toggleClass("text-truncate");

        });

    });
</script>

<?php include APPROOT . "/admin/layouts/admin_footer.php"; ?>
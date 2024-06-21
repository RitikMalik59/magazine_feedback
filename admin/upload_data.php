<?php include "../config/db_connect.php"; ?>
<?php include APPROOT . "/admin/layouts/admin_header.php"; ?>
<?php
is_loggedIn();
?>

<?php
// Get status message 
if (!empty($_SESSION['response'])) {
    $status = $_SESSION['response']['status'];
    $statusMsg = $_SESSION['response']['msg'];
    unset($_SESSION['response']);
}
?>

<!-- Display status message -->
<?php if (!empty($statusMsg)) { ?>
    <div class="col-xs-12">
        <div class="alert alert-<?php echo $status; ?>"><?php echo $statusMsg; ?></div>
    </div>
<?php } ?>

<div class="row ">
    <div class="row d-flex justify-content-between mb-3">

        <!-- Import link -->

        <div class="col">
            <p>
                <b>NOTE: CSV format separated by comma (,) only are accepted ! </b><br>
                <b> Eg :</b>"Ritik Malik","Web Developer","Vis Group","1234567890","example@gmail.com"
            </p>
        </div>
        <div class="col-md-3">
            <div class="float-end">
                <a href="javascript:void(0);" class="btn btn-primary" onclick="formToggle('importFrm');"><i class="bi bi-plus-square-dotted"></i> Import</a>
            </div>
        </div>
    </div>

    <!-- <div class="col-md-12 mb-3 head">
        <div class="float-end">
            <h5>CSV format only</h5>
            <a href="javascript:void(0);" class="btn btn-primary" onclick="formToggle('importFrm');"><i class="bi bi-plus-square-dotted"></i> Import</a>
        </div>
    </div> -->
    <!-- CSV file upload form -->
    <div class="col-md-12" id="importFrm" style="display: none;">
        <form action="./includes/import_data.php" method="post" class="row g-2 float-end border border-primary mb-3" enctype="multipart/form-data">
            <div class="col-auto">
                <input type="file" name="file" class="form-control" required />
                <!-- Link to download sample format -->
                <!-- <p class="text-start mb-0 mt-2">
                    <a href="sample-csv-members.csv" class="link-primary" download>Download Sample Format</a>
                </p> -->
            </div>
            <div class="col-auto">
                <input type="submit" class="btn btn-success mb-3" name="importSubmit" value=" Import CSV">
            </div>

        </form>
    </div>

    <!-- Data list table -->
    <div class="table-responsive px-4">
        <table class="table table-striped table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Designation</th>
                    <th>Company</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Email Progress</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Determine the total number of records
                $sql = "SELECT COUNT(id) as count FROM old_records";
                $result = $connection->prepare($sql);
                $result->execute();
                $row = $result->fetchAll()[0];
                $total_records =  $row['count'];

                // Define how many results you want per page
                $results_per_page = 50;

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
                // Fetch member records from database 
                $query = "SELECT * FROM old_records ORDER BY id DESC LIMIT $start_from, $results_per_page";
                $stmt = $connection->prepare($query);
                $stmt->execute();
                $row_count = $stmt->rowCount();
                if ($row_count > 0) {
                    $data = $stmt->fetchAll();
                    foreach ($data as $key => $user) {
                ?>
                        <tr>
                            <td><?php echo '#' . $user['id']; ?></td>
                            <td><?php echo $user['name']; ?></td>
                            <td><?php echo $user['designation']; ?></td>
                            <td><?php echo $user['company']; ?></td>
                            <td><?php echo $user['phone']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td><?php echo ($user['is_email_sent'] == 0) ? 'Waiting' : 'Sent'; ?></td>
                        </tr>
                    <?php }
                } else { ?>
                    <tr>
                        <td colspan="5">No User(s) found...</td>
                    </tr>
                <?php } ?>
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
                                                    echo "upload_data.php?page=" . ($page - 1);
                                                } ?>">Previous</a>
                </li>

                <!-- Page number links -->
                <?php
                for ($i = 1; $i <= $total_pages; $i++) {
                    echo "<li class='page-item";
                    if ($i == $page) echo " active";
                    echo "'><a class='page-link' href='upload_data.php?page=" . $i . "'>" . $i . "</a></li>";
                }
                ?>

                <!-- Next button -->
                <li class="page-item <?php if ($page >= $total_pages) {
                                            echo 'disabled';
                                        } ?>">
                    <a class="page-link" href="<?php if ($page >= $total_pages) {
                                                    echo '#';
                                                } else {
                                                    echo "upload_data.php?page=" . ($page + 1);
                                                } ?>">Next</a>
                </li>
            </ul>
        </nav>
    </div>
</div>

<!-- Show/hide CSV upload form -->
<script>
    $(document).ready(function() {
        console.log('document ready upload data page');
    });

    function formToggle(ID) {
        var element = document.getElementById(ID);
        if (element.style.display === "none") {
            element.style.display = "block";
        } else {
            element.style.display = "none";
        }
    }
</script>


<?php include APPROOT . "/admin/layouts/admin_footer.php"; ?>
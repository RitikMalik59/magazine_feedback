<?php include "../config/db_connect.php"; ?>
<?php include APPROOT . "/admin/includes/admin_header.php"; ?>
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

        <div class="float-start">
            <a href="javascript:void(0);" class="btn btn-primary" onclick="formToggle('importFrm');"><i class="bi bi-plus-square-dotted"></i> Import</a>
        </div>
        <div class="float-end">
            <h5>CSV format only</h5>
            <a href="javascript:void(0);" class="btn btn-primary" onclick="formToggle('importFrm');"><i class="bi bi-plus-square-dotted"></i> Import</a>
        </div>
    </div> -->
    <!-- CSV file upload form -->
    <div class="col-md-12" id="importFrm" style="display: none;">
        <form action="./includes/import_data.php" method="post" class="row g-2 float-end border border-primary mb-3" enctype="multipart/form-data">
            <div class="col-auto">
                <!-- <input type="file" name="file" class="form-control" /> -->
                <input type="file" name="file" class="form-control" required />
                <!-- <label for="formFile" class="form-label">Default file input example</label> -->
                <!-- <input class="form-control" type="file" name="file" id="formFile"> -->

                <!-- Link to download sample format -->
                <p class="text-start mb-0 mt-2">
                    <a href="sample-csv-members.csv" class="link-primary" download>Download Sample Format</a>
                </p>
            </div>
            <div class="col-auto">
                <!-- <div class="mb-3">
                    <label for="formFile" class="form-label">Default file input example</label>
                    <input class="form-control" type="file" name="csv" id="formFile">
                </div> -->

                <input type="submit" class="btn btn-success mb-3" name="importSubmit" value=" Import CSV">
            </div>
            <!-- <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="submit" value="Upload Image" name="submit"> -->
        </form>
    </div>

    <!-- Data list table -->
    <table class="table table-striped table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Designation</th>
                <th>Company</th>
                <th>Phone</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch member records from database 
            // $result = $db->query("SELECT * FROM old_records ORDER BY id DESC");
            $query = "SELECT * FROM old_records ORDER BY id DESC";
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
                    </tr>
                <?php }
            } else { ?>
                <tr>
                    <td colspan="5">No User(s) found...</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- Show/hide CSV upload form -->
<script>
    $(document).ready(function() {

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

<script>
    $(document).ready(function() {
        console.log('document ready');
    });
</script>

<?php include APPROOT . "/admin/includes/admin_footer.php"; ?>
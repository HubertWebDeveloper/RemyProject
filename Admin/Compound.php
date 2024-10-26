<?php include("includes/header.php") ?>

<?php
if (isset($_SESSION["success"])) {
    ?>
    <script type="text/javascript">
        alertify.set('notifier', 'position', 'top-right');
        alertify.success('<?= $_SESSION["success"] ?>');
    </script>
    <?php
    // Clear the session message after displaying it
    unset($_SESSION["success"]);
}
// Danger message
if (isset($_SESSION["danger"])) {
    ?>
    <script type="text/javascript">
        alertify.set('notifier', 'position', 'top-right');
        alertify.error('<?= $_SESSION["danger"] ?>');
    </script>
    <?php
    unset($_SESSION["danger"]);
}
// Warning message
if (isset($_SESSION["warning"])) {
    ?>
    <script type="text/javascript">
        alertify.set('notifier', 'position', 'top-right');
        alertify.warning('<?= $_SESSION["warning"] ?>');
    </script>
    <?php
    unset($_SESSION["warning"]);
}
?>

<div class="card-header">
    <button class="btn" style="background:#3b5d50;color:white" data-bs-toggle="modal" data-bs-target="#exampleModal">Adding Compound</button>
</div>
<form action="EditCode.php" method="POST">
    <div class="d-flex justify-content-end">
        <button type="submit" name="editSelectedComp" class="btn btn-warning me-2">Edit Comp</button>
        <button type="submit" name="deleteSelectedComp" class="btn btn-danger">Delete Comp</button>
    </div>
    <div class="card-body mt-2 mb-4 border" style="padding:0 20px">
        <?php
            $admins = mysqli_query($con, "SELECT * FROM `compound` ORDER BY  id DESC");
            $i=0;
        ?>
        <div class="table-responsive">
            <table id="myTable_customer" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th style="position: sticky; left: 0; z-index: 1; background-color: white;"></th>
                        <th style="position: sticky; left: 40px; z-index: 1; background-color: white;">ID</th>
                        <th>Name</th>
                        <th>L.Contact</th>
                        <th>C.Contact</th>
                        <th>Location</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($admins as $admin) : $i++; $id = $admin['id'];
                    ?>
                    <tr>
                        <td style="position: sticky; left: 0; background-color: white;"><input type="checkbox" name="selected[]" value="<?= $admin['id'] ?>" class="row-select" onchange="toggleEditable(this)"></td>
                        <td style="position: sticky; left: 40px; background-color: white;"><?= $i ?></td>
                        <td><b style="display:none"><?= $admin['name'] ?></b><input type="text" name="name[<?= $admin['id'] ?>]" value="<?= $admin['name'] ?>" class="form-control" style="width:150px" readonly></td>
                        <td><b style="display:none"><?= $admin['l_contact'] ?></b><input type="text" name="lcontact[<?= $admin['id'] ?>]" value="<?= $admin['l_contact'] ?>" class="form-control" style="width:150px" readonly></td>
                        <td><b style="display:none"><?= $admin['c_contact'] ?></b><input type="text" name="ccontact[<?= $admin['id'] ?>]" value="<?= $admin['c_contact'] ?>" class="form-control" style="width:150px" readonly></td>
                        <td><b style="display:none"><?= $admin['location'] ?></b><input type="text" name="location[<?= $admin['id'] ?>]" value="<?= $admin['location'] ?>" class="form-control" style="width:200px" readonly></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</form>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Adding Compound</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid px-4 mb-4">
                    <form action="EditCode.php" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="inputGroupSelect02">Name</label>
                                    <input type="text" name="name" placeholder="Name" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="inputGroupSelect02">L.Contact</label>
                                    <input type="phone" name="lcontact" placeholder="landloard phone" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="inputGroupSelect02">C.Contact</label>
                                    <input type="phone" name="ccontact" placeholder="CareTake phone" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="inputGroupSelect02">Location</label>
                                    <input type="text" name="location" placeholder="Location" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="cardCompBtn" class="btn" style="background:#3b5d50;color:white">Save Compound</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function toggleEditable(checkbox) {
        let row = checkbox.closest('tr');
        let inputs = row.querySelectorAll('input[type="text"]');

        inputs.forEach(function(input) {
            if (checkbox.checked) {
                input.removeAttribute('readonly');  // Make the input editable
            } else {
                input.setAttribute('readonly', 'readonly');  // Make the input read-only
            }
        });
    }
</script>
<?php include("includes/footer.php") ?>
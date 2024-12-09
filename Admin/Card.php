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
    <button class="btn" style="background:#3b5d50;color:white" data-bs-toggle="modal" data-bs-target="#exampleModal">Adding New Card</button>
</div>
<form action="EditCode.php" method="POST">
    <div class="d-flex justify-content-end">
        <button type="submit" name="editSelected" class="btn btn-warning me-2">Edit Card</button>
        <button type="submit" name="postSelected" class="btn btn-success me-2">Post Card</button>
        <button type="submit" name="unpostSelected" class="btn btn-secondary me-2">Unpost Card</button>
        <button type="submit" name="deleteSelected" class="btn btn-danger">Delete Card</button>
    </div>
    <div class="card-body mt-2 mb-4 border" style="padding:0 20px">
        <?php
            $admins = mysqli_query($con, "SELECT * FROM `cards` ORDER BY  id DESC");
            $comps = mysqli_query($con, "SELECT * FROM `compound`");
            $i=0;
        ?>
        <div class="table-responsive">
            <table id="myTable_customer" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th style="position: sticky; left: 0; z-index: 1; background-color: white;"></th>
                        <th style="position: sticky; left: 40px; z-index: 1; background-color: white;">ID</th>
                        <th style="position: sticky; left: 80px; z-index: 1; background-color: white;">Status</th>
                        <th>Title</th>
                        <th>New_price</th>
                        <th>Old_price</th>
                        <th>Description</th>
                        <th>Location</th>
                        <th>Category</th>
                        <th>Compound</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($admins as $admin) : $i++; $id = $admin['id']; $status=$admin['status']; ?>
                    <tr>
                        <td style="position: sticky; left: 0; background-color: white;"><input type="checkbox" name="selected[]" value="<?= $admin['id'] ?>" class="row-select" onchange="toggleEditable(this)"></td>
                        <td style="position: sticky; left: 40px; background-color: white;"><?= $i ?> | <?= $id ?></td>
                        <td style="position: sticky; left: 80px; background-color: white;">
                            <?php
                            if($status=="Posted"){
                                echo "<label style='border-radius:4px;color:white;padding:5px 7px;background:green'>$status</label>";
                            }else{
                                echo "<label style='border-radius:4px;color:white;padding:5px 7px;background:red'>$status</label>";
                            }
                            ?>
                        </td>
                        <td><b style="display:none"><?= $admin['title'] ?></b><input type="text" name="title[<?= $admin['id'] ?>]" value="<?= $admin['title'] ?>" class="form-control" style="width:250px" readonly></td>
                        <td><input type="text" name="new_price[<?= $admin['id'] ?>]" value="<?= $admin['new_price'] ?>" class="form-control" style="width:100px" readonly></td>
                        <td><input type="text" name="old_price[<?= $admin['id'] ?>]" value="<?= $admin['old_price'] ?>" class="form-control" style="width:100px" readonly></td>
                        <td><input type="text" name="description[<?= $admin['id'] ?>]" value="<?= $admin['description'] ?>" class="form-control" style="width:350px" readonly></td>
                        <td><input type="text" name="location[<?= $admin['id'] ?>]" value="<?= $admin['location'] ?>" class="form-control" style="width:350px" readonly></td>
                        <td><?= $admin['category'] ?></td>
                        <td><?= $admin['compound'] ?></td>
                        <td><?= $admin['date'] ?></td>
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
                <h1 class="modal-title fs-5" id="exampleModalLabel">Adding New Card</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid px-4 mb-4">
                    <form action="EditCode.php" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="inputGroupSelect02">Title</label>
                                    <input type="text" name="title" placeholder="Card Title" class="form-control" required>
                                </div>
                            </div>
                            <!-- <div class="col-md-6 mb-3">
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="inputGroupSelect01">Compaund</label>
                                    <select name="category" class="form-select" id="inputGroupSelect01" required>
                                        <option value="ui/ux">UI/UX Design</option>
                                        <option value="logo">Logo Design</option>
                                        <option value="graphics">Graphics Design</option>
                                    </select>
                                </div>
                            </div> -->
                            <div class="col-md-6 mb-3">
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="inputGroupSelect02">Location</label>
                                    <input type="text" name="location" placeholder="Location..." class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="inputGroupSelect02">New Price</label>
                                    <input type="number" name="newPrice" placeholder="New Price" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="inputGroupSelect02">Old Price</label>
                                    <input type="number" name="oldPrice" placeholder="Old Price" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="input-group">
                                    <span class="input-group-text">Category</span>
                                    <select name="category" class="form-select" id="inputGroupSelect01" required>
                                       <option value="rent">Vacant House</option>
                                       <option value="B&B">Vacant B&Bs</option>
                                       <option value="Car">Car Rents</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="input-group">
                                    <span class="input-group-text">Compound</span>
                                    <select name="comp" class="form-select" id="inputGroupSelect01" required>
                                        <option value="">--Select--</option>
                                        <?php foreach($comps as $comp) : $id = $comp['id']; ?>
                                        <option value="<?php echo $id ?>"><?= $comp['name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="input-group">
                                    <span class="input-group-text">Description</span>
                                    <textarea class="form-control" name="desc" placeholder="1 bedroom, kitchen, worshroom" aria-label="With textarea" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="cardBtn" class="btn" style="background:#3b5d50;color:white">Save Card</button>
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
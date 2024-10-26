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
    <button class="btn" style="background:#3b5d50;color:white" data-bs-toggle="modal" data-bs-target="#exampleModal">Adding Card Images</button>
</div>
<form action="EditCode.php" method="POST">
    <div class="d-flex justify-content-end">
        <button type="submit" name="deleteSelectedImage" class="btn btn-danger">Delete Card</button>
    </div>
    <div class="card-body mt-2 mb-4 border" style="padding:0 20px">
        <?php
            $admins = mysqli_query($con, "SELECT * FROM `card_images` ORDER BY  id DESC");
            $cards = mysqli_query($con, "SELECT * FROM `cards`");
            $i=0;
        ?>
        <div class="table-responsive">
            <table id="myTable_customer" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th style="position: sticky; left: 0; z-index: 1; background-color: white;"></th>
                        <th style="position: sticky; left: 40px; z-index: 1; background-color: white;">ID</th>
                        <th>Card_ID</th>
                        <th>Images</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($admins as $admin) : $i++; $id = $admin['id']; 
                        $check = mysqli_query($con, "SELECT c.* FROM `card_images` ci JOIN `cards` c ON ci.card_id = c.id WHERE ci.id='$id'");
                        $rowData = mysqli_fetch_assoc($check);
                    ?>
                    <tr>
                        <td style="position: sticky; left: 0; background-color: white;"><input type="checkbox" name="selected[]" value="<?= $admin['id'] ?>" class="row-select" onchange="toggleEditable(this)"></td>
                        <td style="position: sticky; left: 40px; background-color: white;"><?= $i ?></td>
                        <td><?= $admin['card_id'] ?> | <?= $rowData['title'] ?></td>
                        <td>
                            <?php
                            foreach(json_decode($admin['image']) as $image) :
                            ?>
                            <img src="cardImages/<?= $image ?>" style="width:60px;height:60px;border-radius:10px">
                            <?php endforeach; ?>
                        </td>
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
                <h1 class="modal-title fs-5" id="exampleModalLabel">Adding Card Images</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid px-4 mb-4">
                    <form action="EditCode.php" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="inputGroupSelect01">Card ID</label>
                                    <select name="card_id" class="form-select" id="inputGroupSelect01" required>
                                        <?php foreach($cards as $card) : $id = $card['id']; ?>
                                        <option value="<?php $id ?>"><?= $card['title'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="input-group mb-3">
                                    <input type="file" name="fileImg[]" class="form-control" accept=".jpg, .jpeg, .png" required multiple>
                                    <label class="input-group-text" for="inputGroupSelect02">Upload Images</label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="cardImgBtn" class="btn" style="background:#3b5d50;color:white">Save Card Images</button>
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
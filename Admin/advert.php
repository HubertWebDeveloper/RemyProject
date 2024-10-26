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
    <button class="btn" style="background:#3b5d50;color:white" data-bs-toggle="modal" data-bs-target="#exampleModal">Adding New Advert</button>
</div>
<form action="EditCode.php" method="POST">
    <div class="d-flex justify-content-end">
        <button type="submit" name="postSelectedAdert" class="btn btn-success me-2">Post Again</button>
        <button type="submit" name="unpostSelectedAdert" class="btn btn-secondary me-2">Unpost Immediately</button>
        <button type="submit" name="deleteSelectedAdert" class="btn btn-danger">Delete Advert</button>
    </div>
    <div class="card-body mt-2 mb-4 border" style="padding:0 20px">
        <?php
            $admins = mysqli_query($con, "SELECT * FROM `advert` ORDER BY  id DESC");
            $compounds = mysqli_query($con, "SELECT * FROM `compound`");
            $i=0;
        ?>
        <div class="table-responsive">
            <table id="myTable_customer" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th style="position: sticky; left: 0; z-index: 1; background-color: white;"></th>
                        <th style="position: sticky; left: 40px; z-index: 1; background-color: white;">ID</th>
                        <th style="position: sticky; left: 80px; z-index: 1; background-color: white;">Status</th>
                        <th>Compound</th>
                        <th>video</th>
                        <th>Published_Date</th>
                        <th>End_Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($admins as $admin) : $i++; $id = $admin['id'];
                    $status = $admin['status'];
                    $publishedDate = new DateTime($admin['published_date']);
                    $endDate = new DateTime($admin['end_date']);
                    $currentDate = new DateTime();
                        if ($currentDate >= $publishedDate && $currentDate <= $endDate) {
                            $status = "Posted"; // Set status to Posted
                        } elseif ($currentDate < $publishedDate) {
                            $status = "Waiting..."; // Set status to Waiting
                        } elseif ($currentDate > $endDate) {
                            $status = "Done"; // Set status to Done
                        } else {
                            $status = "Unposted"; // Default status if none of the conditions match
                        }
                     ?>
                    <tr>
                        <td style="position: sticky; left: 0; background-color: white;"><input type="checkbox" name="selected[]" value="<?= $admin['id'] ?>" class="row-select" onchange="toggleEditable(this)"></td>
                        <td style="position: sticky; left: 40px; background-color: white;"><?= $i ?></td>
                        <td style="position: sticky; left: 80px; background-color: white;">
                            <?php
                            if($status=="Posted"){
                                echo "<label style='border-radius:4px;color:white;padding:5px 7px;background:green'>$status</label>";
                            }else if($status=="Waiting..."){
                                echo "<label style='border-radius:4px;color:white;padding:5px 7px;background:orange'>$status</label>";
                            }else if($status=="Done"){
                                echo "<label style='border-radius:4px;color:white;padding:5px 7px;background:grey'>$status</label>";
                            }else{
                                echo "<label style='border-radius:4px;color:white;padding:5px 7px;background:red'>$status</label>";
                            }
                            ?>
                        </td>
                        <td><?= $admin['compound'] ?></td>
                        <td><?= $admin['video'] ?></td>
                        <td><?= $admin['published_date'] ?></td>
                        <td><?= $admin['end_date'] ?></td>
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
                <h1 class="modal-title fs-5" id="exampleModalLabel">Adding Card Advert</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid px-4 mb-4">
                    <form action="EditCode.php" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="inputGroupSelect01">Compound</label>
                                    <select name="compound" class="form-select" id="inputGroupSelect01" required>
                                        <?php foreach($compounds as $compound) : $id = $compound['id']; ?>
                                        <option value="<?php $id ?>"><?= $compound['name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="input-group mb-3">
                                    <input type="file" name="video" class="form-control" accept=".mp4" required>
                                    <label class="input-group-text" for="inputGroupSelect02">Upload Video</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="inputGroupSelect02">Publish Date</label>
                                    <input type="date" name="publishedDate" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="inputGroupSelect02">End Date</label>
                                    <input type="date" name="endDate" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="AdvertBtn" class="btn" style="background:#3b5d50;color:white">Save Advert</button>
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
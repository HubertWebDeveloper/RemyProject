<div class="card-body mt-2 mb-4 border" style="padding:0 20px">
    <?php
        $admins = mysqli_query($con, "SELECT * FROM `comments` ORDER BY  id DESC");
        $i=0;
    ?>
    <form action="EditCode.php" method="POST">
        <div class="d-flex justify-content-end mb-2">
            <button type="submit" name="postSelectedCmment" class="btn btn-success me-2">Post Comment</button>
            <button type="submit" name="unpostSelectedComment" class="btn btn-secondary me-2">Unpost Comment</button>
        </div>
        <div class="table-responsive">
            <table id="myTable_customer" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th style="position: sticky; left: 0; z-index: 1; background-color: white;"></th>
                        <th style="position: sticky; left: 40px; z-index: 1; background-color: white;">ID</th>
                        <th style="position: sticky; left: 100px; z-index: 1; background-color: white;">Status</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Message</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($admins as $admin) : $i++; $id = $admin['id']; $status=$admin['status']; ?>
                    <tr>
                    <td style="position: sticky; left: 0; background-color: white;"><input type="checkbox" name="selected[]" value="<?= $admin['id'] ?>" class="row-select" onchange="toggleEditable(this)"></td>
                    <td style="position: sticky; left: 40px; background-color: white;"><?= $i ?></td>
                        <td style="position: sticky; left: 100px; background-color: white;">
                            <?php
                            if($status=="Posted"){
                                echo "<label style='border-radius:4px;color:white;padding:5px 7px;background:green'>$status</label>";
                            }else{
                                echo "<label style='border-radius:4px;color:white;padding:5px 7px;background:red'>$status</label>";
                            }
                            ?>
                        </td>
                        <td><?= $admin['name'] ?></td>
                        <td><?= $admin['email'] ?></td>
                        <td><?= $admin['comment'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </form>
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
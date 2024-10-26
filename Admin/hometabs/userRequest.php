<div class="card-body mt-2 mb-4 border" style="padding:0 20px">
    <?php
        $admins = mysqli_query($con, "SELECT * FROM `userrequest` ORDER BY  id DESC");
        $i=0;
    ?>
    <form action="EditCode.php" method="POST">
        <div class="d-flex justify-content-end mb-2">
            <button type="submit" name="SelectedRequestPaid" class="btn btn-success me-2">Set Status Paid</button>
            <button type="submit" name="SelectedRequestUnpiad" class="btn btn-secondary me-2">Set Status Unpaid</button>
        </div>
        <div class="table-responsive">
            <table id="myTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th style="position: sticky; left: 0; z-index: 1; background-color: white;"></th>
                        <th style="position: sticky; left: 40px; z-index: 1; background-color: white;">ID</th>
                        <th style="position: sticky; left: 80px; z-index: 1; background-color: white;">Status</th>
                        <th>Email</th>
                        <th>Phone</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($admins as $admin) : $i++; $id = $admin['id']; $status=$admin['status']; ?>
                    <tr>
                    <td style="position: sticky; left: 0; background-color: white;"><input type="checkbox" name="selected[]" value="<?= $admin['id'] ?>" class="row-select" onchange="toggleEditable(this)"></td>
                    <td style="position: sticky; left: 40px; background-color: white;"><?= $i ?></td>
                        <td style="position: sticky; left: 80px; background-color: white;">
                            <?php
                            if($status=="Paid"){
                                echo "<label style='border-radius:4px;color:white;padding:5px 7px;background:green'>$status</label>";
                            }else{
                                echo "<label style='border-radius:4px;color:white;padding:5px 7px;background:red'>$status</label>";
                            }
                            ?>
                        </td>
                        <td><?= $admin['email'] ?></td>
                        <td><?= $admin['phone'] ?></td>
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
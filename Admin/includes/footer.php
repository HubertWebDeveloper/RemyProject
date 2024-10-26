</div>
</div>
</div>
</div>
<script src="vendors/base/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <script src="vendors/datatables.net/jquery.dataTables.js"></script>
  <script src="vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="js/dashboard.js"></script>
  <script src="js/data-table.js"></script>
  <script src="js/jquery.dataTables.js"></script>
  <script src="js/dataTables.bootstrap4.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
  <script>
    $(document).ready(function() {
        $(".MyTextarea").summernote({
            height: 250,
            display: none
        });
        $(".MyText").summernote({
            height: 100
        });
        $(".largeText").summernote({
            height: 550
        });
        $('.dropdown-toggle').dropdown();
    });
    $(document).ready(function() {
    $('.mySelect2').select2();
    });
    $(document).ready( function () {
      $('#myTable').DataTable();
    });$(document).ready( function () {
      $('#myTable_customer').DataTable();
    });$(document).ready( function () {
      $('#myTable_categ').DataTable();
    });$(document).ready( function () {
      $('#myTable_prod').DataTable();
    });
    // =============== allow to use multiple input ===============
    
  </script>
</body>

</html>


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
<style>
    .box a{
      text-decoration:none;
    }
</style>
<div class="row shadow" style="background:#3b5d50;padding:20px">
    <div class="col-md-5 text-end">
        <img src="logo.png" style="margin-top:-10px;width:70%;height:150px;mix-blend-mode:multiply">
    </div>
    <div class="col-md-6">
      <h4 class="text-light">Welcome to the Vacant House</h4>
      <p class="text-light">This house has been left untouched for years, showing signs of abandonment. 
            The windows are dark, the yard is overgrown, and no one has lived here for a long time. 
            Its eerie silence and neglected exterior tell a story of time passing without care or attention.</p>
    </div>
</div>


<ul class="nav nav-tabs mt-4" id="myTab" role="tablist">
  <li class="nav-item" role="presentation">
    <button type="button" class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">
        New User Request
    </button>
  </li>
  <li class="nav-item" role="presentation">
    <button type="button" class="nav-link" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">
        User Comments <span class="badge text-secondary" style="font-size:18px">00</span>
    </button>
  </li>
</ul>

<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
    <?php include("hometabs/userRequest.php") ?>
  </div>
  <div class="tab-pane fade" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
    <?php include("hometabs/userComments.php") ?>
  </div>
</div>
       
<?php include("includes/footer.php") ?>
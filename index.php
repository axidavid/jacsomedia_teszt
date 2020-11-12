<?php
  require_once("header.html");
  session_start();
  if(isset($_SESSION["userid"]) && $_SESSION["userid"] == 1)
  {
    header("Location: mpaf.php");
  }
?>
<div class="text-center mt-5">
  <div class="text-left">
    <form class="form-signin" action="login.php" method="post">
      <p class="form-text">Please sign in</p>
      <p class="form-text">User name:</p>
      <input type="text" name="username" style="width:100%" required autofocus>
      <p class="form-text" style="padding-top: 1em;">Password:</p>
      <input type="password" name="password"  style="width:100%" required>
      <div class="text-center">
        <button type="submit" class="form-enter-button mt-3">ENTER</button>
      </div>
    </form>
  </div>
  <?php
    if(isset($_GET["error"]))
    {
      echo '<p class="form-error-text mt-4">Your username or password was incorrect.</p>
      <p class="form-error-text">Please try it again.</p>';
    }
  ?>
</div>
<script>
  $('a[href$="index.php"]').addClass("header-text-active");
</script>
<?php
  require_once("footer.html")
?>
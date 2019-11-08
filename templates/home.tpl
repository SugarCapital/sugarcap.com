<div class="container">
  <div class="py-4">
    <div class="text-center mb-4">
        <a href="https://www.instagram.com/sugarcapital/following/"><img src="/imgs/icon-blue.png" height="300" width="auto" /></a>
      </div>
    <h1 class='text-serif p-3'>Sugar Capital invests in innovative companies with mass appeal that strive to simplify and elevate everyday life.</h1>

    <p class='text-serif'>
      If this sounds like you, <a class="" href="mailto:contact@sugarcap.com">email us</a>.
    </p>
  </div>
  <div class="mt-4">
    <h1>Companies</h1>
  </div>
  <div class="d-flex flex-wrap">

    <?php foreach ($companies as $company) { ?>
      <div class="text-sans-serif company-logo text-center m-1 m-lg-4">
        <a href="<?= $company['link'] ?>" class="" style="background-image:url('<?= $company['img'] ?>')"></a>
        <?= $company['name'] ?>
      </div>
    <?php } ?>

  </div>
</div>

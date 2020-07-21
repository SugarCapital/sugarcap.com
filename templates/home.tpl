<div class="bg-primary">
  <div class="container py-4">
    <div class="py-4">
    <div class="py-4"></div>
      <div class="pt-4 my-4">
        <a href="https://www.instagram.com/sugarcapital/following/"><img src="/imgs/sugar-capital-red.png" width="300" width="auto" /></a>
      </div>

      <h1 class='text-display text-white pt-4 py-2 pb-4'>A Venture Capital Firm</h1>
      <h2 class='text-serif text-white pb-1'>Sugar Capital invests in smart companies that seek to elevate everyday life.</h2>
    </div>
    <div class="py-4"></div>
    <div class="py-4"></div>
  </div>
</div>
<div class="bg-tertiary py-4">
  <div class="container">
    <div class="text-secondary">
      <h3>Companies</h3>
    </div>
    <div class="d-flex flex-wrap">
      <?php foreach ($companies as $company) { ?>
        <div class="text-sans-serif company-logo text-center m-1 m-lg-4">
          <a href="<?= $company['link'] ?>" class="">
            <div  class="icon" style="background-image:url('<?= $company['img'] ?>')"></div>
            <div class="text-center pt-2 text-primary"><?= $company['name'] ?></div>
          </a>
        </div>
      <?php } ?>
    </div>
  </div>
</div>
<div class="py-4 text-left bg-secondary">
  <div class="container">
    <p class='text-serif text-white'>
      If this sounds like you, <a class="text-white" href="mailto:contact@sugarcap.com">email us</a>.
    </p>
  </div>
</div>

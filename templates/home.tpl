<div class="container">
  <div class="py-4">
    <div class="text-center mb-4">
        <a href="https://www.instagram.com/sugarcapital/following/"><img src="/imgs/icon-blue.png" height="300" width="auto" /></a>
      </div>
    <h1 class='text-serif'>Sugar Capital invests in innovative companies that push the mainstream forward.</h1>
    <p class='mt-4 text-serif'>We believe the future of innovation should be practical, approachable and designed to serve more types of people. We seek companies with mass appeal that strive to simplify and elevate everyday life.</p>
    <p class='text-serif'>We help prepare them for massive growth through capital and a wealth of knowledge and expertise on brand and consumer behavior. Because companies that serve more people aren’t just better for business, they’re better for the world.</p>
    <p class='text-serif'>
      Consumers today gravitate to a new breed of companies that use technology and design to deliver a better brand experience.
    </p>
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

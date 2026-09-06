<?php
/**
 * Template Part: Client & Partner Logos Ticker
 */

$logos = array(
    'ASU.webp'              => 'ASU Logo',
    'CCL.webp'              => 'CCL Logo',
    'glidepath.webp'        => 'Glidepath Logo',
    'E2.webp'               => 'E2 Logo',
    'CEFA.webp'             => 'CEFA Logo',
    'edf-logo-updated.webp' => 'EDF Logo',
    'Guggenhjeim.webp'      => 'Guggenheim Logo',
    'IAA.webp'              => 'IAA Logo',
    'MPT.webp'              => 'MPT Logo',
    'NATO.webp'             => 'NATO Logo',
    'Northampton.webp'      => 'Northampton Logo',
    'pse.webp'              => 'PSE Logo',
    'sierra-club.webp'      => 'Sierra Club Logo',
    'gevo.webp'             => 'Gevo Logo',
    'TFOC.webp'             => 'TFOC Logo',
    'TiltGlobal.webp'       => 'Tilt Global Logo',
    'WHRO.webp'             => 'WHRO Logo',
    'Fordhamlogo.webp'      => 'Fordham Logo',
    'ccs-logo.webp'         => 'CCS Logo',
    'asp-logo.webp'         => 'ASP Logo',
);
?>
<section class="client-logos-section">
  <div class="container text-center" style="margin-bottom: 20px;">
    <span class="section-tag" style="letter-spacing: 2px;">TRUSTED BY LEADING ORGANIZATIONS & COALITIONS</span>
  </div>

  <div class="logo-carousel-wrapper">
    <div class="logo-carousel-track">
      <?php foreach ( $logos as $file => $alt ) : ?>
        <div class="logo-slide"><img src="<?php echo rs_asset( 'logos/' . $file ); ?>" alt="<?php echo esc_attr( $alt ); ?>" loading="lazy" decoding="async" height="48" /></div>
      <?php endforeach; ?>
      <?php foreach ( $logos as $file => $alt ) : ?>
        <div class="logo-slide"><img src="<?php echo rs_asset( 'logos/' . $file ); ?>" alt="<?php echo esc_attr( $alt ); ?>" loading="lazy" decoding="async" height="48" /></div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

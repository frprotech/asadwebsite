<?php
/**
 * Template Name: About Page
 */

get_header();

$pid          = get_the_ID();
$badge        = rs_get_field( 'hero_badge_text', $pid, 'STRATEGIC COMMUNICATIONS & DOCUMENTARY FILM' );
$title_line1  = rs_get_field( 'hero_title_line1', $pid, "Solutions to humanity's greatest challenges" );
$title_line2  = rs_get_field( 'hero_title_line2', $pid, 'start with strong narrative foundations.' );
$subtitle     = rs_get_field( 'hero_subtitle', $pid, 'Strategic communications advisor and award-winning documentary filmmaker helping organizations build durable narrative infrastructure, unite diverse stakeholders, and accelerate systemic change.' );

$default_stats = array(
    array( 'number' => '30+', 'label' => 'Years Experience' ),
    array( 'number' => 'Founder', 'label' => 'American Resilience Project' ),
    array( 'number' => 'Stanford & Hopkins', 'label' => 'Academic Foundation' ),
    array( 'number' => 'Bipartisan', 'label' => 'Policy Advancements' ),
);
$trust_stats = rs_get_stats( $pid, $default_stats );

// Chapter 01
$c1_tag       = rs_get_field( 'chapter1_tag', $pid, 'CHAPTER 01 • THE MISSION' );
$c1_line1     = rs_get_field( 'chapter1_line1', $pid, 'Three Decades of Uniting Stakeholders' );
$c1_line2     = rs_get_field( 'chapter1_line2', $pid, 'Through Narrative Strategy' );
$c1_lead      = rs_get_field( 'chapter1_lead', $pid, 'As founder of the American Resilience Project (ARP), Roger has spent over 30 years pioneering narrative strategies that unite disparate stakeholders around shared solutions.' );
$c1_story1    = rs_get_field( 'chapter1_story1', $pid, 'In an era of acute polarization and communication fatigue, high-stakes organizations often struggle to translate complex science, energy policy, and national security data into narratives that resonate. Roger bridges this gap by discovering the underlying human truths that move people from skepticism to consensus.' );
$c1_stat_num  = rs_get_field( 'chapter1_stat_num', $pid, '800+' );
$c1_stat_desc = rs_get_field( 'chapter1_stat_desc', $pid, 'Screening events engaging over 2,900 policymakers to achieve concrete bipartisan policy advancements on climate, energy, and national defense.' );
$c1_story2    = rs_get_field( 'chapter1_story2', $pid, 'Moving beyond conventional public relations, Roger equips leadership teams with the narrative cornerstones needed to navigate regulatory friction and convert critical initiatives into measurable, long-term impact.' );
$c1_btn1_lbl  = rs_get_field( 'chapter1_btn1_label', $pid, 'Schedule Strategy Session →' );
$c1_btn1_url  = rs_get_field( 'chapter1_btn1_url', $pid, '/contact/' );
$c1_btn2_lbl  = rs_get_field( 'chapter1_btn2_label', $pid, 'View Case Studies' );
$c1_btn2_url  = rs_get_field( 'chapter1_btn2_url', $pid, '/projects/' );
$c1_photo_raw = rs_get_field( 'chapter1_photo', $pid );
$c1_photo_url = $c1_photo_raw ? rs_image_url( $c1_photo_raw ) : rs_asset( 'about/roger-directing-profile.webp' );

// Chapter 02
$c2_tag       = rs_get_field( 'chapter2_tag', $pid, 'CHAPTER 02 • SECTORS & ADVOCACY' );
$c2_line1     = rs_get_field( 'chapter2_line1', $pid, "From America's Heartland to West Point:" );
$c2_line2     = rs_get_field( 'chapter2_line2', $pid, 'Overcoming Message Friction' );
$c2_lead      = rs_get_field( 'chapter2_lead', $pid, 'Through his strategic communications advisory, Roger brings this narrative expertise directly to organizations navigating complex challenges across defense, infrastructure, agriculture, clean energy, and public health.' );
$c2_c1_title  = rs_get_field( 'chapter2_card1_title', $pid, 'Airport Enterprise Alignment' );
$c2_c1_text   = rs_get_field( 'chapter2_card1_text', $pid, 'When leadership pushed back on "another corporate video," Roger engineered an enterprise-wide narrative architecture unifying sustainability and operational pride across 10,000 employees.' );
$c2_c2_title  = rs_get_field( 'chapter2_card2_title', $pid, 'Heartland Agriculture Coalitions' );
$c2_c2_text   = rs_get_field( 'chapter2_card2_text', $pid, 'Bridged deep partisan divides by centering authentic farmer voices, transforming regulatory friction into bipartisan legislative support for resilient agricultural policy.' );
$c2_c3_title  = rs_get_field( 'chapter2_card3_title', $pid, 'National Security & Defense' );
$c2_c3_text   = rs_get_field( 'chapter2_card3_text', $pid, 'Reframed clean energy and grid resilience as vital operational vulnerabilities for military leadership at West Point and the Pentagon, directly helping secure key defense appropriations.' );
$c2_photo_raw = rs_get_field( 'chapter2_photo', $pid );
$c2_photo_url = $c2_photo_raw ? rs_image_url( $c2_photo_raw ) : rs_asset( 'about/roger-at-westpoint.webp' );

// Chapter 03
$c3_tag       = rs_get_field( 'chapter3_tag', $pid, 'CHAPTER 03 • METHODOLOGY & ROOTS' );
$c3_line1     = rs_get_field( 'chapter3_line1', $pid, 'Anthropological Fieldwork' );
$c3_line2     = rs_get_field( 'chapter3_line2', $pid, 'Meets Documentary Craft' );
$c3_lead      = rs_get_field( 'chapter3_lead', $pid, "Roger's methodology draws from ethnographic research and documentary filmmaking, shaped by his studies in Anthropology at Johns Hopkins University and Communication at Stanford." );
$c3_story1    = rs_get_field( 'chapter3_story1', $pid, 'Before founding ARP, Roger produced award-winning content for National Geographic and PBS: foundational experiences that taught him how to uncover stories that resonate on deeper human levels. He has taught at business schools, led immersive simulations for executives at Fordham University, and moderated high-level forums with government and industry leaders.' );
$c3_story2    = rs_get_field( 'chapter3_story2', $pid, 'When not working with clients, Roger coaches youth baseball in Western Massachusetts, finding that building team cohesion on the field offers surprising, practical insights that translate directly to executive communications strategy.' );
$c3_btn1_lbl  = rs_get_field( 'chapter3_btn1_label', $pid, 'Work With Roger →' );
$c3_btn1_url  = rs_get_field( 'chapter3_btn1_url', $pid, '/contact/' );
$c3_btn2_lbl  = rs_get_field( 'chapter3_btn2_label', $pid, 'Explore Services Suite' );
$c3_btn2_url  = rs_get_field( 'chapter3_btn2_url', $pid, '/services/' );
$c3_photo_raw = rs_get_field( 'chapter3_photo', $pid );
$c3_photo_url = $c3_photo_raw ? rs_image_url( $c3_photo_raw ) : rs_asset( 'about/roger-speaking-onstage-scaled.webp' );

// Core Philosophy / 3 Principles
$pr_tag       = rs_get_field( 'principles_tag', $pid, 'CORE PHILOSOPHY' );
$pr_title     = rs_get_field( 'principles_title', $pid, 'Three Principles That Guide My Work' );
$pr_sub       = rs_get_field( 'principles_subtitle', $pid, 'My approach to communication challenges is guided by three core principles developed across three decades of filmmaking and executive strategy:' );
$p1_title     = rs_get_field( 'principle_1_title', $pid, 'The Same Solution, Different Reasons' );
$p1_text      = rs_get_field( 'principle_1_text', $pid, "People don't need to share identical values to support the same initiative. By identifying where different interests naturally converge, we can build support from stakeholders who might otherwise remain divided." );
$p1_tag       = rs_get_field( 'principle_1_tag', $pid, 'Bipartisan Coalition Building' );
$p2_title     = rs_get_field( 'principle_2_title', $pid, 'Emotion Matters as Much as Data' );
$p2_text      = rs_get_field( 'principle_2_text', $pid, 'While facts are important, emotional connections create more meaningful relationships with audiences. Authentic storytelling that connects on human levels drives action more effectively than statistics alone.' );
$p2_tag       = rs_get_field( 'principle_2_tag', $pid, 'Human-Centered Engagement' );
$p3_title     = rs_get_field( 'principle_3_title', $pid, 'Narratives Are a Strategic Asset' );
$p3_text      = rs_get_field( 'principle_3_text', $pid, "Communication isn't just what you say: it's the connection between what you do with why you do it. When organizations develop coherent narratives, both internal alignment and external engagement improve dramatically." );
$p3_tag       = rs_get_field( 'principle_3_tag', $pid, 'Narrative Architecture' );

// Systemic Methodology (3 Steps)
$app_tag   = rs_get_field( 'approach_tag', $pid, 'SYSTEMIC METHODOLOGY' );
$app_title = rs_get_field( 'approach_title', $pid, 'My Approach to Communications Challenges' );
$app_sub   = rs_get_field( 'approach_subtitle', $pid, 'Every engagement follows a structured, ethnographic methodology ensuring that strategy is deeply grounded in human reality and client mission.' );
$app_s1_t  = rs_get_field( 'approach_step_1_title', $pid, 'Ecosystem Assessment' );
$app_s1_d  = rs_get_field( 'approach_step_1_text', $pid, "I begin each engagement with a thorough assessment of your communication ecosystem: who you're trying to reach, what you're saying, and where you're getting stuck. This ethnographic process helps me understand your organization's unique culture and challenges before developing any strategic recommendations." );
$app_s2_t  = rs_get_field( 'approach_step_2_title', $pid, 'Filmmaking Meets Strategy' );
$app_s2_d  = rs_get_field( 'approach_step_2_text', $pid, "My style combines filmmaking expertise with strategic communications knowledge. Whether I'm directing a documentary that captures your mission or designing a comprehensive communications plan, I focus on finding authentic stories that connect with your stakeholders on both emotional and intellectual levels." );
$app_s3_t  = rs_get_field( 'approach_step_3_title', $pid, 'Direct, Senior-Level Partnership' );
$app_s3_d  = rs_get_field( 'approach_step_3_text', $pid, "I work directly with clients throughout the entire process, from initial concept development through final delivery. This hands-on approach ensures consistency of vision and allows me to adapt quickly as projects evolve. You'll always work with me personally, not a rotating team of associates who might lose sight of your objectives." );

// Credentials & Affiliations (6 Cards)
$cred_tag   = rs_get_field( 'credentials_tag', $pid, 'CREDENTIALS & AFFILIATIONS' );
$cred_title = rs_get_field( 'credentials_title', $pid, "Educational Pedigree & Institutional Milestones" );
$cred_sub   = rs_get_field( 'credentials_subtitle', $pid, 'A career shaped by top-tier academic institutions, national broadcast networks, and mission-driven leadership.' );
$cred_1_t   = rs_get_field( 'cred_1_title', $pid, 'Stanford University' );
$cred_1_d   = rs_get_field( 'cred_1_desc', $pid, 'M.A. in Communication (Documentary Film & Video)' );
$cred_2_t   = rs_get_field( 'cred_2_title', $pid, 'Johns Hopkins University' );
$cred_2_d   = rs_get_field( 'cred_2_desc', $pid, 'B.A. in Anthropology with focus on ethnographic research' );
$cred_3_t   = rs_get_field( 'cred_3_title', $pid, 'American Resilience Project' );
$cred_3_d   = rs_get_field( 'cred_3_desc', $pid, 'Founder & Executive Director driving national narrative policy' );
$cred_4_t   = rs_get_field( 'cred_4_title', $pid, 'National Geographic & PBS' );
$cred_4_d   = rs_get_field( 'cred_4_desc', $pid, 'Documentary Producer alumnus crafting high-impact human stories' );
$cred_5_t   = rs_get_field( 'cred_5_title', $pid, 'Fordham University' );
$cred_5_d   = rs_get_field( 'cred_5_desc', $pid, 'Guest Lecturer & Simulation Facilitator, Gabelli School of Business' );
$cred_6_t   = rs_get_field( 'cred_6_title', $pid, 'Cross-Sector Advisory' );
$cred_6_d   = rs_get_field( 'cred_6_desc', $pid, 'Defense, clean energy, infrastructure, food security & public health' );
?>

  <main id="main-content">
    <!-- PAGE HERO BANNER -->
    <section class="page-hero-section">
      <div class="page-hero-orb" aria-hidden="true"></div>
      <div class="container page-hero-container">
        
        <nav class="breadcrumb-nav" aria-label="Breadcrumb">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="breadcrumb-link">Home</a>
          <span class="breadcrumb-sep">/</span>
          <span class="breadcrumb-current" aria-current="page">About Roger Sorkin</span>
        </nav>

        <div class="pill-badge-hero">
          <span class="live-pulse"></span>
          <span class="badge-text"><?php echo esc_html( $badge ); ?></span>
        </div>

        <h1 class="page-hero-title">
          <?php echo esc_html( $title_line1 ); ?><br class="hero-title-break">
          <span class="text-gradient"><?php echo esc_html( $title_line2 ); ?></span>
        </h1>

        <p class="page-hero-subtitle">
          <?php echo esc_html( $subtitle ); ?>
        </p>

        <!-- Stats Bar: Matches Homepage Layout & Stacks 1 Per Row on Mobile with Separators -->
        <div class="trust-bar">
          <?php foreach ( $trust_stats as $idx => $st ) : ?>
            <?php if ( $idx > 0 ) : ?><div class="trust-divider"></div><?php endif; ?>
            <div class="trust-item">
              <span class="trust-number"><?php echo esc_html( $st['number'] ); ?></span>
              <span class="trust-label"><?php echo esc_html( $st['label'] ); ?></span>
            </div>
          <?php endforeach; ?>
        </div>

      </div>
    </section>

    <!-- CHAPTER 01: THE FOUNDATION & MISSION -->
    <section class="about-chapter-section section-light" id="mission">
      <div class="container">
        <div class="chapter-grid">
          
          <!-- Left Column: Portrait Frame with Offset Outline Border -->
          <div class="chapter-photo-col">
            <div class="story-portrait-wrap">
              <div class="photo-frame-offset">
                <img src="<?php echo esc_url( $c1_photo_url ); ?>" alt="Roger Sorkin Directing on Location" width="1189" height="1398" decoding="async" fetchpriority="high" />
              </div>
            </div>
          </div>

          <!-- Right Column: Chapter 1 Editorial Narrative -->
          <div class="chapter-content-col">
            <span class="section-tag"><?php echo esc_html( $c1_tag ); ?></span>
            <h2 class="section-title-dark chapter-heading-two-lines">
              <span class="heading-line"><?php echo esc_html( $c1_line1 ); ?></span>
              <?php if ( $c1_line2 ) : ?><span class="heading-line"><?php echo esc_html( $c1_line2 ); ?></span><?php endif; ?>
            </h2>
            
            <p class="lead-text-dark">
              <?php echo esc_html( $c1_lead ); ?>
            </p>

            <p class="story-p">
              <?php echo esc_html( $c1_story1 ); ?>
            </p>

            <div class="chapter-stat-callout">
              <div class="chapter-stat-num"><?php echo esc_html( $c1_stat_num ); ?></div>
              <div class="chapter-stat-desc">
                <?php echo esc_html( $c1_stat_desc ); ?>
              </div>
            </div>

            <p class="story-p">
              <?php echo esc_html( $c1_story2 ); ?>
            </p>

            <div class="about-action-row" style="margin-top: 28px;">
              <a href="<?php echo esc_url( home_url( $c1_btn1_url ) ); ?>" class="btn btn-dark"><?php echo esc_html( $c1_btn1_lbl ); ?></a>
              <a href="<?php echo esc_url( home_url( $c1_btn2_url ) ); ?>" class="btn btn-outline-dark"><?php echo esc_html( $c1_btn2_lbl ); ?></a>
            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- CHAPTER 02: HIGH-STAKES SECTORS & PROVEN IMPACT (With Roger at West Point Photo) -->
    <section class="about-chapter-section" id="sectors" style="background: #ffffff; border-top: 1px solid var(--color-border-light); border-bottom: 1px solid var(--color-border-light);">
      <div class="container">
        <div class="chapter-grid reverse-layout">
          
          <!-- Left Column: Chapter 2 Editorial Narrative & Impact Cards -->
          <div class="chapter-content-col">
            <span class="section-tag"><?php echo esc_html( $c2_tag ); ?></span>
            <h2 class="section-title-dark chapter-heading-two-lines">
              <span class="heading-line"><?php echo esc_html( $c2_line1 ); ?></span>
              <?php if ( $c2_line2 ) : ?><span class="heading-line"><?php echo esc_html( $c2_line2 ); ?></span><?php endif; ?>
            </h2>
            
            <p class="lead-text-dark">
              <?php echo esc_html( $c2_lead ); ?>
            </p>

            <!-- 3 High-Converting Impact Cards Replacing Walls of Text -->
            <div class="impact-cards-stack">
              <div class="impact-card">
                <div class="impact-card-header">
                  <div class="impact-card-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>
                  </div>
                  <h3 class="impact-card-title"><?php echo esc_html( $c2_c1_title ); ?></h3>
                </div>
                <p class="impact-card-text">
                  <?php echo esc_html( $c2_c1_text ); ?>
                </p>
              </div>

              <div class="impact-card">
                <div class="impact-card-header">
                  <div class="impact-card-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>
                  </div>
                  <h3 class="impact-card-title"><?php echo esc_html( $c2_c2_title ); ?></h3>
                </div>
                <p class="impact-card-text">
                  <?php echo esc_html( $c2_c2_text ); ?>
                </p>
              </div>

              <div class="impact-card">
                <div class="impact-card-header">
                  <div class="impact-card-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                  </div>
                  <h3 class="impact-card-title"><?php echo esc_html( $c2_c3_title ); ?></h3>
                </div>
                <p class="impact-card-text">
                  <?php echo esc_html( $c2_c3_text ); ?>
                </p>
              </div>
            </div>
          </div>

          <!-- Right Column: Visual Photo Card of Roger at West Point with Offset Frame -->
          <div class="chapter-photo-col">
            <div class="photo-frame-offset">
              <img src="<?php echo esc_url( $c2_photo_url ); ?>" alt="Roger Sorkin at the U.S. Military Academy at West Point" width="1400" height="859" loading="lazy" decoding="async" />
            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- CHAPTER 03: ANTHROPOLOGICAL RIGOR, MEDIA ROOTS & COMMUNITY (With Roger Speaking Onstage Photo) -->
    <section class="about-chapter-section section-light" id="methodology-roots">
      <div class="container">
        <div class="chapter-grid">
          
          <!-- Left Column: Visual Photo Card of Roger Speaking Onstage with Offset Frame -->
          <div class="chapter-photo-col">
            <div class="photo-frame-offset">
              <img src="<?php echo esc_url( $c3_photo_url ); ?>" alt="Roger Sorkin Speaking Onstage to Leaders and Policymakers" width="1400" height="860" loading="lazy" decoding="async" />
            </div>
          </div>

          <!-- Right Column: Chapter 3 Editorial Narrative -->
          <div class="chapter-content-col">
            <span class="section-tag"><?php echo esc_html( $c3_tag ); ?></span>
            <h2 class="section-title-dark chapter-heading-two-lines">
              <span class="heading-line"><?php echo esc_html( $c3_line1 ); ?></span>
              <?php if ( $c3_line2 ) : ?><span class="heading-line"><?php echo esc_html( $c3_line2 ); ?></span><?php endif; ?>
            </h2>
            
            <p class="lead-text-dark">
              <?php echo esc_html( $c3_lead ); ?>
            </p>

            <p class="story-p">
              <?php echo esc_html( $c3_story1 ); ?>
            </p>

            <p class="story-p">
              <?php echo esc_html( $c3_story2 ); ?>
            </p>

            <div class="about-action-row" style="margin-top: 28px;">
              <a href="<?php echo esc_url( home_url( $c3_btn1_url ) ); ?>" class="btn btn-dark"><?php echo esc_html( $c3_btn1_lbl ); ?></a>
              <a href="<?php echo esc_url( home_url( $c3_btn2_url ) ); ?>" class="btn btn-outline-dark"><?php echo esc_html( $c3_btn2_lbl ); ?></a>
            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- CLIENT LOGOS TICKER SECTION -->
    <?php get_template_part( 'template-parts/client-logos' ); ?>

    <!-- THREE GUIDING PRINCIPLES SECTION (Dark Navy with Background Pattern, Icon and Heading Next to Each Other) -->
    <section class="section section-principles" id="principles">
      <div class="container">
        
        <div class="text-center" style="max-width: 780px; margin: 0 auto;">
          <span class="section-tag"><?php echo esc_html( $pr_tag ); ?></span>
          <h2 class="section-title-light"><?php echo esc_html( $pr_title ); ?></h2>
          <p class="section-subtitle-light">
            <?php echo esc_html( $pr_sub ); ?>
          </p>
        </div>

        <div class="principles-grid">
          
          <!-- Principle 1 -->
          <div class="principle-card">
            <span class="principle-num">PRINCIPLE 01</span>
            
            <div class="principle-header-row">
              <div class="principle-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <circle cx="18" cy="5" r="3"></circle>
                  <circle cx="6" cy="12" r="3"></circle>
                  <circle cx="18" cy="19" r="3"></circle>
                  <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line>
                  <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line>
                </svg>
              </div>
              <h3 class="principle-title"><?php echo esc_html( $p1_title ); ?></h3>
            </div>

            <p class="principle-text">
              <?php echo esc_html( $p1_text ); ?>
            </p>
            <div class="principle-tag">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
              <span><?php echo esc_html( $p1_tag ); ?></span>
            </div>
          </div>

          <!-- Principle 2 -->
          <div class="principle-card">
            <span class="principle-num">PRINCIPLE 02</span>
            
            <div class="principle-header-row">
              <div class="principle-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                </svg>
              </div>
              <h3 class="principle-title"><?php echo esc_html( $p2_title ); ?></h3>
            </div>

            <p class="principle-text">
              <?php echo esc_html( $p2_text ); ?>
            </p>
            <div class="principle-tag">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
              <span><?php echo esc_html( $p2_tag ); ?></span>
            </div>
          </div>

          <!-- Principle 3 -->
          <div class="principle-card">
            <span class="principle-num">PRINCIPLE 03</span>
            
            <div class="principle-header-row">
              <div class="principle-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                  <polyline points="2 17 12 22 22 17"></polyline>
                  <polyline points="2 12 12 17 22 12"></polyline>
                </svg>
              </div>
              <h3 class="principle-title"><?php echo esc_html( $p3_title ); ?></h3>
            </div>

            <p class="principle-text">
              <?php echo esc_html( $p3_text ); ?>
            </p>
            <div class="principle-tag">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
              <span><?php echo esc_html( $p3_tag ); ?></span>
            </div>
          </div>

        </div>

      </div>
    </section>

    <!-- APPROACH TO COMMUNICATIONS CHALLENGES SECTION -->
    <section class="section section-light" id="approach">
      <div class="container">
        
        <div class="text-center" style="max-width: 780px; margin: 0 auto;">
          <span class="section-tag"><?php echo esc_html( $app_tag ); ?></span>
          <h2 class="section-title-dark"><?php echo esc_html( $app_title ); ?></h2>
          <p class="body-text-dark" style="margin-bottom: 0;">
            <?php echo esc_html( $app_sub ); ?>
          </p>
        </div>

        <div class="approach-grid">
          
          <!-- Step 1 -->
          <div class="approach-card">
            <div class="approach-header">
              <span class="approach-num">01</span>
              <div class="approach-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <circle cx="11" cy="11" r="8"></circle>
                  <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
              </div>
            </div>
            <h3><?php echo esc_html( $app_s1_t ); ?></h3>
            <p>
              <?php echo esc_html( $app_s1_d ); ?>
            </p>
          </div>

          <!-- Step 2 -->
          <div class="approach-card">
            <div class="approach-header">
              <span class="approach-num">02</span>
              <div class="approach-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <polygon points="23 7 16 12 23 17 23 7"></polygon>
                  <rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect>
                </svg>
              </div>
            </div>
            <h3><?php echo esc_html( $app_s2_t ); ?></h3>
            <p>
              <?php echo esc_html( $app_s2_d ); ?>
            </p>
          </div>

          <!-- Step 3 -->
          <div class="approach-card">
            <div class="approach-header">
              <span class="approach-num">03</span>
              <div class="approach-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                  <circle cx="9" cy="7" r="4"></circle>
                  <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                  <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
              </div>
            </div>
            <h3><?php echo esc_html( $app_s3_t ); ?></h3>
            <p>
              <?php echo esc_html( $app_s3_d ); ?>
            </p>
          </div>

        </div>

      </div>
    </section>

    <!-- CREDENTIALS, EDUCATION & IMPACT GRID -->
    <section class="section section-light" id="credentials" style="border-top: 1px solid var(--color-border-light);">
      <div class="container">
        
        <div class="text-center" style="max-width: 780px; margin: 0 auto;">
          <span class="section-tag"><?php echo esc_html( $cred_tag ); ?></span>
          <h2 class="section-title-dark">
            <?php echo nl2br( esc_html( $cred_title ) ); ?>
          </h2>
          <p class="body-text-dark" style="margin-bottom: 0;">
            <?php echo esc_html( $cred_sub ); ?>
          </p>
        </div>

        <div class="credentials-grid">
          
          <div class="cred-card">
            <div class="cred-icon-box">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
            </div>
            <div class="cred-info">
              <h4><?php echo esc_html( $cred_1_t ); ?></h4>
              <p><?php echo esc_html( $cred_1_d ); ?></p>
            </div>
          </div>

          <div class="cred-card">
            <div class="cred-icon-box">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
            </div>
            <div class="cred-info">
              <h4><?php echo esc_html( $cred_2_t ); ?></h4>
              <p><?php echo esc_html( $cred_2_d ); ?></p>
            </div>
          </div>

          <div class="cred-card">
            <div class="cred-icon-box">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>
            </div>
            <div class="cred-info">
              <h4><?php echo esc_html( $cred_3_t ); ?></h4>
              <p><?php echo esc_html( $cred_3_d ); ?></p>
            </div>
          </div>

          <div class="cred-card">
            <div class="cred-icon-box">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>
            </div>
            <div class="cred-info">
              <h4><?php echo esc_html( $cred_4_t ); ?></h4>
              <p><?php echo esc_html( $cred_4_d ); ?></p>
            </div>
          </div>

          <div class="cred-card">
            <div class="cred-icon-box">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div class="cred-info">
              <h4><?php echo esc_html( $cred_5_t ); ?></h4>
              <p><?php echo esc_html( $cred_5_d ); ?></p>
            </div>
          </div>

          <div class="cred-card">
            <div class="cred-icon-box">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            </div>
            <div class="cred-info">
              <h4><?php echo esc_html( $cred_6_t ); ?></h4>
              <p><?php echo esc_html( $cred_6_d ); ?></p>
            </div>
          </div>

        </div>

      </div>
    </section>

    <!-- TESTIMONIALS HIGHLIGHT SECTION -->
    <section class="section section-light section-testimonials" id="endorsements">
      <div class="container">
        
        <div class="text-center" style="max-width: 780px; margin: 0 auto 40px auto;">
          <span class="section-tag">LEADERSHIP ENDORSEMENTS</span>
          <h2 class="section-title-dark">
            Trusted by Decision-Makers<br class="title-break">
            Across Sectors
          </h2>
        </div>

        <div class="endorsements-grid">
          
          <div class="endorsement-card">
            <div class="quote-icon-wrap">
              <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="quote-svg-icon"><path d="M3 21c3 0 7-1 7-8V5c0-1.25-.75-2-2-2H4c-1.25 0-2 .75-2 2v6c0 1.25.75 2 2 2h3c0 4-2 6-4 7.5L3 21z"/><path d="M15 21c3 0 7-1 7-8V5c0-1.25-.75-2-2-2h-4c-1.25 0-2 .75-2 2v6c0 1.25.75 2 2 2h3c0 4-2 6-4 7.5L15 21z"/></svg>
            </div>
            <p class="quote-text">
              "Roger created a strategic narrative that didn't just document our flooding challenges, it catalyzed cross-jurisdictional collaboration that resulted in action that's harder to accomplish through traditional advocacy channels."
            </p>
            <div class="author-info-box">
              <h4 class="author-name">Rear Admiral Ann Phillips</h4>
              <span class="author-title">USN (RET.)</span>
            </div>
          </div>

          <div class="endorsement-card">
            <div class="quote-icon-wrap">
              <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="quote-svg-icon"><path d="M3 21c3 0 7-1 7-8V5c0-1.25-.75-2-2-2H4c-1.25 0-2 .75-2 2v6c0 1.25.75 2 2 2h3c0 4-2 6-4 7.5L3 21z"/><path d="M15 21c3 0 7-1 7-8V5c0-1.25-.75-2-2-2h-4c-1.25 0-2 .75-2 2v6c0 1.25.75 2 2 2h3c0 4-2 6-4 7.5L15 21z"/></svg>
            </div>
            <p class="quote-text">
              "Roger opened doors for our company by helping us communicate to our investors and other stakeholders the complexities and urgency of a just energy transition."
            </p>
            <div class="author-info-box">
              <h4 class="author-name">David Gautschi</h4>
              <span class="author-title">FOUNDER &amp; CEO, TILT GLOBAL DECISIONS</span>
            </div>
          </div>

        </div>

      </div>
    </section>

    <!-- CONTACT SECTION -->
    <?php get_template_part( 'template-parts/contact-section', null, array( 'style' => 'dark' ) ); ?>
  </main>

<?php
get_footer();

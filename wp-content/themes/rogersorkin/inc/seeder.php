<?php
/**
 * Automated Content Seeder for Roger Sorkin Theme
 *
 * Populates all pages, CPTs, custom fields, and options.
 * Works seamlessly with Free ACF, ACF Pro, and native WordPress fields.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Set a post field value across both ACF and native post meta.
 */
function rs_save_field( $field_name, $value, $post_id ) {
    update_post_meta( $post_id, $field_name, $value );
    if ( function_exists( 'update_field' ) ) {
        update_field( $field_name, $value, $post_id );
    }
}

/**
 * Set an option value across WP options and ACF options.
 */
function rs_save_option( $key, $value ) {
    update_option( 'options_' . $key, $value );
    update_option( 'rs_' . $key, $value );
    if ( function_exists( 'update_field' ) ) {
        update_field( $key, $value, 'option' );
    }
}

function rs_seed_initial_content( $force = false ) {
    if ( ! $force && get_option( 'rs_theme_seeded_v8' ) ) {
        return;
    }

    // ------------------------------------------------------------------
    // 1. Create Core Pages
    // ------------------------------------------------------------------
    $pages = array(
        'Home'     => array( 'template' => 'front-page.php', 'slug' => 'home' ),
        'About'    => array( 'template' => 'page-about.php', 'slug' => 'about' ),
        'Services' => array( 'template' => 'page-services.php', 'slug' => 'services' ),
        'Projects' => array( 'template' => 'page-projects.php', 'slug' => 'projects' ),
        'Blog'     => array( 'template' => '', 'slug' => 'blog' ),
        'Contact'  => array( 'template' => 'page-contact.php', 'slug' => 'contact' ),
    );

    $page_ids = array();
    foreach ( $pages as $title => $data ) {
        $existing = get_page_by_path( $data['slug'] );
        if ( ! $existing ) {
            $pid = wp_insert_post( array(
                'post_title'   => $title,
                'post_name'    => $data['slug'],
                'post_status'  => 'publish',
                'post_type'    => 'page',
            ) );
            if ( $pid && ! empty( $data['template'] ) ) {
                update_post_meta( $pid, '_wp_page_template', $data['template'] );
            }
            $page_ids[ $title ] = $pid;
        } else {
            $page_ids[ $title ] = $existing->ID;
            if ( ! empty( $data['template'] ) ) {
                update_post_meta( $existing->ID, '_wp_page_template', $data['template'] );
            }
        }
    }

    // Set Reading Settings (Static Front Page)
    if ( ! empty( $page_ids['Home'] ) ) {
        update_option( 'show_on_front', 'page' );
        update_option( 'page_on_front', $page_ids['Home'] );
    }
    if ( ! empty( $page_ids['Blog'] ) ) {
        update_option( 'page_for_posts', $page_ids['Blog'] );
    }

    // ------------------------------------------------------------------
    // 2. Seed Homepage Fields
    // ------------------------------------------------------------------
    if ( ! empty( $page_ids['Home'] ) ) {
        $hid = $page_ids['Home'];
        rs_save_field( 'hero_badge_text', 'STRATEGIC COMMUNICATIONS & DOCUMENTARY FILM', $hid );
        rs_save_field( 'hero_title_line1', 'Turning narrative risk', $hid );
        rs_save_field( 'hero_title_line2', 'into strategic advantage.', $hid );
        rs_save_field( 'hero_subtitle', 'Translating complex environmental, economic, and security challenges into compelling, bipartisan strategic narratives and attainable calls-to-action.', $hid );
        rs_save_field( 'hero_cta_primary_label', 'Book Strategy Session', $hid );
        rs_save_field( 'hero_cta_primary_url', '/contact/', $hid );
        rs_save_field( 'hero_cta_reel_label', 'Watch Showreel', $hid );

        // 4 Stats
        rs_save_field( 'stat_1_num', '30+', $hid );
        rs_save_field( 'stat_1_label', 'Years Experience', $hid );
        rs_save_field( 'stat_2_num', '10+', $hid );
        rs_save_field( 'stat_2_label', 'Award Films', $hid );
        rs_save_field( 'stat_3_num', 'Bipartisan', $hid );
        rs_save_field( 'stat_3_label', 'Congressional Impact', $hid );
        rs_save_field( 'stat_4_num', '10,000+', $hid );
        rs_save_field( 'stat_4_label', 'Leaders Trained', $hid );

        // Section Headings
        rs_save_field( 'services_hub_tag', 'STRATEGIC COMMUNICATIONS SUITE', $hid );
        rs_save_field( 'services_hub_title', 'A Range of Services to Meet Your Communications Needs', $hid );
        rs_save_field( 'services_hub_subtitle', 'Connecting seasoned executive counsel, custom simulations, and impact storytelling to convert narrative risk into enduring advantage.', $hid );
        rs_save_field( 'projects_section_tag', 'SELECTED CASE STUDIES', $hid );
        rs_save_field( 'projects_section_title', 'Strategic Narratives in Action', $hid );
        rs_save_field( 'projects_section_subtitle', 'From reframing national security and agriculture to guiding executive leadership transitions, explore case studies that accomplished what facts alone could not.', $hid );

        // About Roger Sorkin Section on Homepage
        rs_save_field( 'hp_about_tag', 'ABOUT ROGER SORKIN', $hid );
        rs_save_field( 'hp_about_title', '30 Years of Finding Common Ground Through Storytelling', $hid );
        rs_save_field( 'hp_about_lead', 'Spanning three decades across documentary filmmaking, investigative journalism, and non-partisan advocacy, Roger Sorkin transforms complex national challenges into unified human narratives.', $hid );
        rs_save_field( 'hp_about_body', 'My background in anthropology and journalism taught me how to read room dynamics, cultivate authentic constituent voices, and uncover the shared values that bypass partisan skepticism. From producing daily public affairs broadcasts to screening original documentaries before Congressional committees, I help leaders build trust where traditional public relations fail.', $hid );
        rs_save_field( 'hp_about_feat1_title', 'Journalistic Rigor & Research', $hid );
        rs_save_field( 'hp_about_feat1_text', 'In-depth investigation yielding constituent narratives that command authority.', $hid );
        rs_save_field( 'hp_about_feat2_title', 'Bipartisan Coalition Building', $hid );
        rs_save_field( 'hp_about_feat2_text', 'Uniting business leaders, military veterans, lawmakers, and advocates.', $hid );
        rs_save_field( 'hp_about_cred1_text', 'M.A. Communication (Stanford)', $hid );
        rs_save_field( 'hp_about_cred2_text', 'Founder, American Resilience Project', $hid );
        rs_save_field( 'hp_about_quote_text', 'A white paper disguised as a film: perhaps the greatest compliment possible for my approach.', $hid );
        rs_save_field( 'hp_about_quote_cite', 'Senior Congressional Energy Policy Advisor • Roger Sorkin', $hid );
        rs_save_field( 'hp_about_cta1_label', 'Schedule Strategy Call →', $hid );
        rs_save_field( 'hp_about_cta1_url', '/contact/', $hid );
        rs_save_field( 'hp_about_cta2_label', 'Read Full Bio & Story →', $hid );
        rs_save_field( 'hp_about_cta2_url', '/about/', $hid );
    }

    // ------------------------------------------------------------------
    // 3. Seed About Page Fields
    // ------------------------------------------------------------------
    if ( ! empty( $page_ids['About'] ) ) {
        $aid = $page_ids['About'];
        rs_save_field( 'hero_badge_text', 'STRATEGIC COMMUNICATIONS & DOCUMENTARY FILM', $aid );
        rs_save_field( 'hero_title_line1', "Solutions to humanity's greatest challenges", $aid );
        rs_save_field( 'hero_title_line2', 'start with strong narrative foundations.', $aid );
        rs_save_field( 'hero_subtitle', 'Strategic communications advisor and award-winning documentary filmmaker helping organizations build durable narrative infrastructure, unite diverse stakeholders, and accelerate systemic change.', $aid );

        rs_save_field( 'stat_1_num', '30+', $aid );
        rs_save_field( 'stat_1_label', 'Years Experience', $aid );
        rs_save_field( 'stat_2_num', 'Founder', $aid );
        rs_save_field( 'stat_2_label', 'American Resilience Project', $aid );
        rs_save_field( 'stat_3_num', 'Stanford & Hopkins', $aid );
        rs_save_field( 'stat_3_label', 'Academic Foundation', $aid );
        rs_save_field( 'stat_4_num', 'Bipartisan', $aid );
        rs_save_field( 'stat_4_label', 'Policy Advancements', $aid );

        // Chapter 01
        rs_save_field( 'chapter1_tag', 'CHAPTER 01 • THE MISSION', $aid );
        rs_save_field( 'chapter1_line1', 'Three Decades of Uniting Stakeholders', $aid );
        rs_save_field( 'chapter1_line2', 'Through Narrative Strategy', $aid );
        rs_save_field( 'chapter1_lead', 'As founder of the American Resilience Project (ARP), Roger has spent over 30 years pioneering narrative strategies that unite disparate stakeholders around shared solutions.', $aid );
        rs_save_field( 'chapter1_story1', 'In an era of acute polarization and communication fatigue, high-stakes organizations often struggle to translate complex science, energy policy, and national security data into narratives that resonate. Roger bridges this gap by discovering the underlying human truths that move people from skepticism to consensus.', $aid );
        rs_save_field( 'chapter1_stat_num', '800+', $aid );
        rs_save_field( 'chapter1_stat_desc', 'Screening events engaging over 2,900 policymakers to achieve concrete bipartisan policy advancements on climate, energy, and national defense.', $aid );
        rs_save_field( 'chapter1_story2', 'Moving beyond conventional public relations, Roger equips leadership teams with the narrative cornerstones needed to navigate regulatory friction and convert critical initiatives into measurable, long-term impact.', $aid );
        rs_save_field( 'chapter1_btn1_label', 'Schedule Strategy Session →', $aid );
        rs_save_field( 'chapter1_btn1_url', '/contact/', $aid );
        rs_save_field( 'chapter1_btn2_label', 'View Case Studies', $aid );
        rs_save_field( 'chapter1_btn2_url', '/projects/', $aid );

        // Chapter 02
        rs_save_field( 'chapter2_tag', 'CHAPTER 02 • SECTORS & ADVOCACY', $aid );
        rs_save_field( 'chapter2_line1', "From America's Heartland to West Point:", $aid );
        rs_save_field( 'chapter2_line2', 'Overcoming Message Friction', $aid );
        rs_save_field( 'chapter2_lead', 'Through his strategic communications advisory, Roger brings this narrative expertise directly to organizations navigating complex challenges across defense, infrastructure, agriculture, clean energy, and public health.', $aid );
        rs_save_field( 'chapter2_card1_title', 'Airport Enterprise Alignment', $aid );
        rs_save_field( 'chapter2_card1_text', 'When leadership pushed back on "another corporate video," Roger engineered an enterprise-wide narrative architecture unifying sustainability and operational pride across 10,000 employees.', $aid );
        rs_save_field( 'chapter2_card2_title', 'Heartland Agriculture Coalitions', $aid );
        rs_save_field( 'chapter2_card2_text', 'Bridged deep partisan divides by centering authentic farmer voices, transforming regulatory friction into bipartisan legislative support for resilient agricultural policy.', $aid );
        rs_save_field( 'chapter2_card3_title', 'National Security & Defense', $aid );
        rs_save_field( 'chapter2_card3_text', 'Reframed clean energy and grid resilience as vital operational vulnerabilities for military leadership at West Point and the Pentagon, directly helping secure key defense appropriations.', $aid );

        // Chapter 03
        rs_save_field( 'chapter3_tag', 'CHAPTER 03 • METHODOLOGY & ROOTS', $aid );
        rs_save_field( 'chapter3_line1', 'Anthropological Fieldwork', $aid );
        rs_save_field( 'chapter3_line2', 'Meets Documentary Craft', $aid );
        rs_save_field( 'chapter3_lead', "Roger's methodology draws from ethnographic research and documentary filmmaking, shaped by his studies in Anthropology at Johns Hopkins University and Communication at Stanford.", $aid );
        rs_save_field( 'chapter3_story1', 'Before founding ARP, Roger produced award-winning content for National Geographic and PBS: foundational experiences that taught him how to uncover stories that resonate on deeper human levels. He has taught at business schools, led immersive simulations for executives at Fordham University, and moderated high-level forums with government and industry leaders.', $aid );
        rs_save_field( 'chapter3_story2', 'When not working with clients, Roger coaches youth baseball in Western Massachusetts, finding that building team cohesion on the field offers surprising, practical insights that translate directly to executive communications strategy.', $aid );
        rs_save_field( 'chapter3_btn1_label', 'Work With Roger →', $aid );
        rs_save_field( 'chapter3_btn1_url', '/contact/', $aid );
        rs_save_field( 'chapter3_btn2_label', 'Explore Services Suite', $aid );
        rs_save_field( 'chapter3_btn2_url', '/services/', $aid );

        // Core Philosophy / 3 Principles
        rs_save_field( 'principles_tag', 'CORE PHILOSOPHY', $aid );
        rs_save_field( 'principles_title', 'Three Principles That Guide My Work', $aid );
        rs_save_field( 'principles_subtitle', 'My approach to communication challenges is guided by three core principles developed across three decades of filmmaking and executive strategy:', $aid );
        rs_save_field( 'principle_1_title', 'The Same Solution, Different Reasons', $aid );
        rs_save_field( 'principle_1_text', "People don't need to share identical values to support the same initiative. By identifying where different interests naturally converge, we can build support from stakeholders who might otherwise remain divided.", $aid );
        rs_save_field( 'principle_1_tag', 'Bipartisan Coalition Building', $aid );
        rs_save_field( 'principle_2_title', 'Emotion Matters as Much as Data', $aid );
        rs_save_field( 'principle_2_text', 'While facts are important, emotional connections create more meaningful relationships with audiences. Authentic storytelling that connects on human levels drives action more effectively than statistics alone.', $aid );
        rs_save_field( 'principle_2_tag', 'Human-Centered Engagement', $aid );
        rs_save_field( 'principle_3_title', 'The Medium Shapes the Message', $aid );
        rs_save_field( 'principle_3_text', 'Whether an intimate one-on-one executive coaching session or a national documentary screening, the format must serve the strategic goal. Strategy dictates medium, never the reverse.', $aid );
        rs_save_field( 'principle_3_tag', 'Multi-Platform Strategy', $aid );

        // Systemic Methodology (3 Steps)
        rs_save_field( 'approach_tag', 'SYSTEMIC METHODOLOGY', $aid );
        rs_save_field( 'approach_title', 'My Approach to Communications Challenges', $aid );
        rs_save_field( 'approach_subtitle', 'Every engagement follows a structured, ethnographic methodology ensuring that strategy is deeply grounded in human reality and client mission.', $aid );
        rs_save_field( 'approach_step_1_title', 'Ecosystem Assessment', $aid );
        rs_save_field( 'approach_step_1_text', "I begin each engagement with a thorough assessment of your communication ecosystem: who you're trying to reach, what you're saying, and where you're getting stuck. This ethnographic process helps me understand your organization's unique culture and challenges before developing any strategic recommendations.", $aid );
        rs_save_field( 'approach_step_2_title', 'Filmmaking Meets Strategy', $aid );
        rs_save_field( 'approach_step_2_text', "My style combines filmmaking expertise with strategic communications knowledge. Whether I'm directing a documentary that captures your mission or designing a comprehensive communications plan, I focus on finding authentic stories that connect with your stakeholders on both emotional and intellectual levels.", $aid );
        rs_save_field( 'approach_step_3_title', 'Direct, Senior-Level Partnership', $aid );
        rs_save_field( 'approach_step_3_text', "I work directly with clients throughout the entire process, from initial concept development through final delivery. This hands-on approach ensures consistency of vision and allows me to adapt quickly as projects evolve. You'll always work with me personally, not a rotating team of associates who might lose sight of your objectives.", $aid );

        // Credentials & Affiliations (6 Cards)
        rs_save_field( 'credentials_tag', 'CREDENTIALS & AFFILIATIONS', $aid );
        rs_save_field( 'credentials_title', 'Educational Pedigree & Institutional Milestones', $aid );
        rs_save_field( 'credentials_subtitle', 'A career shaped by top-tier academic institutions, national broadcast networks, and mission-driven leadership.', $aid );
        rs_save_field( 'cred_1_title', 'Stanford University', $aid );
        rs_save_field( 'cred_1_desc', 'M.A. in Communication (Documentary Film & Video)', $aid );
        rs_save_field( 'cred_2_title', 'Johns Hopkins University', $aid );
        rs_save_field( 'cred_2_desc', 'B.A. in Anthropology with focus on ethnographic research', $aid );
        rs_save_field( 'cred_3_title', 'American Resilience Project', $aid );
        rs_save_field( 'cred_3_desc', 'Founder & Executive Director driving national narrative policy', $aid );
        rs_save_field( 'cred_4_title', 'National Geographic & PBS', $aid );
        rs_save_field( 'cred_4_desc', 'Documentary Producer alumnus crafting high-impact human stories', $aid );
        rs_save_field( 'cred_5_title', 'Fordham University', $aid );
        rs_save_field( 'cred_5_desc', 'Guest Lecturer & Simulation Facilitator, Gabelli School of Business', $aid );
        rs_save_field( 'cred_6_title', 'Cross-Sector Advisory', $aid );
        rs_save_field( 'cred_6_desc', 'Defense, clean energy, infrastructure, food security & public health', $aid );
    }

    // ------------------------------------------------------------------
    // 4. Seed Services Page Fields
    // ------------------------------------------------------------------
    if ( ! empty( $page_ids['Services'] ) ) {
        $sid = $page_ids['Services'];
        rs_save_field( 'hero_badge_text', 'STRATEGIC COMMUNICATIONS & DOCUMENTARY FILM', $sid );
        rs_save_field( 'hero_title_line1', 'A Range of Services to Meet', $sid );
        rs_save_field( 'hero_title_line2', 'Your Communications Needs.', $sid );
        rs_save_field( 'hero_subtitle', 'Organizations face more communications demands than ever: internal alignment, public storytelling, executive visibility, media engagement, and high-impact content. Few teams can take all of it on alone. Here is how Roger Sorkin delivers strategic advantage.', $sid );

        rs_save_field( 'stat_1_num', '30+', $sid );
        rs_save_field( 'stat_1_label', 'Years Experience', $sid );
        rs_save_field( 'stat_2_num', '10+', $sid );
        rs_save_field( 'stat_2_label', 'Award Films', $sid );
        rs_save_field( 'stat_3_num', 'Bipartisan', $sid );
        rs_save_field( 'stat_3_label', 'Congressional Impact', $sid );
        rs_save_field( 'stat_4_num', '10,000+', $sid );
        rs_save_field( 'stat_4_label', 'Leaders Trained', $sid );

        rs_save_field( 'models_tag', 'ENGAGEMENT MODELS', $sid );
        rs_save_field( 'models_title', 'How We Work Together', $sid );
        rs_save_field( 'models_subtitle', 'Whether you need ongoing executive advisory, an intensive workshop, or a full documentary production, we offer structured models to fit your timeline and goals.', $sid );

        // Model 1
        rs_save_field( 'model_1_badge', 'MODEL 01 • STRATEGIC COUNSEL', $sid );
        rs_save_field( 'model_1_title', 'Executive Retainers', $sid );
        rs_save_field( 'model_1_desc', 'Ongoing fractional C-suite leadership and trusted counsel embedded directly alongside your executive team.', $sid );
        rs_save_field( 'model_1_features', "Fractional Communications Officer role
Weekly senior strategy & review calls
Crisis preparedness & response standby
Direct CEO & board advisory access", $sid );
        rs_save_field( 'model_1_bullets', "Fractional Communications Officer role\nWeekly senior strategy & review calls\nCrisis preparedness & response standby\nDirect CEO & board advisory access", $sid );
        rs_save_field( 'model_1_btn_label', 'Inquire About Retainer', $sid );
        rs_save_field( 'model_1_btn_url', '/contact/', $sid );

        // Model 2
        rs_save_field( 'model_2_badge', 'MODEL 02 • DIAGNOSTIC', $sid );
        rs_save_field( 'model_2_title', 'Focused Intensives', $sid );
        rs_save_field( 'model_2_desc', 'Concentrated, time-boxed engagements that diagnose narrative friction or prepare teams for critical public events.', $sid );
        rs_save_field( 'model_2_features', "Comprehensive Communications Audit
Custom role-playing simulations (1-3 days)
Executive coaching prior to major hearings
Detailed actionable findings report", $sid );
        rs_save_field( 'model_2_bullets', "Comprehensive Communications Audit\nCustom role-playing simulations (1-3 days)\nExecutive coaching prior to major hearings\nDetailed actionable findings report", $sid );
        rs_save_field( 'model_2_btn_label', 'Schedule an Intensive', $sid );
        rs_save_field( 'model_2_btn_url', '/contact/', $sid );

        // Model 3
        rs_save_field( 'model_3_badge', 'MODEL 03 • PRODUCTION', $sid );
        rs_save_field( 'model_3_title', 'Creative Systems', $sid );
        rs_save_field( 'model_3_desc', 'Full-cycle content infrastructure that convenes key decision-makers and establishes in-house production capability.', $sid );
        rs_save_field( 'model_3_features', "Documentary film production & distribution
Content Roadmap systems for in-house teams
End-to-end podcast series production
Screening tour convening policymakers", $sid );
        rs_save_field( 'model_3_bullets', "Documentary film production & distribution\nContent Roadmap systems for in-house teams\nEnd-to-end podcast series production\nScreening tour convening policymakers", $sid );
        rs_save_field( 'model_3_btn_label', 'Commission Creative', $sid );
        rs_save_field( 'model_3_btn_url', '/contact/', $sid );
    }

    // ------------------------------------------------------------------
    // 5. Seed Projects Page Fields
    // ------------------------------------------------------------------
    if ( ! empty( $page_ids['Projects'] ) ) {
        $ppid = $page_ids['Projects'];
        rs_save_field( 'hero_badge_text', 'STRATEGIC COMMUNICATIONS & DOCUMENTARY FILM', $ppid );
        rs_save_field( 'hero_title_line1', 'Strategic Narratives in Action:', $ppid );
        rs_save_field( 'hero_title_line2', 'Films, Campaigns & Case Studies', $ppid );
        rs_save_field( 'hero_subtitle', 'Explore how Roger Sorkin uses ethnographic storytelling, trusted messengers, and cinematic production to reframe contentious issues, unite polarized audiences, and accelerate policy solutions.', $ppid );

        rs_save_field( 'stat_1_num', '11 Projects', $ppid );
        rs_save_field( 'stat_1_label', 'Documentary & Advisory', $ppid );
        rs_save_field( 'stat_2_num', 'Bipartisan', $ppid );
        rs_save_field( 'stat_2_label', 'Legislative Impact', $ppid );
        rs_save_field( 'stat_3_num', 'NATO & Pentagon', $ppid );
        rs_save_field( 'stat_3_label', 'Defense Briefings', $ppid );
        rs_save_field( 'stat_4_num', '10M+', $ppid );
        rs_save_field( 'stat_4_label', 'Civics Viewers', $ppid );

        // Systemic Methodology
        rs_save_field( 'approach_tag', 'SYSTEMIC METHODOLOGY', $ppid );
        rs_save_field( 'approach_title', 'My Creative Approach', $ppid );
        rs_save_field( 'approach_story1', "When I heard a combat veteran describe losing his friend to a fuel convoy attack in Iraq, I recognized a powerful untold story: how our military's dependence on fossil fuels was costing lives and undermining national security.", $ppid );
        rs_save_field( 'approach_story2', 'This insight became The Burden, a groundbreaking documentary that bridged unlikely allies: environmental advocates, defense conservatives, and military commanders: through a shared solution with different motivations. One policy wonk called it "a white paper disguised as a film": perhaps the greatest compliment possible for my approach.', $ppid );
        rs_save_field( 'step_1_title', 'Identify Communication Gaps', $ppid );
        rs_save_field( 'step_1_text', 'Pinpoint precisely where public discourse and policy negotiations have stalled due to polarization or narrative fatigue.', $ppid );
        rs_save_field( 'step_2_title', 'Deploy Trusted Messengers', $ppid );
        rs_save_field( 'step_2_text', 'Center authentic voices: veterans, farmers, engineers, and executives: who command respect from skeptical audiences.', $ppid );
        rs_save_field( 'step_3_title', 'Provide Clear Calls to Action', $ppid );
        rs_save_field( 'step_3_text', 'Deliver attainable pathways that convert emotional resonance into durable legislative and institutional change.', $ppid );
        rs_save_field( 'approach_badge_text', 'ON LOCATION • DOCUMENTARY DIRECTING', $ppid );
        rs_save_field( 'approach_quote_text', 'Each project is designed with specific outcomes in mind: a signal cutting through the noise to create measurable change.', $ppid );
        rs_save_field( 'approach_quote_author', 'Roger Sorkin • Founder & Director', $ppid );
    }

    // ------------------------------------------------------------------
    // 6. Seed Contact Page Fields
    // ------------------------------------------------------------------
    if ( ! empty( $page_ids['Contact'] ) ) {
        $cid = $page_ids['Contact'];
        rs_save_field( 'hero_badge_text', 'STRATEGIC ADVISORY • CONSULTATION INQUIRIES', $cid );
        rs_save_field( 'hero_title_line1', "Let's Build Common Ground", $cid );
        rs_save_field( 'hero_title_line2', 'Through High-Impact Storytelling', $cid );
        rs_save_field( 'hero_subtitle', "Whether you are navigating executive communication hurdles, preparing a high-stakes legislative campaign, or commissioning an impact documentary, let's discuss how strategic narratives can turn your challenge into an advantage.", $cid );

        rs_save_field( 'stat_1_num', 'Global', $cid );
        rs_save_field( 'stat_1_label', 'D.C. & Worldwide Projects', $cid );
        rs_save_field( 'stat_2_num', '24-48h', $cid );
        rs_save_field( 'stat_2_label', 'Direct Response Window', $cid );
        rs_save_field( 'stat_3_num', '30 Min', $cid );
        rs_save_field( 'stat_3_label', 'Initial Consultation', $cid );
        rs_save_field( 'stat_4_num', '100%', $cid );
        rs_save_field( 'stat_4_label', 'Strict Confidentiality', $cid );

        rs_save_field( 'inquiry_box_title', 'Direct Consultation & Advisory', $cid );
        rs_save_field( 'inquiry_box_desc', 'Roger Sorkin works with a limited number of organizations, coalitions, and production partners each year to ensure uncompromising depth, senior-level attention, and narrative impact.', $cid );
    }

    // ------------------------------------------------------------------
    // 7. Seed Testimonials
    // ------------------------------------------------------------------
    $testimonials = array(
        array(
            'name'  => 'Rear Admiral Ann Phillips',
            'title' => 'USN (RET.)',
            'quote' => "Roger created a strategic narrative that didn't just document our flooding challenges, it catalyzed cross-jurisdictional collaboration that resulted in action that's harder to accomplish through traditional advocacy channels.",
            'order' => 1,
        ),
        array(
            'name'  => 'David Gautschi',
            'title' => 'FOUNDER & CEO, TILT GLOBAL DECISIONS',
            'quote' => 'Roger opened doors for our company by helping us communicate to our investors and other stakeholders the complexities and urgency of a just energy transition.',
            'order' => 2,
        ),
        array(
            'name'  => 'Nicole Lederer',
            'title' => 'CHAIRMAN & FOUNDER, E2',
            'quote' => "Roger's films are strategic tools for lawmakers to understand how public policies affect their constituents, and for citizens to advocate for the policies they need.",
            'order' => 3,
        ),
        array(
            'name'  => 'John Szoka',
            'title' => 'CEO, CONSERVATIVE ENERGY NETWORK',
            'quote' => "Roger's was one of the most original and effective sessions we've ever hosted. Our staff and allied advocates didn't just hear about tough conversations, they lived them, and got better in real time.",
            'order' => 4,
        ),
    );

    foreach ( $testimonials as $t ) {
        $existing = get_page_by_title( $t['name'], OBJECT, 'testimonial' );
        $tid = $existing ? $existing->ID : null;
        if ( ! $existing ) {
            $tid = wp_insert_post( array(
                'post_title'   => $t['name'],
                'post_content' => $t['quote'],
                'post_status'  => 'publish',
                'post_type'    => 'testimonial',
                'menu_order'   => $t['order'],
            ) );
        }
        if ( $tid ) {
            rs_save_field( 'author_title',  $t['title'], $tid );
            rs_save_field( 'featured_home', 1,           $tid );
        }
    }

    // ------------------------------------------------------------------
    // 8. Seed the 8 Services
    // ------------------------------------------------------------------
    $services = array(
        array(
            'slug'        => 'fractional-cco',
            'photo_path'  => 'services/roger-sorkin-senator-angus-king.webp',
            'title'       => 'Fractional Communications Officer',
            'tagline'     => 'Seasoned C-suite vision, judgment, and crisis counsel.',
            'cap_tag'     => 'CAPABILITY 01 • STRATEGIC LEADERSHIP',
            'line1'       => 'Fractional Communications Officer:',
            'line2'       => 'Vision & Counsel Under Pressure',
            'lead'        => 'Not every organization needs a full-time chief communications officer, though many would benefit from the vision, seasoned judgment, and efficiency the role brings to decisions made under pressure.',
            'body'        => 'This is especially crucial at critical turning points during the growth of mission-driven enterprises, young companies, and non-profit coalitions. As your fractional communications leader, Roger integrates directly with leadership to provide high-level clarity without the long-term overhead of an executive hire.',
            'deliv_title' => 'Core Capabilities & Deliverables',
            'delivs_text' => "Ongoing C-suite strategic counsel\nInternal & external messaging oversight\nExecutive support & speech preparation\nCrisis preparedness & rapid response",
            'order'       => 1,
        ),
        array(
            'slug'        => 'audit',
            'photo_path'  => 'services/speaking-1.webp',
            'title'       => 'Communications Audit',
            'tagline'     => 'On-site diagnostic identifying messaging friction at the root.',
            'cap_tag'     => 'CAPABILITY 02 • DIAGNOSTIC ASSESSMENT',
            'line1'       => 'Communications Audit:',
            'line2'       => 'Diagnosing Friction at the Root',
            'lead'        => 'When an organization senses that its communications are not landing the way they should, the instinct is often to reach for a quick fix: a new campaign, fresh marketing, or a media push.',
            'body'        => 'Without a clear, candid read on what is actually causing the friction, those reactionary measures tend to address the symptom rather than the underlying cause. The Communications Audit helps your organization take a meaningful look at the full picture through an immersive on-site assessment.',
            'deliv_title' => 'Audit Process & Deliverables',
            'delivs_text' => "On-site immersion & executive discovery\nCandid cross-departmental interviews\nRoot-cause narrative friction analysis\nActionable roadmap with clear priorities",
            'order'       => 2,
        ),
        array(
            'slug'        => 'simulations',
            'photo_path'  => 'services/roger-hawaii.webp',
            'title'       => 'Simulations and Role-Playing Training',
            'tagline'     => 'Safe scenario testing for boardrooms and hearings.',
            'cap_tag'     => 'CAPABILITY 03 • IMMERSIVE PREPAREDNESS',
            'line1'       => 'Simulations & Role-Playing:',
            'line2'       => 'Stress-Testing Strategy Before It Counts',
            'lead'        => 'The best time to discover how your team responds to an unpredictable stakeholder confrontation or media crisis is not when microphones are on and reputations are on the line.',
            'body'        => 'Drawing from methodologies refined across universities and executive seminars, Roger designs custom scenario simulations that put leadership in realistic, high-pressure environments to test strategies safely.',
            'deliv_title' => 'Simulation Components',
            'delivs_text' => "Custom conflict scenario design\nReal-time multi-stakeholder role playing\nImmediate video playback & debrief\nCrisis response playbooks",
            'order'       => 3,
        ),
        array(
            'slug'        => 'media-training',
            'photo_path'  => 'services/roger-state-leg.webp',
            'title'       => 'Media Training',
            'tagline'     => 'Spokesperson interview readiness and soundbite craft.',
            'cap_tag'     => 'CAPABILITY 04 • SPOKESPERSON READINESS',
            'line1'       => 'Media Training:',
            'line2'       => 'Mastering the Soundbite & Staying on Message',
            'lead'        => "In today's rapid media ecosystem, complex ideas are routinely compressed into eight-second clips and contentious headlines.",
            'body'        => 'Roger teaches executives, scientists, and spokespeople how to reframe challenging questions, pivot effectively, and deliver memorable messages that withstand adversarial interviews.',
            'deliv_title' => 'Training Curriculum',
            'delivs_text' => "On-camera interview drills & technique\nMessage framing & bridging tactics\nSoundbite & quote refinement\nHandling hostile questioning",
            'order'       => 4,
        ),
        array(
            'slug'        => 'coaching',
            'photo_path'  => 'services/roger-interview.webp',
            'title'       => 'Executive Coaching',
            'tagline'     => '1-on-1 speechwriting and commanding delivery.',
            'cap_tag'     => 'CAPABILITY 05 • EXECUTIVE ADVISORY',
            'line1'       => 'Executive Coaching:',
            'line2'       => 'Commanding Delivery & Keynote Speechwriting',
            'lead'        => 'Public presence is not an innate gift; it is a discipline that can be mastered with thoughtful, experienced guidance.',
            'body'        => 'Roger works one-on-one with leaders to help them find their authentic voice, refine keynote speeches, and project authority before boards, investors, and legislative committees.',
            'deliv_title' => 'Coaching Focus Areas',
            'delivs_text' => "Keynote speechwriting & narrative structuring\nStage presence & voice modulation\nSlide & visual presentation coaching\nHigh-stakes hearing preparation",
            'order'       => 5,
        ),
        array(
            'slug'        => 'content-roadmap',
            'photo_path'  => 'services/rancher-solar-panels.webp',
            'title'       => 'Content Roadmap',
            'tagline'     => 'In-house storytelling systems built to sustain.',
            'cap_tag'     => 'CAPABILITY 06 • SYSTEMIC STORYTELLING',
            'line1'       => 'Content Roadmap:',
            'line2'       => 'Sustainable In-House Storytelling Engines',
            'lead'        => 'One-off videos and sporadic press releases fail to build lasting narrative momentum.',
            'body'        => 'Roger builds systematic, sustainable storytelling roadmaps tailored to your organizational capacity, aligning internal teams and agency partners around cohesive editorial calendars.',
            'deliv_title' => 'Roadmap Deliverables',
            'delivs_text' => "Comprehensive multi-channel content calendar\nAudience segmentation & messaging matrix\nIn-house production workflow templates\nKPI tracking & narrative measurement",
            'order'       => 6,
        ),
        array(
            'slug'        => 'podcast',
            'photo_path'  => 'services/roger-profile-3.webp',
            'title'       => 'Podcast Production',
            'tagline'     => 'End-to-end series building weekly thought leadership.',
            'cap_tag'     => 'CAPABILITY 07 • AUDIO THOUGHT LEADERSHIP',
            'line1'       => 'Podcast Production:',
            'line2'       => 'Building Deep Audience Relationships Through Audio',
            'lead'        => 'Audio remains one of the most intimate, trust-building mediums for complex discussions and policy thought leadership.',
            'body'        => 'From conceptual framing and guest curation to full broadcast engineering and distribution, Roger develops high-caliber podcast properties that establish your leadership at scale.',
            'deliv_title' => 'Production Scope',
            'delivs_text' => "Series concept & format architecture\nGuest vetting, research & question design\nStudio-grade audio mastering & editing\nDistribution & promotional cutdowns",
            'order'       => 7,
        ),
        array(
            'slug'        => 'filmmaking',
            'photo_path'  => 'services/woman-interview-creation.webp',
            'title'       => 'Impact Filmmaking',
            'tagline'     => 'Human documentaries built to convene lawmakers.',
            'cap_tag'     => 'CAPABILITY 08 • DOCUMENTARY FILMMAKING',
            'line1'       => 'Impact Filmmaking:',
            'line2'       => 'Storytelling Engineered for Legislative Action',
            'lead'        => 'Data informs minds, but human stories move people to action.',
            'body'        => "Roger's award-winning documentaries have screened before Congressional committees, at NATO doctrine exercises, and on public television nationwide, creating dialogue where traditional lobbying fails.",
            'deliv_title' => 'Film Production Services',
            'delivs_text' => "Full-scale documentary production & directing\nConstituent & trusted-messenger casting\nCongressional & statehouse screening campaigns\nEducational curricula & public distribution",
            'order'       => 8,
        ),
    );

    foreach ( $services as $s ) {
        $existing = get_page_by_path( $s['slug'], OBJECT, 'service' );
        $sid = $existing ? $existing->ID : null;
        if ( ! $existing ) {
            $sid = wp_insert_post( array(
                'post_title'  => $s['title'],
                'post_name'   => $s['slug'],
                'post_status' => 'publish',
                'post_type'   => 'service',
                'menu_order'  => $s['order'],
            ) );
        }
        if ( $sid ) {
            rs_save_field( 'anchor_id',          $s['slug'],        $sid );
            if ( ! empty( $s['photo_path'] ) ) { rs_save_field( 'photo_path', $s['photo_path'], $sid ); }
            rs_save_field( 'tagline',            $s['tagline'],     $sid );
            rs_save_field( 'capability_tag',     $s['cap_tag'],     $sid );
            rs_save_field( 'title_line1',        $s['line1'],       $sid );
            rs_save_field( 'title_line2',        $s['line2'],       $sid );
            rs_save_field( 'lead_text',          $s['lead'],        $sid );
            rs_save_field( 'body_text',          $s['body'],        $sid );
            rs_save_field( 'deliverables_title', $s['deliv_title'], $sid );
            rs_save_field( 'deliverables_text',  $s['delivs_text'], $sid );
            rs_save_field( 'cta_label',          'Engage Service →', $sid );
            rs_save_field( 'cta_url',            '/contact/',       $sid );
        }
    }

    // ------------------------------------------------------------------
    // 9. Seed ALL 11 Projects
    // ------------------------------------------------------------------
    $projects = array(
        array(
            'slug'         => 'the-burden',
            'title'        => 'The Burden',
            'category'     => 'Defense & Energy',
            'cat_pill'     => 'DEFENSE & ENERGY • FEATURE DOCUMENTARY (2015)',
            'subtitle'     => 'How Roger Sorkin mobilized senior military leadership as trusted messengers to bridge partisan divides, protect DoD clean energy initiatives, and influence defense authorization.',
            'poster_path'  => 'projects/the-burden.webp',
            'hover_tag'    => 'Defense & Energy',
            'card_accent'  => 'The Burden',
            'card_cta'     => 'Case Study Details →',
            'hover_text'   => 'How Roger Sorkin mobilized senior military leadership as trusted messengers to bridge partisan divides, protect DoD clean energy initiatives, and influence defense authorization.',
            'stats'        => array( array( 'NATO Doctrine', 'Allied Operational Exercises' ), array( 'NDAA Impact', 'Congressional Defense Authorization' ), array( '2 Major Awards', 'Clean Skies & Audience Prize' ), array( 'Bipartisan', 'Military & Clean Energy Coalition' ) ),
            'snapshot'     => array( 'Entity' => 'American Resilience Project', 'Director' => 'Roger Sorkin', 'Format' => '40-Minute Feature Documentary', 'Release' => '2015', 'Messengers' => 'Combat Veterans, Generals, Navy Admirals', 'link_url' => 'https://www.amresproject.org/the-burden', 'link_label' => 'Watch the Full Film →' ),
            'purpose_h'    => 'Reframe fossil fuel dependence as a national security issue to build broader support for clean energy initiatives.',
            'purpose_c'    => '<p>When Roger Sorkin heard a combat veteran describe losing his friend to a fuel convoy attack in Iraq, he recognized a powerful untold story: how our military\'s dependence on fossil fuels was costing lives and undermining national security.</p><p>By shifting the conversation away from polarizing political rhetoric and focusing instead on troop survival, supply-line vulnerability, and operational resilience, <em>The Burden</em> bridged environmental advocates and military leadership through a shared solution with different motivations.</p><p>Successfully influenced legislation and policy at local, state, and federal levels by identifying military leaders as trusted messengers on energy transition.</p>',
            'impact_h'     => '',
            'impact_intro' => '',
            'bullets'      => array( array( 'Global NATO Doctrine:', 'Screened globally as part of NATO military doctrine and training exercises, opening new dialogue channels between security and environmental stakeholders.' ), array( 'NDAA Legislative Language:', 'Directly informed bipartisan provisions in the National Defense Authorization Act (NDAA) advancing operational energy efficiency and tactical microgrids.' ), array( 'Defended DoD Mandates:', 'Mobilized senior military leadership to protect Department of Defense renewable energy directives against repeal attempts on Capitol Hill.' ) ),
            'awards'       => array( array( 'Audience Award • Best Feature Documentary', 'Long Beach International Film Festival (2015)' ), array( 'Energy Visions Prize', 'American Clean Skies Foundation' ) ),
            'quote'        => 'A white paper disguised as a film: perhaps the greatest compliment possible for my approach.',
            'cite'         => 'Senior Congressional Energy Policy Advisor • Roger Sorkin',
            'video_url'    => 'https://player.vimeo.com/video/164196442?dnt=1',
            'video_title'  => 'Watch The Burden',
            'video_desc'   => 'See how four-star generals, combat veterans, and national security experts reframed clean energy as an indispensable military force multiplier.',
            'order'        => 1,
        ),
        array(
            'slug'         => 'tidewater',
            'title'        => 'Tidewater',
            'category'     => 'National Security',
            'cat_pill'     => 'NATIONAL SECURITY • DOCUMENTARY FILM (2017)',
            'subtitle'     => 'How Roger Sorkin highlighted sea level rise as an urgent national security threat to 18 military installations in Hampton Roads, catalyzing unprecedented collaboration and Congressional defense authorization.',
            'poster_path'  => 'projects/Tidewater-Poster-25.webp',
            'hover_tag'    => 'National Security',
            'card_accent'  => 'Tidewater',
            'card_cta'     => 'Case Study Details →',
            'hover_text'   => 'How Roger Sorkin highlighted sea level rise as an urgent national security threat to 18 military installations in Hampton Roads, catalyzing unprecedented collaboration and Congressional defense authorization.',
            'stats'        => array( array( 'NDAA Enacted', 'Defense Authorization Focus' ), array( 'Hampton Roads', '18 Military Commands & Cities' ), array( 'Green Fire Award', 'SF Green Film Festival' ), array( 'Bipartisan Tour', 'Capitol Hill & Pentagon' ) ),
            'snapshot'     => array( 'Client / Producer' => 'American Resilience Project', 'Director / Writer' => 'Roger Sorkin', 'Key Messengers' => 'Navy Admirals, City Mayors, Civil Engineers', 'Primary Focus' => 'Sea Level Rise, Military Readiness & Infrastructure', 'Key Screenings' => 'Capitol Hill, Pentagon, WHRO Public Television', 'link_url' => 'https://www.amresproject.org/tidewater-film', 'link_label' => 'Watch Full Film on AmResProject →' ),
            'purpose_h'    => 'The Strategic Purpose & Challenge',
            'purpose_c'    => '<p>Hampton Roads, Virginia is home to the highest concentration of military assets in the United States, including Naval Station Norfolk: the world\'s largest naval base. Recurrent tidal flooding and accelerating sea level rise routinely submerged primary access corridors, overwhelmed electrical substations, and threatened daily operational readiness for thousands of service members.</p><p>Yet regional political discourse remained paralyzed by climate skepticism and entrenched jurisdictional silos separating federal military commands from municipal city councils. The challenge was to reframe sea level rise not as an ideological talking point, but as an immediate threat to military readiness and regional economic survival that required urgent, collective defense action.</p><p>By deploying senior naval leadership, combat veterans, and municipal engineers as trusted messengers, <em>Tidewater</em> transcended ideological gridlock. Screened directly for members of the House and Senate Armed Services Committees, the film provided vital narrative backing that led to explicit language in the National Defense Authorization Act (NDAA) directing the Pentagon to evaluate and mitigate climate threats across domestic installations.</p>',
            'impact_h'     => '',
            'impact_intro' => '',
            'bullets'      => array( array( 'Legislative Authorization:', 'Directly influenced Congressional authorization requiring DoD-wide climate vulnerability assessments.' ), array( 'Inter-Agency Collaboration:', 'Catalyzed regular joint resilience summits between 18 military commands and municipal civic planners.' ), array( 'Public Broadcast Reach:', 'Broadcast extensively across regional PBS affiliates to educate coastal defense communities.' ) ),
            'awards'       => array( array( 'Green Fire Award Winner', 'San Francisco Green Film Festival (2017)' ), array( 'Special Congressional Screening', 'US Capitol Visitor Center, Washington, D.C.' ) ),
            'quote'        => 'In Hampton Roads, sea level rise is not a distant theoretical scenario: it is an immediate challenge to mission readiness, logistics corridors, and military families.',
            'cite'         => 'Rear Admiral David Titley, USN (Ret.) • Former Oceanographer of the Navy',
            'video_url'    => 'https://player.vimeo.com/video/671124389?dnt=1',
            'video_title'  => 'Watch Tidewater',
            'video_desc'   => 'Watch the trailer illustrating how rising waters challenge military readiness and how defense commanders are uniting with civic partners to adapt.',
            'order'        => 2,
        ),
        array(
            'slug'         => 'fordham-simulation',
            'title'        => 'Fordham University Business School',
            'category'     => 'Executive Education',
            'cat_pill'     => 'EXECUTIVE EDUCATION • SCENARIO SIMULATION CASE STUDY',
            'subtitle'     => 'How Roger Sorkin designed immersive crisis simulations for Fordham University\'s Gabelli School of Business, training executive MBA cohorts to navigate politically sensitive stakeholder conflicts with nuance and empathy.',
            'poster_path'  => 'projects/roger-sorkin-case-study.webp',
            'hover_tag'    => 'Executive Education',
            'card_accent'  => 'Fordham University Business School',
            'card_cta'     => 'Case Study Details →',
            'hover_text'   => 'How Roger Sorkin designed immersive crisis simulations for Fordham University\'s Gabelli School of Business, training executive MBA cohorts to navigate politically sensitive stakeholder conflicts with nuance and empathy.',
            'stats'        => array( array( 'Executive MBA', 'Core Leadership Curriculum' ), array( 'Live Simulation', 'Crisis Negotiation Format' ), array( 'Nuanced Framing', 'Counter-Framing & Empathy' ), array( 'Measurable Skill', 'Documented Skill Growth' ) ),
            'snapshot'     => array( 'Client / Institution' => 'Fordham University Gabelli School of Business', 'Simulation Designer' => 'Roger Sorkin', 'Methodology' => 'Immersive Role-Play, Stakeholder Mapping & Crisis Drills', 'Focus Area' => 'Corporate Governance, Energy Conflicts & Stakeholder Diplomacy', 'Core Deliverables' => 'Scenario Dossiers, Role Cards & Evaluation Rubrics', 'link_url' => 'assets/docs/Roger-Sorkin-Case-Study-FORDHAM-UNIVERSITY.pdf', 'link_label' => 'Download Full Case Study (PDF) →' ),
            'purpose_h'    => 'The Strategic Purpose & Educational Need',
            'purpose_c'    => '<p>Corporate executives and business leaders operate in an era of unprecedented ideological polarization. Issues ranging from carbon accounting and supply chain decarbonization to community labor disputes regularly trigger intense public scrutiny and internal organizational conflict.</p><p>Fordham University\'s Gabelli School of Business recognized that conventional lecture-based instruction and passive case studies failed to prepare students for real-world stakeholder warfare. They needed an immersive pedagogy that forced graduate business students to step into the shoes of ideological adversaries, practice active listening under pressure, and discover mutually beneficial policy compromises.</p><p>Roger Sorkin architected an intensive multi-stakeholder simulation model where students were assigned divergent stakeholder roles: fossil fuel executives, environmental justice organizers, state utility regulators, and defense planners. Over dynamic negotiating rounds, students were evaluated on their ability to build durable consensus without abandoning core organizational mandates.</p>',
            'impact_h'     => '',
            'impact_intro' => '',
            'bullets'      => array( array( 'Visceral Muscle Memory:', 'Replaced abstract theory with realistic, high-pressure negotiating drills that mirrored executive board dynamics.' ), array( 'Ethnographic Empathy:', 'Trained business leaders to uncover unstated emotional motivations behind opposing stakeholder positions.' ), array( 'Institutional Adoption:', 'Established a recurring pedagogical framework utilized across executive education cohorts at Fordham.' ) ),
            'awards'       => array(  ),
            'quote'        => 'Immersive scenario simulations force future corporate leaders out of intellectual comfort zones, creating the emotional muscle memory required to lead through deep political polarization.',
            'cite'         => 'Roger Sorkin • Scenario Simulation Designer & Coach',
            'video_url'    => '',
            'video_title'  => 'Ready to Start Thinking About Your Communication Strategy?',
            'video_desc'   => '',
            'order'        => 3,
        ),
        array(
            'slug'         => 'clean-economy-now',
            'title'        => 'Clean Economy Now',
            'category'     => 'Clean Economy',
            'cat_pill'     => 'ENERGY TRANSITION • FORTHCOMING DOCUSERIES',
            'subtitle'     => 'Defending and accelerating the clean energy transition by spotlighting its concrete economic, job-creation, and manufacturing revival benefits across diverse American heartland regions.',
            'poster_path'  => 'projects/clean-economy-now-cover.webp',
            'hover_tag'    => 'Clean Economy',
            'card_accent'  => 'Clean Economy Now',
            'card_cta'     => 'Case Study Details →',
            'hover_text'   => 'Defending and accelerating the clean energy transition by spotlighting its concrete economic, job-creation, and manufacturing revival benefits across diverse American heartland regions.',
            'stats'        => array( array( 'National Scope', 'Frontline U.S. Workers & Mfg' ), array( 'Forthcoming', 'Nationwide Release Scheduled' ), array( 'Economic Framing', 'Domestic Industrial Renewal' ), array( 'Bipartisan Appeal', 'Heartland Clean Tech Coalition' ) ),
            'snapshot'     => array( 'Production Entity' => 'American Resilience Project', 'Executive Producer' => 'Roger Sorkin', 'Featured Voices' => 'Industrial Lineworkers, Plant Managers, Engineers', 'Strategic Focus' => 'Clean Manufacturing, Grid Investment & Job Creation', 'Production Phase' => 'Post-Production & Distribution Strategy', 'link_url' => 'contact.html', 'link_label' => 'Sign Up for Release Updates →' ),
            'purpose_h'    => 'The Strategic Purpose & Narrative Challenge',
            'purpose_c'    => '<p>Historic federal and private investments have ignited an unprecedented clean technology manufacturing boom across the United States. New battery mega-factories, solar assembly plants, and critical mineral processing centers are revitalizing regions that suffered decades of deindustrialization.</p><p>However, public discourse remains dominated by ideological narratives that mischaracterize the clean energy transition as a punitive regulatory burden rather than an economic lifeline. <em>Clean Economy Now</em> was conceived to puncture this false dichotomy by documenting how clean energy investments directly create family-sustaining union jobs, expand municipal tax revenues, and restore American manufacturing supremacy.</p><p>Currently in post-production, the docuseries travels directly to heartland manufacturing towns and energy communities. By letting everyday tradespeople, factory directors, and local elected leaders articulate the tangible benefits to their hometowns, the project constructs an unassailable economic narrative that protects clean energy momentum across changing political administrations.</p>',
            'impact_h'     => '',
            'impact_intro' => '',
            'bullets'      => array( array( 'Countering Disinformation:', 'Reframes clean energy investments from ideological debates into verifiable domestic economic gains.' ), array( 'Heartland Messenger Focus:', 'Empowers local industrial workers and mayors as the primary storytellers.' ), array( 'Strategic Campaign Integration:', 'Prepared in tandem with economic development groups, labor organizations, and business alliances.' ) ),
            'awards'       => array(  ),
            'quote'        => 'Clean energy is not a sacrifice or an abstract aspiration: it is the greatest domestic industrial modernization and wealth-building frontier of the twenty-first century.',
            'cite'         => 'Roger Sorkin • Executive Producer & Director',
            'video_url'    => '',
            'video_title'  => 'Ready to Start Thinking About Your Communication Strategy?',
            'video_desc'   => '',
            'order'        => 4,
        ),
        array(
            'slug'         => 'farm-free-or-die',
            'title'        => 'Farm Free or Die',
            'category'     => 'Agriculture',
            'cat_pill'     => 'AGRICULTURE & FOOD SECURITY • DOCUMENTARY FILM (2022)',
            'subtitle'     => 'How Roger Sorkin amplified authentic farmer voices to transform agricultural resilience from an ideological flashpoint into common-sense economic policy in the federal Farm Bill.',
            'poster_path'  => 'projects/Farm-Free-Poster-18.webp',
            'hover_tag'    => 'Agriculture',
            'card_accent'  => 'Farm Free or Die',
            'card_cta'     => 'Case Study Details →',
            'hover_text'   => 'How Roger Sorkin amplified authentic farmer voices to transform agricultural resilience from an ideological flashpoint into common-sense economic policy in the federal Farm Bill.',
            'stats'        => array( array( 'Farm Bill Impact', 'Soil Health Conservation' ), array( '100% Farmer-Led', 'Generational Growers & Ranchers' ), array( 'Nationwide Tour', 'Farm Bureaus & Congress' ), array( 'Bipartisan', 'Agriculture & Conservation' ) ),
            'snapshot'     => array( 'Client / Producer' => 'American Resilience Project', 'Director / Writer' => 'Roger Sorkin', 'Key Messengers' => 'Family Farmers, Soil Health Innovators, Agronomists', 'Primary Focus' => 'Regenerative Agriculture, Soil Carbon & Economic Survival', 'Distribution' => 'Congressional Briefings, Public Television, Agricultural Summits', 'link_url' => 'https://www.amresproject.org/farm-free-or-die', 'link_label' => 'Watch Full Film on AmResProject →' ),
            'purpose_h'    => 'The Strategic Purpose & Challenge',
            'purpose_c'    => '<p>American agricultural producers find themselves on the front lines of accelerating climate disruption: enduring prolonged droughts, catastrophic flash flooding, disappearing topsoil, and erratic growing seasons. Yet conventional environmental messaging frequently alienated farm communities by placing blame rather than recognizing farmers as indispensable conservation partners.</p><p>The strategic objective of <em>Farm Free or Die</em> was to remove partisan hostility by placing authentic, independent farmers at the heart of the narrative. The film demonstrates how regenerative soil management practices cut expensive chemical fertilizer inputs, retain moisture during droughts, and restore farm profitability: proving that environmental health and agricultural bottom lines are completely aligned.</p><p>Released ahead of critical federal Farm Bill negotiations, the film was screened for agricultural coalitions, farm bureau executives, and members of the House and Senate Agriculture Committees. By showcasing respected growers demonstrating real financial gains from soil stewardship, the documentary fostered rare bipartisan consensus on expanding USDA conservation incentives.</p>',
            'impact_h'     => '',
            'impact_intro' => '',
            'bullets'      => array( array( 'Legislative Organizing:', 'Served as a centerpiece organizing tool for agricultural coalitions lobbying for federal soil health funding.' ), array( 'Rural Peer-to-Peer Influence:', 'Catalyzed regional soil health workshops where skeptical growers learned directly from neighboring producers.' ), array( 'Public Broadcast Reach:', 'Distributed to millions of viewers via regional public broadcasting systems.' ) ),
            'awards'       => array( array( 'Official Selection', 'Environmental Film Festival in the Nation\'s Capital' ), array( 'Congressional Briefing Showcase', 'US Capitol Agriculture Working Group' ) ),
            'quote'        => 'When farmers speak for themselves about soil health, fertilizer costs, and profitability, ideological divisions vanish and durable policy takes root.',
            'cite'         => 'Roger Sorkin • Founder & Director, American Resilience Project',
            'video_url'    => 'https://player.vimeo.com/video/669500610?dnt=1',
            'video_title'  => 'Watch Farm Free or Die',
            'video_desc'   => 'Watch the trailer showing how American farmers are rebuilding soil biology, protecting their livelihoods, and pioneering climate solutions.',
            'order'        => 5,
        ),
        array(
            'slug'         => 'current-revolution',
            'title'        => 'The Current Revolution',
            'category'     => 'Energy Grid',
            'cat_pill'     => 'GRID MODERNIZATION • 3-PART FILM SERIES (2018-2020)',
            'subtitle'     => 'A multi-part documentary series demonstrating the technological readiness, national security imperatives, and high-wage workforce opportunities of modernizing America\'s electric grid.',
            'poster_path'  => 'projects/current-revolution.webp',
            'hover_tag'    => 'Energy Grid',
            'card_accent'  => 'The Current Revolution',
            'card_cta'     => 'Case Study Details →',
            'hover_text'   => 'A multi-part documentary series demonstrating the technological readiness, national security imperatives, and high-wage workforce opportunities of modernizing America\'s electric grid.',
            'stats'        => array( array( '3-Part Series', 'Features & Specialized Short' ), array( 'Chesapeake Winner', 'Best Environmental Short Award' ), array( 'Utility Alignment', 'Regulators & Labor Unions' ), array( 'Workforce Focus', 'Grid Modernization Pathways' ) ),
            'snapshot'     => array( 'Producer' => 'American Resilience Project', 'Director & EP' => 'Roger Sorkin', 'Key Messengers' => 'Power Engineers, Utility CEOs, Lineworkers, Economists', 'Core Focus' => 'Distributed Generation, Microgrids, Cybersecurity & Storage', 'Distribution' => 'Public Television, Universities, Industry Summits', 'link_url' => 'https://www.amresproject.org/current-revolution-series', 'link_label' => 'Watch Full Film on AmResProject →' ),
            'purpose_h'    => 'The Strategic Purpose & Systemic Challenge',
            'purpose_c'    => '<p>America\'s centralized electric grid: often called the supreme engineering achievement of the twentieth century: was never engineered for the demands of the twenty-first. Extreme weather catastrophes, cyber warfare risks, and massive demand surges from electrification and computing strain outdated legacy infrastructure.</p><p>Yet regulatory inertia, conflicting utility business models, and political mischaracterizations threatened to paralyze grid modernization investments. The goal of <em>Current Revolution</em> was to create a technically rigorous yet visually captivating series that made modern grid architecture accessible to lawmakers, business executives, and consumers alike.</p><p>Comprising two feature films (<em>Current Revolution: Nation in Transition</em>, <em>Current Revolution: The Great Disruption</em>) and the award-winning short, the series became an indispensable educational asset across state regulatory dockets and clean energy executive conferences.</p>',
            'impact_h'     => '',
            'impact_intro' => '',
            'bullets'      => array( array( 'Regulatory Briefings:', 'Screened before state public utility commissions (PUCs) navigating renewable portfolio standards and interconnection rules.' ), array( 'Workforce Pathways:', 'Showcased utility lineworkers and engineers transitioning into smart-grid and microgrid careers, calming union apprehensions.' ), array( 'National Defense Alignment:', 'Demonstrated how military bases rely on islandable microgrids to ensure mission survival during regional blackout events.' ) ),
            'awards'       => array( array( 'Best Environmental Short', 'Chesapeake Film Festival (2018)' ), array( 'Official Selection', 'Colorado Environmental Film Festival' ) ),
            'quote'        => 'A modern electric grid is not an elective luxury: it is the indispensable backbone of American technological sovereignty, physical defense, and economic security.',
            'cite'         => 'Roger Sorkin • Director & Executive Producer',
            'video_url'    => 'https://player.vimeo.com/video/671134533?dnt=1',
            'video_title'  => 'Watch Current Revolution Series',
            'video_desc'   => 'Watch the trailer showing how smart grids, battery storage, and distributed renewable energy are transforming our power system.',
            'order'        => 6,
        ),
        array(
            'slug'         => 'nation-in-transition',
            'title'        => 'A Nation in Transition',
            'category'     => 'Workforce & Energy',
            'cat_pill'     => 'TRIBAL SOVEREIGNTY • DOCUMENTARY FILM (2020)',
            'subtitle'     => 'Created in partnership with Arizona State University to explore the coal-to-renewables transition on the Navajo Nation and establish an actionable blueprint for equitable energy transitions respecting sovereign indigenous rights.',
            'poster_path'  => 'projects/Current-Rev-NIT-Poster-15.webp',
            'hover_tag'    => 'Workforce & Energy',
            'card_accent'  => 'A Nation in Transition',
            'card_cta'     => 'Case Study Details →',
            'hover_text'   => 'Created in partnership with Arizona State University to explore the coal-to-renewables transition on the Navajo Nation and establish an actionable blueprint for equitable energy transitions respecting sovereign indigenous rights.',
            'stats'        => array( array( 'ASU Partnership', 'Global Institute of Sustainability' ), array( 'Navajo Centered', 'Indigenous Community Focus' ), array( 'Just Transition', 'Clean Energy Replacement' ), array( 'Policy Blueprint', 'Federal Transition Guidelines' ) ),
            'snapshot'     => array( 'Academic Partner' => 'Arizona State University (Global Futures Laboratory)', 'Director / Producer' => 'Roger Sorkin', 'Key Messengers' => 'Navajo Tribal Officials, Former Coal Miners, Youth Leaders', 'Primary Focus' => 'Energy Sovereignty, Just Transition & Tribal Economy', 'Distribution' => 'Academic Symposia, Tribal Summits & Public Television', 'link_url' => 'https://www.amresproject.org/current-revolution-series', 'link_label' => 'Explore Series on AmResProject →' ),
            'purpose_h'    => 'The Strategic Purpose & Historic Dilemma',
            'purpose_c'    => '<p>The sudden retirement of the Navajo Generating Station: once the largest coal-fired power plant in the American West: and the associated Kayenta Mine dismantled the economic foundation of northern Arizona tribal communities, erasing hundreds of family-supporting jobs and critical tribal government revenue.</p><p>While environmental advocates celebrated the closure, indigenous communities faced severe economic hardship without viable replacement revenue or local power reliability. Partnering with Arizona State University\'s Julie Ann Wrigley Global Futures Laboratory, Roger Sorkin sought to document how clean energy development can be structured to restore tribal sovereignty, reinvest in local communities, and guarantee a truly just transition.</p><p>By embedding directly with Navajo miners, chapter house leaders, business owners, and utility executives, the film illuminated concrete pathways where large-scale solar arrays and battery storage generate tribal revenue while training displaced workers in high-tech renewable construction.</p>',
            'impact_h'     => '',
            'impact_intro' => '',
            'bullets'      => array( array( 'Federal Policy Guidance:', 'Screened for federal agencies and energy transition task forces to guide equitable transition grant allocations.' ), array( 'Tribal Energy Sovereignty:', 'Amplified the work of indigenous clean energy innovators pioneering community-owned utility projects.' ), array( 'Academic & Civic Dialogue:', 'Integrated into university curricula across the Southwest to teach energy justice and regional economic planning.' ) ),
            'awards'       => array( array( 'Official Academic Selection', 'ASU Sustainability Solutions Festival' ), array( 'Special Tribal Forum Screening', 'Inter-Tribal Energy Resilience Summit' ) ),
            'quote'        => 'A just transition is not philanthropy or an afterthought: it is our moral imperative to respect the sovereign nations and workers whose resources powered American prosperity for generations.',
            'cite'         => 'Roger Sorkin • Director & Fellow, Arizona State University',
            'video_url'    => '',
            'video_title'  => 'Ready to Start Thinking About Your Communication Strategy?',
            'video_desc'   => '',
            'order'        => 7,
        ),
        array(
            'slug'         => 'resilient-on-the-ground',
            'title'        => 'Resilient on the Ground',
            'category'     => 'Climate Resilience',
            'cat_pill'     => 'INFRASTRUCTURE • STRATEGIC COMMUNICATIONS CAMPAIGN',
            'subtitle'     => 'Strategic communications, executive narrative alignment, and public storytelling for the Indianapolis Airport Authority to celebrate and expand world-class sustainability achievements.',
            'poster_path'  => 'projects/resilient-on-the-ground-poster-1.webp',
            'hover_tag'    => 'Climate Resilience',
            'card_accent'  => 'Resilient on the Ground',
            'card_cta'     => 'Case Study Details →',
            'hover_text'   => 'Strategic communications, executive narrative alignment, and public storytelling for the Indianapolis Airport Authority to celebrate and expand world-class sustainability achievements.',
            'stats'        => array( array( '#1 in N. America', 'Ranked by ACI World' ), array( 'Executive Alignment', 'Cross-Departmental Strategy' ), array( 'Solar Leadership', 'Largest Airport Array' ), array( 'Civic Value', 'Regional Economic Pride' ) ),
            'snapshot'     => array( 'Client / Partner' => 'Indianapolis Airport Authority (IAA)', 'Communications Advisor' => 'Roger Sorkin', 'Key Messengers' => 'Aviation Directors, Facilities Engineers, Civic Leaders', 'Strategic Focus' => 'Aviation Sustainability, Solar Generation & Public Alignment', 'Deliverables Produced' => 'Communications Diagnostic Audit, Messaging Roadmap, Video Briefs', 'link_url' => 'contact.html', 'link_label' => 'Inquire About Custom Communications →' ),
            'purpose_h'    => 'The Strategic Purpose & Communications Hurdle',
            'purpose_c'    => '<p>Indianapolis International Airport (IND) is a world-class transit hub and home to the largest airport-based solar farm on the continent, alongside pioneering stormwater recycling, energy efficiency systems, and LEED-certified infrastructure. Despite these achievements, the airport authority faced narrative friction.</p><p>Internal operational departments (engineering, facilities, passenger experience, finance) operated in communications silos. Externally, the authority needed an accessible, pride-inducing narrative to communicate complex investments to travelers, airline partners, and civic oversight boards without triggering political resistance.</p><p>Roger Sorkin executed a comprehensive strategic communications engagement: conducting executive stakeholder diagnostics, synthesizing engineering data into human stories, and delivering a unified internal and external narrative framework.</p>',
            'impact_h'     => '',
            'impact_intro' => '',
            'bullets'      => array( array( 'Internal Cultural Cohesion:', 'Aligned operations, facilities, and communications teams around a shared narrative identity of civic stewardship.' ), array( 'Board & Airline Stakeholder Support:', 'Positioned sustainability initiatives as fiscal prudence and operational risk reduction, securing cross-board buy-in.' ), array( 'National Transportation Model:', 'Enhanced the airport\'s visibility as North America\'s premier example of resilient public transit infrastructure.' ) ),
            'awards'       => array(  ),
            'quote'        => 'When sustainability is articulated not as an ideological trend, but as rigorous fiscal management and operational excellence, every stakeholder becomes an active advocate.',
            'cite'         => 'Roger Sorkin • Strategic Communications Advisor',
            'video_url'    => '',
            'video_title'  => 'Ready to Start Thinking About Your Communication Strategy?',
            'video_desc'   => '',
            'order'        => 8,
        ),
        array(
            'slug'         => 'renewable-energy-rural-america',
            'title'        => 'Renewable Energy for Rural America',
            'category'     => 'Rural Renewables',
            'cat_pill'     => 'ADVOCACY & RURAL ECONOMY • MULTIMEDIA CAMPAIGN',
            'subtitle'     => 'A comprehensive multimedia campaign produced for the Natural Resources Defense Council (NRDC) and Environmental Entrepreneurs (E2), proving how clean energy investments revitalize farming economies and rural communities.',
            'poster_path'  => 'projects/renewable-energy-poster.webp',
            'hover_tag'    => 'Rural Renewables',
            'card_accent'  => 'Renewable Energy for Rural America',
            'card_cta'     => 'Case Study Details →',
            'hover_text'   => 'A comprehensive multimedia campaign produced for the Natural Resources Defense Council (NRDC) and Environmental Entrepreneurs (E2), proving how clean energy investments revitalize farming economies and rural communities.',
            'stats'        => array( array( 'NRDC & E2', 'Clean Business Coalition' ), array( 'Field Content', 'Profiles, Case Studies & Op-Eds' ), array( 'Rural Revenues', 'Preserving Family Farms' ), array( 'Policy Defense', 'Countering Zoning Bans' ) ),
            'snapshot'     => array( 'Clients / Partners' => 'Natural Resources Defense Council (NRDC) & E2', 'Narrative Producer' => 'Roger Sorkin', 'Key Messengers' => 'Family Farmers, County Commissioners, School Superintendents', 'Strategic Focus' => 'Rural Economic Revitalization, Lease Revenues & Local Tax Bases', 'Core Assets' => 'Field Video Library, Case Study Vignettes, Digital Advocacy Hub', 'link_url' => 'https://e2.org/renewables-for-rural-america/', 'link_label' => 'Watch Campaign Clips on E2 →' ),
            'purpose_h'    => 'The Strategic Purpose & Advocacy Imperative',
            'purpose_c'    => '<p>Across the American heartland, well-funded special interest groups launched aggressive disinformation campaigns aimed at convincing county commissions to enact moratoriums and zoning bans against wind and solar developments, falsely claiming clean energy harms local communities.</p><p>NRDC and Environmental Entrepreneurs (E2) needed an evidence-based, emotionally resonant storytelling initiative to debunk these claims. The mandate was to give voice to the rural landowners, school superintendents, and county commissioners who directly experience the financial benefits of hosting renewable energy infrastructure.</p><p>Roger Sorkin led field production across agricultural counties, documenting real farmers whose lease payments saved generational family farms from foreclosure, and local school administrators who built modern science labs funded by wind and solar property tax receipts.</p>',
            'impact_h'     => '',
            'impact_intro' => '',
            'bullets'      => array( array( 'Defeating Zoning Bans:', 'Testimonials were presented at critical county commission hearings, defeating anti-renewable ordinances in multiple states.' ), array( 'Trusted Rural Messengers:', 'Relied strictly on conservative rural community leaders rather than national environmental spokespeople.' ), array( 'Persistent Media Library:', 'Created a permanent video and case study repository utilized by clean energy advocates nationwide.' ) ),
            'awards'       => array(  ),
            'quote'        => 'Clean energy lease income acts as an essential, drought-proof financial shock absorber for rural family farms, allowing growers to keep land in the family for future generations.',
            'cite'         => 'Roger Sorkin • Media Campaign Producer',
            'video_url'    => '',
            'video_title'  => 'Ready to Start Thinking About Your Communication Strategy?',
            'video_desc'   => '',
            'order'        => 9,
        ),
        array(
            'slug'         => 'tedx-planet-action',
            'title'        => 'Roger Sorkin Speaks at TEDx',
            'category'     => 'Keynotes',
            'cat_pill'     => 'KEYNOTES & THOUGHT LEADERSHIP • TEDX ADDRESS',
            'subtitle'     => 'A keynote address on how narrative architecture, ethnographic listening, and credible trusted messengers break through cognitive dissonance to unlock systemic action on complex planetary challenges.',
            'poster_path'  => 'projects/planet-action-ted-x.webp',
            'hover_tag'    => 'Keynotes',
            'card_accent'  => 'Roger Sorkin Speaks at TEDx',
            'card_cta'     => 'Case Study Details →',
            'hover_text'   => 'A keynote address on how narrative architecture, ethnographic listening, and credible trusted messengers break through cognitive dissonance to unlock systemic action on complex planetary challenges.',
            'stats'        => array( array( 'TEDx Global', 'Planet Action Keynote' ), array( 'Trusted Messengers', 'Transcending Tribal Skepticism' ), array( 'Ethnography', 'Deep Cultural Storytelling' ), array( 'Advisory Model', 'Philanthropy & NGO Adoption' ) ),
            'snapshot'     => array( 'Event / Platform' => 'TEDx Boston / Planet Action', 'Keynote Speaker' => 'Roger Sorkin', 'Core Themes' => 'Behavioral Psychology, Ideological Polarization & Narrative Design', 'Target Audience' => 'Philanthropic Executives, Policy Strategists, Civic Leaders', 'Media Asset' => 'Live Stage Address & High-Definition Recording', 'link_url' => 'https://www.youtube.com/watch?v=uOaJCmCRapA', 'link_label' => 'Watch the Full Talk on YouTube →' ),
            'purpose_h'    => 'The Strategic Purpose & Core Thesis',
            'purpose_c'    => '<p>Cognitive psychology and communications research consistently confirm that inundating skeptical audiences with scientific charts, catastrophic warnings, and moral lectures triggers defensive psychological retrenchment rather than enlightened cooperation.</p><p>In this compelling TEDx address, Roger Sorkin confronted the foundational communication flaw crippling modern social and environmental movements. He demonstrated why effective narrative change requires deep ethnographic inquiry into the values, fears, and cultural heritage of target audiences before attempting to persuade them.</p><p>Drawing from his experiences creating <em>The Burden</em> and <em>Tidewater</em>, Sorkin outlined the operational mechanics of the \'trusted messenger framework\': illustrating how 4-star generals, combat veterans, and agricultural growers achieved bipartisan breakthroughs where traditional environmental advocacy had repeatedly stalled.</p>',
            'impact_h'     => '',
            'impact_intro' => '',
            'bullets'      => array( array( 'Executive Masterclasses:', 'Keynote led directly to executive communication workshops for corporate sustainability cohorts and universities.' ), array( 'Philanthropic Framing:', 'Guided major climate foundations in restructuring grant evaluation metrics around audience trust and narrative framing.' ), array( 'Bipartisan Application:', 'Established a universal methodology applied across criminal justice, energy security, and public health campaigns.' ) ),
            'awards'       => array( array( 'Featured TEDx Keynote', 'TEDx Boston / Planet Action Conference' ), array( 'Executive Masterclass Series', 'Adapted into Corporate & Philanthropic Seminars' ) ),
            'quote'        => 'If you want someone to change their mind, do not bombard them with data: first give them a story where they can see themselves as the hero, not the villain.',
            'cite'         => 'Roger Sorkin • TEDx Keynote Speaker & Documentary Director',
            'video_url'    => 'https://www.youtube-nocookie.com/embed/uOaJCmCRapA?rel=0&amp;modestbranding=1&amp;playsinline=1',
            'video_title'  => 'Watch Roger Sorkin Speaks at TEDx',
            'video_desc'   => 'Watch Roger Sorkin\'s full TEDx address on how narrative strategy and trusted messengers overcome societal polarization.',
            'order'        => 10,
        ),
        array(
            'slug'         => '10-rules',
            'title'        => '10 Rules for Dealing with Police',
            'category'     => 'Civil Liberties',
            'cat_pill'     => 'CIVIL LIBERTIES & CIVICS • EDUCATIONAL FILM',
            'subtitle'     => 'A landmark educational docudrama created with Flex Your Rights, the ACLU, and LEAP, providing clear constitutional protocols to safely de-escalate law enforcement encounters and protect citizens and officers alike.',
            'poster_path'  => 'projects/10-rules.webp',
            'hover_tag'    => 'Civil Liberties',
            'card_accent'  => '10 Rules for Dealing with Police',
            'card_cta'     => 'Case Study Details →',
            'hover_text'   => 'A landmark educational docudrama created with Flex Your Rights, the ACLU, and LEAP, providing clear constitutional protocols to safely de-escalate law enforcement encounters and protect citizens and officers alike.',
            'stats'        => array( array( 'Millions Educated', 'Civics Education Impact' ), array( 'ACLU to Cato', 'Full Political Spectrum Reach' ), array( 'De-escalation', 'Proven Citizen Protocols' ), array( 'Police Endorsed', 'Law Enforcement Partnership' ) ),
            'snapshot'     => array( 'Collaborating Partners' => 'Flex Your Rights Foundation, ACLU, LEAP', 'Director / Filmmaker' => 'Roger Sorkin', 'Key Messengers' => 'Retired Police Commanders, Defense Lawyers, Civics Advocates', 'Core Focus' => '4th & 5th Amendment Rights, Community Safety, Conflict De-escalation', 'Distribution' => 'Viral Online Reach, Public Schools & Legal Education', 'link_url' => 'https://www.youtube.com/watch?v=s4nQ_mFJV4I', 'link_label' => 'Watch Educational Video on YouTube →' ),
            'purpose_h'    => 'The Strategic Purpose & Critical Safety Need',
            'purpose_c'    => '<p>Every day across the United States, tens of thousands of citizens interact with law enforcement during roadside traffic stops and street encounters without knowing their basic constitutional protections. Ambiguity, fear, and misunderstanding can quickly cause routine encounters to escalate into conflict, unlawful searches, or tragic violence.</p><p>In collaboration with the Flex Your Rights Foundation, the American Civil Liberties Union (ACLU), and the Law Enforcement Action Partnership (LEAP), Roger Sorkin directed <em>10 Rules for Dealing with Police</em> to deliver accessible, dramatic, and legally precise guidance. The goal was to empower citizens with the knowledge to remain calm, assert their rights respectfully, and stay safe.</p><p>By featuring real former police officers explaining law enforcement protocols alongside constitutional attorneys, the film achieved universal credibility. It was championed across the political spectrum: lauded by criminal justice reformers, civil libertarians at the Cato Institute, and progressive advocacy groups alike.</p>',
            'impact_h'     => '',
            'impact_intro' => '',
            'bullets'      => array( array( 'Viral Public Education:', 'Viewed tens of millions of times online, becoming the definitive constitutional training resource for drivers and youth.' ), array( 'Classroom Integration:', 'Adopted by public high school civics teachers, youth centers, and legal defense organizations nationwide.' ), array( 'Roadside Conflict Reduction:', 'Proven to reduce roadside tension by providing clear, practical scripts for de-escalating ambiguous encounters.' ) ),
            'awards'       => array( array( 'Landmark Civics Education', 'Over 50 Million Combined Views Across Platforms' ), array( 'Cross-Partisan Endorsement', 'Championed by ACLU and Cato Institute' ) ),
            'quote'        => 'Constitutional literacy is the single most effective de-escalation tool available: it protects citizen rights while ensuring law enforcement officers return home safely.',
            'cite'         => 'Roger Sorkin • Director, 10 Rules for Dealing with Police',
            'video_url'    => 'https://www.youtube-nocookie.com/embed/s4nQ_mFJV4I?rel=0&amp;modestbranding=1&amp;playsinline=1',
            'video_title'  => 'Watch 10 Rules for Dealing with Police',
            'video_desc'   => 'Watch the complete educational film teaching constitutional rights and peaceful de-escalation protocols for law enforcement encounters.',
            'order'        => 11,
        ),
    );
    foreach ( $projects as $p ) {
        $existing = get_page_by_path( $p['slug'], OBJECT, 'project' );
        $pid = $existing ? $existing->ID : null;
        if ( ! $existing ) {
            $pid = wp_insert_post( array(
                'post_title'   => $p['title'],
                'post_name'    => $p['slug'],
                'post_status'  => 'publish',
                'post_type'    => 'project',
                'menu_order'   => $p['order'],
                'post_excerpt' => $p['hover_text'],
            ) );
        }

        if ( $pid ) {
            if ( ! empty( $p['category'] ) ) {
                wp_set_object_terms( $pid, $p['category'], 'project_category' );
            }

            rs_save_field( 'category_pill',      $p['cat_pill'],   $pid );
            rs_save_field( 'hero_subtitle',      $p['subtitle'],   $pid );
            rs_save_field( 'featured_homepage',  1,                $pid );
            rs_save_field( 'hover_tag',          $p['hover_tag'],  $pid );
            rs_save_field( 'card_accent',        $p['card_accent'],$pid );
            rs_save_field( 'card_cta_label',     $p['card_cta'],   $pid );

            // Stats (numbered fields)
            if ( ! empty( $p['stats'] ) ) {
                for ( $i = 1; $i <= count( $p['stats'] ); $i++ ) {
                    rs_save_field( "stat_{$i}_num",   $p['stats'][$i-1][0], $pid );
                    rs_save_field( "stat_{$i}_label", $p['stats'][$i-1][1], $pid );
                }
            }

            // Snapshot facts
            if ( ! empty( $p['snapshot'] ) ) {
                foreach ( $p['snapshot'] as $k => $v ) {
                    $clean_k = strtolower( preg_replace( '/[^a-zA-Z0-9_]/', '_', $k ) );
                    rs_save_field( "snapshot_{$clean_k}", $v, $pid );
                    if ( strpos( $clean_k, 'director' ) !== false ) {
                        rs_save_field( 'snapshot_director', $v, $pid );
                    } elseif ( strpos( $clean_k, 'client' ) !== false || strpos( $clean_k, 'producer' ) !== false || strpos( $clean_k, 'entity' ) !== false ) {
                        rs_save_field( 'snapshot_entity', $v, $pid );
                    } elseif ( strpos( $clean_k, 'messenger' ) !== false ) {
                        rs_save_field( 'snapshot_messengers', $v, $pid );
                    } elseif ( strpos( $clean_k, 'format' ) !== false ) {
                        rs_save_field( 'snapshot_format', $v, $pid );
                    } elseif ( strpos( $clean_k, 'release' ) !== false || strpos( $clean_k, 'year' ) !== false ) {
                        rs_save_field( 'snapshot_release', $v, $pid );
                    } elseif ( strpos( $clean_k, 'link_url' ) !== false ) {
                        rs_save_field( 'snapshot_link_url', $v, $pid );
                    } elseif ( strpos( $clean_k, 'link_label' ) !== false ) {
                        rs_save_field( 'snapshot_link_label', $v, $pid );
                    }
                }
            }

            // Purpose & Impact
            rs_save_field( 'purpose_heading', $p['purpose_h'],    $pid );
            rs_save_field( 'purpose_content', $p['purpose_c'],    $pid );
            rs_save_field( 'impact_heading',  $p['impact_h'],     $pid );
            rs_save_field( 'impact_intro',    $p['impact_intro'], $pid );

            // Bullets
            if ( ! empty( $p['bullets'] ) ) {
                for ( $i = 1; $i <= count( $p['bullets'] ); $i++ ) {
                    rs_save_field( "bullet_{$i}_lead", $p['bullets'][$i-1][0], $pid );
                    rs_save_field( "bullet_{$i}_text", $p['bullets'][$i-1][1], $pid );
                }
            }

            // Awards
            if ( ! empty( $p['awards'] ) ) {
                for ( $i = 1; $i <= count( $p['awards'] ); $i++ ) {
                    rs_save_field( "award_{$i}_title", $p['awards'][$i-1][0], $pid );
                    rs_save_field( "award_{$i}_event", $p['awards'][$i-1][1], $pid );
                }
            }

            // Quote & Video
            rs_save_field( 'quote_text',   $p['quote'],       $pid );
            rs_save_field( 'quote_cite',   $p['cite'],        $pid );
            rs_save_field( 'video_url',    $p['video_url'],   $pid );
            rs_save_field( 'video_title',  $p['video_title'], $pid );
            rs_save_field( 'video_desc',   $p['video_desc'],  $pid );
        }
    }

    // ------------------------------------------------------------------
    // 10. Seed Theme Settings / Options
    // ------------------------------------------------------------------
    rs_save_option( 'brand_name',               'ROGER SORKIN' );
    rs_save_option( 'brand_tagline',            'STRATEGIC NARRATIVES' );
    rs_save_option( 'header_cta_label',         'Work With Me' );
    rs_save_option( 'header_cta_url',           '/contact/' );
    rs_save_option( 'contact_location',         'Washington, D.C. & Worldwide Projects' );
    rs_save_option( 'contact_recipient_email',  get_option( 'admin_email' ) );
    rs_save_option( 'linkedin_url',             'https://www.linkedin.com/in/rogersorkin/' );
    rs_save_option( 'amres_url',                'https://www.amresproject.org/' );
    rs_save_option( 'footer_desc',              'Translating complex environmental, economic, and security challenges into bipartisan strategic narratives and attainable calls-to-action.' );
    rs_save_option( 'copyright_text',           'Copyright Roger Sorkin. All Rights Reserved.' );
    rs_save_option( 'showreel_video_url',       'hero/RS-website-banner-4.mp4' );
    rs_save_option( 'showreel_poster_url',      'hero/hp-bg.webp' );

    // ------------------------------------------------------------------
    // 11. Setup Primary Navigation Menu
    // ------------------------------------------------------------------
    $menu_name = 'Primary Navigation';
    $menu_exists = wp_get_nav_menu_object( $menu_name );
    if ( ! $menu_exists ) {
        $menu_id = wp_create_nav_menu( $menu_name );
        $menu_items = array(
            'About'    => '/about/',
            'Services' => '/services/',
            'Projects' => '/projects/',
            'Blog'     => '/blog/',
            'Contact'  => '/contact/',
        );
        $order = 1;
        foreach ( $menu_items as $label => $url ) {
            wp_update_nav_menu_item( $menu_id, 0, array(
                'menu-item-title'    => $label,
                'menu-item-url'      => home_url( $url ),
                'menu-item-status'   => 'publish',
                'menu-item-type'     => 'custom',
                'menu-item-position' => $order++,
            ) );
        }
        $locations = get_theme_mod( 'nav_menu_locations' );
        $locations['primary'] = $menu_id;
        set_theme_mod( 'nav_menu_locations', $locations );
    }

    // Flush rewrite rules so clean URLs work
    flush_rewrite_rules();

    // Mark as seeded
    update_option( 'rs_theme_seeded_v8', 1 );
}

add_action( 'after_switch_theme', 'rs_seed_initial_content' );

// Auto-seed on first admin visit if not seeded yet!
add_action( 'admin_init', function() {
    if ( ! get_option( 'rs_theme_seeded_v8' ) && current_user_can( 'manage_options' ) ) {
        rs_seed_initial_content( true );
    }
    if ( isset( $_GET['seed_roger_sorkin'] ) && current_user_can( 'manage_options' ) ) {
        rs_seed_initial_content( true );
        wp_safe_redirect( admin_url( 'admin.php?page=theme-settings&seeded=1' ) );
        exit;
    }
} );

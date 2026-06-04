<?php
/**
 * =====================================================================
 * Renna Portfolio — Main Landing Page
 * =====================================================================
 * A clean, modern, fully responsive professional portfolio website.
 * Built with native PHP, Bootstrap 5, and custom CSS.
 *
 * @author  Renna
 * @version 1.0.0
 * =====================================================================
 */

// Start session for CSRF token generation
session_start();

// Generate CSRF token if not set
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// ── Sanitization helper ─────────────────────────────────────────────
function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

// ── Portfolio Data ──────────────────────────────────────────────────
// All dynamic data is centralized here for easy editing.

$siteTitle   = 'Renna Faye Y. Estandarte';
$siteTagline = 'Virtual Assistant · System Analyst · Project Manager';

// Skills data — grouped by category
$skillCategories = [
    [
        'icon'      => 'fa-headset',
        'iconClass' => 'icon-primary',
        'title'     => 'Virtual Assistance',
        'desc'      => 'Providing administrative and remote support including scheduling, email management, data entry, document preparation, and client coordination.',
        'skills'    => [
            ['name' => 'Email & Calendar Management',  'level' => 90],
            ['name' => 'Data Entry & Encoding',         'level' => 92],
            ['name' => 'Document Preparation (MS Office)', 'level' => 88],
            ['name' => 'Online Research & Reporting',  'level' => 85],
        ],
        'tags' => ['MS Word', 'MS Excel', 'Google Workspace', 'Zoom', 'Canva', 'Slack'],
    ],
    [
        'icon'      => 'fa-sitemap',
        'iconClass' => 'icon-secondary',
        'title'     => 'Systems Analysis',
        'desc'      => 'Analyzing business processes, gathering requirements, creating flowcharts and DFDs, and recommending technology-driven improvements.',
        'skills'    => [
            ['name' => 'Business Process Analysis',   'level' => 82],
            ['name' => 'Requirements Gathering',       'level' => 80],
            ['name' => 'Flowcharts & DFD Modeling',   'level' => 85],
            ['name' => 'System Documentation',         'level' => 83],
        ],
        'tags' => ['Lucidchart', 'Draw.io', 'UML', 'MS Visio', 'SQL', 'ERD'],
    ],
    [
        'icon'      => 'fa-tasks',
        'iconClass' => 'icon-accent',
        'title'     => 'Project Management',
        'desc'      => 'Planning, coordinating, and monitoring project tasks and timelines to ensure smooth and on-time delivery across academic and internship projects.',
        'skills'    => [
            ['name' => 'Task & Timeline Planning',    'level' => 84],
            ['name' => 'Team Coordination',           'level' => 86],
            ['name' => 'Progress Tracking',           'level' => 82],
            ['name' => 'Stakeholder Reporting',       'level' => 80],
        ],
        'tags' => ['Trello', 'Notion', 'Google Drive', 'MS Project', 'Agile Basics'],
    ],
];

// Projects data
$projects = [
    [
        'title'       => 'Virtual Assistant Operations Tracker',
        'description' => 'Designed a structured Google Sheets tracker for managing daily VA tasks, client schedules, deadlines, and progress logs — improving personal workflow efficiency.',
        'image'       => 'https://images.unsplash.com/photo-1484480974693-6ca0a78fb36b?w=600&h=400&fit=crop',
        'tags'        => ['Google Sheets', 'Google Workspace', 'Productivity'],
        'github'      => 'https://github.com/',
        'demo'        => 'https://example.com/',
        'featured'    => true,
    ],
    [
        'title'       => 'Business Process Analysis Report',
        'description' => 'Internship Project: Conducted a systems analysis of an existing business process, produced a DFD, identified bottlenecks, and recommended technology-based process improvements.',
        'image'       => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=600&h=400&fit=crop',
        'tags'        => ['Systems Analysis', 'DFD', 'Documentation'],
        'github'      => 'https://github.com/',
        'demo'        => 'https://example.com/',
        'featured'    => true,
    ],
    [
        'title'       => 'Project Timeline & Task Tracker',
        'description' => 'Academic Capstone Project: Built a Trello-based project management workflow for a team of 5, with task cards, due dates, checklists, and a Gantt-style timeline in Excel.',
        'image'       => 'https://images.unsplash.com/photo-1611532736597-de2d4265fba3?w=600&h=400&fit=crop',
        'tags'        => ['Trello', 'MS Excel', 'Project Management'],
        'github'      => 'https://github.com/',
        'demo'        => 'https://example.com/',
        'featured'    => true,
    ],
    [
        'title'       => 'Information System Requirements Spec',
        'description' => 'Academic Project: Created a full IS requirements specification document including use cases, ER diagram, and system scope definition for a proposed enrollment system.',
        'image'       => 'https://images.unsplash.com/photo-1507925921958-8a62f3d1a50d?w=600&h=400&fit=crop',
        'tags'        => ['UML', 'ERD', 'MS Word', 'Draw.io'],
        'github'      => 'https://github.com/',
        'demo'        => 'https://example.com/',
        'featured'    => false,
    ],
    [
        'title'       => 'Internship Progress Report Dashboard',
        'description' => 'Created a structured internship documentation set including daily logs, summary reports, and a simple Excel tracker for monitoring weekly milestones and hours.',
        'image'       => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=600&h=400&fit=crop',
        'tags'        => ['Excel', 'Reporting', 'Documentation'],
        'github'      => 'https://github.com/',
        'demo'        => 'https://example.com/',
        'featured'    => true,
    ],
    [
        'title'       => 'Client Communication & Scheduling System',
        'description' => 'Academic Project: Designed a simple scheduling and client follow-up system using Google Calendar and Sheets to automate reminders and organize client meeting notes.',
        'image'       => 'https://images.unsplash.com/photo-1506784983877-45594efa4cbe?w=600&h=400&fit=crop',
        'tags'        => ['Google Calendar', 'Google Sheets', 'Automation'],
        'github'      => 'https://github.com/',
        'demo'        => 'https://example.com/',
        'featured'    => false,
    ],
];

// About statistics
$stats = [
    ['number' => 'BS',    'label' => 'Information Systems'],
    ['number' => 'DNSC',  'label' => 'Davao del Norte State College'],
    ['number' => '3',     'label' => 'Core Specializations'],
];

// Certifications data
$certifications = [
    [
        'title'    => 'OJT Program Completion Certificate',
        'issuer'   => 'Davao del Norte State College',
        'date'     => 'May 18, 2026',
        'icon'     => 'fas fa-graduation-cap',
        'color'    => 'primary',
        'image'    => 'assets/OJT Completion.jpg',
        'featured' => true,
    ],
    [
        'title'    => 'Capstone Project Completion (BranchSync)',
        'issuer'   => 'SJ Printing Services & DNSC',
        'date'     => 'April 9, 2026',
        'icon'     => 'fas fa-project-diagram',
        'color'    => 'secondary',
        'image'    => 'assets/System Deployment Completion.jpg',
        'featured' => true,
    ],
    [
        'title'    => 'Certificate of Recognition (Facilitator)',
        'issuer'   => 'CDITE XI & CHED Region XI',
        'date'     => 'March 17, 2026',
        'icon'     => 'fas fa-award',
        'color'    => 'accent',
        'image'    => 'assets/RAISE Davao Certificate.png',
        'featured' => true,
    ],
    [
        'title'    => 'Statement of Achievement (Python Essentials 1)',
        'issuer'   => 'Cisco Networking Academy',
        'date'     => 'November 9, 2025',
        'icon'     => 'fab fa-python',
        'color'    => 'primary',
        'image'    => 'assets/Statement of Achievement in Python Essentials.png',
        'featured' => true,
    ],
    [
        'title'    => 'Python Essentials 1 Course Certificate',
        'issuer'   => 'Cisco Networking Academy',
        'date'     => 'November 9, 2025',
        'icon'     => 'fab fa-python',
        'color'    => 'secondary',
        'image'    => 'assets/Python Essentials 1.png',
        'featured' => true,
    ],
    [
        'title'    => 'Certificate of Participation (MarineSentinel)',
        'issuer'   => 'Davao del Norte State College',
        'date'     => 'December 6, 2024',
        'icon'     => 'fas fa-lightbulb',
        'color'    => 'accent',
        'image'    => 'assets/Startup Sundayag Event.jpg',
        'featured' => true,
    ],
    [
        'title'    => 'Certificate of Participation (Multimedia Festival)',
        'issuer'   => 'Davao del Norte State College',
        'date'     => 'December 22, 2022',
        'icon'     => 'fas fa-film',
        'color'    => 'primary',
        'image'    => 'assets/Multi-Media Festival 2022.jpg',
        'featured' => false,
    ],
];
?>

<?php include 'includes/header.php'; ?>

    <!-- ===================================================================
         HERO SECTION
    ==================================================================== -->
    <section id="hero" class="hero-section">
        <div class="container">
            <div class="row align-items-center gy-5">
                <!-- Hero Text Content -->
                <div class="col-lg-6 order-lg-1 order-2">
                    <p class="hero-greeting reveal">
                        <span class="wave">👋</span> Hello, I'm
                    </p>
                    <h1 class="hero-title reveal">
                        <?php echo e($siteTitle); ?><br>
                        <span class="highlight" id="typedText">Data Analyst</span>
                        <span class="highlight" aria-hidden="true">|</span>
                    </h1>
                    <p class="hero-subtitle reveal">
                        An Information Systems student at DNSC passionate about utilizing technology to build efficient solutions, improve business processes, and create meaningful digital innovations.
                    </p>

                    <!-- CTA Buttons -->
                    <div class="hero-cta reveal">
                        <a href="#projects" class="btn-primary-custom">
                            <i class="fas fa-chart-bar"></i> View My Work
                        </a>
                        <a href="#contact" class="btn-outline-custom">
                            <i class="fas fa-paper-plane"></i> Get in Touch
                        </a>
                    </div>

                    <!-- Social Links -->
                    <div class="hero-socials reveal">
                        <span class="line"></span>
                        <a href="https://github.com/" target="_blank" rel="noopener" aria-label="GitHub">
                            <i class="fab fa-github"></i>
                        </a>
                        <a href="https://linkedin.com/" target="_blank" rel="noopener" aria-label="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="https://twitter.com/" target="_blank" rel="noopener" aria-label="Twitter">
                            <i class="fab fa-x-twitter"></i>
                        </a>
                        <a href="https://kaggle.com/" target="_blank" rel="noopener" aria-label="Kaggle">
                            <i class="fab fa-kaggle"></i>
                        </a>
                    </div>
                </div>

                <!-- Hero Image -->
                <div class="col-lg-6 order-lg-2 order-1">
                    <div class="hero-image-wrapper reveal-right">
                        <div class="hero-image-container">
                            <!-- Replace with your own profile photo -->
                            <img src="assets/profile.jpg"
                                 alt="<?php echo e($siteTitle); ?> — Profile Photo"
                                 loading="eager">
                        </div>
                        <!-- Decorative floating dots -->
                        <span class="hero-float-dot"></span>
                        <span class="hero-float-dot"></span>
                        <span class="hero-float-dot"></span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===================================================================
         ABOUT SECTION
    ==================================================================== -->
    <section id="about" class="section about-section">
        <div class="container">
            <!-- Section Header -->
            <div class="section-header reveal">
                <span class="section-label">About Me</span>
                <h2 class="section-title">Driven by Technology &amp; Purpose</h2>
                <p class="section-subtitle">
                    Information Systems student with hands-on experience in virtual assistance,
                    data management, project coordination, and systems analysis.
                </p>
            </div>

            <div class="row justify-content-center">
                <!-- About Content -->
                <div class="col-lg-8 reveal">
                    <h3 class="about-title text-center mb-4">
                        Hi, I'm <?php echo e($siteTitle); ?> — based in Panabo City, Philippines
                    </h3>
                    <p class="about-text text-center">
                        I am a Bachelor of Science in Information Systems student at <strong>Davao del Norte State College (DNSC)</strong>.
                        With experience in virtual assistance, data management, project coordination, and systems analysis,
                        I am passionate about utilizing technology to develop efficient solutions and improve business processes.
                    </p>
                    <p class="about-text text-center mb-4">
                        I continuously grow my technical and professional skills, driven by a genuine desire
                        to create meaningful digital innovations and deliver real value to every team I work with.
                    </p>
                    <ul class="about-list mb-4">
                        <li><i class="fas fa-check-circle text-primary me-2"></i> <span><strong>Virtual Assistance:</strong> Administrative support, scheduling, communication management, and document preparation.</span></li>
                        <li><i class="fas fa-check-circle text-secondary me-2"></i> <span><strong>Systems Analysis:</strong> Analyzing business processes, identifying requirements, and recommending technology-driven improvements.</span></li>
                        <li><i class="fas fa-check-circle text-accent me-2"></i> <span><strong>Project Management:</strong> Coordinating tasks, tracking timelines, and ensuring smooth project delivery from start to finish.</span></li>
                    </ul>

                    <!-- Statistics -->
                    <div class="about-stats justify-content-center mt-5">
                        <?php foreach ($stats as $stat): ?>
                            <div class="stat-pill">
                                <span class="stat-number"><?php echo e($stat['number']); ?></span>
                                <span class="stat-label"><?php echo e($stat['label']); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Download Resume Button -->
                    <div class="text-center mt-4">
                        <a href="assets/files/resume.pdf" target="_blank" rel="noopener" class="btn-primary-custom">
                            <i class="fas fa-download"></i> Download Resume
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===================================================================
         SKILLS SECTION
    ==================================================================== -->
    <section id="skills" class="section skills-section">
        <div class="container">
            <!-- Section Header -->
            <div class="section-header reveal">
                <span class="section-label">Skills & Expertise</span>
                <h2 class="section-title">Tools & Technologies I Use</h2>
                <p class="section-subtitle">
                    A curated toolkit of languages, platforms, and analytics tools that I use
                    to extract insights and deliver data-driven solutions.
                </p>
            </div>

            <!-- Skills Grid -->
            <div class="row g-4 stagger-children">
                <?php
                // Gradient classes for progress bars — cycle per category
                $progressClasses = ['bg-primary-gradient', 'bg-secondary-gradient', 'bg-accent-gradient'];

                foreach ($skillCategories as $catIndex => $category):
                    $progressClass = $progressClasses[$catIndex % count($progressClasses)];
                ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="skill-card">
                            <!-- Category Icon -->
                            <div class="skill-icon <?php echo e($category['iconClass']); ?>">
                                <i class="fas <?php echo e($category['icon']); ?>"></i>
                            </div>
                            <h5><?php echo e($category['title']); ?></h5>
                            <p><?php echo e($category['desc']); ?></p>

                            <!-- Progress Bars -->
                            <?php foreach ($category['skills'] as $skill): ?>
                                <div class="skill-progress">
                                    <div class="skill-progress-label">
                                        <span><?php echo e($skill['name']); ?></span>
                                        <span><?php echo e((string)$skill['level']); ?>%</span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar <?php echo e($progressClass); ?>"
                                             role="progressbar"
                                             style="width: 0%"
                                             data-width="<?php echo e((string)$skill['level']); ?>"
                                             aria-valuenow="<?php echo e((string)$skill['level']); ?>"
                                             aria-valuemin="0"
                                             aria-valuemax="100">
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                            <!-- Tech Tags -->
                            <div class="tech-tags mt-3">
                                <?php foreach ($category['tags'] as $tag): ?>
                                    <span class="tech-tag"><?php echo e($tag); ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ===================================================================
         CERTIFICATIONS SECTION
    ==================================================================== -->
    <section id="certifications" class="section certifications-section">
        <div class="container">
            <!-- Section Header -->
            <div class="section-header reveal">
                <span class="section-label">Certifications</span>
                <h2 class="section-title">Credentials &amp; Recognitions</h2>
                <p class="section-subtitle">
                    Certificates and training completions from academic events, internships,
                    and professional programs that validate my skills.
                </p>
            </div>

            <!-- Certifications Grid -->
            <div class="row g-4 stagger-children">
                <?php foreach ($certifications as $cert): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="cert-card">
                            <?php if ($cert['featured']): ?>
                                <span class="cert-featured-badge">
                                    <i class="fas fa-award me-1"></i> Featured
                                </span>
                            <?php endif; ?>

                            <!-- Issuer Icon -->
                            <div class="cert-icon cert-icon-<?php echo e($cert['color']); ?>">
                                <i class="<?php echo e($cert['icon']); ?>"></i>
                            </div>

                            <!-- Certificate Info -->
                            <h5 class="cert-title"><?php echo e($cert['title']); ?></h5>
                            <p class="cert-issuer">
                                <i class="fas fa-building me-1"></i>
                                <?php echo e($cert['issuer']); ?>
                            </p>
                            <p class="cert-date">
                                <i class="fas fa-calendar-alt me-1"></i>
                                <?php echo e($cert['date']); ?>
                            </p>

                            <!-- View Button -->
                            <button type="button" 
                                    class="cert-link border-0 w-100 justify-content-center cursor-pointer"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#certModal" 
                                    data-bs-image="<?php echo e($cert['image']); ?>" 
                                    data-bs-title="<?php echo e($cert['title']); ?>"
                                    style="background: transparent;">
                                <i class="fas fa-eye me-1"></i> View Certificate
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ===================================================================
         PROJECTS / PORTFOLIO SECTION
    ==================================================================== -->
    <section id="projects" class="section projects-section">
        <div class="container">
            <!-- Section Header -->
            <div class="section-header reveal">
                <span class="section-label">Portfolio</span>
                <h2 class="section-title">Featured Projects</h2>
                <p class="section-subtitle">
                    A selection of recent work that showcases my skills in data analysis,
                    visualization, and turning numbers into narratives.
                </p>
            </div>

            <!-- Projects Grid -->
            <div class="row g-4 stagger-children">
                <?php foreach ($projects as $project): ?>
                    <div class="col-lg-4 col-md-6">
                        <article class="project-card">
                            <!-- Project Image + Overlay -->
                            <div class="project-image">
                                <?php if ($project['featured']): ?>
                                    <span class="project-badge">
                                        <i class="fas fa-star me-1"></i> Featured
                                    </span>
                                <?php endif; ?>

                                <img src="<?php echo e($project['image']); ?>"
                                     alt="<?php echo e($project['title']); ?> — Project Screenshot"
                                     loading="lazy">

                                <!-- Hover Overlay -->
                                <div class="project-overlay">
                                    <a href="<?php echo e($project['github']); ?>"
                                       target="_blank" rel="noopener"
                                       class="btn-icon" title="View Source Code"
                                       aria-label="View source code for <?php echo e($project['title']); ?>">
                                        <i class="fab fa-github"></i>
                                    </a>
                                    <a href="<?php echo e($project['demo']); ?>"
                                       target="_blank" rel="noopener"
                                       class="btn-icon" title="View Live Demo"
                                       aria-label="View live demo of <?php echo e($project['title']); ?>">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                </div>
                            </div>

                            <!-- Project Info -->
                            <div class="project-body">
                                <h5><?php echo e($project['title']); ?></h5>
                                <p><?php echo e($project['description']); ?></p>
                                <div class="project-tags">
                                    <?php foreach ($project['tags'] as $tag): ?>
                                        <span class="project-tag"><?php echo e($tag); ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </article>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ===================================================================
         CONTACT SECTION
    ==================================================================== -->
    <section id="contact" class="section contact-section">
        <div class="container">
            <!-- Section Header -->
            <div class="section-header reveal">
                <span class="section-label">Contact</span>
                <h2 class="section-title">Let's Work Together</h2>
                <p class="section-subtitle">
                    Have a project, collaboration, or opportunity in mind?
                    I'd love to hear from you. Drop me a message below.
                </p>
            </div>

            <div class="row g-4">
                <!-- Contact Info Column -->
                <div class="col-lg-5 reveal-left">
                    <div class="contact-info-card">
                        <h4>Let's connect</h4>
                        <p>
                            I'm always open to discussions about projects, systems work,
                            virtual assistance opportunities, or collaborations. Let's connect!
                        </p>

                        <!-- Email -->
                        <div class="contact-detail">
                            <div class="contact-detail-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="contact-detail-text">
                                <h6>Email</h6>
                                <a href="mailto:estandartefaye@gmail.com" style="color:inherit">estandartefaye@gmail.com</a>
                            </div>
                        </div>

                        <!-- Location -->
                        <div class="contact-detail">
                            <div class="contact-detail-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="contact-detail-text">
                                <h6>Location</h6>
                                <span>Panabo City, Philippines</span>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="contact-detail">
                            <div class="contact-detail-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="contact-detail-text">
                                <h6>Phone</h6>
                                <a href="tel:+639922327636" style="color:inherit">+63 992 232 7636</a>
                            </div>
                        </div>

                        <!-- Availability -->
                        <div class="contact-detail">
                            <div class="contact-detail-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="contact-detail-text">
                                <h6>Availability</h6>
                                <span>Open for opportunities</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form Column -->
                <div class="col-lg-7 reveal-right">
                    <div class="contact-form-card">
                        <form id="contactForm" method="POST" action="https://api.web3forms.com/submit" novalidate>
                            <!-- Web3Forms Access Key (Get a free key from web3forms.com) -->
                            <input type="hidden" name="access_key" value="622818a5-5502-4a1e-9218-03cc88fa9af6">
                            <input type="hidden" name="from_name" value="Renna Faye Portfolio">
                            <input type="hidden" name="subject" value="New Contact Form Submission">

                            <div class="row g-3">
                                <!-- Name Field -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="contactName"
                                               name="name" placeholder="Your Name" required
                                               minlength="2" maxlength="100"
                                               autocomplete="name">
                                        <label for="contactName">
                                            <i class="fas fa-user me-1"></i> Your Name
                                        </label>
                                    </div>
                                </div>

                                <!-- Email Field -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="contactEmail"
                                               name="email" placeholder="your@email.com" required
                                               autocomplete="email">
                                        <label for="contactEmail">
                                            <i class="fas fa-envelope me-1"></i> Email Address
                                        </label>
                                    </div>
                                </div>

                                <!-- Subject Field -->
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="contactSubject"
                                               name="subject" placeholder="Subject" required
                                               minlength="2" maxlength="200">
                                        <label for="contactSubject">
                                            <i class="fas fa-tag me-1"></i> Subject
                                        </label>
                                    </div>
                                </div>

                                <!-- Message Field -->
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control" id="contactMessage"
                                                  name="message" placeholder="Your message..."
                                                  style="height: 160px" required
                                                  minlength="10" maxlength="5000"></textarea>
                                        <label for="contactMessage">
                                            <i class="fas fa-comment-dots me-1"></i> Your Message
                                        </label>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="col-12">
                                    <button type="submit" class="btn-submit" id="submitBtn">
                                        <span class="spinner-border spinner-border-sm d-none" role="status"
                                              aria-hidden="true"></span>
                                        <span class="btn-text">Send Message</span>
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!-- Form Status Message -->
                        <div id="formStatus" class="form-status"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php include 'includes/footer.php'; ?>

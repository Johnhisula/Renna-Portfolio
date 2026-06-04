/**
 * =====================================================================
 * Main JavaScript — Renna Portfolio
 * =====================================================================
 * Handles:
 *   1. Navbar scroll behavior (transparent → solid)
 *   2. Smooth scroll for anchor links
 *   3. Active nav-link highlighting on scroll
 *   4. Back-to-top button visibility
 *   5. Scroll-reveal animations (IntersectionObserver)
 *   6. Contact form AJAX submission
 *   7. Skill progress bar animation on scroll
 * =====================================================================
 */

document.addEventListener('DOMContentLoaded', () => {
    'use strict';

    // ── DOM References ──────────────────────────────────────────────
    const navbar       = document.getElementById('mainNav');
    const backToTop    = document.getElementById('backToTop');
    const contactForm  = document.getElementById('contactForm');
    const formStatus   = document.getElementById('formStatus');
    const navLinks     = document.querySelectorAll('#mainNav .nav-link');
    const sections     = document.querySelectorAll('section[id]');

    // ================================================================
    // 1. NAVBAR — Add "scrolled" class after 60px
    // ================================================================
    function handleNavbarScroll() {
        if (window.scrollY > 60) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    }

    // ================================================================
    // 2. BACK TO TOP — Show after 400px scroll
    // ================================================================
    function handleBackToTop() {
        if (window.scrollY > 400) {
            backToTop.classList.add('visible');
        } else {
            backToTop.classList.remove('visible');
        }
    }

    // ================================================================
    // 3. ACTIVE NAV LINK HIGHLIGHTING — Based on scroll position
    // ================================================================
    function highlightActiveNav() {
        const scrollPos = window.scrollY + 120;

        sections.forEach(section => {
            const top    = section.offsetTop;
            const height = section.offsetHeight;
            const id     = section.getAttribute('id');

            if (scrollPos >= top && scrollPos < top + height) {
                navLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === '#' + id) {
                        link.classList.add('active');
                    }
                });
            }
        });
    }

    // ── Combined scroll handler (throttled with rAF) ────────────────
    let scrollTicking = false;

    window.addEventListener('scroll', () => {
        if (!scrollTicking) {
            window.requestAnimationFrame(() => {
                handleNavbarScroll();
                handleBackToTop();
                highlightActiveNav();
                scrollTicking = false;
            });
            scrollTicking = true;
        }
    });

    // Run once on load
    handleNavbarScroll();
    handleBackToTop();

    // ── Back to Top click ───────────────────────────────────────────
    if (backToTop) {
        backToTop.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // ================================================================
    // 4. SMOOTH SCROLL — For all anchor links
    // ================================================================
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const targetId = this.getAttribute('href');
            if (targetId === '#' || targetId === '#top') {
                e.preventDefault();
                window.scrollTo({ top: 0, behavior: 'smooth' });
                return;
            }
            const target = document.querySelector(targetId);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth' });

                // Close mobile nav if open
                const navCollapse = document.getElementById('navbarNav');
                if (navCollapse.classList.contains('show')) {
                    const bsCollapse = bootstrap.Collapse.getInstance(navCollapse);
                    if (bsCollapse) bsCollapse.hide();
                }
            }
        });
    });

    // ================================================================
    // 5. SCROLL REVEAL — IntersectionObserver for .reveal elements
    // ================================================================
    const revealObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                    // Optional: unobserve after revealing (one-time animation)
                    revealObserver.unobserve(entry.target);
                }
            });
        },
        {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        }
    );

    document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .stagger-children').forEach(el => {
        revealObserver.observe(el);
    });

    // ================================================================
    // 6. SKILL PROGRESS BARS — Animate width on scroll into view
    // ================================================================
    const progressObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const bars = entry.target.querySelectorAll('.progress-bar');
                    bars.forEach(bar => {
                        const targetWidth = bar.getAttribute('data-width');
                        bar.style.width = targetWidth + '%';
                    });
                    progressObserver.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.3 }
    );

    document.querySelectorAll('.skill-card').forEach(card => {
        progressObserver.observe(card);
    });

    // ================================================================
    // 7. CONTACT FORM — Submission Handler (Supports AJAX / Fallback)
    // ================================================================
    if (contactForm) {
        contactForm.addEventListener('submit', async function (e) {
            e.preventDefault();

            const submitBtn   = this.querySelector('button[type="submit"]');
            const btnText     = submitBtn.querySelector('.btn-text');
            const btnSpinner  = submitBtn.querySelector('.spinner-border');

            // Reset status
            formStatus.className = 'form-status';
            formStatus.textContent = '';
            formStatus.style.display = 'none';

            // Show loading state
            submitBtn.disabled = true;
            btnText.textContent = 'Sending...';
            btnSpinner.classList.remove('d-none');

            try {
                const formData = new FormData(this);
                const action = this.getAttribute('action') || 'contact-handler.php';

                // Check if using Web3Forms (Static site helper)
                if (action.includes('web3forms.com')) {
                    const accessKey = formData.get('access_key');
                    if (!accessKey || accessKey === 'YOUR_WEB3FORMS_ACCESS_KEY' || accessKey === 'YOUR_ACCESS_KEY_HERE') {
                        // Web3Forms key is not configured, fall back to opening email client
                        const name = formData.get('name');
                        const email = formData.get('email');
                        const subject = formData.get('subject');
                        const message = formData.get('message');
                        
                        const mailtoBody = `Name: ${name}\nEmail: ${email}\n\nMessage:\n${message}`;
                        const mailtoUrl = `mailto:estandartefaye@gmail.com?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(mailtoBody)}`;
                        
                        window.location.href = mailtoUrl;

                        formStatus.className = 'form-status success';
                        formStatus.innerHTML = '<i class="fas fa-info-circle me-2"></i>Web3Forms key not configured. Opening your email client to send message...';
                        formStatus.style.display = 'block';
                        this.reset();
                        return;
                    }

                    // AJAX submission to Web3Forms
                    const json = JSON.stringify(Object.fromEntries(formData));
                    const response = await fetch(action, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: json
                    });

                    const result = await response.json();

                    if (response.status === 200 || result.success) {
                        formStatus.className = 'form-status success';
                        formStatus.innerHTML = '<i class="fas fa-check-circle me-2"></i>Thank you! Your message has been sent successfully. I will get back to you soon.';
                        formStatus.style.display = 'block';
                        this.reset();
                    } else {
                        formStatus.className = 'form-status error';
                        formStatus.innerHTML = '<i class="fas fa-exclamation-circle me-2"></i>' + (result.message || 'Submission failed.');
                        formStatus.style.display = 'block';
                    }
                } else {
                    // Fallback to PHP handler
                    const response = await fetch(action, {
                        method: 'POST',
                        body: formData,
                    });

                    const result = await response.json();

                    if (result.success) {
                        formStatus.className = 'form-status success';
                        formStatus.innerHTML = '<i class="fas fa-check-circle me-2"></i>' + result.message;
                        formStatus.style.display = 'block';
                        this.reset();
                    } else {
                        formStatus.className = 'form-status error';
                        formStatus.innerHTML = '<i class="fas fa-exclamation-circle me-2"></i>' + result.message;
                        formStatus.style.display = 'block';
                    }
                }
            } catch (error) {
                formStatus.className = 'form-status error';
                formStatus.innerHTML = '<i class="fas fa-exclamation-circle me-2"></i>Network error. Please check your connection and try again.';
                formStatus.style.display = 'block';
            } finally {
                // Restore button state
                submitBtn.disabled = false;
                btnText.textContent = 'Send Message';
                btnSpinner.classList.add('d-none');
            }
        });
    }

    // ================================================================
    // 8. TYPED TEXT EFFECT — Simple typewriter for hero subtitle
    // ================================================================
    const typedElement = document.getElementById('typedText');
    if (typedElement) {
        const phrases = [
            'Virtual Assistant',
            'System Analyst',
            'Project Manager'
        ];
        let phraseIndex = 0;
        let charIndex   = 0;
        let isDeleting  = false;
        let typeSpeed   = 80;

        function typeEffect() {
            const currentPhrase = phrases[phraseIndex];

            if (isDeleting) {
                typedElement.textContent = currentPhrase.substring(0, charIndex - 1);
                charIndex--;
                typeSpeed = 40;
            } else {
                typedElement.textContent = currentPhrase.substring(0, charIndex + 1);
                charIndex++;
                typeSpeed = 80;
            }

            if (!isDeleting && charIndex === currentPhrase.length) {
                typeSpeed = 2000; // Pause at end
                isDeleting = true;
            } else if (isDeleting && charIndex === 0) {
                isDeleting = false;
                phraseIndex = (phraseIndex + 1) % phrases.length;
                typeSpeed = 500; // Pause before next word
            }

            setTimeout(typeEffect, typeSpeed);
        }

        typeEffect();
    }

    // ================================================================
    // 9. CERTIFICATE LIGHTBOX MODAL HANDLER
    // ================================================================
    const certModal = document.getElementById('certModal');
    if (certModal) {
        certModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const imageSrc = button.getAttribute('data-bs-image');
            const certTitle = button.getAttribute('data-bs-title');
            
            const modalImage = certModal.querySelector('#certModalImage');
            const modalTitle = certModal.querySelector('#certModalLabel');
            
            if (modalImage && imageSrc) {
                modalImage.src = imageSrc;
                modalImage.alt = certTitle || 'Certificate';
            }
            if (modalTitle && certTitle) {
                modalTitle.textContent = certTitle;
            }
        });
    }
});

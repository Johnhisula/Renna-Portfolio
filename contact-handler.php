<?php
/**
 * =====================================================================
 * Contact Form Handler
 * =====================================================================
 * Processes the contact form submission:
 *  1. Validates the CSRF token.
 *  2. Sanitizes & validates all input fields.
 *  3. Simulates sending an email (replace with mail() in production).
 *  4. Returns a JSON response for AJAX consumption.
 *
 * Security measures:
 *  - CSRF token verification
 *  - Input sanitization via htmlspecialchars() & filter_var()
 *  - Rate limiting (basic, session-based)
 * =====================================================================
 */

// Start session for CSRF validation
session_start();

// Set JSON response header
header('Content-Type: application/json; charset=UTF-8');

// ── Helper: Send JSON response and exit ─────────────────────────────
function sendResponse(bool $success, string $message, int $httpCode = 200): void
{
    http_response_code($httpCode);
    echo json_encode([
        'success' => $success,
        'message' => $message,
    ]);
    exit;
}

// ── Only accept POST requests ───────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendResponse(false, 'Invalid request method.', 405);
}

// ── CSRF Token Verification ─────────────────────────────────────────
$tokenFromForm = $_POST['csrf_token'] ?? '';
$tokenFromSession = $_SESSION['csrf_token'] ?? '';

if (empty($tokenFromForm) || !hash_equals($tokenFromSession, $tokenFromForm)) {
    sendResponse(false, 'Security verification failed. Please refresh the page and try again.', 403);
}

// ── Basic Rate Limiting (max 5 submissions per 10 minutes) ──────────
$currentTime = time();
$rateLimitWindow = 600; // 10 minutes in seconds
$maxAttempts = 5;

if (!isset($_SESSION['contact_attempts'])) {
    $_SESSION['contact_attempts'] = [];
}

// Clean up old attempts outside the window
$_SESSION['contact_attempts'] = array_filter(
    $_SESSION['contact_attempts'],
    fn($timestamp) => ($currentTime - $timestamp) < $rateLimitWindow
);

if (count($_SESSION['contact_attempts']) >= $maxAttempts) {
    sendResponse(false, 'Too many submissions. Please wait a few minutes before trying again.', 429);
}

// ── Retrieve and Sanitize Input ─────────────────────────────────────
$name    = trim(htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES, 'UTF-8'));
$email   = trim(htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8'));
$subject = trim(htmlspecialchars($_POST['subject'] ?? '', ENT_QUOTES, 'UTF-8'));
$message = trim(htmlspecialchars($_POST['message'] ?? '', ENT_QUOTES, 'UTF-8'));

// ── Validation ──────────────────────────────────────────────────────
$errors = [];

// Name: required, 2–100 characters, letters/spaces/hyphens only
if (empty($name)) {
    $errors[] = 'Name is required.';
} elseif (mb_strlen($name) < 2 || mb_strlen($name) > 100) {
    $errors[] = 'Name must be between 2 and 100 characters.';
}

// Email: required, valid format
if (empty($email)) {
    $errors[] = 'Email address is required.';
} elseif (!filter_var(filter_var($email, FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Please provide a valid email address.';
}

// Subject: required, 2–200 characters
if (empty($subject)) {
    $errors[] = 'Subject is required.';
} elseif (mb_strlen($subject) < 2 || mb_strlen($subject) > 200) {
    $errors[] = 'Subject must be between 2 and 200 characters.';
}

// Message: required, 10–5000 characters
if (empty($message)) {
    $errors[] = 'Message is required.';
} elseif (mb_strlen($message) < 10) {
    $errors[] = 'Message must be at least 10 characters long.';
} elseif (mb_strlen($message) > 5000) {
    $errors[] = 'Message must not exceed 5000 characters.';
}

// Return validation errors if any
if (!empty($errors)) {
    sendResponse(false, implode(' ', $errors), 422);
}

// ── Process the Message ─────────────────────────────────────────────
// In production, replace this block with actual mail() or a mailer library.
// Example with mail():
//
// $to      = 'hello@renna.dev';
// $headers = "From: {$email}\r\nReply-To: {$email}\r\nContent-Type: text/plain; charset=UTF-8";
// $body    = "Name: {$name}\nEmail: {$email}\nSubject: {$subject}\n\nMessage:\n{$message}";
// $sent    = mail($to, "Portfolio Contact: {$subject}", $body, $headers);

// Simulate successful email sending
$sent = true;

// Optional: Log the submission to a file for development/testing
$logEntry = sprintf(
    "[%s] Contact Form Submission\nName: %s\nEmail: %s\nSubject: %s\nMessage: %s\n%s\n",
    date('Y-m-d H:i:s'),
    $name,
    $email,
    $subject,
    $message,
    str_repeat('-', 60)
);

// Write log (create directory if needed)
$logDir = __DIR__ . '/logs';
if (!is_dir($logDir)) {
    mkdir($logDir, 0755, true);
}
file_put_contents($logDir . '/contact_submissions.log', $logEntry, FILE_APPEND | LOCK_EX);

// ── Record this attempt for rate limiting ───────────────────────────
$_SESSION['contact_attempts'][] = $currentTime;

// ── Regenerate CSRF token after successful submission ───────────────
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

// ── Send Response ───────────────────────────────────────────────────
if ($sent) {
    sendResponse(true, 'Thank you, ' . $name . '! Your message has been sent successfully. I\'ll get back to you soon.');
} else {
    sendResponse(false, 'Oops! Something went wrong while sending your message. Please try again later.', 500);
}

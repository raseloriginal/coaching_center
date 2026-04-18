<?php
/**
 * Utility Helpers
 */

/**
 * Safely encode data for JavaScript
 */
function json_safe($data) {
    return json_encode($data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
}

/**
 * Format currency
 */
function format_currency($amount) {
    return '$' . number_format($amount, 2);
}

/**
 * Format date
 */
function format_date($date, $format = 'M j, Y') {
    return date($format, strtotime($date));
}

/**
 * Record an audit log entry
 */
function log_action($action, $details = '') {
    if (isset($_SESSION['user_id'])) {
        $auditModel = new AuditLog();
        $auditModel->log($_SESSION['user_id'], $action, $details);
    }
}

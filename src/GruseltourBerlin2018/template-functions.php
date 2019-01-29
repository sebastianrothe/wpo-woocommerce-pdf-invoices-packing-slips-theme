<?php
/**
 * Use this file for all your template filters and actions.
 * Requires WooCommerce PDF Invoices & Packing Slips 1.4.13 or higher
 */
if (!defined('ABSPATH')) {
    exit;
}
// Exit if accessed directly

add_action('wpo_wcpdf_custom_styles', 'add_custom_style_for_invoices', 10, 2);
function add_custom_style_for_invoices($document_type, $document)
{
    $output = '';
    
    $files = ['yaml4-core.css', 'gruseltourberlin-invoice.css'];
    foreach ($files as $stylesheet) {
        $file = $document->get_template_path() . '/css/' . $stylesheet;
        $css = apply_filters('wpo_wcpdf_template_styles_file', $file);

        ob_start();
        if (file_exists($css)) {
            include $css;
        }
        $css = ob_get_clean();

        $css = apply_filters('wpo_wcpdf_template_styles', $css, $document);
        $output .= $css;
    }

    echo $output;
}

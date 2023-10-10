<?php

/**
 * Plugin Name: Custom Article Importer
 * Description: Import and display custom articles.
 * Version: 1.0
 * Author: Serhii Vasyliev
 */

namespace CustomArticleImporter;

require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';

class CustomArticleImporter
{
    public function __construct()
    {
        // Add hooks and actions here
        add_action('wp_enqueue_scripts', [$this, 'enqueueStyles']);
        register_activation_hook(__FILE__, [$this, 'scheduleImportEvent']);
        add_action('custom_article_import_event', [$this, 'importArticles']);

        $shortcode_functions = new ShortcodeFunctions();
        $shortcode_functions->registerShortcode();
    }

    public function enqueueStyles(): void
    {
        global $post;
        if (is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'custom_articles')) {
            wp_enqueue_style(
                'custom-article-importer-style',
                plugin_dir_url(__FILE__) . 'dist/styles.css'
            );
        }
    }

    public function scheduleImportEvent(): void
    {
        // Schedule the event to run daily
        if (!wp_next_scheduled('custom_article_import_event')) {
            wp_schedule_event(time(), 'daily', 'custom_article_import_event');
        }
    }

    public function importArticles(): void
    {
        $importer = new ImporterFunctions();
        $importer->importArticles();
    }
}

new CustomArticleImporter();

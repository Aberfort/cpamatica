<?php

namespace CustomArticleImporter;

class ShortcodeFunctions
{
    /**
     * Display articles based on the provided shortcode attributes.
     *
     * @param array $atts Shortcode attributes.
     *
     * @return string Rendered HTML output of the articles.
     */
    public function displayArticles($atts): string
    {
        // Extract and sanitize shortcode attributes
        $atts = shortcode_atts(
            array(
                'title' => 'Latest Articles',
                'count' => 5,
                'sort'  => 'date',
                'ids'   => '',
            ),
            $atts
        );

        $title = sanitize_text_field($atts['title']);
        $count = intval($atts['count']);
        $sort  = in_array(
            $atts['sort'],
            array('date', 'title', 'rating')
        ) ? $atts['sort'] : 'date';
        $ids   = sanitize_text_field($atts['ids']);

        // Prepare arguments for querying posts
        $args = array(
            'post_type'      => 'post',
            'posts_per_page' => $count,
            'orderby'        => $sort === 'rating' ? 'meta_value' : $sort,
            'order'          => 'DESC',
        );

        if ($sort === 'rating') {
            $args['meta_key'] = 'article_rating';
        }

        // If specific post IDs are provided, include them
        if ($ids) {
            $ids_array        = array_map('intval', explode(',', $ids));
            $args['post__in'] = $ids_array;
        }

        // Query the posts
        $query = new \WP_Query($args);

        // Output the list of articles using the template file from the 'views' folder
        $template_path = plugin_dir_path(
            __FILE__
        ) . '../views/shortcode-template.php';

        ob_start();
        if (file_exists($template_path)) {
            include $template_path;
        } else {
            echo 'Template file not found.';
        }
        wp_reset_postdata();

        return ob_get_clean();
    }

    /**
     * Register the custom 'custom_articles' shortcode.
     */
    public function registerShortcode(): void
    {
        add_shortcode('custom_articles', array($this, 'displayArticles'));
    }
}

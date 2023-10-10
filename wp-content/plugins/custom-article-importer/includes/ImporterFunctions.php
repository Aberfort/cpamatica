<?php

namespace CustomArticleImporter;

class ImporterFunctions
{
    public function importArticles(): void
    {
        $api_url = 'https://my.api.mockaroo.com/posts.json';
        $api_key = '413dfbf0';

        $response = $this->makeApiRequest($api_url, $api_key);

        if (is_wp_error($response)) {
            error_log('API request error: ' . $response->get_error_message());

            return;
        }

        $data = json_decode(wp_remote_retrieve_body($response));

        if (! is_array($data)) {
            error_log('Invalid API response');

            return;
        }

        foreach ($data as $article) {
            $this->processArticle($article);
        }
    }

    private function makeApiRequest($url, $api_key): \WP_Error|array
    {
        $headers = array(
            'X-API-Key' => $api_key,
        );

        return wp_safe_remote_get($url, array( 'headers' => $headers ));
    }

    private function processArticle($article): void
    {
        $post_title    = $article->title;
        $post_content  = $article->content;
        $category_name = $article->category;
        $image_url     = $article->image;

        $site_link = $article->site_link ?? '';
        $rating    = $article->rating ?? '';

        $post_id = $this->findOrCreatePost($post_title, $post_content);

        $category_id = $this->getOrCreateCategory($category_name);
        wp_set_post_categories($post_id, array( $category_id ));

        $this->uploadAndSetFeaturedImage($post_id, $image_url);

        $random_date = $this->generateRandomDate();
        wp_update_post(array(
            'ID'        => $post_id,
            'post_date' => $random_date,
        ));

        update_post_meta($post_id, 'article_site_link', $site_link);
        update_post_meta($post_id, 'article_rating', $rating);
    }

    private function findOrCreatePost($post_title, $post_content): \WP_Error|int
    {
        $existing_post = get_page_by_title($post_title, OBJECT, 'post');

        if ($existing_post) {
            $post_id = $existing_post->ID;
            if ($post_content !== $existing_post->post_content) {
                wp_update_post(array(
                    'ID'           => $post_id,
                    'post_content' => $post_content,
                ));
            }
        } else {
            $post_data = array(
                'post_title'   => $post_title,
                'post_content' => $post_content,
                'post_status'  => 'publish',
            );
            $post_id   = wp_insert_post($post_data);
        }

        return $post_id;
    }

    private function getOrCreateCategory($category_name)
    {
        $category = get_term_by('name', $category_name, 'category');

        if ($category) {
            return $category->term_id;
        } else {
            $existing_category = term_exists($category_name, 'category');

            if ($existing_category) {
                return $existing_category['term_id'];
            } else {
                return wp_create_category($category_name);
            }
        }
    }

    private function uploadAndSetFeaturedImage($post_id, $image_url): void
    {
        $image_id = $this->uploadImageFromUrl($image_url);

        if ($image_id) {
            set_post_thumbnail($post_id, $image_id);
        }
    }

    private function uploadImageFromUrl($image_url)
    {
        $image_id = $this->getAttachmentIdByUrl($image_url);

        if (! $image_id) {
            $image_id = media_sideload_image($image_url, 0, '', 'id');
        }

        return $image_id;
    }

    private function getAttachmentIdByUrl($image_url)
    {
        global $wpdb;
        $attachment = $wpdb->get_col($wpdb->prepare(
            "SELECT ID FROM $wpdb->posts WHERE guid='%s';",
            $image_url
        ));

        return empty($attachment) ? 0 : $attachment[0];
    }

    private function generateRandomDate(): string
    {
        $current_time     = current_time('timestamp');
        $random_timestamp = mt_rand($current_time - 30 * 24 * 60 * 60, $current_time);

        return date('Y-m-d H:i:s', $random_timestamp);
    }
}

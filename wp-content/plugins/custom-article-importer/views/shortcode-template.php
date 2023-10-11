<?php

/**
 * @var $title
 */
/**
 * @var $query
 */

use Spatie\Emoji\Emoji;

?>
<div class="custom-article">
  <h2 class="custom-article__title"><?php echo esc_html($title); ?></h2>
  <ul class="custom-article__list">
      <?php while ($query->have_posts()) :
            $query->the_post();

            // Get additional data
            $article_site_link = get_post_meta(get_the_ID(), 'article_site_link', true);
            $article_rating    = get_post_meta(get_the_ID(), 'article_rating', true);
            $post_categories   = get_the_category();
            $post_category     = ! empty($post_categories) ? esc_html($post_categories[0]->name) : '';
            $image_url         = get_the_post_thumbnail_url(get_the_ID(), 'full');
            ?>
        <li class="custom-article__item">
          <div class="custom-article__preview"
               style="background-image: url(' <?php echo esc_url($image_url) ?> ');">
          </div>
          <div class="custom-article__details">
            <div class="custom-article__category"><?php echo esc_html($post_category); ?></div>
            <h3 class="custom-article__post-title"><?php the_title(); ?></h3>
            <div class="custom-article__actions">
              <a href="<?php echo esc_url(get_permalink()); ?>"
                 target="_blank"
                 rel="nofollow"
                 class="custom-article__read-more">Read More</a>
                <?php if (! empty($article_rating)) : ?>
                  <span class="custom-article__rating">
                      <?php echo Emoji::star() . ' ' . esc_html($article_rating); ?>
                  </span>
                <?php endif; ?>
                <?php if (! empty($article_site_link)) : ?>
                  <a href="<?php echo esc_url($article_site_link); ?>"
                     target="_blank"
                     class="custom-article__site-link">Visit Site</a>
                <?php endif; ?>
            </div>
          </div>
        </li>
      <?php endwhile; ?>
  </ul>
</div>

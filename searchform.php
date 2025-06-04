<?php
/**
 * Custom search form template
 *
 * @package Multi_Maiven
 */

$mm_unique_id = wp_unique_id('search-form-');
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>" aria-labelledby="<?php echo esc_attr($mm_unique_id); ?>">
    <label for="<?php echo esc_attr($mm_unique_id); ?>-field" class="screen-reader-text">
        <?php esc_html_e('Search for:', 'multi-maiven'); ?>
    </label>
    <div class="search-form-container">
        <input 
            type="search" 
            id="<?php echo esc_attr($mm_unique_id); ?>-field"
            class="search-field" 
            placeholder="<?php esc_attr_e('Search...', 'multi-maiven'); ?>" 
            value="<?php echo get_search_query(); ?>" 
            name="s" 
            aria-describedby="<?php echo esc_attr($mm_unique_id); ?>-submit"
        />
        <button 
            type="submit" 
            class="search-submit" 
            id="<?php echo esc_attr($mm_unique_id); ?>-submit"
            aria-label="<?php esc_attr_e('Submit search', 'multi-maiven'); ?>"
        >
            <span class="screen-reader-text"><?php esc_html_e('Search', 'multi-maiven'); ?></span>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M21 21L16.514 16.506L21 21ZM19 10.5C19 15.194 15.194 19 10.5 19C5.806 19 2 15.194 2 10.5C2 5.806 5.806 2 10.5 2C15.194 2 19 5.806 19 10.5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
    </div>
</form>

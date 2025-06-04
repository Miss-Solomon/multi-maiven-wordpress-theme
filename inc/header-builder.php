<?php
/**
 * Header Builder Functionality
 *
 * @package Multi_Maiven
 */

/**
 * Register customizer settings for header builder
 */
function mm_header_builder_customize_register($wp_customize) {
    // Add Header Builder Section
    $wp_customize->add_section('mm_header_builder', array(
        'title'    => __('Header Builder', 'multi-maiven'),
        'priority' => 46,
    ));

    // Header Layout
    $wp_customize->add_setting('mm_header_layout', array(
        'default'           => 'default',
        'sanitize_callback' => 'mm_sanitize_header_layout',
    ));

    $wp_customize->add_control('mm_header_layout', array(
        'type'        => 'select',
        'label'       => __('Header Layout', 'multi-maiven'),
        'section'     => 'mm_header_builder',
        'description' => __('Select the layout for your site header', 'multi-maiven'),
        'choices'     => array(
            'default'      => __('Default (Logo Left, Menu Right)', 'multi-maiven'),
            'centered'     => __('Centered Logo', 'multi-maiven'),
            'split'        => __('Split Menu', 'multi-maiven'),
            'left_aligned' => __('Left Aligned (Logo and Menu Left)', 'multi-maiven'),
        ),
    ));

    // Logo Position
    $wp_customize->add_setting('mm_logo_position', array(
        'default'           => 'left',
        'sanitize_callback' => 'mm_sanitize_logo_position',
    ));

    $wp_customize->add_control('mm_logo_position', array(
        'type'    => 'radio',
        'label'   => __('Logo Position', 'multi-maiven'),
        'section' => 'mm_header_builder',
        'choices' => array(
            'left'   => __('Left', 'multi-maiven'),
            'center' => __('Center', 'multi-maiven'),
            'right'  => __('Right', 'multi-maiven'),
        ),
    ));

    // Header Padding
    $wp_customize->add_setting('mm_header_padding', array(
        'default'           => '20',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('mm_header_padding', array(
        'type'        => 'range',
        'label'       => __('Header Padding (px)', 'multi-maiven'),
        'section'     => 'mm_header_builder',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 50,
            'step' => 5,
        ),
    ));

    // Header Border
    $wp_customize->add_setting('mm_header_border', array(
        'default'           => true,
        'sanitize_callback' => 'mm_sanitize_checkbox',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('mm_header_border', array(
        'type'    => 'checkbox',
        'label'   => __('Show Header Border', 'multi-maiven'),
        'section' => 'mm_header_builder',
    ));

    // Transparent Header
    $wp_customize->add_setting('mm_transparent_header', array(
        'default'           => false,
        'sanitize_callback' => 'mm_sanitize_checkbox',
    ));

    $wp_customize->add_control('mm_transparent_header', array(
        'type'        => 'checkbox',
        'label'       => __('Transparent Header on Front Page', 'multi-maiven'),
        'section'     => 'mm_header_builder',
        'description' => __('Make the header transparent on the front page', 'multi-maiven'),
    ));

    // Menu Position
    $wp_customize->add_setting('mm_menu_position', array(
        'default'           => 'right',
        'sanitize_callback' => 'mm_sanitize_menu_position',
    ));

    $wp_customize->add_control('mm_menu_position', array(
        'type'    => 'radio',
        'label'   => __('Menu Position', 'multi-maiven'),
        'section' => 'mm_header_builder',
        'choices' => array(
            'left'   => __('Left', 'multi-maiven'),
            'center' => __('Center', 'multi-maiven'),
            'right'  => __('Right', 'multi-maiven'),
        ),
    ));

    // Header Elements
    $wp_customize->add_setting('mm_header_elements', array(
        'default'           => array('logo', 'menu'),
        'sanitize_callback' => 'mm_sanitize_header_elements',
    ));

    $wp_customize->add_control(new MM_Sortable_Control($wp_customize, 'mm_header_elements', array(
        'label'       => __('Header Elements', 'multi-maiven'),
        'section'     => 'mm_header_builder',
        'description' => __('Drag and drop to reorder header elements', 'multi-maiven'),
        'choices'     => array(
            'logo'     => __('Logo/Site Title', 'multi-maiven'),
            'menu'     => __('Primary Menu', 'multi-maiven'),
            'search'   => __('Search', 'multi-maiven'),
            'button'   => __('Button', 'multi-maiven'),
            'html'     => __('Custom HTML', 'multi-maiven'),
        ),
    )));

    // Custom Button Text
    $wp_customize->add_setting('mm_header_button_text', array(
        'default'           => __('Contact Us', 'multi-maiven'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('mm_header_button_text', array(
        'type'    => 'text',
        'label'   => __('Button Text', 'multi-maiven'),
        'section' => 'mm_header_builder',
    ));

    // Custom Button URL
    $wp_customize->add_setting('mm_header_button_url', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('mm_header_button_url', array(
        'type'    => 'url',
        'label'   => __('Button URL', 'multi-maiven'),
        'section' => 'mm_header_builder',
    ));

    // Custom HTML
    $wp_customize->add_setting('mm_header_html', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
    ));

    $wp_customize->add_control('mm_header_html', array(
        'type'        => 'textarea',
        'label'       => __('Custom HTML', 'multi-maiven'),
        'section'     => 'mm_header_builder',
        'description' => __('Add custom HTML to your header', 'multi-maiven'),
    ));
}
add_action('customize_register', 'mm_header_builder_customize_register');

/**
 * Sanitization functions
 */
function mm_sanitize_header_layout($input) {
    $valid_layouts = array('default', 'centered', 'split', 'left_aligned');
    return in_array($input, $valid_layouts) ? $input : 'default';
}

function mm_sanitize_logo_position($input) {
    $valid_positions = array('left', 'center', 'right');
    return in_array($input, $valid_positions) ? $input : 'left';
}

function mm_sanitize_menu_position($input) {
    $valid_positions = array('left', 'center', 'right');
    return in_array($input, $valid_positions) ? $input : 'right';
}

function mm_sanitize_header_elements($input) {
    $valid_elements = array('logo', 'menu', 'search', 'button', 'html');

    if (is_array($input)) {
        return array_intersect($input, $valid_elements);
    }

    return array('logo', 'menu');
}

/**
 * Custom Sortable Control for Customizer
 */
if (class_exists('WP_Customize_Control')) {
    class MM_Sortable_Control extends WP_Customize_Control {
        public $type = 'sortable';

        public function render_content() {
            if (empty($this->choices)) {
                return;
            }

            $values = $this->value();
            if (!is_array($values)) {
                $values = array('logo', 'menu');
            }

            ?>
            <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
            <?php if (!empty($this->description)) : ?>
                <span class="description customize-control-description"><?php echo esc_html($this->description); ?></span>
            <?php endif; ?>

            <div class="mm-sortable">
                <ul class="mm-sortable-list">
                    <?php foreach ($values as $value) : ?>
                        <?php if (isset($this->choices[$value])) : ?>
                            <li class="mm-sortable-item" data-value="<?php echo esc_attr($value); ?>">
                                <?php echo esc_html($this->choices[$value]); ?>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <?php foreach ($this->choices as $value => $label) : ?>
                        <?php if (!in_array($value, $values)) : ?>
                            <li class="mm-sortable-item" data-value="<?php echo esc_attr($value); ?>">
                                <?php echo esc_html($label); ?>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
                <input type="hidden" id="<?php echo esc_attr($this->id); ?>" name="<?php echo esc_attr($this->id); ?>" value="<?php echo esc_attr(implode(',', $values)); ?>" <?php $this->link(); ?> />
            </div>
            <?php
        }
    }
}

/**
 * Output header elements based on customizer settings
 */
function mm_header_elements() {
    $header_layout = get_theme_mod('mm_header_layout', 'default');
    $elements = get_theme_mod('mm_header_elements', array('logo', 'menu'));

    if (!is_array($elements)) {
        $elements = explode(',', $elements);
    }

    // Apply header layout class
    $header_class = 'header-' . $header_layout;
    add_filter('body_class', function($classes) use ($header_class) {
        $classes[] = $header_class;
        return $classes;
    });

    // Apply header styles
    $header_padding = get_theme_mod('mm_header_padding', '20');
    $header_border = get_theme_mod('mm_header_border', true);
    $transparent_header = get_theme_mod('mm_transparent_header', false);

    $logo_position = get_theme_mod('mm_logo_position', 'left');
    $menu_position = get_theme_mod('mm_menu_position', 'right');

    // Add inline styles
    add_action('wp_head', function() use ($header_padding, $header_border, $transparent_header, $logo_position, $menu_position) {
        ?>
        <style type="text/css">
            .header-container {
                padding-top: <?php echo esc_attr($header_padding); ?>px;
                padding-bottom: <?php echo esc_attr($header_padding); ?>px;
                border-bottom: <?php echo $header_border ? '1px solid var(--mm-color-border)' : 'none'; ?>;
            }

            <?php if ($logo_position === 'center') : ?>
            .site-branding {
                justify-content: center;
                text-align: center;
            }
            <?php elseif ($logo_position === 'right') : ?>
            .site-branding {
                justify-content: flex-end;
                text-align: right;
            }
            <?php endif; ?>

            <?php if ($menu_position === 'center') : ?>
            .main-navigation {
                justify-content: center;
            }
            <?php elseif ($menu_position === 'left') : ?>
            .main-navigation {
                justify-content: flex-start;
            }
            <?php endif; ?>

            <?php if ($transparent_header && is_front_page()) : ?>
            .site-header {
                background-color: transparent;
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                z-index: 999;
                border-bottom: none;
            }
            .site-header .site-title a,
            .site-header .site-description,
            .site-header .main-navigation a {
                color: #fff;
            }
            <?php endif; ?>

            <?php if ($header_layout === 'centered') : ?>
            .header-container {
                flex-direction: column;
            }
            .site-branding {
                margin-bottom: 1rem;
            }
            <?php elseif ($header_layout === 'split') : ?>
            /* Split menu layout - requires JavaScript to implement fully */
            <?php elseif ($header_layout === 'left_aligned') : ?>
            .header-container {
                justify-content: flex-start;
            }
            .main-navigation {
                margin-left: 2rem;
            }
            <?php endif; ?>
        </style>
        <?php
    });

    // Output header elements in custom order
    add_action('mm_header_inside_before', function() use ($elements) {
        // Start custom header element container
        echo '<div class="header-elements">';

        foreach ($elements as $element) {
            switch ($element) {
                case 'logo':
                    // Logo is already included in the default header.php template
                    break;

                case 'menu':
                    // Menu is already included in the default header.php template
                    break;

                case 'search':
                    echo '<div class="header-search">';
                    get_search_form();
                    echo '</div>';
                    break;

                case 'button':
                    $button_text = get_theme_mod('mm_header_button_text', __('Contact Us', 'multi-maiven'));
                    $button_url = get_theme_mod('mm_header_button_url', '#');
                    echo '<div class="header-button">';
                    echo '<a href="' . esc_url($button_url) . '" class="mm-button">' . esc_html($button_text) . '</a>';
                    echo '</div>';
                    break;

                case 'html':
                    $custom_html = get_theme_mod('mm_header_html', '');
                    if (!empty($custom_html)) {
                        echo '<div class="header-html">';
                        echo wp_kses_post($custom_html);
                        echo '</div>';
                    }
                    break;
            }
        }

        echo '</div><!-- .header-elements -->';
    });
}
add_action('after_setup_theme', 'mm_header_elements');

/**
 * Enqueue header builder JavaScript
 */
function mm_header_builder_scripts() {
    if (is_customize_preview()) {
        wp_enqueue_script('mm-header-builder', get_template_directory_uri() . '/js/header-builder.js', array('customize-preview', 'jquery', 'jquery-ui-sortable'), _S_VERSION, true);
    }
}
add_action('customize_preview_init', 'mm_header_builder_scripts');

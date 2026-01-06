<?php

// Asegurarnos de que las clases base del Customizer existan antes de extenderlas
if (class_exists('WP_Customize_Control')) {

    // 1. CONTROL REPEATER (Para redes sociales e iconos)
    class Custom_Repeater_Control extends WP_Customize_Control {
        public $type = 'custom_repeater';
        public $choices = []; // Iconos permitidos

        public function enqueue() {
            wp_enqueue_script('jquery-ui-sortable');
            
            wp_enqueue_script(
                'custom-repeater-js', 
                get_template_directory_uri() . '/assets/js/repeater.js', 
                ['jquery', 'jquery-ui-sortable'], 
                false, 
                true
            );
            
            wp_enqueue_style(
                'custom-repeater-css', 
                get_template_directory_uri() . '/assets/css/modules/repeater.css'
            );
        }

        public function render_content() {
            $value = $this->value();
            $value = $value ? json_decode($value, true) : [];
            $icons_json = htmlspecialchars(json_encode($this->choices), ENT_QUOTES, 'UTF-8');
            ?>
            <label>
                <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
            </label>
            
            <div class="custom-repeater-wrapper" data-icons="<?php echo $icons_json; ?>">
                <button type="button" class="button add-item">Añadir elemento</button>

                <ul class="custom-repeater-list">
                    <?php if (!empty($value)): ?>
                        <?php foreach ($value as $item): ?>
                            <li class="custom-repeater-item">
                                <input type="text" class="title-field" placeholder="Título" value="<?php echo esc_attr(isset($item['title']) ? $item['title'] : ''); ?>">
                                
                                <select class="icon-select">
                                    <option value="">Elegir icono…</option>
                                    <?php foreach ($this->choices as $class => $label): ?>
                                        <option value="<?php echo esc_attr($class); ?>" <?php selected(isset($item['icon']) ? $item['icon'] : '', $class); ?>>
                                            <?php echo esc_html($label); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                                <input type="text" class="icon-field" placeholder="Icono manual (ej: fa-solid fa-user)" value="<?php echo esc_attr(isset($item['icon']) ? $item['icon'] : ''); ?>">
                                <input type="text" class="url-field" placeholder="URL" value="<?php echo esc_attr(isset($item['url']) ? $item['url'] : ''); ?>">

                                <span class="drag-handle">☰</span>
                                <button type="button" class="button remove-item">Eliminar</button>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>

                <input type="hidden" class="custom-repeater-hidden" <?php $this->link(); ?> value="<?php echo esc_attr($this->value()); ?>">
            </div>
            <?php
        }
    }

    // 2. CONTROL DE CATEGORÍAS (Dropdown)
    class WP_Customize_Category_Control extends WP_Customize_Control {
        public $type = 'dropdown-categories';
        public function render_content() {
            $dropdown = wp_dropdown_categories([
                'show_option_none' => __('— Selecciona —', 'theme-domain'),
                'orderby' => 'name',
                'hide_empty' => false,
                'name' => '_customize-dropdown-categories-' . $this->id,
                'selected' => $this->value(),
                'echo' => false
            ]);
            $dropdown = str_replace('<select', '<select ' . $this->get_link(), $dropdown);
            echo '<label><span class="customize-control-title">' . esc_html($this->label) . '</span></label>';
            echo $dropdown;
        }
    }
}

/**
 * Función principal de registro de opciones del Customizer
 */
function theme_customize_register($wp_customize) {
    
    // --- LISTAS DE ICONOS ---
    $social_icons = [
        'fab fa-facebook-f'   => 'Facebook',
        'fab fa-instagram'    => 'Instagram',
        'fab fa-tiktok'       => 'TikTok',
        'fab fa-whatsapp'     => 'WhatsApp',
        'fab fa-x-twitter'    => 'X (Twitter)',
        'fab fa-youtube'      => 'YouTube',
        'fab fa-linkedin-in'  => 'LinkedIn',
        'fas fa-envelope'     => 'Email (Correo)',
        'fas fa-phone'        => 'Teléfono',
    ];

    $related_icons = [
        'fa-solid fa-newspaper' => 'Noticia / Diario',
        'fa-solid fa-building'  => 'Empresa / Edificio',
        'fa-solid fa-globe'     => 'Sitio Web / Globo',
        'fa-solid fa-link'      => 'Enlace',
        'fa-solid fa-check'     => 'Verificado',
    ];

    // --- SECCIÓN: REDES SOCIALES ---
    $wp_customize->add_section('social_links_section', [
        'title' => __('Redes Sociales', 'theme-domain'),
        'priority' => 30,
    ]);

    $wp_customize->add_setting('social_links_data', [
        'default' => '',
        'sanitize_callback' => function ($input) { return wp_kses_post($input); }
    ]);

    if (class_exists('Custom_Repeater_Control')) {
        $wp_customize->add_control(new Custom_Repeater_Control($wp_customize, 'social_links_data', [
            'label' => __('Redes sociales dinámicas', 'theme-domain'),
            'section' => 'social_links_section',
            'choices' => $social_icons, 
        ]));
    }

    // --- SECCIÓN: SITIOS RELACIONADOS ---
    $wp_customize->add_section('related_sites_section', [
        'title' => __('Sitios Relacionados', 'theme-domain'),
        'priority' => 31,
    ]);

    $wp_customize->add_setting('related_sites_data', [
        'default' => '',
        'sanitize_callback' => function ($input) { return wp_kses_post($input); }
    ]);

    if (class_exists('Custom_Repeater_Control')) {
        $wp_customize->add_control(new Custom_Repeater_Control($wp_customize, 'related_sites_data', [
            'label' => __('Enlaces del footer', 'theme-domain'),
            'section' => 'related_sites_section',
            'choices' => $related_icons,
        ]));
    }

    // --- SECCIÓN: GRID DE NOTICIAS ---
    $wp_customize->add_section('grid_news_section', [
        'title' => __('Grid de Noticias', 'theme-domain'),
        'priority' => 30,
    ]);

    $wp_customize->add_setting('grid_category_id', [
        'default' => '',
        'sanitize_callback' => 'absint',
    ]);

    if (class_exists('WP_Customize_Category_Control')) {
        $wp_customize->add_control(new WP_Customize_Category_Control(
            $wp_customize,
            'grid_category_control',
            [
                'label' => __('Categoría a mostrar', 'theme-domain'),
                'section' => 'grid_news_section',
                'settings' => 'grid_category_id',
            ]
        ));
    }

    // --- SECCIÓN: BLOG ---
    $wp_customize->add_section('blog_settings_section', array(
        'title' => __('Control del Blog', 'theme-domain'),
        'priority' => 35,
    ));

    $wp_customize->add_setting('show_blog_list', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('show_blog_list_control', array(
        'label' => __('Mostrar listado del blog', 'theme-domain'),
        'section' => 'blog_settings_section',
        'settings' => 'show_blog_list',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('home_posts_per_page', array(
        'default' => 10,
        'sanitize_callback' => 'absint',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control('home_posts_per_page_control', array(
        'label' => __('Artículos por página', 'theme-domain'),
        'section' => 'blog_settings_section',
        'settings' => 'home_posts_per_page',
        'type' => 'number',
        'input_attrs' => array('min' => 1, 'max' => 50, 'step' => 1)
    ));
}
add_action('customize_register', 'theme_customize_register');
<?php

class NS_ACF_Field_Dimensions extends acf_field
{
    public function __construct(array $settings)
    {
        // Name.
        $this->name = 'dimensions';

        // Label.
        $this->label = esc_html__('Dimensions', 'acf-dimensions');

        // Category.
        $this->category = 'layout';

        // Defaults.
        $this->defaults = [
            'return_format' => 'string',
            'unit' => 'rem',
        ];

        // Internationalization.
        $this->l10n = [];

        // Units.
        $this->units = [
            'px' => 'px',
            '%' => '%',
            'in' => 'in',
            'cm' => 'cm',
            'mm' => 'mm',
            'em' => 'em',
            'ex' => 'ex',
            'pt' => 'pt',
            'pc' => 'pc',
            'rem' => 'rem',
        ];

        $this->sizes = [
            '' => 'Default',
            'none' => 'None',
            'xx-small' => 'XX-Small',
            'x-small' => 'X-Small',
            'small' => 'Small',
            'medium' => 'Medium',
            'large' => 'Large',
            'x-large' => 'X-Large',
            'xx-large' => 'XX-Large',
            'custom' => 'Custom',
        ];

        $this->sides = [
            'block' => 'Block',
            'inline' => 'Inline',
        ];

        // Settings.
        $this->settings = $settings;

//        $this->env = array(
//            'url'     => site_url( str_replace( ABSPATH, '', __DIR__ ) ), // URL to the acf-FIELD-NAME directory.
//            'version' => '1.0', // Replace this with your theme or plugin version constant.
//        );

//        $this->preview_image

        // Call parent constructor.
        parent::__construct();
    }

    /**
     * Render field settings.
     *
     * @param array $field Field details.
     * @since 1.0.0
     *
     */
    public function render_field_settings(array $field): void
    {
        acf_render_field_setting(
            $field,
            [
                'label' => esc_html__('Return Format', 'acf-dimensions'),
                'instructions' => '',
                'type' => 'radio',
                'name' => 'return_format',
                'layout' => 'horizontal',
                'choices' => [
                    'string' => esc_html__('String', 'acf-dimensions'),
                    'array' => esc_html__('Array', 'acf-dimensions'),
                ],
            ]
        );
        acf_render_field_setting(
            $field,
            [
                'label' => esc_html__('Default Unit', 'acf-dimensions'),
                'instructions' => '',
                'type' => 'radio',
                'name' => 'default_unit',
                'choices' => $this->units,
                'layout' => 'horizontal',
            ]
        );
    }

    /**
     * Render field.
     *
     * @param array $field Field details.
     * @since 1.0.0
     *
     */
    public function render_field(array $field): void
    {
        $devices = [
            'desktop',
            'tablet',
            'mobile',
        ];
        ?>
        <div class="acf-dimensions">
            <div class="acf-dimensions__buttons">
                <ul>
                    <?php $cnt = 1; ?>
                    <?php foreach ($devices as $item) : ?>
                        <?php
                        $icon = ('mobile' === $item) ? 'dashicons-smartphone' : 'dashicons-'.$item;
                        $classes = (1 === $cnt) ? 'btn--active' : '';
                        ?>
                        <li>
                            <a href="#" rel="acf-dimensions__device--<?php esc_attr_e($item); ?>" class="btn <?php esc_attr_e($classes); ?>" rel="acf-dimensions__device--<?php esc_attr_e($item); ?>"><span class="dashicons <?php esc_attr_e($icon); ?>"></span></a>
                        </li>
                        <?php $cnt++; ?>
                    <?php endforeach; ?>
                </ul>
            </div><!-- .acf-dimensions__buttons -->

            <div class="acf-dimensions__devices">

                <?php $cnt = 1; ?>
                <?php foreach ($devices as $item) : ?>

                    <?php
                    $device_classes = 'acf-dimensions__device--'.$item;

                    if (1 === $cnt) {
                        $device_classes .= ' acf-dimensions__device--active';
                    }
                    ?>

                    <div class="acf-dimensions__device <?php esc_attr_e($device_classes); ?>">
                        <?php
                        // Values.
                        $value_top = $field['value'][$item]['top'] ?? '';
                        $value_right = $field['value'][$item]['right'] ?? '';
                        $value_bottom = $field['value'][$item]['bottom'] ?? '';
                        $value_left = $field['value'][$item]['left'] ?? '';

                        // Linked status.
                        $is_linked = 1 === absint($field['value'][$item]['linked'] ?? 0);

                        if ($is_linked) {
                            $value_right = $value_top;
                            $value_bottom = $value_top;
                            $value_left = $value_top;
                        }
                        ?>

                        <div class="acf-dimensions__inputs">
                            <div class="sides">
                                <?php foreach ($this->sides as $sideKey => $side): ?>
                                    <?php esc_html_e($side); ?>
                                    <select
                                            name="<?php esc_attr_e($field['name']); ?>[side][<?php esc_attr_e($sideKey); ?>]"
                                    >
                                        <?php foreach ($this->sizes as $sizeKey => $size): ?>
                                            <option value="<?php esc_attr_e($sizeKey); ?>"><?php esc_html_e($size); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                <?php endforeach; ?>
                            </div>
                            <div class="acf-dimensions__texts">
                                <div class="acf-dimensions__input">
                                    <input type="text"
                                           class="input-top"
                                           name="<?php esc_attr_e($field['name']); ?>[<?php esc_attr_e($item); ?>][top]"
                                           value="<?php esc_attr_e($value_top); ?>"
                                    />
                                    <span class="input-label"><?php esc_html_e('Top', 'acf-dimensions'); ?></span>
                                </div><!-- .acf-dimensions__input -->
                                <div class="acf-dimensions__input">
                                    <input type="text"
                                           class="input-right"
                                           name="<?php esc_attr_e($field['name']); ?>[<?php esc_attr_e($item); ?>][right]"
                                           value="<?php esc_attr_e($value_right); ?>"
                                        <?php echo $is_linked ? ' readonly ' : ''; ?>
                                    />
                                    <span class="input-label"><?php esc_html_e('Right', 'acf-dimensions'); ?></span>
                                </div>
                                <div class="acf-dimensions__input">
                                    <input type="text"
                                           class="input-bottom"
                                           name="<?php esc_attr_e($field['name']); ?>[<?php esc_attr_e($item); ?>][bottom]"
                                           value="<?php esc_attr_e($value_bottom); ?>"
                                        <?php echo $is_linked ? ' readonly ' : ''; ?>
                                    />
                                    <span class="input-label"><?php esc_html_e('Bottom', 'acf-dimensions'); ?></span>
                                </div>
                                <div class="acf-dimensions__input">
                                    <input type="text"
                                           class="input-left"
                                           name="<?php esc_attr_e($field['name']); ?>[<?php esc_attr_e($item); ?>][left]"
                                           value="<?php esc_attr_e($value_left); ?>"
                                        <?php echo $is_linked ? ' readonly ' : ''; ?>
                                    />
                                    <span class="input-label"><?php esc_html_e('Left', 'acf-dimensions'); ?></span>
                                </div>
                            </div><!-- .acf-dimensions__texts -->
                            <div class="acf-dimensions__linker">
                                <?php
                                $button_classes = '';

                                if ($is_linked) {
                                    $button_classes .= ' btn--active';
                                }
                                ?>
                                <button class="btn btn--linker <?php esc_attr_e($button_classes); ?>">
                                    <span class="linked dashicons dashicons-admin-links"></span>
                                    <span class="unlinked dashicons dashicons-editor-unlink"></span>
                                </button>

                                <input type="hidden" class="input-linked" name="<?php esc_attr_e($field['name']); ?>[<?php esc_attr_e($item); ?>][linked]" value="<?php esc_attr_e($is_linked); ?>"/>
                            </div><!-- .acf-dimensions__linker -->
                        </div>
                        <div class="acf-dimensions__unit">
                            <?php
                            $selected_desktop_unit = (isset($field['value'][$item]['unit'])) ? $field['value'][$item]['unit'] : '';
                            ?>
                            <select name="<?php esc_attr_e($field['name']); ?>[<?php esc_attr_e($item); ?>][unit]">
                                <?php foreach ($this->units as $unitItem) : ?>
                                    <option value="<?php esc_attr_e($unitItem); ?>" <?php selected($unitItem, $selected_desktop_unit); ?>><?php echo esc_html($unitItem); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div><!-- .acf-dimensions__unit -->
                    </div>
                    <?php $cnt++; ?>
                <?php endforeach; ?>

            </div><!-- .acf-dimensions__devices -->

        </div><!-- .acf-dimensions -->
        <?php
    }

    /**
     * Load assets.
     *
     * @since 1.0.0
     */
    public function input_admin_enqueue_scripts()
    {
        $url = $this->settings['url'];

        $version = $this->settings['version'];

        wp_enqueue_script('acf-dimensions', "{$url}assets/input.js", array('acf-input'), $version);
        wp_enqueue_style('acf-dimensions', "{$url}assets/input.css", array('acf-input'), $version);
    }

    /**
     * Get string format value.
     *
     * @param mixed $value The value which was loaded from the database.
     * @param int $post_id The $post_id from which the value was loaded.
     * @param array $field The field array holding all the field options.
     * @return mixed The modified value.
     * @since 1.0.0
     *
     */
    public function format_value($value, $post_id, $field)
    {
        // Bail early if no value.
        if (empty($value)) {
            return $value;
        }

        if ('string' === $field['return_format']) {
            return $this->get_string_format_value($value);
        }

        return $value;
    }

    /**
     * Get string format value.
     *
     * @param array $value Value.
     * @return array Array of CSS string based on device.
     * @since 1.0.0
     *
     */
    public function get_string_format_value($value)
    {
        $output = [];

        $devices = [
            'desktop',
            'tablet',
            'mobile',
        ];

        foreach ($devices as $item) {
            $css = '';

            $top = $value[$item]['top'] ?? '';
            $right = $value[$item]['right'] ?? '';
            $bottom = $value[$item]['bottom'] ?? '';
            $left = $value[$item]['left'] ?? '';
            $unit = $value[$item]['unit'] ?? '';

            if ('' !== $top || '' !== $right || '' !== $bottom || '' !== $left) {
                $css .= sprintf('%2$s%1$s %3$s%1$s %4$s%1$s %5$s%1$s', $unit, (float)$top, (float)$right, (float)$bottom, (float)$left);
            }

            $output[$item] = $css;
        }

        return $output;
    }
}


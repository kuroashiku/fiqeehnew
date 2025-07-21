<?php 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

define( 'LANDINGPRESS_CUSTOMIZER_VERSION', '0.2.2-lp' );

function landingpress_customize_setting_type() {
	return apply_filters( 'landingpress_customize_setting_type', 'theme_mod' );
}

function landingpress_customize_setting_db() {
	$setting_db = defined( 'LANDINGPRESS_THEME_SLUG' ) ? LANDINGPRESS_THEME_SLUG : '';
	$setting_db = apply_filters( 'landingpress_customize_setting_db', $setting_db );
	if ( !$setting_db ) {
		$setting_db = get_template();
	}
	return $setting_db;
}

function landingpress_customize_get_mod( $field ) {
	if ( ! $field['setting'] ) {
		return false;
	}
	if ( ! isset( $field['default'] ) ) {
		global $landingpress_defaults;
		if ( isset( $landingpress_defaults[ $field['setting'] ] ) ) {
			$field['default'] = $landingpress_defaults[ $field['setting'] ];
		}
		else {
			$field['default'] = false;
		}
	}
	if ( ! isset( $field['setting_type'] ) ) {
		$field['setting_type'] = landingpress_customize_setting_type();
	}
	if ( ! isset( $field['setting_db'] ) ) {
		$field['setting_db'] = '';
	}
	if ( $field['setting_type'] == 'option' ) {
		$value = get_option( $field['setting'], $field['default'] );
	}
	elseif ( $field['setting_type'] == 'option_mod' ) {
		if ( $field['setting_db'] ) {
			$setting_db = $field['setting_db'];
		}
		else {
			$setting_db = landingpress_customize_setting_db();
		}
		$setting_db_value = get_option( $setting_db );
		if ( isset($setting_db_value[$field['setting']]) ) {
			$value = $setting_db_value[$field['setting']];
		}
		else {
			$value = $field['default'];
		}
	}
	else {
		$value = get_theme_mod( $field['setting'], $field['default'] );
	}
	return $value;
}

add_action( 'customize_register', 'landingpress_customize_register', 10 );
function landingpress_customize_register( $wp_customize ){

	if ( ! isset( $wp_customize ) ) {
		return;
	}

	$wp_customize->register_control_type( 'LandingPress_Customize_Heading_Control' );
	$wp_customize->register_control_type( 'LandingPress_Customize_Warning_Control' );
	$wp_customize->register_control_type( 'LandingPress_Customize_Number_Control' );
	$wp_customize->register_control_type( 'LandingPress_Customize_Color_Control' );
	$wp_customize->register_control_type( 'LandingPress_Customize_Slider_Control' );
	$wp_customize->register_control_type( 'LandingPress_Customize_Radio_Buttonset_Control' );
	$wp_customize->register_control_type( 'LandingPress_Customize_Radio_Iconset_Control' );
	$wp_customize->register_control_type( 'LandingPress_Customize_Radio_Image_Control' );
	$wp_customize->register_control_type( 'LandingPress_Customize_Select2_Control' );
	$wp_customize->register_control_type( 'LandingPress_Customize_Select2_Multiple_Control' );
	$wp_customize->register_control_type( 'LandingPress_Customize_GoogleFonts_Control' );
	$wp_customize->register_control_type( 'LandingPress_Customize_Sortable_Control' );

	$fields = apply_filters( 'landingpress_customize_controls', array() );

	if ( ! empty( $fields ) ) {
		foreach ( $fields as $field ) {

			$defaults = array(
				'setting_type'			=> landingpress_customize_setting_type(),
				'setting'				=> '',
				'setting_db'			=> '',
				'section'				=> 'colors',
				'panel'					=> '',
				'title'					=> '',
				'type'					=> '',
				'priority'				=> 10,
				'label'					=> '',
				'description'			=> '',
				'choices'				=> array(),
				'input_attrs'			=> array(),
				'default'				=> '',
				'capability'			=> 'edit_theme_options',
				'sanitize_callback'		=> '',
				'active_callback'		=> '',
				'transport'				=> 'refresh',
			);

			if ( 'text' == $field['type'] ) {
				$defaults['sanitize_callback'] = 'sanitize_text_field';
			}
			elseif ( 'textarea' == $field['type'] ) {
				$defaults['sanitize_callback'] = 'sanitize_textarea_field';
			}
			elseif ( 'textarea-html' == $field['type'] ) {
				$defaults['sanitize_callback'] = 'landingpress_customize_sanitize_html';
			}
			elseif ( 'textarea-nohtml' == $field['type'] ) {
				$defaults['sanitize_callback'] = 'landingpress_customize_sanitize_nohtml';
			}
			elseif ( 'textarea-unfiltered' == $field['type'] ) {
				$defaults['sanitize_callback'] = 'landingpress_customize_sanitize_unfiltered';
			}
			elseif ( 'email' == $field['type'] ) {
				$defaults['sanitize_callback'] = 'landingpress_customize_sanitize_email';
			}
			elseif ( 'url' == $field['type'] ) {
				$defaults['sanitize_callback'] = 'landingpress_customize_sanitize_url';
			}
			elseif ( 'number' == $field['type'] ) {
				$defaults['sanitize_callback'] = 'landingpress_customize_sanitize_number';
			}
			elseif ( 'checkbox' == $field['type'] ) {
				$defaults['sanitize_callback'] = 'landingpress_customize_sanitize_checkbox';
			}
			elseif ( in_array( $field['type'], array( 'select', 'select2', 'radio', 'radio-buttonset', 'radio-iconset', 'radio-image' ) ) ) {
				$defaults['sanitize_callback'] = 'landingpress_customize_sanitize_select';
			}
			elseif ( in_array( $field['type'], array( 'sortable', 'select2-multiple' ) ) ) {
				$defaults['sanitize_callback'] = 'landingpress_customize_sanitize_select_multiple';
			}
			elseif ( in_array( $field['type'], array( 'font' ) ) ) {
				$defaults['sanitize_callback'] = 'landingpress_customize_sanitize_select_remote';
			}
			elseif ( 'image' == $field['type'] ) {
				$defaults['sanitize_callback'] = 'landingpress_customize_sanitize_image';
			}
			elseif ( 'color' == $field['type'] ) {
				$defaults['sanitize_callback'] = 'landingpress_customize_sanitize_color';
			}
			elseif ( 'dropdown-pages' == $field['type'] ) {
				$defaults['sanitize_callback'] = 'landingpress_customize_sanitize_pages';
			}
			else {
				$defaults['sanitize_callback'] = 'sanitize_text_field';
			}

			if ( !empty( $field['style'] ) ) {
				$defaults['transport'] = 'postMessage';
			} 

			global $landingpress_defaults;
			if ( isset( $landingpress_defaults[ $field['setting'] ] ) ) {
				$defaults['default'] = $landingpress_defaults[ $field['setting'] ];
			}

			$field = wp_parse_args( $field, $defaults );

			if ( $field['setting'] && $field['type'] ) {

				$setting = $field['setting'];
				if ( $field['setting_type'] == 'option_mod' ) {
					if ( $field['setting_db'] ) {
						$setting_db = $field['setting_db'];
					}
					else {
						$setting_db = landingpress_customize_setting_db();
					}
					$field['setting_type'] = 'option';
					$setting = $setting_db.'['.$field['setting'].']';
				}
				elseif ( $field['setting_type'] == 'option' ) {
					$field['setting_type'] = 'option';
				}
				else {
					$field['setting_type'] = 'theme_mod';
				}

				if ( in_array( $field['type'], array( 'slider', 'sidebar-width' ) ) ) {
					if ( !isset($field['choices']['min']) ) {
						$field['choices']['min'] = 0;
					}
					if ( !isset($field['choices']['max']) ) {
						$field['choices']['max'] = 100;
					}
					if ( !isset($field['choices']['step']) ) {
						$field['choices']['step'] = 1;
					}
					if ( !isset($field['choices']['unit']) ) {
						$field['choices']['unit'] = 'px';
					}
					if ( !isset($field['choices']['type']) ) {
						$field['choices']['type'] = $field['type'];
					}
				}

				if ( in_array( $field['type'], array( 'textarea-html', 'textarea-nohtml', 'textarea-unfiltered' ) ) ) {
					$field['type'] = 'textarea';
				}

				if ( 'panel' == $field['type'] ) {
					$wp_customize->add_panel( 
						$field['setting'], 
						array(
							'title'				=> $field['title'],
							'priority'			=> $field['priority'],
						)
					);
				}
				elseif ( 'section' == $field['type'] ) {
					if ( $field['panel'] ) {
						$wp_customize->add_section( 
							$field['setting'], 
							array(
								'title'				=> $field['title'],
								'description'		=> $field['description'],
								'panel'				=> $field['panel'],
								'priority'			=> $field['priority'],
							) 
						);
					}
					else {
						$wp_customize->add_section( 
							$field['setting'], 
							array(
								'title'				=> $field['title'],
								'description'		=> $field['description'],
								'priority'			=> $field['priority'],
							) 
						);
					}
				}
				else {
					$wp_customize->add_setting(
						$setting,
						array(
							'default'			=> $field['default'],
							'type'				=> $field['setting_type'],
							'capability'		=> $field['capability'],
							'sanitize_callback'	=> $field['sanitize_callback'],
							'transport'			=> $field['transport'],
						)
					);
					if ( in_array( $field['type'], array( 'checkbox', 'text', 'textarea', 'email', 'tel', 'url', 'dropdown-pages' ) ) ) {
						$wp_customize->add_control(
							$setting,
							array(
								'settings'		=> $setting,
								'section'		=> $field['section'],
								'type'			=> $field['type'],
								'priority'		=> $field['priority'],
								'label'			=> $field['label'],
								'description'	=> $field['description'],
								'input_attrs'	=> $field['input_attrs'],
								'active_callback' => $field['active_callback'], 
							)
						);
					}
					elseif ( in_array( $field['type'], array( 'radio', 'select' ) ) && !empty( $field['choices'] ) ) {
						$wp_customize->add_control(
							$setting,
							array(
								'settings'		=> $setting,
								'section'		=> $field['section'],
								'type'			=> $field['type'],
								'priority'		=> $field['priority'],
								'label'			=> $field['label'],
								'description'	=> $field['description'],
								'choices'		=> $field['choices'],
								'input_attrs'	=> $field['input_attrs'],
								'active_callback' => $field['active_callback'], 
							)
						);
					}
					elseif ( 'color' == $field['type'] ) {
						$wp_customize->add_control(
							// new WP_Customize_Color_Control( 
							new LandingPress_Customize_Color_Control( 
								$wp_customize,
								$setting,
								array(
									'settings'		=> $setting,
									'section'		=> $field['section'],
									'priority'		=> $field['priority'],
									'label'			=> $field['label'],
									'description'	=> $field['description'],
									'input_attrs'	=> $field['input_attrs'],
									'active_callback' => $field['active_callback'], 
								)
							)
						);
					}
					elseif ( 'image' == $field['type'] ) {
						$wp_customize->add_control(
							new WP_Customize_Image_Control( 
								$wp_customize,
								$setting,
								array(
									'settings'		=> $setting,
									'section'		=> $field['section'],
									'priority'		=> $field['priority'],
									'label'			=> $field['label'],
									'description'	=> $field['description'],
									'input_attrs'	=> $field['input_attrs'],
									'active_callback' => $field['active_callback'], 
								)
							)
						);
					}
					elseif ( in_array( $field['type'], array( 'number' ) ) ) {
						$wp_customize->add_control(
							new LandingPress_Customize_Number_Control( 
								$wp_customize,
								$setting,
								array(
									'settings'		=> $setting,
									'section'		=> $field['section'],
									'priority'		=> $field['priority'],
									'label'			=> $field['label'],
									'description'	=> $field['description'],
									'choices'		=> $field['choices'],
									'input_attrs'	=> $field['input_attrs'],
									'active_callback' => $field['active_callback'], 
								)
							)
						);
					}
					elseif ( in_array( $field['type'], array( 'slider', 'sidebar-width' ) ) ) {
						$wp_customize->add_control(
							new LandingPress_Customize_Slider_Control( 
								$wp_customize,
								$setting,
								array(
									'settings'		=> $setting,
									'section'		=> $field['section'],
									'priority'		=> $field['priority'],
									'label'			=> $field['label'],
									'description'	=> $field['description'],
									'choices'		=> $field['choices'],
									'input_attrs'	=> $field['input_attrs'],
									'active_callback' => $field['active_callback'], 
								)
							)
						);
					}
					elseif ( 'radio-buttonset' == $field['type'] ) {
						$wp_customize->add_control(
							new LandingPress_Customize_Radio_Buttonset_Control( 
								$wp_customize,
								$setting,
								array(
									'settings'		=> $setting,
									'section'		=> $field['section'],
									'priority'		=> $field['priority'],
									'label'			=> $field['label'],
									'description'	=> $field['description'],
									'choices'		=> $field['choices'],
									'input_attrs'	=> $field['input_attrs'],
									'active_callback' => $field['active_callback'], 
								)
							)
						);
					}
					elseif ( 'radio-iconset' == $field['type'] ) {
						$wp_customize->add_control(
							new LandingPress_Customize_Radio_Iconset_Control( 
								$wp_customize,
								$setting,
								array(
									'settings'		=> $setting,
									'section'		=> $field['section'],
									'priority'		=> $field['priority'],
									'label'			=> $field['label'],
									'description'	=> $field['description'],
									'choices'		=> $field['choices'],
									'input_attrs'	=> $field['input_attrs'],
									'active_callback' => $field['active_callback'], 
								)
							)
						);
					}
					elseif ( 'radio-image' == $field['type'] ) {
						$wp_customize->add_control(
							new LandingPress_Customize_Radio_Image_Control( 
								$wp_customize,
								$setting,
								array(
									'settings'		=> $setting,
									'section'		=> $field['section'],
									'priority'		=> $field['priority'],
									'label'			=> $field['label'],
									'description'	=> $field['description'],
									'choices'		=> $field['choices'],
									'input_attrs'	=> $field['input_attrs'],
									'active_callback' => $field['active_callback'], 
								)
							)
						);
					}
					elseif ( 'heading' == $field['type'] ) {
						$wp_customize->add_control(
							new LandingPress_Customize_Heading_Control( 
								$wp_customize,
								$setting,
								array(
									'settings'		=> $setting,
									'section'		=> $field['section'],
									'priority'		=> $field['priority'],
									'label'			=> $field['label'],
									'description'	=> $field['description'],
									'input_attrs'	=> $field['input_attrs'],
									'active_callback' => $field['active_callback'], 
								)
							)
						);
					}
					elseif ( 'warning' == $field['type'] ) {
						$wp_customize->add_control(
							new LandingPress_Customize_Warning_Control( 
								$wp_customize,
								$setting,
								array(
									'settings'		=> $setting,
									'section'		=> $field['section'],
									'priority'		=> $field['priority'],
									'label'			=> $field['label'],
									'description'	=> $field['description'],
									'input_attrs'	=> $field['input_attrs'],
									'active_callback' => $field['active_callback'], 
								)
							)
						);
					}
					elseif ( 'select2' == $field['type'] ) {
						$wp_customize->add_control(
							new LandingPress_Customize_Select2_Control( 
								$wp_customize,
								$setting,
								array(
									'settings'		=> $setting,
									'section'		=> $field['section'],
									'priority'		=> $field['priority'],
									'label'			=> $field['label'],
									'description'	=> $field['description'],
									'choices'		=> $field['choices'],
									'input_attrs'	=> $field['input_attrs'],
									'active_callback' => $field['active_callback'], 
								)
							)
						);
					}
					elseif ( 'select2-multiple' == $field['type'] ) {
						$wp_customize->add_control(
							new LandingPress_Customize_Select2_Multiple_Control( 
								$wp_customize,
								$setting,
								array(
									'settings'		=> $setting,
									'section'		=> $field['section'],
									'priority'		=> $field['priority'],
									'label'			=> $field['label'],
									'description'	=> $field['description'],
									'choices'		=> $field['choices'],
									'input_attrs'	=> $field['input_attrs'],
									'active_callback' => $field['active_callback'], 
								)
							)
						);
					}
					elseif ( 'font' == $field['type'] ) {
						$wp_customize->add_control(
							new LandingPress_Customize_GoogleFonts_Control( 
								$wp_customize,
								$setting,
								array(
									'settings'		=> $setting,
									'section'		=> $field['section'],
									'priority'		=> $field['priority'],
									'label'			=> $field['label'],
									'description'	=> $field['description'],
									'choices'		=> array(),
									'input_attrs'	=> $field['input_attrs'],
									'active_callback' => $field['active_callback'], 
								)
							)
						);
					}
					elseif ( 'sortable' == $field['type'] ) {
						$wp_customize->add_control(
							new LandingPress_Customize_Sortable_Control( 
								$wp_customize,
								$setting,
								array(
									'settings'		=> $setting,
									'section'		=> $field['section'],
									'priority'		=> $field['priority'],
									'label'			=> $field['label'],
									'description'	=> $field['description'],
									'choices'		=> $field['choices'],
									'input_attrs'	=> $field['input_attrs'],
									'active_callback' => $field['active_callback'], 
								)
							)
						);
					}
				}
			}
		}
	}
}

add_action( 'customize_controls_enqueue_scripts', 'landingpress_customize_controls_enqueue_scripts' );
function landingpress_customize_controls_enqueue_scripts() {
	$assets_uri = apply_filters( 'landingpress_customize_assets_uri', get_template_directory_uri() . '/assets' );
	wp_enqueue_style( 'select2', $assets_uri . '/lib/select2/css/select2.min.css', array(), '4.0.6-rc.1' );
	wp_enqueue_script( 'select2', $assets_uri . '/lib/select2/js/select2.full.min.js', array('jquery'), '4.0.6-rc.1', false );
	wp_enqueue_script( 'landingpress-customize', $assets_uri . '/js/customize.min.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-slider', 'jquery-ui-button', 'jquery-ui-sortable', 'wp-color-picker', 'select2' ), LANDINGPRESS_CUSTOMIZER_VERSION, true );
	wp_enqueue_style( 'landingpress-customize', $assets_uri . '/css/customize.min.css', array( 'wp-color-picker', 'select2' ), LANDINGPRESS_CUSTOMIZER_VERSION );
}

function landingpress_customize_output() {
	$style = '';
	$fonts = array();
	$fields = apply_filters( 'landingpress_customize_controls', array() );
	if ( ! empty( $fields ) ) {
		foreach ( $fields as $field ) {
			$defaults = array(
				'setting_type'			=> landingpress_customize_setting_type(),
				'setting'				=> '',
				'setting_db'			=> '',
				'type'					=> '',
				'style'					=> '',
			);
			$field = wp_parse_args( $field, $defaults );
			if ( in_array( $field['type'], array( 'color', 'image' ) ) && $field['setting'] && !empty( $field['style'] ) ) {
				if ( $value = landingpress_customize_get_mod( $field ) ) {
					$style .= str_replace( '[value]', $value, $field['style'] );
				}
			}
			elseif ( in_array( $field['type'], array( 'number', 'slider' ) ) && $field['setting'] && !empty( $field['style'] ) ) {
				$value = landingpress_customize_get_mod( $field );
				if ( is_numeric( $value ) ) {
					$style .= str_replace( '[value]', $value, $field['style'] );
				}
			}
			elseif ( in_array( $field['type'], array( 'radio', 'select', 'select2', 'radio-buttonset', 'radio-iconset', 'radio-image' ) ) && $field['setting'] && !empty( $field['style'] ) ) {
				if ( $value = landingpress_customize_get_mod( $field ) ) {
					if ( isset( $field['style'][$value] ) ) {
						$style .= $field['style'][$value];
					}
				}
			}
			elseif ( in_array( $field['type'], array( 'checkbox' ) ) && $field['setting'] && !empty( $field['style'] ) ) {
				$value = landingpress_customize_get_mod( $field );
				if ( $value && isset( $field['style']['on'] ) ) {
					$style .= $field['style']['on'];
				}
				elseif ( ! $value && isset( $field['style']['off'] ) ) {
					$style .= $field['style']['off'];
				}
			}
			elseif ( in_array( $field['type'], array( 'font' ) ) && $field['setting'] && isset( $field['selector'] ) && $field['selector'] ) {
				$value = landingpress_customize_get_mod( $field );
				if ( $value && 'default' != $value ) {
					if ( in_array( $value, array( 'serif', 'sans-serif' ) ) ) {
						$style .= $field['selector'].'{font-family:'.$value.';}';
					}
					elseif ( false !== strpos( $value, ' (' ) && false !== strpos( $value, ')' ) ) {
						$value = str_replace( ')', '', $value );
						$value = explode( ' (', $value );
						if ( is_array( $value ) && 2 == count($value) ) {
							if ( in_array( $value[1], array( 'serif', 'sans-serif' ) ) ) {
								$style .= $field['selector'].'{font-family:"'.$value[0].'", '.$value[1].';}';
							}
							else {
								$style .= $field['selector'].'{font-family:"'.$value[0].'";}';
							}
							$fonts[$value[0]] = $value[0];
						}
					}
					else {
						$style .= $field['selector'].'{font-family:"'.$value.'", sans-serif;}';
						$fonts[$value] = $value;
					}
				}
			}
			elseif ( in_array( $field['type'], array( 'sidebar-width' ) ) && $field['setting'] && !empty( $field['style'] ) ) {
				$value = landingpress_customize_get_mod( $field );
				if ( $value > 0 ) {
					$sidebar_style = $field['style'];
					$sidebar_style = str_replace( '[value]', $value, $sidebar_style );
					$sidebar_style = str_replace( '[100_value]', (100-$value), $sidebar_style );
					$style .= $sidebar_style;
				}
			}
		}
	}
	$output = array( 
		'style' => $style,
		'fonts' => $fonts,
	);
	return $output;
}

add_action( 'customize_save_after', 'landingpress_customize_save_after' );
function landingpress_customize_save_after() {
	$output = landingpress_customize_output();
	set_theme_mod( 'landingpress_customize_css', $output['style'] );
	set_theme_mod( 'landingpress_customize_fonts', $output['fonts'] );
	set_theme_mod( 'landingpress_customize_saved', 'yes' );
}

add_filter( 'landingpress_style', 'landingpress_style_customize_css' );
function landingpress_style_customize_css( $style ) {
	$css = '';
	if ( ! is_customize_preview() ) {
		if ( defined( 'LANDINGPRESS_CUSTOMIZER_DEBUG' ) && LANDINGPRESS_CUSTOMIZER_DEBUG ) {
			$style = $style.' /* Customizer Debug is ON */ ';
			$output = landingpress_customize_output();
			$css = $output['style'];
		}
		else {
			$saved =  get_theme_mod( 'landingpress_customize_saved' );
			if ( $saved ) {
				$css = get_theme_mod( 'landingpress_customize_css' );
			}
			else {
				$output = landingpress_customize_output();
				$css = $output['style'];
				set_theme_mod( 'landingpress_customize_css', $output['style'] );
				set_theme_mod( 'landingpress_customize_fonts', $output['fonts'] );
				set_theme_mod( 'landingpress_customize_saved', 'yes' );
			}
		}
	}
	$style = $style.$css;
	return $style;
}

/* Backward compatibility for old themes */
add_action( 'landingpress_custom_styles', 'landingpress_style_customize_css_custom' );
function landingpress_style_customize_css_custom() {
	echo apply_filters( 'landingpress_style', '' );
}

add_action( 'wp_enqueue_scripts', 'landingpress_enqueue_googlefonts' );
function landingpress_enqueue_googlefonts() {
	$fonts = array();
	if ( ! is_customize_preview() ) {
		if ( defined( 'LANDINGPRESS_CUSTOMIZER_DEBUG' ) && LANDINGPRESS_CUSTOMIZER_DEBUG ) {
			$output = landingpress_customize_output();
			$fonts = $output['fonts'];
		}
		else {
			$saved =  get_theme_mod( 'landingpress_customize_saved' );
			if ( $saved ) {
				$fonts = get_theme_mod('landingpress_customize_fonts');
			}
			else {
				$output = landingpress_customize_output();
				$fonts = $output['fonts'];
				set_theme_mod( 'landingpress_customize_css', $output['style'] );
				set_theme_mod( 'landingpress_customize_fonts', $output['fonts'] );
				set_theme_mod( 'landingpress_customize_saved', 'yes' );
			}
		}
	}
	$fonts = apply_filters( 'landingpress_customize_google_fonts', $fonts );
	if ( is_array( $fonts ) && !empty( $fonts ) ) {
		$googlefonts = array();
		foreach ( $fonts as $font ) {
			$googlefonts[] = urlencode($font).':400,700';
		}
		$stylesheet = 'https://fonts.googleapis.com/css?family='.implode( '|', $googlefonts ).'&display=swap';
		wp_enqueue_style( 'googlefonts', $stylesheet );
	}
}

add_action( 'wp_head', 'landingpress_customize_preview_head_css', 9999 );
function landingpress_customize_preview_head_css() {
	if ( ! is_customize_preview() ) {
		return;
	}
	$fields = apply_filters( 'landingpress_customize_controls', array() );
	if ( ! empty( $fields ) ) {
		foreach ( $fields as $field ) {
			$defaults = array(
				'setting_type'			=> landingpress_customize_setting_type(),
				'setting'				=> '',
				'setting_db'			=> '',
				'type'					=> '',
				'style'					=> '',
			);
			$field = wp_parse_args( $field, $defaults );
			if ( 'option_mod' == $field['setting_type'] ) {
				if ( $field['setting_db'] ) {
					$setting_db = $field['setting_db'];
				}
				else {
					$setting_db = landingpress_customize_setting_db();
				}
				$setting = $setting_db.'['.$field['setting'].']';
			}
			else {
				$setting = $field['setting'];
			}
			if ( in_array( $field['type'], array( 'color', 'image' ) ) && $field['setting'] && !empty( $field['style'] ) ) {
				if ( $value = landingpress_customize_get_mod( $field ) ) {
					$style = str_replace( '[value]', $value, $field['style'] );
					echo '<style type="text/css" id="customize_'.$field['setting'].'">'.$style.'</style>';
				}
			}
			elseif ( in_array( $field['type'], array( 'number', 'slider' ) ) && $field['setting'] && !empty( $field['style'] ) ) {
				$value = landingpress_customize_get_mod( $field );
				if ( is_numeric( $value ) ) {
					$style = str_replace( '[value]', $value, $field['style'] );
					echo '<style type="text/css" id="customize_'.$field['setting'].'">'.$style.'</style>';
				}
			}
			elseif ( in_array( $field['type'], array( 'radio', 'select', 'select2', 'radio-buttonset', 'radio-iconset', 'radio-image' ) ) && $field['setting'] && !empty( $field['style'] ) ) {
				if ( $value = landingpress_customize_get_mod( $field ) ) {
					if ( isset( $field['style'][$value] ) ) {
						$style = $field['style'][$value];
						echo '<style type="text/css" id="customize_'.$field['setting'].'">'.$style.'</style>';
					}
				}
			}
			elseif ( in_array( $field['type'], array( 'checkbox' ) ) && $field['setting'] && !empty( $field['style'] ) ) {
				$value = landingpress_customize_get_mod( $field );
				if ( $value && isset( $field['style']['on'] ) ) {
					echo '<style type="text/css" id="customize_'.$field['setting'].'">'.$field['style']['on'].'</style>';
				}
				elseif ( ! $value && isset( $field['style']['off'] ) ) {
					echo '<style type="text/css" id="customize_'.$field['setting'].'">'.$field['style']['off'].'</style>';
				}
			}
			elseif ( in_array( $field['type'], array( 'font' ) ) && $field['setting'] && isset( $field['selector'] ) && $field['selector'] ) {
				$value = landingpress_customize_get_mod( $field );
				$font_family = '';
				$font_google = false;
				if ( $value && 'default' != $value ) {
					if ( in_array( $value, array( 'serif', 'sans-serif' ) ) ) {
						$font_family = $value;
					}
					elseif ( false !== strpos( $value, ' (' ) && false !== strpos( $value, ')' ) ) {
						$value = str_replace( ')', '', $value );
						$value = explode( ' (', $value );
						if ( is_array( $value ) && 2 == count($value) ) {
							if ( in_array( $value[1], array( 'serif', 'sans-serif' ) ) ) {
								$font_family = '"'.$value[0].'", '.$value[1];
								$font_google = $value[0];
							}
							else {
								$font_family = '"'.$value[0].'"';
								$font_google = $value[0];
							}
						}
					}
					else {
						$font_family = '"'.$value.'", sans-serif';
						$font_google = $value;
					}
				}
				if ( $font_google ) {
					echo '<link id="font_'.$field['setting'].'" href="https://fonts.googleapis.com/css?family='.urlencode($font_google).':400,700" rel="stylesheet" type="text/css">';
				}
				if ( $font_family ) {
					echo '<style type="text/css" id="customize_'.$field['setting'].'">'.$field['selector'].'{ font-family: '.$font_family.'; }</style>';
				}
			}
			elseif ( in_array( $field['type'], array( 'sidebar-width' ) ) && $field['setting'] && !empty( $field['style'] ) ) {
				$value = landingpress_customize_get_mod( $field );
				if ( $value ) {
					$style = $field['style'];
					$style = str_replace( '[value]', $value, $style );
					$style = str_replace( '[100_value]', (100-$value), $style );
					echo '<style type="text/css" id="customize_'.$field['setting'].'">'.$style.'</style>';
				}
			}
		}
	}
}

add_action( 'customize_preview_init', 'landingpress_customize_preview_init' );
function landingpress_customize_preview_init() {
	add_action( 'wp_enqueue_scripts', 'landingpress_customize_preview_init_jquery' );
	add_action( 'wp_footer', 'landingpress_customize_preview_init_script_css', 20 );
}

function landingpress_customize_preview_init_jquery() {
	wp_enqueue_script( 'jquery' );
}

function landingpress_customize_preview_init_script_css() {
	$fields = apply_filters( 'landingpress_customize_controls', array() );
	if ( ! empty( $fields ) ) {
		echo '<script type="text/javascript" id="landingpress-customize-preview"> ( function( $ ) { head = $(\'head\'); '."\n";
		foreach ( $fields as $field ) {
			$defaults = array(
				'setting_type'			=> landingpress_customize_setting_type(),
				'setting'				=> '',
				'setting_db'			=> '',
				'type'					=> '',
				'style'					=> '',
			);
			$field = wp_parse_args( $field, $defaults );
			if ( $field['setting_type'] == 'option_mod' ) {
				if ( $field['setting_db'] ) {
					$setting_db = $field['setting_db'];
				}
				else {
					$setting_db = landingpress_customize_setting_db();
				}
				$setting = $setting_db.'['.$field['setting'].']';
			}
			else {
				$setting = $field['setting'];
			}
			if ( in_array( $field['type'], array( 'color', 'number', 'slider', 'image' ) ) && $field['setting'] && !empty( $field['style'] ) ) {
				$style_to = str_replace( '[value]', "' + to + '", $field['style'] );
				echo 'wp.customize(\''.$setting.'\',function( value ) { value.bind(function(to) { style = $(\'#customize_'.$field['setting'].'\'); style.remove(); if ( to ) { $(\'<style type="text/css" id="customize_'.$field['setting'].'">'.$style_to.'</style>\').appendTo( head ); } }); });'."\n";
			}
			elseif ( in_array( $field['type'], array( 'radio', 'select', 'select2', 'radio-buttonset', 'radio-iconset', 'radio-image' ) ) && $field['setting'] && !empty( $field['style'] ) ) {
				echo 'var customize_'.$field['setting'].' = '.json_encode( $field['style'] ).'; wp.customize(\''.$setting.'\',function( value ) { value.bind(function(to) { style = $(\'#customize_'.$field['setting'].'\'); style.remove(); if ( to ) { $(\'<style type="text/css" id="customize_'.$field['setting'].'">\' + customize_'.$field['setting'].'[to] + \'</style>\').appendTo( head ); } }); });'."\n";
			}
			elseif ( in_array( $field['type'], array( 'checkbox' ) ) && $field['setting'] && !empty( $field['style'] ) ) {
				echo 'var customize_'.$field['setting'].' = '.json_encode( $field['style'] ).';  wp.customize(\''.$setting.'\',function( value ) {  value.bind(function(to) {  style = $(\'#customize_'.$field['setting'].'\'); style.remove();  if ( to ) {  $(\'<style type="text/css" id="customize_'.$field['setting'].'">\' + customize_'.$field['setting'].'["on"] + \'</style>\').appendTo( head );  } else { $(\'<style type="text/css" id="customize_'.$field['setting'].'">\' + customize_'.$field['setting'].'["off"] + \'</style>\').appendTo( head ); } }); });'."\n";
			}
			elseif ( in_array( $field['type'], array( 'sidebar-width' ) ) && $field['setting'] && !empty( $field['style'] ) ) {
				$style_to = $field['style'];
				$style_to = str_replace( '[value]', "' + to + '", $style_to );
				$style_to = str_replace( '[100_value]', "' + ( 100 - to ) + '", $style_to );
				echo 'wp.customize(\''.$setting.'\',function( value ) { value.bind(function(to) { style = $(\'#customize_'.$field['setting'].'\'); style.remove(); if ( to > 0 ) { $(\'<style type="text/css" id="customize_'.$field['setting'].'">'.$style_to.'</style>\').appendTo( head ); } }); });'."\n";
			}
		}
		echo '} )( jQuery ); </script>'."\n";
	}
}

function landingpress_customize_sanitize_number( $val ) {
	return is_numeric( $val ) ? $val : '';
}

function landingpress_customize_sanitize_url( $url ) {
	return esc_url_raw( $url );
}

function landingpress_customize_sanitize_email( $email, $setting ) {
	$email = sanitize_email( $email );
	return ( ! null( $email ) ? $email : $setting->default );
}

function landingpress_customize_sanitize_checkbox( $checked ) {
	return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

function landingpress_customize_sanitize_select( $input, $setting ) {
	$choices = $setting->manager->get_control( $setting->id )->choices;
	$default = $setting->default;
	if ( isset( $choices[''] ) ) {
		$default = '';
	}
	return ( array_key_exists( $input, $choices ) ? $input : $default );
}

function landingpress_customize_sanitize_select_multiple( $input, $setting ) {
	$input_keys = $input;
	$choices = $setting->manager->get_control( $setting->id )->choices;
	foreach ( $input_keys as $key => $value ) {
		if ( ! array_key_exists( $value, $choices ) ) {
			unset( $input[ $key ] );
		}
	}
	return ( is_array( $input ) ? $input : array() );
}

function landingpress_customize_sanitize_select_remote( $input, $setting ) {
	return esc_attr( $input );
}

function landingpress_customize_sanitize_image( $image, $setting ) {
    $mimes = array(
        'jpg|jpeg|jpe' => 'image/jpeg',
        'gif'          => 'image/gif',
        'png'          => 'image/png',
        'bmp'          => 'image/bmp',
        'tif|tiff'     => 'image/tiff',
        'ico'          => 'image/x-icon'
    );
    $file = wp_check_filetype( $image, $mimes );
    return ( $file['ext'] ? $image : $setting->default );
}

function landingpress_customize_sanitize_color( $color, $setting ) {
	if ( empty( $color ) || is_array( $color ) ) {
		return '';
	}
	if ( false !== strpos( $color, 'rgba' ) ) {
		$color = str_replace( ' ', '', $color );
		sscanf( $color, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );
		return 'rgba('.$red.','.$green.','.$blue.','.$alpha.')';
	}
	else {
		return sanitize_hex_color( $color );
	}
}

function landingpress_customize_sanitize_pages( $page_id, $setting ) {
	$page_id = absint( $page_id );
	return ( 'publish' == get_post_status( $page_id ) ? $page_id : $setting->default );
}

function landingpress_customize_wp_filter_post_kses( $data ) {
	$data = stripslashes( $data );
	if ( function_exists( 'force_balance_tags' ) ) {
		$data = force_balance_tags( $data );		
	}
    return wp_kses( $data, 'post' );
}

function landingpress_customize_sanitize_html( $html ) {
	if ( is_array( $html ) ) {
		return array_map( 'landingpress_customize_wp_filter_post_kses', $$html );
	}
	else {
		return landingpress_customize_wp_filter_post_kses( $html );
	}
}

function landingpress_customize_wp_filter_nohtml_kses( $data ) {
    return wp_kses( stripslashes( $data ), 'strip' );
}

function landingpress_customize_sanitize_nohtml( $nohtml ) {
	if ( is_array( $nohtml ) ) {
		return array_map( 'landingpress_customize_wp_filter_nohtml_kses', $nohtml );
	}
	else {
		return landingpress_customize_wp_filter_nohtml_kses( $nohtml );
	}
}

function landingpress_customize_sanitize_unfiltered( $html ) {
	if ( current_user_can('unfiltered_html') ) {
		return $html;
	}
	else {
		if ( is_array( $html ) ) {
			return array_map( 'landingpress_customize_wp_filter_post_kses', $$html );
		}
		else {
			return landingpress_customize_wp_filter_post_kses( $html );
		}
	}
}

add_action( 'customize_preview_init', 'landingpress_customize_preview_loading_style_init' );
function landingpress_customize_preview_loading_style_init() {
	global $wp_customize;
	remove_action( 'wp_head', array( $wp_customize, 'customize_preview_loading_style' ) );
	add_action( 'wp_head', 'landingpress_customize_preview_loading_style_head', 100 );
	add_action( 'wp_footer', 'landingpress_customize_preview_loading_style_footer' );
}

function landingpress_customize_preview_loading_style_head() {
	echo '<style>';
	echo '/* Spinkit https://github.com/tobiasahlin/SpinKit MIT License */ ';
	echo 'body.wp-customizer-unloading{opacity:1;cursor:progress!important;-webkit-transition:none;transition:none}body.wp-customizer-unloading *{pointer-events:none!important}body.wp-customizer-unloading .landingpress-customize-loading{display:block!important}.landingpress-customize-loading{display:none;position:fixed;z-index:999999;top:0;left:0;width:100%;height:100%;background:#fff;background:rgba(255,255,255,.8)}.spinkit-wave{display:block;position:relative;top:50%;left:50%;width:50px;height:40px;margin:-25px 0 0 -25px;font-size:10px;text-align:center}.spinkit-wave .spinkit-rect{display:block;float:left;width:6px;height:50px;margin:0 2px;background-color:#e91e63;-webkit-animation:spinkit-wave-stretch-delay 1.2s infinite ease-in-out;animation:spinkit-wave-stretch-delay 1.2s infinite ease-in-out}.spinkit-wave .spinkit-rect1{-webkit-animation-delay:-1.2s;animation-delay:-1.2s}.spinkit-wave .spinkit-rect2{-webkit-animation-delay:-1.1s;animation-delay:-1.1s}.spinkit-wave .spinkit-rect3{-webkit-animation-delay:-1s;animation-delay:-1s}.spinkit-wave .spinkit-rect4{-webkit-animation-delay:-.9s;animation-delay:-.9s}.spinkit-wave .spinkit-rect5{-webkit-animation-delay:-.8s;animation-delay:-.8s}@-webkit-keyframes spinkit-wave-stretch-delay{0%,100%,40%{-webkit-transform:scaleY(.5);transform:scaleY(.5)}20%{-webkit-transform:scaleY(1);transform:scaleY(1)}}@keyframes spinkit-wave-stretch-delay{0%,100%,40%{-webkit-transform:scaleY(.5);transform:scaleY(.5)}20%{-webkit-transform:scaleY(1);transform:scaleY(1)}}';
	echo '</style>';
}

function landingpress_customize_preview_loading_style_footer() {
	echo '<div class="landingpress-customize-loading">';
		echo '<div class="spinkit-wave">';
			echo '<div class="spinkit-rect spinkit-rect1"></div>';
			echo '<div class="spinkit-rect spinkit-rect2"></div>';
			echo '<div class="spinkit-rect spinkit-rect3"></div>';
			echo '<div class="spinkit-rect spinkit-rect4"></div>';
			echo '<div class="spinkit-rect spinkit-rect5"></div>';
		echo '</div>';
	echo '</div>';
}

<?php 
/**
 * This function incorporates code from 
 * 
 * 1) Kirki Customizer Framework.
 * 
 * The Kirki Customizer Framework, Copyright Aristeides Stathopoulos (@aristath),
 * is licensed under the terms of the GNU GPL, Version 2 (or later).
 * 
 * @link https://github.com/aristath/kirki
 * 
 * 2) Alpha Color Picker Customizer Control
 * 
 * The Alpha Color Picker Customizer Control, Copyright BraadMartin,
 * is licensed under the terms of the GNU GPL, Version 3 (or later).
 * 
 * @link https://github.com/BraadMartin/components
 * 
 * 3) OceanWP WordPress Theme
 * 
 * The OceanWP WordPress Theme, Copyright OceanWP,
 * is licensed under the terms of the GNU GPL, Version 3 (or later).
 * 
 * @link https://github.com/oceanwp/oceanwp
 * 
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class LandingPress_Customize_Heading_Control extends WP_Customize_Control {
	public $type = 'landingpress-heading';
	protected function content_template() {
		?>
		<# if ( data.label ) { #>
			<span class="customize-control-title">{{{ data.label }}}</span>
		<# } #>
		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>
		<?php
	}
}

class LandingPress_Customize_Warning_Control extends WP_Customize_Control {
	public $type = 'landingpress-warning';
	protected function content_template() {
		?>
		<div class="customize-control-warning">
		<# if ( data.label ) { #>
			<span class="customize-control-title">{{{ data.label }}}</span>
		<# } #>
		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>
		</div>
		<?php
	}
}

class LandingPress_Customize_Number_Control extends WP_Customize_Control {
	public $type = 'landingpress-number';
	public function to_json() {
		parent::to_json();
		$this->json['value']   = $this->value();
		$this->json['choices'] = $this->choices;
		$this->json['link']    = $this->get_link();
		$this->json['id']      = $this->id;
	}
	protected function content_template() {
		?>
		<label>
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{{ data.label }}}</span>
			<# } #>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
		</label>
		<div class="number-input">
			<input type="number" class="control-number-input" id="input_{{ data.id }}" value="{{ data.value }}" {{{ data.link }}} <# if ( data.choices['min'] !== '' ) { #> min="{{ data.choices['min'] }}" <# } #> <# if ( data.choices['max'] !== '' ) { #> max="{{ data.choices['max'] }}" <# } #> <# if ( data.choices['step'] !== '' ) { #> step="{{ data.choices['step'] }}" <# } #> <# if ( data.choices['placeholder'] !== '' ) { #> placeholder="{{ data.choices['placeholder'] }}" <# } #> /> <span class="number-unit"> {{{ data.choices['unit'] }}} </span>
		</div>
		<?php
	}
}

class LandingPress_Customize_Color_Control extends WP_Customize_Control {
	public $type = 'landingpress-color';
	public function to_json() {
		parent::to_json();
		$this->json['default'] = $this->setting->default;
		if ( isset( $this->default ) ) {
			$this->json['default'] = $this->default;
		}
		$this->json['value']   = $this->value();
		$this->json['palette'] = true;
		$this->json['show_opacity'] = true;
		$this->json['link'] = $this->get_link();
		$this->json['id'] = $this->id;
	}
	protected function content_template() {
		?>
		<label>
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{{ data.label }}}</span>
			<# } #>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
		</label>
		<input class="landingpress-color-control" type="text" data-show-opacity="{{ data.show_opacity }}" data-palette="{{ data.palette }}" data-default-color="{{ data.default }}" value="{{ data.value }}" {{{ data.link }}} />
		<?php
	}
}

class LandingPress_Customize_Slider_Control extends WP_Customize_Control {
	public $type = 'landingpress-slider';
	public function to_json() {
		parent::to_json();
		$value = $this->value();
		$this->json['slider_value'] = is_numeric( $value ) ? $value : 0;
		$this->json['value']   = $value;
		$this->json['choices'] = $this->choices;
		$this->json['link']    = $this->get_link();
		$this->json['id']      = $this->id;
	}
	protected function content_template() {
		?>
		<label>
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{{ data.label }}}</span>
			<# } #>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
		</label>
		<div class="slider-wrapper">
			<div class="slider-input">
				<input type="number" min="{{ data.choices['min'] }}" max="{{ data.choices['max'] }}" step="{{ data.choices['step'] }}" class="control-slider-input" id="input_{{ data.id }}" value="{{ data.value }}" {{{ data.link }}} /> 
				<span class="slider-unit"> {{{ data.choices['unit'] }}} </span>
				<span class="slider-reset"> <span class="dashicons dashicons-image-rotate"></span> </span>
			</div>
			<div class="slider-container">
				<div id="slider_{{ data.id }}" class="control-slider" data-value="{{ data.slider_value }}" data-min="{{ data.choices['min'] }}" data-max="{{ data.choices['max'] }}" data-step="{{ data.choices['step'] }}"></div>
			</div>
		</div>
		<?php
	}
}

class LandingPress_Customize_Radio_Buttonset_Control extends WP_Customize_Control {
	public $type = 'landingpress-radio-buttonset';
	public function to_json() {
		parent::to_json();
		$this->json['value']   = $this->value();
		$this->json['choices'] = $this->choices;
		$this->json['link']    = $this->get_link();
		$this->json['id']      = $this->id;
	}
	protected function content_template() {
		?>
		<# if ( ! data.choices ) { return; } #>
		<label>
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{{ data.label }}}</span>
			<# } #>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
		</label>
		<div id="input_{{ data.id }}" class="buttonset control-buttonset">
			<# for ( key in data.choices ) { #>
				<input type="radio" value="{{ key }}" name="_customize-radio-{{ data.id }}" id="{{ data.id }}{{ key }}" {{{ data.link }}} <# if ( data.value === key ) { #>checked<# } #>>
					<label for="{{ data.id }}{{ key }}">
						{{ data.choices[ key ] }}
					</label>
				</input>
			<# } #>
		</div>
		<?php
	}
}

class LandingPress_Customize_Radio_Iconset_Control extends WP_Customize_Control {
	public $type = 'landingpress-radio-iconset';
	public function to_json() {
		parent::to_json();
		$this->json['value']   = $this->value();
		$this->json['choices'] = $this->choices;
		$this->json['link']    = $this->get_link();
		$this->json['id']      = $this->id;
	}
	protected function content_template() {
		?>
		<# if ( ! data.choices ) { return; } #>
		<label>
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{{ data.label }}}</span>
			<# } #>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
		</label>
		<div id="input_{{ data.id }}" class="buttonset control-iconset">
			<# for ( key in data.choices ) { #>
				<input type="radio" value="{{ key }}" name="_customize-radio-{{ data.id }}" id="{{ data.id }}{{ key }}" {{{ data.link }}} <# if ( data.value === key ) { #>checked<# } #>>
					<label for="{{ data.id }}{{ key }}">
						<i class="{{ data.choices[ key ] }}"></i>
					</label>
				</input>
			<# } #>
		</div>
		<?php
	}
}

class LandingPress_Customize_Radio_Image_Control extends WP_Customize_Control {
	public $type = 'landingpress-radio-image';
	public function to_json() {
		parent::to_json();
		$this->json['value']   = $this->value();
		$this->json['choices'] = $this->choices;
		$this->json['link']    = $this->get_link();
		$this->json['id']      = $this->id;
	}
	protected function content_template() {
		?>
		<# if ( ! data.choices ) { return; } #>
		<label>
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{{ data.label }}}</span>
			<# } #>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
		</label>
		<div id="input_{{ data.id }}" class="control-image">
			<# for ( key in data.choices ) { #>
				<input class="image-select" type="radio" value="{{ key }}" name="_customize-radio-{{ data.id }}" id="{{ data.id }}{{ key }}" {{{ data.link }}} <# if ( data.value === key ) { #>checked<# } #>>
					<label for="{{ data.id }}{{ key }}">
						<img src="{{ data.choices[ key ] }}">
					</label>
				</input>
			<# } #>
		</div>
		<?php
	}
}

class LandingPress_Customize_Select2_Control extends WP_Customize_Control {
	public $type = 'landingpress-select2';
	public function to_json() {
		parent::to_json();
		$this->json['value']   = $this->value();
		$this->json['choices'] = $this->choices;
		$this->json['link']    = $this->get_link();
		$this->json['id']      = $this->id;
	}
	protected function content_template() {
		?>
		<# if ( ! data.choices ) { return; } #>
		<label>
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{{ data.label }}}</span>
			<# } #>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
		</label>
		<select {{{ data.link }}} id="select2-{{ data.id }}" class="control-select2">
			<# for ( key in data.choices ) { #>
				<option value="{{ key }}" <# if ( data.value === key ) { #>selected<# } #>>{{ data.choices[ key ] }}</option>
			<# } #>
		</select>
		<?php
	}
}

class LandingPress_Customize_Select2_Multiple_Control extends WP_Customize_Control {
	public $type = 'landingpress-select2-multiple';
	public function to_json() {
		parent::to_json();
		$this->json['value']   = (array) $this->value();
		$this->json['choices'] = $this->choices;
		$this->json['link']    = $this->get_link();
		$this->json['id']      = $this->id;
	}
	protected function content_template() {
		?>
		<# if ( ! data.choices ) { return; } #>
		<label>
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{{ data.label }}}</span>
			<# } #>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
		</label>
		<select {{{ data.link }}} id="select2-{{ data.id }}" class="control-select2" multiple="multiple">
			<# _.each( data.choices, function( label, choice ) { #>
				<option value="{{ choice }}" <# if ( -1 !== data.value.indexOf( choice ) ) { #> selected="selected" <# } #>>{{ label }}</option>
			<# } ) #>
		</select>
		<?php
	}
}

class LandingPress_Customize_GoogleFonts_Control extends WP_Customize_Control {
	public $type = 'landingpress-googlefonts';
	public function to_json() {
		parent::to_json();
		$this->json['value']   = $this->value();
		$this->json['choices'] = $this->choices;
		$this->json['link']    = $this->get_link();
		$this->json['id']      = $this->id;
	}
	protected function content_template() {
		?>
		<# if ( ! data.choices ) { return; } #>
		<label>
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{{ data.label }}}</span>
			<# } #>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
		</label>
		<select {{{ data.link }}} id="select2-{{ data.id }}" class="control-select2">
			<# if ( data.value ) { #>
				<option value="{{ data.value }}" selected>{{ data.value }}</option>
			<# } #>
		</select>
		<?php
	}
}

class LandingPress_Customize_Sortable_Control extends WP_Customize_Control {
	public $type = 'landingpress-sortable';
	public function to_json() {
		parent::to_json();
		$this->json['default'] = $this->setting->default;
		if ( isset( $this->default ) ) {
			$this->json['default'] = $this->default;
		}
		$this->json['value']       = maybe_unserialize( $this->value() );
		$this->json['choices']     = $this->choices;
		$this->json['link']        = $this->get_link();
		$this->json['id']          = $this->id;

		$this->json['inputAttrs'] = '';
		foreach ( $this->input_attrs as $attr => $value ) {
			$this->json['inputAttrs'] .= $attr . '="' . esc_attr( $value ) . '" ';
		}
		$this->json['inputAttrs'] = maybe_serialize( $this->input_attrs() );
	}
	protected function content_template() {
		?>
		<label class='landingpress-sortable'>
			<span class="customize-control-title">
				{{{ data.label }}}
			</span>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
			<ul class="sortable">
				<# _.each( data.value, function( choiceID ) { #>
					<li {{{ data.inputAttrs }}} class='landingpress-sortable-item' data-value='{{ choiceID }}'>
						<i class='dashicons dashicons-menu'></i>
						<i class="dashicons dashicons-visibility visibility"></i>
						{{{ data.choices[ choiceID ] }}}
					</li>
				<# }); #>
				<# _.each( data.choices, function( choiceLabel, choiceID ) { #>
					<# if ( -1 === data.value.indexOf( choiceID ) ) { #>
						<li {{{ data.inputAttrs }}} class='landingpress-sortable-item invisible' data-value='{{ choiceID }}'>
							<i class='dashicons dashicons-menu'></i>
							<i class="dashicons dashicons-visibility visibility"></i>
							{{{ data.choices[ choiceID ] }}}
						</li>
					<# } #>
				<# }); #>
			</ul>
		</label>
		<?php
	}
	protected function render_content() {}
}

<?php
namespace ElementorLandingPress\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Utils;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class LP_Countdown_Simple extends Widget_Base {

	public function get_name() {
		return 'countdown_simple';
	}

	public function get_title() {
		return __( 'LP - Fixed Countdown Timer', 'landingpress-wp' );
	}

	public function get_icon() {
		return 'eicon-countdown';
	}

	public function get_categories() {
		return [ 'landingpress' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_date',
			[
				'label' => __( 'Countdown Due Date', 'landingpress-wp' ),
			]
		);

		$countdown_day = range( 1, 31 );
		$countdown_day = array_combine( $countdown_day, $countdown_day );
		for ($i=1; $i < 10 ; $i++) { 
			$countdown_day[$i] = '0'.$i;
		}

		$this->add_control(
			'day',
			[
				'label' => __( 'Day', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => date( 'j' ),
				'options' => $countdown_day,
			]
		);

		$countdown_month = array(
			'1' => __( 'January', 'landingpress-wp' ),
			'2' => __( 'February', 'landingpress-wp' ),
			'3' => __( 'March', 'landingpress-wp' ),
			'4' => __( 'April', 'landingpress-wp' ),
			'5' => __( 'May', 'landingpress-wp' ),
			'6' => __( 'June', 'landingpress-wp' ),
			'7' => __( 'July', 'landingpress-wp' ),
			'8' => __( 'August', 'landingpress-wp' ),
			'9' => __( 'September', 'landingpress-wp' ),
			'10' => __( 'October', 'landingpress-wp' ),
			'11' => __( 'November', 'landingpress-wp' ),
			'12' => __( 'Desember', 'landingpress-wp' ),
		);

		$default_month = date( 'n' ) < 12 ? date( 'n' ) + 1 : 1;

		$this->add_control(
			'month',
			[
				'label' => __( 'Month', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => $default_month,
				'options' => $countdown_month,
			]
		);

		$default_year = date( 'n' ) < 12 ? date( 'Y' ) : date( 'Y' ) + 1;

		$this->add_control(
			'year',
			[
				'label' => __( 'Year', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'min' => date( 'Y' ),
				'default' => $default_year,
			]
		);

		$countdown_hours = range( 0, 23 );
		$countdown_hours = array_combine( $countdown_hours, $countdown_hours );
		for ($i=0; $i < 10 ; $i++) { 
			$countdown_hours[$i] = '0'.$i;
		}

		$this->add_control(
			'hours',
			[
				'label' => __( 'Hours', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => '9',
				'options' => $countdown_hours,
			]
		);

		$countdown_minutes = range( 0, 59 );
		$countdown_minutes = array_combine( $countdown_minutes, $countdown_minutes );
		for ($i=0; $i < 10 ; $i++) { 
			$countdown_minutes[$i] = '0'.$i;
		}

		$this->add_control(
			'minutes',
			[
				'label' => __( 'Minutes', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => '0',
				'options' => $countdown_minutes,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_label',
			[
				'label' => __( 'Countdown Label', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'label_days',
			[
				'label' => __( 'Days', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => __( 'days', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'label_hours',
			[
				'label' => __( 'Hours', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => __( 'hours', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'label_minutes',
			[
				'label' => __( 'Minutes', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => __( 'minutes', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'label_seconds',
			[
				'label' => __( 'Seconds', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => __( 'seconds', 'landingpress-wp' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_intro',
			[
				'label' => __( 'Countdown Before Text', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'intro',
			[
				'label' => __( 'Countdown Before Text', 'landingpress-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Limited Offer', 'landingpress-wp' ),
				'placeholder' => __( 'Limited Offer', 'landingpress-wp' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_sticky',
			[
				'label' => __( 'Sticky Countdown', 'landingpress-wp' ),
			]
		);

		$this->add_control(
			'floating',
			[
				'label' => __( 'Sticky Countdown', 'landingpress-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'no',
				'options' => [
					'no' => __( 'No', 'landingpress-wp' ),
					'yes' => __( 'Yes', 'landingpress-wp' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_intro_style',
			[
				'label' => __( 'Text', 'landingpress-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'intro_color',
			[
				'label' => __( 'Text Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-countdown-simple' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'intro_typography',
				'label' => __( 'Typography', 'landingpress-wp' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector' => '{{WRAPPER}} .elementor-countdown-simple',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_countdown_style',
			[
				'label' => __( 'Countdown', 'landingpress-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => __( 'Text Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-countdown-simple .count-num' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'background_color',
			[
				'label' => __( 'Background Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-countdown-simple .count-num' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'label' => __( 'Border', 'landingpress-wp' ),
				'placeholder' => '0px',
				'default' => '0px',
				'selector' => '{{WRAPPER}} .elementor-countdown-simple .count-num',
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => __( 'Border Radius', 'landingpress-wp' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-countdown-simple .count-num' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_sticky_style',
			[
				'label' => __( 'Sticky', 'landingpress-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'sticky_background',
			[
				'label' => __( 'Background Color', 'landingpress-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-countdown-floating-yes' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings();

		$this->add_render_attribute( 'wrapper', 'class', 'elementor-countdown-simple' );

		if ( $settings['floating'] ) {
			$this->add_render_attribute( 'wrapper', 'class', 'elementor-countdown-floating-' . $settings['floating'] );
		}

		$is_valid = checkdate($settings['month'], $settings['day'], $settings['year']);
		if ( !$is_valid ) {
			echo '<p style="text-align:center">'.__( 'invalid date', 'landingpress-wp' ).'</p>';
			return;
		}
		$date = sprintf("%04d/%02d/%02d", $settings['year'], $settings['month'], $settings['day']);
		$time = sprintf("%02d:%02d", $settings['hours'], $settings['minutes']);
		$intro = $settings['intro'] ? '<div class="countdown-intro">' . $settings['intro'] . '</div>' : '';

		$label_days = $settings['label_days'] ? $settings['label_days'] : __( 'days', 'landingpress-wp' );
		$label_hours = $settings['label_hours'] ? $settings['label_hours'] : __( 'hours', 'landingpress-wp' );
		$label_minutes = $settings['label_minutes'] ? $settings['label_minutes'] : __( 'minutes', 'landingpress-wp' );
		$label_seconds = $settings['label_seconds'] ? $settings['label_seconds'] : __( 'seconds', 'landingpress-wp' );

		$new_date = new \DateTime( $date . ' ' . $time );
		$datetime = $new_date->format( 'm\/d\/Y h:i A' );

		$selector = 'lp-countdown-fixed-'.$this->get_id();

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<div id="<?php echo $selector; ?>">
				<?php echo $intro; ?>
				<span class="count-container"><span class="count-box"><span class="count-num">00</span> <span class="count-label"><?php echo $label_days; ?></span></span> <span class="count-box"><span class="count-num">00</span> <span class="count-label"><?php echo $label_hours; ?></span></span> <span class="count-box"><span class="count-num">00</span> <span class="count-label"><?php echo $label_minutes; ?></span></span><span class="count-box"> <span class="count-num">00</span> <span class="count-label"><?php echo $label_seconds; ?></span></span></span>
			</div>
		</div>
		<script type="text/javascript">
		!function(a){"use strict";a.extend=function(b,c){if(b=b||{},arguments.length>2)for(var d=1;d<arguments.length;d++)a.extend(b,arguments[d]);else for(var e in c)b[e]=c[e];return b};var b=function(b){this.conf=a.extend({dateStart:new Date,dateEnd:new Date((new Date).getTime()+864e5),selector:".timer",msgBefore:"Be ready!",msgAfter:"It's over, sorry folks!",msgPattern:"{days} days, {hours} hours, {minutes} minutes and {seconds} seconds left.",onStart:null,onEnd:null,leadingZeros:!1,initialize:!0},b),this.started=!1,this.selector=document.querySelectorAll(this.conf.selector),this.interval=1e3,this.patterns=[{pattern:"{years}",secs:31536e3},{pattern:"{months}",secs:2628e3},{pattern:"{weeks}",secs:604800},{pattern:"{days}",secs:86400},{pattern:"{hours}",secs:3600},{pattern:"{minutes}",secs:60},{pattern:"{seconds}",secs:1}],this.initialize!==!1&&this.initialize()};b.prototype.initialize=function(){return this.defineInterval(),this.isOver()?this.outOfInterval():void this.run()},b.prototype.seconds=function(a){return a.getTime()/1e3},b.prototype.isStarted=function(){return this.seconds(new Date)>=this.seconds(this.conf.dateStart)},b.prototype.isOver=function(){return this.seconds(new Date)>=this.seconds(this.conf.dateEnd)},b.prototype.run=function(){var b,c=this,d=Math.abs(this.seconds(this.conf.dateEnd)-this.seconds(new Date));this.isStarted()?this.display(d):this.outOfInterval(),b=a.setInterval(function(){d--,0>=d?(a.clearInterval(b),c.outOfInterval(),c.callback("end")):c.isStarted()&&(c.started||(c.callback("start"),c.started=!0),c.display(d))},this.interval)},b.prototype.display=function(a){for(var b=this.conf.msgPattern,c=0;c<this.patterns.length;c++){var d=this.patterns[c];if(-1!==this.conf.msgPattern.indexOf(d.pattern)){var e=Math.floor(a/d.secs),f=this.conf.leadingZeros&&9>=e?"0"+e:e;a-=e*d.secs,b=b.replace(d.pattern,f)}}for(var g=0;g<this.selector.length;g++)this.selector[g].innerHTML=b},b.prototype.defineInterval=function(){for(var a=this.patterns.length;a>0;a--){var b=this.patterns[a-1];if(-1!==this.conf.msgPattern.indexOf(b.pattern))return void(this.interval=1e3*b.secs)}},b.prototype.outOfInterval=function(){for(var a=new Date<this.conf.dateStart?this.conf.msgBefore:this.conf.msgAfter,b=0;b<this.selector.length;b++)this.selector[b].innerHTML!==a&&(this.selector[b].innerHTML=a)},b.prototype.callback=function(b){var c=b.capitalize();"function"==typeof this.conf["on"+c]&&this.conf["on"+c](),"undefined"!=typeof a.jQuery&&a.jQuery(this.conf.selector).trigger("countdown"+c)},String.prototype.capitalize=function(){return this.charAt(0).toUpperCase()+this.slice(1)},a.Countdown=b}(window); 
		new Countdown({
		selector: '#<?php echo $selector; ?>',
		dateEnd: new Date('<?php echo $datetime; ?>'),
		msgPattern: '<?php echo $intro; ?><span class="count-container"><span class="count-box"><span class="count-num">{days}</span> <span class="count-label"><?php echo $label_days; ?></span></span> <span class="count-box"><span class="count-num">{hours}</span> <span class="count-label"><?php echo $label_hours; ?></span></span> <span class="count-box"><span class="count-num">{minutes}</span> <span class="count-label"><?php echo $label_minutes; ?></span></span><span class="count-box"> <span class="count-num">{seconds}</span> <span class="count-label"><?php echo $label_seconds; ?></span></span></span>',
		msgAfter: "",
		leadingZeros: true,
		});
		</script>
		<?php 
	}

	protected function content_template() {}

}

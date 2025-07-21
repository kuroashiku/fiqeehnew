<?php
/**
 * WooCommerce Ongkir for LandingPress 
 * 
 * This module incorporates codes from:
 * 
 * 1) WooCommerce plugin, Copyright WooCommerce, GPL v3 license.
 * @link https://github.com/woocommerce/woocommerce
 * 
 * 2) MyOngkir plugin, Copyright eezhal, MIT license.
 * @link https://github.com/eezhal92/myongkir
 * 
 * 3) RajaOngkir documentation, Copyright RajaOngkir
 * @link http://rajaongkir.com/
 * 
**/

if ( class_exists('woocommerce') ) {

	if ( ! defined( 'LP_WC_ONGKIR_PATH') )
		define( 'LP_WC_ONGKIR_PATH', plugin_dir_path( __FILE__ ) );

	if ( ! defined( 'LP_WC_ONGKIR_URL' ) )
		define( 'LP_WC_ONGKIR_URL', plugins_url( '', __FILE__ ) );

	if ( ! class_exists( 'LandingPress_WC_Ongkir_Shipping_Method' ) ) {

		add_action( 'woocommerce_shipping_init', 'landingpress_wc_ongkir_shipping_init' );
		function landingpress_wc_ongkir_shipping_init() {

			class LandingPress_WC_Ongkir_Shipping_Method extends WC_Shipping_Method {

				public function __construct() {
					$this->id = 'landingpress_wc_ongkir';
					$this->method_title = esc_html__( 'LandingPress WC Ongkir', 'landingpress-wp' );
					$this->method_description = esc_html__( 'Modul Ongkir khusus untuk LandingPress, menggunakan database ongkir dari RajaOngkir API', 'landingpress-wp' );
					// $this->method_description = esc_html__( 'Modul Ongkir khusus untuk LandingPress, menggunakan database ongkir dari RajaOngkir API', 'landingpress-wp' ).'<br/><br/><span class="description">'.esc_html__( 'Silahkan klik tombol "Save Changes" jika ingin menghapus cache ongkir (data ongkir yang tersimpan).', 'landingpress-wp' ).'</span>';

					$this->init();
				}

				function init() {
					$this->init_settings();
					$this->init_form_fields();

					$this->title = esc_html__( 'LandingPress WC Ongkir', 'landingpress-wp' );

					$this->enabled = !isset($this->settings['enabled'])? false : $this->settings['enabled'] ; 
					$this->api_key = !isset($this->settings['api_key'])? null : $this->settings['api_key'] ;
					$this->api_type = !isset($this->settings['api_type'])? 'starter' : $this->settings['api_type'] ;
					$this->base_city = !isset($this->settings['base_city'])? null : $this->settings['base_city'];
					$this->show_weight = !isset($this->settings['show_weight'])? false : $this->settings['show_weight'] ; 

					add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
					add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'clear_transients' ) );
					if ( $this->enabled == 'yes' ) {
						add_action( 'woocommerce_review_order_before_shipping', array( $this, 'cart_weight_row'));
					}
				}

				public function clear_transients() {
					// delete_transient( 'landingpress_wc_ongkir_caches_jne' );
					// delete_transient( 'landingpress_wc_ongkir_caches_tiki' );
					// delete_transient( 'landingpress_wc_ongkir_caches_pos' );
					// delete_transient( 'landingpress_wc_ongkir_caches_jnt' );
					// delete_transient( 'landingpress_wc_ongkir_caches_wahana' );
					// delete_transient( 'landingpress_wc_ongkir_caches_indah' );
					// delete_transient( 'landingpress_wc_ongkir_caches_sicepat' );
					// delete_transient( 'landingpress_wc_ongkir_caches_ninja' );
					// delete_transient( 'landingpress_wc_ongkir_caches_lion' );
				}

				public function init_form_fields() {

					$this->api_key = !isset($this->settings['api_key'])? null : $this->settings['api_key'] ;
					$this->api_type = !isset($this->settings['api_type'])? 'starter' : $this->settings['api_type'] ;
					$this->base_city = !isset($this->settings['base_city'])? null : $this->settings['base_city'];

					if ( isset($this->settings['services']) ) {
						$this->couriers = array();
						$this->services = !isset($this->settings['services'])? array() : $this->settings['services'];
						if ( !empty( $this->services ) ) {
							foreach ( $this->services as $service ) {
								if ( in_array( $service, array('jne_reg','jne_oke','jne_yes') ) ) {
									if ( !in_array( 'jne', $this->couriers ) ) {
										$this->couriers[] = 'jne';
									}
								}
								elseif ( in_array( $service, array('tiki_reg','tiki_eco','tiki_ons') ) ) {
									if ( !in_array( 'tiki', $this->couriers ) ) {
										$this->couriers[] = 'tiki';
									}
								}
								elseif ( in_array( $service, array('pos_skk','pos_end') ) ) {
									if ( !in_array( 'pos', $this->couriers ) ) {
										$this->couriers[] = 'pos';
									}
								}
								else {
									if ( $this->api_type == 'pro' ) {
										if ( in_array( $service, array('jnt_ez') ) ) {
											if ( !in_array( 'jnt', $this->couriers ) ) {
												$this->couriers[] = 'jnt';
											}
										}
										elseif ( in_array( $service, array('wahana_normal') ) ) {
											if ( !in_array( 'wahana', $this->couriers ) ) {
												$this->couriers[] = 'wahana';
											}
										}
										// elseif ( in_array( $service, array('indah_darat') ) ) {
										// 	if ( !in_array( 'indah', $this->couriers ) ) {
										// 		$this->couriers[] = 'indah';
										// 	}
										// }
										elseif ( in_array( $service, array('sicepat_reg','sicepat_best') ) ) {
											if ( !in_array( 'sicepat', $this->couriers ) ) {
												$this->couriers[] = 'sicepat';
											}
										}
										elseif ( in_array( $service, array('ninja_standard','ninja_nextday') ) ) {
											if ( !in_array( 'ninja', $this->couriers ) ) {
												$this->couriers[] = 'ninja';
											}
										}
										elseif ( in_array( $service, array('lion_reg') ) ) {
											if ( !in_array( 'lion', $this->couriers ) ) {
												$this->couriers[] = 'lion';
											}
										}
										elseif ( in_array( $service, array('sap_reg','sap_ons') ) ) {
											if ( !in_array( 'sap', $this->couriers ) ) {
												$this->couriers[] = 'sap';
											}
										}
									}
								}
							}
						}
						$this->services_default = array();
					}
					/* backward compatibility */
					elseif ( isset($this->settings['couriers']) ) {
						$this->couriers = $this->settings['couriers'];
						$this->services = array();
						if ( !empty( $this->couriers ) ) {
							foreach ( $this->couriers as $courier ) {
								if ( $courier == 'jne' ) {
									$this->services[] = 'jne_reg';
									$this->services[] = 'jne_oke';
									$this->services[] = 'jne_yes';
								}
								elseif ( $courier == 'tiki' ) {
									$this->services[] = 'tiki_reg';
									$this->services[] = 'tiki_eco';
									$this->services[] = 'tiki_ons';
								}
								elseif ( $courier == 'pos' ) {
									$this->services[] = 'pos_skk';
									$this->services[] = 'pos_end';
								}
							}
						}
						$this->services_default = $this->services;
					}
					else {
						$this->couriers = array();
						$this->services = array();
						$this->services_default = $this->services;
					}

					$this->services_code = array();
					if ( !empty( $this->services ) ) {
						foreach ( $this->services as $service ) {
							if ( $service == 'jne_reg' ) {
								$this->services_code['jne'][] = 'CTC';
								$this->services_code['jne'][] = 'REG';
							}
							elseif ( $service == 'jne_oke' ) {
								$this->services_code['jne'][] = 'CTCOKE';
								$this->services_code['jne'][] = 'OKE';
							}
							elseif ( $service == 'jne_yes' ) {
								$this->services_code['jne'][] = 'CTCYES';
								$this->services_code['jne'][] = 'YES';
							}
							elseif ( $service == 'tiki_reg' ) {
								$this->services_code['tiki'][] = 'REG';
							}
							elseif ( $service == 'tiki_eco' ) {
								$this->services_code['tiki'][] = 'ECO';
							}
							elseif ( $service == 'tiki_ons' ) {
								$this->services_code['tiki'][] = 'ONS';
							}
							elseif ( $service == 'pos_skk' ) {
								$this->services_code['pos'][] = 'Paket Kilat Khusus';
							}
							elseif ( $service == 'pos_end' ) {
								$this->services_code['pos'][] = 'Express Sameday Barang';
							}
							else {
								if ( $this->api_type == 'pro' ) {
									if ( $service == 'jnt_ez' ) {
										$this->services_code['jnt'][] = 'EZ';
									}
									elseif ( $service == 'wahana_normal' ) {
										$this->services_code['wahana'][] = 'Normal';
									}
									// elseif ( $service == 'indah_darat' ) {
									// 	$this->services_code['indah'][] = 'Paket Darat';
									// }
									elseif ( $service == 'sicepat_reg' ) {
										$this->services_code['sicepat'][] = 'REG';
									}
									elseif ( $service == 'sicepat_best' ) {
										$this->services_code['sicepat'][] = 'BEST';
									}
									elseif ( $service == 'ninja_standard' ) {
										$this->services_code['ninja'][] = 'STANDARD';
									}
									elseif ( $service == 'ninja_nextday' ) {
										$this->services_code['ninja'][] = 'NEXTDAY';
									}
									elseif ( $service == 'lion_reg' ) {
										$this->services_code['lion'][] = 'REGPACK';
									}
									elseif ( $service == 'sap_reg' ) {
										$this->services_code['sap'][] = 'UDRREG';
									}
									elseif ( $service == 'sap_ons' ) {
										$this->services_code['sap'][] = 'UDRONS';
									}
								}
							}
						}
					}

					$cities = array();
					$province = WC()->countries->get_base_state();
					$province_id = landingpress_wc_ongkir_province_to_id( $province );
					if ( $province_id ) {
						$cities = landingpress_wc_ongkir_get_cities( $province_id );
						if ( !empty($cities) && is_array( $cities ) ) {
							$cities = array( '' => esc_attr__( 'Pilih Kota / Kabupaten...', 'landingpress-wp' ) ) + $cities;
						}
					}

					$services = array(
						    	'jne_reg' => 'JNE - REG / CTC',
						    	'jne_oke' => 'JNE - OKE / CTCOKE',
						    	'jne_yes' => 'JNE - YES / CTCYES',
						    	'tiki_reg'=> 'TIKI - REG',
						    	'tiki_eco'=> 'TIKI - ECO',
						    	'tiki_ons'=> 'TIKI - ONS',
						    	'pos_skk' => 'POS - Paket Kilat Khusus',
						    	'pos_end' => 'POS - Express Next Day Barang',
						    );

					$services_pro = array(
						    	'jnt_ez' => 'J&T - EZ',
						    	'wahana_normal' => 'WAHANA - Normal',
						    	// 'indah_darat' => 'INDAH - Paket Darat',
						    	'sicepat_reg' => 'SICEPAT - REG',
						    	'sicepat_best' => 'SICEPAT - BEST',
						    	'ninja_standard' => 'NINJA - STANDARD',
						    	'ninja_nextday' => 'NINJA - NEXTDAY',
						    	'lion_reg' => 'LION - REGPACK',
						    	'sap_reg' => 'SAP - REG',
						    	'sap_ons' => 'SAP - ODS',
						    );

					if ( $this->api_type == 'pro' ) {
						$services = array_merge( $services, $services_pro );
					}

				    $this->form_fields = array(
				    	'enabled' => array(
						    'title'   => esc_html__( 'Enable/Disable', 'landingpress-wp' ),
						    'type'    => 'checkbox',
						    'default' => '',
						    'label'   => esc_html__( 'Aktifkan LandingPress WC Ongkir', 'landingpress-wp' ),
						),
				    	'api_key' => array(
						    'title'   => esc_html__( 'RajaOngkir API Key', 'landingpress-wp' ),
						    'type'    => 'text',
						    'default' => '',
						    'description'   => landingpress_wc_ongkir_test_connect( $this->api_key, $this->api_type ).'<br/><br/>'.esc_html__( 'Jika Anda belum mempunyai RajaOngkir API Key,', 'landingpress-wp' ).' <br/><a href="'. esc_url('http://rajaongkir.com/akun/daftar') .'">'.esc_html__( 'klik di sini untuk mendaftar', 'landingpress-wp' ).'</a>',
						),
						'api_type' => array(
					        'title'       => esc_html__( 'RajaOngkir API Type', 'landingpress-wp' ),
					        'type'        => 'select',
					        'class'       => 'chosen_select',
					        'description' => esc_html__( 'Pilih tipe RajaOngkir API sesuai dengan yang Anda miliki.', 'landingpress-wp' ).'<br/><strong>starter:</strong> '.esc_html__( 'GRATIS, hanya bisa cek ongkir hingga level kabupaten', 'landingpress-wp' ).'<br/><strong>pro:</strong> '.esc_html__( 'BERBAYAR, sudah bisa cek ongkir hingga level kecamatan.', 'landingpress-wp' ).'<br/>'.esc_html__( 'Harganya sekitar Rp 500.000,- sekali bayar dan bisa digunakan di banyak website.', 'landingpress-wp' ),
					        'options'     => array(
						    	'starter' => 'starter',
						    	'pro'=> 'pro',
						    )
					    ),
						'base_city' => array(
					        'title'       => esc_html__( 'Base City', 'landingpress-wp' ),
					        'type'        => 'select',
					        'class'       => 'chosen_select',
					        'description' => esc_html__( 'Pilih kota asal pengiriman.', 'landingpress-wp' ),
					        'options'     => $cities
					    	),
						'services' => array(
						    'title'       => esc_html__( 'Services', 'landingpress-wp' ),
						    'type'        => 'multiselect',
						    'default'     => $this->services_default,
						    'description' => esc_html__( 'Pilih jasa ekspedisi yang diinginkan.', 'landingpress-wp' ),
							'class'       => 'wc-enhanced-select',
						    'options' => $services,
						),
				    	'show_weight' => array(
						    'title'   => esc_html__( 'Weight Total', 'landingpress-wp' ),
						    'type'    => 'checkbox',
						    'default' => '',
						    'label'   => esc_html__( 'Tampilan berat total di halaman checkout', 'landingpress-wp' ),
						),
				    );
				}	

				public function calculate_shipping( $package = array() ) {
					// $this->add_rate( array( 'id' => $this->id.':debug', 'label' => "debug wc ongkir", 'cost' => 1, 'calc_tax' => 'per_item' ) );
					if ( $this->enabled == 'yes' ) {
						$from = $this->base_city;
						$destination_city = WC()->customer->get_shipping_city();
						$to = '';
						if ( $destination_city ) {
							preg_match_all( '/\d+/', $destination_city, $matches );
							if ( isset( $matches[0] ) && !empty( $matches[0] ) ) {
								$to = end( $matches[0] );
							}
						}
						// $this->add_rate( array( 'id' => $this->id . ':debug_city', 'label' => "from $from to $to", 'cost' => 1, 'package' => $package ) );
						$couriers = $this->couriers;
						if ( $from && $to && !empty( $couriers ) ) {
							$weight = $this->get_cart_weight(true); // in gram		
							foreach ( $couriers as $courier ) {
								$costs = landingpress_wc_ongkir_get_costs( $this->api_key, $this->api_type, $from, $to, $courier, $weight );
								// $weight_multiplier = $weight >= 200 ? $weight - 199 : $weight;
								// $weight_multiplier = $weight_multiplier / 1000;
								// $weight_multiplier = ceil ( $weight_multiplier );
								// $this->add_rate( array( 'id' => $this->id . ':debug_'.$courier, 'label' => json_encode($costs), 'cost' => 1, 'calc_tax' => 'per_item' ) );
								if ( !empty( $costs ) && is_array( $costs ) ) {
									foreach ( $costs as $service ) {
										if ( isset( $this->services_code[$courier] ) && !empty( $this->services_code[$courier] ) ) {
											foreach ( $service['cost'] as $cost ) {
												if ( in_array( $service['service'], $this->services_code[$courier] ) ) {
													$etd = '';
													if ( $cost['etd'] ) {
														$etd = strtolower( $cost['etd'] );
														if ( strpos( $etd, 'jam') === false && strpos( $etd, 'hari') === false ) {
															$etd .= ' hari';
														}
														$etd = ' ('.$etd.')';
													}
													$rate_id = str_replace( ' ', '_', strtolower($service['service']) );
													if ( $cost['value'] > 0 ) {
														$this->add_rate(
															array(
																'id' => $this->id . ":" . $courier . "_" . $rate_id ,
																'label' => strtoupper( $courier ) . " - " . $service['service'].$etd,
																'cost' => $cost['value'],
																// 'cost' => $cost['value'] * $weight_multiplier,
																'package' => $package,
															)
														);
													}
												}
											}
										}
									}
								}
							}
						}
					}
				}

				public function cart_weight_row() {	
					if ( $this->show_weight == 'yes' ) {
						echo '<tr class="order-total">';
						echo   '<th>Berat Total</th>';
						echo     '<td><strong><span class="amount">';  
						echo		$this->get_cart_weight() . ' ' . get_option( 'woocommerce_weight_unit' );  
						echo     '</span></strong></td>';
						echo '</tr>';			
					}
				}

				private function get_cart_weight( $to_gram = false ) {
					$weight = WC()->cart->cart_contents_weight;
					if ( $to_gram ) {
						$weight_unit = get_option('woocommerce_weight_unit');			
						$weight = $this->get_cart_weight_to_gram($weight, $weight_unit);
						if ( !$weight ) {
							$weight = 1000;
						}
					}
					return $weight;
				}

			    private function get_cart_weight_to_gram( $number, $type ) {
			        $weight_units = array(
			            'kg'  => 1000,
			            'g'   => 1,
			            'lbs' => 453.592,
			            'oz'  => 28.3495,
			        );
			        if (array_key_exists($type, $weight_units)) {
			            $result = $number * $weight_units[$type];
			            return $result;
			        }
			        return false;
			    }

			}
		}

		add_filter( 'woocommerce_shipping_methods', 'landingpress_wc_ongkir_shipping_methods' );
		function landingpress_wc_ongkir_shipping_methods( $methods ) {
			$methods['landingpress_wc_ongkir'] = 'LandingPress_WC_Ongkir_Shipping_Method';
			return $methods;
		}

		add_action( 'init', 'landingpress_wc_ongkir_init' );
		function landingpress_wc_ongkir_init() {
			global $landingpress_wc_ongkir_settings;
			$landingpress_wc_ongkir_settings = get_option('woocommerce_landingpress_wc_ongkir_settings');

			if ( landingpress_wc_ongkir_get_seting('enabled') != 'yes' ) {
				return;
			}

			if ( WC()->countries->get_base_country() != 'ID' ) {
				add_action( 'admin_notices', 'landingpress_wc_ongkir_admin_notice_base_country' );
				return;
			}

			if ( get_woocommerce_currency() != 'IDR' ) {
				add_action( 'admin_notices', 'landingpress_wc_ongkir_admin_notice_base_currency' );
				return;
			}

			if ( ! landingpress_wc_ongkir_get_seting('api_key') ) {
				return;
			}

			if ( ! landingpress_wc_ongkir_get_seting('base_city') ) {
				return;
			}

			define("LANDINGPRESS_WC_ONGKIR_NONCE", "landingpress-wc-ongkir-nonce");
			if ( !is_admin() ) {
				add_filter('pre_option_woocommerce_allowed_countries', 'landingpress_wc_ongkir_woocommerce_allowed_countries' ); 
				add_filter('pre_option_woocommerce_specific_allowed_countries', 'landingpress_wc_ongkir_woocommerce_specific_allowed_countries' ); 
			}
			add_filter( 'default_checkout_billing_country', 'landingpress_wc_ongkir_default_checkout_country' );
			add_filter( 'default_checkout_billing_state', 'landingpress_wc_ongkir_default_checkout_state' );
			add_filter( 'woocommerce_get_country_locale', 'landingpress_wc_ongkir_country_locale' );
			add_filter( 'woocommerce_default_address_fields' , 'landingpress_wc_ongkir_default_address_fields' );
			add_filter( 'woocommerce_checkout_fields', 'landingpress_wc_ongkir_checkout_fields' );
			add_action( 'woocommerce_checkout_order_review', 'landingpress_wc_ongkir_enqueue_js' );
			add_action( 'wp_ajax_ongkir_get_cities', 'landingpress_wc_ongkir_ajax_get_cities' );
			add_action( 'wp_ajax_nopriv_ongkir_get_cities', 'landingpress_wc_ongkir_ajax_get_cities' );
			add_action( 'wp_ajax_ongkir_get_subdistricts', 'landingpress_wc_ongkir_ajax_get_subdistricts' );
			add_action( 'wp_ajax_nopriv_ongkir_get_subdistricts', 'landingpress_wc_ongkir_ajax_get_subdistricts' );

			add_filter('pre_option_woocommerce_enable_shipping_calc', 'landingpress_wc_enable_shipping_calc' ); 
			add_filter('pre_option_woocommerce_shipping_cost_requires_address', 'landingpress_wc_shipping_cost_requires_address' ); 
			// add_filter('woocommerce_cart_no_shipping_available_html', 'landingpress_wc_cart_no_shipping_available_html' ); 
			// add_filter('woocommerce_no_shipping_available_html', 'landingpress_wc_no_shipping_available_html' ); 
		}

		function landingpress_wc_enable_shipping_calc( $option ) {
			return 'no';
		}

		function landingpress_wc_shipping_cost_requires_address( $option ) {
			return 'yes';
		}

		function landingpress_wc_cart_no_shipping_available_html() {
			return esc_html__('Proceed to checkout to calculate shipping...', 'landingpress-wp');
		}

		function landingpress_wc_no_shipping_available_html() {
			return esc_html__('No shipping available. Please check your address...', 'landingpress-wp');
		}

		function landingpress_wc_ongkir_woocommerce_allowed_countries( $options ) {
			return 'specific';
		}

		function landingpress_wc_ongkir_woocommerce_specific_allowed_countries( $options ) {
			return array('ID');
		}

		function landingpress_wc_ongkir_admin_notice_base_country() {
			$message = esc_html__( 'LandingPress WC Ongkir needs Indonesia (ID) for WooCommerce base country location.', 'landingpress-wp' ).' <a href="'.admin_url('admin.php?page=wc-settings&tab=general').'">Setup Now!</a>';
			$html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
			echo wp_kses_post( $html_message );
		}

		function landingpress_wc_ongkir_admin_notice_base_currency() {
			$message = esc_html__( 'LandingPress WC Ongkir needs Rupiah (IDR) for WooCommerce currency.', 'landingpress-wp' ).' <a href="'.admin_url('admin.php?page=wc-settings&tab=general').'">Setup Now!</a>';
			$html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
			echo wp_kses_post( $html_message );
		}

		function landingpress_wc_ongkir_get_seting( $setting ) {
			global $landingpress_wc_ongkir_settings;
			$value = isset($landingpress_wc_ongkir_settings[$setting]) ? $landingpress_wc_ongkir_settings[$setting] : null;
			return $value;
		}

		function landingpress_wc_ongkir_default_checkout_country( $country ) {
			return 'ID';
		}

		function landingpress_wc_ongkir_default_checkout_state( $state ) {
			$state = WC()->countries->get_base_state();
			if ( !$state ) {
				$state = 'JK';
			}
			return $state;
		}

		function landingpress_wc_ongkir_country_locale( $locale ) {
			$locale['ID']['postcode_before_city'] = true;
			return $locale;
		}

		function landingpress_wc_ongkir_default_address_fields( $address_fields ) {
			unset( $address_fields['company'] );
			$address_fields['last_name']['required'] = false;
			$address_fields['city']['required'] = false;
			$address_fields['postcode']['required'] = false;
			return $address_fields;
		}

		function landingpress_wc_ongkir_checkout_fields( $fields ) {
			// var_dump($fields);
			$allowed_fields = array( 'billing', 'shipping' );
			foreach ( $fields as $type => $field ) {
				if ( in_array( $type, $allowed_fields ) ) {
					$fields[$type][$type.'_state']['class'] = array( 'form-row-wide', 'address-field', 'update_totals_on_change' );
					$fields[$type][$type.'_postcode']['class'] = array('form-row-wide');

					$state_field = $fields[$type][$type.'_state'];
					unset( $fields[$type][$type.'_state'] );

					$city_field = $fields[$type][$type.'_city'];
					unset( $fields[$type][$type.'_city'] );

					$postcode_field = $fields[$type][$type.'_postcode'];
					unset( $fields[$type][$type.'_postcode'] );

					$address_1_field = $fields[$type][$type.'_address_1'];
					unset( $fields[$type][$type.'_address_1'] );

					$address_2_field = $fields[$type][$type.'_address_2'];
					unset( $fields[$type][$type.'_address_2'] );

					$offset_country = array_search( $type.'_country', array_keys( $fields[$type] ) );
					$offset_after_country  = $offset_country + 1;

					$fields_before_country = array_slice( $fields[$type], 0, $offset_after_country, true );
					$fields_after_country = array_slice( $fields[$type], $offset_after_country, null, true );

					$fields[$type] = $fields_before_country;
					$fields[$type] = $fields[$type] + array( $type.'_state' => $state_field ); 
					$fields[$type] = $fields[$type] + array( $type.'_city_ongkir' => landingpress_wc_ongkir_city_field( $type ) );
					if ( landingpress_wc_ongkir_get_seting('api_type') == 'pro' ) {
						$fields[$type] = $fields[$type] + array( $type.'_subdistrict_ongkir' => landingpress_wc_ongkir_subdistrict_field( $type ) );
					}
					$fields[$type] = $fields[$type] + array( $type.'_address_1' => $address_1_field );
					$fields[$type] = $fields[$type] + array( $type.'_address_2' => $address_2_field );
					$fields[$type] = $fields[$type] + array( $type.'_city' => $city_field );
					$fields[$type] = $fields[$type] + array( $type.'_postcode' => $postcode_field );
					$fields[$type] = $fields[$type] + $fields_after_country;
				}
			}		
			return $fields;
		}

		function landingpress_wc_ongkir_enqueue_js( $hook ) {
			?>
			<style type="text/css">
			#billing_state_field, #billing_postcode_field, #billing_city_field,
			#shipping_state_field, #shipping_postcode_field, #shipping_city_field {
				float: none !important;
				width: 100%;
			}
			.woocommerce-billing-fields #billing_city_field,
			.woocommerce-shipping-fields #shipping_city_field {
				display: none !important;
			}
			<?php 
			$countries = WC()->countries->get_allowed_countries();
			if ( 1 == count( $countries ) && isset($countries['ID']) ) {
				echo '#billing_country_field, #shipping_country_field { display: none; }';
			}
			?>
			</style>
			<?php 
			$api_type = landingpress_wc_ongkir_get_seting('api_type');
			if ( !$api_type ) {
				$api_type = 'starter';
			}
			$user_billing_state = null;
			$user_shipping_state = null;
			$user_billing_city_ongkir = null;
			$user_shipping_city_ongkir = null;
			if ( is_user_logged_in() ) {
				global $current_user;
				$user_id = $current_user->data->ID;
				$user_billing_state = get_user_meta( $user_id, 'billing_state', true );
				$user_shipping_state = get_user_meta( $user_id, 'shipping_state', true );
				$user_billing_city_ongkir = get_user_meta( $user_id, 'billing_city_ongkir', true );
				$user_shipping_city_ongkir = get_user_meta( $user_id, 'shipping_city_ongkir', true );
			}
			$settings = array(
				'ajax_url'  				=> admin_url( 'admin-ajax.php' ),
				'nonce' 					=> wp_create_nonce( constant('LANDINGPRESS_WC_ONGKIR_NONCE') ),
				'api_type'					=> $api_type,
				'base_state'				=> WC()->countries->get_base_state(),
				'placeholder_city'			=> esc_attr__( 'Pilih Kota / Kabupaten...', 'landingpress-wp' ),
				'user_billing_state'		=> $user_billing_state,
				'user_shipping_state'		=> $user_shipping_state,
				'user_billing_city_ongkir'	=> $user_billing_city_ongkir,
				'user_shipping_city_ongkir'	=> $user_shipping_city_ongkir,
			);
			if ( $api_type == 'pro' ) {
				$user_billing_subdistrict_ongkir = null;
				$user_shipping_subdistrict_ongkir = null;
				if ( is_user_logged_in() ) {
					global $current_user;
					$user_id = $current_user->data->ID;
					$user_billing_subdistrict_ongkir = get_user_meta( $user_id, 'billing_subdistrict_ongkir', true );
					$user_shipping_subdistrict_ongkir = get_user_meta( $user_id, 'shipping_subdistrict_ongkir', true );
				}
				$settings_pro = array(
					'placeholder_subdistrict'			=> esc_attr__( 'Pilih Kecamatan...', 'landingpress-wp' ),
					'user_billing_subdistrict_ongkir'	=> $user_billing_subdistrict_ongkir,
					'user_shipping_subdistrict_ongkir'	=> $user_shipping_subdistrict_ongkir,
				);
				$settings = $settings + $settings_pro;
			}
			wp_enqueue_script( 'landingpress-wc-ongkir-script', trailingslashit( LP_WC_ONGKIR_URL ).'landingpress-wc-ongkir.min.js', array('jquery'), LANDINGPRESS_THEME_VERSION, true );
			wp_localize_script( 'landingpress-wc-ongkir-script', 'landingpress_wc_ongkir_ajax', $settings );
		}

		function landingpress_wc_ongkir_ajax_get_cities() {
			$nonce = $_GET['nonce'];
			if ( !wp_verify_nonce( $nonce, constant('LANDINGPRESS_WC_ONGKIR_NONCE' ) ) ) die( $nonce );
			$api_key = landingpress_wc_ongkir_get_seting('api_key');
			if ( !$api_key ) {
				die();
			} 
			else {
				$province = $_GET['province'];
				if ( $province ) {
					$province_id = landingpress_wc_ongkir_province_to_id( $province );
					if ( $province_id) {
						$cities = landingpress_wc_ongkir_get_cities( $province_id );
						echo json_encode( $cities );
					}
				}
				die();
			}
		}

		function landingpress_wc_ongkir_ajax_get_subdistricts() {
			$nonce = $_GET['nonce'];
			if ( !wp_verify_nonce( $nonce, constant('LANDINGPRESS_WC_ONGKIR_NONCE' ) ) ) die( $nonce );
			$api_key = landingpress_wc_ongkir_get_seting('api_key');
			if ( !$api_key ) {
				die();
			} 
			else {
				$province = $_GET['province'];
				if ( $province ) {
					$province_id = landingpress_wc_ongkir_province_to_id( $province );
					if ( $province_id) {
						$city_id = $_GET['city_id'];
						if ( $city_id ) {
							$subdistricts = landingpress_wc_ongkir_get_subdistricts( $province_id, $city_id );
							echo json_encode( $subdistricts );
						}
					}
				}
				die();
			}
		}

		function landingpress_wc_ongkir_city_field( $type ) {
			$options = array( '' => esc_attr__( 'Pilih Kota / Kabupaten...', 'landingpress-wp' ) );
			$field = array(
				'type' 			=> 'select',
				'label' 		=> esc_attr__( 'Kota / Kabupaten', 'landingpress-wp' ),
				'placeholder' 	=> esc_attr__( 'Pilih Kota / Kabupaten...', 'landingpress-wp' ),
				'required' 		=> true,
				'class' 		=> array( 'form-row-wide', 'address-field', 'update_totals_on_change' ),
				'clear' 		=> true,
				'options'		=> $options
			);
			return $field;
		}

		function landingpress_wc_ongkir_subdistrict_field( $type ) {
			$options = array( '' => esc_attr__( 'Pilih Kecamatan...', 'landingpress-wp' ) );
			$field = array(
				'type' 			=> 'select',
				'label' 		=> esc_attr__( 'Kecamatan', 'landingpress-wp' ),
				'placeholder' 	=> esc_attr__( 'Pilih Kecamatan...', 'landingpress-wp' ),
				'required' 		=> true,
				'class' 		=> array( 'form-row-wide', 'address-field', 'update_totals_on_change' ),
				'clear' 		=> true,
				'options'		=> $options
			);
			return $field;
		}

		function landingpress_wc_ongkir_get_cities( $province_id ) {
			$cities_file = LP_WC_ONGKIR_PATH.'/city/'.$province_id.'.json';
			if ( file_exists( $cities_file ) ) {
				$response = file_get_contents( $cities_file );
				$cities = json_decode( $response, true );
				if ( !empty( $cities ) ) {
					return $cities;
				}
			}
			return false;
		}

		function landingpress_wc_ongkir_get_subdistricts( $province_id, $city_id ) {
			$subdistricts_file = LP_WC_ONGKIR_PATH.'/subdistrict/'.$province_id.'.json';
			if ( file_exists( $subdistricts_file ) ) {
				$response = file_get_contents( $subdistricts_file );
				$subdistricts = json_decode( $response, true );
				if ( isset( $subdistricts[$city_id] ) && !empty( $subdistricts[$city_id] ) ) {
					return $subdistricts[$city_id];
				}
			}
			return false;
		}

		function landingpress_wc_ongkir_get_costs( $api_key, $api_type, $from, $to, $courier = 'jne', $weight = 1000 ) {
			if ( !$api_key )
				return false;
			// $to = 22;
			if ( !$to ) {
			   return false;
			}

			// $weight = 1000;

			// $cache = get_transient( 'landingpress_wc_ongkir_caches_' . $courier );
			// if ( isset( $cache[$from][$to] ) ) {
			// 	return $cache[$from][$to];
			// }

			$api_url = $api_type == 'pro' ? 'http://pro.rajaongkir.com/api/cost' : 'http://api.rajaongkir.com/starter/cost';
			$dest_type = $api_type == 'pro' ? 'subdistrict' : 'city';

			$response = wp_remote_post( $api_url, array(
				'body' => array(
					'key'             => $api_key,
					'origin'          => $from,
					'originType'      => 'city',
					'destination'     => $to,
					'destinationType' => $dest_type,
					'weight'          => $weight,
		      		'courier'         => $courier
				)
			) );
			if ( is_wp_error( $response ) ) {
			   $error_message = $response->get_error_message();
			} 
			else {
				if ( 200 == $response['response']['code'] ) {
					$output = json_decode( $response['body'], true );
					if ( isset( $output['rajaongkir']['results']['costs'] ) ) {
						// $cache[$from][$to] = $output['rajaongkir']['results']['costs'];
						// set_transient( 'landingpress_wc_ongkir_caches_' . $courier, $cache, YEAR_IN_SECONDS );
						return $output['rajaongkir']['results']['costs'];
					}
					elseif ( isset( $output['rajaongkir']['results'][0]['costs'] ) ) {
						// $cache[$from][$to] = $output['rajaongkir']['results'][0]['costs'];
						// set_transient( 'landingpress_wc_ongkir_caches_' . $courier, $cache, YEAR_IN_SECONDS );
						return $output['rajaongkir']['results'][0]['costs'];
					}
					else {
						// $cache[$from][$to] = '';
						// set_transient( 'landingpress_wc_ongkir_caches_' . $courier, $cache, YEAR_IN_SECONDS );
					}
				}
			}
			return false;
		}

		function landingpress_wc_ongkir_test_connect( $api_key, $api_type ) {
			if ( !$api_key )
				return false;

			$result = '';
			$courier = 'tiki';
			$from = 22;
			$to = 22;
			$weight = 1000;

			$api_url = $api_type == 'pro' ? 'http://pro.rajaongkir.com/api/cost' : 'http://api.rajaongkir.com/starter/cost';
			$dest_type = $api_type == 'pro' ? 'subdistrict' : 'city';

			$response = wp_remote_post( $api_url, array(
				'body' => array(
					'key'             => $api_key,
					'origin'          => $from,
					'originType'      => 'city',
					'destination'     => $to,
					'destinationType' => 'city',
					'weight'          => $weight,
		      		'courier'         => $courier
				)
			) );
			$error_message = '';
			$connected = false;
			if ( is_wp_error( $response ) ) {
				$error_message = $response->get_error_message();
			} 
			else {
				$output = json_decode( $response['body'], true );
				$status = 0;
				if ( isset( $output['rajaongkir']['status']['code'] ) ) {
					$status = $output['rajaongkir']['status']['code'];
					if ( $status == '200' ) {
						$connected = true;
					}
					else {
						if ( isset( $output['rajaongkir']['status']['description'] ) ) {
							$error_message = $output['rajaongkir']['status']['description'];
						}
					}
				}
			}
			if ( $connected ) {
				$result = 'status: <span style="color:green;font-weight:bold;">connected</span>';
			}
			else {
				$result = 'status: <span style="color:red;font-weight:bold;">not connected</span><br/>pesan error: <strong>'.$error_message.'</strong>';
				if ( strpos( $error_message, 'cURL' ) !== false ) {
					$result .= '<br/>error cURL berarti server hosting Anda tidak bisa terhubung dengan server RajaOngkir.';
					$result .= '<br/>ada dua kemungkinan:';
					$result .= '<br/>1) koneksi cURL bermasalah di server hosting, silahkan hubungi support hosting Anda untuk menyelesaikan masalah ini, atau';
					$result .= '<br/>2) server hosting Anda di-block oleh server RajaOngkir, silahkan hubungi support RajaOngkir untuk memastikan hal tersebut.';
				}
			}
			return $result;
		}

		function landingpress_wc_ongkir_province_to_id( $province ) {
			$provinces = array(
				'AC' => 21,
				'SU' => 34,
				'SB' => 32,
				'RI' => 26,
				'KR' => 17,
				'JA' => 8,
				'SS' => 33,
				'BB' => 2,
				'BE' => 4,
				'LA' => 18,
				'JK' => 6,
				'JB' => 9,
				'BT' => 3,
				'JT' => 10,
				'JI' => 11,
				'YO' => 5,
				'BA' => 1,
				'NB' => 22,
				'NT' => 23,
				'KB' => 12,
				'KT' => 14,
				'KI' => 15,
				'KS' => 13,
				'KU' => 16,
				'SA' => 31,
				'ST' => 29,
				'SG' => 30,
				'SR' => 27,
				'SN' => 28,
				'GO' => 7,
				'MA' => 19,
				'MU' => 20,
				'PA' => 24,
				'PB' => 25
			);
			if ( array_key_exists( $province, $provinces ) ) {
				return $provinces[$province];
			}
			else {
				return false;
			}
		}
	}
}

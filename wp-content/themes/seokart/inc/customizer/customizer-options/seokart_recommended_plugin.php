<?php
/* Notifications in customizer */


require SEOKART_PARENT_INC_DIR . '/customizer/customizer-notify/seokart-notify.php';
$seokart_config_customizer = array(
	'recommended_plugins'       => array(
		'burger-companion' => array(
			'recommended' => true,
			'description' => sprintf(__('Install and activate <strong>Burger Companion</strong> plugin for taking full advantage of all the features this theme has to offer SeoKart.', 'seokart')),
		),
	),
	'recommended_actions'       => array(),
	'recommended_actions_title' => esc_html__( 'Recommended Actions', 'seokart' ),
	'recommended_plugins_title' => esc_html__( 'Recommended Plugin', 'seokart' ),
	'install_button_label'      => esc_html__( 'Install and Activate', 'seokart' ),
	'activate_button_label'     => esc_html__( 'Activate', 'seokart' ),
	'seokart_deactivate_button_label'   => esc_html__( 'Deactivate', 'seokart' ),
);
Seokart_Customizer_Notify::init( apply_filters( 'seokart_customizer_notify_array', $seokart_config_customizer ) );

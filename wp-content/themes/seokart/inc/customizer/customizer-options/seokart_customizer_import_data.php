<?php
class seokart_import_dummy_data {

	private static $instance;

	public static function init( ) {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof seokart_import_dummy_data ) ) {
			self::$instance = new seokart_import_dummy_data;
			self::$instance->seokart_setup_actions();
		}

	}

	/**
	 * Setup the class props based on the config array.
	 */
	

	/**
	 * Setup the actions used for this class.
	 */
	public function seokart_setup_actions() {

		// Enqueue scripts
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'seokart_import_customize_scripts' ), 0 );

	}
	
	

	public function seokart_import_customize_scripts() {

	wp_enqueue_script( 'seokart-import-customizer-js', SEOKART_PARENT_INC_URI . '/customizer/customizer-notify/js/seokart-import-customizer-options.js', array( 'customize-controls' ) );
	}
}

$seokart_import_customizers = array(

		'import_data' => array(
			'recommended' => true,
			
		),
);
seokart_import_dummy_data::init( apply_filters( 'seokart_import_customizer', $seokart_import_customizers ) );
<?php

/* ADMIN MENU CREATION AND RELATED FUNCTIONS FOR EASY USE */
####################################################################

/**
 *  Generate needed settings & options for Content Generator plugin
 *  @since  1.0.0
 */

class Cntrst_Generate_Plugin_Settings {

	function __construct() {
		//Actions
		add_action( 'plugins_loaded', array( &$this, 'after_loaded' ) ); //Load textdomain
		add_action( 'admin_menu', array( &$this, 'cntrst_child_register_generator_menu' ) ); //Hook up the menu
	}

	/**
	 *  After plugin load, right now only loads textdomain/translations
	 *  @since  1.0.0
	 */

	public function after_loaded() {
		load_plugin_textdomain( 'content-generator', false, dirname( plugin_basename( __FILE__ ) ) . '/../i18n/languages' );
	}

	/**
	 *  Register new menu under tools
	 *  @since  1.0.0
	 */

	public function cntrst_child_register_generator_menu() { //Register menu
	    add_submenu_page(
	        'tools.php',
	        __( 'Generate content', 'content-generator' ),
	        __( 'Generate content', 'content-generator' ),
	        'manage_options',
	        'content-generator',
	        array( &$this, 'cntrst_child_create_generator_menu' ) );
	}

	/**
	 *  Generate the previously generated menu
	 *  Simple form with get actions, creates new generator object
	 *  @since  1.0.0
	 */

	public function cntrst_child_create_generator_menu() { //Create the menu ?>
		<div class="wrap"><div id="icon-tools" class="icon32"></div>
			<h2><?php echo __( 'Generate content', 'content-generator' ) ?></h2>

			<form action="" method="get">
			<input type="hidden" name="page" value="content-generator">
			<input type="hidden" name="generate-content" value="true">
			<p><?php echo __( 'Content type', 'content-generator' ) ?></p>
			<select name="type">
				<option value="post"><?php echo __( 'Post', 'content-generator' ) ?></option>
				<option value="page"><?php echo __( 'Page', 'content-generator' ) ?></option>
				<?php $this->cntrst_child_list_cpts(); ?>
			</select>
			<p><?php echo __( 'Amount of content to be generated (number)', 'content-generator' ) ?></p>
			<input type="text" name="amount" placeholder="<?php echo __( 'Amount of content', 'content-generator' ) ?>">
			<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php echo __( 'Generate content', 'content-generator' ) ?>"></p>
			</form>
		</div>

	    <?php //Handle get request, run generator object

	    if( isset( $_GET['generate-content'] ) ) {
	    	if ( ctype_digit( $_GET['amount'] ) ) { //check that amount is a number ?>
	    		<div class='notice notice-success'>
					<p><?php echo __( 'Content generator ran succesfully', 'content-generator' ) ?></p>
				</div>
				<?php
				$generator = new Cntrst_Generate();
				$generator->content( $_GET['type'], $_GET['amount'] );
	    	} else { ?>
	    		<div class='notice notice-success'>
					<p><?php echo __( 'Invalid amount input, insert a number instead', 'content-generator' ) ?></p>
				</div> <?php
	    	}

		}
	} //End cntrst_child_create_generator_menu()

	/**
	 *  Retrieve custom post types for form select
	 *  @since  1.0.0
	 */

	public function cntrst_child_list_cpts() {

		$args = array(
	       'public'   => true,
	       '_builtin' => false,
	    );

	    $post_types = get_post_types( $args, 'names', 'and' );

	    foreach ( $post_types  as $post_type ) {
	    	echo '<option value="'.$post_type.'">'. ucfirst( $post_type ) .'</option>';
	    }
	}


} //End Cntrst_Generate_Plugin_Settings

$cntrst_generate_plugin_settings = new Cntrst_Generate_Plugin_Settings(); //Start it all




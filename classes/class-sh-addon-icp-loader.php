<?php
/**
 * Init
 *
 * @since 1.0.0
 * @package ShortcodeHub
 */

if ( ! class_exists( 'Sh_Addon_ICP_Loader' ) ) :

	/**
	 * Init
	 *
	 * @since 1.0.0
	 */
	class Sh_Addon_ICP_Loader {

		/**
		 * Instance
		 *
		 * @access private
		 * @var object Class Instance.
		 * @since 1.0.0
		 */
		private static $instance;

		/**
		 * Initiator
		 *
		 * @since 1.0.0
		 * @return object initialized object of class.
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self;
			}
			return self::$instance;
		}

		/**
		 * Constructor
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			add_action( 'plugins_loaded', array( $this, 'check_plugin' ) );
		}

		function check_plugin() {

			if( ! class_exists( 'Sh_Loader' ) ) {
				add_action( 'admin_notices', array( $this, 'show_plugin_notice' ) );
				return;
			}

			add_filter( 'sh_shortcode_types', array( $this, 'add_shortcode_group' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'backend_scripts' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'frontend_scripts' ) );
			add_action( 'sh_metabox_image-color-palette', array( $this, 'add_metabox' ), 10, 2 );
			add_action( 'sh_save_shortcode_image-color-palette', array( $this, 'save_metabox' ), 10, 2 );
			add_action( 'sh_shortcode_markup_image-color-palette', array( $this, 'markup' ) );
		}

		/**
		 * Plugin Notice
		 * 
		 * @return mixed Return null if not plugins screen.
		 */
		function show_plugin_notice() {
			if( 'plugins' !== get_current_screen()->id ) {
				return;
			}
			?>
			<div class="notice notice-warning">
				<?php printf( '<p>One step ahead! To use the plugin "Image Color Palette" you need to install "ShortcodeHub". <a href="%s">Click here</a> and install the ShortcodeHub.</p>', admin_url( 'plugin-install.php?s=shortcodehub&tab=search&type=term' ) ); ?>
			</div>
			<?php
		}

		/**
		 * Shortcode Markup
		 * 
		 * @param  int $post_id Post ID.
		 * @return void
		 */
		function markup( $post_id ) {
			$image_url = $this->get_image_url( $post_id );

			wp_enqueue_script( 'sh-addon-icp-frontend' );
			wp_enqueue_style( 'sh-addon-icp-frontend' );
			?>

			<div class="sh-addon-icp">
				<img class="sh-image-palette-image" src="<?php echo esc_url( $image_url ); ?>" />

				<div class="sh-image-palettes">
					<div class="sh-image-palette sh-addon-icp-primary-color">
						<div class="title"><?php esc_html_e( 'Primary Color', 'shortcodehub' ); ?></div>
						<div class="colors"></div>
					</div>

					<div class="sh-image-palette sh-addon-icp-three-colors">
						<div class="title"><?php esc_html_e( 'Three Colors', 'shortcodehub' ); ?></div>
						<div class="colors"></div>
					</div>

					<div class="sh-image-palette sh-addon-icp-five-colors">
						<div class="title"><?php esc_html_e( 'Five Colors', 'shortcodehub' ); ?></div>
						<div class="colors"></div>
					</div>

					<div class="sh-image-palette sh-addon-icp-palettes-all">
						<div class="title"><?php esc_html_e( 'All Colors', 'shortcodehub' ); ?></div>
						<div class="colors"></div>
					</div>
				</div>
			</div>
			<?php
		}

		/**
		 * Save Metabox
		 * 
		 * @param  string $shortcode_group Shortcode Group.
		 * @param  int $post_id         Post id
		 * @return void
		 */
		function save_metabox( $shortcode_group, $post_id ) {
			$image_id = isset( $_POST['sh-image-color-palette-id'] ) ? absint( $_POST['sh-image-color-palette-id'] ) : 0;
			update_post_meta( $post_id, 'sh-image-color-palette-id', $image_id );
		}

		/**
		 * Get Image ID
		 * 
		 * @param  int $post_id         Post id
		 * @return mixed Image ID or null.
		 */
		function get_image_id( $post_id ) {
			return get_post_meta( $post_id, 'sh-image-color-palette-id', true );
		}

		/**
		 * Get Image URL
		 * 
		 * @param  int $post_id         Post id
		 * @return mixed Image URL of null.
		 */
		function get_image_url( $post_id ) {

			$image_id = $this->get_image_id( $post_id );
			if( empty( $image_id ) ) {
				return '';
			}

			$image_data = wp_get_attachment_image_src( $image_id, 'large' );
			if( is_array($image_data) && ! empty( $image_data ) ) {
				$image_url = $image_data[0];
			}
			return $image_url;
		}

		/**
		 * Add Meta Box
		 * 
		 * @param  string $shortcode_group Shortcode Group
		 * @param  object $post         Post Object
		 * @return void
		 */
		function add_metabox( $shortcode_group, $post ) {

			wp_enqueue_media();

			wp_enqueue_script( 'sh-addon-icp-backend' );

			$image_id = $this->get_image_id( $post->ID );
			$image_url = $this->get_image_url( $post->ID );

			$button_text = __( 'Add Image', 'shortcodehub' );
			if( ! empty( $image_url ) ) {
				$button_text = __( 'Change Image', 'shortcodehub' );
			}
			?>
			<table class="widefat sh-table">
				<tr class="sh-row">
					<td class="sh-heading"><?php esc_html_e( 'Select Image', 'shortcodehub' ); ?></td>
					<td class="sh-content">
						<div class="sh-image-wrap">
							<div class="sh-show-image">
								<img style="max-width: 200px" src="<?php echo esc_url( $image_url ); ?>" />
								<input type="hidden" name="sh-image-color-palette-id" class="sh-image-color-palette-id" value="<?php echo esc_url( $image_id ); ?>" />
							</div>
							<div style="margin-top: 5px;" class="sh-add-image button"><?php echo esc_html( $button_text ); ?></div>
						</div>
					</td>
				</tr>
			</table>
			<?php
		}

		/**
		 * Add Shortcode Group
		 * 
		 * @param  array $groups Shortcode Group
		 * @return array Shortcodes
		 */
		function add_shortcode_group( $groups ) {

			if( ! isset( $groups['image'] ) ) {
				$groups['image'] = array(
					'label' => __( 'Image Shortcodes', 'shortcodehub' ),
		            'types' => array()
	            );
			}

			$groups['image']['types'] = array(
	            'image-color-palette' => array(
					'title'       => __( 'Image Color Palette', 'shortcodehub' ),
					'description' => __( 'Grabs the dominant or representative color palette from an image.', 'shortcodehub' ),
					'video-link'  => '',
	            )
			);

			return $groups;
		}

		/**
		 * Enqueue Frontend Assets.
		 *
		 * @version 1.0.0
		 *
		 * @return void
		 */
		function frontend_scripts() {
			wp_register_script( 'color-thief', SH_ADDON_ICP_URI . 'assets/js/color-thief.min.js', NULL, SH_ADDON_ICP_VER, true );
			wp_register_script( 'sh-addon-icp-frontend', SH_ADDON_ICP_URI . 'assets/js/frontend.js', array( 'jquery', 'color-thief' ), SH_ADDON_ICP_VER, true );
			wp_register_style( 'sh-addon-icp-frontend', SH_ADDON_ICP_URI . 'assets/css/frontend.css', NULL, SH_ADDON_ICP_VER, 'all' );
		}

		/**
		 * Enqueue Backend Assets.
		 *
		 * @version 1.0.0
		 *
		 * @return void
		 */
		function backend_scripts( $hook ) {
			// vl( $hook );
			// wp_die();
			wp_register_script( 'sh-addon-icp-backend', SH_ADDON_ICP_URI . 'assets/js/backend.js', array( 'jquery' ), SH_ADDON_ICP_VER, true );
		}
	}

	/**
	 * Kicking this off by calling 'get_instance()' method
	 */
	Sh_Addon_ICP_Loader::get_instance();

endif;

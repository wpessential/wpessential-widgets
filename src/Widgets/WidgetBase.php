<?php

namespace WPEssential\Library\Widgets;

if ( ! \defined( 'ABSPATH' ) )
{
	exit; // Exit if accessed directly.
}

use WP_Widget;
use WPEssential\Library\Widgets\Implement\WidgetInit;

abstract class WidgetBase extends WP_Widget
{
	protected $fields        = [];
	private   $admin_enqueue = false;

	public static function make ( ...$args )
	{
		new static( ...$args );
	}

	public function admin_enqueue ()
	{
		global $pagenow;
		if ( 'widgets.php' !== $pagenow ) return;

		$assets_dir_uri = get_template_directory_uri() . '/vendor/wpessential/wpessential-widgets/src/assets';
		wp_enqueue_script( 'wpe-widget-script', $assets_dir_uri . '/js/wpe-widget-script', [ 'jquery' ], time(), true );
		wp_enqueue_style( 'wpe-widget-style', $assets_dir_uri . '/css/wpe-widget-style' );
	}

	public function __construct ( $desc = '' )
	{
		if ( true === $this->admin_enqueue )
		{
			add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue' ] );
		}

		if ( ! ( $this instanceof WidgetInit ) )
		{
			wp_die( sprintf( esc_html__( 'WordPress widget %s has not interface.', 'TEXT_DOMAIN' ), $this->get_name() ) );
		}

		parent::__construct( WPE_SETTINGS . '_' . $this->set_id(), $this->set_name(), [ 'description' => $desc ] );
	}

	/**
	 * Set widget Title.
	 * Retrieve widget title.
	 *
	 * @return string Widget title.
	 * @access private
	 */
	private function set_title ()
	{
		return sprintf( esc_html__( '%s', 'TEXT_DOMAIN' ), preg_replace( '/(?<!\ )[A-Z]/', ' $0', $this->set_id() ) );
	}

	/**
	 * Set widget name.
	 * Retrieve widget name.
	 *
	 * @return string Widget name.
	 * @access private
	 */
	private function set_id ()
	{
		return substr( strrchr( get_class( $this ), "\\" ), 1 );
	}

	/**
	 * Set widget classes.
	 * Retrieve widget classes.
	 *
	 * @return array Widget classes.
	 * @access protected
	 * @public
	 */
	protected function set_classes ()
	{
		return [];
	}

	/**
	 * Set widget script dependency
	 *
	 * @return array Widget classes.
	 * @access      protected
	 *
	 */
	protected function set_script_depends ()
	{
		return [];
	}

	/**
	 * Set widget style dependency
	 *
	 * @return array Widget classes.
	 * @access      protected
	 *
	 */
	protected function set_style_depends ()
	{
		return [];
	}

	/**
	 * Set HTML wrapper class.
	 * Retrieve the widget container class. Can be used to override the
	 * container class for specific widgets.
	 *
	 * @return string
	 * @access private
	 */
	private function set_html_wrapper_class ()
	{
		$classes = implode( ' ', $this->set_classes() );
		return "wpe-widget wpe-widget-{$this->set_id()} wpe-widget-{$this->set_id()} {$classes}";
	}

	protected function fields ()
	{
		return [];
	}

	public function widget ( $args, $instance )
	{
		if ( ! empty( $this->set_script_depends() ) )
		{
			wp_enqueue_script( $this->set_script_depends() );
		}

		if ( ! empty( $this->set_style_depends() ) )
		{
			wp_enqueue_style( $this->set_script_depends() );
		}

		echo "<div class='{$this->set_html_wrapper_class()}' id='{$this->set_id()}'>";
		include get_template_part( "/templates/widgets/{$this->set_id()}", '', compact( 'args', 'instance' ) );
		echo '</div>';
	}

	public function form ( $instance )
	{
		include get_template_directory() . "/config/widgets/{$this->set_id()}.php";
	}

	public function update ( $new_options, $existing_options )
	{
		if ( empty( $this->fields ) ) return;

		foreach ( $this->fields as $_field )
		{
			$existing_options[ $_field ] = $new_options[ $_field ] ?? '';
		}

		return $existing_options;
	}
}

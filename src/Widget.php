<?php

namespace WPEssential\Library;

if ( ! \defined( 'ABSPATH' ) && ! \defined( 'WPE_WIDGETS' ) )
{
	exit; // Exit if accessed directly.
}

final class Widget
{
	private $add_widgets    = [];
	private $remove_widgets = [];

	public static function make ()
	{
		return new static();
	}

	public function __construct () {}

	public function enqueue ()
	{
		$assets_dir_uri = get_template_directory_uri() . '/vendor/wpessential/wpessential-widgets/src/assets';
		wp_enqueue_script( 'wpe-widget-script', $assets_dir_uri . '/js/wpe-widget-script', '', '', true );
		wp_enqueue_style( 'wpe-widget-style', $assets_dir_uri . '/css/wpe-widget-style' );
	}

	public function add ( $class_name = '' )
	{
		$this->add_widgets = array_push( $this->add_widgets, $class_name );
		return $this;
	}

	public function adds ( $classes_names = [ '' ] )
	{
		$this->add_widgets = array_merge( $this->add_widgets, $classes_names );
		return $this;
	}

	public function remove ( $class_name = '' )
	{
		$this->remove_widgets = array_push( $this->remove_widgets, $class_name );
		return $this;
	}

	public function removes ( $classes_names = [ '' ] )
	{
		$this->remove_widgets = array_merge( $this->remove_widgets, $classes_names );
		return $this;
	}

	public function init ()
	{
		add_action( 'widgets_init', [ $this, 'register' ] );
		add_action( 'widgets_init', [ $this, 'unregister' ], 100 );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue', 1000 ] );
	}

	private function unregister ()
	{
		$widgets = apply_filters( 'wpe/library/widgets_remove', $this->remove_widgets );
		if ( ! empty( $widgets ) )
		{
			$un_reg_wid = 'unre' . 'gister' . '_wi' . 'dget';
			foreach ( $widgets as $widet )
			{
				$un_reg_wid( $widet );
			}
		}
	}

	private function register ()
	{
		$widgets = apply_filters( 'wpe/library/widgets_add', $this->add_widgets );
		if ( ! empty( $widgets ) )
		{
			$reg_wid = 'regi' . 'ster' . '_wid' . 'get';
			sort( $widgets );
			foreach ( $widgets as $widet )
			{
				if ( class_exists( $widet ) )
				{
					$reg_wid( $widet );
				}
			}
		}
	}
}

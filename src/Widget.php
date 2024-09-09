<?php

namespace WPEssential\Library;

if ( ! \defined( 'ABSPATH' ) && ! \defined( 'WPE_REG_WIDGETS' ) )
{
	exit; // Exit if accessed directly.
}

final class Widget
{
	private $add_widgets    = [];
	private $remove_widgets = [];

	public static function make ()
	{
		return new self();
	}

	public function __construct ()
	{
		add_action( 'widgets_init', [ __CLASS__, 'init' ] );
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
		$this->unregister();
		$this->register();
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

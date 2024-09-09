<?php

namespace WPEssential\Library\Widgets\Implement;

if ( ! \defined( 'ABSPATH' ) )
{
	exit; // Exit if accessed directly.
}

interface WidgetInit
{
	public function view ( $args, $instance );

	public function options ( $instance );
}

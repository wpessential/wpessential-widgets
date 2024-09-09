<?php

namespace WPEssential\Library\Widgets\Fields;

if ( ! \defined( 'ABSPATH' ) )
{
	exit; // Exit if accessed directly.
}

class Textarea extends Text
{
	private $rows = 8;
	private $cols;

	public function rows ( $rows = 8 )
	{
		$this->rows = $rows;

		return $this;
	}

	public function cols ( $cols = 50 )
	{
		$this->cols = $cols;

		return $this;
	}

	protected function attributes ()
	{
		$this->attributes = array_filter( array_merge( $this->attributes, [
			'rows' => $this->rows,
			'cols' => $this->cols,
		] ) );

		if ( isset( $this->attributes[ 'default' ] ) )
		{
			unset( $this->attributes[ 'default' ] );
		}

		return $this;
	}

	protected function field ()
	{
		$default = esc_textarea( $this->default );
		echo "<textarea {$this->attributes}>{$default}</textarea>";
	}
}

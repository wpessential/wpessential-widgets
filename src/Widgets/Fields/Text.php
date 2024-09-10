<?php

namespace WPEssential\Library\Widgets\Fields;

if ( ! \defined( 'ABSPATH' ) )
{
	exit; // Exit if accessed directly.
}

class Text
{
	protected $key         = '';
	protected $title       = '';
	protected $subtitle    = '';
	protected $desc        = '';
	protected $type        = 'text';
	protected $placeholder = '';
	protected $default     = '';
	protected $require     = false;
	protected $attributes  = [];

	public static function make ( ...$args )
	{
		return new static( ...$args );
	}

	public function __construct ( $name = '', $id = '' )
	{
		$this->title = sprintf( esc_html__( '%s', 'TEXT_DOMAIN' ), $name );
		if ( ! $id )
		{
			$id = str_replace( ' ', '_', strtolower( $name ) );
		}

		if ( $id )
		{
			$this->key = WPE_SETTINGS . '_' . $id;
		}
	}

	public function type ( $type = '' )
	{
		$this->type = $type;

		return $this;
	}

	public function subtitle ( $subtitle = '' )
	{
		$this->subtitle = $subtitle;

		return $this;
	}

	public function desc ( $desc = '' )
	{
		$this->desc = $desc;

		return $this;
	}

	public function placeholder ( $placeholder = '' )
	{
		$this->placeholder = $placeholder;

		return $this;
	}

	public function default ( $default = '' )
	{
		$this->default = $default;

		return $this;
	}

	public function require ( $require = '' )
	{
		$this->require = $require;

		return $this;
	}

	protected function scripts_dependency ()
	{
		return [];
	}

	protected function styles_dependency ()
	{
		return [];
	}

	protected function attributes ()
	{
		$this->attributes = array_filter( array_merge( $this->attributes, [
			'class'       => "{$this->key} widefat",
			'id'          => $this->key,
			'name'        => $this->key,
			'placeholder' => $this->placeholder,
			'type'        => $this->type,
			'value'       => $this->default,
			'required'    => $this->require
		] ) );
		return $this;
	}

	public function render ()
	{
		if ( ! empty( $this->scripts_dependency() ) )
		{
			wp_enqueue_script( $this->scripts_dependency() );
		}

		if ( ! empty( $this->styles_dependency() ) )
		{
			wp_enqueue_style( $this->styles_dependency() );
		}

		$this->build_attributes();

		echo '<div class="wpe-widget-field">';
		echo '<p>';
		$this->label();
		$this->field();
		$this->description();
		echo '</p>';
		echo '</div>';
	}

	private function build_attributes ()
	{
		if ( empty( $this->attributes ) ) return false;

		$attributePairs = [];
		foreach ( $this->attributes as $key => $val )
		{
			if ( is_int( $key ) )
				$attributePairs[] = $val;
			else
			{
				$val              = htmlspecialchars( $val, ENT_QUOTES );
				$attributePairs[] = "{$key}=\"{$val}\"";
			}
		}

		$this->attributes = implode( ' ', $attributePairs );

		return $this;
	}

	protected function field ()
	{
		echo "<input {$this->attributes} />";
	}

	protected function label ()
	{
		?>
		<label for="<?php echo esc_attr( $this->key ); ?>">
			<strong><?php echo esc_html( $this->title ); ?>:</strong>
			<?php
			if ( isset( $this->required ) )
			{
				echo "<sup class='alert alert-error'>*</sup>";
			}
			$this->subdescription()
			?>
		</label>
		<?php
	}

	private function description ()
	{
		if ( $this->desc )
		{
			?>
			<i class="widget-description"><?php echo esc_html( $this->desc ); ?></i>
			<?php
		}
	}

	private function subdescription ()
	{
		if ( $this->subtitle )
		{
			?>
			<i class="widget-subdescription"><?php echo esc_html( $this->subtitle ); ?></i>
			<?php
		}
	}

}

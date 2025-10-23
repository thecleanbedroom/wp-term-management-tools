<?php

namespace CNMD\TMT;

use function \esc_attr;
use function \esc_html_e;
use function \wp_dropdown_categories;
use function \__;
use function \get_taxonomies;
use function \esc_html;
use function \esc_html__;

/**
 * Class HTML
 *
 * Handles the creation and display of required HTML. The elements inserted ad re-positioned by javascript.
 *
 * @package CNMD\TMT
 */
class HTML extends Base {


	/**
	 * Create and insert the HTML required by each valid action. They are put into the footer of the page and
	 * moved to the correct spot via JS.
	 */
	public function insert() {
		global $taxonomy;
		foreach ( array_keys( $this->get_actions( $taxonomy ) ) as $key ) {
			if ( ! method_exists( $this, $key ) ) {
				// @codeCoverageIgnoreStart
				continue;
				// @codeCoverageIgnoreEnd
			}
			/*
			 * I realize this is less elegant than using something like
			 * $this->{$key}( $taxonomy )
			 * but it is also a lot clearer, and clearer > clever every time IMHO.
			 */
			echo '<div id="tmt-input-' . \esc_attr( $key ) . '" style="display:none">';
			switch ( $key ) {
				case 'merge_to_new':
					$success = $this->merge_to_new( $taxonomy );
					break;
				case 'merge_into_existing':
					$success = $this->merge_into_existing( $taxonomy );
					break;
				case 'set_parent':
					$success = $this->set_parent( $taxonomy );
					break;
				case 'change_tax':
					$success = $this->change_tax( $taxonomy );
					break;
			}
			echo '</div>';
		}
	}


	/**
	 * Create and echo the HTML for the "Merge" required extra info.
	 *
	 * @param string $taxonomy
	 */
	private function merge_to_new( string $taxonomy ) {
		\esc_html_e( 'New term name:', 'term-management-tools' );
		echo "\t\t";
		echo '<input name="bulk_to_tag" type="text" size="20">';
	}

		private function merge_into_existing( string $taxonomy ) {
            \esc_html_e( 'Select existing category to merge into:', 'term-management-tools' );
            \wp_dropdown_categories(
                array(
                    'echo'             => true,
                    'hide_empty'       => 0,
                    'hide_if_empty'    => false,
                    'name'             => 'merge_into_existing_target',
                    'orderby'          => 'name',
                    'taxonomy'         => $taxonomy,
                    'hierarchical'     => true,
                    'show_option_none' => \__( 'Select a category', 'term-management-tools' ),
                )
            );
        }


	/**
	 * Create and echo the HTML for the "Set Parent" required extra info.
	 *
	 * @param string $taxonomy
	 *
	 * @codeCoverageIgnore  This contains only a WP core function, which we don't need to test.
	 */
	private function set_parent( string $taxonomy ) {
		\wp_dropdown_categories(
			array(
				'echo'             => true,
				'hide_empty'       => 0,
				'hide_if_empty'    => false,
				'name'             => 'parent',
				'orderby'          => 'name',
				'taxonomy'         => $taxonomy,
				'hierarchical'     => true,
				'show_option_none' => __( 'None', 'term-management-tools' ),
			)
		);
	}


	/**
	 * Create and echo the HTML for the "Change Parent" required extra info. This is a list of valid taxonomies,
	 * excluding the current one.
	 *
	 * @param string $taxonomy
	 */
	private function change_tax( string $taxonomy ) {
		$tax_list = \get_taxonomies(
			array(
				'show_ui' => true,
				'public'  => true,
			),
			'objects'
		);
		?>
		<select class="postform" name="new_tax">
			<?php
			foreach ( $tax_list as $new_tax => $tax_obj ) {
				if ( $new_tax === $taxonomy ) {
					continue;
				}
				echo '<option value="' . \esc_attr( $new_tax ) . '">' . \esc_html( $tax_obj->label ) . '</option>';
			}
			?>
		</select>
		<?php
	}

}


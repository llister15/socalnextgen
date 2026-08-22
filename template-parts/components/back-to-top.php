<?php
/**
 * Displays the global back-to-top control.
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

?>
<button class="scng-back-to-top" type="button" aria-label="<?php esc_attr_e( 'Back to top', 'socalnextgen' ); ?>" aria-hidden="true" tabindex="-1" hidden>
	<?php get_template_part( 'template-parts/components/icon', null, array( 'name' => 'arrow-up', 'class' => 'h-5 w-5' ) ); ?>
</button>

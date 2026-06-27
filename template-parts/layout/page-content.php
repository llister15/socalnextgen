<?php
/**
 * Displays editable page content with a fallback message.
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

$fallback = $args['fallback'] ?? '';

?>
<section class="scng-section bg-white">
	<div class="scng-container">
		<div class="mx-auto w-full max-w-site text-center text-brand-navy">
			<?php
			if ( have_posts() ) {
				while ( have_posts() ) {
					the_post();

					if ( trim( get_the_content() ) ) {
						the_content();
					} elseif ( $fallback ) {
						echo '<p>' . esc_html( $fallback ) . '</p>';
					}
				}
			}
			?>
		</div>
	</div>
</section>

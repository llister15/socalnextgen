<?php
/**
 * NextGen Locator archive.
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

$directory = new \WP_Query(
	array(
		'post_type'      => 'youth-group',
		'posts_per_page' => -1,
		'post_status'    => 'publish',
		'orderby'        => 'title',
		'order'          => 'ASC',
	)
);
$search    = isset( $_GET['locator_search'] ) ? sanitize_text_field( wp_unslash( $_GET['locator_search'] ) ) : '';
$state     = isset( $_GET['locator_state'] ) ? sanitize_text_field( wp_unslash( $_GET['locator_state'] ) ) : '';
$city      = isset( $_GET['locator_city'] ) ? sanitize_text_field( wp_unslash( $_GET['locator_city'] ) ) : '';
$records   = array();
$states    = array();
$cities    = array();

foreach ( $directory->posts as $group ) {
	$group_state = (string) get_post_meta( $group->ID, 'scng_youth_group_state', true );
	$group_city  = (string) get_post_meta( $group->ID, 'scng_youth_group_city', true );
	$haystack    = implode(
		' ',
		array(
			$group->post_title,
			get_post_meta( $group->ID, 'scng_youth_group_pastors', true ),
			get_post_meta( $group->ID, 'scng_youth_group_address', true ),
			$group_city,
			$group_state,
			get_post_meta( $group->ID, 'scng_youth_group_zip', true ),
		)
	);

	if ( $group_state ) {
		$states[ $group_state ] = $group_state;
	}
	if ( $group_city ) {
		$cities[ $group_city ] = $group_city;
	}

	if (
		( $search && false === stripos( $haystack, $search ) ) ||
		( $state && $state !== $group_state ) ||
		( $city && $city !== $group_city )
	) {
		continue;
	}

	$records[ $group_state ?: __( 'Other', 'socalnextgen' ) ][ $group_city ?: __( 'Details Coming Soon', 'socalnextgen' ) ][] = $group;
}

ksort( $states );
ksort( $cities );
ksort( $records );

foreach ( $records as &$state_cities ) {
	foreach ( $state_cities as &$groups ) {
		usort(
			$groups,
			static function ( \WP_Post $first, \WP_Post $second ): int {
				return strnatcasecmp( $first->post_title, $second->post_title );
			}
		);
	}
	unset( $groups );
}
unset( $state_cities );

get_header();
?>
<main id="primary" class="site-main">
	<?php
	get_template_part(
		'template-parts/layout/page-hero',
		null,
		array(
			'eyebrow' => __( 'NextGen Locator', 'socalnextgen' ),
			'title'   => __( 'Find the Nearest NextGen Youth Ministry Near You', 'socalnextgen' ),
			'intro'   => __( 'Search the directory by ministry, pastor, state, or city.', 'socalnextgen' ),
		)
	);
	?>

	<section class="scng-section bg-slate-50">
		<div class="scng-container">
			<form class="mb-10 grid gap-4 rounded-lg border border-brand-line bg-white p-5 shadow-card md:grid-cols-[2fr_1fr_1fr_auto]" action="<?php echo esc_url( get_post_type_archive_link( 'youth-group' ) ); ?>" method="get">
				<div>
					<label class="mb-1 block font-display text-sm font-bold uppercase text-brand-navy" for="locator-search"><?php esc_html_e( 'Search ministries', 'socalnextgen' ); ?></label>
					<input class="w-full rounded-md border border-brand-line px-4 py-3" id="locator-search" name="locator_search" type="search" value="<?php echo esc_attr( $search ); ?>">
				</div>
				<div>
					<label class="mb-1 block font-display text-sm font-bold uppercase text-brand-navy" for="locator-state"><?php esc_html_e( 'State', 'socalnextgen' ); ?></label>
					<select class="w-full rounded-md border border-brand-line px-4 py-3" id="locator-state" name="locator_state">
						<option value=""><?php esc_html_e( 'All states', 'socalnextgen' ); ?></option>
						<?php foreach ( $states as $option ) : ?>
							<option value="<?php echo esc_attr( $option ); ?>" <?php selected( $state, $option ); ?>><?php echo esc_html( $option ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div>
					<label class="mb-1 block font-display text-sm font-bold uppercase text-brand-navy" for="locator-city"><?php esc_html_e( 'City', 'socalnextgen' ); ?></label>
					<select class="w-full rounded-md border border-brand-line px-4 py-3" id="locator-city" name="locator_city">
						<option value=""><?php esc_html_e( 'All cities', 'socalnextgen' ); ?></option>
						<?php foreach ( $cities as $option ) : ?>
							<option value="<?php echo esc_attr( $option ); ?>" <?php selected( $city, $option ); ?>><?php echo esc_html( $option ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="flex items-end gap-2">
					<button class="scng-button scng-button-primary min-h-[46px]" type="submit"><?php esc_html_e( 'Find Groups', 'socalnextgen' ); ?></button>
					<?php if ( $search || $state || $city ) : ?>
						<a class="scng-link-cta min-h-[46px] items-center" href="<?php echo esc_url( get_post_type_archive_link( 'youth-group' ) ); ?>"><?php esc_html_e( 'Clear', 'socalnextgen' ); ?></a>
					<?php endif; ?>
				</div>
			</form>

			<?php if ( $records ) : ?>
				<?php foreach ( $records as $state_name => $state_cities ) : ?>
					<section class="mb-12" aria-labelledby="locator-state-<?php echo esc_attr( sanitize_title( $state_name ) ); ?>">
						<h2 class="mb-6 border-b-2 border-brand-orange pb-2 text-3xl" id="locator-state-<?php echo esc_attr( sanitize_title( $state_name ) ); ?>"><?php echo esc_html( $state_name ); ?></h2>
						<?php foreach ( $state_cities as $city_name => $groups ) : ?>
							<h3 class="mb-4 mt-8 text-xl text-brand-navy"><?php echo esc_html( $city_name ); ?></h3>
							<div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
								<?php
								foreach ( $groups as $group ) {
									get_template_part( 'template-parts/cards/youth-group-card', null, array( 'post_id' => $group->ID ) );
								}
								?>
							</div>
						<?php endforeach; ?>
					</section>
				<?php endforeach; ?>
			<?php else : ?>
				<div class="rounded-lg border border-brand-line bg-white p-8 text-center">
					<h2 class="text-2xl"><?php esc_html_e( 'No youth groups matched your search.', 'socalnextgen' ); ?></h2>
					<p class="mt-3"><?php esc_html_e( 'Try a broader ministry name, state, or city.', 'socalnextgen' ); ?></p>
				</div>
			<?php endif; ?>
		</div>
	</section>
</main>
<?php
wp_reset_postdata();
get_footer();

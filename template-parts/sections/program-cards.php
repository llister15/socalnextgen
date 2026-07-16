<?php
/**
 * Homepage program preview cards.
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

$programs = array(
	array(
		'icon'        => 'users',
		'title'       => __( 'Leadership Hub', 'socalnextgen' ),
		'description' => __( 'Resources, training, and encouragement for youth leaders and churches.', 'socalnextgen' ),
		'url'         => home_url( '/leadership-hub/' ),
		'label'       => __( 'Explore Resources', 'socalnextgen' ),
		'tone'        => 'navy',
	),
	array(
		'icon'        => 'palette',
		'title'       => __( 'Fine Arts', 'socalnextgen' ),
		'description' => __( 'Discover and develop your God-given talents through art, drama, music, dance, and more.', 'socalnextgen' ),
		'url'         => home_url( '/fine-arts/' ),
		'label'       => __( 'Learn About Fine Arts', 'socalnextgen' ),
		'tone'        => 'purple',
	),
	array(
		'icon'        => 'cap',
		'title'       => __( 'Scholarship Program', 'socalnextgen' ),
		'description' => __( 'Supporting graduating high school seniors as they pursue their God-given purpose.', 'socalnextgen' ),
		'url'         => home_url( '/scholarships/' ),
		'label'       => __( 'Learn More', 'socalnextgen' ),
		'tone'        => 'green',
	),
);

?>
<section class="bg-white py-8">
	<div class="scng-container grid gap-5 lg:grid-cols-3">
		<?php
		foreach ( $programs as $program ) {
			get_template_part( 'template-parts/cards/program-card', null, $program );
		}
		?>
	</div>
</section>

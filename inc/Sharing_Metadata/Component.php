<?php
/**
 * WP_Rig\WP_Rig\Sharing_Metadata Component.
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig\Sharing_Metadata;

use WP_Rig\WP_Rig\Component_Interface;

/**
 * Adds lightweight social-sharing metadata when no SEO plugin owns it.
 */
class Component implements Component_Interface {

	/**
	 * Gets the component slug.
	 *
	 * @return string Component slug.
	 */
	public function get_slug(): string {
		return 'sharing-metadata';
	}

	/**
	 * Adds WordPress hooks.
	 */
	public function initialize() {
		add_action( 'wp_head', array( $this, 'action_render_metadata' ), 5 );
	}

	/**
	 * Renders Open Graph and X/Twitter metadata.
	 */
	public function action_render_metadata(): void {
		if ( is_admin() || $this->seo_plugin_owns_metadata() ) {
			return;
		}

		$data = $this->get_metadata();
		if ( ! $data['title'] || ! $data['url'] ) {
			return;
		}

		echo "\n<!-- SocalNextGen sharing metadata -->\n";
		$this->meta( 'name', 'description', $data['description'] );
		$this->meta( 'property', 'og:locale', str_replace( '_', '-', get_locale() ) );
		$this->meta( 'property', 'og:site_name', get_bloginfo( 'name' ) );
		$this->meta( 'property', 'og:type', $data['type'] );
		$this->meta( 'property', 'og:title', $data['title'] );
		$this->meta( 'property', 'og:description', $data['description'] );
		$this->meta( 'property', 'og:url', $data['url'] );
		$this->meta( 'name', 'twitter:card', $data['image'] ? 'summary_large_image' : 'summary' );
		$this->meta( 'name', 'twitter:title', $data['title'] );
		$this->meta( 'name', 'twitter:description', $data['description'] );

		if ( $data['image'] ) {
			$this->meta( 'property', 'og:image', $data['image'] );
			$this->meta( 'property', 'og:image:alt', $data['image_alt'] );
			$this->meta( 'name', 'twitter:image', $data['image'] );
			$this->meta( 'name', 'twitter:image:alt', $data['image_alt'] );
		}

		echo "<!-- /SocalNextGen sharing metadata -->\n";
	}

	/**
	 * Resolves contextual sharing data.
	 *
	 * @return array<string,string> Metadata values.
	 */
	private function get_metadata(): array {
		$title       = wp_get_document_title();
		$description = get_bloginfo( 'description' );
		$url         = home_url( '/' );
		$type        = 'website';
		$image       = get_theme_file_uri( '/assets/images/NextGenLogo.png' );
		$image_alt   = __( 'Socal NextGen Youth Ministries logo', 'socalnextgen' );

		if ( is_singular() ) {
			$post_id     = get_queried_object_id();
			$url         = get_permalink( $post_id );
			$type        = 'article';
			$description = get_the_excerpt( $post_id );

			if ( ! $description ) {
				$description = wp_trim_words( wp_strip_all_tags( (string) get_post_field( 'post_content', $post_id ) ), 32, '…' );
			}

			if ( has_post_thumbnail( $post_id ) ) {
				$thumbnail_id = get_post_thumbnail_id( $post_id );
				$resolved     = wp_get_attachment_image_url( $thumbnail_id, 'full' );
				$resolved_alt = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );

				if ( $resolved ) {
					$image     = $resolved;
					$image_alt = $resolved_alt ?: get_the_title( $post_id );
				}
			}
		} elseif ( is_post_type_archive( 'youth-group' ) ) {
			$url         = get_post_type_archive_link( 'youth-group' );
			$description = __( 'Search SocalNextGen youth ministries by state and city.', 'socalnextgen' );
		}

		return array(
			'title'       => sanitize_text_field( $title ),
			'description' => sanitize_text_field( $description ?: get_bloginfo( 'description' ) ),
			'url'         => esc_url_raw( $url ),
			'type'        => $type,
			'image'       => esc_url_raw( $image ),
			'image_alt'   => sanitize_text_field( $image_alt ),
		);
	}

	/**
	 * Prints one escaped meta element.
	 *
	 * @param string $attribute Attribute name.
	 * @param string $key       Metadata key.
	 * @param string $value     Metadata value.
	 */
	private function meta( string $attribute, string $key, string $value ): void {
		if ( '' === $value ) {
			return;
		}

		printf(
			"<meta %s=\"%s\" content=\"%s\">\n",
			esc_attr( $attribute ),
			esc_attr( $key ),
			esc_attr( $value )
		);
	}

	/**
	 * Detects common SEO plugins that already generate social metadata.
	 *
	 * @return bool Whether another plugin owns metadata.
	 */
	private function seo_plugin_owns_metadata(): bool {
		return (
			defined( 'WPSEO_VERSION' ) ||
			defined( 'RANK_MATH_VERSION' ) ||
			defined( 'AIOSEO_VERSION' ) ||
			defined( 'SEOPRESS_VERSION' ) ||
			class_exists( 'The_SEO_Framework\\Load' )
		);
	}
}

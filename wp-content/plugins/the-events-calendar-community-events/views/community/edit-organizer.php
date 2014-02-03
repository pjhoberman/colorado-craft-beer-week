<?php
/**
 * Edit Organizer Form (requires form-organizer.php)
 * This is used to edit an event organizer.
 *
 * Override this template in your own theme by creating a file at
 * [your-theme]/tribe-events/community/edit-organizer.php
 *
 * @package TribeCommunityEvents
 * @since  3.1
 * @author Modern Tribe Inc.
 *
 */

if ( !defined('ABSPATH') ) { die('-1'); } ?>

<?php tribe_get_template_part( 'community/modules/header-links' ); ?>

<form method="post">

	<?php wp_nonce_field( 'ecp_organizer_submission' ); ?>

	<!-- Organizer Title -->
	<?php $organizer_name = esc_attr( tribe_get_organizer() ); ?>
	<div class="events-community-post-title">
		<label for="post_title" class="<?php echo ( $_POST && empty( $organizer_name ) ) ? 'error' : ''; ?>">
			<?php _e( 'Organizer Name:', 'tribe-events-community' ); ?>
			<small class="req"><?php _e( '(required)', 'tribe-events-community' ); ?></small>
		</label>
		<input type="text" name="post_title" value="<?php echo $organizer_name; ?>"/>

	</div><!-- .events-community-post-title -->

	<!-- Organizer Description -->
	<div class="events-community-post-content">

		<label for="post_content">
			<?php _e( 'Organizer Description:', 'tribe-events-community' ); ?>
			<small class="req"></small>
		</label>

		<?php // if admin wants rich editor (and using WP 3.3+) show the WYSIWYG, otherwise default to a textarea
		$content = tribe_community_events_get_organizer_description();
		if(TribeCommunityEvents::instance()->useVisualEditor && function_exists( 'wp_editor')) {
			$settings = array(
				'wpautop' => true,
				'media_buttons' => false,
				'editor_class' => 'frontend',
				'textarea_rows' => 5,
			);
			echo wp_editor( $content, 'tcepostcontent', $settings );
		} else {
			echo '<textarea name="tcepostcontent">'. esc_textarea( $content ) .'</textarea>';
		} ?>

	</div><!-- .events-community-post-content -->

	<?php tribe_get_template_part( 'community/modules/organizer' ); ?>

	<!-- Form Submit -->
	<div class="tribe-events-community-footer">

		<input type="submit" class="button submit events-community-submit" value="<?php
			echo ( $tribe_organizer_id ) ? __( 'Update Organizer', 'tribe-events-community' ) : __( 'Submit Organizer', 'tribe-events-community' );
		?>" name="community-event" />

	</div><!-- .tribe-events-community-footer -->

</form>

<?php
/**
 * Event Submission Form Image Uploader Block
 * Renders the image upload field in the submission form.
 *
 * Override this template in your own theme by creating a file at
 * [your-theme]/tribe-events/community/modules/image.php
 *
 * @package TribeCommunityEvents
 * @since  3.1
 * @author Modern Tribe Inc.
 *
 */

if ( !defined('ABSPATH') ) { die('-1'); }

?>

<!-- Event Featured Image -->
<?php do_action( 'tribe_events_community_before_the_featured_image' ); ?>

	<div class="tribe-events-community-details eventForm bubble" id="event_image_uploader">
		<table class="tribe-community-event-info" cellspacing="0" cellpadding="0">
			<tr>
				<td colspan="2" class="tribe_sectionheader">
					<h4 class="event-time"><?php _e( 'Event Image', 'tribe-events-community' ); ?></h4>
				</td>
			</tr>
			<tr>
				<td>
					<label for="EventImage">
						<?php _e( 'Upload', 'tribe-events-community' ); ?>:
					</label>
				</td>
				<td>
					<?php if( get_post() && has_post_thumbnail() ) { ?>
						<div class="tribe-community-events-preview-image">
							<?php the_post_thumbnail( 'medium' ); ?>
							<?php tribe_community_events_form_image_delete(); ?>
						</div>
					<?php }	?>

					<input type="file" name="event_image" id="EventImage">
					<small class="note"><?php _e('Images that are not png, jpg, or gif will not be uploaded.', 'tribe-events-community' ) ?></small>
				</td>
			</tr>
		</table><!-- .tribe-community-event-info -->
	</div><!-- .tribe-events-community-details -->

<?php do_action( 'tribe_events_community_after_the_featured_image' ); ?>
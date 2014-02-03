<?php
/**
 * Event Submission Form Metabox For Organizers
 * This is used to add a metabox to the event submission form to allow for choosing or
 * creating an organizer for user submitted events.
 *
 * This is ALSO used in the Organizer edit view. Be careful to test changes in both places.
 *
 * Override this template in your own theme by creating a file at
 * [your-theme]/tribe-events/community/modules/organizer.php
 *
 * @package TribeCommunityEvents
 * @since  2.1
 * @author Modern Tribe Inc.
 *
 */

if ( !defined('ABSPATH') ) { die('-1'); }

$organizer_name = esc_attr( tribe_get_organizer() );
$organizer_phone = esc_attr( tribe_get_organizer_phone() );
$organizer_website = esc_url( tribe_get_organizer_website_url() );
$organizer_email = esc_attr( tribe_get_organizer_email() );
if ( !isset( $event ) ) { $event = null; }
?>

<!-- Organizer -->
<div class="tribe-events-community-details eventForm bubble" id="event_organizer">

	<table class="tribe-community-event-info" cellspacing="0" cellpadding="0">

		<tr>
			<td colspan="2" class="tribe_sectionheader">
				<h4><?php _e( 'Event Organizer Details', 'tribe-events-community' ); ?></h4>
			</td><!-- .tribe_sectionheader -->
		</tr>

		<?php tribe_community_events_organizer_select_menu( $event ); ?>

		<?php if ( !tribe_community_events_is_organizer_edit_screen() ) { ?>
		<tr class="organizer">
			<td>
				<label for="OrganizerOrganizer" <?php if ( $event && $_POST && empty( $organizer_name ) ) echo 'class="error"'; ?>>
					<?php _e( 'Organizer Name' , 'tribe-events-community' ); ?>:
				</label>
			</td>
			<td>
				<input type="text" id="OrganizerOrganizer" name="organizer[Organizer]" size="25"  value="<?php echo $organizer_name; ?>" />
			</td>
		</tr><!-- .organizer -->
		<?php } ?>

		<tr class="organizer">
			<td>
				<label for="OrganizerPhone">
					<?php _e( 'Phone' , 'tribe-events-community' ); ?>:
				</label>
			</td>
			<td>
				<input type="text" id="OrganizerPhone" name="organizer[Phone]" size="25" value="<?php echo $organizer_phone; ?>" />
			</td>
		</tr><!-- .organizer -->

		<tr class="organizer">
			<td>
				<label for="OrganizerWebsite"><?php _e( 'Website' , 'tribe-events-community' ); ?>:</label>
			</td>
			<td>
				<input type="text" id="OrganizerWebsite" name="organizer[Website]" size="25" value="<?php echo $organizer_website; ?>" />
			</td>
		</tr><!-- .organizer -->

		<tr class="organizer">
			<td>
				<label for="OrganizerEmail"><?php _e( 'Email' , 'tribe-events-community' ); ?>:</label>
			</td>
			<td>
				<input type="text" id="OrganizerEmail" name="organizer[Email]" size="25" value="<?php echo $organizer_email; ?>" />
			</td>
		</tr><!-- .organizer -->

	</table><!-- #event_organizer -->

</div>
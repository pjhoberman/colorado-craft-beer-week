<?php
/**
 * Event Submission Form Website Block
 * Renders the website fields in the submission form.
 *
 * Override this template in your own theme by creating a file at
 * [your-theme]/tribe-events/community/modules/website.php
 *
 * @package TribeCommunityEvents
 * @since  3.1
 * @author Modern Tribe Inc.
 *
 */

if ( !defined('ABSPATH') ) { die('-1'); }

$event_url = function_exists('tribe_get_event_website_url') ? tribe_get_event_website_url() : tribe_community_get_event_website_url();

?>

<!-- Event Website -->
<?php do_action( 'tribe_events_community_before_the_website' ); ?>

<div class="tribe-events-community-details eventForm bubble" id="event_cost">

	<table class="tribe-community-event-info" cellspacing="0" cellpadding="0">

		<tr>
			<td colspan="2" class="tribe_sectionheader">
				<h4><?php _e('Event Website', 'tribe-events-calendar'); ?></h4>
			</td><!-- .tribe_sectionheader -->
		</tr>

		<tr class="website">
			<td>
				<label for="EventURL"><?php _e( 'URL' , 'tribe-events-community' ); ?>:</label>
			</td>
			<td>
				<input type="text" id="EventURL" name="EventURL" size="25" value="<?php echo esc_url($event_url); ?>" />
			</td>
		</tr><!-- .website -->

	</table><!-- #event_cost -->

</div><!-- .tribe-events-community-details -->

<?php do_action( 'tribe_events_community_after_the_website' ); ?>
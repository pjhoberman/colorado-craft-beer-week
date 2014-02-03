<?php
/**
 * Event Submission Form Price Block
 * Renders the pricing fields in the submission form.
 *
 * Override this template in your own theme by creating a file at
 * [your-theme]/tribe-events/community/modules/cost.php
 *
 * @package TribeCommunityEvents
 * @since  3.1
 * @author Modern Tribe Inc.
 *
 */

if ( !defined('ABSPATH') ) { die('-1'); }

?>

<!-- Event Cost -->
<?php do_action( 'tribe_events_community_before_the_cost' ); ?>

<div class="tribe-events-community-details eventForm bubble" id="event_cost">

	<table class="tribe-community-event-info" cellspacing="0" cellpadding="0">

		<tr>
			<td colspan="2" class="tribe_sectionheader">
				<h4><?php _e('Event Cost', 'tribe-events-calendar'); ?></h4>
			</td><!-- .tribe_sectionheader -->
		</tr>
		<tr>
			<td>
				<label for="EventCurrencySymbol">
					<?php _e('Currency Symbol','tribe-events-calendar'); ?>:
				</label>
			</td>
			<td>
				<input type='text' id="EventCurrencySymbol" name="EventCurrencySymbol" size="2" value="<?php tribe_community_events_form_currency_symbol(); ?>" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="EventCost">
					<?php _e('Cost','tribe-events-calendar'); ?>:
				</label>
			</td>
			<td><input type='text' id="EventCost" name="EventCost" size="6" value="<?php echo (isset($_POST['EventCost'])) ? esc_attr($_POST['EventCost']) : tribe_get_cost(); ?>" /></td>
		</tr>
		<tr>
			<td></td>
			<td><small><?php _e('Leave blank to hide the field. Enter a 0 for events that are free.', 'tribe-events-calendar'); ?></small></td>
		</tr>

	</table><!-- #event_cost -->

</div><!-- .tribe-events-community-details -->

<?php do_action( 'tribe_events_community_after_the_cost' ); ?>
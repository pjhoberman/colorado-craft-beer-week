<?php
/**
 * Event Submission Form Metabox For Venues
 * This is used to add a metabox to the event submission form to allow for choosing or
 * creating a venue for user submitted events.
 *
 * This is ALSO used in the Venue edit view. Be careful to test changes in both places.
 *
 * Override this template in your own theme by creating a file at
 * [your-theme]/tribe-events/community/modules/venue.php
 *
 * @package TribeCommunityEvents
 * @since  2.1
 * @author Modern Tribe Inc.
 *
 */

if ( !defined('ABSPATH') ) { die('-1'); }

$venue_name = tribe_get_venue();
$venue_phone = tribe_get_phone();
$venue_address = tribe_get_address();
$venue_city = tribe_get_city();
$venue_province = tribe_get_province();
$venue_state = tribe_get_state();
$venue_country = tribe_get_country();
$venue_zip = tribe_get_zip();

if ( !tribe_get_venue_id() && tribe_get_option( 'defaultValueReplace' ) ) {
	$venue_phone = empty( $venue_phone ) ? tribe_get_option( 'eventsDefaultPhone' ) : $venue_phone;
	$venue_address = empty( $venue_address ) ? tribe_get_option( 'eventsDefaultAddress' ) : $venue_address;
	$venue_city = empty( $venue_city ) ? tribe_get_option( 'eventsDefaultCity' ) : $venue_city;
	$venue_state = empty( $venue_state ) ? tribe_get_option( 'eventsDefaultState' ) : $venue_state;
	$venue_province = empty( $venue_province ) ? tribe_get_option( 'eventsDefaultProvince' ) : $venue_province;
	$venue_country = empty( $venue_country ) ? tribe_get_option( 'defaultCountry' ) : $venue_country;
	$venue_zip = empty( $venue_zip ) ? tribe_get_option( 'eventsDefaultZip' ) : $venue_zip;
}

if ( !isset( $event ) ) { $event = null; }
?>

<!-- Venue -->
<div class="tribe-events-community-details eventForm bubble" id="event_venue">

	<table class="tribe-community-event-info" cellspacing="0" cellpadding="0">

		<tr>
			<td colspan="2" class="tribe_sectionheader">
				<h4><?php _e( 'Event Location Details', 'tribe-events-community' ); ?></h4>
			</td><!-- .tribe_sectionheader -->
		</tr>

		<?php tribe_community_events_venue_select_menu( $event ); ?>

		<?php if ( !tribe_community_events_is_venue_edit_screen() ) { ?>
		<tr class="venue">
			<td>
				<label for="VenueVenue" <?php if ( $event && $_POST && empty( $venue_name ) ) echo 'class="error"'; ?>>
					<?php _e( 'Venue Name' , 'tribe-events-community' ); ?>:
				</label>
			</td>
			<td>
				<input type="text" id="VenueVenue" name="venue[Venue]" size="25"  value="<?php esc_attr_e($venue_name); ?>" />
			</td>
		</tr><!-- .venue -->
		<?php } ?>

		<tr class="venue">
			<td>
				<label for="VenueAddress">
					<?php _e( 'Address', 'tribe-events-community' ); ?>:
				</label>
			</td>
			<td>
				<input type="text" id="VenueAddress" name="venue[Address]" size="25" value="<?php esc_attr_e($venue_address); ?>" />
			</td>
		</tr><!-- .venue -->

		<tr class="venue">
			<td>
				<label for="VenueCity">
					<?php _e( 'City', 'tribe-events-community' ); ?>:
				</label>
			</td>
			<td><input type="text" id="VenueCity" name="venue[City]" size="25" value="<?php esc_attr_e($venue_city); ?>" /></td>
		</tr><!-- .venue -->

		<tr class="venue">
			<td>
				<label for="EventCountry">
					<?php _e( 'Country', 'tribe-events-community' ); ?>:
				</label>
			</td>
			<td>
				<select class="chosen" name="venue[Country]" id="EventCountry">
					<?php
					foreach (
						TribeEventsViewHelpers::constructCountries() as $abbr => $fullname ) {
						echo '<option value="'. esc_attr( $fullname ) .'" ';
						if($abbr == '')
							echo "disabled='disabled' ";

						selected( $venue_country == $fullname );
						echo '>'. esc_html( $fullname ) .'</option>';
					} ?>
				</select>
			</td>
		</tr><!-- .venue -->

		<tr class="venue">
			<?php if ( !isset( $venue_stateProvince ) || $venue_stateProvince == '' ) $venue_stateProvince = -1; ?>
			<td>
				<label for="StateProvinceText">
					<?php _e( 'State or Province', 'tribe-events-calendar' ); ?>:
				</label>
			</td>
			<td>
				<input id="StateProvinceText" name="venue[Province]" type="text" name="" size="25" value="<?php echo ( isset( $venue_province ) && $venue_province != '' && $venue_province != -1 ) ? esc_attr($venue_province) : ''; ?>" />
				<select class="chosen" id="StateProvinceSelect" name="venue[State]">
					<option value=""><?php _e( 'Select a State', 'tribe-events-community' ); ?></option>
					<?php foreach ( TribeEventsViewHelpers::loadStates() as $abbr => $fullname ) {
						echo '<option value="' . esc_attr($abbr) .'" ';
						selected( $venue_state == $abbr );
						echo '>'. esc_html( $fullname ) .'</option>'. "\n";
					} ?>
				</select>
			</td>
		</tr><!-- .venue -->

		<tr class="venue">
			<td>
				<label for="EventZip">
					<?php _e( 'Postal Code', 'tribe-events-community' ); ?>:
				</label>
			</td>
			<td>
				<input type="text" id="EventZip" name="venue[Zip]" size="6" value="<?php esc_attr_e($venue_zip); ?>" />
			</td>
		</tr><!-- .venue -->

		<tr class="venue">
			<td>
				<label for="EventPhone">
					<?php _e( 'Phone', 'tribe-events-community' ); ?>:
				</label>
			</td>
			<td>
				<input type="text" id="EventPhone" name="venue[Phone]" size="14" value="<?php esc_attr_e($venue_phone); ?>" />
			</td>
		</tr><!-- .venue -->

		<?php if ( !tribe_community_events_is_venue_edit_screen() ) { ?>
		<tr id="google_map_link_toggle">
			<td>
				<label for="EventShowMapLink">
					<?php _e( 'Show Google Maps Link','tribe-events-community' ); ?>:
				</label>
			</td>
			<td>
				<input type="checkbox" id="EventShowMapLink" name="EventShowMapLink" value="1" <?php checked( get_post_meta( $event, '_EventShowMapLink', true ) ); ?> />
			</td>
		</tr><!-- #google_map_link_toggle -->

		<?php if( tribe_get_option( 'embedGoogleMaps', true ) ) : ?>

			<tr id="google_map_toggle">
				<td>
					<label for="EventShowMap">
						<?php _e( 'Show Google Map', 'tribe-events-community' ); ?>:
					</label>
				</td>
				<td>
					<input type="checkbox" id="EventShowMap" name="EventShowMap" value="1" <?php checked( tribe_embed_google_map( $event ) ); ?> />
				</td>
			</tr><!-- #google_map_toggle -->

		<?php endif; ?>
		<?php } // if ( tribe_community_events_is_venue_edit_screen() ) ?>

	</table><!-- #event_venue -->

</div>
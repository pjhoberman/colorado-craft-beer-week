<?php
/**
 * Events Calendar Pro template Tags
 *
 * Display functions for use in WordPress templates.
 */

// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

if( class_exists( 'TribeEventsPro' ) ) {

	if ( !function_exists( 'tribe_get_mapview_link' ) ) {
		function tribe_get_mapview_link( $term = null ) {
			if ( isset( $wp_query->query_vars[TribeEvents::TAXONOMY] ) )
				$term = $wp_query->query_vars[TribeEvents::TAXONOMY];
			$output = TribeEvents::instance()->getLink( 'map', null, $term );
			return apply_filters( 'tribe_get_map_view_permalink', $output );
		}
	}

	/**
	 * Event Recurrence
	 *
	 * Test to see if event is recurring.
	 *
	 * Note: $recur_test_cache is used to avoid having to call get_post_meta repeatedly since get_post_meta is slow.
	 *
	 * @param int $postId (optional)
	 * @return bool true if event is a recurring event.
	 * @since 2.0
	 */
	if (!function_exists( 'tribe_is_recurring_event' )) {
		function tribe_is_recurring_event( $postId = null )  {
			static $recur_test_cache;
			if ( empty( $recur_test_cache ) ) $recur_test_cache = array();
			TribeEvents::instance();
			$postId = TribeEvents::postIdHelper( $postId );
			if ( isset( $recur_test_cache[$postId] ) ) return $recur_test_cache[$postId];
			$recur_test_cache[$postId] = apply_filters('tribe_is_recurring_event', (sizeof(get_post_meta($postId, '_EventStartDate')) > 1));
			return $recur_test_cache[$postId];
		}
	}

	/**
	 * Recurrence Text
	 *
	 * Get the textual version of event recurrence
	 * e.g Repeats daily for three days
	 *
	 * @param int $postId (optional)
	 * @return string Summary of recurrence.
	 * @since 2.0
	 */
	if (!function_exists( 'tribe_get_recurrence_text' )) {
		function tribe_get_recurrence_text( $postId = null )  {
			$postId = TribeEvents::postIdHelper( $postId );
			$tribe_ecp = TribeEvents::instance();
		  	return apply_filters( 'tribe_get_recurrence_text', TribeEventsRecurrenceMeta::recurrenceToTextByPost( $postId ) );
		}
	}

	/**
	 * Recurring Event List Link
	 *
	 * Display link for all occurrences of an event (based on the currently queried event).
	 *
	 * @param int $postId (optional)
	 * @since 2.0
	 */
	if (!function_exists( 'tribe_all_occurences_link' )) {
		function tribe_all_occurences_link( $postId = null, $echo = true )  {
			$postId = TribeEvents::postIdHelper( $postId );
			$post = get_post($postId);
			$tribe_ecp = TribeEvents::instance();
			$link = apply_filters('tribe_all_occurences_link', $tribe_ecp->getLink('all'));
			if( $echo ) {
				echo $link;
			} else {
				return $link;
			}
		}
	}

	// show user front-end settings only if ECP is active
	function tribe_recurring_instances_toggle( $postId = null )  {
			$hide_recurrence = ( !empty( $_REQUEST['tribeHideRecurrence'] ) && $_REQUEST['tribeHideRecurrence'] == '1' ) || ( empty( $_REQUEST['tribeHideRecurrence'] ) && empty( $_REQUEST['action'] ) && tribe_get_option( 'hideSubsequentRecurrencesDefault', false ) ) ? '1' : false;
		if( !tribe_is_week() && !tribe_is_month() ){
			echo '<span class="tribe-events-user-recurrence-toggle">';
				echo '<label for="tribeHideRecurrence">';
					echo '<input type="checkbox" name="tribeHideRecurrence" value="1" id="tribeHideRecurrence" ' . checked( $hide_recurrence, 1, false ) . '>' . __( 'Show only the first upcoming instance of recurring events', 'tribe-events-calendar-pro' );
				echo '</label>';
			echo '</span>';
		}
	}

	/**
	 * Event Custom Fields
	 *
	 * Get an array of custom fields
	 *
	 * @param int $postId (optional)
	 * @return array $data of custom fields
	 * @since 2.0
	 */
	function tribe_get_custom_fields( $postId = null ) {
		$postId = TribeEvents::postIdHelper( $postId );
		$data = array();
		$customFields = tribe_get_option('custom-fields', false);
		if (is_array($customFields)) {
			foreach ($customFields as $field) {
				$meta = str_replace('|', ', ', get_post_meta($postId, $field['name'], true));
				if( $field['type'] == 'url' && !empty($meta) ) {
					$url_label = $meta;
					$parseUrl = parse_url($meta);
					if (empty($parseUrl['scheme']))
						$meta = "http://$meta";
					$meta = sprintf('<a href="%s" target="%s">%s</a>',
						$meta,
						apply_filters('tribe_get_event_website_link_target', 'self'),
						apply_filters('tribe_get_event_website_link_label', $url_label)
						);
				}
				if ( $meta ) {
					$data[esc_html($field['label'])] = $meta; // $meta has been through wp_kses - links are allowed
				}
			}
		}
		return apply_filters('tribe_get_custom_fields', $data);
	}

	/**
	 * Event Custom Fields (Display)
	 *
	 * Display a definition term list of custom fields
	 *
	 * @param int $postId (optional)
	 * @since 2.0
	 */
	function tribe_the_custom_fields( $postId = null, $echo = true ) {
		$fields = tribe_get_custom_fields( $postId );
		$meta_html = '';
	  	foreach ($fields as $label => $value) {
			$meta_html .= apply_filters('tribe_the_custom_field', sprintf('<dt>%s</dt><dd class="tribe-events-meta-custom-data">%s</dd>', $label, $value ),
				$label,
				$value);
		}
		$meta_html = apply_filters('tribe_the_custom_fields', $meta_html);
		if( $echo ) {
			echo $meta_html;
		} else {
			return $meta_html;
		}
	}

	/**
	 * Get Event Custom Field by Label
	 *
	 * retrieve a custom field's value by searching its label
	 * instead of its (more obscure) ID
	 *
	 * @since 2.0.3
	 * @param (string) $label, the label to search for
	 * @param (int) $eventID (optional), the event to look for, defaults to global $post
	 * @return (string) value of the field
	 */
	function tribe_get_custom_field( $label, $eventID = null ) {
		return apply_filters('tribe_get_custom_field', TribeEventsCustomMeta::get_custom_field_by_label( $label, $eventID ) );
	}

	/**
	 * Echo Event Custom Field by Label
	 *
	 * same as above but echo instead of return
	 *
	 * @since 2.0.3
	 * @param (string) $label, the label to search for
	 * @param (int) $eventID (optional), the event to look for, defaults to global $post
	 * @return (string) value of the field
	 */
	function tribe_custom_field( $label, $eventID = null ) {
		echo tribe_get_custom_field( $label, $eventID = null );
	}

	/**
	 * iCal Link (Single)
	 *
	 * Returns an ical feed for a single event. Must be used in the loop.
	 *
	 * @return string URL for ical for single event.
	 * @since 2.0
	 */
	function tribe_get_single_ical_link() {
		$output = TribeiCal::get_ical_link();
		return apply_filters( 'tribe_get_ical_link', $output );
	}

	/**
	 * iCal Link
	 *
	 * Returns a sitewide ical link
	 *
	 * @return string URL for ical dump.
	 * @since 2.0
	 */
	function tribe_get_ical_link() {
		$output = TribeiCal::get_ical_link();
		return apply_filters( 'tribe_get_ical_link', $output );
	}

	/**
	 * Google Calendar Link
	 *
	 * Returns an add to Google Calendar link. Must be used in the loop
	 *
	 * @param int $postId (optional)
	 * @return string URL for google calendar.
	 * @since 2.0
	 */
	function tribe_get_gcal_link( $postId = null )  {
		$postId = TribeEvents::postIdHelper( $postId );
		$tribe_ecp = TribeEventsPro::instance();
		$output = esc_url($tribe_ecp->googleCalendarLink( $postId ));
		return apply_filters('tribe_get_gcal_link', $output);
	}

	/**
	 * Day View Link
	 *
	 * Get a link to day view
	 *
	 * @param string $date
	 * @param string $day
	 * @return string HTML linked date
	 * @since 2.0
	 */
	function tribe_get_linked_day($date, $day) {
		$return = '';
		$return .= "<a href='" . tribe_get_day_link($date) . "'>";
		$return .= $day;
		$return .= "</a>";
		return apply_filters('tribe_get_linked_day', $return);
	}

	/**
	* Get Related Events
	*
	* Get a list of related events to the current post
	*
	* @param int $count
	* @return array Array of events
	* @since 2.1
	*/
	function tribe_get_related_events ($count=3) {
		return apply_filters('tribe_get_related_events', TribeRelatedEvents::getEvents( $count ) );
	}

	/**
	* Display Related Events
	*
	* Display a list of related events to the current post
	*
	* @param string $title
	* @param int $count
	* @param bool $thumbnails
	* @param bool $start_date
	* @since 2.1
	*/
	function tribe_related_events ($title, $count=3, $thumbnails=false, $start_date=false, $get_title=true) {
		return apply_filters('tribe_related_events', TribeRelatedEvents::displayEvents( $title, $count, $thumbnails, $start_date, $get_title ) );
	}

	/**
	 * Displays the saved organizer
	 * Used in the settings screen
	 *
	 * @author jkudish
	 * @since 2.0.5
	 * @return void
	 */
	function tribe_display_saved_organizer() {
		$current_organizer_id = tribe_get_option('eventsDefaultOrganizerID', 'none' );
		$current_organizer = ($current_organizer_id != 'none' && $current_organizer_id != 0 && $current_organizer_id) ? tribe_get_organizer($current_organizer_id) : __('No default set', 'tribe-events-calendar-pro');
		echo '<p class="tribe-field-indent description">'.sprintf( __('The current default organizer is: %s', 'tribe-events-calendar-pro' ), '<strong>'.$current_organizer.'</strong>').'</p>';
	}

	/**
	 * Displays the saved venue
	 * Used in the settings screen
	 *
	 * @author jkudish
	 * @since 2.0.5
	 * @return void
	 */
	function tribe_display_saved_venue() {
		$current_venue_id = tribe_get_option('eventsDefaultVenueID', 'none' );
		$current_venue = ($current_venue_id != 'none' && $current_venue_id != 0 && $current_venue_id) ? tribe_get_venue($current_venue_id) : __('No default set', 'tribe-events-calendar-pro');
		echo '<p class="tribe-field-indent tribe-field-description description">'.sprintf( __('The current default venue is: %s', 'tribe-events-calendar-pro' ), '<strong>'.$current_venue.'</strong>').'</p>';
	}

	/**
	 * Displays the saved address
	 * Used in the settings screen
	 *
	 * @author jkudish
	 * @since 2.0.5
	 * @return void
	 */
	function tribe_display_saved_address() {
		$option = tribe_get_option('eventsDefaultAddress', __('No default set', 'tribe-events-calendar-pro'));
		$option = ( !isset($option) || $option == '' || !$option ) ? __('No default set', 'tribe-events-calendar-pro') : $option;
		echo '<p class="tribe-field-indent tribe-field-description venue-default-info description">'.sprintf( __('The current default address is: %s', 'tribe-events-calendar-pro' ), '<strong>'.$option.'</strong>').'</p>';
	}

	/**
	 * Displays the saved city
	 * Used in the settings screen
	 *
	 * @author jkudish
	 * @since 2.0.5
	 * @return void
	 */
	function tribe_display_saved_city() {
		$option = tribe_get_option('eventsDefaultCity', __('No default set', 'tribe-events-calendar-pro'));
		$option = ( !isset($option) || $option == '' || !$option ) ? __('No default set', 'tribe-events-calendar-pro') : $option;
		echo '<p class="tribe-field-indent tribe-field-description venue-default-info description">'.sprintf( __('The current default city is: %s', 'tribe-events-calendar-pro' ), '<strong>'.$option.'</strong>').'</p>';
	}

	/**
	 * Displays the saved state
	 * Used in the settings screen
	 *
	 * @author jkudish
	 * @since 2.0.5
	 * @return void
	 */
	function tribe_display_saved_state() {
		$option = tribe_get_option('eventsDefaultState', __('No default set', 'tribe-events-calendar-pro'));
		$option = ( !isset($option) || $option == '' || !$option ) ? __('No default set', 'tribe-events-calendar-pro') : $option;
		echo '<p class="tribe-field-indent tribe-field-description venue-default-info description">'.sprintf( __('The current default state is: %s', 'tribe-events-calendar-pro' ), '<strong>'.$option.'</strong>').'</p>';
	}

	/**
	 * Displays the saved province
	 * Used in the settings screen
	 *
	 * @author jkudish
	 * @since 2.0.5
	 * @return void
	 */
	function tribe_display_saved_province() {
		$option = tribe_get_option('eventsDefaultProvince', __('No default set', 'tribe-events-calendar-pro'));
		$option = ( !isset($option) || $option == '' || !$option ) ? __('No default set', 'tribe-events-calendar-pro') : $option;
		echo '<p class="tribe-field-indent tribe-field-description venue-default-info description">'.sprintf( __('The current default province is: %s', 'tribe-events-calendar-pro' ), '<strong>'.$option.'</strong>').'</p>';
	}

	/**
	 * Displays the saved zip
	 * Used in the settings screen
	 *
	 * @author jkudish
	 * @since 2.0.5
	 * @return void
	 */
	function tribe_display_saved_zip() {
		$option = tribe_get_option('eventsDefaultZip', __('No default set', 'tribe-events-calendar-pro'));
		$option = ( !isset($option) || $option == '' || !$option ) ? __('No default set', 'tribe-events-calendar-pro') : $option;
		echo '<p class="tribe-field-indent tribe-field-description venue-default-info description">'.sprintf( __('The current default postal code/zip code is: %s', 'tribe-events-calendar-pro' ), '<strong>'.$option.'</strong>').'</p>';
	}

	/**
	 * Displays the saved country
	 * Used in the settings screen
	 *
	 * @author jkudish
	 * @since 2.0.5
	 * @return void
	 */
	function tribe_display_saved_country() {
		$option = tribe_get_option('defaultCountry', __('No default set', 'tribe-events-calendar-pro'));
		$option = ( !isset($option) || $option == '' || !$option || empty($option) || !is_array($option) || !isset($option[1]) ) ? __('No default set', 'tribe-events-calendar-pro') : $option = $option[1];
		echo '<p class="tribe-field-indent tribe-field-description venue-default-info description">'.sprintf( __('The current default country is: %s', 'tribe-events-calendar-pro' ), '<strong>'.$option.'</strong>').'</p>';
	}

	/**
	 * Displays the saved phone
	 * Used in the settings screen
	 *
	 * @author jkudish
	 * @since 2.0.5
	 * @return void
	 */
	function tribe_display_saved_phone() {
		$option = tribe_get_option('eventsDefaultPhone', __('No default set', 'tribe-events-calendar-pro'));
		$option = ( !isset($option) || $option == '' || !$option ) ? __('No default set', 'tribe-events-calendar-pro') : $option;
		echo '<p class="tribe-field-indent tribe-field-description venue-default-info description">'.sprintf( __('The current default phone is: %s', 'tribe-events-calendar-pro' ), '<strong>'.$option.'</strong>').'</p>';
	}

	/**
	 * Returns the formatted and converted distance from the db (always in kms.) to the unit selected
	 * by the user in the 'defaults' tab of our settings.
	 *
	 * @param $distance_in_kms
	 *
	 * @return mixed
	 *
	 */
	function tribe_get_distance_with_unit( $distance_in_kms ) {

		$tec = TribeEvents::instance();

		$unit     = $tec->getOption( 'geoloc_default_unit', 'miles' );
		$distance = round( tribe_convert_units( $distance_in_kms, 'kms', $unit ), 2 );

		return apply_filters( 'tribe_formatted_distance', $distance . ' ' .  $unit );
	}

	/**
	 * Returns an events distance from location search term
	 *
	 * @since 3.0
	 * @return string
	 *
	 */
	function tribe_event_distance() {
		global $post;
 		if ( !empty( $post->distance ) ) {
			return '<span class="tribe-events-distance">'. tribe_get_distance_with_unit( $post->distance ) .'</span>';
		}
	}

	/**
	 *
	 * Converts units. Uses tribe_convert_$unit_to_$unit_ratio filter to get the ratio.
	 *
	 * @param $value
	 * @param $unit_from
	 * @param $unit_to
	 */
	function tribe_convert_units( $value, $unit_from, $unit_to ) {

		if ( $unit_from === $unit_to )
			return $value;

		$filter = sprintf( 'tribe_convert_%s_to_%s_ratio', $unit_from, $unit_to );
		$ratio  = apply_filters( $filter, 0 );

		// if there's not filter for this conversion, let's return the original value
		if ( empty( $ratio ) )
			return $value;

		return ( $value * $ratio );

	}

	/**
	 * Get the first day of the week from a provided date
	 *
	 * @param null|mixed $date  given date or week # (week # assumes current year)
	 * @return string
	 */
	function tribe_get_first_week_day( $date = null ) {
		global $wp_query;
		$offset = 7 - get_option( 'start_of_week', 0 );

		$date = is_null( $date ) ? $wp_query->get('start_date') : $date;

		try {
			$date = new DateTime( $date );
		} catch ( exception $e ) {
			$date = new DateTime();
		}

		// $date = is_null($date) ? new DateTime( $wp_query->get( 'start_date' ) ) : new DateTime( $date );
		// Clone to avoid altering the original date
		$r = clone $date;
		$r->modify(-(($date->format('w') + $offset) % 7) . 'days');
		return apply_filters('tribe_get_first_week_day', $r->format('Y-m-d'));
	}

	/**
	 * Get the last day of the week from a provided date
	 *
	 * @param string|int $date_or_int A given date or week # (week # assumes current year)
	 * @param bool $by_date determines how to parse the date vs week provided
	 * @param int $first_day sets start of the week (offset) respectively, accepts 0-6
	 * @return DateTime
	 */
	function tribe_get_last_week_day( $date_or_int, $by_date = true ) {
		return apply_filters('tribe_get_last_week_day', date('Y-m-d', strtotime( tribe_get_first_week_day( $date_or_int, $by_date ) . ' +7 days' )));
	}

	/**
	 * Week Loop View Test
	 *
	 * @return bool
	 * @since 3.0
	 */
	function tribe_is_week()  {
		$is_week = (TribeEvents::instance()->displaying == 'week') ? true : false;
		return apply_filters('tribe_is_week', $is_week);
	}

	/**
	 * Week Loop View Test
	 *
	 * @return bool
	 * @since 3.0
	 */
	function tribe_is_photo()  {
		$is_photo = (TribeEvents::instance()->displaying == 'photo') ? true : false;
		return apply_filters('tribe_is_photo', $is_photo);
	}

	/**
	 * Map Loop View Test
	 *
	 * @return bool
	 * @since 3.0
	 */
	function tribe_is_map()  {
		$tribe_ecp = TribeEvents::instance();
		$is_map = ($tribe_ecp->displaying == 'map') ? true : false;
		return apply_filters('tribe_is_map', $is_map);
	}

	/**
	 * Display Week Navigation
	 *
	 * @param string $week
	 * @since 3.0
	 */
	// REMOVE IF FOUND UNNEEDED
	// function tribe_display_by_week_navigation( $week = null ){
	// 	if( is_null($week) ){
	// 		$week = date("Y-m-d", strtotime('now'));
	// 	}
	// 	echo date('Y-m-d', strtotime( tribe_get_first_week_day( $week ) . ' -1 day'));
	// 	echo '<br />';
	// 	echo tribe_get_last_week_day( $week );
	// }

	/**
	 * Get last week permalink by provided date (7 days offset)
	 *
	 * @uses tribe_get_week_permalink
	 * @param string $week
	 * @param bool $is_current
	 * @return string $permalink
	 * @since 3.0
	 */
	function tribe_get_last_week_permalink( $week = null ) {
		$week = !empty( $week ) ? $week : tribe_get_first_week_day();
		if ( PHP_INT_SIZE <= 4 ) {
			if ( date('Y-m-d', strtotime($week)) < '1902-01-08' ) {
				throw new OverflowException(__('Date out of range.', 'tribe-events-calendar-pro'));
			}
		}
		$week = date('Y-m-d', strtotime( $week . ' -1 week'));
		return apply_filters('tribe_get_last_week_permalink', tribe_get_week_permalink( $week ) );
	}

	/**
	 * Get next week permalink by provided date (7 days offset)
	 *
	 * @uses tribe_get_week_permalink
	 * @param string $week
	 * @return string $permalink
	 * @since 3.0
	 */
	function tribe_get_next_week_permalink( $week = null ) {
		$week = !empty( $week ) ? $week : tribe_get_first_week_day();
		if ( PHP_INT_SIZE <= 4 ) {
			if ( date('Y-m-d', strtotime($week)) > '2037-12-24' ) {
				throw new OverflowException(__('Date out of range.', 'tribe-events-calendar-pro'));
			}
		}
		$week = date('Y-m-d', strtotime( $week . ' +1 week'));
		return apply_filters('tribe_get_next_week_permalink', tribe_get_week_permalink( $week ) );
	}

	/**
	 * Output an html link to a day
	 *
	 * @param string $date 'previous day', 'next day', 'yesterday', 'tomorrow', or any date string that strtotime() can parse
	 * @param string $text text for the link
	 * @return void
	 * @since 3.0
	 **/
	function tribe_the_day_link( $date = null, $text = null ) {
		try {
			if ( is_null( $text ) ) {
				$text = tribe_get_the_day_link_label($date);
			}
			$date = tribe_get_the_day_link_date( $date );

			$link = tribe_get_day_link($date);

			$html = '<a href="'. $link .'" data-day="'. $date .'" rel="prev">'.$text.'</a>';
		} catch ( OverflowException $e ) {
			$html = '';
		}

		echo apply_filters( 'tribe_the_day_link', $html );
	}

	/**
	 * Get the label for the day navigation link
	 *
	 * @param string $date_description
	 * @return string
	 * @since 3.1.1
	 */
	function tribe_get_the_day_link_label( $date_description ) {
		switch ( strtolower( $date_description ) ) {
			case null :
				return __( 'Today', 'tribe-events-calendar-pro' );
			case 'previous day' :
				return __( '&laquo; Previous Day', 'tribe-events-calendar-pro' );
			case 'next day' :
				return __( 'Next Day &raquo;', 'tribe-events-calendar-pro' );
			case 'yesterday' :
				return __( 'Yesterday', 'tribe-events-calendar-pro' );
			case 'tomorrow' :
				return __( 'Tomorrow', 'tribe-events-calendar-pro' );
			default :
				return date_i18n( 'Y-m-d', strtotime( $date_description ) );
		}
	}


	/**
	 * Get the date for the day navigation link.
	 *
	 * @param string $date_description
	 * @return string
	 * @since 3.1.1
	 * @throws OverflowException
	 */
	function tribe_get_the_day_link_date( $date_description ) {
		if ( is_null($date_description) ) {
			return TribeEventsPro::instance()->todaySlug;
		}
		if ( $date_description == 'previous day' ) {
			return tribe_get_previous_day_date(get_query_var('start_date'));
		}
		if ( $date_description == 'next day' ) {
			return tribe_get_next_day_date(get_query_var('start_date'));
		}
		return date('Y-m-d', strtotime($date_description) );
	}

	/**
	 * Get the next day's date
	 *
	 * @param string $start_date
	 * @return string
	 * @since 3.1.1
	 * @throws OverflowException
	 */
	function tribe_get_next_day_date( $start_date ) {
		if ( PHP_INT_SIZE <= 4 ) {
			if ( date('Y-m-d', strtotime($start_date)) > '2037-12-30' ) {
				throw new OverflowException(__('Date out of range.', 'tribe-events-calendar-pro'));
			}
		}
		$date = Date('Y-m-d', strtotime($start_date . " +1 day") );
		return $date;
	}

	/**
	 * Get the previous day's date
	 *
	 * @param string $start_date
	 * @return string
	 * @since 3.1.1
	 * @throws OverflowException
	 */
	function tribe_get_previous_day_date( $start_date ) {
		if ( PHP_INT_SIZE <= 4 ) {
			if ( date('Y-m-d', strtotime($start_date)) < '1902-01-02' ) {
				throw new OverflowException(__('Date out of range.', 'tribe-events-calendar-pro'));
			}
		}
		$date = Date('Y-m-d', strtotime($start_date . " -1 day") );
		return $date;
	}


	/**
	 * Get week permalink
	 *
	 * @param string $week
	 * @return string $permalink
	 * @since 3.0
	 */
	function tribe_get_week_permalink( $week = null, $term = true ){
		$week = is_null($week) ? false : date('Y-m-d', strtotime( $week ) );
		if ( isset( $wp_query->query_vars[TribeEvents::TAXONOMY] ) )
			$term = $wp_query->query_vars[TribeEvents::TAXONOMY];
		$output = TribeEvents::instance()->getLink( 'week', $week, $term );
		return apply_filters('tribe_get_week_permalink', $output);
	}


	/**
	 * Get photo permalink by provided date
	 * @return string $permalink
	 * @since 3.0
	 */
	function tribe_get_photo_permalink( $term = true ) {
		if ( isset( $wp_query->query_vars[TribeEvents::TAXONOMY] ) )
			$term = $wp_query->query_vars[TribeEvents::TAXONOMY];
		$output = TribeEvents::instance()->getLink( 'photo', null, $term );
		return apply_filters( 'tribe_get_photo_view_permalink', $output );
	}

	/**
	 * Echos the single events page related events boxes.
	 *
	 * @param mixed $tag The specific tags you want it relating to.
	 * @param mixed $category The specific categories you want it relating to.
	 * @param int $count The number of related events to find.
	 * @return void.
	 */
	function tribe_single_related_events( $count = 3 ) {
		$posts = tribe_get_related_posts( $count );
		if ( is_array( $posts ) && !empty( $posts ) ) {
			echo '<h3 class="tribe-events-related-events-title">'.  __( 'Related Events', 'tribe-events-calendar-pro' ) .'</h3>';
			echo '<ul class="tribe-related-events tribe-clearfix hfeed vcalendar">';
			foreach ( $posts as $post ) {
				echo '<li>';

					$thumb = ( has_post_thumbnail( $post->ID ) ) ? get_the_post_thumbnail( $post->ID, 'large' ) : '<img src="'. trailingslashit( TribeEventsPro::instance()->pluginUrl ) . 'resources/images/tribe-related-events-placeholder.png" alt="'. get_the_title( $post->ID ) .'" />';;
					echo '<div class="tribe-related-events-thumbnail">';
					echo '<a href="'. tribe_get_event_link( $post ) .'" class="url" rel="bookmark">'. $thumb .'</a>';
					echo '</div>';
					echo '<div class="tribe-related-event-info">';
						echo '<h3 class="tribe-related-events-title summary"><a href="'. tribe_get_event_link( $post ) .'" class="url" rel="bookmark">'. get_the_title( $post->ID ) .'</a></h3>';

						if ( class_exists( 'TribeEvents' ) && $post->post_type == TribeEvents::POSTTYPE && function_exists( 'tribe_events_event_schedule_details' ) ) {
							echo tribe_events_event_schedule_details( $post );
						}
						if ( class_exists( 'TribeEvents' ) && $post->post_type == TribeEvents::POSTTYPE && function_exists( 'tribe_events_event_recurring_info_tooltip' ) ) {
							echo tribe_events_event_recurring_info_tooltip( $post->ID );
						}
					echo '</div>';
				echo '</li>';
			}
			echo '</ul>';
		}
	}

	/**
	 * Template tag to get related posts for the current post.
	 *
	 * @since 1.1
	 * @author Paul Hughes
	 * @param int $count number of related posts to return.
	 * @param int|obj $post the post to get related posts to, defaults to current global $post
	 * @return array the related posts.
	 */
	function tribe_get_related_posts( $count = 3, $post = false ) {
		$post_id = TribeEvents::postIdHelper( $post );
		$tags = wp_get_post_tags( $post_id, array( 'fields' => 'ids' ) );
		$categories = wp_get_object_terms( $post_id, TribeEvents::TAXONOMY, array( 'fields' => 'ids' ) );
		if ( ! $tags && ! $categories )
			return;
		$args = array(
			'posts_per_page' => $count,
			'post__not_in' => array( $post_id ),
			'eventDisplay' => 'upcoming',
			'tax_query' => array('relation' => 'OR'),
			'orderby' => 'rand',
		);
		if ( $tags ) {
			$args['tax_query'][] = array( 'taxonomy' => 'post_tag', 'field' => 'id', 'terms' => $tags );
		}
		if ( $categories ) {
			$args['tax_query'][] = array( 'taxonomy' => TribeEvents::TAXONOMY, 'field' => 'id', 'terms' => $categories );
		}

		$args = apply_filters( 'tribe_related_posts_args', $args );

		if ( $args ) {
			$posts = TribeEventsQuery::getEvents( $args );
		} else {
			$posts = array();
		}

		return apply_filters( 'tribe_get_related_posts',  $posts ) ;
	}


}

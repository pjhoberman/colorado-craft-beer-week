<?php
/**
 * Tests if the current page is the My Events page
 *
 * @return bool whether it is the My Events page.
 * @author Paul Hughes
 * @since 1.0.1
 */
function tribe_is_community_my_events_page() {
	$tce = TribeCommunityEvents::instance();

	return $tce->isMyEvents;
}

/**
 * Tests if the current page is the Edit Event page
 *
 * @return bool whether it is the Edit Event page.
 * @author Paul Hughes
 * @since 1.0.1
 */
function tribe_is_community_edit_event_page() {
	$tce = TribeCommunityEvents::instance();

	return $tce->isEditPage;
}

/**
 * Test if the current user can edit posts
 *
 * @param int|null $post_id
 * @param string|null $post_type (tribe_events, tribe_venue, or tribe_organizer)
 * @return bool whether the user can edit
 * @author Peter Chester
 * @since 3.1
 * @deprecated since version 3.1
 */
function tribe_community_events_user_can_edit( $post_id = null, $post_type = null ) {
	return TribeCommunityEvents::instance()->userCanEdit( $post_id, $post_type );
}

/**
 * Echo the community events form title field
 *
 * @author Peter Chester
 * @since 3.1
 */
function tribe_community_events_form_title() {
	TribeCommunityEvents::instance()->formTitle();
}

/**
 * Echo the community events form content editor
 *
 * @author Peter Chester
 * @since 3.1
 */
function tribe_community_events_form_content() {
	TribeCommunityEvents::instance()->formContentEditor();
}

/**
 * Echo the community events form image delete button
 *
 * @author Peter Chester
 * @since 3.1
 */
function tribe_community_events_form_image_delete() {
	echo TribeCommunityEvents::instance()->getDeleteFeaturedImageButton();
}

/**
 * Echo the community events form image preview
 *
 * @author Peter Chester
 * @since 3.1
 */
function tribe_community_events_form_image_preview() {
	echo TribeCommunityEvents::instance()->getDeleteFeaturedImageButton();
}

/**
 * Echo the community events form currency symbol
 *
 * @author Peter Chester
 * @since 3.1
 */
function tribe_community_events_form_currency_symbol() {
	if ( get_post() )
		$EventCurrencySymbol = get_post_meta( get_the_ID(), '_EventCurrencySymbol', true );
	if ( !isset( $EventCurrencySymbol ) || !$EventCurrencySymbol )
		$EventCurrencySymbol = isset( $_POST['EventCurrencySymbol'] ) ? $_POST['EventCurrencySymbol'] : tribe_get_option( 'defaultCurrencySymbol', '$' );
	echo esc_attr($EventCurrencySymbol);
}

/**
 * Return URL for adding a new event.
 */
function tribe_community_events_add_event_link() {
	$url = TribeCommunityEvents::instance()->getUrl( 'add' );
	return apply_filters( 'tribe-community-events-add-event-link', $url );
}

/**
 * Return URL for listing events.
 */
function tribe_community_events_list_events_link() {
	$url = TribeCommunityEvents::instance()->getUrl( 'list' );
	return apply_filters( 'tribe-community-events-list-events-link', $url );
}

/**
 * Return URL for editing an event.
 */
function tribe_community_events_edit_event_link( $event_id = null ) {
	$url = TribeCommunityEvents::instance()->getUrl( 'edit', $event_id );
	return apply_filters( 'tribe-community-events-edit-event-link', $url, $event_id );
}

/**
 * Return URL for deleting an event.
 */
function tribe_community_events_delete_event_link( $event_id = null ) {
	$url = TribeCommunityEvents::instance()->getUrl( 'delete', $event_id );
	return apply_filters( 'tribe-community-events-delete-event-link', $url, $event_id );
}

/**
 * Return the event start date string with a default of today.
 *
 * @param null|int $event_id
 * @return string event date
 * @author Peter Chester
 * @since 3.1
 */
function tribe_community_events_get_start_date( $event_id = null ) {
	$event_id = TribeEvents::postIdHelper( $event_id );
	$event = ( $event_id ) ? get_post( $event_id ) : null;
	$date = tribe_get_start_date( $event, true, 'Y-m-d' );
	$date = ( $date ) ? TribeDateUtils::dateOnly( $date ) : date_i18n( 'Y-m-d' );
	return apply_filters( 'tribe_community_events_get_start_date', $date, $event_id );
}

/**
 * Return the event end date string with a default of today.
 *
 * @param null|int $event_id
 * @return string event date
 * @author Peter Chester
 * @since 3.1
 */
function tribe_community_events_get_end_date( $event_id = null ) {
	$event_id = TribeEvents::postIdHelper( $event_id );
	$event = ( $event_id ) ? get_post( $event_id ) : null;
	$date = tribe_get_end_date( $event, true, 'Y-m-d' );
	$date = ( $date ) ? TribeDateUtils::dateOnly( $date ) : date_i18n( 'Y-m-d' );
	return apply_filters( 'tribe_community_events_get_end_date', $date, $event_id );
}

/**
 * Return true if event is an all day event.
 *
 * @param null|int $event_id
 * @return bool event date
 * @author Peter Chester
 * @since 3.1
 */
function tribe_community_events_is_all_day( $event_id = null ) {
	$event_id = TribeEvents::postIdHelper( $event_id );
	$is_all_day = tribe_event_is_all_day( $event_id );
	$is_all_day = ( $is_all_day == 'Yes' || $is_all_day == true );
	return apply_filters( 'tribe_community_events_is_all_day', $is_all_day, $event_id );
}

/**
 * Return form select fields for event start time.
 *
 * @param null|int $event_id
 * @return string time select HTML
 * @author Peter Chester
 * @since 3.1
 */
function tribe_community_events_form_start_time_selector( $event_id = null ) {

	$event_id = TribeEvents::postIdHelper( $event_id );
	$is_all_day = tribe_event_is_all_day( $event_id );
	$start_date = tribe_get_start_date( $event_id );

	$start_minutes 	= TribeEventsViewHelpers::getMinuteOptions( $start_date, true );
	$start_hours = TribeEventsViewHelpers::getHourOptions( $is_all_day == 'yes' ? null : $start_date, true );
	$start_meridian = TribeEventsViewHelpers::getMeridianOptions( $start_date, true );

	$output = '';
	$output .= sprintf( '<select name="EventStartHour">%s</select>', $start_hours );
	$output .= sprintf( '<select name="EventStartMinute">%s</select>', $start_minutes );
	if ( !strstr( get_option( 'time_format', TribeDateUtils::TIMEFORMAT ), 'H' ) ) {
		$output .= sprintf( '<select name="EventStartMeridian">%s</select>', $start_meridian );
	}
	return apply_filters( 'tribe_community_events_form_start_time_selector', $output, $event_id );
}

/**
 * Return form select fields for event end time.
 *
 * @param null|int $event_id
 * @return string time select HTML
 * @author Peter Chester
 * @since 3.1
 */
function tribe_community_events_form_end_time_selector( $event_id = null ) {

	$event_id = TribeEvents::postIdHelper( $event_id );
	$is_all_day = tribe_event_is_all_day( $event_id );
	$end_date = tribe_get_end_date( $event_id );

	$end_minutes = TribeEventsViewHelpers::getMinuteOptions( $end_date );
	$end_hours = TribeEventsViewHelpers::getHourOptions( $is_all_day == 'yes' ? null : $end_date );
	$end_meridian = TribeEventsViewHelpers::getMeridianOptions( $end_date );

	$output = '';
	$output .= sprintf( '<select name="EventEndHour">%s</select>', $end_hours );
	$output .= sprintf( '<select name="EventEndMinute">%s</select>', $end_minutes );
	if ( !strstr( get_option( 'time_format', TribeDateUtils::TIMEFORMAT ), 'H' ) ) {
		$output .= sprintf( '<select name="EventEndMeridian">%s</select>', $end_meridian );
	}
	return apply_filters( 'tribe_community_events_form_end_time_selector', $output, $event_id );
}

/**
 * Get the error or notice messages for a given form result.
 *
 * @return string error/notice HTML
 * @author Peter Chester
 * @since 3.1
 */
function tribe_community_events_get_messages() {
	return TribeCommunityEvents::instance()->outputMessage( null, false );
}

/********************** ORGANIZER TEMPLATE TAGS **********************/

/**
 * Echo Organizer edit form contents
 *
 * @param int|null $organizer_id (optional)
 * @author Peter Chester
 * @since 3.1
 */
function tribe_community_events_organizer_edit_form( $organizer_id = null ) {
	if ( $organizer_id ) {
		$post = get_post( $organizer_id );
		$saved = false;

		if( isset( $post->post_type ) && $post->post_type == TribeEvents::ORGANIZER_POST_TYPE ) {

			$postId = $post->ID;

			$saved = ( ( is_admin() && isset( $_GET['post'] ) && $_GET['post'] ) || ( !is_admin() && isset( $postId ) ) );

			// Generate all the inline variables that apply to Organizers
			$organizer_vars = TribeEvents::instance()->organizerTags;
			foreach ( $organizer_vars as $var ) {
				if ( $postId && $saved ) { //if there is a post AND the post has been saved at least once.
					$$var = get_post_meta( $postId, $var, true );
				}
			}
		}
		$meta_box_template = apply_filters('tribe_events_organizer_meta_box_template', '');
		if( !empty($meta_box_template) )
			include( $meta_box_template );
	}
}

/**
 * Organizer website url
 *
 * Returns the event Organizer Name with a url to their supplied website
 *
 * @param int|null $event_id (optional)
 * @return string
 * @author Peter Chester
 * @since 3.1
 */
if ( !function_exists( 'tribe_get_organizer_website_url' ) ) { // wrapped in if function exists to maintain compatibility with TEC 3.0.x - delete after moving to 3.1.x
	function tribe_get_organizer_website_url( $event_id = null ){
		$event_id = TribeEvents::postIdHelper( $event_id );
		$output = esc_url(tribe_get_event_meta( tribe_get_organizer_id( $event_id ), '_OrganizerWebsite', true ));
		return apply_filters( 'tribe_get_organizer_website_url', $output );
	}
}

/**
 * Echo Organizer select menu
 *
 * @param int|null $event_id (optional)
 * @author Peter Chester
 * @since 3.1
 */
function tribe_community_events_organizer_select_menu( $event_id = null ) {
	if ( !$event_id ) {
		global $post;
		if( isset( $post->post_type ) && $post->post_type == TribeEvents::POSTTYPE ) {
			$event_id = $post->ID;
		} elseif( isset( $post->post_type ) && $post->post_type == TribeEvents::ORGANIZER_POST_TYPE ) {
			return;
		}
	}
	do_action( 'tribe_organizer_table_top', $event_id );
}

/**
 * Test to see if this is the Organizer edit screen
 *
 * @param int|null $organizer_id (optional)
 * @return bool
 * @author Peter Chester
 * @since 3.1
 */
function tribe_community_events_is_organizer_edit_screen( $organizer_id = null ) {
	$organizer_id = TribeEvents::postIdHelper( $organizer_id );
	$is_organizer = ( $organizer_id ) ? TribeEvents::instance()->isOrganizer( $organizer_id ) : false;
	return apply_filters( 'tribe_is_organizer', $is_organizer, $organizer_id );
}

/**
 * Return Organizer Description
 *
 * @param int|null $organizer_id (optional)
 * @return string
 * @author Peter Chester
 * @since 3.1
 */
function tribe_community_events_get_organizer_description( $organizer_id = null ) {
	$organizer_id = tribe_get_organizer_id( $organizer_id );
	$description = ( $organizer_id > 0 ) ? get_post( $organizer_id )->post_content : null;
	return apply_filters( 'tribe_get_organizer_description', $description );
}

/********************** VENUE TEMPLATE TAGS **********************/

/**
 * Echo Venue edit form contents
 *
 * @param int|null $venue_id (optional)
 * @author Peter Chester
 * @since 3.1
 */
function tribe_community_events_venue_edit_form( $venue_id = null ) {
	if ( $venue_id ) {
		$post = get_post( $venue_id );
		$saved = false;

		if( isset( $post->post_type ) && $post->post_type == TribeEvents::VENUE_POST_TYPE ) {

			$postId = $post->ID;

			$saved = ( ( is_admin() && isset( $_GET['post'] ) && $_GET['post'] ) || ( !is_admin() && isset( $postId ) ) );

			// Generate all the inline variables that apply to Venues
			$venue_vars = TribeEvents::instance()->venueTags;
			foreach ( $venue_vars as $var ) {
				if ( $postId && $saved ) { //if there is a post AND the post has been saved at least once.
					$$var = get_post_meta( $postId, $var, true );
				}
			}
		}
		$meta_box_template = apply_filters('tribe_events_venue_meta_box_template', '');
		if( !empty( $meta_box_template ) )
			include( $meta_box_template );
	}
}

/**
 * Echo Venue select menu
 *
 * @param int|null $event_id (optional)
 * @author Peter Chester
 * @since 3.1
 */
function tribe_community_events_venue_select_menu( $event_id = null ) {
	if ( !$event_id ) {
		global $post;
		if( isset( $post->post_type ) && $post->post_type == TribeEvents::POSTTYPE ) {
			$event_id = $post->ID;
		} elseif( isset( $post->post_type ) && $post->post_type == TribeEvents::VENUE_POST_TYPE ) {
			return;
		}
	}
	do_action( 'tribe_venue_table_top', $event_id );
}

/**
 * Test to see if this is the Venue edit screen
 *
 * @param int|null $venue_id (optional)
 * @return bool
 * @author Peter Chester
 * @since 3.1
 */
function tribe_community_events_is_venue_edit_screen( $venue_id = null ) {
	$venue_id = TribeEvents::postIdHelper( $venue_id );
	return ( tribe_is_venue( $venue_id ) );
}

/**
 * Return Venue Description
 *
 * @param int|null $venue_id (optional)
 * @return string
 * @author Peter Chester
 * @since 3.1
 */
function tribe_community_events_get_venue_description( $venue_id = null ) {
	$venue_id = tribe_get_venue_id( $venue_id );
	$description = ( $venue_id > 0 ) ? get_post( $venue_id )->post_content : null;
	return apply_filters( 'tribe_get_venue_description', $description );
}


/**
 * Event Website URL
 *
 * @param null|object|int $event
 * @return string The event's website URL
 * @deprecated use tribe_get_event_website_url()
 *
 * This function was added for compatibility reasons. It can be removed once
 * tribe_get_event_website_url() is in the required version of core
 *  -- jbrinley (2013-09-16)
 */
function tribe_community_get_event_website_url( $event = null ) {
	if ( function_exists('tribe_get_event_website_url') ) {
		return tribe_get_event_website_url();
	}
	$post_id = ( is_object($event) && isset($event->tribe_is_event) && $event->tribe_is_event ) ? $event->ID : $event;
	$post_id = ( !empty($post_id) || empty($GLOBALS['post']) ) ? $post_id : get_the_ID();
	$url = tribe_get_event_meta( $post_id, '_EventURL', true );
	if ( !empty($url) ) {
		$parseUrl = parse_url($url);
		if (empty($parseUrl['scheme'])) {
			$url = "http://$url";
		}
	}
	return apply_filters( 'tribe_get_event_website_url', $url, $post_id );
}

/**
 * Get the logout URL
 *
 * @return string The logout URL with appropriate redirect for the current user
 * @since 3.1
 */
function tribe_community_events_logout_url() {
	$community = TribeCommunityEvents::instance();
	return $community->logout_url();
}

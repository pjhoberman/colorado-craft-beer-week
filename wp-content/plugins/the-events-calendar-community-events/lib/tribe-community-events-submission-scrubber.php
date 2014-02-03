<?php

/**
 * Class TribeCommunityEvents_SubmissionScrubber
 *
 * Scrubs inappropriate data out of a submitted event
 */
class TribeCommunityEvents_SubmissionScrubber {
	protected $submission = array();
	protected $allowed_fields = array( // filter these with 'tribe_events_community_allowed_event_fields'
		'ID',
		'post_content',
		'post_title',
		'tax_input',
		'EventAllDay',
		'EventStartDate',
		'EventStartHour',
		'EventStartMinute',
		'EventStartMeridian',
		'EventEndDate',
		'EventEndHour',
		'EventEndMinute',
		'EventEndMeridian',
		'EventShowMapLink',
		'EventShowMap',
		'EventURL',
		'EventCurrencySymbol',
		'EventCost',
		'Venue',
		'Organizer',
		'is_recurring',
		'recurrence_action',
		'recurrence',
	);

	protected $allowed_venue_fields = array( // filter these with 'tribe_events_community_allowed_venue_fields'
		'VenueID',
		'Venue',
		'Address',
		'City',
		'Country',
		'Province',
		'State',
		'Zip',
		'Phone',
	);

	protected $allowed_organizer_fields = array( // filter these with 'tribe_events_community_allowed_organizer_fields'
		'OrganizerID',
		'Organizer',
		'Phone',
		'Website',
		'Email'
	);

	protected $filters = NULL;

	public function __construct( array $submission ) {
		$this->submission = $submission;
	}

	/**
	 * Remove data from the submission that shouldn't be there
	 *
	 * @return array The cleaned submission
	 */
	public function scrub() {
		add_filter( 'wp_kses_allowed_html', array( $this, 'filter_allowed_html_tags' ), 10, 2 );

		$this->fix_post_content_key();
		$this->set_venue();
		$this->set_organizer();

		$this->remove_unexpected_fields();
		$this->filter_field_contents();

		// These should not be user-submitted
		$this->set_post_type();
		$this->set_post_author();

		remove_filter( 'wp_kses_allowed_html', array( $this, 'filter_allowed_html_tags' ), 10, 2 );


		$this->submission = apply_filters( 'tribe_events_community_sanitize_submission', $this->submission );
		return $this->submission;
	}

	protected function fix_post_content_key() {
		$this->submission['post_content'] = $this->submission['tcepostcontent'];
		unset($this->submission['tcepostcontent']);
	}

	public function filter_allowed_html_tags( $tags, $context ) {
		unset($tags['form']);
		unset($tags['button']);
		unset($tags['img']);
		$tags = apply_filters( 'tribe_events_community_allowed_tags', $tags );
		return $tags;
	}

	protected function set_post_type() {
		$this->submission['post_type'] = TribeEvents::POSTTYPE;
	}

	protected function set_post_author() {
		$this->submission['post_author'] = get_current_user_id();
	}

	protected function set_venue() {
		$this->submission['Venue'] = stripslashes_deep( $this->submission['venue'] );
		$this->submission['Venue'] = $this->filter_venue_data($this->submission['Venue']);
		unset( $this->submission['venue'] );
	}

	protected function filter_venue_data( $venue_data ) {
		if( !empty($venue_data['VenueID']) ) {
			$venue_data = array('VenueID' => intval($venue_data['VenueID']));
		} else {
			foreach ( array('Venue', 'Address', 'City', 'Country', 'Province', 'State', 'Zip', 'Phone' ) as $field ) {
				if ( isset( $venue_data[$field]) ) {
					$venue_data[$field] = $this->filter_string( $venue_data[$field] );
				}
			}
		}
		return $venue_data;
	}

	protected function set_organizer() {
		$this->submission['Organizer'] = stripslashes_deep( $this->submission['organizer'] );
		$this->submission['Organizer'] = $this->filter_organizer_data($this->submission['Organizer']);
		unset( $this->submission['organizer'] );
	}

	protected function filter_organizer_data( $organizer_data ) {
		if( !empty($organizer_data['OrganizerID']) ) {
			$organizer_data = array('OrganizerID' => intval($organizer_data['OrganizerID']));
		} else {
			foreach ( array('Organizer', 'Phone', 'Website', 'Email' ) as $field ) {
				if ( isset( $organizer_data[$field]) ) {
					$organizer_data[$field] = $this->filter_string( $organizer_data[$field] );
				}
			}
		}
		return $organizer_data;
	}

	protected function remove_unexpected_fields() {
		$allowed_fields = $this->get_allowed_event_fields();

		foreach ( $this->submission as $key => $value ) {
			if ( !in_array($key, $allowed_fields) ) {
				unset($this->submission[$key]);
			}
		}

		if ( !empty($this->submission['Venue']) ) {
			$allowed_venue_fields = $this->get_allowed_venue_fields();
			foreach ( $this->submission['Venue'] as $key => $value ) {
				if ( !in_array($key, $allowed_venue_fields) ) {
					unset($this->submission['Venue'][$key]);
				}
			}
		}

		if ( !empty($this->submission['Organizer']) ) {
			$allowed_organizer_fields = $this->get_allowed_organzer_fields();
			foreach ( $this->submission['Organizer'] as $key => $value ) {
				if ( !in_array($key, $allowed_organizer_fields) ) {
					unset($this->submission['Organizer'][$key]);
				}
			}
		}
	}

	protected function get_allowed_event_fields() {
		$allowed_fields = array_merge($this->allowed_fields, $this->get_custom_field_keys());
		return apply_filters( 'tribe_events_community_allowed_event_fields', $allowed_fields );
	}

	protected function get_allowed_venue_fields() {
		return apply_filters( 'tribe_events_community_allowed_venue_fields', $this->allowed_venue_fields );
	}

	protected function get_allowed_organzer_fields() {
		return apply_filters( 'tribe_events_community_allowed_organizer_fields', $this->allowed_organizer_fields );
	}

	protected function get_custom_field_keys() {
		$customFields = tribe_get_option('custom-fields');
		if ( empty( $customFields ) || !is_array( $customFields ) ) {
			return array();
		}
		$keys = array();
		foreach ( $customFields as $field ) {
			$keys[] = $field['name'];
		}
		return $keys;
	}

	protected function filter_field_contents() {
		foreach ( array('post_content', 'post_title', 'EventURL', 'EventCurrencySymbol', 'EventCost' ) as $field ) {
			if ( isset( $this->submission[$field]) ) {
				$this->submission[$field] = $this->filter_string( $this->submission[$field] );
			}
		}
	}

	protected function get_content_filters() {
		if ( !isset( $this->filters ) ) {
			$this->filters = array();
			$user_id = is_user_logged_in() ? wp_get_current_user() : false;
			// These filters are a booleans to determine whether to strip bad stuff. The added arguments are the current user's id and the event id (false for new events, obviously).
			if( apply_filters( 'tribe_events_community_submission_should_strip_html', true, $user_id, $this->submission['ID'] ) ) {
				$this->filters[] = 'wp_kses_post';
			}
			if ( apply_filters( 'tribe_events_community_submission_should_strip_shortcodes', true, $user_id, $this->submission['ID'] ) ) {
				$this->filters[] = 'strip_shortcodes';
			}
		}
		return $this->filters;
	}

	protected function filter_string( $string ) {
		foreach ( $this->get_content_filters() as $callback ) {
			$string = call_user_func( $callback, $string );
		}
		return $string;
	}
}
 
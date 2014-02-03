<?php

/**
 * Class TribeCommunityEvents_OrganizerSubmissionScrubber
 */
class TribeCommunityEvents_OrganizerSubmissionScrubber extends TribeCommunityEvents_SubmissionScrubber {
	protected $allowed_fields = array( // filter these with 'tribe_events_community_allowed_event_fields'
		'post_content',
		'post_title',
		'organizer',
	);

	public function __construct( $submission ){
		parent::__construct($submission);
	}

	/**
	 * The following block of code is taken from the events calendar code that it uses to prepare the data of venue for saving.
	 */
	protected function set_venue() {
		return; // nothing to do here
	}

	protected function set_post_type() {
		$this->submission['post_type'] = TribeEvents::ORGANIZER_POST_TYPE;
	}

	protected function set_organizer() {
		$this->submission['organizer'] = stripslashes_deep( $this->submission['organizer'] );
		$this->submission['organizer'] = $this->filter_organizer_data($this->submission['organizer']);
	}
}
 
<?php

/**
 * Class TribeCommunityEvents_Schema
 *
 * This class is responsible for making one time updates to the database.
 * E.g., adding/deleting options, setting capabilities for roles, etc.
 * Kind of like an activation hook, but it can also run when code is
 * updated (by incrementing the version constant), and it works
 * with multisite.
 */
class TribeCommunityEvents_Schema {
	const VERSION = 3;
	private $db_version = 0;

	private function __construct() {
		$this->db_version = get_option(__CLASS__.'schema_version', 0);
	}

	/**
	 * @return bool
	 */
	private function update_required() {
		if ( $this->db_version < self::VERSION ) {
			return TRUE;
		}
		return FALSE;
	}

	private function set_db_version() {
		update_option(__CLASS__.'schema_version', self::VERSION);
		$this->db_version = self::VERSION;
	}

	private function do_updates() {
		if ( $this->db_version < 3 ) {
			$this->update_3();
		}
		$this->set_db_version();
		flush_rewrite_rules();
	}

	/**
	 * earlier versions had given edit_tribe_events caps to subscribers
	 * these caps are no longer necessary
	 * @return void
	 */
	private function update_3() {
		$role = get_role( 'subscriber' );
		if ( $role ) {
			$role->remove_cap( 'edit_tribe_event' );
			$role->remove_cap( 'edit_tribe_events' );
		}
	}

	public static function init() {
		$updater = new self();
		if ( $updater->update_required() ) {
			$updater->do_updates();
		}
	}
}

<?php
/**
 * Templating functionality for Tribe Events Calendar
 */

// don't load directly
if ( !defined('ABSPATH') )
	die('-1');

if ( !class_exists('TribeCommunityEventsTemplates') ) {

	/**
	 * Handle views and template files.
	 */
	class TribeCommunityEventsTemplates {

		function __construct() {
			add_filter( 'tribe_events_template_paths', array( $this, 'add_community_template_paths' ) );
		}

		/**
		 * Filter template paths to add the community plugin to the queue
		 *
		 * @param array $paths
		 * @return array $paths
		 * @author Peter Chester
		 * @since 3.1
		 */
		public function add_community_template_paths( $paths ) {
			$paths['community'] = TribeCommunityEvents::instance()->pluginPath;
			return $paths;
		}


		/********** Singleton **********/

		/**
		 * @var TribeCommunityEventsTemplates $instance
		 */
		protected static $instance;

		/**
		 * Static Singleton Factory Method
		 * @return TribeCommunityEventsTemplates
		 */
		public static function instance() {
			if (!isset(self::$instance)) {
				$className = __CLASS__;
				self::$instance = new $className;
			}
			return self::$instance;
		}

	}

}
?>
<?php
/**
 * Recurrence Dialog Box
 * This is used to add a recurrence dialog box when editing recurring user
 * submitted events.
 *
 * Override this template in your own theme by creating a file at
 * [your-theme]/tribe-events/community/modules/recurrence-dialog.php
 *
 * @package TribeCommunityEvents
 * @since  2.1
 * @author Modern Tribe Inc.
 *
 */
 
if ( !defined('ABSPATH') ) { die('-1'); }

$post_id = isset($tribe_event_id) ? $tribe_event_id : null;
$recStart = isset($recStart) ? $recStart : null;
$recPost = isset($recPost) ? $recPost : null; ?>

<div id="recurring-dialog" title="Saving Recurring Event" style="display: none;">
	<?php echo __( 'Which events do you wish to update?', 'tribe-events-community' ) .'<br/>'; ?>
</div>

<div id="deletion-dialog" title="<?php _e( 'Delete Recurring Event', 'tribe-events-community' ); ?>" style="display: none;" data-start="<?php $recStart; ?>" data-post="<?php $recPost; ?>">
	<?php echo __( 'Select your desired action', 'tribe-events-community' ) .'<br/>'; ?>
</div>
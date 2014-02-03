<?php
/**
 * Event Submission Form Taxonomy Block
 * Renders the taxonomy field in the submission form.
 *
 * Override this template in your own theme by creating a file at
 * [your-theme]/tribe-events/community/modules/taxonomy.php
 *
 * @package TribeCommunityEvents
 * @since  3.1
 * @author Modern Tribe Inc.
 *
 */

if ( !defined('ABSPATH') ) { die('-1'); }

?>

<?php
$event_cats = get_terms( TribeEvents::TAXONOMY, array( 'hide_empty' => false ) );
$currently_selected_category_ids = array();
if ( get_post() && get_the_ID() ) { // is there a current post?
	$currently_selected_category_ids = get_the_terms(get_the_ID(), TribeEvents::TAXONOMY);
	$currently_selected_category_ids = $currently_selected_category_ids?wp_list_pluck($currently_selected_category_ids, 'term_id'):array();
}
if ( empty($currently_selected_category_ids) && !empty($_POST['tax_input']['tribe_events_cat']) ) {
	$currently_selected_category_ids = $_POST['tax_input']['tribe_events_cat'];
}
if ( !empty( $event_cats ) ) { // only display categories if there are any.
	?>
	<!-- Event Categories -->
	<?php do_action( 'tribe_events_community_before_the_categories' ); ?>
	<div class="tribe-events-community-details eventForm bubble" id="event_taxonomy">
		<table class="tribe-community-event-info" cellspacing="0" cellpadding="0">
			<tr>
				<td colspan="2" class="tribe_sectionheader">
					<h4 class="event-time"><?php _e( 'Event Categories:', 'tribe-events-community' ); ?></h4>
				</td>
			</tr>
			<tr>
				<td><?php TribeCommunityEvents::instance()->formCategoryDropdown( null, $currently_selected_category_ids ); ?></td>
			</tr>
		</table><!-- .tribe-community-event-info -->
	</div><!-- .tribe-events-community-details -->
	<?php do_action( 'tribe_events_community_after_the_categories' ); ?>

<?php } ?>
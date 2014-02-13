<?php
/**
 * Event Submission Form
 * The wrapper template for the event submission form.
 *
 * Override this template in your own theme by creating a file at
 * [your-theme]/tribe-events/community/edit-event.php
 *
 * @package TribeCommunityEvents
 * @since  3.1
 * @author Modern Tribe Inc.
 *
 */

if ( !defined('ABSPATH') ) { die('-1'); } ?>

<?php tribe_get_template_part( 'community/modules/header-links' ); ?>

<?php do_action( 'tribe_events_community_form_before_template' ); ?>

<script type="text/javascript">
$(function() {
    "use strict";
    var help_text = {
        "Colorado Brewers Guild Fundraiser:": "Is your event a Colorado Brewers Guild fundraiser? If so, select 'yes' and we'll be in touch about further details. CBG Fundraiser events get special placement in the event listings.",
        "Ticketed event?:": "If your event needs tickets, Imbibe can host ticketing for you for free! Learn more at <a href='http://imbibedenver.com/ticketing'>imbibedenver.com/ticketing</a>.",
        "Ticket URL:": ""
    };
    for (i = 1;  i < $('#event-meta tr').length;  i++) {
        var $this_tr = $('#event-meta tr:eq(' + i + ')'),
            the_text = help_text[$.trim($this_tr.find('td:eq(0)').text())],
            true_text = the_text === undefined ? "" : the_text;

        $this_tr.append('<td><em>' + true_text + '</em></td>');
    }

    $('#event-categories label').each(function() {
        if ($.trim($(this).text()) === "Featured" || 
            $.trim($(this).text()) === "CBG Fundraiser") {
            $(this).parent('li').hide();
        }
    });

    $('#show_hidden_categories').click();

});

</script>

<form method="post" enctype="multipart/form-data">
	<p>Please fill out as much detail as you can about your event. Allow 48 hours for approval and posting. Any questions? Email Steve at manager@coloradobeer.org.</p>
	<?php wp_nonce_field( 'ecp_event_submission' ); ?>

	<!-- Event Title -->
	<?php do_action( 'tribe_events_community_before_the_event_title' ) ?>

	<div class="events-community-post-title">
		<?php // Validation
		$class = ( $_POST && empty( $event->post_title ) ) ? 'error' : ''; ?>
		<label for="post_title" class="<?php echo $class; ?>"><?php _e( 'Event Title:', 'tribe-events-community' ); ?><small class="req"><?php _e( '(required)', 'tribe-events-community' ); ?></small></label>
		<?php tribe_community_events_form_title(); ?>
	</div><!-- .events-community-post-title -->

	<?php do_action( 'tribe_events_community_after_the_event_title' ) ?>


	<!-- Event Description -->
	<?php do_action( 'tribe_events_community_before_the_content' ); ?>

	<div class="events-community-post-content">
		<?php // Validation
		$class = ( $_POST && empty($event->post_content ) ) ? 'error' : ''; ?>
		<label for="post_content" class="<?php echo $class; ?>"><?php _e( 'Event Description:', 'tribe-events-community' ); ?><small class="req"><?php _e( '(required)', 'tribe-events-community' ); ?></small></label>
		<?php tribe_community_events_form_content(); ?>
	</div><!-- .tribe-events-community-post-content -->

	<?php do_action( 'tribe_events_community_after_the_content' ); ?>


	<?php tribe_get_template_part( 'community/modules/taxonomy' ); ?>

	<?php tribe_get_template_part( 'community/modules/image' ); ?>

	<?php tribe_get_template_part( 'community/modules/datepickers' ); ?>

	<?php tribe_get_template_part( 'community/modules/venue' ); ?>

	<?php tribe_get_template_part( 'community/modules/organizer' ); ?>

	<?php tribe_get_template_part( 'community/modules/website' ); ?>

	<?php tribe_get_template_part( 'community/modules/custom' ); ?>

	<?php tribe_get_template_part( 'community/modules/cost' ); ?>

	<!-- Spam Control -->
	<?php TribeCommunityEvents::instance()->formSpamControl(); ?>

	<!-- Form Submit -->
	<?php do_action( 'tribe_events_community_before_form_submit' ); ?>
	<div class="tribe-events-community-footer">
		<input type="submit" id="post" class="button submit events-community-submit" value="<?php

			if( isset( $post_id ) && $post_id )
				echo apply_filters( 'tribe_ce_event_update_button_text', __( 'Update Event', 'tribe-events-community' ) );
			else
				echo apply_filters( 'tribe_ce_event_submit_button_text', __( 'Submit Event', 'tribe-events-community' ) );

			?>" name="community-event" />
	</div><!-- .tribe-events-community-footer -->
	<?php do_action( 'tribe_events_community_after_form_submit' ); ?>

</form>
<?php do_action( 'tribe_events_community_form_after_template' ); ?>

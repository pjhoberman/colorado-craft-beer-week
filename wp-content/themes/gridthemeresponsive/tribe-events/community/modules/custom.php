<?php
/**
 * Event Submission Form Metabox For Custom Fields
 * This is used to add a metabox to the event submission form to allow for custom
 * field input for user submitted events.
 *
 * Override this template in your own theme by creating a file at
 * [your-theme]/tribe-events/community/modules/custom.php
 *
 * @package TribeCommunityEvents
 * @since  2.1
 * @author Modern Tribe Inc.
 *
 */

if ( !defined('ABSPATH') ) { die('-1'); }

$customFields = tribe_get_option('custom-fields');

if ( empty( $customFields ) || !is_array( $customFields ) ) {
	return;
} ?>

<!-- Custom -->
<div class="tribe-events-community-details eventForm bubble" id="event_custom">
	<table id="event-meta" class="tribe-community-event-info">

		<tbody>

			<tr>
				<td colspan="2" class="tribe_sectionheader">
					<h4><?php _e( 'Additional Fields', 'tribe-events-community' ); ?></h4>
				</td>
			</tr><!-- .snp-sectionheader -->

			<?php foreach ( $customFields as $customField ) :

				$val = '';
				global $post;
				if( isset( $post->ID ) && get_post_meta( get_the_id(), $customField['name'], true ) )
					$val = get_post_meta( get_the_id(), $customField['name'], true );

				$field_id = 'tribe_custom_'.sanitize_title( $customField['label'] );
				?>
				<tr>
					<td>
						<label for="<?php echo $field_id; ?>">
							<?php echo esc_html( stripslashes( $customField['label'] ) ); ?>:
						</label>
					</td>
					<td>
						<?php $options = explode( "\n", $customField['values'] ); ?>
						<?php if( $customField['type'] == 'text' ): ?>
							<input type="text" id="<?php echo $field_id; ?>" name="<?php echo esc_attr( $customField['name'] ); ?>" value="<?php echo esc_attr( $val ); ?>"/>
						<?php elseif ( $customField['type'] == 'url' ): ?>
							<input type="text" id="<?php echo $field_id; ?>" name="<?php echo esc_attr( $customField['name'] ); ?>" value="<?php echo esc_attr( $val ); ?>"/>
						<?php elseif ( $customField['type'] == 'radio' ) : ?>
							<?php foreach ( $options as $option ) : ?>
								<div>
									<label>
										<input type="radio" name="<?php echo esc_attr( stripslashes( $customField['name'] ) ); ?>" value="<?php echo esc_attr( $option ); ?>" <?php checked( trim( $val ), trim( $option ) ); ?>/>
							<?php echo esc_html( stripslashes( $option ) ); ?>
									</label>
								</div>
							<?php endforeach ?>
						<?php elseif ( $customField['type'] == 'checkbox' ) : ?>
							<?php foreach ( $options as $option ) : ?>
								<?php $values = !is_array( $val ) ? explode( '|', $val ) : $val; ?>
								<div>
									<label>
										<input type="checkbox" value="<?php echo esc_attr( trim( $option ) ); ?>" <?php checked( in_array( trim( $option ), $values ) ) ?> name="<?php echo esc_attr( stripslashes( $customField['name'] ) ); ?>[]"/>
										<?php echo esc_html( stripslashes( $option ) ); ?>
									</label>
								</div>
							<?php endforeach ?>
						<?php elseif( $customField['type'] == 'dropdown' ): ?>
							<select name="<?php echo $customField['name']; ?>">
								<?php $options = explode( "\n", $customField['values'] ); ?>
								<?php foreach ( $options as $option ): ?>
									<option value="<?php echo esc_attr( $option ); ?>" <?php selected( trim( $val ), trim( $option ) ); ?>><?php echo esc_html( stripslashes( $option ) ); ?></option>
								<?php endforeach ?>
							</select>
						<?php elseif ( $customField['type'] == 'textarea') : ?>
							<textarea id="<?php echo $field_id; ?>" name="<?php echo esc_attr( $customField['name'] ); ?>"><?php echo esc_textarea( stripslashes( $val ) ); ?></textarea>
						<?php endif; ?>
					</td>
				</tr>
			<?php endforeach; ?>

		</tbody>

	</table>
</div><!-- #event-meta -->

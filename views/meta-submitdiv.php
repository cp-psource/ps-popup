<?php
/**
 * Metabox "submitdiv"
 *
 * Used in class-popup-admin.php
 * Available variables: $popup
 */
$delete_url = isset($post) ? get_delete_post_link($post->ID) : '';
$duplicate_url = esc_url_raw(add_query_arg('do', 'duplicate'));

?>
<div class="submitbox" id="submitpost">
	<?php /* Save/Deactivate/Preview */ ?>
	<div id="minor-publishing">
		<?php // Hidden submit button early on so that the browser chooses the right button when the form is submitted with the Return key ?>
		<div style="display:none;">
			<?php submit_button(__('Speichern', 'popover'), 'button', 'save', false); ?>
		</div>

		<div id="minor-publishing-actions" class="non-sticky">
			<div class="status">
				<div class="status-switch">
					<input type="checkbox"
						name="po_active"
						id="po-status"
						<?php checked(isset($popup) ? $popup->status : '', 'active'); ?>/>
					<label class="status-box" for="po-status">
						<span class="indicator"></span>
						<span class="label-active"><?php _e('Status: <strong>Aktiv</strong>', 'popover'); ?></span>
						<span class="label-inactive"><?php _e('Status: Inaktiv', 'popover'); ?></span>
					</label>
				</div>
			</div>

			<div class="preview-action">
				<button type="button" class="preview button">
					<i class="dashicons dashicons-visibility"></i>
					<?php _e('Vorschau PopUp', 'popover'); ?>
				</button>
			</div>
			<div class="clear"></div>
		</div>
	</div>

	<?php /* *** Trash/Save/Activate *** */ ?>
	<div id="major-publishing-actions" class="non-sticky">
		<div class="delete-action">
		<?php if (isset($post) && current_user_can('delete_post', $post->ID)) : ?>
			<a class="submitdelete deletion" href="<?php echo esc_url($delete_url); ?>">
				<?php _e('Ab in den Müll', 'popover'); ?>
			</a>
		<?php endif; ?>
		</div>

		<div class="publishing-action">
			<span class="spinner"></span>
			<?php if (isset($popup) && !empty($popup->id)) : ?>
				<a href="<?php echo esc_url($duplicate_url); ?>" class="do-duplicate">
					<?php _e('Duplizieren', 'popover'); ?>
				</a>
			<?php endif; ?>
			<input type="hidden" name="po-action" value="save" />
			<button class="button-primary" id="publish" name="publish">
				<?php _e('Speichern', 'popover'); ?>
			</button>
		</div>

		<div class="clear"></div>
	</div>

	<?php /* *** Sticky form: Trash/Preview/Save/Activate *** */ ?>
	<div class="sticky-actions" style="display:none">
		<div class="delete-action">
		<?php if (isset($post) && current_user_can('delete_post', $post->ID)) : ?>
			<a class="submitdelete deletion" href="<?php echo esc_url($delete_url); ?>">
				<?php _e('Ab in den Müll', 'popover'); ?>
			</a>
		<?php endif; ?>
		</div>

		<div class="publishing-action">
			<input type="hidden" name="po-action" value="save" />
			<button class="button-primary" id="publish" name="publish">
				<?php _e('Speichern', 'popover'); ?>
			</button>
		</div>

		<div class="preview-action">
			<button type="button" class="preview button">
				<i class="dashicons dashicons-visibility"></i>
				<?php _e('Vorschau PopUp', 'popover'); ?>
			</button>
		</div>

		<div class "duplicate-action">
			<span class="spinner"></span>
			<?php if (isset($popup) && !empty($popup->id)) : ?>
				<a href="<?php echo esc_url($duplicate_url); ?>" class="do-duplicate">
					<?php _e('Duplizieren', 'popover'); ?>
				</a>
			<?php endif; ?>
		</div>

		<div class="clear"></div>
	</div>
</div>

<!-- -------------- -->
<!-- Feedback Form  -->
<!-- -------------- -->

<div id="feedback" class="overlay" style="display:none;background-image:url(<?php echo WsiCommons::getURL(); ?>/style/petrol.png);color:#fff;width:500px;margin:40px;">
	<fieldset style="border:1px solid black; padding:20px 20px 5px 20px; display:inline;">
		<legend style="display:block;font-size:1.17em;font-weight:bold;margin:1em 0;margin-top:22px;" >
			&nbsp;<?php echo __('Feedback','wp-splash-image'); ?>&nbsp;
		</legend>
		<form method="post" id="feedback_form" action="<?php echo $_SERVER ['REQUEST_URI']?>">
			<?php wp_nonce_field('feedback','nonce_feedback_field'); ?>
			<input type="hidden" name="action" value="feedback" />
			<table>
				<tr>
					<td><?php echo __('Your Email:','wp-splash-image'); ?></td>
					<td><input type="email" required="required" name="feedback_email" size="50" /></td>
				</tr>
				<tr>
					<td><?php echo __('Message:','wp-splash-image'); ?></td>
					<td><textarea name="feedback_message" required="required" rows="10" cols="40"></textarea></td>
				</tr>
				<tr>
					<td><?php echo __('Send infos:','wp-splash-image'); ?><br /></td>
					<td>
						<input type="checkbox" name="feedback_sendInfos" checked="checked" />
						<?php echo __('(to reproduce the error locally and help me to fix the problem)','wp-splash-image'); ?>
					</td>
				</tr>
			</table>
			<p class="submit">
				<input type="submit" value="<?php echo __('Send Feedback','wp-splash-image'); ?>" />
			</p>
		</form>
	</fieldset>
</div>
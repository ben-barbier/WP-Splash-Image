<div id="tab_HTML" class="tab">
	<table>
		<tr id="box_html" class="box_type">
			<td>
                <input type="radio"
                       id="radio_html"
                       name="wsi_type"
                       class="with-gap"
                       value="html" <?php if($siBean->getWsi_type()=="html") echo('checked="checked"') ?> />
                <label for="radio_html"></label>
            </td>
			<td style="padding: 0;">
				<div>
				<?php if ( current_user_can('edit_posts') ) : ?>
					<?php wp_editor($siBean->getWsi_html(), 'wsi_html'); ?>
				<?php endif; ?>
				</div>
			</td>
		</tr>
	</table>
</div> 
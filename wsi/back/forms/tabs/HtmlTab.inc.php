<div id="tab_HTML">
	<table>
		<tr id="box_html" class="box_type" style="height:220px;">
			<td><input type="radio" id="radio_html" name="wsi_type" value="html" <?php if($siBean->getWsi_type()=="html") echo('checked="checked"') ?> /></td>
			<td style="padding:15px;width:590px;">
				<div style="background-color:#FFFFFF;padding:15px;">
				<?php if ( current_user_can('edit_posts') ) : ?>
					<?php wp_editor($siBean->getWsi_html(), 'wsi_html'); ?>
				<?php endif; ?>
				</div>
			</td>
		</tr>
	</table>
</div> 
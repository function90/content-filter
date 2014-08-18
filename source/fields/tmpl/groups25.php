<?php
/**
 * @package 	Plugin Content Filter for Joomla! 3.X
 * @version 	0.0.1
 * @author 		Function90.com
 * @copyright 	C) 2013- Function90.com
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
**/
defined('_JEXEC') or die;
$counter = 0;
?>

	<?php if(!empty($this->value)) : ?>
	<?php foreach ($this->value as $values):?>
		<?php  $values = is_array($values) ? (object)$values : $values;?>
		<?php if(empty($values->token)) : ?>
			<?php continue;?>
		<?php endif;?>
		<li>
			<label><?php echo JText::_('PLG_CONTENT_F90FILTER_ENTER_TOKEN_GROUP_NAME');?></label>
			<input type="text" name="<?php echo $this->name;?>[<?php echo $counter;?>][token]" value="<?php echo $values->token;?>"></input>
		</li>
		<li>
			<label><?php echo JText::_('PLG_CONTENT_F90FILTER_SELECT_USERGROUP');?></label>
			<select name="<?php echo $this->name;?>[<?php echo $counter;?>][groups][]" multiple="multiple">
				<?php foreach ($groups as $group) : ?>
					<option value="<?php echo $group->id;?>" <?php echo in_array($group->id, $values->groups) ? 'selected="selected"' : '';?> ><?php echo $group->title;?></option>
				<?php endforeach;?>
			</select>
		<li>
		
		<li class="clr"></li><hr>
		<?php $counter++;?>
	<?php endforeach;?>
	<?php endif; ?>


		<li>
			<label><?php echo JText::_('PLG_CONTENT_F90FILTER_ENTER_TOKEN_GROUP_NAME');?></label>
			<input type="text" placeholder="<?php echo JText::_('PLG_CONTENT_F90FILTER_ENTER_TOKEN_GROUP_NAME');?>" name="<?php echo $this->name;?>[<?php echo $counter;?>][token]"></input>
		</li>
		<li>
			<label><?php echo JText::_('PLG_CONTENT_F90FILTER_SELECT_USERGROUP');?></label>
			<select name="<?php echo $this->name;?>[<?php echo $counter;?>][groups][]" multiple="multiple">
			<?php foreach ($groups as $group) : ?>
				<option value="<?php echo $group->id;?>"><?php echo $group->title;?></option>
			<?php endforeach;?>
			</select>
		</li>

<li>
	<button class="btn btn-small btn-success" onclick=" Joomla.submitbutton('plugin.apply'); return false;" href="#">
		<i class="icon-new icon-white"></i>
		<?php echo JText::_('PLG_CONTENT_F90FILTER_ADD_NEW');?>
	</button>
<li>

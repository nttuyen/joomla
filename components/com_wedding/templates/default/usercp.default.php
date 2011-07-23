<?php
/**
 * components/com_wedding/views/profile/tmpl/default.php
 * @author 		: Phạm Văn An
 * @version 	: 1.0
*/
 
// no direct access 
defined( '_JEXEC' ) or die( 'Restricted access' );
if($this->juser->guest)
{
	echo 'Your must login to see this page';
	return ;
}
$itemId = JRequest::getInt('Itemid');
$document = & JFactory::getDocument();
?>
<fieldset class="list-fieldset">
	<legend>Xem đám cưới của 2 bạn</legend>
	<table>
		<tr>
			<td class="key">Website</td>
			<td>
				<a href="<?php echo JRoute::_('index.php?option=com_wedding&view=profile');?>">
					<?php echo JRoute::_(JURI::base().'index.php?option=com_wedding&view=profile');?>
				</a>
			</td>
		</tr>
	</table>
</fieldset>
<form method="post" action="index.php">
	<table class="list-table">
		<thead>
			<tr>
				<th>Tính năng</th>
				<th>Ẩn/Hiện</th>
				<th>Đổi tên</th>
				<th>Thứ tự</th>
				<th>Mật khẩu</th>
			</tr>
		</thead>
		<tbody>
	<?php
	if($this->apps)
	{
		$i = 0;
		foreach ($this->apps as $application)
		{
			if($application->app_show===0 || $application->app_show==='0')
			{
				$hide_option = ' selected="selected"';
				$show_option = '';
			}
			else
			{
				$hide_option = '';
				$show_option = ' selected="selected"';
			}
			$title = empty($application->app_title) ? $application->title : $application->app_title;
	?>
			<tr class="row<?php echo $i%2;?>">
				<td>
					<?php echo $application->title;?>
				</td>
				<td class="center">
					<select class="inputbox" name="app_show[<?php echo $application->id;?>]">
						<option value="1"<?php echo $show_option;?>>Hiện</option>
						<option value="0"<?php echo $hide_option;?>>Ẩn</option>
					</select>
				</td>
				<td class="center">
					<input type="text" name="title[<?php echo $application->id;?>]" class="inputbox" value="<?php echo $title;?>" />
				</td>
				<td class="center">
					<input type="text" name="order[<?php echo $application->id;?>]" class="order inputbox" size="3 " value="<?php echo $i+1;?>" />
				</td>
				<td class="center">
					<input type="password" name="password[<?php echo $application->id;?>]" class="inputbox" value="<?php echo $application->password;?>" />
				</td>
			</tr>
	<?php
			$i++;
		}
	}
	?>
			<tr>
				<td class="center" colspan="5">
					<input type="submit" value="Ghi lại" />
				</td>
			</tr>
		</tbody>
		<tfoot></tfoot>
	</table>
	<input type="hidden" name="option" value="com_wedding" />
	<input type="hidden" name="view" value="usercp" />
	<input type="hidden" name="task" value="save" />
	<input type="hidden" name="Itemid" value="<?php echo $itemId;?>" />
</form>
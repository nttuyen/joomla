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
$document = & JFactory::getDocument();
$Itemid = JRequest::getInt('Itemid');
?>

<form name="frmSetting" id="frmSetting" method="post" action="index.php">
	<fieldset class="list-fieldset">
		<legend>Thông tin thiết lập chung</legend>
		<table>
			<tr>
				<td width="65%">Đặt bộ đếm trên website</td>
				<td class="center">
					<input class="inputbox" type="radio" name="show_counter" id="sc1" value="1"<?php if($this->cuser && $this->cuser->show_counter) echo ' checked="checked"';?> />
					<label for="sc1">Có</label>&nbsp;&nbsp;
					<input class="inputbox" type="radio" name="show_counter" id="sc0" value="0"<?php if(!$this->cuser || !$this->cuser->show_counter) echo ' checked="checked"';?> />
					<label for="sc0">Không</label>
				</td>
			</tr>
			<tr>
				<td>Đăng ký nhận tin tức và thông báo về tính năng mới từ HANHPHUC</td>
				<td class="center">
					<input class="inputbox" type="radio" name="email_subscribe" id="es1" value="1"<?php if(!$this->cuser || $this->cuser->email_subscribe) echo ' checked="checked"';?> />
					<label for="es1">Có</label>&nbsp;&nbsp;
					<input class="inputbox" type="radio" name="email_subscribe" id="es0" value="0"<?php if($this->cuser && !$this->cuser->email_subscribe) echo ' checked="checked"';?> />
					<label for="es0">Không</label>
				</td>
			</tr>
			<tr>
				<td>Thông báo qua email khi có lời chúc/ý kiến mới (Áp dụng cho: Nhật ký-Blog, Lưu bút, Album ảnh)</td>
				<td class="center">
					<input class="inputbox" type="radio" name="email_notify" id="en1" value="1"<?php if(!$this->cuser || $this->cuser->email_notify) echo ' checked="checked"';?> />
					<label for="en1">Có</label>&nbsp;&nbsp;
					<input class="inputbox" type="radio" name="email_notify" id="en0" value="0"<?php if($this->cuser && !$this->cuser->email_notify) echo ' checked="checked"';?> />
					<label for="en0">Không</label>
				</td>
			</tr>
			<tr>
				<td>Kiểm tra lời chúc/ý kiến trước khi cho phép hiển thị (Áp dụng cho: Nhật ký-Blog, Lưu bút, Album ảnh)</td>
				<td class="center">
					<input class="inputbox" type="radio" name="pre_check" id="pc1" value="1"<?php if(!$this->cuser || $this->cuser->pre_check) echo ' checked="checked"';?> />
					<label for="pc1">Có</label>&nbsp;&nbsp;
					<input class="inputbox" type="radio" name="pre_check" id="pc0" value="0"<?php if($this->cuser && !$this->cuser->pre_check) echo ' checked="checked"';?> />
					<label for="pc0">Không</label>
				</td>
			</tr>
			<tr>
				<td class="center" colspan="2"><input class="inputbox" type="submit" value="Ghi Lại" /></td>
			</tr>
		</table>
	</fieldset>
	<input type="hidden" name="Itemid" value="<?php echo $Itemid;?>" />
	<input type="hidden" name="option" value="com_wedding" />
	<input type="hidden" name="view" value="profile" />
	<input type="hidden" name="task" value="savesetting" />
</form>

<form name="frmUser" id="frmUser" method="post" action="index.php">
	<fieldset class="list-fieldset">
		<legend>Thông tin tài khoản</legend>
		<table>
			<tr>
				<td width="25%">Tên</td>
				<td>
					<?php echo $this->juser->username;?>
				</td>
			</tr>
			<tr>
				<td>Gói dịch vụ đang sử dụng</td>
				<td><?php if($this->cuser->type==1) echo 'Gói nâng cao'; else echo 'Miễn phí';?></td>
			</tr>
			<tr>
				<td>Địa chỉ website</td>
				<td>
					<a href="<?php echo JRoute::_(JURI::base().'index.php?option=com_wedding&view=home&user='.$this->juser->username.'&tmpl=component');?>">
						<?php echo JRoute::_(JURI::base().'index.php?option=com_wedding&view=home&user='.$this->juser->username.'&tmpl=component');?>
					</a>
				</td>
			</tr>
		</table>
	</fieldset>
	<input type="hidden" name="Itemid" value="<?php echo $Itemid;?>" />
	<input type="hidden" name="option" value="com_wedding" />
	<input type="hidden" name="view" value="profile" />
	<input type="hidden" name="task" value="savepassword" />
</form>

<form name="frmInfo" id="frmInfo" method="post" action="index.php" enctype="multipart/form-data">
	<fieldset class="list-fieldset">
		<legend>Thông tin cá nhân</legend>
		<table>
			<tr>
				<td>Avatar</td>
				<td>
				<?php if(strlen($this->cuser->avatar) && file_exists($this->cuser->avatar)) { ?>
					<img src="<?php echo $this->cuser->avatar;?>" /><br/>
				<?php } else { ?>
					<img src="images/wedding/avatar/no_avatar.jpg" /><br/>
				<?php } ?>
					<input type="file" name="avatar" />
				</td>
			</tr>
			<tr>
				<td>Địa chỉ</td>
				<td>
					<input class="inputbox" type="text" name="address" value="<?php echo $this->cuser->address;?>" size="50" />
				</td>
			</tr>
			<tr>
				<td>Quốc Gia</td>
				<td>
					<input class="inputbox" type="text" name="country" value="<?php echo $this->cuser->country;?>" size="50" />
				</td>
			</tr>
			<tr>
				<td class="center" colspan="2"><input class="inputbox" type="submit" value="Ghi Lại" /></td>
			</tr>
		</table>
	</fieldset>
	<input type="hidden" name="Itemid" value="<?php echo $Itemid;?>" />
	<input type="hidden" name="option" value="com_wedding" />
	<input type="hidden" name="view" value="profile" />
	<input type="hidden" name="task" value="saveinfo" />
</form>

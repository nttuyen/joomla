<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	</head>
	<body>
		<form name="frmAuth" id="frmAuth" method="post" action="<?php echo JURI::base();?>index.php">
			<input type="hidden" name="loginview" value="<?php echo $this->view;?>" />
			<input type="hidden" name="url" value="<?php echo base64_encode($this->uri);?>" />
			<input type="hidden" name="profile_id" value="<?php echo $this->profile_id;?>" />
			<input type="hidden" name="app_id" value="<?php echo $this->app_id;?>" />
			<input type="hidden" name="option" value="com_wedding" />
			<input type="hidden" name="task" value="authlogin" />
			<input type="hidden" name="password" value="" />
		</form>
		<script type="text/javascript">
			var pwstr = prompt("Hãy nhập mật khẩu");
			if(pwstr != null && pwstr != '')
			{
				document.frmAuth.password.value = pwstr;
				document.frmAuth.submit();
			}
			else
			{
				window.location.href="<?php echo JURI::base();?>";
			}
		</script>
	</body>
</html>
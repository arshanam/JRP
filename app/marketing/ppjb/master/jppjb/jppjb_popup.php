<?php
require_once('jppjb_proses.php');
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<!-- CSS -->
<link type="text/css" href="../../../../../config/css/style.css" rel="stylesheet">
<link type="text/css" href="../../../../../plugin/css/zebra/default.css" rel="stylesheet">

<!-- JS -->
<script type="text/javascript" src="../../../../../plugin/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="../../../../../plugin/js/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="../../../../../plugin/js/jquery.inputmask.custom.js"></script>
<script type="text/javascript" src="../../../../../plugin/js/keymaster.js"></script>
<script type="text/javascript" src="../../../../../plugin/js/zebra_datepicker.js"></script>
<script type="text/javascript" src="../../../../../config/js/main.js"></script>
<script type="text/javascript">
$(function() {
	$('#kode_jenis').inputmask('numeric', { repeat: '3' });
	$('#nama_jenis').inputmask('varchar', { repeat: '30' });
	$('#nama_file').inputmask('varchar', { repeat: '40' });
	
	$('#close').on('click', function(e) {
		e.preventDefault();
		return parent.loadData();
	});
	
	$('#save').on('click', function(e) {
		e.preventDefault();
		var url		= base_marketing + 'ppjb/master/jppjb/jppjb_proses.php',
			data	= $('#form').serialize();
			
		$.post(url, data, function(data) {			
			if (data.error == true)
			{
				alert(data.msg);
			}
			else
			{
				if (data.act == 'Tambah')
				{
					alert(data.msg);
					$('#reset').click();
				}
				else if (data.act == 'Ubah')
				{
					alert(data.msg);
					parent.loadData();
				}
			}
		}, 'json');		
		return false;
	});
});
</script>
</head>
<body class="popup">

<form name="form" id="form" method="post">
<table class="t-popup">
<tr>
	<td width="100">Kode</td><td>:</td>
	<td><input type="text" name="kode_jenis" id="kode_jenis" size="3" value="<?php echo $kode_jenis; ?>"></td>
</tr>
<tr>
	<td>Jenis PPJB</td><td>:</td>
	<td><input type="text" name="nama_jenis" id="nama_jenis" size="30" value="<?php echo $nama_jenis; ?>"></td>
</tr>
<tr>
	<td>Nama File</td><td>:</td>
	<td><input type="text" name="nama_file" id="nama_file" size="40" value="<?php echo $nama_file; ?>"></td>
</tr>
<tr>
	<td colspan="3" class="td-action text-center">
		<input type="submit" id="save" value=" <?php echo $act; ?> ">
		<input type="reset" id="reset" value=" Reset ">
		<input type="button" id="close" value=" Tutup "></td>
	</td>
</tr>
</table>

<input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
<input type="hidden" name="act" id="act" value="<?php echo $act; ?>">
</form>

</body>
</html>
<?php close($conn); ?>
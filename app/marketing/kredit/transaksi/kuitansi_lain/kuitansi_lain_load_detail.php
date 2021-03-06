<?php
require_once('../../../../../config/config.php');
$conn = conn($sess_db);
die_conn($conn);

$id		= (isset($_REQUEST['id'])) ? clean($_REQUEST['id']) : '';
?>

<table class="t-data w100">
<tr>
	<th class="w5"><input type="checkbox" id="cb_all"></th>
	<th class="w5">NO.</th>
	<th class="w10">NOMOR KWITANSI</th>
	<th class="w10">TANGGAL BAYAR</th>
	<th class="w10">JUMLAH (Rp)</th>
	<th class="w70">KETERANGAN</th>
</tr>

<?php
	$query = "
	SELECT *
	FROM 
		KWITANSI_LAIN_LAIN
	WHERE KODE_BLOK = '$id'
	ORDER BY TANGGAL
	";
	$obj = $conn->execute($query);
	$i = 1;

	while( ! $obj->EOF)
	{
		$id = $obj->fields['NOMOR_KWITANSI'];
		?>
		<tr class="onclick" id="<?php echo $id; ?>">
			<td width="30" class="notclick text-center"><input type="checkbox" name="cb_data[]" class="cb_data" value="<?php echo $id; ?>"></td> 			
			<td class="text-center"><?php echo $i; ?></td>
			<td class="text-center"><?php echo $id; ?></td>
			<td class="text-center"><?php echo date("d M Y", strtotime($obj->fields['TANGGAL']));  ?></td>
			<td class="text-center"><?php echo to_money($obj->fields['NILAI']);  ?></td>
			<td><?php echo $obj->fields['KETERANGAN'];  ?></td>
		</tr>
		<?php
		$i++;
		$obj->movenext();
	}
?>
</table>

<script type="text/javascript">
jQuery(function($) {
	t_strip('.t-data');
});
</script>

<?php
close($conn);
exit;
?>
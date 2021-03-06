<?php
require_once('../../../../config/config.php');
die_login();
die_app('A01');
die_mod('PM07');
$conn = conn($sess_db);
die_conn($conn);


$per_page	= (isset($_REQUEST['per_page'])) ? max(1, $_REQUEST['per_page']) : 20;
$page_num	= (isset($_REQUEST['page_num'])) ? max(1, $_REQUEST['page_num']) : 1;

$s_opf1		= (isset($_REQUEST['s_opf1'])) ? clean($_REQUEST['s_opf1']) : '';
$s_opv1	= (isset($_REQUEST['s_opv1'])) ? clean($_REQUEST['s_opv1']) : '';

$query_search = '';
if ($s_opv1 != '')
{
	$query_search .= " WHERE $s_opf1 LIKE '%$s_opv1%' ";
}

# Pagination
$query = "
SELECT 
	COUNT(ht.KODE_SK) AS TOTAL
FROM 
	HARGA_TANAH ht
	LEFT JOIN LOKASI l ON ht.KODE_LOKASI = l.KODE_LOKASI
$query_search
";
$total_data = $conn->Execute($query)->fields['TOTAL'];
$total_page = ceil($total_data/$per_page);

$page_num = ($page_num > $total_page) ? $total_page : $page_num;
$page_start = (($page_num-1) * $per_page);
# End Pagination
?>

<table id="pagging-1" class="t-control w60">
<tr>
	<td>
		<input type="button" id="tambah" value=" Tambah ">
	</td>
	
	<td class="text-right">
		<input type="button" id="prev_page" value=" < ">
		Hal : <input type="text" name="page_num" size="5" class="page_num apply text-center" value="<?php echo $page_num; ?>">
		Dari <?php echo $total_page ?> 
		<input type="hidden" id="total_page" value="<?php echo $total_page; ?>">
		<input type="button" id="next_page" value=" > ">
	</td>
</tr>
</table>

<table class="t-data w60">
<tr>
	<th class="w5">KODE</th>
	<th class="w30">LOKASI</th>
	<th class="w20">HARGA TANAH / M&sup2;</th>
	<th class="w2">STATUS</th>
	<th class="w10">TANGGAL</th>
</tr>

<?php
if ($total_data > 0)
{
	$query = "
	SELECT 
		ht.KODE_SK,	
		l.LOKASI,
		ht.HARGA_TANAH,
		ht.STATUS,
		ht.TANGGAL
	FROM 
		HARGA_TANAH ht
		LEFT JOIN LOKASI l ON ht.KODE_LOKASI = l.KODE_LOKASI
	$query_search
	ORDER BY ht.KODE_SK ASC
	";
	
	$obj = $conn->SelectLimit($query, $per_page, $page_start);
	$i = 1 + $page_start;
	while( ! $obj->EOF)
	{
		$id = $obj->fields['KODE_SK'];
		?>
		<tr class="onclick" id="<?php echo $id; ?>">
			<td class="text-center"><?php echo $id; ?></td>
			<td><?php echo $obj->fields['LOKASI']; ?></td>
			<td class="text-right"><?php echo to_money($obj->fields['HARGA_TANAH']); ?></td>	
			<td class="text-center"><?php echo status_check($obj->fields['STATUS']); ?></td>
			<td><?php echo tgltgl(f_tgl($obj->fields['TANGGAL'])); ?></td>	
		</tr>
		<?php
		$obj->movenext();
	}
}
?>
</table>

<table id="pagging-2" class="t-control w60"></table>

<script type="text/javascript">
jQuery(function($) {
	$('#pagging-2').html($('#pagging-1').html());
	
	$('#total-data').html('<?php echo $total_data; ?>');
	$('#per_page').val('<?php echo $per_page; ?>');
	$('.page_num').inputmask('integer');
	t_strip('.t-data');
});
</script>

<?php
close($conn);
exit;
?>
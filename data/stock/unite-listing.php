<?php
# Entete de page
define('NIVO', '../../'); 
$css = 'standard';
include NIVO."includes/ifentete.php" ;

$idstockf = $_REQUEST['idstockf'];

$classe = "etiq2";
$classe2 = "standard";
?>
<table class="<?php echo $classe2; ?>" border="0" width="98%" cellspacing="1" cellpadding="1" align="center">
<?php
# Recherche des officers
if (!empty($idstockf)) {
		$stocksort='stm.reference, ma.idstockm, ma.idvip, ma.mnom';
		$recherche1='
			SELECT 
			ma.idmatos, ma.idvip, ma.codematos, ma.mnom, ma.dateout AS madateout, ma.autre, ma.idpeople, 
			ma.situation, ma.complet, ma.idstockm, 
			stm.idstockf, stm.reference,
			stf.reference AS reffamille, stf.stype,
			m.idvip, m.idvipjob, a.idanimation, me.idmerch,
			p.pnom, p.pprenom, p.email, p.gsm, p.codepeople,
			j.reference AS jreference, a.reference AS areference, me.produit  
			FROM matos ma
			LEFT JOIN stockm stm ON ma.idstockm = stm.idstockm 
			LEFT JOIN stockf stf ON stm.idstockf = stf.idstockf 
			LEFT JOIN vipmission m ON ma.idvip = m.idvip 
			LEFT JOIN vipjob j ON m.idvipjob = j.idvipjob 
			LEFT JOIN animation a ON ma.idanimation = a.idanimation 
			LEFT JOIN merch me ON ma.idmerch = me.idmerch 
			LEFT JOIN people p ON ma.idpeople = p.idpeople
		';

		$quid = " WHERE stm.idstockf = ".$idstockf;
		
		$recherche='
			'.$recherche1.'
			'.$quid.'
			 ORDER BY '.$stocksort.'
		';
	$matos = new db();
	$matos->inline("$recherche;");
	$FoundCount = mysql_num_rows($matos->result);
#	echo $recherche;

}
$i = 0;
$idstockm = 0;
while ($row = mysql_fetch_array($matos->result)) {
$i++;
$j++; # compteur modele
?>
	<?php /* Ligne Famille */ if ($i == 1) {?>
		<tr>
			<td class="<?php echo $classe2; ?>" colspan="11"><font size=+1><?php echo $row['reffamille'];?> &nbsp; : <?php echo $FoundCount;?></font> </td>
		</tr>
	<?php } ?>
	<?php /* Ligne Modele et titres */
	if ($row['idstockm'] != $idstockm) { $idstockm = $row['idstockm']; $j = 1;
	?>
		<tr>
			<td class="<?php echo $classe; ?>" colspan="11"><font size=+1><?php echo $row['reference'];?></font></td>
		</tr>
		<tr>
			<td class="<?php echo $classe; ?>">#</td>
			<td class="<?php echo $classe; ?>">Code</td>
			<td class="<?php echo $classe; ?>">R&eacute;f&eacute;rence</td>
			<td class="<?php echo $classe; ?>">Situation</td>
			<td class="<?php echo $classe; ?>">Complet</td>
			<td class="<?php echo $classe; ?>">Mission</td>
			<td class="<?php echo $classe; ?>">Date out</td>
			<td class="<?php echo $classe; ?>">Nom</td>
			<td class="<?php echo $classe; ?>">Pr&eacute;nom</td>
			<td class="<?php echo $classe; ?>">Gsm</td>
			<td class="<?php echo $classe; ?>">email</td>
		</tr>
	<?php } /*/ Ligne Modele et titres */?>
		<tr id="line<?php echo $i; ?>">
			<td class="<?php echo $classe; ?>"><?php echo $j; ?></td>
			<td class="<?php echo $classe2; ?>"><?php echo $row['codematos']; ?></td>
			<td class="<?php echo $classe2; ?>"><?php echo $row['mnom']; ?></td>
			<td class="<?php echo $classe2; ?>">
				<?php 
					if ($row['situation'] == 'in') {echo 'In';}
					if ($row['situation'] == 'out') {echo 'Out';}
					if ($row['situation'] == 'supplier') {echo 'Supplier';}
					if ($row['situation'] == 'going') {echo 'En partance';}
					if ($row['situation'] == 'coming') {echo 'En revenance';}
					if ($row['situation'] == 'client') {echo 'Retour client';}
				?>
			</td>
			<td class="<?php echo $classe2; ?>">
				<?php 
					if ($row['complet'] == '0') {echo 'Non';}
					if ($row['complet'] == '1') {echo 'Oui';}
					if ($row['complet'] == '2') {echo 'Partiel';}
				?>
			</td>
			<td class="<?php echo $classe2; ?>">
				<?php if ($row['idvip'] > 0) { echo 'V '.$row['idvip'];} ?>
			</td>
			<td class="<?php echo $classe2; ?>"><?php echo fdate($row['madateout']); ?></td>
			<td class="<?php echo $classe2; ?>"><?php echo $row['pnom']; ?></td>
			<td class="<?php echo $classe2; ?>"><?php echo $row['pprenom']; ?></td>
			<td class="<?php echo $classe2; ?>"><?php echo $row['gsm']; ?></td>
			<td class="<?php echo $classe2; ?>"><?php echo $row['email']; ?></td>
		</tr>
<?php } ?>
	</table>
<?php
# Pied de Page
include NIVO."includes/ifpied.php" ;
?>
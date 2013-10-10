<?php 

$fail = $this->input->get('fail') ; 
$col  = $this->input->get('col') ; 

switch($fail)
{
	case 'dup' :
	$label =  $col ; 
	foreach($crud_data as $c )
	{
		if($c['name'] == trim($col))
		{
			$label = $c['label'];
			break;
		}
	}
	$msg  = $errors['duplicate_1part']; 
	$msg .= '<span>&nbsp;'.$label.'&nbsp;</span>' ;
	$msg .= $errors['duplicate_2part'];
	break ;
	default :
	$fail = false ;
	break;

}
if($fail ) { 
?>
<div class="crud_fail" dir="rtl">
<?php echo $msg ; ?>
</div>
<?php } ?>
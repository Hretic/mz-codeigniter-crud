<?php
$this->lang->load ( $lang['file'] , $lang['folder']);
$edit_option   = $this->lang->line('edit_option');

$errors_label    = $this->lang->line('errors_label');
?>

<!--  TEXT EDITO FILES -->
  
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>crud_assets/markitup/skins/markitup/style.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>crud_assets/markitup/sets/default/style.css" />

<!-- END OF TEXT EDITO FILES -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>crud_assets/css/style.css" />

<?php 
	$data['crud_data'] = $crud_data;
	$data['errors'] = $errors_label;
	$this->load->view('crud/msg' , $data );
?>


<form action="<?php echo base_url(); ?>crud/action/edit/?r=<?php echo base64_encode($redirect); ?>" method="post"><div class="crud_edit">

    <table border="0" class="crud_VerticalTable">
		 <?php foreach($crud_data as $f) { ?>
          <tr>
            <td> <?php
			
					 if(is_array($H_Addon) && isset($H_Addon[$f['name']]))
					 {
					   echo $H_Addon[$f['name']];
					   echo '<br />';
					 }
			
			 echo $f['input']; ?> </td>
            <th><?php echo $f['label']; ?></th>
          </tr>
         <?php } ?>
         <Tr><td></td><td> <input name="" type="submit" value=" <?php echo $edit_option; ?> " /></td></Tr>
    </table>
    <input name="id" type="hidden" value="<?php echo $id; ?>" />
    <input name="tbl" type="hidden" value="<?php echo $tbl; ?>" />
    <input name="default_implode" type="hidden" value="<?php echo $default_implode; ?>" />
    <input name="id_fild" type="hidden" value="<?php echo $id_fild; ?>" />
   <input name="fail_url" type="hidden" value="<?php echo $fail_url; ?>" />
   
   
    <?php if($check_duplicate ) {
	         foreach($check_duplicate as $chd)
			 {?>
                 <input name="check_duplicate[]" type="hidden" value="<?php echo $chd; ?>" />

    <?php } } ?>


   
</div>
</form>   
<script type="text/javascript" >
    var base_url = '<?php echo base_url(); ?>';
    function documentready(){
	  <?php 
	   foreach($documentready as $d )
	   echo $d ;
	   ?>
	}
</script>
<script src="<?php echo base_url(); ?>crud_assets/js/script.js"></script>

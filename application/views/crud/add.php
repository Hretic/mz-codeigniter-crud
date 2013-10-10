<?php
$this->lang->load ( $lang['file'] , $lang['folder']);
$add_option    = $this->lang->line('add_option');
$errors_label    = $this->lang->line('errors_label');

?>
<!--  TEXT EDITO FILES -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>crud_assets/markitup/skins/markitup/style.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>crud_assets/markitup/sets/default/style.css" />
<!-- END OF TEXT EDITO FILES -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>crud_assets/css/style.css" />

<div class="crud_add">
<?php 
	$data['crud_data'] = $crud_data;
	$data['errors'] = $errors_label;
	$this->load->view('crud/msg' , $data );
?>
<form action="<?php echo base_url(); ?>crud/action/add/?r=<?php echo base64_encode($redirect); ?>" method="post">
    <table border="0" class="crud_VerticalTable" dir="ltr">
		 <?php foreach($crud_data as $f) { ?>
          <tr>
            <td> <?php echo $f['input']; ?> </td>
            <th><?php echo $f['label']; ?></th>
          </tr>
         <?php } ?>
         <tr><td></td><td><input name="" type="submit" value=" <?php echo $add_option; ?> " /></td></tr>
    </table>
    <input name="tbl" type="hidden" value="<?php echo $tbl; ?>" />
    <input name="fail_url" type="hidden" value="<?php echo $fail_url; ?>" />
    <input name="default_implode" type="hidden" value="<?php echo $default_implode; ?>" />
    <?php if($check_duplicate ) {
	         foreach($check_duplicate as $chd)
			 {?>
                 <input name="check_duplicate[]" type="hidden" value="<?php echo $chd; ?>" />

    <?php } } ?>
    
    </form>
</div>
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


<?php
$this->lang->load ( $lang['file'] , $lang['folder']);
$edit_option   = $this->lang->line('edit_option');
$add_option    = $this->lang->line('add_option');
$delete_option = $this->lang->line('delete_option');
$row_label     = $this->lang->line('row_label');
$search_label     = $this->lang->line('search');
$errors_label     = $this->lang->line('errors_label');

$sort_label     = $this->lang->line('sort');
$sort_options     = $this->lang->line('sort_options');

$select_label     = $this->lang->line('select');

?>
<link href="<?php echo base_url(); ?>/crud_assets/css/style.css" rel="stylesheet" type="text/css">


<?php
if(!empty($search)){ 

	$currSearch = $this->input->get('search');
	$search_fild = $this->input->get('search_fild');

?>
<div id="crud_search_div">
<form action="<?php echo current_url(); ?>" method="get">	

<select name="search_fild">
<option value=""><?php echo $select_label ; ?></option>
<?php
foreach ($search as $s ) {?>
<option value="<?php echo $s; ?>"  <?php echo $search_fild == $s  ? 'selected="selected"' : ' ';?> ><?php echo isset($labels[$s]) ? $labels[$s] : $s ; ?></option>
<?php }?>
</select>
<input name="search" type="text"  placeholder="<?php echo $search_label; ?>" value="<?php echo $currSearch ; ?>"/>
<input name="" type="submit" value="<?php echo $search_label; ?>" /></form>
</div>
<?php } ?>



<?php
if(!empty($sort)){
	
	$currSort = $this->input->get('sort');
	$sort_fild = $this->input->get('sort_fild');
	 ?>
     <div id="crud_sort_div">
<form action="<?php echo current_url(); ?>" method="get">	

<select name="sort_fild">
<option value=""><?php echo $select_label ; ?></option>
<?php
foreach ($sort as $s ) {?>
<option value="<?php echo $s; ?>" <?php echo $sort_fild == $s  ? 'selected="selected"' : ' ';?> ><?php echo isset($labels[$s]) ? $labels[$s] : $s ; ?></option>
<?php } ?>
</select>

<select name="sort">
<?php
foreach ($sort_options as $k=>$v ) {?>
<option value="<?php echo $k ; ?>" <?php echo $currSort == $k  ? 'selected="selected"' : ' ';?>><?php echo $v; ?></option>
<?php } ?>
</select>

<input name="" type="submit" value="<?php echo $sort_label; ?>" /></form>
</div>
<?php } ?>




    <table class="crud_ListTble"  dir="rtl">
    
        <?php 
		if(in_array('add' , $md_options)){?>
          <form method="post" class="fast_add">    
            <tr class="adder_row">
                 <th><input type="button" value=" <?php echo $add_option; ?> " onclick="Fast_Add();"></th>
                 <?php
				 
				 
				 
				  foreach($crud_data as $f) { ?>
                     <th>
					 
					 <?php 
					 
					 if(is_array($H_Addon) && isset($H_Addon[$f['name']]))
					 {
					   echo $H_Addon[$f['name']];
					   echo '<br />';
					 }
					 echo $f['input'] ;
					 
					 
					 ?>
                     
                     </th>
                 <?php }


				  if($helper && is_array($helper))
				     foreach($helper as $h )
					 {
						 ?>
                         <th></th>
                         <?php						  
					 }


				  if(!empty($append) && is_array($append)){
					 foreach($append as $ap ){?>
					 <th></th> 
					 <?php }
				  }
				  
				  
				         
		if(in_array('edit' , $md_options)){
 
				  ?>
                 
             <th></th>
             <?php } 
			 
		if(in_array('delete' , $md_options)){?>

             <th><input class="crud_checkall" type="checkbox" ></th>
             
             <?php } ?>
    
          </tr>
         </form>  
         <?php } ?>
         
                    
        <tr class="label_Row">
          <th><?php echo $row_label; ?></th>
		 <?php foreach($crud_data as $f) { ?>
             <th><?php echo $f['label'] ;?></th>
         <?php } 
		 
		 
		  if($helper && is_array($helper))
			 foreach($helper as $h )
			 {
				 ?>
				 <th><?php echo $h['label']; ?></th>
				 <?php						  
			 }



		 if(!empty($append) && is_array($append)){
			 foreach($append as $ap ){
			  ?>
               <th><?php echo $ap['label'] ; ?></th>
         <?php }
		 }
		 
		  
		if(in_array('edit' , $md_options)){?>
         <th><?php echo $edit_option; ?></th>
        <?php } 
        
        if(in_array('delete' , $md_options)){?>
<th><input name="" type="button" value="  <?php echo $delete_option; ?>  "  onclick="delete_()" class="CrudDelete_Btn"/></th>
  <?php } ?>

         
         </tr>
    
		<?php 
			$c = 0 ;
			foreach($list_data->result() as $cl ){
			$c++;
		?>
        
        <tr id="CrudRow_<?php echo $cl->$id_fild; ?>">  
        
               <td><?php echo $c; ?></td>
                <?php foreach($crud_data as $cd ) { ?>
                <td>
				
				<?php 
				
				if(is_array($get_replace) && isset($get_replace[$cd['name']]))
				{
					$ex = explode( $crud_explode , $cl->$cd['name'] );
					foreach($ex as $ex)
					{
						$Q = $this->db->where('id' , $ex)->get($get_replace[$cd['name']]['tbl']);
						$result = $Q->num_rows > 0 ? $Q->row() : false ;
						if($result)
						{
						   echo $result->$get_replace[$cd['name']]['fild'];
						   echo '<br />';
						}
					}
					
				}
				else
				echo $cl->$cd['name'];
				
				
				 ?></td>
                <?php } 


			  if($helper && is_array($helper))
				 foreach($helper as $h )
				 {
					 ?>
					 <th><?php echo $h['function']($h['args'] , $cl ); ?></th>
					 <?php						  
				 }



				
				if(!empty($append) && is_array($append)){
			               foreach($append as $ap ){
			 			  ?>
                      			 <th><?php 
								 echo str_replace('{id}' , $cl->id ,$ap['html']) ; ?></th>
                 		<?php } 
                 }
				 
				 
		      if(in_array('edit' , $md_options)){?>
             <th><a href="<?php echo $edit_url; echo $cl->$id_fild; ?>"><?php echo $edit_option; ?></a></th>
            <?php 
			  }
		     if(in_array('delete' , $md_options)){?>
             <th> <input class="crud_inputs" type="checkbox" value="<?php echo $cl->$id_fild; ?>" /></th>
             <?php } ?>

        </tr>
        <?php } ?> 
        
        
    </table>
    
<?php

$config['suffix']      = '';
$config['base_url']    = current_url().'/?';

foreach($_GET as $k=>$v)
{ 
   if ( $k  == "offset" )  continue ;
   $config['suffix']  .= '&'.$k.'='.$v ;
}

$config['total_rows']           = $total_count;
$config['per_page']             = $per_page ;
$config['page_query_string']    = TRUE;
$config['query_string_segment'] = 'offset';

$this->pagination->initialize($config);
$pagination =  $this->pagination->create_links();
if($pagination) 
echo "<div id='crud_pagination'> $pagination </div>";
?>


<script type="text/javascript" >

	var default_implode = '<?php echo $default_implode; ?>';

    var base_url = '<?php echo base_url(); ?>';
	var id_fild  = '<?php echo $id_fild;?>';
	var tbl      = '<?php echo $tbl; ?>';
	var edit_url = '<?php echo $edit_url;?>';
	var columns  = new Array();
	var labels   = {};
	var check_duplicate  = new Array();
	
	<?php foreach($crud_data as $cd ) { ?>
	  columns.push('<?php echo $cd['name'] ; ?>');
	  labels['<?php echo $cd['name'] ; ?>'] = '<?php echo $cd['label'] ; ?>';
	<?php } ?>


	<?php 
	
	 if(!empty($check_duplicate) )
	 {
	  foreach($check_duplicate as $ch ) { ?>
	  check_duplicate.push('<?php echo $ch ; ?>');
	<?php
	    }
	  }
	   else
	   { ?>
	  check_duplicate = false;
 <?php } ?>
	  
	var errors = {};
	<?php foreach($errors_label as $k=>$v ) {?>
	errors['<?php echo $k; ?>'] = '<?php echo $v; ?>';
	 
	<?php } ?>
	

	  
var get_replace = '<?php echo json_encode($get_replace); ?>';
var helper      = '<?php echo json_encode($helper); ?>';


var append      = new Array;
<?php if(!empty($append)) foreach($append as $ap) { ?>
 append.push('<?php echo $ap['html'];?>' );
<?php } ?>


function Fast_Add(){
	
	var array = $('.fast_add').serializeArray();
	
	$('.adder_row input').attr('disabled' , true );
	
	$.post(base_url+'crud/action/fast_Add' , 
	{crud_inputs:array , tbl : tbl , default_implode : default_implode ,  check_duplicate:check_duplicate , labels:labels , errors:errors}
	, function(data){
		data = $.trim(data);
		if(data ==  'ok' )
		{
			$.post(base_url+'crud/last_row' , 
			{columns : columns , id_fild:id_fild , tbl:tbl , edit_url:edit_url ,
			 get_replace:get_replace , helper:helper , append :append  , crud_explode:'<?php echo $crud_explode; ?>'} , function(row)
			{
	            $('.adder_row input').attr('disabled' , false );
				$('.adder_row input:text').val('');
				$('.crud_ListTble .label_Row').after(row);
			});
			
		}
		else
		{
	        $('.adder_row input').attr('disabled' , false );
			slidedown(data);
		}
	})
}

	
    function documentready(){

	  <?php 
	   foreach($documentready as $d )
	   echo $d ; 
	   ?>
	}
	
</script>
<script src="<?php echo base_url(); ?>crud_assets/js/script.js"></script>


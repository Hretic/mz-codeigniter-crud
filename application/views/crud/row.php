<tr id="CrudRow_<?php echo $cl->$id_fild; ?>">  
        
               <td><?php echo $c; ?></td>
                <?php foreach($crud_data as $cd ) { ?>
                <td><?php
				$get_replace = json_decode($this->input->post('get_replace'));
			
				if(!is_null($get_replace) && is_array($get_replace) && isset($get_replace[$cd['name']]))
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
                <?php } ?>
               
             <th><a href="<?php echo $edit_url; echo $cl->$id_fild; ?>">Edit</a></th>
             <th> <input class="crud_inputs" type="checkbox" value="<?php echo $cl->$id_fild; ?>" /></th>

</tr>

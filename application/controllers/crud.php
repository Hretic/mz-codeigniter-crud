<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class crud extends CI_Controller {
	
	
	public function __construct(){
		parent::__construct();
		$this->load->model('m_crud');
	}
	
	
  public function action($do = ''){


    $this->form_validation->set_rules('crud_inputs', 'crud_inputs', 'required');
    $this->form_validation->set_rules('tbl', 'tbl', 'required');
	$errors = $this->input->post('errors');
	
	if($do == 'edit')
		$this->form_validation->set_rules('id', 'id', 'required');
		
	if($do == 'delete')
		$this->form_validation->set_rules('id_fild', 'id_fild', 'required');
	
	
       if ($this->form_validation->run() == FALSE)
      {
         $this->load->library('mz_crud');
		 echo $this->mz_crud->error(2);
      }
      else
      {
		  $is_ajax         = $this->input->is_ajax_request();
		  
          
		  if($do == 'add')
		  {
			$this->check_duplicate();
		    $this->m_crud->add();
		  }
		  
		  if($do == 'fast_Add')
		  {
			  
				$array = $this->input->post('crud_inputs');
				
				foreach($array as &$item)
				{
					 $item = array_map('urlencode',$item);
					 $item = implode('=',$item);
				}
				
				$string = implode('&',$array);
				parse_str($string,$result);
				
				if(!isset($result['crud_inputs']))
				{
					 echo $this->mz_crud->error(2);
					 exit;
				}
				
				
				$crud_inputs = $result['crud_inputs'] ;
				$impload     = isset($result['implode']) ? $result['implode'] : false ;
	            $this->check_duplicate($crud_inputs , false , $errors);
				$this->m_crud->add($crud_inputs , $impload );
		  }
		  
		  
		  if($do == 'edit')
		  {	
			$this->check_duplicate(false , $this->input->post('id') , $errors);
		    $this->m_crud->edit();
		  }
		  
		  if($do == 'delete')
		  $this->m_crud->delete();
		  
		  
		  

		  if($is_ajax)
		    echo 'ok';
		  else
		  {
			  $r = base64_decode($this->input->get('r'));
			  redirect($r);
		  }
      }  
   	}
	
	function check_duplicate($inputs = false , $id = false , $errors = array()){
		
		
		$is_ajax         = $this->input->is_ajax_request();
		$inputs          = $inputs ? $inputs : $_POST['crud_inputs'] ;
	    $check_duplicate = $this->input->post('check_duplicate');
	    $tbl             = $this->input->post('tbl');
	    $id_fild         = $this->input->post('id_fild');
	    $fail_url        = $this->input->post('fail_url');
	    $labels          = $this->input->post('labels');
		
		if(!$check_duplicate || !is_array($check_duplicate))
		return ;

		foreach($check_duplicate as $chd )
		{
			$check = $this->m_crud->check_duplicate( $chd , $inputs[$chd] , $tbl , $id , $id_fild );
			if($check > 0 )
			{
				if($is_ajax)
				{
					$dup = isset($labels[$chd]) ?  $labels[$chd] : $chd ;
				    echo $errors['duplicate_1part'];
					echo  $dup ;
				    echo $errors['duplicate_2part'];
				}
				else
				redirect($fail_url.'/?fail=dup&col='.$chd);
				exit;
			}
		}
		
	}
	
	function last_row(){


    $this->form_validation->set_rules('columns', 'columns', 'required');
    $this->form_validation->set_rules('id_fild', 'id_fild', 'required');
    $this->form_validation->set_rules('tbl', 'tbl', 'required');
	
       if ($this->form_validation->run() == FALSE)
      {
		  echo ''  ;
      }
	  else
	  {
		$columns = $this->input->post('columns');
		$id_fild = $this->input->post('id_fild');
		$edit_url= $this->input->post('edit_url');

		$row = $this->m_crud->get_last(); 
		
		if($row)
		{
			 echo '<tr>';
			 echo '<td> NEW </td>';
			 foreach($columns as $c )
			 {
				echo '<td>';
				$get_replace = json_decode($this->input->post('get_replace') , true );
				
				if(!is_null($get_replace) && is_array($get_replace) && isset($get_replace[$c]))
				{ 
					$ex = explode( $this->input->post('crud_explode') , $row->$c );
					foreach($ex as $ex)
					{
						if($ex == '' ) continue ;
						$Q = $this->db->where('id' , $ex)->get($get_replace[$c]['tbl']);
						$result = $Q->num_rows > 0 ? $Q->row() : false ;
						if($result)
						{
						   echo $result->$get_replace[$c]['fild'];
						   echo '<br />';
						}
					}
					
				}
				else
			    echo $row->$c ;
				
				echo '</td>';
			 }
				$helper = json_decode($this->input->post('helper') , true );
				if(!is_null($helper) && is_array($helper) )
				{
					 foreach($helper as $h )
					 {
						 ?>
						 <th><?php echo $h['function']($h['args'] , $row ); ?></th>
						 <?php						  
					 }
				}


			 

				$append = $this->input->post('append') ;
                    if(!empty($append) && is_array($append)){
			               foreach($append as $ap ){
			 			
                      			echo '<th>';
								 echo str_replace('{id}' , $result->id ,$ap) ; 
								echo '</th>';
                 	} } 
						
									 
			 
			 echo '<th><a href="'.$edit_url.$row->$id_fild.'">Edit</a></th>';
			 echo '<th> <input class="crud_inputs" type="checkbox" value="'.$row->$id_fild.'" /></th>';
			 echo '</tr>';
		}
	  }
	     
	}

}

	  
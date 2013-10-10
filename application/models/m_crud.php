<?php
class m_crud extends CI_Model {
  
  public function __construct(){
	
	parent::__construct();  
	  
  }


/*
| -------------------------------------------------------------------
|  ADDS
| -------------------------------------------------------------------
*/

   
   function add($inputs = false , $implode =  false){
	   
		$tbl     =  $this->input->post('tbl');
		$inputs  =  ($inputs)  ? $inputs : $this->input->post('crud_inputs');
		$implode =  ($implode) ? $implode : $this->input->post('implode');
		$default_implode =  $this->input->post('default_implode');
		
		if(is_array($inputs) && !empty($inputs) )
		{
	    
		  foreach($inputs as $k=>$v)
		  {
			  if(is_array($v))
			  {
				  $imp = isset($implode[$k]) ? $implode[$k] : $default_implode ;
				  $inputs[$k] = implode($imp , $v);
			  }
		  }
		  $this->db->insert($tbl , $inputs );
		}
   }


/*
| -------------------------------------------------------------------
|  EDIT
| -------------------------------------------------------------------
*/

   function edit(){
	  
		$tbl     =  $this->input->post('tbl');
		$id      =  $this->input->post('id');
		$inputs  =  $this->input->post('crud_inputs');
		$id_fild =  $this->input->post('id_fild');
		$implode =  $this->input->post('implode');
		$default_implode =  $this->input->post('default_implode');

		if(is_array($inputs) && !empty($inputs) )
		{
	    
		  foreach($inputs as $k=>$v)
		  {
			  if(is_array($v))
			  {
				  $imp = isset($implode[$k]) ? $implode[$k] : $default_implode ;
				  $inputs[$k] = implode($imp , $v);
			  }
		  }

		 $this->db->where( $id_fild, $id )->update($tbl , $inputs );
			
		}
   }
   

/*
| -------------------------------------------------------------------
|  EDIT
| -------------------------------------------------------------------
*/

   function delete(){
	   
		$tbl     =  $this->input->post('tbl');
		$id_fild =  $this->input->post('id_fild');
		$inputs  =  $this->input->post('crud_inputs');
		  
		 $this->db->where_in($id_fild , $inputs )->delete($tbl );
   }
/*
| -------------------------------------------------------------------
|  LIST
| -------------------------------------------------------------------
*/

   function list_($tbl , $limit = 0 ){
	   
		$search_fild  =  $this->input->get('search_fild');
		$search       =  $this->input->get('search');
		$sort         =  $this->input->get('sort');
		$sort_fild    =  $this->input->get('sort_fild');
		$offset       =  (int)$this->input->get('offset');
		
		if($search && $search_fild )
		$this->db->where( $search_fild , $search);
		if($sort && $sort_fild )
		$this->db->order_by( $sort_fild , $sort );
		if( $limit != 0 )
		$this->db->limit($limit , $offset);
		
		return $this->db->get($tbl);
   }
/*
| -------------------------------------------------------------------
|  GET LAST ROE 
| -------------------------------------------------------------------
*/

   function get_last(){
	   
		$id_fild      =  $this->input->post('id_fild');
		$tbl          =  $this->input->post('tbl');
		
		$R =  $this->db->order_by($id_fild , 'DESC')->limit(1)->get($tbl);
		return ($R->num_rows() == 0 ) ? false : $R->row() ;
		
		
   }
   
   
/*
| -------------------------------------------------------------------
|  GET LAST ROE 
| -------------------------------------------------------------------
*/

   function check_duplicate( $fild , $val , $tbl , $id , $id_fild ){
	   
		$this->db->where($fild , $val );
		if($id)
		$this->db->where( "$id_fild != " , $id );
		$r = $this->db->get($tbl);
		return $r->num_rows();
   }   
   
}
?>
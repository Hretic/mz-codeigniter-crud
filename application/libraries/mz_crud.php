<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mz_crud extends CI_Controller {
	
	private $allviews = array('add'=>'crud/add' , 'edit'=>'crud/edit' , 'list'=>'crud/list' , 'err'=>'crud/error'); 
	private $errors   = array(
	'0'=>'UNDEFINED ERROR !' ,
	'1'=>'TABLE CANNOT BE FOUND' , 
	'2'=>'FORM ARGUMENTS ARE MISSING' ,
	'3'=>'ROW WITH GIVEN ID DOESNT EXIST ' ,
	) ;
	private $configs  = array( 
	'labels'=>'',
	'ignor'=>'',
	'redirect'=>'',
	'edit_url'=>'',
	'fail_url'=>'',
	'inp_type'=>'',
	'lang'   => array('file'=>'crud' , 'folder'=>'crud')  ,
	'per_page'=>0,
	'check_duplicate'=>false,
	'validate'=>false,
	'id_fild'=>'id' ,  
	'options'=>'',
	'helper'=>false,
	'implode'=>'',
	'search'=>array(),
	'sort'=>array(),
	'per_page'=>'',
	'md_options'=>array(),
	'default_implode'=>',' ,
	'crud_explode'=>',' ,
	'get_replace'=> array()  , 
	'append' => array() ,
	'documentready'=> array()  , 
	'H_Addon' => array()  
	);
	private $filds    = array() ;
	private $view ;
	private $ci ;
	private $row;
	

    public function __construct()
    {
		  parent::__construct();
		  $this->configs['redirect'] = current_url();
		  $this->configs['fail_url'] = current_url();
		  $this->ci = & get_instance();
    }
	
	


	public function set_config( $conf )
	{
		foreach($conf as $k=>$v)
		{
			if(isset($this->configs[$k]))
			$this->configs[$k] = $v;
		}
		
	}


	public function set_documentready( $js )
	{
		$this->documentready[] = $js;
	}



	private function check_config($key  , $val , $check_type = 'isset' )
	{
		if($check_type == 'isset' ) 
		return isset( $this->configs[$key][$val] ) ? $this->configs[$key][$val]  :  false ; 
		if($check_type == 'in_array')
		return (is_array( $this->configs[$key]) && in_array( $val , $this->configs[$key] ))  ? true  :  false ; 
	}




	public function get_filds($tbl)
	{

		 $arr = array();
         $table_exits = $this->ci->db->table_exists($tbl);  
		 if(!$table_exits) return false;
		 $fields      = $this->ci->db->list_fields($tbl);
		 foreach ($fields as $field)
		 {
			 if(! $this->check_config('ignor' , $field , 'in_array' ))
			 {
				 $label = $this->check_config('labels' , $field ) ;
				 $arr[] = array('label' => ($label) ? $label : $field , 'name'=>$field );
			 }
		 } 	
		 $this->filds = $arr ;	
		 $this->get_html_inputs();
		 return true ; 
	}
	
	
	public function get_html_inputs(){

		foreach($this->filds as $k=>$v )
		{
			$fild = $v['name'];
			$type = isset($this->configs['inp_type'][$fild]) ? $this->configs['inp_type'][$fild]: 'text';
			$val  = isset($this->row->$fild) ? $this->row->$fild : '' ; 
			switch($type)
			{
				 case 'textarea':
				 $this->filds[$k]['input'] = '<textarea name="crud_inputs['.$fild.']" >'.$val.'</textarea>';
				 break;

				 case 'rich_textarea':
				 $this->filds[$k]['input'] = '<textarea id="rich_'.$fild.'"
				  name="crud_inputs['.$fild.']" >'.$val.'</textarea>';
				  $this->configs['documentready'][] = '$("#rich_'.$fild.'").markItUp();';
				 break;


				 case 'checkbox':
				 $implode = isset($this->configs['implode'][$fild]) ? $this->configs['implode'][$fild]  : 
				 $this->configs['default_implode'];
				 
				 $expl_val = ($val != '' && isset( $this->configs['implode'][$fild]) ) ? explode($implode , $val) 
				 : (array)$val ;
				 
				 $this->filds[$k]['input'] = '<ul>' ;
				 if(isset($this->configs['options'][$fild]) && is_array($this->configs['options'][$fild]))
				 {
					 foreach($this->configs['options'][$fild] as $ok=>$ov )
					 {
						 if(is_array($ov))
						 {
						   $class = $ov['class'];
						   $ov = $ov['val'];
						 }
						 else
						 {
						   $class = $fild.'_'.$ov;
						 }
					 
						 $this->filds[$k]['input'] .= '<li><input  class="'.$class.'" name="crud_inputs['.$fild.'][]" type="checkbox" 
						 value="'.$ov.'"';
						 $this->filds[$k]['input'] .= ($val != '' && in_array($ov ,$expl_val) ) ?
						  'checked="checked" />' :  '/>' ;
						  
						 $this->filds[$k]['input'] .= $ok.' <br />';
					 }
					
						$this->filds[$k]['input'] .= '<input type="hidden" name="implode['.$fild.']" 
						value="'.$implode.'" /></li>' ;
				 }
				 $this->filds[$k]['input'] .= '</ul>' ;
				 
				 break;

				 case 'radio':
				 $this->filds[$k]['input'] = '' ;
				 if(isset($this->configs['options'][$fild]) && is_array($this->configs['options'][$fild]))
				 {
					 foreach($this->configs['options'][$fild] as $ok=>$ov )
					 {
						 $this->filds[$k]['input'] .= '<input name="crud_inputs['.$fild.']"
						  type="radio" value="'.$ov.'"';
						 $this->filds[$k]['input'] .= ($val != '' && $val == $ov ) ? ' checked="checked"  />' :  '/>' ;
						 $this->filds[$k]['input'] .= $ok.' <br />';
					 }
				 }
				 break;


				 case 'select':
				 $this->filds[$k]['input'] = '<select name="crud_inputs['.$fild.']" >' ;
				 if(isset($this->configs['options'][$fild]) && is_array($this->configs['options'][$fild]))
				 {
					 foreach($this->configs['options'][$fild] as $ok=>$ov )
					 {
						 $this->filds[$k]['input'] .= '<option value="'.$ov.'"  ';
						 $this->filds[$k]['input'] .= ($val != '' && $val == $ov ) ? ' selected="selected" >' :  '>' ;
						 $this->filds[$k]['input'] .= $ok.' </ option>';
					 }
				 }
				 $this->filds[$k]['input'] .= '</select>' ;
				 break;
				 
				 

				 default:
				 $this->filds[$k]['input'] = '<input name="crud_inputs['.$fild.']" type="text" value="'.$val.'">';
				 break;
			}
			
		}
		
	}


	function add($tbl = '' ){
        
		if(! $this->get_filds($tbl) )
		return $this->error(1);

		$this->view = $this->allviews['add'];
		$data   = $this->load_data();
		$data['crud_data']  = $this->filds  ;
		$data['tbl']        = $tbl ;
		return $this->ci->load->view($this->view , $data , TRUE ); 
	}
	

	function list_($tbl = '' ){
		
	  
		if(! $this->get_filds($tbl) )
		return $this->error(1);
       
	    $this->load->library('pagination');
		$this->ci->load->model('m_crud');
		
		$per_page            = $this->configs['per_page']; 
		$data['list_data']   = $this->ci->m_crud->list_($tbl , $this->configs['per_page'] );
		$total               = $this->ci->m_crud->list_($tbl);
		$data['total_count']= $total->num_rows();

		$this->view         = $this->allviews['list'];
		$data               = $this->load_data($data);
		$data['crud_data']  = $this->filds  ;
		$data['tbl']        = $tbl ;
		
		return $this->ci->load->view($this->view , $data , TRUE ); 
	}


	function edit($id =0 , $tbl = ''  ){
		 
		
        $this->view = $this->allviews['edit'];
		$get = $this->db->where( $this->configs['id_fild'] , $id )->get($tbl);
		if($get->num_rows() == 0)
		return $this->error(3);
		
		$this->row = $get->row();

		if(! $this->get_filds($tbl) )
		return $this->error(1);
		
		$data   = $this->load_data();
		$data['crud_data']  = $this->filds  ;
		$data['tbl']        = $tbl ;
		$data['id']         = $id ;
		return $this->ci->load->view($this->view , $data , TRUE ); 
	}




	
	
		function load_data($data = array())
	{
		$data['documentready']    = $this->configs['documentready'];
		$data['redirect']         = $this->configs['redirect'] ;
		$data['per_page']         = $this->configs['per_page'] ;
		$data['input']            = $this->configs['inp_type'] ;
		$data['default_implode']  = $this->configs['default_implode'] ;
		$data['crud_explode']     = $this->configs['crud_explode'] ;
		$data['id_fild']          = $this->configs['id_fild'] ;
		$data['edit_url']         = $this->configs['edit_url'] ;
		$data['check_duplicate']  = $this->configs['check_duplicate'] ;
		$data['validate']         = $this->configs['validate'] ;
		$data['fail_url']         = $this->configs['fail_url'] ;
		$data['get_replace']      = $this->configs['get_replace'] ;
		$data['append']           = $this->configs['append'] ;
		$data['helper']           = $this->configs['helper'] ;
		$data['H_Addon']          = $this->configs['H_Addon'] ;
		$data['md_options']       = $this->configs['md_options'];
		$data['lang']             = $this->configs['lang'];
		$data['per_page']         = $this->configs['per_page'] ;
		$data['search']           = $this->configs['search'] ;
		$data['sort']             = $this->configs['sort'] ;
		$data['labels']           = $this->configs['labels'] ;
		return $data;
	}


	function error($id = 0 ){
        
		$this->view = $this->allviews['err'];
		$data['crud_data'] =  $this->errors[$id];
		return $this->ci->load->view($this->view , $data , TRUE ); 
	}


}
?>
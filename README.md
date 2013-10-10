# mz-codeigniter-crud

crud system for codeigniter , ajax delete and insert + list + auto search , sort , pagination ....


## Requirements

1. PHP 5.2 or greater
2. CodeIgniter 

## Installation

copy the files in the root of your codeigniter application 

## List

list set of data from your database :

	$config['labels'] = array( 'username'=>'Username' , 'email'=>' Email' );
	$this->mz_crud->set_config($config);
	$dataTable = $this->mz_crud->list_('users');

##Insert

	$config['labels']  = array( 'username'=>'Alias' , 'email'=>'Email' , 'about_me'=> 'About Me' );
	$config['ignor']  = array('id');
	$config['check_duplicate']  = array( 'username' , 'email' );
	$config['redirect']  = base_url().'index/crudList/';
	$config['inp_type']  = array('username'=>'text' , 'about_me'=>'rich_textarea');

	$this->mz_crud->set_config($config);
	$insertTable = $this->mz_crud->add('users');
##Edit

	$config['labels']  = array( 'username'=>'Alias' , 'email'=>'Email' , 'about_me'=> 'About Me' );
	$config['ignor']  = array('id');
	$config['check_duplicate']  = array( 'username' , 'email' );
	$config['redirect']  = base_url().'index/crudList/';
	$config['inp_type']  = array('username'=>'text' , 'about_me'=>'rich_textarea');

	$this->mz_crud->set_config($config);
	$insertTable = $this->mz_crud->edit( $id , 'users');

	*see the sample code for more information
	 

##Preferences

The preferences described below .

Note that not all preferences are availabel for every function.

 <table cellpadding="0" cellspacing="1" border="0" style="width:100%" class="tableborder">
<tbody><tr>
<th>Preference</th>
<th>Default&nbsp;Value</th>
<th>value</th>
<th>Description</th>
<th>Availability</th>
</tr>

<tr>
<td class="td"><strong>labels</strong></td>
<td class="td">database column label</td>
<td class="td">array of 'column'=&gt;'label' pairs </td>
<td class="td">Sets the label for each database column in the view</td>
<td class="td">all</td>
</tr>

<tr>
<td class="td"><strong>ignor</strong></td>
<td class="td">None</td>
<td class="td">array of columns</td>
<td class="td">Sets column that should be ignored in the operation </td>
<td class="td">all</td>
</tr>

<tr>
<td class="td"><strong>redirect</strong></td>
<td class="td">current_url()</td>
<td class="td">string</td>
<td class="td">Sets the  redirect URL after operation  (edit <br>
  , insert ) </td>
<td class="td">add , edit </td>
</tr>

<tr>
<td class="td"><strong>edit_url</strong></td>
<td class="td">current_url()</td>
<td class="td">string</td>
<td class="td">Sets the Url to Edit function</td>
<td class="td">list_</td>
</tr>


<tr>
<td class="td"><strong>fail_url</strong></td>
<td class="td">current_url()</td>
<td class="td">string</td>
<td class="td">Sets the  redirect URL after operation fails</td>
<td class="td">add , edit </td>
</tr>


<tr>
<td class="td"><strong>inp_type</strong></td>
<td class="td">type="text"</td>
<td class="td">array of 'column'=&gt;'input type' pairs </td>
<td class="td">Sets the Html input type for each column.</td>
<td class="td">all</td>
</tr>

<tr>
<td class="td"><strong>options</strong></td>
<td class="td">empty array</td>
<td class="td">2d array of 'column'=&gt;array('option label'=&gt;'option value') </td>
<td class="td">Sets the selectable options for input_type of (select , checkbox , radio )</td>
<td class="td">all</td>
</tr>


<tr>
<td class="td"><strong>check_duplicate</strong></td>
<td class="td">None</td>
<td class="td">array of columns</td>
<td class="td">checks the database for duplicate before insert or edit </td>
<td class="td">all</td>
</tr>

<tr>
<td class="td"><strong>md_options</strong></td>
<td class="td">None</td>
<td class="td">array( 'add' , 'edit' , 'delete')</td>
<td class="td">Sets the moderating options for a list .</td>
<td class="td">list_</td>
</tr>

<tr>
<td class="td"><strong>id_fild</strong></td>
<td class="td">id</td>
<td class="td">string</td>
<td class="td">sets the id colum in database</td>
<td class="td">edit</td>
</tr>

<tr>
<td class="td"><strong>per_page</strong></td>
<td class="td">0</td>
<td class="td">int</td>
<td class="td"> sets the per page option for pagination  ( 0 == no pagination )</td>
<td class="td">list_</td>
</tr>

<tr>
<td class="td"><strong>search</strong></td>
<td class="td">empty array</td>
<td class="td">array of columns</td>
<td class="td">sets the searchable colums and adds a search option to the list </td>
<td class="td">list_</td>
</tr>


<tr>
<td class="td"><strong>sort</strong></td>
<td class="td">empty array</td>
<td class="td">array of columns</td>
<td class="td">sets the sortable colums and adds a sort option to the list </td>
<td class="td">list_</td>
</tr>




<tr>
<td class="td"><strong>documentready</strong></td>
<td class="td">ampty array</td>
<td class="td">array</td>
<td class="td">javascript commands  to be run on document ready </td>
<td class="td">all</td>
</tr>

<tr>
<td class="td"><strong>lang</strong></td>
<td class="td">array('file'=&gt;'crud' , 'folder'=&gt;'crud')</td>
<td class="td">array</td>
<td class="td">sets the address for language file</td>
<td class="td">all</td>
</tr>

</tbody></table>

##sample code

lets say we have a table called "users" 
users : id , username , email , recive_newsletter , profile

	class index extends CI_Controller { 

		function crudList(){ 

			$this->load->library('mz_crud');

			$config['ignor']  = array('id' , 'recive_newsletter' , 'profile' );
			$config['check_duplicate']  = array( 'username' , 'email');
			$config['edit_url']    = base_url().'index/crudEdit/';
			$config['md_options']  = array( 'add' , 'edit' , 'delete');
			$config['labels']    = array( 'username'=>'UserName' , 'email'=>'Email);
			$config['per_page']  = 2;
			$config['search']    = array( 'username' , 'email');
			$config['sort']      = array( 'username');

			$this->mz_crud->set_config($config);
			echo $this->mz_crud->list_('users');

		}


		function crudInsert(){

			$this->load->library('mz_crud');

			$config['labels']  = array('username'=>'UserName' , 'email'=>'Email' , 'recive_newsletter'=>'would you like to recive our newsletter' , 'profile'=>'Choose how you share information on your profile ?');
			$config['ignor']   = array('id');
			$config['check_duplicate']  = array( 'username' , 'email' );
			$config['redirect']  = base_url().'index/crudList/';
			$config['inp_type']  = array('newsletter'=>'select' , 'profile'=>'radio');
			$config['options']   = array('newsletter'=>array('Yes , i do'=>'1' , 'No , thanx '=>'0' ) ,
			'profile'=>array('i want a public profile '=>'public' , 'i want a private profile'=>'private' ));
			$config['documentready']  = array('alert("Please fill in all fields ");');

			$this->mz_crud->set_config($config);
			echo $this->mz_crud->add('users');

		}




		function crudEdit( $id = 0 ){

			$this->load->library('mz_crud');

			$config['labels']  = array('username'=>'UserName' , 'email'=>'Email' , 'recive_newsletter'=>'would you like to recive our newsletter' , 'profile'=>'Choose how you share information on your profile ?');
			$config['ignor']   = array('id');
			$config['check_duplicate']  = array( 'username' , 'email' );
			$config['redirect']  = base_url().'index/crudList/';
			$config['inp_type']  = array('newsletter'=>'select' , 'profile'=>'radio');
			$config['options']   = array('newsletter'=>array('Yes , i do'=>'1' , 'No , thanx '=>'0' ) ,
			'profile'=>array('i want a public profile '=>'public' , 'i want a private profile'=>'private' ));
			$config['documentready']  = array('alert("Please fill in all fields ");');

			$this->mz_crud->set_config($config);
			echo $this->mz_crud->edit( $id , 'users');

		}


	}


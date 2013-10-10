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


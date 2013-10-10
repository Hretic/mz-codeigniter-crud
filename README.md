mz-codeigniter-crud
===================

crud system for codeigniter , ajax delete and insert + auto search , sort , pagination ....

<code>

$config['labels'] = array( 'username'=>'Username' , 'email'=>' Email' );
$this->mz_crud->set_config($config);
$dataTable = $this->mz_crud->list_('users');

</code>
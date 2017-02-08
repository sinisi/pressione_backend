<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

	//REF: http://www.redbeanphp.com/index.php
	require_once('lib/rb.php');
	R::setup( 'mysql:host=127.0.0.1:3306;dbname=pa-master','pa', 'pressione' );
        
        $error="";
	$table='pressione';
	$record=(empty($_REQUEST['id'])) ?  R::dispense($table) : R::load($table, intval($_REQUEST['id']));	
	try {
		if ($record && !empty($_REQUEST['act']) && $_REQUEST['act']=='del') R::trash($record);
		
                /*if (isset($_POST['datamisurazione'])){       
			foreach ($_POST as $k=>$v){
				$record[$k]=$_POST[$k];
			}
		}*/
                
                $new = json_decode(file_get_contents('php://input'),true);
                
                if(!empty($new)){
                    foreach ($new as $k=>$v) {
                        $record[$k] = $new[$k];
                    }
                R::store($record);
                }
                
	} catch (RedBeanPHP\RedException\SQL $e) {
		
	}	
	$pa=R::find($table);
        
        echo json_encode($pa);

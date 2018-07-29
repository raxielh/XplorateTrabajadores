<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use Flash;
use Exception;

class ImportarController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
    	$campus = DB::select("SELECT * FROM ps_campus");
    	$tipo = DB::select("SELECT * FROM b_tipoempleado");
    	$cargo = DB::select("SELECT * FROM b_cargo");
    	$programa = DB::select("SELECT * FROM ps_acad_prog where acad_career='PREG' order by campus");

    	return view('importar.index')->with('campus', $campus)->with('programa', $programa)->with('tipo', $tipo)->with('cargo', $cargo);
    }

    public function index2(request $request)
    {
    	$fileName = date('Y_m_d H').'.'.$request->file('archivo')->getClientOriginalExtension();
    	$input = $request->file('archivo');
	    $request->file('archivo')->move(
	    	base_path().'/public/datos/',$fileName
	    );
	    $url = base_path().'/public/datos/'.$fileName;
    
    	//return ($url);
    	set_time_limit(0);
    	Excel::load($url, function($reader) {
    		foreach ($reader->get() as $persona) {
    			//echo $persona;

    			$c=DB::select("SELECT count(*) as c FROM b_persona_categoria WHERE cedula=".$persona->cedula);
    			foreach ($c as $c) {
				    if($c->c==0){

					    DB::select("
							INSERT INTO `b_persona_categoria` (
							  `persona_categoria`,
							  `cedula`,
							  `tipoempleado`,
							  `acad_prog`,
							  `cargo`,
							  `campus`,
							  `numero_rowdata`,
							  `nombres`
							) 
							VALUES
							  (
							    null,
							    '".$persona->cedula."',
							    '".$persona->tipoempleado."',
							    '".$persona->acad_prog."',
							    '".$persona->cargo."',
							    '".$persona->campus."',
							    0,
							    '".$persona->nombres."'
							  ) ;
				        ");

				    }
				}
		    
    		}
    	});

    	return view('importar.render');
  
    }

}

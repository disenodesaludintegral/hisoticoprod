<?php
require_once 'conexion.php'; 
class ReporteadorHistorico{

	#-- FILTROS DE ENCUESTAS--#
	
	#-- TRAER LOS SITIOS ASIGNADOS --#

	static public function getSitiosAsignados($userId){
		$stmt = Conexion::Conectar()->prepare("SELECT mb.id_miembro,
					a.clave_hosp
					FROM directorio.miembros mb 
					LEFT JOIN directorio.asignacion_hospitales AS a 
					ON a.id_miembro = mb.id_miembro 
					AND a.active = 1
					WHERE mb.user_id = $userId
					ORDER BY a.clave_hosp ASC");
		try{
			if($stmt->execute()){
				return  $stmt->fetchAll(PDO::FETCH_ASSOC);
			}else{
				return 0;
			}
		
		}catch(PDOException $e){
			return 0;
		}
		$stmt->close();
	}


	static public function getSitiosAsignadosFull(){
		$stmt = Conexion::Conectar()->prepare("SELECT hosp_alias FROM hovahlt.hospital WHERE nomSuper NOT LIKE '' and hosp_status = 1  ORDER BY hosp_alias");
		try{
			if($stmt->execute()){
				return  $stmt->fetchAll(PDO::FETCH_ASSOC);
			}else{
				return 0;
			}
		
		}catch(PDOException $e){
			return 0;
		}
		$stmt->close();
	}


	static public function getSitiosAsignadosUsuarios(){
		$stmt = Conexion::Conectar()->prepare("SELECT hosp_alias FROM hovahlt.hospital WHERE nomSuper NOT LIKE '' and hosp_status = 1  ORDER BY hosp_alias");
		try{
			if($stmt->execute()){
				return  $stmt->fetchAll(PDO::FETCH_ASSOC);
			}else{
				return 0;
			}
		
		}catch(PDOException $e){
			return 0;
		}
		$stmt->close();
	}

	static public function getModalidades(){
		$stmt = Conexion::Conectar()->prepare("SELECT clave_mod FROM modalidades.modalidades_itop 
			GROUP BY clave_mod
			ORDER BY id_mod  DESC");
		try{
			if($stmt->execute()){
				return  $stmt->fetchAll(PDO::FETCH_ASSOC);
			}else{
				//echo "No se ejecuto";
				return 0;
			}
		
		}catch(PDOException $e){
			//echo "No se ejecuto cARCH". $e;
			return 0;
		}
		$stmt->close();
	}

	#-- QUERYS DE INFOMACIÓN -- #

	#--TRAER TODA LA INFORMACION DE LOS ESTUDIOS LOCAL--#
	static public function getInfoAllLocal($tabla, $parametros){

	
		$stmt = Conexion::Conectar()->prepare("SELECT 
			COUNT(EL.id_estudio) as 'CUANTO', 
			EL.clave as 'Clave',
			hvp.hosp_corto as 'NCorto',
           	 (CASE
                WHEN MONTH(EL.study_Date_Time) = '01'
                THEN 'ENERO'
             WHEN MONTH(EL.study_Date_Time) = '02'
                THEN 'FEBRERO'
             WHEN MONTH(EL.study_Date_Time) = '03'
                THEN 'MARZO'
             WHEN MONTH(EL.study_Date_Time) = '04'
                THEN 'ABRIL'
             WHEN MONTH(EL.study_Date_Time) = '05'
                THEN 'MAYO'
             WHEN MONTH(EL.study_Date_Time) = '06'
                THEN 'JUNIO'
             WHEN MONTH(EL.study_Date_Time) = '07'
                THEN 'JULIO'
             WHEN MONTH(EL.study_Date_Time) = '08'
                THEN 'AGOSTO'
             WHEN MONTH(EL.study_Date_Time) = '09'
                THEN 'SEPTIEMBRE'
             WHEN MONTH(EL.study_Date_Time) = '10'
                THEN 'OCTUBRE'
             WHEN MONTH(EL.study_Date_Time) = '11'
                THEN 'NOVIEMBRE'
             WHEN MONTH(EL.study_Date_Time) = '12'
                THEN 'DICIEMBRE'
                
            END) as 'Mes'
            
			FROM $tabla EL 
			LEFT JOIN hovahlt.hospital hvp on hvp.hosp_alias = EL.clave
			where year(EL.study_Date_Time) = '2021'
           /* and EL.clave  LIKE '%CHIS%'*/
            GROUP BY MONTH(EL.study_Date_Time), EL.clave
            ORDER BY EL.clave, MONTH(EL.study_Date_Time)");
		try{
			if($stmt->execute()){
				return  $stmt->fetchAll(PDO::FETCH_ASSOC);
			}else{
				return 0;
			}
		
		}catch(PDOException $e){
			return 0;
		}
		$stmt->close();
	}

	#--TRAER TODA LA INFORMACION DE LOS ESTUDIOS CENTRAL--#
	static public function getInfoAllCentral($tabla, $parametros){

	
		$stmt = Conexion::Conectar()->prepare("SELECT 
			COUNT(EL.id_estudio) as 'CUANTO', 
			EL.clave as 'Clave',
			hvp.hosp_corto as 'NCorto',
           	 (CASE
                WHEN MONTH(EL.study_Date_Time) = '01'
                THEN 'ENERO'
             WHEN MONTH(EL.study_Date_Time) = '02'
                THEN 'FEBRERO'
             WHEN MONTH(EL.study_Date_Time) = '03'
                THEN 'MARZO'
             WHEN MONTH(EL.study_Date_Time) = '04'
                THEN 'ABRIL'
             WHEN MONTH(EL.study_Date_Time) = '05'
                THEN 'MAYO'
             WHEN MONTH(EL.study_Date_Time) = '06'
                THEN 'JUNIO'
             WHEN MONTH(EL.study_Date_Time) = '07'
                THEN 'JULIO'
             WHEN MONTH(EL.study_Date_Time) = '08'
                THEN 'AGOSTO'
             WHEN MONTH(EL.study_Date_Time) = '09'
                THEN 'SEPTIEMBRE'
             WHEN MONTH(EL.study_Date_Time) = '10'
                THEN 'OCTUBRE'
             WHEN MONTH(EL.study_Date_Time) = '11'
                THEN 'NOVIEMBRE'
             WHEN MONTH(EL.study_Date_Time) = '12'
                THEN 'DICIEMBRE'
                
            END) as 'Mes'
            
			FROM $tabla EL 
			LEFT JOIN hovahlt.hospital hvp on hvp.hosp_alias = EL.clave
			where year(EL.study_Date_Time) = '2021'
            and EL.clave  LIKE '%CHIS%'
            GROUP BY MONTH(EL.study_Date_Time), EL.clave
            ORDER BY EL.clave, MONTH(EL.study_Date_Time)");
		try{
			if($stmt->execute()){
				return  $stmt->fetchAll(PDO::FETCH_ASSOC);
			}else{
				return 0;
			}
		
		}catch(PDOException $e){
			return 0;
		}
		$stmt->close();
	}



	
}
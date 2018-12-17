<?php
$base = __DIR__ . '/..';
require_once("$base/lib/resposta.class.php");
require_once("$base/lib/database.class.php");

class Autor
{
    private $conn;       //connexió a la base de dades (PDO)
    private $resposta;   // resposta
    
    public function __CONSTRUCT()
    {
        $this->conn = Database::getInstance()->getConnection();      
        $this->resposta = new Resposta();
    }
    
    public function getAll($orderby="id_aut")
    {
		try
		{
			$result = array();                        
			$stm = $this->conn->prepare("SELECT id_aut,nom_aut,fk_nacionalitat FROM autors ORDER BY $orderby");
			$stm->execute();
            $tuples=$stm->fetchAll();
            $this->resposta->setDades($tuples);    // array de tuples
			$this->resposta->setCorrecta(true);       // La resposta es correcta        
            return $this->resposta;
		}
        catch(Exception $e)
		{   // hi ha un error posam la resposta a fals i tornam missatge d'error
			$this->resposta->setCorrecta(false, $e->getMessage());
            return $this->resposta;
		}
    }
    /*Funcion para obtener el autor con un id especifico*/
    public function get($id)
    {
        try
		{
			$result = array();                        
            $stm = $this->conn->prepare("SELECT id_aut,nom_aut,fk_nacionalitat FROM autors WHERE ID_AUT =:id");
            /*Comprovar la insercion de codigo*/
            $stm->bindValue(':id',$id);
			$stm->execute();
            $tuples=$stm->fetchAll();
            $this->resposta->setDades($tuples);    // array de tuples
			$this->resposta->setCorrecta(true);       // La resposta es correcta        
            return $this->resposta;
		}
        catch(Exception $e)
		{   // hi ha un error posam la resposta a fals i tornam missatge d'error
			$this->resposta->setCorrecta(false, $e->getMessage());
            return $this->resposta;
		}


    }
    
    public function insert($nombre,$pais)
    {
		try 
		{
                $sql = "SELECT max(id_aut) as N from autors";
                $stm=$this->conn->prepare($sql);
                $stm->execute();
                $row=$stm->fetch();
                $id_aut=$row["N"]+1;

                $insertar = "INSERT INTO autors
                            (id_aut,nom_aut,fk_nacionalitat)
                            VALUES (:id,:nom,:nacionalidad)";
                
                $stm=$this->conn->prepare($insertar);
                $stm->bindValue(':id',$id_aut);
                $stm->bindValue(':nom',$nombre);
                $stm->bindValue(':nacionalidad',!empty($pais)?$pais:NULL,PDO::PARAM_STR);
                $stm->execute();
            
       	        $this->resposta->setCorrecta(true);
                return $this->resposta;
        }
        catch (Exception $e) 
		{
                $this->resposta->setCorrecta(false, "Error insertant: ".$e->getMessage());
                return $this->resposta;
		}
    }   
    
    public function update($data,$id,$nacionalidad)
    {
        try
		{
            $result = array();           
            $stm = $this->conn->prepare("UPDATE autors SET nom_aut =:data,fk_nacionalitat =:nacionalidad where ID_AUT =:id");          
            /*Comprovar la insercion de codigo*/
            $stm->bindValue(':id',$id);
            $stm->bindValue(':data',$data);
            $stm->bindValue(':nacionalidad',$nacionalidad);
			$stm->execute();
			$this->resposta->setCorrecta(true);       // La resposta es correcta        
            return $this->resposta;
		}
        catch(Exception $e)
		{   // hi ha un error posam la resposta a fals i tornam missatge d'error
			$this->resposta->setCorrecta(false, $e->getMessage());
            return $this->resposta;
		}


    }

    
    
    public function delete($id)
    {
        try
		{
            $result = array();           
            $stm = $this->conn->prepare("DELETE from AUTORS where ID_AUT =:id");          
            /*Comprovar la insercion de codigo*/
            $stm->bindValue(':id',$id);
			$stm->execute();
			$this->resposta->setCorrecta(true);       // La resposta es correcta        
            return $this->resposta;
		}
        catch(Exception $e)
		{   // hi ha un error posam la resposta a fals i tornam missatge d'error
			$this->resposta->setCorrecta(false, $e->getMessage());
            return $this->resposta;
		}
    }

    public function filtra($where,$orderby,$offset,$count)
    {
        // TODO
    }
    
          
}

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MyModel
 *
 * @author yen
 */
class CRUD_Model extends CI_Model{
    function __construct() {
        parent::__construct();
    }
    
    /*GET($ID, $TABEL) : Geeft 1 row terug uit een specifieke tabel ($TABEL) met 
     * een specifieke id ($ID). 
     * Datatype(s) van variabele(n): $ID - INTEGER, $TABEL - STRING*/
    function get($id, $tabel) {
        $this->db->where('id', $id);
        $query = $this->db->get($tabel);
        return $query->row();  
    }
    
    /*GETALL($TABEL) : Geeft alle records terug van een specifieke tabel ($TABEL).
     * Datatype(s) van variabele(n): $TABEL - STRING*/
    function getAll($tabel) {
        $query = $this->db->get($tabel);
        return $query->result();
    }
    
    /*UPDATE($ID, $DATA, $TABEL) : Update een record met een speciefieke id ($ID)
     * in een specifieke tabel ($TABEL). $DATA verwijst naar het data object dat
     * ook moet worden meegegeven, wat er in die record moet komen.
     * Datatype(s) van variabele(n): $ID - INTEGER, $DATA - STRING ARRAY/OBJECT, $TABEL - STRING*/
    function update($id, $data, $tabel) {
        $this->db->where('id', $id);
        $this->db->update($tabel, $data);
    }
    
    /*DELETE($ID, $TABEL) : Delete een record met een specifiek id ($ID) in een 
     * specifieke tabel ($TABEL).
     * Datatype(s) van variabele(n): $ID - INTEGER, $TABEL - STRING*/
    function delete($id, $tabel) {
        $this->db->where('id', $id);
        $this->db->delete($tabel);
    }
    
    /*ADD($DATA) : Voegt een rij toe aan een speciefieke tabel ($TABEL). 
     * $DATA verwijst naar het data object dat ook moet worden meegegeven, 
     * wat er in die record moet komen.
     * Datatype(s) van variabele(n): $DATA - STRING ARRAY/OBJECT, $TABEL - STRING*/
    function add($data, $tabel) {
        $this->db->insert($tabel, $data);
    }
    
    //Functies voor taken: BEGIN
    
    /*GETALLBYCOLUMN($DATA) : Geeft alle rijen uit een specifieke tabel ($TABLE) waardat een gegeven ($DATA) overeenkomt met een waarde in een kolom ($COLUMN). 
     * $DATA verwijst naar get gegeven om mee te vergelijken. 
     * $COLUMN verwijst naar de kolomnaam.
     * $TABLE verwijst naar de tabelnaam.
     * Datatype(s) van variabele(n): $DATA - STRING/INTEGER, $COLUMN - STRING, $TABLE - STRING*/
    function getAllByColumn($data, $column, $table) {
        $this->db->where($column, $data);
        $query = $this->db->get($table);
        return $query->result();
    }
    
    /*GETLAST($COLUMN, $TABLE) : Geeft laatste rij uit een spciefieke tabel ($TABLE) van een specifieke kolom ($COLUMN). 
     * $COLUMN verwijst naar kolomnaam
     * $TABLE verwijst naar tabelnaam
     * Datatype(s) van variabele(n): $COLUMN - STRING, $TABLE - STRING*/
    function getLast($column, $table) {
        $this->db->select_max($column);
        $query = $this->db->get($table);
        return $query->row();
    }
    
    
    //Funties voor taken: END
}

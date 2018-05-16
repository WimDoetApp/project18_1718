<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pipeline_Model
 *
 * @author yen
 */
class Pipeline_Model extends CI_Model{
    function __construct() {
        parent::__construct();
    }
    
    /**
     * Pipeline model is a special pipeline spanning mutiple tables, being a pipeline
     * to and from them. This model is the pipeline between the tables: Taak, TaakShift
     * and helperTaak. This model gathers information to send e-mails.
    
     * The first required value when calling is the $level variable. This value
     * determines what needs to be executed, it also has effect on the use of the two
     * following values. $level has [3] possible values, the minimum being 1 and the
     * maximum being 3.
     *     1: Use when deleting one shift
     *     2: Use when deleting on whole task with one or more shifts
     *     3: Use when deleting one whole dagOnderdeel with one or more tasks with
     *     those tasks having one or more shifts
    
     * The second value is: $id. This value is influensed bu the $level value. The $id
     * value is the id that is used on a particular field of a table. Because it is
     * influenced by the $level value, which has a range from 1 to 3 the meaning of the
     * $id value varies. Here is an overview
     *     1: $id is the value from the id column shiftId from the table helperTaak
     *     2: $id is the value from the id column shiftId from the table taakShift
     *     3: look for the explenation of the $isD value.
    
     * The third value is: $isD or: does $id refer to a DagOnderdeel or not? This
     * value influences the use of the $id value. The $isD value is only used if
     * the $level value is 3. Following things will happen:
     *      1: $id value refers to the column optieId of the table  if $isD is FALSE
     *      2: $id value refers to the table dagOnderdeelId is $isD is TRUE
     * The $isD value is not used when the $level value is anything else than 3
     * 
     * The RETURNARRAY will be covered here >>START<<
     *      TAKEN:: will hold the array $taken or the value $taakId when the value $level is 3
     *      SHIFTEN:: Will hold the array $shiften or the value $shiftId when the value $level is 2 or higher
     *      HELPERS:: Will hold the array $helpers
     *      VRIJWILLIGERS:: Will hold the array $vrijwilligers
     *      ISD:: Will hold the value $isD
     *      LEVEL:: Will hold the value $level
     * >>END<<
    */
    public function pl_Mail($level, $id, $isD = false) {
        /// Ready Everything
        $this->load->model('CRUD_Model');
        $doColumn = ($isD) ? "dagOnderdeelId" : "optieId";
        $vrijwilligers = array();
        $helpers = array();
        $shiften = array();
        
        ///Get all the IDs and Objects to get all the Deelnemers later.
        if ($level >= 3) {
            $taken = $this->CRUD_Model->getAllByColumn($id, $doColumn, 'taak');
        }
        
        if ($level >= 2) {
            if (isset($taken) && $level >= 3) {
                foreach ($taken as $taak) {
                    $shiften["$taak->id"] = $this->CRUD_Model->getAllByColumn($taak->id, 'taakId', 'taakShift');
                }
            } else {
                $shiften = $this->CRUD_Model->getAllByColumn($id, 'taakId', 'taakShift');
                $taakId = $id;
            }
        }
        
        if ($level >= 1) {
            if (isset($taken) && $level >= 3) {
                foreach ($taken as $taak) {
                    foreach ($shiften["$taak->id"] as $shift) {
                        $helpers["$taak->id-$shift->id"] = $this->CRUD_Model->getAllByColumn($shift->id, 'taakShiftId', 'helperTaak');
                    }
                }
            } elseif (isset ($taakId) && $level == 2) {
                foreach ($shiften as $shift) {
                    $helpers["$shift->id"] = $this->CRUD_Model->getAllByColumn($shift->id, 'taakShiftId', 'helperTaak');
                }
            } else {
                $helpers = $this->CRUD_Model->getAllByColumn($id, 'taakShiftId', 'helperTaak');
                $shiftId = $id;
                $shiftT = $this->CRUD_Model->get($id, 'taakShift');
                $taakId = $shiftT->taakId;
            }
        }
        
        ///Gather all email addresses from the table Deelnemers
        if ($level >= 3 && isset($taken)) {
            foreach ($taken as $taak) {
                foreach ($shiften["$taak->id"] as $shift) {
                    foreach ($helpers["$taak->id-$shift->id"] as $helper) {
                        $vrijwilligers["$taak->id-$shift->id-$helper->deelnemerId"] = $this->CRUD_Model->get($helper->deelnemerId, 'deelnemer');
                    }
                }
            }
        } elseif ($level == 2 && isset($taakId)) {
            foreach ($shiften as $shift) {
                foreach ($helpers["$shift->id"] as $helper) {
                    $vrijwilligers["$shift->id-$helper->deelnemerId"] = $this->CRUD_Model->get($helper->deelnemerId, 'deelnemer');
                }
            }
        } elseif ($level == 1 && isset($shiftId)) {
            foreach ($helpers as $helper) {
                $vrijwilligers["$helper->deelnemerId"] = $this->CRUD_Model->get($helper->deelnemerId, 'deelnemer');
            }
        }
        
        ///Return Array Builder
        $returnArray = array(
                "taken" => ($level >= 3) ? $taken : $taakId,
                "shiften" => ($level >= 2) ? $shiften : $shiftId,
                "helpers" => $helpers,
                "vrijwilligers" => $vrijwilligers
            );
        
        return $returnArray;
    }
}

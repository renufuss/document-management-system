<?php

namespace App\Models;

use CodeIgniter\Model;

class BoxModel extends Model
{
    protected $table      = 'app_box';

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['name'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function addToShelfs($boxId, $shelfId = [])
    {
        $tableRelation = $this->db->table('relation_box_shelf');
        $relation = [
            'box_id'  => $boxId,
            'shelf_id' => $shelfId,
        ];

        return $tableRelation->insert($relation);
    }

    public function removeFromShelfs($boxId)
    {
        $tableRelation = $this->db->table('relation_box_shelf');
        return $tableRelation
        ->where('box_id', $boxId)
        ->delete();
    }

    public function showShelfs($boxId)
    {
        $tableRelation = $this->db->table('relation_box_shelf');
        return $tableRelation
        ->select('shelf_id, app_shelf.name as shelfName')
        ->join('app_shelf', 'shelf_id=app_shelf.id')
        ->where('box_id', $boxId)
        ->get()->getResultObject();
    }
}

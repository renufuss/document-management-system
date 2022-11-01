<?php

namespace App\Models;

use CodeIgniter\Model;

class FolderModel extends Model
{
    protected $table      = 'app_folder';

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

    public function addToBoxs($folderId, $boxId = [])
    {
        $tableRelation = $this->db->table('relation_folder_box');
        $relation = [
            'folder_id'  => $folderId,
            'box_id' => $boxId,
        ];

        return $tableRelation->insert($relation);
    }

    public function removeFromBoxs($folderId)
    {
        $tableRelation = $this->db->table('relation_folder_box');
        return $tableRelation
        ->where('folder_id', $folderId)
        ->delete();
    }

    public function showBoxs($folderId)
    {
        $tableRelation = $this->db->table('relation_folder_box');
        return $tableRelation
        ->select('box_id, app_box.name as boxName')
        ->join('app_box', 'box_id=app_box.id')
        ->where('folder_id', $folderId)
        ->get()->getResultObject();
    }
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table      = 'app_order';

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

    public function addToFolders($orderId, $folderId = [])
    {
        $tableRelation = $this->db->table('relation_order_folder');
        $relation = [
            'order_id'  => $orderId,
            'folder_id' => $folderId,
        ];

        return $tableRelation->insert($relation);
    }

    public function removeFromFolders($orderId)
    {
        $tableRelation = $this->db->table('relation_order_folder');
        return $tableRelation
        ->where('order_id', $orderId)
        ->delete();
    }

    public function showFolders($orderId)
    {
        $tableRelation = $this->db->table('relation_order_folder');
        return $tableRelation
        ->select('folder_id, app_folder.name as folderName')
        ->join('app_folder', 'folder_id=app_folder.id')
        ->where('order_id', $orderId)
        ->get()->getResultObject();
    }
}

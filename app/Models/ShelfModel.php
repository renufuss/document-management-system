<?php

namespace App\Models;

use CodeIgniter\Model;

class ShelfModel extends Model
{
    protected $table      = 'app_shelf';

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['name'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [
        'name' => 'is_unique[app_room.name,id,{id}|alpha_numeric_space'
    ];
    protected $validationMessages = [
        'name' => [
            'alpha_numeric_space' => 'Nama hanya boleh angka atau huruf'
        ],
    ];
    protected $skipValidation     = false;

    public function addToRooms($shelfId, $roomId = [])
    {
        $tableRelation = $this->db->table('relation_shelf_room');
        $relation = [
            'shelf_id'  => $shelfId,
            'room_id' => $roomId,
        ];

        return $tableRelation->insert($relation);
    }

    public function removeFromRooms($shelfId)
    {
        $tableRelation = $this->db->table('relation_shelf_room');
        return $tableRelation
        ->where('shelf_id', $shelfId)
        ->delete();
    }

    public function showRooms($shelfId)
    {
        $tableRelation = $this->db->table('relation_shelf_room');
        return $tableRelation
        ->select('room_id, app_room.name as roomName')
        ->join('app_room', 'room_id=app_room.id')
        ->where('shelf_id', $shelfId)
        ->get()->getResultObject();
    }
}

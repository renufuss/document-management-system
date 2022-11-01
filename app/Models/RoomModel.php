<?php

namespace App\Models;

use CodeIgniter\Model;

class RoomModel extends Model
{
    protected $table      = 'app_room';

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

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
}

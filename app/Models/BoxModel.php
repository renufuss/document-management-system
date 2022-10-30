<?php

namespace App\Models;

use CodeIgniter\Model;

class BoxModel extends Model
{
    protected $table      = 'app_box';

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['name'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}

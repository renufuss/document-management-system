<?php

namespace App\Models;

use CodeIgniter\Model;

class DocumentModel extends Model
{
    protected $table      = 'app_document';

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['name','number','file','size','status','room_id','shelf_id','box_id','folder_id','order_id'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}

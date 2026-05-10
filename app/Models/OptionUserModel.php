<?php

namespace App\Models;

use CodeIgniter\Model;

class OptionUserModel extends Model
{
    protected $table = 'OptionUser';
    protected $primaryKey = 'id';
    protected $allowedFields = ['idUser', 'idOption', 'date_achat'];
    protected $useTimestamps = false;
}

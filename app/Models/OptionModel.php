<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\OptionUserModel;
use App\Models\UserModel;

class OptionModel extends Model
{
    protected $table = 'Option';
    protected $primaryKey = 'id';
    protected $allowedFields = ['label', 'prix', 'reduction'];
    protected $useTimestamps = false;

    public function getOptions(): array
    {
        return $this->orderBy('prix', 'ASC')->findAll();
    }

    public function purchaseOptionForUser(int $optionId, int $userId): array
    {
        $option = $this->find($optionId);
        if (!$option) {
            return ['success' => false, 'message' => 'Option introuvable.'];
        }

        $userModel = new UserModel();
        $user = $userModel->findUserById($userId);
        if (!$user) {
            return ['success' => false, 'message' => 'Utilisateur introuvable.'];
        }

        $optionUserModel = new OptionUserModel();
        $existing = $optionUserModel
            ->where('idUser', $userId)
            ->where('idOption', $optionId)
            ->first();

        if ($existing) {
            return ['success' => false, 'message' => 'Option deja achetee.'];
        }

        $price = is_numeric($option['prix']) ? (float) $option['prix'] : 0.0;
        $balance = is_numeric($user['balance']) ? (float) $user['balance'] : 0.0;

        if ($balance < $price) {
            return ['success' => false, 'message' => 'Balance insuffisante.'];
        }

        $db = $this->db;
        $db->transStart();

        $userModel->update($userId, ['balance' => $balance - $price]);
        $optionUserModel->insert([
            'idUser' => $userId,
            'idOption' => $optionId
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return ['success' => false, 'message' => 'Echec de la mise a jour.'];
        }

        return ['success' => true, 'message' => 'Option achetee avec succes.'];
    }
}
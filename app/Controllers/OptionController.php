<?php

namespace App\Controllers;

use App\Models\OptionModel;

class OptionController extends BaseController
{
    public function purchase()
    {
        $sessionUser = session()->get('user');
        $userId = session()->get('user_id') ?? ($sessionUser['id'] ?? null);

        if (!$sessionUser || !$userId) {
            return redirect()->to('/login');
        }

        if ($sessionUser['role'] === 'admin') {
            return redirect()->to('/admin/dashboard');
        }

        $optionId = (int) $this->request->getPost('option_id');
        if ($optionId <= 0) {
            return redirect()->back()->with('erreur', 'Option invalide.');
        }

        $optionModel = new OptionModel();
        $result = $optionModel->purchaseOptionForUser($optionId, (int) $userId);

        if ($result['success']) {
            return redirect()->to('/hero')->with('success', $result['message']);
        }

        return redirect()->back()->with('erreur', $result['message']);
    }
}

<?php

namespace App\Controllers;

use App\Models\OptionModel;
use App\Models\UserModel;

class HomeController extends BaseController
{
    public function index()
    {
        $user = session()->get('user');
        
        if ($user && $user['role'] === 'admin') {
            return redirect()->to('/admin/dashboard');
        }

        if ($user && $user['role'] === 'user') {
            return redirect()->to('/hero');
        }
        
        // Rediriger vers login au lieu d'afficher home.php
        return redirect()->to('/login');
    }

    public function hero()
    {
        $sessionUser = session()->get('user');
        $userId = session()->get('user_id') ?? ($sessionUser['id'] ?? null);

        if (!$sessionUser || !$userId) {
            return redirect()->to('/login');
        }

        if ($sessionUser['role'] === 'admin') {
            return redirect()->to('/admin/dashboard');
        }

        $userModel = new UserModel();
        $user = $userModel->findUserById((int) $userId);

        if (!$user) {
            return redirect()->to('/login');
        }

        $optionModel = new OptionModel();
        $options = $optionModel->getOptions();

        return view('hero', [
            'user' => $user,
            'options' => $options
        ]);
    }
}
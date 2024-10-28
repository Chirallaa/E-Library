<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProfileService;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{
    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function index()
    {
        $profile = $this->profileService->getUserProfile();
        return view('profile.tampil', ['profile' => $profile]);
    }

    public function edit()
    {
        $profile = $this->profileService->getUserProfile();
        return view('profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $this->profileService->updateProfile($request);
        Alert::success('Success', 'Berhasil Mengubah Profile');
        return redirect('/profile');
    }

    public function show($id)
    {
        $profile = $this->profileService->getProfileById($id);
        if (!$profile) {
            Alert::warning('Gagal', 'Profile tidak ditemukan');
            return redirect()->back();
        }
        return view('profile.tampil', compact('profile'));
    }
}
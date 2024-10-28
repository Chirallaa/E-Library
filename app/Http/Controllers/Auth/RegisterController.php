<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function checkRFID(Request $request)
    {
        $rfid = $request->input('rfid');
        $user = User::where('rfid', $rfid)->first();

        if ($user) {
            return response()->json(['success' => false, 'message' => 'RFID sudah terdaftar.']);
        }

        session(['rfid' => $rfid]);

        return response()->json(['success' => true]);
    }

    public function showBiodataForm()
    {
        // Pastikan RFID ada di sesi sebelum menampilkan form biodata
        if (!session()->has('rfid')) {
            return redirect()->route('register')->with('error', 'Silakan tempelkan kartu RFID terlebih dahulu.');
        }

        return view('auth.biodata');
    }

    public function storeBiodata(Request $request)
    {
        if (!session()->has('rfid')) {
            return redirect()->route('register')->with('error', 'Silakan tempelkan kartu RFID terlebih dahulu.');
        }

        $validator = Validator::make($request->all(), $this->getValidationRules());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $user = $this->createUser($request);
            $profile = $this->createProfile($request, $user);

            Auth::login($user);

            DB::commit();

            // Hapus RFID dari sesi setelah berhasil menyimpan data
            session()->forget('rfid');


            return redirect()->route('dashboard')->with('success', 'Registration successful!');
        } 
        
            catch (\Exception $e) {
           
                DB::rollBack();

            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    private function getValidationRules()
    {
        return array_merge($this->getUserValidationRules(), $this->getProfileValidationRules());
    }

    private function getUserValidationRules()
    {
        return [
            'name' => 'required|string|max:255',
        ];
    }

    private function getProfileValidationRules()
    {
        return [
            'kelas' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'noTelp' => 'required|string|max:255',
            'jk' => 'required|in:laki-laki,perempuan',
        ];
    }

    private function createUser(Request $request)
    {
        return User::create([
            'name' => $request->input('name'),
            'rfid' => session('rfid'), // Ambil RFID dari sesi
        ]);
    }

    private function createProfile(Request $request, User $user)
    {
        return Profile::create([
            'kelas' => $request->input('kelas'),
            'alamat' => $request->input('alamat'),
            'noTelp' => $request->input('noTelp'),
            'user_id' => $user->id,
            'jk' => $request->input('jk'),
        ]);
    }
}
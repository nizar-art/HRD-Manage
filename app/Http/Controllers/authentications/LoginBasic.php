<?php

namespace App\Http\Controllers\Authentications;

use App\Models\User;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LoginBasic extends Controller
{
  public function index()
  {
    // Tampilkan halaman login
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.authentications.auth-login-basic', ['pageConfigs' => $pageConfigs]);
  }

  public function redirect()
  {
    $parameters = [
      'client_id' => env('GOOGLE_CLIENT_ID'),
      'redirect_uri' => "http://127.0.0.1:8000/auth/google/callback", // Sesuaikan dengan yang ada di Google Cloud Console
      'response_type' => 'code',
      'scope' => 'email profile',
      'access_type' => 'offline',
      'include_granted_scopes' => 'true',
      'state' => 'state_parameter_passthrough_value',
      'prompt' => 'consent',
    ];

    $authUrl = 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query($parameters);

    logger()->info('Redirect URL:', ['url' => $authUrl]); // Log untuk debug
    return redirect($authUrl);
  }

  public function callback(Request $request)
  {
    $code = $request->input('code');

    if (!$code) {
      return redirect()->route('auth-login-cover')->withErrors(['error' => 'Kode otorisasi tidak ditemukan']);
    }

    try {
      $client = new Client();

      $response = $client->post('https://oauth2.googleapis.com/token', [
        'form_params' => [
          'code' => $code,
          'client_id' => env('GOOGLE_CLIENT_ID'),
          'client_secret' => env('GOOGLE_CLIENT_SECRET'),
          'redirect_uri' => "http://127.0.0.1:8000/auth/google/callback",
          'grant_type' => 'authorization_code',
          'access_type' => 'offline',
        ],
      ]);

      $tokenData = json_decode($response->getBody(), true);
      $accessToken = $tokenData['access_token'];

      // Mengambil data pengguna dari Google
      $googleUser = Socialite::driver('google')->stateless()->userFromToken($accessToken);

      // Periksa apakah pengguna sudah ada berdasarkan email
      $user = User::where('email', $googleUser->getEmail())->first();

      if (!$user) {
        // Jika tidak ada, cek berdasarkan Google ID
        $user = User::where('google_id', $googleUser->getId())->first();

        if (!$user) {
          // Memisahkan nama menjadi first_name dan last_name
          $fullName = $googleUser->getName();
          $nameParts = explode(' ', $fullName, 2);
          $firstName = $nameParts[0] ?? $fullName;
          $lastName = $nameParts[1] ?? '';

          $slug = Str::slug($firstName . ' ' . $lastName);
          $originalSlug = $slug;
          $count = 1;

          // Cek apakah slug sudah ada
          while (User::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
          }

          $user = User::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $googleUser->getEmail(),
            'google_id' => $googleUser->getId(),
            'slug' => $slug,
          ]);
        } else {
          // Jika Google ID cocok, perbarui email (jika perlu)
          $user->update(['email' => $googleUser->getEmail()]);
        }
      }

      // Login pengguna
      Auth::login($user);
      session()->regenerate();

      return redirect('/view/karyawan'); // Ganti dengan halaman tujuan setelah login

    } catch (\Throwable $th) {
      return redirect()->route('auth-login-cover')->withErrors(['error' => 'Terjadi kesalahan saat login', 'details' => $th->getMessage()]);
    }
  }
  public function logout(Request $request)
  {
    // Logout pengguna
    Auth::logout();

    // Hapus semua data sesi
    $request->session()->invalidate();

    // Regenerasi token sesi untuk keamanan tambahan
    $request->session()->regenerateToken();

    // Redirect ke halaman login atau halaman lain sesuai kebutuhan
    return redirect()->route('auth-login-basic')->with('success', 'Anda telah berhasil logout.');
  }
}

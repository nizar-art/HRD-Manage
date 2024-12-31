<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Detection\MobileDetect;
use Illuminate\Support\Facades\DB;
use App\Models\UserActivity; // Pastikan model ini ada
use Carbon\Carbon;

class LoginCover extends Controller
{
  public function index()
  {
    if (Auth::check()) {
      return redirect()->route('dashboard');
    }

    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.authentications.auth-login-cover', ['pageConfigs' => $pageConfigs]);
  }

  public function login(Request $request)
  {
    $request->validate([
      'email' => 'required|email',
      'password' => 'required',
    ]);

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
      $request->session()->regenerate();

      $user = Auth::user();
      $sessionId = session()->getId();
      $userAgent = $request->header('User-Agent');
      $ipAddress = $request->ip();

      // Gunakan MobileDetect untuk mendapatkan informasi perangkat
      $detect = new MobileDetect();
      $detect->setUserAgent($userAgent);

      $device = $detect->isMobile() ? ($detect->isTablet() ? 'Tablet' : 'Mobile') : 'Desktop';
      $location = $this->getLocationFromIp($ipAddress); // Dapatkan lokasi dari IP

      // Update session dengan data tambahan
      DB::table('sessions')->updateOrInsert(
        ['id' => $sessionId], // Kondisi untuk menemukan sesi berdasarkan ID
        [
          'user_id' => $user->id,
          'ip_address' => $ipAddress,
          'user_agent' => $userAgent,
          'device' => $device,
          'location' => $location,
          'payload' => session()->getHandler()->read($sessionId), // Menyimpan payload sesi
          'last_activity' => Carbon::now()->timestamp, // Simpan sebagai UNIX timestamp
        ]
      );

      // Catat aktivitas login
      UserActivity::create([
        'user_id' => $user->id,
        'activity' => 'Logged in',
        'type' => 'login',
        'description' => "Logged in from {$device}, {$location}, using {$this->getBrowser($userAgent)}",
        'activity_date' => now(),
      ]);

      return redirect()->intended('dashboard');
    }

    return back()->withErrors([
      'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');
  }

  public function logout(Request $request)
  {
    $user = Auth::user();

    // Catat aktivitas logout sebelum logout
    if ($user) {
      UserActivity::create([
        'user_id' => $user->id,
        'activity' => 'Logged out',
        'type' => 'logout',
        'description' => 'User logged out successfully.',
        'activity_date' => now(),
      ]);
    }

    Auth::logout();

    DB::table('sessions')->where('id', session()->getId())->delete();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
  }

  private function getLocationFromIp($ip)
  {
    if ($ip === '127.0.0.1' || $ip === '::1') {
      return 'Localhost';
    }
    try {
      $locationData = @json_decode(file_get_contents("http://ip-api.com/json/{$ip}"));

      if ($locationData && $locationData->status === 'success') {
        return "{$locationData->city}, {$locationData->country}";
      }
    } catch (\Exception $e) {
      // Log atau tangani kesalahan jika diperlukan
    }

    return 'Unknown Location';
  }

  private function getBrowser($userAgent)
  {
    if (strpos($userAgent, 'Chrome') !== false) return 'Chrome';
    if (strpos($userAgent, 'Firefox') !== false) return 'Firefox';
    if (strpos($userAgent, 'Safari') !== false && strpos($userAgent, 'Chrome') === false) return 'Safari';
    if (strpos($userAgent, 'Opera') !== false || strpos($userAgent, 'OPR') !== false) return 'Opera';
    if (strpos($userAgent, 'Edge') !== false) return 'Edge';
    if (strpos($userAgent, 'Trident') !== false) return 'Internet Explorer';

    return 'Unknown Browser';
  }
}

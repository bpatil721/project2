<?php

namespace App\Http\Controllers;
use PragmaRX\Google2FA\Google2FA;
use Illuminate\Http\Request;
use Auth;
use BaconQrCode\Writer;

use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;

class TwoFactorController extends Controller
{
    public function setup()
    {
        $google2fa = app('pragmarx.google2fa');

        $user = Auth::guard('user')->user();

        if ($user->google2fa_secret) {
            return redirect()->route('dashboard')->with('info', '2FA already enabled.');
        }

        $secret = $google2fa->generateSecretKey();

        $qrUrl = $google2fa->getQRCodeUrl(
            config('app.name'),
            $user->email,
            $secret
        );

        $writer = new Writer(
            new ImageRenderer(
                new RendererStyle(200),
                new SvgImageBackEnd()
            )
        );

        $qrCodeSvg = base64_encode($writer->writeString($qrUrl));

        session(['2fa_secret' => $secret]);

        return view('auth.2fa_setup', compact('qrCodeSvg', 'secret'));
    }
    public function enable(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $user = Auth::guard('user')->user();
        $secret = session('2fa_secret');
        $google2fa = app('pragmarx.google2fa');
        
        if ($google2fa->verifyKey($secret, $request->otp)) {
            $user->google2fa_secret = $secret;
            $user->two_fa_status = 1;
            $user->save();

            return redirect()->route('dashboard')->with('success', '2FA enabled!');
        }

        return back()->with('error', 'Invalid OTP, please try again.');
    }

    public function showDisableForm()
    {
        $user = Auth::guard('user')->user();

        if (!$user->google2fa_secret) {
            return redirect()->route('dashboard')->with('info', '2FA is not enabled.');
        }

        return view('auth.2fa_disable');
    }

    public function disable(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $user = Auth::guard('user')->user();

        if (!$user->google2fa_secret) {
            return redirect()->route('dashboard')->with('info', '2FA is not enabled.');
        }

        $google2fa = app('pragmarx.google2fa');

        $otpValid = $google2fa->verifyKey($user->google2fa_secret, $request->input('otp'));

        if (!$otpValid) {
            return back()->with('error', 'Invalid OTP. Please try again.');
        }

        $user->google2fa_secret = null;
        $user->two_fa_status = 0;
        $user->save();

        session()->forget('google2fa_passed');

        return redirect()->route('dashboard')->with('success', '2FA has been disabled.');
    }
    public function verify(Request $request)
    {
       return view('auth.2fa_verify');
    }
    public function postVerify(Request $request)
    {
        $request->validate([
            'one_time_password' => 'required|digits:6',
        ]);

        $user = Auth::guard('user')->user();
        if (!$user->google2fa_secret) {
            return redirect()->route('dashboard')->with('error', '2FA is not enabled.');
        }
        $google2fa = app('pragmarx.google2fa');

        if ($google2fa->verifyKey($user->google2fa_secret, $request->one_time_password)) {
            $user->two_fa_status = 1;
            $user->save();


            return redirect()->route('dashboard')->with('success', '2FA enabled!');
        }
        return back()->with('error', 'Invalid OTP, please try again.');
    }
}

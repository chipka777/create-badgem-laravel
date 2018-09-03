<?php

namespace App\Http\Controllers\API\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UserInvites;
use Illuminate\Support\Facades\Auth;
use Mail;
use Validator;

class InviteController extends Controller
{
    public function sendInvite(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
            ], 422);
        }

        if (Auth::user()->settings === null || Auth::user()->settings->invites === null || Auth::user()->settings->invites == 0) {
            return response()->json([
                'message' => 'You have no more invite codes',
            ], 422);
        }

        if ($request->email === Auth::user()->email) {
            return response()->json([
                'message' => 'You can not send an invitation to yourself',
            ], 422);
        }
       
        $code = strtoupper(str_random(40));

        Mail::send('emails.inviteDesigner',['code' => $code], function ($m) use($request) {
            $m->from('administrator@badgem.com', 'Badgem ');

            $m->to($request->email)->subject('Invite code');
        });

        if (Mail::failures()) {
            return response()->json([
                'message' => 'The invitation was not sent, the problem with sending the email',
            ], 422);
        } else {
            UserInvites::create([
                'user_id' => Auth::user()->id,
                'email' => $request->email,
                'code' => $code
            ]);

            $invites = Auth::user()->settings->invites;

            Auth::user()->settings()->update([
                'invites' => $invites - 1,
            ]);

            return response()->json([
                'status' => 1,
                'invites' => $invites - 1
            ], 201);
        }

    }
}

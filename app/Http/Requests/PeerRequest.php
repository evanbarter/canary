<?php

namespace App\Http\Requests;

use App\Peer;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;

class PeerRequest extends Request
{
    public function peer()
    {
        foreach (Auth::user()->currentAccessToken()->abilities as $token_ability) {
            list($type, $id, ) = explode(':', $token_ability);
            if ($type === 'peer') {
                return Peer::findOrFail($id);
            }
        }
        throw new AuthorizationException();
    }
}

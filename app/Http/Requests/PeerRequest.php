<?php

namespace App\Http\Requests;

use App\Peer;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;

class PeerRequest extends Request
{
    public function peer()
    {
        foreach (auth()->user()->currentAccessToken()->abilities as $token_ability) {
            list($type, $id, $ability) = explode(':', $token_ability);
            if ($type === 'peer') {
                return Peer::findOrFail($id);
            }
        }
        throw new AuthorizationException();
    }
}

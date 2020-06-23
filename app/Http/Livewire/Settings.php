<?php

namespace App\Http\Livewire;

use App\Peer;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Settings extends Component
{
    /** var bool */
    public $visible = true;

    /** @var string */
    public $tab = 'settings';

    /** @var string */
    public $passwordCurrent = '';

    /** @var string */
    public $password = '';

    /** @var string */
    public $passwordConfirmation = '';

    /** @var string */
    public $peerAddURL = '';

    protected $listeners = ['settingsSetProperty' => 'setProperty'];

    public function setProperty(string $property, $value)
    {
        switch ($property) {
            case 'visible':
                $this->visible = $value;
                break;
            case 'tab':
                $this->tab = $value;
                break;
        }
    }

    public function updatePassword()
    {
        $this->validate([
            'password' => 'required|min:8|same:passwordConfirmation',
        ]);

        $user = auth()->user();

        if (Auth::attempt(['email' => $user->email, 'password' => $this->passwordCurrent])) {
            $user->password = Hash::make($this->password);
            $user->setRememberToken(Str::random(60));
            $user->save();

            Auth::guard()->login($user);

            $this->passwordCurrent =
                $this->password =
                $this->passwordConfirmation = '';

            session()->flash('success', 'Your password has been updated.');
        } else {
            $this->addError('passwordCurrent', trans('This does not match your current password.'));
        }
    }

    public function addPeer()
    {
        $this->validate([
            'peerAddURL' => 'required|url',
        ]);

        Peer::create(['url' => $this->peerAddURL]);

        $this->peerAddURL = '';

        session()->flash('success', 'A request has been sent to become peers.');
    }

    public function render()
    {
        return view('livewire.settings');
    }
}

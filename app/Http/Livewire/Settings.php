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
    public $visible = false;

    /** @var string */
    public $tab;

    /** @var string */
    public $passwordCurrent = '';

    /** @var string */
    public $password = '';

    /** @var string */
    public $passwordConfirmation = '';

    /** @var string */
    public $peerAddURL = '';

    protected $listeners = ['settingsSetProperty' => 'setProperty'];
    protected $updatesQueryString = ['tab'];

    public function mount()
    {
        $this->tab = request()->query('tab') ?? 'settings';
    }

    public function setProperty(string $property, $value)
    {
        if (in_array($property, ['visible', 'tab'])) {
            $this->{$property} = $value;
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

        Peer::create(['url' => rtrim($this->peerAddURL, '/')]);

        $this->peerAddURL = '';

        session()->flash('success', 'A request has been sent to become peers.');
    }

    public function render()
    {
        return view('livewire.settings', [
            'peers' => Peer::all(),
        ]);
    }
}

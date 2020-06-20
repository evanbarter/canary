<?php

namespace App\Http\Livewire;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Settings extends Component
{
    /** @var string */
    public $passwordCurrent = '';

    /** @var string */
    public $password = '';

    /** @var string */
    public $passwordConfirmation = '';

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

    public function render()
    {
        return view('livewire.settings');
    }
}

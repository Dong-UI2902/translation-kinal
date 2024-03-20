<?php

namespace App\Http\Requests;

use App\Rules\AccountNotLocked;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            $this->username() => 'required',
            'password' => 'required|string',
        ];
    }

    public function username(): string
    {
        return 'account';
    }

    /**
     * @throws ValidationException
     */
    public function authenticate()
    {
        $this->ensureIsNotRateLimited();

        if (!Auth::attempt($this->credentials())) {
            RateLimiter::hit($this->throttleKey(), $this->decayMinutes() * 60);

            throw ValidationException::withMessages([
                $this->username() => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());

        if (!$this->user()->activated) {
            throw ValidationException::withMessages([
                $this->username() => __('messages.account.locked'),
            ]);
        }
    }

    /**
     * @throws ValidationException
     */
    public function ensureIsNotRateLimited()
    {

        if (!RateLimiter::tooManyAttempts($this->throttleKey(), $this->maxAttempts())) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            $this->username() => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ])->status(Response::HTTP_TOO_MANY_REQUESTS);
    }

    public function throttleKey(): string
    {
        return Str::lower($this->input('email')) . '|' . $this->ip();
    }

    protected function detectLoginField(): string
    {
        return filter_var($this->get($this->username()), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    }

    protected function credentials(): array
    {
        $field = $this->detectLoginField();

        return [
            $field => $this->get($this->username()),
            'password' => $this->get('password'),
        ];
    }

    public function maxAttempts(): int
    {
        return property_exists($this, 'maxAttempts') ? $this->maxAttempts : 5; //default = 5
    }

    public function decayMinutes(): int
    {
        return property_exists($this, 'decayMinutes') ? $this->decayMinutes : 1; //default = 1 minute
    }
}

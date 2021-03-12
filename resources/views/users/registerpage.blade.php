@if (session('message'))
   <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif
<form method="POST" action="/registeruser">
	@csrf
	<label>name</label>
	<input type="text" name="name">
	<label>email</label>
	<input type="email" name="email">
	<label for="password">{{ __('Password') }}</label>
	<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
	@error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
	<label for="password-confirm">{{ __('Confirm Password') }}</label>
	<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
	<input type="submit" name="submit">
</form>
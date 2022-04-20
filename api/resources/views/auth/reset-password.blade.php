@if (session('error'))
<div class="alert alert-success">
    {{ session('error') }}
</div>
@endif
<form method="post" action="{{ route('password.update') }}">
    @csrf

    <label for="email">Email:</label>
    <input type="text" name="email">

    <label for="password">Password:</label>
    <input type="password" name="password">

    <label for="password_confirmation">Password Confirmation:</label>
    <input type="password" name="password_confirmation">

    <input type="hidden" name="token" value="{{ $token }}">

    <button>Login</button>
</form>

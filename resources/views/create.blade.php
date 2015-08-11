
@foreach($errors->all() as $error)
<p>{{$error}}</p>
@endforeach
 
<form method="POST" action="/users">
	<p><label for="username">Usuario*: <input type="text" name="username" value="{{ Input::old('username') }}"/></label></p>
	<p><label for="password">Contraseña*:<input type="password" name="password" value="{{ Input::old('password') }}"/></label></p>
	<p><label for="password-repeat">Repita Contraseña*:<input type="password" name="password-repeat" value="{{ Input::old('password-repeat') }}"/></label></p>
	<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
	<button>Submit</button>
</form>



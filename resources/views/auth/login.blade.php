<form method="POST" action="/login">
    @csrf

    <div>
        <label for="email">Correo electrónico</label>
        <input type="email" name="email" id="email">
    </div>

    <div>
        <label for="password">Contraseña</label>
        <input type="password" name="password" id="password">
    </div>

    <button type="submit">Iniciar sesión</button>
</form>

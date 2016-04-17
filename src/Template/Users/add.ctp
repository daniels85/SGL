<form method="POST" accept-charset="utf-8" action="/Users/add">
	<div style="display:none;">
		<input type="hidden" name="_method" value="POST" />
	</div>


	<label>Nome: </label> <input type="text" name="nome" placeholder="Nome" required>
	<label>Matricula: </label> <input type="text" name="matricula" placeholder="Matricula" required>
	<label>Username: </label> <input type="text" name="username" placeholder="Username" required>
	<label>Senha: </label> <input type="password" name="password" placeholder="Senha" required>
	<label>Função: </label> 
	<select name="role">
		<option value="Professor">Professor</option>
		<option value="Bolsista">Bolsista</option>
		<option value="Suporte">Suporte</option>
	</select>

	<button type="submit">Enviar</button>
</form>
<form method="POST" action="/schools">

    @csrf

    <h3>School Info</h3>

    <input name="name" placeholder="School Name" required>
    <input name="code" placeholder="School Code" required>

    <h3>School Admin Info</h3>

    <input name="admin_name" placeholder="Admin Name" required>

    <input name="admin_email" placeholder="Admin Email" required>

    <input type="password" name="admin_password" placeholder="Password" required>

    <button type="submit">Create School</button>

</form>

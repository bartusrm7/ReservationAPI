<!DOCTYPE html>
<html lang="pl">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous" />
	<link rel="stylesheet" href="/assets/main.css">
	<title>ReservationAPI - Home page</title>
</head>

<body class="vh-100 bg-dark d-flex justify-content-center align-items-center">
	<div class="auth-form-container bg-light p-4 rounded-3">
		<h2 class="ms-1 text-center fw-bold mb-3">Sign Up</h2>
		<form action="/register" method="post">
			<div class="form-group">
				<label class="ms-1" for="userName">Name</label>
				<input type="text" class="form-control" name="userName" id="userName" placeholder="Enter name" />
			</div>
			<div class="form-group">
				<label class="ms-1" for="userEmail">Email address</label>
				<input type="email" class="form-control" name="userEmail" id="userEmail" placeholder="Enter email" />
			</div>
			<div class="form-group">
				<label class="ms-1" for="userPassword">Password</label>
				<input type="password" class="form-control" name="userPassword" id="userPassword" placeholder="Enter password" />
			</div>
			<div class="form-check">
				<label class="form-check-label" for="buisnessAccount">Buisness account</label>
				<input class="form-check-input" type="checkbox" name="buisnessAccount" id="buisnessAccount">
			</div>
			<button type="submit" class="btn btn-success w-100 mt-2 fw-bold">Sign Up</button>
		</form>
		<div class="mt-3">
			<div class="text-center">Already have an account?</div>
			<a href="/signin" class="btn btn-success w-100 fw-bold">Login</a>
		</div>
	</div>
</body>

</html>
# Lumen PHP Framework

## License

The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Implemented routes 

# Routes Free

Create User

http://localhost:8000/user/create

{
	"email": "string",
	"password": "string",
	"username": "string"
}

Login (email or username)

http://localhost:8000/user/login

{
	"login": "string",
	"password": "string"
}

Reset Password (email or username)

http://localhost:8000/user/reset-password

{
	"login": "string",
}

# Route Authenticate

http://localhost:8000/user/update-password

{
	"password": "123456"
}


# Observation

copy .env.example to .env and setting connection database and e-mail to send link of reset password

Change https://url-configured-to-reset/ (ForgotPasswordService.php:29) to your link of change password

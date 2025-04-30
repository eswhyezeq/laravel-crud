<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

Based on Assignment 1, enhance the Laravel authentication module further by adding the following features or functions or modules:

Add MFA module to the project using Laravel Fortify package. The MFA can be setup using the authenticator app or email. For this assignment use email to send the code for verification.
Make sure the password is encrypted or hashed using strong hashing either Bcrypt or Argon2 algorithm or library.
Implement rate limiting to limit only 3 failed attempts by using Laravel RateLimiter library or package.
Modify the current Laravel authentication to add a salt (use random alphanumeric generator) to the current password. You need to modify the users table (Model) to store the generated salt.

Laravel Authentication Enhancement with MFA, Rate Limiting, and Salt
This project enhances the default Laravel authentication module by adding several advanced features such as Multi-Factor Authentication (MFA), rate limiting for failed login attempts, and the addition of a salt to the user's password for extra security.

Features
Multi-Factor Authentication (MFA):

Email-based MFA: After a successful login attempt, users must verify their identity using a code sent to their registered email address.

Password Hashing with Salt:

Passwords are hashed using a secure hashing algorithm (either Bcrypt or Argon2) combined with a randomly generated salt to enhance security.

Rate Limiting:

Limit to only 3 failed login attempts within a short time period using Laravel's RateLimiter.

Sequence of Operations
1. User Registration (Sign-Up Process)
A user registers by providing their name, email, and password.

The password is combined with a randomly generated salt (16 alphanumeric characters) and then hashed using Bcrypt (or Argon2) before being stored in the database.

2. User Login (Sign-In Process)
Upon login, the user provides their email and password.

The password entered by the user is hashed with the stored salt (from the database) and compared to the stored hashed password.

If the credentials are valid, the user is logged in and directed to a page for MFA verification.

3. MFA Verification (Email-based)
After successful login, an email containing a randomly generated 6-digit code is sent to the user's registered email address.

The user enters the code on the verification page.

If the code matches, the user is granted access to the application.

4. Rate Limiting
To protect against brute force attacks, the system allows only 3 failed login attempts per minute. After 3 failed attempts, the user must wait for a minute before trying again.

Steps to Implement
1. Set Up Laravel and Fortify
Install and configure Laravel and Fortify for authentication.

Configure MFA via email in the config/fortify.php file.

Enable the RateLimiter for login attempts in FortifyServiceProvider.php.

2. Create Salt Migration
Create a migration to add a salt field to the users table.

Modify the User model to hash passwords with a salt using Hash::make() in the creating and updating event hooks.

3. Implement Email-based MFA
Implement the email-based MFA by sending a 6-digit code to the user’s email after successful login.

Store the code temporarily in the session or database for validation when the user submits it.

4. Set Up Rate Limiting for Login Attempts
In the FortifyServiceProvider.php, set up rate limiting using Laravel’s RateLimiter class, limiting users to 3 attempts per minute.

Code Validation
Password Hashing & Salt: Ensure that passwords are never stored in plaintext. The salt is combined with the password and hashed using Bcrypt or Argon2, ensuring higher security.

Rate Limiting: Verify that the login attempts are restricted to 3 per minute, and subsequent attempts will be blocked temporarily.

MFA: Check that after logging in, the user receives an email with the verification code and that entering the correct code grants access.

Upload your code to Github and clearly explain your code, sequence and validation using GitHub README.md. Submit your GitHub URL in the given text box as submission.
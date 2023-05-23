**Setting up Laravel 10 Application with PHP 8.1 in Development Environment**

**Step 1: Install Laravel**

1. Ensure that PHP 8.1 is installed on your development machine.

2. Open a terminal or command prompt and navigate to the directory where you want to create your Laravel application.

3. Run the following command to clone Laravel project using GIT:

   ```bash
   git clone https://github.com/mo-fathi/laravel-login.git
   ```

4. Once the cloning is complete, navigate to the application directory:

   ```bash
   cd laravel-login
   ```
**Step 2: Install packages**
1. Make sure you have installed composer.

2. In the root directory of the Laravel application, you'll find a file named `.env.example`. Make a copy of this file and rename it to `.env`:

   ```bash
   composer install
   ```

**Step 3: Configure Environment Variables**

1. In the root directory of the Laravel application, you'll find a file named `.env.example`. Make a copy of this file and rename it to `.env`:

   ```bash
   cp .env.example .env
   ```

2. Open the `.env` file in a text editor and configure the following variables:

   **Database Configuration:**

   ```bash
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_username
   DB_PASSWORD=your_database_password
   ```

   Replace `your_database_name`, `your_database_username`, and `your_database_password` with your actual database details.

   **Mail Configuration:**

   ```bash
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.mailtrap.io
   MAIL_PORT=2525
   MAIL_USERNAME=your_mailtrap_username
   MAIL_PASSWORD=your_mailtrap_password
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS=your_email@example.com
   MAIL_FROM_NAME="${APP_NAME}"
   ```

   Replace `your_mailtrap_username`, `your_mailtrap_password`, and `your_email@example.com` with the appropriate values. You can sign up for a free account on [Mailtrap](https://mailtrap.io/) to get the SMTP credentials.

   **Cache Configuration:**

   ```bash
   CACHE_DRIVER=file
   ```

   You can use other cache drivers like `redis` or `memcached` if desired.

**Step 4: Generate Application Key**

1. Run the following command to generate a unique application key:

   ```bash
   php artisan key:generate
   ```

   This key is used to secure user sessions and other encrypted data.

**Step 5: Run the Application**

1. Start the development server by running the following command:

   ```bash
   php artisan serve
   ```

   This will start the development server at `http://localhost:8000`.

2. Open your web browser and navigate to `http://localhost:8000` to see your Laravel application running.

# ChatSystem

A real-time chat system with **Google OAuth** and **GitHub OAuth** authentication, designed to run easily with Docker Compose.

* Redirect URIs for Github
http://localhost:8000/api/github/oauth/callback

* Redirect URIs for google https://console.cloud.google.com/
http://localhost:8000/api/google/oauth/callback

## 🚀 Features

* 🔐 Google OAuth Authentication
* 🐙 GitHub OAuth Authentication
* 💬 Chat System
* 🐳 Docker & Docker Compose Support
* 🔑 Environment-based configuration
* 🔄 OAuth callback handling

---

## 📋 Requirements

Before running the project, make sure you have:

* [Docker](https://www.docker.com/)
* Docker Compose
* Google Developer Account — for Google OAuth
* GitHub Account — for GitHub OAuth

---

## ⚙️ Environment Configuration

The backend environment file lives in **`laravel-app/.env`**. It is not committed to the
repository (your credentials must stay private). On first start, the Laravel container
automatically creates it by copying `laravel-app/.env.example` if it does not exist.

Open `laravel-app/.env` and set **your own** credentials:

### Google OAuth

```env
GOOGLE_OAUTH_CLIENT_ID=your_google_oauth_client_id
GOOGLE_OAUTH_CLIENT_SECRET=your_google_oauth_client_secret
GOOGLE_OAUTH_CALLBACK_URL="${APP_URL}/api/google/oauth/callback"
```

### GitHub OAuth

```env
GITHUB_OAUTH_CLIENT_ID=your_github_oauth_client_id
GITHUB_OAUTH_CLIENT_SECRET=your_github_oauth_client_secret
GITHUB_OAUTH_CALLBACK_URL="${APP_URL}/api/github/oauth/callback"
```

### Mail (email verification / password reset)

```env
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_gmail_app_password
```

### Application URL

```env
APP_URL=http://localhost:8000
```

> **Important:** Never commit your real OAuth Client Secret or mail password. `.env` is in `.gitignore` on purpose.

---

## 🔑 OAuth Configuration

### Google OAuth

Create OAuth credentials in the **Google Cloud Console**.

Set the authorized callback URL to:

```text
http://localhost:8000/api/google/oauth/callback
```

For production, replace `localhost` with your real domain.

### GitHub OAuth

Create an OAuth App in **GitHub Developer Settings**.

Set the authorization callback URL to:

```text
http://localhost:8000/api/github/oauth/callback
```

For production:

```text
https://your-domain.com/api/github/oauth/callback
```

---

## 🐳 Run with Docker

Clone the repository:

```bash
git clone https://github.com/Savan168/Web_2_Start_from_S2.1.git
cd Web_2_Start_from_S2.1
```

Create your backend environment file (do this before the first start so you can fill in your credentials):

```bash
cp laravel-app/.env.example laravel-app/.env
```

Open `laravel-app/.env` and replace the placeholder values with your own
Google/GitHub OAuth credentials and Gmail app password.

Then build and start the containers (the first start also installs the PHP/NPM dependencies
and the RoadRunner binary automatically):

```bash
docker compose up --build
```

Or run the containers in the background:

```bash
docker compose up --build -d
```

The application is then available at:

* Frontend: http://localhost:5173
* API: http://localhost:8000/api
* phpMyAdmin: http://localhost:9000

---

## 🔍 Check Running Containers

To see the running containers:

```bash
docker compose ps
```

View application logs:

```bash
docker compose logs -f
```

View logs for a specific service:

```bash
docker compose logs -f <service-name>
```

---

## 🛑 Stop the Application

Stop the containers:

```bash
docker compose down
```

To rebuild the application after making changes:

```bash
docker compose down
docker compose up --build -d
```

---

## 📁 Project Structure

```text
ChatSystem/
├── compose.yaml
├── README.md
├── .gitignore
│
├── laravel-app/      # Backend (Laravel + Octane + Sanctum)
│   ├── .env.example
│   └── ...
│
├── vuejs-app/        # Frontend (Vue 3 + Vite)
│   ├── .env
│   └── ...
│
├── docker/           # Dockerfiles + entrypoint scripts
├── instructions/
└── ...
```

---

## 🔐 Security Notes

Do **not** upload sensitive OAuth credentials to GitHub.

❌ Never commit:

```env
GOOGLE_OAUTH_CLIENT_SECRET=real_secret
GITHUB_OAUTH_CLIENT_SECRET=real_secret
```

✅ Use placeholders in `.env.example`:

```env
GOOGLE_OAUTH_CLIENT_ID=your_google_oauth_client_id
GOOGLE_OAUTH_CLIENT_SECRET=your_google_oauth_client_secret

GITHUB_OAUTH_CLIENT_ID=your_github_oauth_client_id
GITHUB_OAUTH_CLIENT_SECRET=your_github_oauth_client_secret
```

Keep the real credentials only in your local `.env` file or your production secret-management system.

---

## 🧪 Development

After starting Docker Compose, check the application using the configured `APP_URL`.

For example:

```text
http://localhost
```

Test the authentication flow:

1. Open the ChatSystem application.
2. Select **Login with Google** or **Login with GitHub**.
3. Complete the OAuth authentication.
4. The provider redirects back to the configured callback URL.
5. The application authenticates the user.

---

## 📝 Useful Docker Commands

| Command                     | Description                    |
| --------------------------- | ------------------------------ |
| `docker compose up`         | Start containers               |
| `docker compose up -d`      | Start containers in background |
| `docker compose up --build` | Build and start containers     |
| `docker compose down`       | Stop and remove containers     |
| `docker compose ps`         | Show container status          |
| `docker compose logs -f`    | Show live logs                 |
| `docker compose restart`    | Restart services               |
| `docker compose pull`       | Pull latest images             |

---

## 👨‍💻 Author

**Savan**

Computer Science / IT Student

---

## 📄 License

This project is for educational and development purposes.

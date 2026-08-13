# ChatSystem

A real-time chat system with **Google OAuth** and **GitHub OAuth** authentication, designed to run easily with Docker Compose.

##Redirect URIs for Github
http://localhost:8000/api/github/oauth/callback

##Redirect URIs for google https://console.cloud.google.com/
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

Create a `.env` file in the root directory of the project.

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

### Application URL

Make sure your `.env` also contains your application URL:

```env
APP_URL=http://localhost
```

> **Important:** Never commit your real OAuth Client Secret to GitHub. Keep your `.env` file in `.gitignore`.

Example `.gitignore`:

```gitignore
.env
.env.*
!.env.example
```

---

## 🔑 OAuth Configuration

### Google OAuth

Create OAuth credentials in the **Google Cloud Console**.

Set the authorized callback URL to:

```text
http://localhost/api/google/oauth/callback
```

For production, replace `localhost` with your real domain.

### GitHub OAuth

Create an OAuth App in **GitHub Developer Settings**.

Set the authorization callback URL to:

```text
http://localhost/api/github/oauth/callback
```

For production:

```text
https://your-domain.com/api/github/oauth/callback
```

---

## 🐳 Run with Docker

Clone the repository:

```bash
git clone https://github.com/YOUR_USERNAME/ChatSystem.git
cd ChatSystem
```

Create your environment file:

```bash
cp .env.example .env
```

Edit `.env` and add your OAuth credentials.

Then build and start the containers:

```bash
docker compose up --build
```

Or run the containers in the background:

```bash
docker compose up --build -d
```

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
├── .env.example
├── .gitignore
├── docker-compose.yml
├── README.md
│
├── backend/
│   └── ...
│
├── frontend/
│   └── ...
│
└── ...
```

> The exact structure may vary depending on the backend and frontend technologies used.

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

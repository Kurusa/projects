# Laravel Application with Docker

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing
purposes.

### Prerequisites

Before starting, ensure you have the following installed on your system:

- Docker
- Docker Compose

### Installation

To get the project up and running locally, follow these steps:

1. **Clone the repository:**

   ```git clone github.com/Kurusa/projects```

   ```cd projects```

2. **Start the Docker environment:**

    Use the Makefile to build and start the containers: ```make up```

    Alternatively, you can use Docker Compose directly: ```docker-compose up -d```

3. **Install dependencies:**
   ```make composer-install```

4. **Set up the database:**
   Run the migrations and seed the database:
   ```make migrate```
   ```make seed```

5. **Generate Swagger documentation:**
   ```make swagger```

6. **Access the project:**
- Open your web browser and visit `http://localhost:8080` to view the application.
- Access the backend through `http://localhost:8080/api` for API routes.
- Access Swagger documentation `http://localhost:8080/api/documentation` for API routes.

### Test User

A test user is automatically created during the database seeding process. You can use these credentials to log in via the Swagger documentation to obtain a token and test the API routes:

- **Email:** test@gmail.com
- **Password:** password

Log in through the Swagger UI to get an authentication token. Use this token in the `Authorization` header as `Bearer {token}` to authenticate your requests to the API.

### Useful Commands

- `make up`: Start the Docker containers.
- `make install`: Stop and remove containers, then build and start them.
- `make stop`: Stop all containers.
- `make migrate`: Run database migrations.
- `make seed`: Seed the database with initial data.
- `make swagger`: Generate Swagger documentation for the API.
- `make shell`: Access the app container's shell.
- `make composer-install`: Install PHP dependencies.

## Docker Services

- **app**: The Laravel application service.
- **nginx**: The web server.
- **db**: The MySQL database.

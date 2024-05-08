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

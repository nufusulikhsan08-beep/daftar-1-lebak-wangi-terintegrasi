# API Documentation

This document describes the API endpoints for the Daftar 1 Lebak Wangi application.

## Base URL

`https://api.daftar1lebakwangi.com/v1`

## Authentication

All API requests require a valid JWT token in the Authorization header:

```
Authorization: Bearer {token}
```

## Endpoints

### GET /entries

Retrieve a list of all registered entries.

Response:
```json
{
  "data": [
    {
      "id": 1,
      "name": "John Doe",
      "address": "Lebak Wangi Street",
      "created_at": "2023-09-01T10:00:00Z"
    }
  ],
  "pagination": {
    "page": 1,
    "total": 100,
    "per_page": 10
  }
}
```

### POST /entries

Create a new entry.

Request body:
```json
{
  "name": "Jane Smith",
  "address": "Another Street"
}
```

Response:
```json
{
  "id": 2,
  "name": "Jane Smith",
  "address": "Another Street",
  "created_at": "2023-09-01T11:00:00Z"
}
```

### GET /entries/{id}

Retrieve a specific entry by ID.

### PUT /entries/{id}

Update a specific entry.

### DELETE /entries/{id}

Delete a specific entry.
# Database Schema

This document describes the database schema for the Daftar 1 Lebak Wangi application.

## Tables

### entries

| Column | Type | Description |
|--------|------|-------------|
| id | INTEGER (PRIMARY KEY, AUTO_INCREMENT) | Unique identifier for each entry |
| name | VARCHAR(255) | Name of the person/entry |
| address | TEXT | Address information |
| phone | VARCHAR(20) | Phone number |
| email | VARCHAR(255) | Email address |
| created_at | TIMESTAMP | Record creation timestamp |
| updated_at | TIMESTAMP | Record update timestamp |

### users

| Column | Type | Description |
|--------|------|-------------|
| id | INTEGER (PRIMARY KEY, AUTO_INCREMENT) | Unique identifier for each user |
| username | VARCHAR(50) (UNIQUE) | User login name |
| email | VARCHAR(255) (UNIQUE) | User email address |
| password | VARCHAR(255) | Hashed password |
| role | ENUM('admin', 'user') | User role |
| created_at | TIMESTAMP | Record creation timestamp |
| updated_at | TIMESTAMP | Record update timestamp |

### migrations

| Column | Type | Description |
|--------|------|-------------|
| id | INTEGER (PRIMARY KEY, AUTO_INCREMENT) | Migration ID |
| migration | VARCHAR(255) | Migration name |
| batch | INTEGER | Batch number |
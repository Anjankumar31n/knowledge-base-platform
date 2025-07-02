-- Database: knowledge_base
CREATE DATABASE IF NOT EXISTS knowledge_base CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE knowledge_base;

-- Users Table
CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    reset_token VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Documents Table
CREATE TABLE documents (
    doc_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    author_id INT NOT NULL,
    is_public TINYINT(1) DEFAULT 0,
    last_modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES users(user_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Access Control Table
CREATE TABLE doc_access (
    access_id INT AUTO_INCREMENT PRIMARY KEY,
    doc_id INT NOT NULL,
    user_id INT NOT NULL,
    permission ENUM('view', 'edit') NOT NULL,
    FOREIGN KEY (doc_id) REFERENCES documents(doc_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Mentions Table
CREATE TABLE mentions (
    mention_id INT AUTO_INCREMENT PRIMARY KEY,
    doc_id INT NOT NULL,
    mentioned_user_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (doc_id) REFERENCES documents(doc_id) ON DELETE CASCADE,
    FOREIGN KEY (mentioned_user_id) REFERENCES users(user_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Document Versions Table
CREATE TABLE doc_versions (
    version_id INT AUTO_INCREMENT PRIMARY KEY,
    doc_id INT NOT NULL,
    content TEXT NOT NULL,
    modified_by INT NOT NULL,
    version_timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (doc_id) REFERENCES documents(doc_id) ON DELETE CASCADE,
    FOREIGN KEY (modified_by) REFERENCES users(user_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Fulltext Index
ALTER TABLE documents ADD FULLTEXT(title, content);

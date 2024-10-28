CREATE DATABASE twitter_clone;

USE twitter_clone;

-- Create follows table
CREATE TABLE follows (
    id INT AUTO_INCREMENT PRIMARY KEY,
    follower_id INT,
    followed_id INT,
    FOREIGN KEY (follower_id) REFERENCES users(id),
    FOREIGN KEY (followed_id) REFERENCES users(id)
);

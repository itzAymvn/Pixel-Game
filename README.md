# Pixel Game

A website for playing pixel game, which is a game that allows you to place 1 pixel on the board each 30 seconds which whatever color you want, other players can also place pixels on the board, and the board will be saved in the database.

# Database Structure

## Table: `Players`

```sql
CREATE TABLE `players` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `lastPlacedPixel` bigint(20) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
```

## Table: `Pixels`

```sql
CREATE TABLE `pixels` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `player_id` int(11) DEFAULT NULL,
  `color` varchar(50) NOT NULL,
  `pixelIndex` int(11) NOT NULL,
  `placed_at` bigint(20) NOT NULL
  FOREIGN KEY (`player_id`) REFERENCES `players` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
```

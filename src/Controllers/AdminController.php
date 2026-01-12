<?php

namespace App\Controllers;

use App\Databases\SQLite;

class AdminController
{

    private SQLite $sqlite;

    public function __construct()
    {
        $dbPath = __DIR__ . '/../../src/Databases/data.db';
        $this->sqlite = new SQLite($dbPath);
    }

    public function createArticle(): void
    {
        header('Content-Type: application/json');

        $body = file_get_contents('php://input');
        $data = json_decode($body, true);

        $params = [
            'title' => $data['title'],
            'created' => $data['created'],
            'cover' => $data['image'],
            'permalink' => $data['permalink'],
            'content' => $data['content'],
        ];

        $this->sqlite->create('articles', $params);

        echo json_encode(['success' => true, 'message' => 'Article created successfully']);
    }

    public function updateArticle(): void
    {
        header('Content-Type: application/json');

        $body = file_get_contents('php://input');
        $data = json_decode($body, true);

        $id = $data['id'] ?? null;
        if ($id === null || $id === '') {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Missing article id']);
            return;
        }

        $params = [
            'title' => $data['title'],
            'created' => $data['created'],
            'cover' => $data['image'],
            'permalink' => $data['permalink'],
            'content' => $data['content'],
        ];

        $this->sqlite->update('articles', $params, ['id' => $id]);

        echo json_encode(['success' => true, 'message' => 'Article updated successfully']);
    }

    public function getArticle(int $id): void
    {
        header('Content-Type: application/json');

        $result = $this->sqlite->read('articles', ['id' => $id], 1);
        if (count($result) === 0) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Article not found']);
            return;
        }

        echo json_encode(['success' => true, 'data' => $result[0]]);
    }

    public function deleteArticle(int $id): void
    {
        header('Content-Type: application/json');

        $result = $this->sqlite->delete('articles', ['id' => $id]);
        if (!$result) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Failed to delete article']);
            return;
        }

        echo json_encode(['success' => true, 'message' => 'Article deleted successfully']);
    }
}

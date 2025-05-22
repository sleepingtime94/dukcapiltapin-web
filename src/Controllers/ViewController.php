<?php

namespace App\Controllers;

use App\Databases\SQLite;

class ViewController
{
    private $sqlite;

    public function __construct()
    {
        $dbPath = __DIR__ . '/../../src/Databases/data.db';
        $this->sqlite = new SQLite($dbPath);
    }

    public function render(string $template, array $data = [], bool $include_layout = true): void
    {
        ob_start();
        extract($data);
        require __DIR__ . '/../../src/Views/' . $template . '.php';
        $content = ob_get_clean();

        if ($include_layout) {
            require __DIR__ . '/../../src/Views/layout.php';
        } else {
            echo $content;
        }
    }

    public function home(): void
    {
        $this->render('home', ['title' => 'DISDUKCAPIL TAPIN']);
    }

    public function preview(string $permalink): void
    {
        $result = $this->sqlite->read('pages', ['permalink' => $permalink]);
        $this->render(
            'preview',
            [
                'title' => strtoupper($result[0]['title']) . ' - DISDUKCAPIL TAPIN',
                'data' => $result[0]
            ]
        );
    }

    public function document(string $category): void
    {

        switch ($category) {
            case 'ppid':
                $subcategory = 'LAPORAN';
                $subtitle = 'PPID';
                $result = $this->sqlite->read('documents', ['category' => $subcategory]);
                $this->render('document', [
                    'title' => $subtitle . ' - DISDUKCAPIL TAPIN',
                    'subtitle' => $subtitle,
                    'data' => $result
                ]);
                break;

            case 'laporan-hasil-skm':
                $subcategory = 'SKM';
                $subtitle = 'Laporan Hasil SKM';
                $result = $this->sqlite->read('documents', ['category' => $subcategory]);
                $this->render('document', [
                    'title' => $subtitle . ' - DISDUKCAPIL TAPIN',
                    'subtitle' => $subtitle,
                    'data' => $result
                ]);
                break;

            case 'laporan-pengaduan':
                $subcategory = 'PENGADUAN';
                $subtitle = 'Laporan Konsultasi dan Pengaduan';
                $result = $this->sqlite->read('documents', ['category' => $subcategory]);
                $this->render('document', [
                    'title' => $subtitle . ' - DISDUKCAPIL TAPIN',
                    'subtitle' => $subtitle,
                    'data' => $result
                ]);
                break;

            default:
                $this->render('404', [
                    'title' => ' - DISDUKCAPIL TAPIN'
                ], false);
                break;
        }
    }


    public function notFound(): void
    {
        $this->render('404', ['title' => 'Halaman Tidak Ditemukan'], false);
    }
}

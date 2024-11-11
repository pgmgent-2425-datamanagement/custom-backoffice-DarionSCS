<?php
namespace App\Controllers;

use App\Models\Book;
use App\Models\Author;
use DateTime;

class DashboardController extends BaseController {

    public static function index() {
        // Fetch data for new releases and new authors
        $newReleasesData = self::getNewReleasesData();
        $newAuthorsData = self::getNewAuthorsData();

        self::loadView('/dashboard/index', [
            'title' => 'Dashboard',
            'newReleasesData' => $newReleasesData,
            'newAuthorsData' => $newAuthorsData,
        ]);
    }

    private static function getNewReleasesData() {
        $db = Book::getDb();
        $sql = "
            SELECT DATE(create_time) as date, COUNT(*) as count
            FROM books
            WHERE create_time >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
            GROUP BY DATE(create_time)
            ORDER BY date ASC
        ";
        $stmt = $db->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    private static function getNewAuthorsData() {
        $db = Author::getDb();
        $sql = "
            SELECT DATE(create_time) as date, COUNT(*) as count
            FROM authors
            WHERE create_time >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
            GROUP BY DATE(create_time)
            ORDER BY date ASC
        ";
        $stmt = $db->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}

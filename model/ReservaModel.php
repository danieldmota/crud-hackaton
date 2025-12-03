<?php
include_once __DIR__ . '/../config/database.php';

declare(strict_types=1);

class ReservaModel
{
    private static PDO $pdo;

    private ?int $id;
    private int $restaurantId;
    private DateTime $date;
    private DateTime $time;
    private int $guests;
    private ?string $specialRequests;

    public function __construct(
        int $restaurantId,
        DateTime $date,
        DateTime $time,
        int $guests,
        ?string $specialRequests = null,
        ?int $id = null
    ) {
        $this->restaurantId = $restaurantId;
        $this->date = $date;
        $this->time = $time;
        $this->guests = $guests;
        $this->specialRequests = $specialRequests;
        $this->id = $id;
    }

    public function save(): void
    {
        if ($this->id === null) {
            $sql = "INSERT INTO reservations 
                        (restaurant_id, date, time, guests, special_requests)
                    VALUES 
                        (:restaurant_id, :date, :time, :guests, :special_requests)";

            $stmt = self::$pdo->prepare($sql);

            $stmt->execute([
                ":restaurant_id"   => $this->restaurantId,
                ":date"            => $this->date->format("Y-m-d"),
                ":time"            => $this->time->format("H:i:s"),
                ":guests"          => $this->guests,
                ":special_requests"=> $this->specialRequests
            ]);

            $this->id = (int)self::$pdo->lastInsertId();
        }
    }
}

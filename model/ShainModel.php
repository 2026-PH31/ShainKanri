<?php

class ShainModel
{
    public function __construct(private PDO $pdo)
    {
    }

    public function findByMailAddress(string $mailAddress): array|false
    {
        $statement = $this->pdo->prepare(
            'SELECT shain_id, shain_mei, mail_address, password FROM shain WHERE mail_address = ?'
        );
        $statement->execute([$mailAddress]);

        return $statement->fetch();
    }

    public function create(string $shainMei, string $mailAddress, string $password): void
    {
        $statement = $this->pdo->prepare(
            'INSERT INTO shain (shain_mei, mail_address, password) VALUES (?, ?, ?)'
        );
        $statement->execute([
            $shainMei,
            $mailAddress,
            password_hash($password, PASSWORD_DEFAULT),
        ]);
    }
}
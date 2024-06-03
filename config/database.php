<?php

function getDatabaseConfig(): array
{
    return [
        "database" => [
            "test" => [
                "url" => "mysql:host=localhost:3306;dbname=db_furni",
                "username" => "root",
                "password" => "root"
            ],
            "prod" => [
                "url" => "mysql:host=localhost:3306;dbname=u341021167_kelasb",
                "username" => "u341021167_kelasb",
                "password" => "Kelasb_123"
            ]
        ]
    ];
}
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = <<<SQL
            CREATE TABLE IF NOT EXISTS `posts` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `created_at` TIMESTAMP NULL DEFAULT NULL,
            `updated_at` TIMESTAMP NULL DEFAULT NULL,
            `newsletter_id` INT NOT NULL,
            `publish_date` VARCHAR(45) NULL DEFAULT NULL,
            `content` TEXT DEFAULT NULL,
            PRIMARY KEY (`id`),
            INDEX `fkey_post_newsletter_id_idx` (`newsletter_id` ASC),
            INDEX `publish_date_idx` (`publish_date` ASC),
            CONSTRAINT `fkey_post_newsletter_id`
                FOREIGN KEY (`newsletter_id`)
                REFERENCES `newsletters` (`id`)
                ON DELETE CASCADE
                ON UPDATE NO ACTION);
        SQL;
        DB::connection()->getPdo()->exec($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post');
    }
}

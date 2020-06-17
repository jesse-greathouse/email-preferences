<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = <<<SQL
            CREATE TABLE IF NOT EXISTS `subscriptions` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `created_at` TIMESTAMP NULL DEFAULT NULL,
            `updated_at` TIMESTAMP NULL DEFAULT NULL,
            `user_id` INT NOT NULL,
            `newsletter_id` INT NOT NULL,
            PRIMARY KEY (`id`),
            UNIQUE INDEX `unique_user_newsletter_idx` (`user_id` ASC, `newsletter_id` ASC),
            INDEX `fkey_newsletter_subscription_idx` (`newsletter_id` ASC),
            INDEX `fkey_user_subscription_idx` (`user_id` ASC),
            CONSTRAINT `fkey_user_subscription`
                FOREIGN KEY (`user_id`)
                REFERENCES `users` (`id`)
                ON DELETE CASCADE
                ON UPDATE NO ACTION,
            CONSTRAINT `fkey_newsletter_subscription`
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
        Schema::dropIfExists('subscription');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Rvsitebuilder\Marketing\Models\Authorisation;

class CreateGapiAuthorisationsTable extends Migration
{
    public function up()
    {
        $table_name = config('googleapi.authorisation_table');

        if (!Schema::hasTable($table_name)) {
            Schema::create($table_name, function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedBigInteger('user_id');
                $table->timestamps();
            });
        }

        if (!Schema::hasColumn($table_name, 'user_id')) {
            Schema::table($table_name, function (Blueprint $table) {
                // The creator/owner of the authorisation.
                // We are assuming the user ID is numeric, and not a UUID.
                // TODO: get the table name from the user model, derived from config.
                $table->foreign('user_id')->references('id')->on('users');
            });
        }

        if (!Schema::hasColumn($table_name, 'name')) {
            Schema::table($table_name, function (Blueprint $table) {
                // The name of this authorisation instance, to distinguish
                // between authorisations for a laravel user.
                $table->string('name', 100)->default(Authorisation::DEFAULT_NAME);
                // Names are unique for each laravel user.
                $table->unique(['user_id', 'name']);
            });
        }

        if (!Schema::hasColumn($table_name, 'state')) {
            Schema::table($table_name, function (Blueprint $table) {
                // States:
                // + "auth" - user has been sent to Google to authorise
                // + "active" - account authorised
                // + "inactive" - account authorisation withdrawn
                $table->enum('state', ['auth', 'active', 'inactive'])->default('auth');
            });
        }

        if (!Schema::hasColumn($table_name, 'access_token')) {
            Schema::table($table_name, function (Blueprint $table) {
                // Access token.
                // We do not know the maximum length of the token, so we won't set one.
                $table->text('access_token')->nullable();
            });
        }

        if (!Schema::hasColumn($table_name, 'refresh_token')) {
            Schema::table($table_name, function (Blueprint $table) {
                // Refresh token.
                $table->string('refresh_token', 250)->nullable();
            });
        }

        if (!Schema::hasColumn($table_name, 'created_time')) {
            Schema::table($table_name, function (Blueprint $table) {
                // The local time the current access_token was created by Google.
                // We will just use an int so there are no problems spanning timezones
                // and implicit conversions when moving into and out of the database.
                $table->integer('created_time')->unsigned()->nullable();
            });
        }

        if (!Schema::hasColumn($table_name, 'expires_in')) {
            Schema::table($table_name, function (Blueprint $table) {
                // The period the access_token will last, in seconds.
                $table->integer('expires_in')->unsigned()->nullable();
            });
        }

        if (!Schema::hasColumn($table_name, 'scope')) {
            Schema::table($table_name, function (Blueprint $table) {
                // The scope of the current authorisation.
                // This will be a JSON-encoded array.
                $table->text('scope')->nullable();
            });
        }

        if (!Schema::hasColumn($table_name, 'google_user_id')) {
            Schema::table($table_name, function (Blueprint $table) {
                // The unique Google user ID, so we can recognise multiple authorisations
                // against the same user (effectively authorisation records that can be merged).
                $table->string('google_user_id', 191)->nullable()->index();
            });
        }

        if (!Schema::hasColumn($table_name, 'google_email')) {
            Schema::table($table_name, function (Blueprint $table) {
                $table->string('google_email', 250)->nullable();
            });
        }
    }

    public function down()
    {
        $table_name = config('googleapi.authorisation_table');

        //Schema::drop($table_name);
        //Schema::dropIfExists($table_name);
    }
}

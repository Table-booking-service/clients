<?php

namespace App\Domain\Clients\Models;

use App\Domain\Clients\Models\Tests\Factories\ClientsFactory;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 *
 * @property string $fio Заголовок новости
 * @property string $email Текст новости
 * @property string $phone_number Текст новости
 * @property string $password Текст новости
 *
 * @property CarbonInterface|null $created_at
 * @property CarbonInterface|null $updated_at
 */
class Clients extends Model
{
    protected $table = 'clients';

    protected $fillable = ['fio', 'email', 'phone_number', 'password'];

    public static function factory(): ClientsFactory
    {
        return ClientsFactory::new();
    }
}

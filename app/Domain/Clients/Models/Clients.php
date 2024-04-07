<?php

namespace App\Domain\Clients\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
}

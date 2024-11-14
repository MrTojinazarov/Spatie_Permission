<?php
namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\Permission\Models\Role;

class MyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    public $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function handle(): void
    {
        $ids = $this->name['permissions'];
        unset($this->name['permissions']);

        for ($i = 0; $i < 50000; $i++) {
            $roleData = array_merge($this->name, ['name' => $this->name['name'] . '_' . $i]);

            $role = Role::create($roleData);
            
            $role->permissions()->attach($ids);
        }
    }
}

<?php
use App\Models\ProgramStudi;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function an_administrator_can_login()
    {
        $role = factory(Role::class)->create(['name' => 'administrator']);
        $user = factory(User::class)->create([
            'program_studi_id' => null,
            'roles_id' => $role->where('name', 'administrator')->first()->id,
            'name' => 'Administrator',
            'username' => 'administrator',
            'password' => bcrypt('admin'),
            'remember_token' => str_random(10),
            'status' => 'admin'
        ]);
        $user->attachRole($role);

        $this->visit('/login');
        $this->type('administrator', 'username');
        $this->type('admin', 'password');
        $this->press('Login');
        $this->seePageIs('/admin');
        $this->see('Administrator');
    }

    /**
     * @test
     */
    public function a_kaprodi_can_login()
    {
        factory(Role::class)->create(['name' => 'kaprodi']);

        $programStudi = factory(ProgramStudi::class)->create(['nama' => 'DIV Kebidanan']);

        $kaprodi = factory(User::class)->create([
            'program_studi_id' => null,
            'roles_id' => Role::where('name', 'kaprodi')->first()->id,
            'username' => 'kaprodi',
            'password' => bcrypt('kaprodi'),
            'status' => 'kaprodi'
        ]);
        $kaprodi->attachRole(Role::where('name', 'kaprodi')->first());

        $this->visit('/login');
        $this->type('kaprodi', 'username');
        $this->type('kaprodi', 'password');
        $this->press('Login');
        $this->seePageIs('/kaprodi');
        $this->see($kaprodi->name);
    }

    /**
     * @test
     */
    public function a_dosen_can_login()
    {
        factory(Role::class)->create(['name' => 'dosen']);

        $programStudi = factory(ProgramStudi::class)->create(['nama' => 'DIV Kebidanan']);

        $dosen = factory(User::class)->create([
            'program_studi_id' => null,
            'roles_id' => Role::where('name', 'dosen')->first()->id,
            'username' => 'dosen',
            'password' => bcrypt('dosen'),
            'status' => 'dosen'
        ]);
        $dosen->attachRole(Role::where('name', 'dosen')->first());

        $this->visit('/login');
        $this->type('dosen', 'username');
        $this->type('dosen', 'password');
        $this->press('Login');
        $this->seePageIs('/dosen');
        $this->see($dosen->name);
    }

    /**
     * @test
     */
    public function a_mahasiswa_can_login()
    {
        factory(Role::class)->create(['name' => 'mahasiswa']);

        $programStudi = factory(ProgramStudi::class)->create(['nama' => 'DIV Kebidanan']);

        $mahasiswa = factory(User::class)->create([
            'program_studi_id' => null,
            'roles_id' => Role::where('name', 'mahasiswa')->first()->id,
            'username' => 'mahasiswa',
            'password' => bcrypt('mahasiswa'),
            'status' => 'mahasiswa'
        ]);
        $mahasiswa->attachRole(Role::where('name', 'mahasiswa')->first());

        $this->visit('/login');
        $this->type('mahasiswa', 'username');
        $this->type('mahasiswa', 'password');
        $this->press('Login');
        $this->seePageIs('/mahasiswa');
        $this->see($mahasiswa->name);
    }
}

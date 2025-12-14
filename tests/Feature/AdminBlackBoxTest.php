<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Petugas;
use App\Models\PickupTruck;
use App\Models\Team;
use App\Models\Batch;
use App\Models\TransaksiSampah;
use App\Models\KategoriSampah;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class AdminBlackBoxTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create admin user directly (same as seeder)
        $this->admin = User::create([
            'nama' => 'Admin Test',
            'email' => 'admin@test.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'no_hp' => '081200000000',
        ]);
    }

    // ==================== AUTHENTICATION TESTS ====================

    /** @test */
    public function admin_can_view_login_page()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('auth.admin-login');
    }

    /** @test */
    public function admin_can_login_with_correct_credentials()
    {
        $response = $this->post('/', [
            'email' => 'admin@test.com',
            'password' => 'password'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($this->admin, 'admin');
    }

    /** @test */
    public function admin_cannot_login_with_wrong_password()
    {
        $response = $this->post('/', [
            'email' => 'admin@test.com',
            'password' => 'wrongpassword'
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
        $this->assertGuest('admin');
    }

    /** @test */
    public function admin_cannot_login_with_nonexistent_email()
    {
        $response = $this->post('/', [
            'email' => 'nonexistent@test.com',
            'password' => 'password'
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
        $this->assertGuest('admin');
    }

    /** @test */
    public function non_admin_user_cannot_login_to_admin()
    {
        // Create a regular user
        User::create([
            'nama' => 'Regular User',
            'email' => 'user@test.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'no_hp' => '081200000001',
        ]);

        $response = $this->post('/', [
            'email' => 'user@test.com',
            'password' => 'password'
        ]);

        $response->assertStatus(401);
        $this->assertGuest('admin');
    }

    /** @test */
    public function admin_can_logout()
    {
        $response = $this->actingAs($this->admin, 'admin')
                         ->post('/logout-admin');

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.login'));
        $this->assertGuest('admin');
    }

    /** @test */
    public function guest_cannot_access_admin_dashboard()
    {
        $response = $this->get('/admin/dashboard');

        $response->assertStatus(302);
    }

    // ==================== DASHBOARD TESTS ====================

    /** @test */
    public function admin_can_view_dashboard()
    {
        $response = $this->actingAs($this->admin, 'admin')
                         ->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertViewIs('Admin.dashboard');
    }

    /** @test */
    public function dashboard_displays_statistics()
    {
        // Create test data
        User::create([
            'nama' => 'Test User',
            'email' => 'testuser@test.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'no_hp' => '081234567890',
        ]);

        $response = $this->actingAs($this->admin, 'admin')
                         ->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertViewHas('totalUsers');
        $response->assertViewHas('totalPetugas');
        $response->assertViewHas('totalTrucks');
    }

    // ==================== USER MANAGEMENT TESTS ====================

    /** @test */
    public function admin_can_view_users_list()
    {
        $response = $this->actingAs($this->admin, 'admin')
                         ->get('/admin/users');

        $response->assertStatus(200);
        $response->assertViewIs('Admin.users.index');
    }

    /** @test */
    public function admin_can_view_create_user_form()
    {
        $response = $this->actingAs($this->admin, 'admin')
                         ->get('/admin/users/create');

        $response->assertStatus(200);
        $response->assertViewIs('Admin.users.create');
    }

    /** @test */
    public function admin_can_create_new_user()
    {
        $response = $this->actingAs($this->admin, 'admin')
                         ->post('/admin/users', [
                             'nama' => 'New User',
                             'email' => 'newuser@example.com',
                             'password' => 'password123',
                             'no_hp' => '08123456789',
                         ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', [
            'nama' => 'New User',
            'email' => 'newuser@example.com',
        ]);
    }

    /** @test */
    public function admin_cannot_create_user_with_duplicate_email()
    {
        User::create([
            'nama' => 'Existing User',
            'email' => 'existing@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'no_hp' => '081234567890',
        ]);

        $response = $this->actingAs($this->admin, 'admin')
                         ->post('/admin/users', [
                             'nama' => 'Another User',
                             'email' => 'existing@example.com',
                             'password' => 'password123',
                             'no_hp' => '08123456789',
                         ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function admin_can_update_user()
    {
        $user = User::create([
            'nama' => 'Old Name',
            'email' => 'olduser@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'no_hp' => '081234567890',
            'saldo_total' => 0,
            'poin_total' => 0,
        ]);

        $response = $this->actingAs($this->admin, 'admin')
                         ->put("/admin/users/{$user->id_user}", [
                             'nama' => 'Updated Name',
                             'email' => 'olduser@example.com',
                             'no_hp' => '08987654321',
                             'saldo_total' => 0,
                             'poin_total' => 0,
                         ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('users', [
            'id_user' => $user->id_user,
            'nama' => 'Updated Name',
        ]);
    }

    /** @test */
    public function admin_can_delete_user()
    {
        $user = User::create([
            'nama' => 'To Delete',
            'email' => 'todelete@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'no_hp' => '081234567890',
        ]);

        $response = $this->actingAs($this->admin, 'admin')
                         ->delete("/admin/users/{$user->id_user}");

        $response->assertStatus(302);
        $this->assertDatabaseMissing('users', [
            'id_user' => $user->id_user,
        ]);
    }

    // ==================== PETUGAS MANAGEMENT TESTS ====================

    /** @test */
    public function admin_can_view_petugas_list()
    {
        $response = $this->actingAs($this->admin, 'admin')
                         ->get('/admin/petugas');

        $response->assertStatus(200);
        $response->assertViewIs('Admin.petugas.index');
    }

    /** @test */
    public function admin_can_create_petugas()
    {
        $response = $this->actingAs($this->admin, 'admin')
                         ->post('/admin/petugas', [
                             'nama' => 'New Petugas',
                             'email' => 'petugas@test.com',
                             'password' => 'password123',
                             'no_hp' => '08123456789',
                             'status' => 'aktif',
                         ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.petugas.index'));
        $this->assertDatabaseHas('petugas', [
            'nama' => 'New Petugas',
            'email' => 'petugas@test.com',
            'status' => 'aktif',
        ]);
    }

    /** @test */
    public function admin_can_update_petugas()
    {
        $petugas = Petugas::create([
            'nama' => 'Old Petugas',
            'email' => 'oldpetugas@test.com',
            'password' => Hash::make('password'),
            'no_hp' => '081234567890',
            'status' => 'aktif',
        ]);

        $response = $this->actingAs($this->admin, 'admin')
                         ->put("/admin/petugas/{$petugas->id_petugas}", [
                             'nama' => 'Updated Petugas',
                             'email' => 'oldpetugas@test.com',
                             'no_hp' => '08987654321',
                             'status' => 'nonaktif',
                         ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('petugas', [
            'id_petugas' => $petugas->id_petugas,
            'nama' => 'Updated Petugas',
            'status' => 'nonaktif',
        ]);
    }

    /** @test */
    public function admin_can_delete_petugas()
    {
        $petugas = Petugas::create([
            'nama' => 'To Delete Petugas',
            'email' => 'deletepetugas@test.com',
            'password' => Hash::make('password'),
            'no_hp' => '081234567890',
            'status' => 'aktif',
        ]);

        $response = $this->actingAs($this->admin, 'admin')
                         ->delete("/admin/petugas/{$petugas->id_petugas}");

        $response->assertStatus(302);
        $this->assertDatabaseMissing('petugas', [
            'id_petugas' => $petugas->id_petugas,
        ]);
    }

    // ==================== TRUCKS MANAGEMENT TESTS ====================

    /** @test */
    public function admin_can_view_trucks_list()
    {
        $response = $this->actingAs($this->admin, 'admin')
                         ->get('/admin/trucks');

        $response->assertStatus(200);
        $response->assertViewIs('Admin.trucks.index');
    }

    /** @test */
    public function admin_can_create_truck()
    {
        $response = $this->actingAs($this->admin, 'admin')
                         ->post('/admin/trucks', [
                             'nama' => 'Truck 1',
                             'plat_nomor' => 'B 1234 XYZ',
                             'kapasitas' => 1000,
                             'warehouse' => 'Warehouse A',
                             'status' => 'idle',
                         ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.trucks.index'));
        $this->assertDatabaseHas('pickup_truck', [
            'nama' => 'Truck 1',
            'plat_nomor' => 'B 1234 XYZ',
            'status' => 'idle',
        ]);
    }

    /** @test */
    public function admin_can_update_truck()
    {
        $truck = PickupTruck::create([
            'nama' => 'Old Truck',
            'plat_nomor' => 'B 9999 OLD',
            'kapasitas' => 500,
            'warehouse' => 'Old Warehouse',
            'status' => 'idle',
        ]);

        $response = $this->actingAs($this->admin, 'admin')
                         ->put("/admin/trucks/{$truck->id_truck}", [
                             'nama' => 'Updated Truck',
                             'plat_nomor' => 'B 9999 OLD',
                             'kapasitas' => 1500,
                             'warehouse' => 'New Warehouse',
                             'status' => 'maintenance',
                         ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('pickup_truck', [
            'id_truck' => $truck->id_truck,
            'nama' => 'Updated Truck',
            'status' => 'maintenance',
        ]);
    }

    /** @test */
    public function admin_can_delete_truck()
    {
        $truck = PickupTruck::create([
            'nama' => 'To Delete Truck',
            'plat_nomor' => 'B 0000 DEL',
            'kapasitas' => 500,
            'warehouse' => 'Warehouse',
            'status' => 'idle',
        ]);

        $response = $this->actingAs($this->admin, 'admin')
                         ->delete("/admin/trucks/{$truck->id_truck}");

        $response->assertStatus(302);
        $this->assertDatabaseMissing('pickup_truck', [
            'id_truck' => $truck->id_truck,
        ]);
    }

    // ==================== KATEGORI SAMPAH TESTS ====================

    /** @test */
    public function admin_can_view_kategori_list()
    {
        $response = $this->actingAs($this->admin, 'admin')
                         ->get('/admin/kategori');

        $response->assertStatus(200);
        $response->assertViewIs('Admin.kategori.index');
    }

    /** @test */
    public function admin_can_create_kategori()
    {
        $response = $this->actingAs($this->admin, 'admin')
                         ->post('/admin/kategori', [
                             'nama_kategori' => 'Plastik',
                             'harga_per_kg' => 5000,
                             'poin_per_kg' => 10,
                         ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.kategori.index'));
        $this->assertDatabaseHas('kategori_sampah', [
            'nama_kategori' => 'Plastik',
            'harga_per_kg' => 5000,
            'poin_per_kg' => 10,
        ]);
    }

    /** @test */
    public function admin_can_update_kategori()
    {
        $kategori = KategoriSampah::create([
            'nama_kategori' => 'Old Kategori',
            'harga_per_kg' => 1000,
            'poin_per_kg' => 5,
        ]);

        $response = $this->actingAs($this->admin, 'admin')
                         ->put("/admin/kategori/{$kategori->id_kategori}", [
                             'nama_kategori' => 'Updated Kategori',
                             'harga_per_kg' => 2000,
                             'poin_per_kg' => 15,
                         ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('kategori_sampah', [
            'id_kategori' => $kategori->id_kategori,
            'nama_kategori' => 'Updated Kategori',
        ]);
    }

    /** @test */
    public function admin_can_delete_kategori()
    {
        $kategori = KategoriSampah::create([
            'nama_kategori' => 'To Delete Kategori',
            'harga_per_kg' => 1000,
            'poin_per_kg' => 5,
        ]);

        $response = $this->actingAs($this->admin, 'admin')
                         ->delete("/admin/kategori/{$kategori->id_kategori}");

        $response->assertStatus(302);
        $this->assertDatabaseMissing('kategori_sampah', [
            'id_kategori' => $kategori->id_kategori,
        ]);
    }

    // ==================== TEAMS MANAGEMENT TESTS ====================

    /** @test */
    public function admin_can_view_teams_list()
    {
        $response = $this->actingAs($this->admin, 'admin')
                         ->get('/admin/teams');

        $response->assertStatus(200);
        $response->assertViewIs('Admin.team.index');
    }

    /** @test */
    public function admin_can_view_create_team_form()
    {
        $response = $this->actingAs($this->admin, 'admin')
                         ->get('/admin/teams/create');

        $response->assertStatus(200);
        $response->assertViewIs('Admin.team.create');
    }

    // ==================== BATCHES MANAGEMENT TESTS ====================

    /** @test */
    public function admin_can_view_batches_list()
    {
        $response = $this->actingAs($this->admin, 'admin')
                         ->get('/admin/batches');

        $response->assertStatus(200);
        $response->assertViewIs('Admin.batch.index');
    }

    /** @test */
    public function admin_can_view_create_batch_form()
    {
        $response = $this->actingAs($this->admin, 'admin')
                         ->get('/admin/batches/create');

        $response->assertStatus(200);
        $response->assertViewIs('Admin.batch.create');
    }

    // ==================== TRANSAKSI MANAGEMENT TESTS ====================

    /** @test */
    public function admin_can_view_transaksi_list()
    {
        $response = $this->actingAs($this->admin, 'admin')
                         ->get('/admin/transaksi');

        $response->assertStatus(200);
        $response->assertViewIs('Admin.transaksi.index');
    }

    // ==================== SEARCH FUNCTIONALITY TESTS ====================

    /** @test */
    public function admin_can_search_users()
    {
        User::create([
            'nama' => 'Searchable User',
            'email' => 'searchable@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'no_hp' => '081234567890',
        ]);

        $response = $this->actingAs($this->admin, 'admin')
                         ->get('/admin/users?search=Searchable');

        $response->assertStatus(200);
        $response->assertSee('Searchable User');
    }

    /** @test */
    public function admin_can_search_petugas()
    {
        Petugas::create([
            'nama' => 'Searchable Petugas',
            'email' => 'searchpetugas@example.com',
            'password' => Hash::make('password'),
            'no_hp' => '081234567890',
            'status' => 'aktif',
        ]);

        $response = $this->actingAs($this->admin, 'admin')
                         ->get('/admin/petugas?search=Searchable');

        $response->assertStatus(200);
        $response->assertSee('Searchable Petugas');
    }
}

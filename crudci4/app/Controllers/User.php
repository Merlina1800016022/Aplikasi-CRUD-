<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;

class User extends Controller
{

    public function __construct() {

        // Mendeklarasikan class ProductModel menggunakan $this->product
        $this->user = new UserModel();
        /* Catatan:
        Apa yang ada di dalam function construct ini nantinya bisa digunakan
        pada function di dalam class Product 
        */
    }

	public function index()
	{
        $data['user'] = $this->user->getUser();
        echo view('user/index', $data);
    }
    
    public function create()
    {
        return view('user/create');
    }

    public function store()
    {
        // Mengambil value dari form dengan method POST
        $nama = $this->request->getPost('user_nama');
        $email = $this->request->getPost('user_email');

        // Membuat array collection yang disiapkan untuk insert ke table
        $data = [
            'user_nama' => $nama,
            'user_email' => $email
        ];

        /* 
        Membuat variabel simpan yang isinya merupakan memanggil function 
        insert_product dan membawa parameter data 
        */
        $simpan = $this->user->insert_user($data);

        // Jika simpan berhasil, maka ...
        if($simpan)
        {
            // Deklarasikan session flashdata dengan tipe success
            session()->setFlashdata('success', 'Created user successfully');
            // Redirect halaman ke product
            return redirect()->to(base_url('user')); 
        }
    }

    public function edit($id)
    {
        // Memanggil function getProduct($id) dengan parameter $id di dalam ProductModel dan menampungnya di variabel array product
        $data['user'] = $this->user->getUser($id);
        // Mengirim data ke dalam view
        return view('user/edit', $data);
    }

    public function update($id)
    {
        // Mengambil value dari form dengan method POST
        $nama = $this->request->getPost('user_nama');
        $email = $this->request->getPost('user_email');

        // Membuat array collection yang disiapkan untuk insert ke table
        $data = [
            'user_nama' => $nama,
            'user_email' => $email
        ];

        /* 
        Membuat variabel ubah yang isinya merupakan memanggil function 
        update_product dan membawa parameter data beserta id
        */
        $ubah = $this->user->update_user($data, $id);
        
        // Jika berhasil melakukan ubah
        if($ubah)
        {
            // Deklarasikan session flashdata dengan tipe info
            session()->setFlashdata('info', 'Updated user successfully');
            // Redirect ke halaman product
            return redirect()->to(base_url('user')); 
        }
    }

    public function delete($id)
    {
        // Memanggil function delete_product() dengan parameter $id di dalam ProductModel dan menampungnya di variabel hapus
        $hapus = $this->user->delete_user($id);

        // Jika berhasil melakukan hapus
        if($hapus)
        {
                // Deklarasikan session flashdata dengan tipe warning
            session()->setFlashdata('warning', 'Deleted user successfully');
            // Redirect ke halaman product
            return redirect()->to(base_url('user'));
        }
    }

}

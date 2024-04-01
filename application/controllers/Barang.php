<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_login(); // Pastikan ada fungsi helper untuk mengecek status login.

        $this->load->model('Admin_model', 'admin');
        $this->load->library('form_validation');

        // Ambil role dan user ID dari session
        $this->role = $this->session->userdata('role');
        $this->userId = $this->session->userdata('login_session')['user'];
    }

    public function index()
    {
        $data['title'] = "BTTD Online";
        $data['barang'] = $this->admin->count('barang');
        $data['user'] = $this->admin->count('user');
        // Hitung total data yang belum diproses
        $data['totalDataBelumDiterima'] = $this->Admin_model->hitungDataBelumDiproses();


        // Periksa apakah pengguna adalah admin menggunakan fungsi is_admin()
        if (is_admin()) {
            $data['barang'] = $this->admin->getAllBarang(); // Admin mendapatkan semua data
        } else {
            // Pastikan hanya role 'vendor' yang bisa mengakses data mereka sendiri
            $data['barang'] = $this->admin->getBarangByUserId($this->userId); // Non-admin mendapatkan data mereka sendiri
        }

        $this->template->load('templates/dashboard', 'barang/data', $data);
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('nama_vendor', 'Nama Vedor', 'required|trim');
        $this->form_validation->set_rules('no_invoice', 'Nomor Invoice', 'required');
        $this->form_validation->set_rules('nilai_invoice', 'Nilai Invoice', 'required');
        $this->form_validation->set_rules('tgl_invoice', 'Tanggal Invoice', 'required');
        $this->form_validation->set_rules('no_spk', 'Nomor SPK', '');
        $this->form_validation->set_rules('no_lhp', 'Nomor LHP', '');
        $this->form_validation->set_rules('no_faktur_pajak', 'Nomor Faktur Pajak', '');
        $this->form_validation->set_rules('tgl_faktur_pajak', 'Tanggal Faktur Pajak', 'required');
        $this->form_validation->set_rules('keterangan_invoice', 'Keterangan Invoice', 'required');
        $this->form_validation->set_rules('status_pembayaran', 'Status Pembayaran', '');
    }

    public function add()
    {
        $this->_validasi();

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = "BTTD Online";

            // Mengenerate ID Barang
            $kode_terakhir = $this->admin->getMax('barang', 'id_vendor');
            $kode_tambah = (int)$kode_terakhir + 1; // Menambahkan satu ke angka tersebut
            $number = str_pad($kode_tambah, 5, '0', STR_PAD_LEFT); // Membuat angka menjadi lima digit dengan padding nol di depan
            $data['id_vendor'] = $number; // Menggunakan angka sebagai ID Vendor

            $this->template->load('templates/dashboard', 'barang/add', $data);
        } else {
            $input = $this->input->post(null, TRUE);

            // Menambahkan id_user dari session ke dalam array input
            $input['id_user'] = $this->session->userdata('login_session')['user'];

            // Konfigurasi upload untuk pdf_invoice
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png|pdf';
            $config['max_size'] = 2048; // 2MB
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('pdf_invoice')) {
                $file_data = $this->upload->data();
                $input['pdf_invoice'] = $file_data['file_name'];
            } else {
                $error = array('error' => $this->upload->display_errors());
                print_r($error); // Atau bisa menggunakan flashdata untuk menampilkan error
            }

            // Konfigurasi upload untuk pdf_faktur_pajak
            if ($this->upload->do_upload('pdf_faktur_pajak')) {
                $file_data = $this->upload->data();
                $input['pdf_faktur_pajak'] = $file_data['file_name'];
            } else {
                $error = array('error' => $this->upload->display_errors());
                print_r($error); // Atau bisa menggunakan flashdata untuk menampilkan error
            }

            $insert = $this->admin->insert('barang', $input);

            if ($insert) {
                set_pesan('data berhasil disimpan.');
                redirect('barang');
            } else {
                set_pesan('gagal menyimpan data.', false);
                redirect('barang/add');
            }

            // Konfigurasi upload untuk Upload_bukti_Potong 
            if ($this->upload->do_upload('bukti_potong')) {
                $file_data = $this->upload->data();
                $input['bukti_potong'] = $file_data['file_name'];
            } else {
                $error = array('error' => $this->upload->display_errors());
                print_r($error); // Atau bisa menggunakan flashdata untuk menampilkan error
            }

            $insert = $this->admin->insert('barang', $input);

            if ($insert) {
                set_pesan('data berhasil disimpan.');
                redirect('barang');
            } else {
                set_pesan('gagal menyimpan data.', false);
                redirect('barang/add');
            }
        }
    }

    public function edit($getId)
    {
        $id = encode_php_tags($getId);
        $this->_validasi();

        if ($this->form_validation->run() == false) {
            $data['title'] = "BTTD Online";

            $data['barang'] = $this->admin->get('barang', ['id_vendor' => $id]);

            $this->template->load('templates/dashboard', 'barang/edit', $data);
        } else {
            $input = $this->input->post(null, true);

            // File Upload Configuration
            $config['upload_path']   = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png|pdf'; // Add more file types as needed
            $config['max_size']      = 2048; // Specify the maximum file size in kilobytes

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('pdf_invoice')) {
                $file_data = $this->upload->data();
                $input['pdf_invoice'] = $file_data['file_name']; // Save the file name to the database
            } else {
                $error = array('error' => $this->upload->display_errors());
                print_r($error);
                // Handle the file upload error as needed
            }

            // File Upload Configuration
            $config['upload_path']   = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png|pdf'; // Add more file types as needed
            $config['max_size']      = 2048; // Specify the maximum file size in kilobytes

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('pdf_faktur_pajak')) {
                $file_data = $this->upload->data();
                $input['pdf_faktur_pajak'] = $file_data['file_name']; // Save the file name to the database
            } else {
                $error = array('error' => $this->upload->display_errors());
                print_r($error);
                // Handle the file upload error as needed
            }
            // File Upload Configuration
            $config['upload_path']   = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png|pdf'; // Add more file types as needed
            $config['max_size']      = 2048; // Specify the maximum file size in kilobytes

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('bukti_potong')) {
                $file_data = $this->upload->data();
                $input['bukti_potong'] = $file_data['file_name']; // Save the file name to the database
            } else {
                $error = array('error' => $this->upload->display_errors());
                print_r($error);
                // Handle the file upload error as needed
            }

            // Additional Fields
            $input['no_invoice'] = $this->input->post('no_invoice', true);
            $input['nilai_invoice'] = $this->input->post('nilai_invoice', true);
            $input['tgl_invoice'] = $this->input->post('tgl_invoice', true);
            $input['no_spk'] = $this->input->post('no_spk', true);
            $input['no_lhp'] = $this->input->post('no_lhp', true);
            $input['no_faktur_pajak'] = $this->input->post('no_faktur_pajak', true);
            $input['tgl_faktur_pajak'] = $this->input->post('tgl_faktur_pajak', true);
            $input['keterangan_invoice'] = $this->input->post('keterangan_invoice', true);
            $input['catatan'] = $this->input->post('catatan', true);
            if ($this->session->userdata('role') !== 'admin') {
                // Jika bukan admin, hilangkan nilai yang dikirimkan untuk kolom "Status"
                $this->input->post('status', NULL);
            }

            if ($this->session->userdata('role') !== 'admin') {
                // Jika bukan admin, hilangkan nilai yang dikirimkan untuk kolom "Tanggal Diterima"
                $this->input->post('tgl_diterima', NULL);
            }
            if ($this->session->userdata('role') !== 'status_pembayaran') {
                // Jika bukan admin, hilangkan nilai yang dikirimkan untuk kolom "Tanggal Diterima"
                $this->input->post('status_pembayaran', NULL);
            }

            $update = $this->admin->update('barang', 'id_vendor', $id, $input);

            if ($update) {
                set_pesan('data berhasil disimpan');
                redirect('barang');
            } else {
                set_pesan('gagal menyimpan data');
                redirect('barang/edit/' . $id);
            }
        }
    }
    public function delete($id)
    {

        $_id = $this->db->get_where('barang', ['id_vendor' => $id])->row();
        $query = $this->db->delete('barang', ['id_vendor' => $id]);
        if ($query) {
            unlink("uploads/" . $_id->pdf_invoice);
            unlink("uploads/" . $_id->pdf_faktur_pajak);
        }
        redirect('barang');
    }

    public function printData($id_vendor)

    {
        $data['barang'] = $this->Admin_model->getDataById($id_vendor);

        $this->load->library('pdfgenerator');
        $data['title'] = "Laporan BTTD";
        $file_pdf = $data['title'];
        $paper = 'A4';
        $orientation = "potrait";
        $html = $this->load->view('barang/print_data_view', $data, true);
        $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
    }
    public function print_all()
    {
        // Ambil data dari model
        $data['barang'] = $this->Admin_model->getAllData();

        // Load library DOMPDF
        $this->load->library('pdfgenerator');
        $data['title'] = "Laporan BTTD";
        $file_pdf = $data['title'];
        $paper = 'A4';
        $orientation = "landscape";
        $html = $this->load->view('barang/print_all', $data, true);
        $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
    }

    public function data_detail($id_vendor)
    {
        $data['title'] = "Detail Barang"; // Set judul halaman

        // Mengambil detail barang berdasarkan $id_vendor dari model
        $data['barang'] = $this->Admin_model->get_barang_by_id_vendor($id_vendor);

        // Load views dengan data yang sudah diambil
        $this->template->load('templates/dashboard', 'barang/data_detail', $data);
    }
    // Contoh penghitungan total barang di dalam controller

    public function excel()
    {
        $data['barang'] = $this->Admin_model->getAllData();

        require(APPPATH . 'PHPExcel/Classes/PHPExcel.php');
        require(APPPATH . 'PHPExcel/Classes/PHPExcel/Writer/Excel2007.php');

        $object = new PHPExcel();

        $object->getProperties()->setCreator("KAL-BTTD");
        $object->getProperties()->setLastModifiedBy("KAL-BTTD");
        $object->getProperties()->setTitle("Daftar KAL-BTTD");

        $object->setActiveSheetIndex(0);

        $object->getActiveSheet()->setCellValue('A1', 'NO');
        $object->getActiveSheet()->setCellValue('B1', 'id_vendor');
        $object->getActiveSheet()->setCellValue('C1', 'nama_vendor');
        $object->getActiveSheet()->setCellValue('D1', 'no_invoice');
        $object->getActiveSheet()->setCellValue('E1', 'nilai_invoice');
        $object->getActiveSheet()->setCellValue('F1', 'tgl_invoice');
        $object->getActiveSheet()->setCellValue('G1', 'no_spk');
        $object->getActiveSheet()->setCellValue('H1', 'no_lhp');
        $object->getActiveSheet()->setCellValue('I1', 'no_faktur_pajak');
        $object->getActiveSheet()->setCellValue('J1', 'tgl_faktur_pajak');
        $object->getActiveSheet()->setCellValue('K1', 'tgl_diterima');
        $object->getActiveSheet()->setCellValue('L1', 'keterangan_invoice');
        $object->getActiveSheet()->setCellValue('M1', 'status');
        $object->getActiveSheet()->setCellValue('N1', 'catatan');

        $baris = 2;
        $no = 1;

        foreach ($data['barang'] as $b) {
            $object->getActiveSheet()->setCellValue('A' . $baris, $no++);
            $object->getActiveSheet()->setCellValue('B' . $baris, $b['id_vendor']);
            $object->getActiveSheet()->setCellValue('C' . $baris, $b['nama_vendor']);
            $object->getActiveSheet()->setCellValue('D' . $baris, $b['no_invoice']);
            $object->getActiveSheet()->setCellValue('E' . $baris, $b['nilai_invoice']);
            $object->getActiveSheet()->setCellValue('F' . $baris, $b['tgl_invoice']);
            $object->getActiveSheet()->setCellValue('G' . $baris, $b['no_spk']);
            $object->getActiveSheet()->setCellValue('H' . $baris, $b['no_lhp']);
            $object->getActiveSheet()->setCellValue('I' . $baris, $b['no_faktur_pajak']);
            $object->getActiveSheet()->setCellValue('J' . $baris, $b['tgl_faktur_pajak']);
            $object->getActiveSheet()->setCellValue('K' . $baris, $b['tgl_diterima']);
            $object->getActiveSheet()->setCellValue('L' . $baris, $b['keterangan_invoice']);
            $object->getActiveSheet()->setCellValue('M' . $baris, $b['status']);
            $object->getActiveSheet()->setCellValue('N' . $baris, $b['catatan']);

            $baris++;
        }

        $filename = "Data_BTTD.xlsx";

        $object->getActiveSheet()->setTitle("Data BTTD");
        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
        $writer->save('php://output');

        exit;
    }
}

<template>
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-12">
        <div class="card border-0 rounded shadow">
          <div class="card-body">
            <h4>TAMBAH MAHASISWA</h4>
            <hr>
            <form @submit.prevent="store">
              <div class="form-group">
                <label for="title" class="font-weight-bold">Nama Mahasiswa</label>
                <input type="text" class="form-control" v-model="post.nama" placeholder="Masukkan Nama Mahasiswa">
                <!-- validation -->
                <div v-if="validation.nama" class="mt-2 alert alert danger">
                  {{ validation.nama[0] }}
                </div>
              </div>
              <div class="form-group">
                <label for="title" class="font-weight-bold">NIM</label>
                <input type="text" class="form-control" v-model="post.nim" placeholder="Masukkan NIM">
                <!-- validation -->
                <div v-if="validation.nim" class="mt-2 alert alert danger">
                  {{ validation.nim[0] }}
                </div>
              </div>
              <div class="form-group">
                <label for="department" class="font-weight-bold">Jurusan</label>
                <select class="form-select" v-model="post.jurusan">
                  <option value="" disabled selected>Pilih Jurusan</option>
                  <option v-for="(jurusan, index) in jurusanData" :key="index" :value="jurusan">{{ jurusan }}</option>
                </select>
                <!-- validation -->
                <div v-if="validation.jurusan" class="mt-2 alert alert danger">
                  {{ validation.jurusan[0] }}
                </div>
              </div>

              <div class="form-group">
                <label for="gender" class="font-weight-bold">Jenis Kelamin</label>
                <div class="form-check">
                  <input type="radio" class="form-check-input" id="male" value="Laki-Laki" v-model="post.jenis_kelamin" />
                  <label class="form-check-label" for="male">Laki-Laki</label>
                </div>
                <div class="form-check">
                  <input type="radio" class="form-check-input" id="female" value="Perempuan"
                    v-model="post.jenis_kelamin" />
                  <label class="form-check-label" for="female">Perempuan</label>
                </div>
                <!-- validation -->
                <div v-if="validation.jenis_kelamin" class="mt-2 alert alert danger">
                  {{ validation.jenis_kelamin[0] }}
                </div>
              </div>
              <div class="form-group">
                <label for="title" class="font-weight-bold">Alamat</label>
                <input type="textarea" class="form-control" placeholder="Masukkan Alamat" v-model="post.alamat">
                <!-- validation -->
                <div v-if="validation.alamat" class="mt-2 alert alert danger">
                  {{ validation.alamat[0] }}
                </div>
              </div>
              <button type="submit" class="btn btn-primary mt-3">SIMPAN</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template> 
<script>
import { reactive, ref } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'
import iziToast from 'izitoast';
import 'izitoast/dist/css/iziToast.min.css';
export default {
  setup() {
    //initial state siswa 
    const post = reactive({
      nama: '',
      nim: '',
      jurusan: '',
      jenis_kelamin: '',
      alamat: ''
    })

    const jurusanData = [
      'D3 Teknik Informatika',
      'D3 Farmasi D3 Unggul',
      'D3 Teknologi Hasil Pertanian',
      'D3 Agribisnis',
      'D3 Desain Komunikasi Visual',
      'D3 Bahasa Mandarin',
      'D3 Hiperkes Dan Keselamatan Kerja',
      'D4 Keselamatan Dan Kesehatan Kerja',
      'D3 Usaha Perjalanan Wisata',
      'D3 Komunikasi Terapan',
      'D3 Manajemen Administrasi',
      'D3 Perpustakaa',
      'D3 Kebidanan',
      'D3 Bahasa Inggris',
      'D3 Teknik Kimia',
      'D3 Akuntansi',
      'D3 Manajemen Pemasaran',
      'D3 Teknik Mesin',
      'D3 Teknik Sipil',
      'D3 Manajemen Perdagangan',
      'D3 Manajemen Bisnis',
      'D3 Keuangan Dan Perbanka',
      'D3 Perpajakan',
      'D4 Demografi dan Pencatatan Sipil',
      'D3 Budi Daya Ternak',
      'D3 Akuntansi PSDKU',
    ];

    //state validation
    const validation = ref([])
    //vue router 
    const router = useRouter()
    //method store 
    function store() {
      let nama = post.nama
      let nim = post.nim
      let jurusan = post.jurusan
      let jenis_kelamin = post.jenis_kelamin
      let alamat = post.alamat
      axios.post('http://localhost:8000/api/mahasiswa', {
        nama: nama,
        nim: nim,
        jurusan: jurusan,
        jenis_kelamin: jenis_kelamin,
        alamat: alamat
      }, {
        headers: {
          Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
      },
        {
          withCredentials: true,
        }).then(() => {
          //redirect ke siswa index 
          router.push({
            name: 'mahasiswa.index'
          })
          showSuccessNotification('Data Berhasil Ditambahkan')
        }).catch(error => {
          //assign state validation with error
          validation.value = error.response.data
          showErrorNotification('Data Gagal Ditambahkan')
        })
    }

    function showSuccessNotification(message) {
      iziToast.success({
        title: 'Success',
        message: message,
        position: 'topRight',
      });
    }

    // method to show error notification
    function showErrorNotification(message) {
      iziToast.error({
        title: 'Error',
        message: message,
        position: 'topRight',
      });
    }
    //return 
    return {
      post,
      validation,
      router,
      store,
      jurusanData,
      showSuccessNotification,
      showErrorNotification,
    }
  }
}
</script> 
<style> body {
   background: #e4e3e3;
 }
</style>
 
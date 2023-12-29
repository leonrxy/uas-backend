<template>
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-12">
        <div class="card border-0 rounded shadow">
          <div class="card-body">
            <div class="logout-button">
              <button @click="logoutUser" class="btn btn-danger">Logout</button>
            </div>
            <div>
              <h4>DATA MAHASISWA</h4>
            </div>
            <hr />
            <router-link :to="{ name: 'mahasiswa.create' }" class="btn btn-md btn-success mb-3" v-if="isAdmin">TAMBAH
              MAHASISWA</router-link>
            <table id="mahasiswaTable" class="table table-striped table-bordered mt-4 display">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">Nama</th>
                  <th scope="col">NIM</th>
                  <th scope="col">Jurusan</th>
                  <th scope="col" style="width: 120px;">Jenis Kelamin</th>
                  <th scope="col">Alamat</th>
                  <th scope="col" style="width: 120px;" v-if="isAdmin">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(mahasiswa, index) in posts" :key="mahasiswa.id">
                  <td>{{ index + 1 }}</td>
                  <td>{{ mahasiswa.nama }}</td>
                  <td>{{ mahasiswa.nim }}</td>
                  <td>{{ mahasiswa.jurusan }}</td>
                  <td>{{ mahasiswa.jenis_kelamin }}</td>
                  <td>{{ mahasiswa.alamat }}</td>
                  <td v-if="isAdmin">
                    <router-link :to="{ name: 'mahasiswa.edit', params: { id: mahasiswa.id } }"
                      class="btn btn-primary btn-sm">Edit</router-link>

                    <button @click="postDelete(mahasiswa.id)" class="btn btn-danger btn-sm"><i class="fa-solid fa-check-square"></i> Delete</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import axios from "axios";
import $ from "jquery"; // Impor jQuery
import { onMounted, ref, computed, nextTick } from "vue";
import { useRouter } from "vue-router";  // Import the useRouter function
import DataTable from 'datatables.net-vue3'
import 'datatables.net-bs5/css/dataTables.bootstrap5.min.css';
import 'datatables.net-bs5/js/dataTables.bootstrap5.min';
import iziToast from 'izitoast';
import 'izitoast/dist/css/iziToast.min.css';
DataTable.use(DataTable);

export default {
  setup() {
    const router = useRouter();  // Use the useRouter function to obtain the router instance

    // reactive state
    let posts = ref([]);
    let currentPage = ref(1);
    let pageSize = ref(15);
    let isAdmin = ref(false);

    // mounted
    onMounted(async () => {
      isAdmin.value = localStorage.getItem("role") === "admin";
      try {
        const response = await axios.get("http://localhost:8000/api/mahasiswa", {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`,
          },
        },
          {
            withCredentials: true,
          });

        // assign state posts with response data
        posts.value = response.data.data;
        console.log(response.data);

        await nextTick()

        // Hancurkan DataTable sebelum memperbarui
        $("#mahasiswaTable").DataTable().destroy();


        // Perbarui DataTable setelah mendapatkan data
        $("#mahasiswaTable").DataTable({
          // Konfigurasi DataTables
          responsive: true, // contoh: konfigurasi responsif
          // ...lainnya
        });
      } catch (error) {
        console.error(error.response ? error.response.data : error.message);
      }
    });



    const totalPages = computed(() => Math.ceil(posts.value.length / pageSize.value));

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

    // method delete
    function postDelete(id) {

      const isConfirmed = window.confirm('Apakah Anda yakin ingin menghapus data ini?');

      if (!isConfirmed) {
        return;
      }

      // delete data post by ID
      axios
        .delete("http://localhost:8000/api/mahasiswa/" + id, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`,
          },
        },
          {
            withCredentials: true,
          })
        .then((response) => {
          console.log(response.data);
          // splice posts
          const index = posts.value.findIndex((post) => post.id === id);
          if (~index) {
            posts.value.splice(index, 1);
            showSuccessNotification('Data berhasil dihapus.');
          }
        })
        .catch((error) => {
          console.log(error.response.data);
          showErrorNotification('Gagal menghapus data.');
        });
    }

    function logoutUser() {
      axios
        .post(
          "http://localhost:8000/api/logout",
          null,
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`,
            },
          },
          {
            withCredentials: true,
          }
        )
        .then(response => {
          console.log(response);
          console.log(localStorage.getItem("token"));
          console.error(localStorage.getItem("token"));
          if (response && response.data) {
            // Handle successful logout response
            console.log(response.data);
            localStorage.removeItem('token');
            router.push({ name: 'login' });
            showSuccessNotification('Logout berhasil.');
          } else {
            console.error('Invalid response format');
            showErrorNotification('Gagal melakukan logout.');
          }
        })
        .catch(error => {
          if (error.response && error.response.data) {
            console.error(error.response.data);
            showErrorNotification('Gagal melakukan logout.');
          } else {
            console.error('Unexpected error:', error);
            showErrorNotification('Gagal melakukan logout.');
          }
        });
    }

    // return
    return {
      posts,
      currentPage,
      totalPages,
      postDelete,
      logoutUser,
      isAdmin,
      showErrorNotification,
      showSuccessNotification,
    };
  },
};
</script>

<style>
body {
  background: #e4e3e3;
}

.logout-button {
  position: absolute;
  top: 10px;
  right: 10px;
}
</style>

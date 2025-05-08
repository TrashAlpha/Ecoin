<template>
    <div class="verifikasi-penukaran">
      <Navbar />
  
      <section class="header-section">
        <h1>Verifikasi Penukaran</h1>
        <p>Kelola penukaran yang masuk dan lakukan verifikasi sesuai dengan bukti transaksi.</p>
      </section>
  
      <section class="filter-section">
        <input type="text" placeholder="Cari berdasarkan nama pengguna..." class="search-input" />
        <select class="filter-select">
          <option value="">Semua Status</option>
          <option value="pending">Menunggu</option>
          <option value="approved">Disetujui</option>
          <option value="rejected">Ditolak</option>
        </select>
      </section>
  
      <section class="table-section">
        <table>
          <thead>
            <tr>
              <th>Nama</th>
              <th>Email</th>
              <th>Tanggal Penukaran</th>
              <th>Jenis Sampah</th>
              <th>Berat</th>
              <th>Detail</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <!-- Contoh data statis -->
            <tr>
              <td>Rizky Adam</td>
              <td>rizky@email.com</td>
              <td>06 Mei 2025</td>
              <td>Organik</td>
              <td>3 Kg</td>
              <td>
                <a href="#" class="show-detail" @click.prevent="showDetailOverlay({
                  nama: 'Rizky Adam',
                  email: 'rizky@email.com',
                  tanggal: '06 Mei 2025',
                  jenis: 'Organik',
                  berat: '3 Kg'
                })">Lihat detail</a>
              </td>
              <td><span class="status status-pending">Menunggu</span></td>
              <td>
                <button class="btn approve">✔</button>
                <button class="btn reject">✖</button>
              </td>
            </tr>
            <!-- Tambahkan lebih banyak baris sesuai data -->
          </tbody>
        </table>
      </section>

      <!-- Detail Overlay -->
      <div v-if="showDetail" class="overlay">
        <div class="overlay-card">
          <div class="overlay-header">
            <button class="close-btn" @click="closeDetail">×</button>
          </div>
          <div class="overlay-content">
            <div class="left-column">
              <img src="/public/images/ic_profile.png" alt="profile" class="profile-pic"/>
              <div class="info-group">
                <p><strong>Nama</strong><br>{{ selectedTransaction.nama }}</p>
                <p><strong>Email</strong><br>{{ selectedTransaction.email }}</p>
                <p><strong>Jenis Sampah</strong><br>{{ selectedTransaction.jenis }}</p>
                <p><strong>Berat sampah (kg)</strong><br>{{ selectedTransaction.berat }}</p>
                <p><strong>Tanggal Penukaran</strong><br>{{ selectedTransaction.tanggal }}</p>
                <p><strong>Waktu Penukaran</strong><br>{{ selectedTransaction.waktu }}</p>
                <p><strong>Lokasi Penukaran</strong><br>{{ selectedTransaction.lokasi }}</p>
              </div>
            </div>
            <div class="right-column">
              <h3 class="image-title">Image</h3>
              <div class="image-grid">
                <div class="image-box" v-for="(img, index) in selectedTransaction.buktiGambar" :key="index">
                  <img :src="img" alt="Bukti" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <Footer />
    </div>
  </template>
  
  <script>
  import Navbar from '../components/Navbar.vue'
  import Footer from '../components/Footer.vue'
  
export default {
  components: {
    Navbar,
    Footer
  },
  data() {
    return {
      showDetail: false,
      selectedTransaction: {}
    }
  },
  methods: {
    showDetailOverlay(transaction) {
      this.selectedTransaction = {
        nama: transaction.nama,
        email: transaction.email,
        jenis: transaction.jenis,
        berat: transaction.berat,
        tanggal: transaction.tanggal,
        waktu: transaction.waktu || '08:00', // contoh default
        lokasi: transaction.lokasi || 'TPS RW 01',
        buktiGambar: transaction.buktiGambar || [
          '/images/bukti1.jpg',
          '/images/bukti2.jpg',
          '/images/bukti3.jpg',
          '/images/bukti4.jpg'
        ]
      };
      this.showDetail = true;
    },
    closeDetail() {
      this.showDetail = false;
      this.selectedTransaction = {};
    }
  }
}

</script>

  <style scoped>
  .verifikasi-penukaran {
    font-family: var(--fontFamily);
    background-color: var(--backgroundWhite);
  }
  
  .header-section {
    text-align: center;
    margin-bottom: 24px;
    padding: 20px 32px;
    background-color: var(--primaryGreen);
  }
  .header-section h1 {
    color: var(--backgroundWhite);
    font-size: 24px;
    font-weight: var(--fontWeightBold);
  }
  .header-section p {
    color: var(--backgroundWhite);
    margin-top: 8px;
  }
  
  .filter-section {
    display: flex;
    justify-content: space-between;
    margin-bottom: 16px;
    flex-wrap: wrap;
    gap: 12px;
    padding: 0 32px;
  }
  
  .search-input {
    padding: 10px;
    flex: 1;
    min-width: 200px;
    background-color: var(--textField);
    border: none;
  }
  
  .filter-select {
    padding: 10px;
    background-color: var(--textField);
    border: none;
  }
  
  .table-section {
    overflow-x: auto;
    padding: 0 32px;
  }
  
  table {
    width: 100%;
    border-collapse: collapse;
    background-color: white;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
  }
  
  th, td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
  }
  
  th {
    background-color: var(--primaryGreen);
    color: white;
    font-weight: 600;
  }

  .show-detail {
    color: blue;
    text-decoration: underline;
    cursor: pointer;
  }
  
  .bukti-img {
    width: 60px;
    height: auto;
    border-radius: 4px;
  }
  
  .status {
    padding: 6px 12px;
    border-radius: 20px;
    font-weight: bold;
    font-size: 12px;
  }
  .status-pending {
    background-color: orange;
    color: white;
  }
  .status-approved {
    background-color: green;
    color: white;
  }
  .status-rejected {
    background-color: red;
    color: white;
  }
  
  .btn {
    border: none;
    cursor: pointer;
    padding: 6px 10px;
    margin: 0 2px;
    font-size: 16px;
    border-radius: 4px;
  }
  .btn.approve {
    background-color: #27ae60;
    color: white;
  }
  .btn.reject {
    background-color: #c0392b;
    color: white;
  }
  
  .btn:hover {
    opacity: 0.85;
  }

  /* Detail Overlay Styles */
    .overlay {
    position: fixed;
    inset: 0;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 999;
  }

  .overlay-card {
    background: #f4f1f5;
    width: 90%;
    max-width: 900px;
    border-radius: 12px;
    position: relative;
  }

  .overlay-header {
    background-color: var(--accentGreen1);
    padding: 8px 16px;
    display: flex;
    justify-content: flex-start;
    align-items: center;
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
  }

  .close-btn {
    background: none;
    border: none;
    font-size: 24px;
    color: var(--textBlack);
    cursor: pointer;
  }

  .overlay-content {
    display: flex;
    gap: 32px;
    flex-wrap: wrap;
    padding: 12px;
  }

  .left-column {
    flex: 1;
    min-width: 250px;
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .profile-pic {
    width: 80px;
    height: 80px;
    margin-bottom: 16px;
  }

  .info-group {
    text-align: center;
  }

  .info-group p {
    margin: 12px 0;
  }

  .right-column {
    flex: 2;
    min-width: 300px;
  }

  .image-title {
    font-weight: var(--fontWeightBold);
    color: var(--textGrey);
    font-size: var(--fontSizeLarge);
    text-align: center;
    margin-bottom: 12px;
  }

  .image-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
  }

  .image-box {
    background-color: #eefaf9;
    border-radius: 8px;
    height: 120px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
  }

  .image-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
  }

  </style>
  
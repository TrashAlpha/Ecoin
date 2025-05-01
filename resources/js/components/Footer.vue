<template>
    <footer class="footer">
      <div class="footer-container">
        <div class="footer-section brand">
          <img src="/public/images/logoheader.png" alt="Ecoin Logo" class="logo" />
          <p class="tagline">Jadikan lingkungan lebih bersih dengan cara<br />mengolah sampah kembali</p>
        </div>
  
        <div class="footer-section">
          <h3>Informasi</h3>
          <ul>
            <li>Artikel</li>
            <li>Kegiatan</li>
            <li>Penukaran</li>
            <li>Produk</li>
          </ul>
        </div>
  
        <div class="footer-section">
          <h3>Tambahan</h3>
          <ul>
            <li>Keamanan</li>
            <li>Pengaturan</li>
            <li>Syarat</li>
            <li>Term & Condition</li>
          </ul>
        </div>
  
        <div class="footer-section">
          <h3>Get In Touch</h3>
          <p>Informasi Lebih Lengkap tentang ECOIN dapat menghubungi</p>
          <div class="contact-item">
            <img src="/public/images/ic_mapmarker.png" alt="Alamat" class="icon" />
            <span>Alamat</span>
          </div>
          <div class="contact-item">
            <img src="/public/images/ic_telephone.png" alt="Nomor" class="icon" />
            <span>Nomor</span>
          </div>
        </div>
      </div>
  
      <div class="copyright">
        <hr />
        <p>© 2025 Ecoin. All right reserved</p>
      </div>
    </footer>
</template>
  
<script>
import { theme } from '../config/theme';

export default {
name: 'Footer',
};
</script>

<style scoped>
    .footer {
        background-color: var(--backgroundWhite);
        padding: 40px 60px 20px;
        font-family: var(--fontFamily);
        font-size: var(--fontSizeSmall);
    }

    .footer-container {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 40px;
    }

    .footer-section {
        flex: 1;
        min-width: 200px;
    }

    .footer-section h3 {
        font-size: var(--fontSizeNormal);
        font-weight: var(--fontWeightBold);
        color: var(--primaryGreen);
        margin-bottom: 12px;
    }

    .footer-section ul {
        list-style: none;
        padding: 0;
    }

    .footer-section li {
        margin: 6px 0;
        color: var(--textBlack);
    }

    .footer-section p {
        color: var(--textBlack);
        margin: 6px 0;
    }

    .logo {
        margin-bottom: 10px;
        align-items: start;
    }

    .tagline {
        margin-top: 10px;
        padding-left: 10px;
        color: var(--textBlack);
        font-weight: var(--fontWeightMedium);
    }

    .contact-item {
        display: flex;
        align-items: center;
        margin: 6px 0;
    }

    .contact-item .icon {
        width: 14px;
        height: 14px;
        margin-right: 8px;
    }

    hr {
        margin: 30px 0 10px;
        border: 0.5px solid #ccc;
    }

    .copyright {
        text-align: center;
        color: #999;
        font-size: 12px;
    }
</style>  
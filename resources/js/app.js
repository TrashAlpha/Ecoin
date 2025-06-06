import './bootstrap';
import { createApp } from 'vue';

import Login from './pages/Login.vue';
import Register from './pages/Register.vue';
import Beranda from './pages/Beranda.vue';
import Jelajah from './pages/Jelajah.vue';
import Tentang from './pages/Tentang.vue';
import Profil from './pages/Profil.vue';
import PenukaranStep1 from './pages/penukaranstep1.vue';
import PenukaranStep2 from './pages/PenukaranStep2.vue';
import PenukaranStep3 from './pages/PenukaranStep3.vue';
import PenukaranStep3_2 from './pages/PenukaranStep3_2.vue';
import PenukaranKoin from './pages/PenukaranKoin.vue';
import ManajemenUser from './pages/ManajemenUser.vue';
import DaftarTransaksi from './pages/DaftarTransaksi.vue';
import VerifikasiPenukaran from './pages/VerifikasiPenukaran.vue';
import ManajemenVoucher from './pages/ManajemenVoucher.vue';
import Artikel from './pages/Artikel.vue';

const el = document.getElementById('app');

if (el) {
  const page = el.dataset.page;
  let component = null;
  // console.log(page) // apakah bisa jika pake parameter?, karena di cek di console jika menggunakan parameter tdk menampilkan apa2

  switch (page) {
    case 'login':
      component = Login;
      break;
    case 'register':
      component = Register;
      break;
    case 'beranda':
      component = Beranda;
      break;
    case 'penukaran-step-1':
      component = PenukaranStep1;
      break;
    case 'penukaran-step-2':
      component = PenukaranStep2;
      break;
    case 'penukaran-step-3':
      component = PenukaranStep3;
      break;
    case 'penukaran-step-3-2':
      component = PenukaranStep3_2;
      break;
    case 'penukaran-koin':
      component = PenukaranKoin;
      break;
    case 'jelajah':
        component = Jelajah;
        break;
    case 'tentang':
      component = Tentang;
      break;
    case 'manajemen-user':
        component = ManajemenUser;
        break;
    case 'manajemen-voucher':
        component = ManajemenVoucher;
        break;
    case 'profil':
        component = Profil;
        break;
    case 'daftartransaksi':
        component = DaftarTransaksi;
        break;
    case 'verifikasi-penukaran':
        component = VerifikasiPenukaran;
        break;
    case 'artikel':
        component = Artikel;
        break;
    default:
        console.error('Unknown page component:', page);
        break;
  }

  if (component) {
    createApp(component).mount('#app');
    console.log(`Mounted ${page} component`);
  }
}

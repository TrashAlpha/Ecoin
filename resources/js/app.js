import './bootstrap';
import { createApp } from 'vue';

import PenukaranStep2 from './pages/PenukaranStep2.vue';
import PenukaranStep3_2 from './pages/PenukaranStep3_2.vue';

const el = document.getElementById('app');

if (el) {
  const page = el.dataset.page;
  let component = null;

  switch (page) {
    // case 'beranda':

    //   break;
    // case 'penukaran-step-1':

    //   break;
    case 'penukaran-step-2':
      component = PenukaranStep2;
      break;
    // case 'penukaran-step-3':

    //   break;
    case 'penukaran-step-3-2':
        component = PenukaranStep3_2;
        break;

    //   break;
    // case 'jelajah':

    //   break;
    // case 'tentang':

    //   break;
    // case 'profile':

    //   break;
    // case 'riwayat-recycle':

    //   break;
    default:
      console.error('Unknown page component:', page);
      break;
  }

  if (component) {
    createApp(component).mount('#app');
    console.log(`Mounted ${page} component`);
  }
}

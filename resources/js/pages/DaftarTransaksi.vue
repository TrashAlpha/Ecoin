<template>
    <div class="daftartransaksi">
        <div class="container-card">
            <div class="header">
                <button class="back-button" @click="goBack">
                    <img
                        src="/public/images/back.png"
                        alt="Back"
                        class="icon"
                    />
                </button>

                <h1 class="title">Daftar Transaksi</h1>
            </div>

            <div
                class="list-card"
                v-for="(item, index) in transaksi"
                :key="index"
            >
                <div><strong>Tanggal</strong><br />{{ item.tanggal }}</div>
                <div>
                    <strong>Jenis Transaksi</strong><br />{{ item.jenis }}
                </div>
                <div><strong>Koin</strong><br />{{ item.koin }}</div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "daftartransaksi",
    data() {
        return {
            transaksi: [
                {
                    tanggal: "10 Maret 2025",
                    jenis: "Penukaran Voucher",
                    koin: "-50",
                },
                {
                    tanggal: "17 Maret 2025",
                    jenis: "Penukaran Sampah",
                    koin: "+35",
                },
                {
                    tanggal: "30 Maret 2025",
                    jenis: "Penukaran Sampah",
                    koin: "+60",
                },
            ],
        };
    },
    methods: {
        goBack() {
            window.location.href = '/profil';
        }
    }
};

</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=DM+Sans:wght@700&display=swap");

.daftartransaksi {
    background-color: #075e54;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: stretch;
    padding: 20px;
    font-family: "Poppins", sans-serif;
}

.container-card {
    background-color: #fff;
    border-radius: 12px;
    padding: 24px;
    width: 100%;
    max-width: 600px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    min-height: calc(100vh - 40px);
    display: flex;
    flex-direction: column;
}

.header {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
}

.back-button .icon {
    width: 45px;
    height: 45px;
    cursor: pointer;
}

.title {
    flex: 1;
    text-align: center;
    font-size: 40px;
    font-family: "DM Sans", sans-serif;
    font-weight: 700;
    color: #6b6b6b;
    margin: 0;
}

/* Card transaksi */
.list-card {
    background-color: #f5ffff;
    border-radius: 8px;
    padding: 16px;
    margin-bottom: 12px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
    display: flex;
    justify-content: space-between;
    font-family: "Poppins", sans-serif;
}

/* Label (Tanggal, Jenis Transaksi, Koin) */
.list-card > div > strong {
    display: block;
    font-size: 20px;
    font-weight: 600;
    color: #006662;
}

/* Nilai (13 Maret 2025, dsb) */
.list-card > div {
    font-size: 16px;
    font-weight: 400;
    color: #006662;
}
</style>

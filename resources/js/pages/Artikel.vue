<script setup>
import Navbar from '../components/Navbar.vue';
import Footer from '../components/Footer.vue';
import { onMounted, ref } from 'vue';

const artikel = ref({});
const userAnswers = ref({});

function fetchArtikel() {
    const path = window.location.pathname;
    const id = path.split('/').pop();

    fetch(`https://ecoin-hosted.vercel.app/api/artikel/${id}`)
        .then((res) => res.json())
        .then((data) => {
            artikel.value = data.data;
        })
        .catch((err) => {
            console.error('Gagal ambil detail artikel:', err);
        });
}

async function submitQuiz() {
    const path = window.location.pathname;
    const artikelId = path.split('/').pop();

    const payload = {
        answer: userAnswers.value
    };

    try {
        const response = await fetch(`https://ecoin-hosted.vercel.app/api/artikel/${artikelId}/submit-quiz`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Authorization": `Bearer ${localStorage.getItem('token')}`
            },
            body: JSON.stringify(payload),
        });
        const data = await response.json();
        if (data.success) {
            alert(data.message);
            window.location.reload(true);
        } else {
            alert(data.message);
            window.location.reload(true);
        }
    } catch (err) {
        alert('Gagal submit quiz!');
        console.error(err);
        window.location.reload(true);
    }
}

onMounted(() => {
    fetchArtikel();
});
</script>

<template>
    <Navbar />
    <div class="artikel" v-if="artikel.judul">
        <nav class="breadcrumb">
            <a href="/">Beranda</a> /
            <a href="/jelajah">Jelajah</a> /
            <span>{{ artikel.judul }}</span>
        </nav>
        <div class="container">
            <h1>{{ artikel.judul }}</h1>
            <p class="info">Tim ecoin - Ecoin</p>
            <img :src="artikel.gambar_url" alt="gambar artikel">
            <p class="desc">{{ artikel.konten }}</p><br>
            <p>Genre: <span class="status status-active">{{ artikel.kategori }}</span></p>
            <br>
            <p>Selesaikan quiz di bawah untuk mendapatkan koinnya!</p>
        </div>
        <div class="quiz-container">
            <h1>Quiz</h1>
            <form action="" method="post" v-for="q in artikel.quiz" :key="q.id">
                <br><hr>
                <p class="pertanyaan">{{ q.pertanyaan }}</p>
                <div class="opsi-jawaban">
                    <div class="jawaban" v-for="(jawaban, key) in q.pilihan_jawaban" :key="key">
                        <input
                        :id="`jawaban-${q.id}-${key}`"
                        type="radio"
                        :name="`opsi-jawaban-${q.id}`"
                        :value="key"
                        v-model="userAnswers[q.id]"/>
                        <label :for="`jawaban-${q.id}-${key}`">{{ key }}. {{ jawaban }}</label>
                    </div>
                </div>
            </form>
            <button type="submit" class="btn" id="submit" @click="submitQuiz">Submit</button>
        </div>
    </div>
    <Footer />
</template>

<style scoped>
.artikel {
    font-family: var(--fontFamily);
    max-width: 800px;
    margin: 20px auto;
    padding: 0 15px;
}

.breadcrumb {
    font-size: var(--fontSizeSmall);
    margin-top: 10px;
    margin-bottom: 15px;
    color: #666;
}

.breadcrumb a {
    text-decoration: none;
    color: var(--primaryGreen);
}

.breadcrumb a:hover {
    text-decoration: underline;
}

.container{
    background-color: var(--backgroundWhite);
}

.info{
    text-align: center;
    margin-bottom: 5px;

}

.artikel h1 {
    font-weight: var(--fontWeightBold);
    font-size: var(--fontSizeHeading);
    color: var(--primaryGreen);
    margin-bottom: 8px;
    margin-top: 10px;
    text-align: center;
}

.artikel img {
    max-width: 100%;
    height: auto;
    margin: 15px 0;
    border-radius: 8px;
}

.desc {
    text-align: justify;
    font-size: var(--fontSizeNormal);
}

.status {
    padding: 6px 12px;
    border-radius: 20px;
    font-weight: bold;
    font-size: 12px;
}

.status-active {
    background-color: var(--primaryGreen);
    color: white;
}

.quiz-container{
    margin-top: 20px;
    background-color: var(--accentGreen2);
    border-width: 2px;
    border-color: var(--primaryGreen);
    border-radius: 8px;
    padding: 15px;
    text-align: center;
}

.pertanyaan {
    font-weight: var(--fontWeightMedium);
    font-size: var(--fontSizeMedium);
    margin: 20px 0;
}

.opsi-jawaban {
    display: flex;
    flex-direction: column;
    gap: 0.7em;
}

.jawaban {
    text-align: start;
    display: flex;
    align-items: center;
}

.jawaban input[type="radio"] {
    accent-color: var(--primaryGreen);
    margin-right: 0.7em;
    width: 1.1em;
    height: 1.1em;
}
.jawaban label {
    cursor: pointer;
    font-size: 1em;
    color: #222;
    transition: color 0.2s;
}
.jawaban input[type="radio"]:checked + label {
    color: var(--primaryGreen);
    font-weight: 500;
}

.btn{
    display: inline-block;
    text-align: center;
    text-decoration: none; /* hilangkan underline */
    margin-top: 10px;
    padding: 8px 20px;
    background-color: var(--primaryGreen);
    color: var(--backgroundWhite);
    border: 2px solid transparent;
    font-weight: 600;
    cursor: pointer;
    border-radius: 4px;
}

.btn:hover{
    border: 2px solid var(--primaryGreen);
    background-color: var(--accentGreen2);
    color: var(--primaryGreen);
    transition-duration: 0.3s;
}

@media (max-width: 600px) {
  .quiz-container {
    padding: 1em;
  }
  .quiz-form {
    padding-bottom: 1em;
  }
}
</style>
